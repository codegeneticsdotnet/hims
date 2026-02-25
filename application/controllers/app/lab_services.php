<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Lab_services extends General {

    public function __construct(){
        parent::__construct();
        $this->load->model("app/lab_services_model");
        $this->load->model("app/patient_model");
        $this->load->model("app/billing_model"); // For some helpers if needed
        if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
        General::variable();
    }

    public function index(){
        $this->dashboard();
    }

    public function dashboard(){
        // Get recent requests (last 10)
        $this->data['recent_requests'] = $this->lab_services_model->getRequests(10, 0);
        $this->load->view('app/lab_services/dashboard', $this->data);
    }

    public function service_request(){
        // Default Date Range: Yesterday to Today
        if(!$this->input->post('cFrom')){
            $this->data['cFrom'] = date('Y-m-d', strtotime("-1 days"));
            $this->data['cTo'] = date('Y-m-d');
        } else {
            $this->data['cFrom'] = $this->input->post('cFrom');
            $this->data['cTo'] = $this->input->post('cTo');
        }

        if($this->input->post('btn_submit') == 'excel'){
            $this->export_excel($this->data['cFrom'], $this->data['cTo']);
        } elseif($this->input->post('btn_submit') == 'print'){
            $this->print_report_list($this->data['cFrom'], $this->data['cTo']);
        } else {
            // If report generation requested from service request index (though typically this is list view)
            // But user asked to use filter request in service_request index for generating reports.
            // Wait, if 'excel' is clicked, we export.
            // If 'filter' is clicked, we just show the list.
            
            // Re-using getRequests for list view
            $this->data['requests'] = $this->lab_services_model->getRequests();
            $this->load->view('app/lab_services/service_request_index', $this->data);
        }
    }
    
    public function print_report_list($from, $to){
        $this->data['cFrom'] = $from;
        $this->data['cTo'] = $to;
        $this->data['reports'] = $this->lab_services_model->getReports($from, $to);
        $this->load->view('app/lab_services/print_report_list', $this->data);
    }

    public function add_request(){
        $this->data['request_no'] = ''; // Will be populated via AJAX based on category selection
        $this->load->view('app/lab_services/add_request', $this->data);
    }

    public function get_next_id(){
        $type = $this->input->post('type'); // Laboratory, X-ray, Ultrasound
        echo $this->lab_services_model->generateRequestNo($type);
    }

    public function save_request(){
        // Validation
        $this->form_validation->set_rules('patient_no', 'Patient', 'required');
        $this->form_validation->set_rules('service_category', 'Category', 'required');
        $this->form_validation->set_rules('particular_id[]', 'Service', 'required');

        if($this->form_validation->run() == FALSE){
            $this->add_request();
        } else {
            // Generate ID again to be safe
            $type = $this->input->post('service_category');
            $next_id = $this->lab_services_model->generateRequestNo($type);
            
            // Override the posted request_no with the fresh one
            $_POST['request_no'] = $next_id;

            if($this->lab_services_model->saveRequest()){
                // Get the last inserted ID (assuming saveRequest returns or we can fetch it)
                // Actually saveRequest returns db->trans_status()
                // We need to get the ID. The model doesn't return ID.
                // Let's modify logic slightly: we'll redirect to view page which has print button
                // Or we can modify model to return ID.
                
                // For now, let's find the ID we just saved using the request_no
                $req_id = $this->lab_services_model->getRequestIdByNo($next_id);
                
                $this->session->set_flashdata('message', "<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Request successfully saved! <a href='".base_url()."app/lab_services/print_request/".$req_id."' target='_blank' class='btn btn-primary btn-sm'>Print Request</a></div>");
                redirect(base_url().'app/lab_services/view/'.$req_id);
            } else {
                $this->session->set_flashdata('message', "<div class='alert alert-danger alert-dismissable'><i class='fa fa-ban'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Error saving request.</div>");
                redirect(base_url().'app/lab_services/add_request');
            }
        }
    }
    
    public function print_request($id){
        $this->data['header'] = $this->lab_services_model->getRequestHeader($id);
        $this->data['details'] = $this->lab_services_model->getRequestDetails($id);
        $this->load->view('app/lab_services/print_request', $this->data);
    }

    public function patient_autocomplete(){
        $search = $this->input->post('search');
        $this->db->like('lastname', $search);
        $this->db->or_like('firstname', $search);
        $this->db->or_like('patient_no', $search);
        $this->db->limit(10);
        $query = $this->db->get('patient_personal_info');
        
        $result = array();
        foreach($query->result() as $row){
            $result[] = array(
                'id' => $row->patient_no,
                'value' => $row->patient_no . ' - ' . $row->firstname . ' ' . $row->lastname,
                'label' => $row->patient_no . ' - ' . $row->firstname . ' ' . $row->lastname
            );
        }
        echo json_encode($result);
    }

    public function service_autocomplete(){
        $search = $this->input->post('search');
        $category = $this->input->post('category'); // Laboratory, X-ray, Ultrasound
        
        // Map Category to Group Name in DB
        // Assuming the DB group names match "Laboratory", "X-ray", "Ultrasound"
        // If they are different, we need a mapping.
        // Based on analysis, "Laboratory" is likely "Laboratory".
        
        $this->db->select('A.particular_id, A.particular_name, A.charge_amount, B.group_name');
        $this->db->from('bill_particular A');
        $this->db->join('bill_group_name B', 'B.group_id = A.group_id');
        $this->db->like('A.particular_name', $search);
        
        if($category){
             $this->db->like('B.group_name', $category);
        }

        $this->db->where('A.InActive', 0);
        $this->db->limit(20);
        $query = $this->db->get();

        $result = array();
        foreach($query->result() as $row){
            $result[] = array(
                'id' => $row->particular_id,
                'value' => $row->particular_name,
                'price' => $row->charge_amount,
                'label' => $row->particular_name . ' (' . $row->group_name . ')'
            );
        }
        echo json_encode($result);
    }

    public function change_status(){
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        $this->lab_services_model->updateStatus($id, $status);
        echo "Status updated";
    }

    public function view($id){
        $this->data['header'] = $this->lab_services_model->getRequestHeader($id);
        $this->data['details'] = $this->lab_services_model->getRequestDetails($id);
        $this->load->view('app/lab_services/view', $this->data);
    }
    
    public function bulk_update_status(){
        $detail_ids = $this->input->post('detail_id');
        $status = $this->input->post('bulk_status');
        $remarks = $this->input->post('bulk_remarks');
        
        if(is_array($detail_ids)){
            foreach($detail_ids as $id){
                $this->lab_services_model->updateDetailStatus($id, $status, $remarks);
            }
        }
        
        $this->session->set_flashdata('message', "<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Status successfully updated!</div>");
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function toggle_detail_status(){
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        $this->lab_services_model->updateDetailStatus($id, $status, NULL);
        echo "Status updated";
    }

    public function reports(){
        // This page is now redundant as reports are generated from service_request
        redirect(base_url().'app/lab_services/service_request');
    }

    public function export_excel($from, $to){
        $reports = $this->lab_services_model->getReports($from, $to);
        
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=Laboratory_Reports_".$from."_to_".$to.".xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo "Date Request\tRequest No\tPatient Name\tType\tStatus\tTotal Amount\n";
        
        foreach($reports as $row){
            // Set amount to 0 if status is Cancelled
            $amount = ($row->status == 'Cancelled') ? 0 : $row->total_amount;
            
            echo date('M d, Y', strtotime($row->request_date)) . "\t" .
                 $row->request_no . "\t" .
                 $row->patient_name . "\t" .
                 $row->request_type . "\t" .
                 $row->status . "\t" .
                 number_format($amount, 2) . "\n";
        }
    }
}
