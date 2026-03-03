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
            'tab'           =>      'pharmacy',
            'module'        =>      'reports',
            'subtab'        =>      '',
            'submodule'     =>      ''));
        
        $this->data['cFrom'] = $this->input->post('cFrom') ? $this->input->post('cFrom') : date('Y-m-d');
        $this->data['cTo'] = $this->input->post('cTo') ? $this->input->post('cTo') : date('Y-m-d');
        
        if($this->input->post('btnView')){
            $this->data['sales'] = $this->pharmacy_reports_model->getDailySales($this->data['cFrom'], $this->data['cTo']);
            $this->data['returns'] = $this->pharmacy_reports_model->getDailyReturns($this->data['cFrom'], $this->data['cTo']);
        }
        
        $this->load->view('app/pharmacy/reports/daily_sales', $this->data);
    }
    
    public function sales_return(){
        $this->session->set_userdata(array(
            'tab'           =>      'pharmacy',
            'module'        =>      'reports',
            'subtab'        =>      '',
            'submodule'     =>      ''));
        
        $this->data['cFrom'] = $this->input->post('cFrom') ? $this->input->post('cFrom') : date('Y-m-d');
        $this->data['cTo'] = $this->input->post('cTo') ? $this->input->post('cTo') : date('Y-m-d');
        
        if($this->input->post('btnView')){
            $this->data['returns'] = $this->pharmacy_reports_model->getDailyReturns($this->data['cFrom'], $this->data['cTo']);
            if($this->input->post('print')){
                $this->load->view('app/pharmacy/reports/print_sales_return', $this->data);
                return;
            }
        }
        
        $this->load->view('app/pharmacy/reports/sales_return', $this->data);
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
