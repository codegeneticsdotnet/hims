<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Company_branch extends General{

    private $limit = 10;

    public function __construct(){
        parent::__construct();
        $this->load->model("app/company_branch_model");
        if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
        General::variable();
    }
    
    public function index(){
        $this->session->set_userdata(array(
            'tab'           =>      'administrator',
            'module'        =>      'company_branch',
            'subtab'        =>      '',
            'submodule'     =>      ''));
            
        $this->data['branches'] = $this->company_branch_model->getAll();
        $this->load->view('app/company_branch/index', $this->data);
    }
    
    public function add(){
        $this->load->view('app/company_branch/add', $this->data);
    }
    
    public function save(){
        $this->form_validation->set_rules("company_name", "Company Name", "trim|required|xss_clean");
        $this->form_validation->set_rules("branch_code", "Branch Code", "trim|required|xss_clean|max_length[1]|alpha");
        
        if($this->form_validation->run()){
            if($this->company_branch_model->save()){
                $this->session->set_flashdata('message','<div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i> Branch Saved Successfully!</div>');
                redirect(base_url().'app/company_branch',$this->data);
            }else{
                $this->session->set_flashdata('message','<div class="alert alert-danger alert-dismissable"><i class="fa fa-ban"></i> Failed to save branch.</div>');
                redirect(base_url().'app/company_branch/add',$this->data);
            }
        }else{
            $this->add();
        }
    }
    
    public function edit($id){
        $this->data['branch'] = $this->company_branch_model->getBranch($id);
        $this->load->view('app/company_branch/edit', $this->data);
    }
    
    public function edit_save(){
        $this->form_validation->set_rules("company_name", "Company Name", "trim|required|xss_clean");
        $this->form_validation->set_rules("branch_code", "Branch Code", "trim|required|xss_clean|max_length[1]|alpha");
        
        if($this->form_validation->run()){
            if($this->company_branch_model->edit_save()){
                $this->session->set_flashdata('message','<div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i> Branch Updated Successfully!</div>');
                redirect(base_url().'app/company_branch',$this->data);
            }else{
                $this->session->set_flashdata('message','<div class="alert alert-danger alert-dismissable"><i class="fa fa-ban"></i> Failed to update branch.</div>');
                redirect(base_url().'app/company_branch/edit/'.$this->input->post('id'),$this->data);
            }
        }else{
            $this->edit($this->input->post('id'));
        }
    }
    
    public function delete($id){
        $this->company_branch_model->delete($id);
        $this->session->set_flashdata('message','<div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i> Branch Deleted Successfully!</div>');
        redirect(base_url().'app/company_branch',$this->data);
    }
}