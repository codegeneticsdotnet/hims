<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Billing_new extends General {
    
    public function __construct(){
        parent::__construct();
        $this->load->model("app/billing_new_model");
        $this->load->model("app/patient_model");
        $this->load->model("General_model");
        if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');
        }
        General::variable();
        
        $this->data['userInfo'] = $this->General_model->getUserLoggedIn($this->session->userdata('username'));
        $this->data['companyInfo'] = $this->General_model->companyInfo();
    }
    
    public function index(){
        $this->session->set_userdata("page_name", "billing_dashboard");
        $this->session->set_userdata("page_id", "billing_dashboard");
        
        $this->data['opd_patients'] = $this->billing_new_model->getPendingOPD();
        $this->data['ipd_patients'] = $this->billing_new_model->getAdmittedIPD();
        
        $this->load->view('app/billing_new/dashboard', $this->data);
    }
    
    public function opd(){
        $this->session->set_userdata("page_name", "billing_opd");
        $this->session->set_userdata("page_id", "billing_opd");
        
        $this->data['patients'] = $this->billing_new_model->getPendingOPD();
        $this->load->view('app/billing_new/opd_list', $this->data);
    }
    
    public function ipd(){
        $this->session->set_userdata("page_name", "billing_ipd");
        $this->session->set_userdata("page_id", "billing_ipd");
        
        $this->data['patients'] = $this->billing_new_model->getAdmittedIPD();
        $this->load->view('app/billing_new/ipd_list', $this->data);
    }
    
    public function create_bill($patient_no, $type = 'OPD', $io_id = null){
        $patient_no = urldecode($patient_no); // Decode URL encoded patient number
        
        $this->data['patient'] = $this->billing_new_model->getPatientInfo($patient_no);
        
        if(!$this->data['patient']){
            // Try to find patient by IO_ID if patient_no lookup fails (e.g. if patient_no passed is actually IO_ID or something else)
            // Or just redirect with error
            // For now, let's just proceed, the view will show "Patient not found"
        }
        
        $this->data['type'] = $type;
        $this->data['io_id'] = $io_id;
        $this->data['invoice_no'] = $this->billing_new_model->getInvoiceNo($type);
        
        // Fetch Charges
        // Logic for fetching charges based on Type
        // If OPD, fetch Pending Lab, Pending Meds (if linked to OPD visit)
        // If IPD, fetch All Unbilled
        
        // For simplicity in this demo, we'll fetch based on patient_no and status
        $this->data['items'] = $this->billing_new_model->getBillableItems($patient_no, $io_id);
        
        $this->load->view('app/billing_new/create_bill', $this->data);
    }
    
    public function get_items($category){
        $this->load->model("app/billing_new_model");
        // Decode category just in case
        $category = urldecode($category);
        $items = $this->billing_new_model->getItemsByCategory($category);
        echo json_encode($items);
    }
    
    public function save_bill(){
        $patient_no = $this->input->post('patient_no');
        $io_id = $this->input->post('io_id');
        $invoice_no = $this->input->post('invoice_no');
        $total_amount = $this->input->post('total_amount');
        $discount = $this->input->post('discount');
        $net_total = $this->input->post('net_total');
        
        // Header Data
        $header = array(
            'invoice_no' => $invoice_no,
            'patient_no' => $patient_no,
            'iop_id' => $io_id,
            'dDate' => date('Y-m-d H:i:s'),
            'sub_total' => $total_amount, // Gross Total
            'discount' => $discount,
            'total_amount' => $net_total, // Net Total
            'reason_discount' => $this->input->post('remarks'), 
            'payment_type' => 'Cash', // Default to Cash for now
            'InActive' => 0
        );
        
        // Details Data
        $items = $this->input->post('item_id');
        $qtys = $this->input->post('qty');
        $prices = $this->input->post('price');
        $details = array();
        
        if($items){
            foreach($items as $key => $id){
                $details[] = array(
                    'invoice_no' => $invoice_no,
                    'bill_name' => $this->input->post('item_name')[$key],
                    'qty' => $qtys[$key],
                    'rate' => $prices[$key],
                    'amount' => $qtys[$key] * $prices[$key],
                    'InActive' => 0
                );
            }
        }
        
        $this->billing_new_model->saveBill($header, $details);
        $this->billing_new_model->updateInvoiceNo($invoice_no);
        
        // redirect(base_url().'app/billing_new/view_receipt/'.$invoice_no);
        // Redirect to Dashboard as requested or view receipt
        // User said: "once processed, it will be marked as paid in dashboard" and "Payment Successful! ... but it is still marked as pending"
        // The issue is likely the update logic in saveBill for "Pending" items.
        
        redirect(base_url().'app/billing_new');
    }
    
    public function view_receipt($invoice_no){
        // Reuse existing receipt logic or create new
        // For now, simple success page
        echo "<h1>Payment Successful!</h1><p>Invoice #$invoice_no</p><a href='".base_url()."app/billing_new'>Back to Dashboard</a>";
    }
}