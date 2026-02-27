<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Reset_system extends General{

	public function __construct(){
		parent::__construct();
		$this->load->model("app/general_model");
        if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();	
	}
	
	public function index(){
        $this->session->set_userdata(array(
             'tab'			=>		'admin',
             'module'		=>		'reset_system',
             'subtab'		=>		'',
             'submodule'	=>		''));
        
        $this->data['message'] = $this->session->flashdata('message');
        $this->load->view('app/reset_system/index', $this->data);
    }
    
    public function process(){
        $password = $this->input->post('password');
        
        // Check if password matches the logged in user's password (or a specific admin password)
        // Here we verify against the logged in user's password
        $user_id = $this->session->userdata('user_id');
        $user = $this->db->get_where('users', array('user_id' => $user_id))->row();
        
        if($user && $user->password == md5($password)){ // Assuming MD5 as per legacy systems, or simple check
            $this->do_reset();
            $this->session->set_flashdata('message', '<div class="alert alert-success">System Reset Successfully! All records have been cleared.</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Invalid Password! Reset aborted.</div>');
        }
        
        redirect(base_url().'app/reset_system');
    }
    
    private function do_reset(){
        // Disable foreign key checks to avoid constraint errors during truncation
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        
        // 1. Patient Records
        $this->db->truncate('patient_personal_info');
        $this->db->truncate('patient_attachment');
        $this->db->truncate('patient_details_iop');
        
        // 2. Clinical Records (OPD/IPD)
        $this->db->truncate('iop_diagnosis');
        $this->db->truncate('iop_medication'); // Also used in Pharmacy IPD Billing
        $this->db->truncate('iop_laboratory');
        $this->db->truncate('iop_vital_parameters');
        $this->db->truncate('iop_nurse_notes');
        $this->db->truncate('iop_progress_note');
        $this->db->truncate('iop_complaints');
        $this->db->truncate('iop_intake_record');
        $this->db->truncate('iop_output_record');
        $this->db->truncate('iop_discharge_summary');
        $this->db->truncate('iop_bed_side_procedure');
        $this->db->truncate('iop_operation_theater');
        $this->db->truncate('iop_room_transfer');
        
        // 3. Laboratory Services
        $this->db->truncate('lab_service_request');
        $this->db->truncate('lab_service_request_details');
        
        // 4. Pharmacy Sales
        $this->db->truncate('pharmacy_sales');
        $this->db->truncate('pharmacy_sales_details');
        
        // 5. Billing & Receipts
        $this->db->truncate('iop_billing');
        $this->db->truncate('iop_billing_details');
        $this->db->truncate('declaredor');
        $this->db->truncate('iop_receipt');
        $this->db->truncate('doctors_fee');
        
        // 6. Reset System Increments (system_option)
        // Reset specific keys to 0
        $keys_to_reset = array(
            'patient_no', 
            'opd_no', 
            'ipd_no', 
            'pharmacy_invoice_no', 
            'receipt_no'
        );
        
        $this->db->where_in('cCode', $keys_to_reset);
        $this->db->update('system_option', array('cValue' => 0));
        
        // Re-enable foreign key checks
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');
    }
}
