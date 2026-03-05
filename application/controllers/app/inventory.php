<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Inventory extends General{

    private $limit = 10;

    public function __construct(){
        parent::__construct();
        $this->load->model("app/inventory_model");
        $this->load->model("app/pharmacy_model"); // Reuse item search if needed
        $this->load->model("general_model");
        if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
        General::variable();
    }
    
    public function index(){
        // Redirect to Pharmacy Dashboard as it's now the main inventory hub
        redirect(base_url().'app/pharmacy');
    }
    
    // --- Stock Transfer ---
    
    public function stock_transfer(){
        $this->session->set_userdata(array(
            'tab'           =>      'inventory',
            'module'        =>      'stock_transfer',
            'subtab'        =>      '',
            'submodule'     =>      ''));
            
        $this->data['transfers'] = $this->inventory_model->get_stock_transfers(100);
        $this->load->view('app/inventory/stock_transfer/index', $this->data);
    }
    
    public function add_stock_transfer(){
        $branch_code = $this->session->userdata('branch_code') ? $this->session->userdata('branch_code') : 'A';
        $this->data['transfer_no'] = $this->inventory_model->get_transfer_no($branch_code);
        $this->load->view('app/inventory/stock_transfer/add', $this->data);
    }
    
    public function save_stock_transfer(){
        $this->form_validation->set_rules("transfer_no", "Transfer No", "required");
        
        if($this->form_validation->run()){
            $header = array(
                'transfer_no' => $this->input->post('transfer_no'),
                'from_branch' => $this->input->post('from_branch'),
                'to_branch' => $this->input->post('to_branch'),
                'transfer_date' => date('Y-m-d'),
                'status' => 'Pending',
                'remarks' => $this->input->post('remarks'),
                'created_by' => $this->session->userdata('user_id'),
                'created_date' => date('Y-m-d H:i:s'),
                'InActive' => 0
            );
            
            $details = array();
            $items = $this->input->post('item_id');
            $qtys = $this->input->post('qty');
            
            if($items){
                foreach($items as $key => $id){
                    if($qtys[$key] > 0){
                        $details[] = array(
                            'item_id' => $id,
                            'qty_requested' => $qtys[$key],
                            'qty_issued' => 0, 
                            'InActive' => 0
                        );
                    }
                }
            }
            
            if($this->inventory_model->save_transfer($header, $details)){
                $this->session->set_flashdata('message','<div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i> Stock Transfer Saved Successfully!</div>');
                redirect('app/inventory/stock_transfer');
            } else {
                $this->session->set_flashdata('message','<div class="alert alert-danger alert-dismissable"><i class="fa fa-ban"></i> Failed to save transfer.</div>');
                redirect('app/inventory/stock_transfer');
            }
        } else {
            $this->add_stock_transfer();
        }
    }
    
    public function view_transfer($id){
        $this->data['header'] = $this->inventory_model->get_transfer($id);
        $this->data['details'] = $this->inventory_model->get_transfer_details($id);
        $this->load->view('app/inventory/stock_transfer/view', $this->data);
    }
    
    public function receive_transfer($id){
        $received_by = $this->session->userdata('user_id');
        if($this->inventory_model->receive_transfer($id, $received_by)){
             $this->session->set_flashdata('message','<div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i> Stock Transfer Received Successfully!</div>');
        } else {
             $this->session->set_flashdata('message','<div class="alert alert-danger alert-dismissable"><i class="fa fa-ban"></i> Failed to receive transfer.</div>');
        }
        redirect('app/inventory/view_transfer/'.$id);
    }
    
    public function cancel_transfer($id){
        if($this->inventory_model->cancel_transfer($id)){
             $this->session->set_flashdata('message','<div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i> Stock Transfer Cancelled Successfully!</div>');
        } else {
             $this->session->set_flashdata('message','<div class="alert alert-danger alert-dismissable"><i class="fa fa-ban"></i> Failed to cancel transfer.</div>');
        }
        redirect('app/inventory/view_transfer/'.$id);
    }
    
    public function print_transfer($id){
        $this->data['header'] = $this->inventory_model->get_transfer($id);
        $this->data['details'] = $this->inventory_model->get_transfer_details($id);
        $this->load->view('app/inventory/stock_transfer/print', $this->data);
    }
    
    // --- Stock Issuance ---
    
    public function stock_issuance(){
        $this->session->set_userdata(array(
            'tab'           =>      'inventory',
            'module'        =>      'stock_issuance',
            'subtab'        =>      '',
            'submodule'     =>      ''));
            
        $this->data['issuances'] = $this->inventory_model->get_stock_issuances(100);
        $this->load->view('app/inventory/stock_issuance/index', $this->data);
    }
    
    public function add_stock_issuance(){
        $branch_code = $this->session->userdata('branch_code') ? $this->session->userdata('branch_code') : 'A';
        $this->data['issuance_no'] = $this->inventory_model->get_issuance_no($branch_code);
        $this->load->view('app/inventory/stock_issuance/add', $this->data);
    }
    
    public function save_stock_issuance(){
        $this->form_validation->set_rules("issuance_no", "Issuance No", "required");
        
        if($this->form_validation->run()){
            $header = array(
                'issuance_no' => $this->input->post('issuance_no'),
                'issue_date' => date('Y-m-d'),
                'issued_to' => $this->input->post('issued_to_id'), // Use ID from hidden field
                'remarks' => $this->input->post('remarks'),
                'created_by' => $this->session->userdata('user_id'),
                'created_date' => date('Y-m-d H:i:s'),
                'status' => 'Active',
                'InActive' => 0
            );
            
            $details = array();
            $items = $this->input->post('item_id');
            $qtys = $this->input->post('qty');
            
            if($items){
                foreach($items as $key => $id){
                    if($qtys[$key] > 0){
                        $details[] = array(
                            'item_id' => $id,
                            'qty' => $qtys[$key],
                            'InActive' => 0
                        );
                    }
                }
            }
            
            if($this->inventory_model->save_issuance($header, $details)){
                $this->session->set_flashdata('message','<div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i> Stock Issuance Saved Successfully!</div>');
                redirect('app/inventory/stock_issuance');
            } else {
                $this->session->set_flashdata('message','<div class="alert alert-danger alert-dismissable"><i class="fa fa-ban"></i> Failed to save issuance.</div>');
                redirect('app/inventory/stock_issuance');
            }
        } else {
            $this->add_stock_issuance();
        }
    }
    
    // AJAX Helpers
    public function search_employees($keyword = ''){
        $keyword = urldecode($keyword);
        $employees = $this->inventory_model->search_employees($keyword);
        $result = array();
        foreach($employees as $emp){
            $result[] = array(
                'id' => $emp->user_id,
                'name' => $emp->firstname . ' ' . $emp->lastname
            );
        }
        echo json_encode($result);
    }
    
    public function search_branches($keyword = ''){
        $keyword = urldecode($keyword);
        $branches = $this->inventory_model->search_branches($keyword);
        $result = array();
        foreach($branches as $br){
            $result[] = array(
                'id' => $br->branch_id,
                'name' => $br->company_name . ' (' . $br->branch_code . ') - ' . $br->address
            );
        }
        echo json_encode($result);
    }
}
