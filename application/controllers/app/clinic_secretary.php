<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Clinic_secretary extends General{

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
		$this->session->set_userdata('page_name','clinic_secretary_dashboard');
		$this->session->set_userdata('page_id','clinic_secretary_dashboard');
		
		// Get OPD Queue (Pending Patients)
		// We can filter by the logged-in user's department if needed, 
        // but for now let's show the general queue or the one from opd_model
		$this->data['queue'] = $this->opd_model->get_opd_queue();
		
		$this->load->view('app/clinic_secretary/dashboard', $this->data);
	}
}
?>