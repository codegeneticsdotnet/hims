<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Pharmacy extends General{
	private $limit = 10;

	function __construct(){
		parent::__construct();
		$this->load->model("app/pharmacy_model");
		$this->load->model("app/Drug_name_model");
		$this->load->model("general_model");
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}
	
	public function index(){
		$this->pharmacy();	
	}
	public function itemtagging(){
		$data = $this->Drug_name_model->getAll();
		$this->load->view('app/pharmacy/itemtagging',$this->data);	
	}

	public function inventoryin(){
		$this->load->view('app/pharmacy/inventoryin',$this->data);	
	}
	
	public function pharmacy(){
		$this->session->set_userdata(array(
			'tab'			=>		'',
			'module'		=>		'',
			'subtab'		=>		'',
			'submodule'	=>		''));
		   // user restriction function
		   $this->session->set_userdata('page_name','receipt_lists');
		   $page_id = $this->general_model->getPageID();
		   $userRole = $this->general_model->getUserLoggedIn($this->session->userdata('username'));
		   //if(General::has_rights_to_access($page_id->page_id,$userRole->user_role) == FALSE){
			//	   redirect(base_url().'access_denied');
		   //}
		   // end of user restriction function		 	
		$this->load->view('app/pharmacy/index',$this->data);	
	}

	//for item table list
	public function tableitems(){
		//pass value to session
		$this->session->set_userdata("search_item",$this->input->post('catitem'));	
		$this->data['items'] = $this->pharmacy_model->getItems($this->limit);
		$this->data['tabletoload'] = "tableitems";
		$this->load->view('app/pharmacy/viewtables',$this->data);	
	}

	//for category table list
	public function tablecategory(){
		//pass value to session
		$this->session->set_userdata("search_category",$this->input->post('catsearch'));	
		$this->data['categories'] = $this->pharmacy_model->getCategory($this->limit);
		$this->data['tabletoload'] = "tablecategory";
		$this->load->view('app/pharmacy/viewtables',$this->data);	
	}

	//for category table list
	public function tableunit(){
		//pass value to session
		$this->session->set_userdata("search_unit",$this->input->post('unitsearch'));	
		$this->data['units'] = $this->pharmacy_model->getUnit($this->limit);
		$this->data['tabletoload'] = "tableunit";
		$this->load->view('app/pharmacy/viewtables',$this->data);	
	}

	// save category
	public function savecategory(){
		$this->form_validation->set_rules("cCategory","Category Name","trim|xss_clean|required");	
		$this->form_validation->set_rules("cDescription","Category Description","trim|xss_clean|required");	
		$data = (object)[];
		$data->status = "";
		$data->message = "";
		if($this->form_validation->run()){
			//save the data
			$added = $this->pharmacy_model->saveCategory();
			if($added){
				$data->status = "SUCCESS";
			}else{
				$data->status = "ERROR";
			}
		}else{
			$validate = "";
			$data->status = "NOTVALID";
			if(form_error('cCategory')){
				$validate .= "<br /> * Category Name";
			}
			if(form_error('cDescription')){
				$validate .= "<br /> * Category Description";
			}
			$data->message = $validate;
		}	
		echo json_encode($data);
	}

	// save unit
	public function saveunit(){
		$this->form_validation->set_rules("cUnit","Unit Name","trim|xss_clean|required");	
		$this->form_validation->set_rules("cUnitDescription","Unit Description","trim|xss_clean|required");	
		$data = (object)[];
		$data->status = "";
		$data->message = "";
		if($this->form_validation->run()){
			//TODO: Check for Duplicate
			//save the data
			$added = $this->pharmacy_model->saveUnit();
			if($added){
				$data->status = "SUCCESS";
			}else{
				$data->status = "ERROR";
			}
		}else{
			$validate = "";
			$data->status = "NOTVALID";
			if(form_error('cUnit')){
				$validate .= "<br /> * Unit Name";
			}
			if(form_error('cUnitDescription')){
				$validate .= "<br /> * Unit Description";
			}
			$data->message = $validate;
		}	
		echo json_encode($data);
	}

	//for category ajax
	public function fillcategory(){
		//pass value to session
		$this->session->set_userdata("search_category",$this->input->post('search'));	
		$this->data['items'] = $this->pharmacy_model->getCategory($this->limit);
		$response = array();
		foreach ($this->data['items'] as $item){
			$value = $item->param_id;
			$value .= "$$" . $item->categoryname;
			$value .= "$$" . $item->categorydesc;
			$item = $item->categoryname; 
			$response[] = array("id"=>$value,"name"=>$item);
		}
		echo json_encode($response);
	}
	//for category ajax
	public function fillunit(){
		//pass value to session
		$this->session->set_userdata("search_unit",$this->input->post('search'));	
		$this->data['items'] = $this->pharmacy_model->getUnit($this->limit);
		$response = array();
		foreach ($this->data['items'] as $item){
			$value = $item->param_id;
			$value .= "$$" . $item->unitname;
			$value .= "$$" . $item->unitdesc;
			$item = $item->unitname; 
			$response[] = array("id"=>$value,"name"=>$item);
		}
		echo json_encode($response);
	}


	//for category ajax
	public function filllcategory(){
		//pass value to session
		$this->session->set_userdata("search_category",$this->input->post('search'));	
		$this->data['items'] = $this->pharmacy_model->getCategory($this->limit);
		$results = array();
		foreach ($this->data['items'] as $item){
			$value = $item->param_id;
			$value .= "$$" . $item->categoryname;
			$value .= "$$" . $item->categorydesc;
			$item = $item->categoryname; 
			$results[] = array("id"=>$value,"text"=>$item);
		}
		$response = array(
			"results" => $results,
			"pagination" => array("more" => false)
		);
		header('Content-Type: application/json');
		echo json_encode($response);
	}
	public function filllunit(){
		//pass value to session
		$this->session->set_userdata("search_unit",$this->input->post('search'));	
		$this->data['items'] = $this->pharmacy_model->getUnit($this->limit);
		$results = array();
		foreach ($this->data['items'] as $item){
			$value = $item->param_id;
			$value .= "$$" . $item->unitname;
			$value .= "$$" . $item->unitdesc;
			$item = $item->unitname; 
			$results[] = array("id"=>$value,"text"=>$item);
		}
		$response = array(
			"results" => $results,
			"pagination" => array("more" => false)
		);
		header('Content-Type: application/json');
		echo json_encode($response);
	}
}