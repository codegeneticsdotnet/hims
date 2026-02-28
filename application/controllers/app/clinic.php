<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Clinic extends General{

	public function __construct(){
		parent::__construct();
		$this->load->model("app/opd_model");
		$this->load->model("app/patient_model");
		$this->load->model("general_model");
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();	
	}
	
	public function index(){
		$this->dashboard();
	}
	
	public function dashboard(){
		$this->session->set_userdata('page_name','clinic_dashboard');
		$this->session->set_userdata('page_id','clinic_dashboard');
		
        $doctor_id = $this->input->cookie('clinic_doctor_id');
        
		$this->data['opd_counts'] = $this->opd_model->get_opd_counts();
		$this->data['queue'] = $this->opd_model->get_opd_queue($doctor_id);
        $this->data['doctorList'] = $this->general_model->doctorList();
        $this->data['selected_doctor'] = $doctor_id;
		
		$this->load->view('app/clinic/dashboard', $this->data);
	}
    
    public function set_doctor(){
        $doctor_id = $this->input->post('doctor_id');
        $cookie = array(
            'name'   => 'clinic_doctor_id',
            'value'  => $doctor_id,
            'expire' => '86500',
            'path'   => '/'
        );
        $this->input->set_cookie($cookie);
        redirect(base_url().'app/clinic/dashboard');
    }
    
    public function call_patient($io_id){
        // Logic to mark patient as called
        // For now, redirect back
        redirect(base_url().'app/clinic/dashboard');
    }
}
?>