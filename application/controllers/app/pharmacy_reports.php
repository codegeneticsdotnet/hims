<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Pharmacy_reports extends General{

	private $limit = 10;

	public function __construct(){
		parent::__construct();
		$this->load->model("app/pharmacy_reports_model");
        $this->load->model("app/pharmacy_model");
		$this->load->model("app/general_model");
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();	
	}
	
	public function index(){
        $this->daily_sales();
    }

    public function daily_sales(){
        $this->session->set_userdata(array(
             'tab'			=>		'pharmacy',
             'module'		=>		'daily_sales_report',
             'subtab'		=>		'',
             'submodule'	=>		''));
        
        $this->data['reports_title'] = "Daily Pharmacy Sales Report";
        
        if($this->input->post('btnView')){
            $cFrom = $this->input->post('cFrom');
            $cTo = $this->input->post('cTo');
            $this->data['sales'] = $this->pharmacy_reports_model->getDailySales($cFrom, $cTo);
            $this->data['cFrom'] = $cFrom;
            $this->data['cTo'] = $cTo;
            $this->load->view('app/pharmacy/reports/daily_sales', $this->data);
        }else{
            $this->load->view('app/pharmacy/reports/daily_sales', $this->data);
        }
    }
    
    public function daily_dispense(){
        $this->session->set_userdata(array(
             'tab'			=>		'pharmacy',
             'module'		=>		'daily_dispense_report',
             'subtab'		=>		'',
             'submodule'	=>		''));
        
        $this->data['reports_title'] = "Daily Pharmacy Dispense Report";
        
        if($this->input->post('btnView')){
            $cFrom = $this->input->post('cFrom');
            $cTo = $this->input->post('cTo');
            $this->data['dispense'] = $this->pharmacy_reports_model->getDailyDispense($cFrom, $cTo);
            $this->data['cFrom'] = $cFrom;
            $this->data['cTo'] = $cTo;
            $this->load->view('app/pharmacy/reports/daily_dispense', $this->data);
        }else{
            $this->load->view('app/pharmacy/reports/daily_dispense', $this->data);
        }
    }
}
