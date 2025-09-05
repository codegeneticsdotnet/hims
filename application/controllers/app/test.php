<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Test extends General{
	private $limit = 10;

	function __construct(){
		parent::__construct();
		$this->load->model("general_model");
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}
	public function index(){
		$this->test();	
	}
	public function test(){
		$this->load->view('app/test/index',$this->data);	
	}
}