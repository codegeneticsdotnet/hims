<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Company_branch_model extends CI_Model{
    
    public function __construct(){
        parent::__construct();    
    }
    
    public function getAll(){
        $this->db->where('InActive', 0);
        $this->db->order_by('branch_id', 'asc');
        $query = $this->db->get('company_branch');
        return $query->result();
    }
    
    public function getBranch($id){
        $this->db->where('branch_id', $id);
        $query = $this->db->get('company_branch');
        return $query->row();
    }
    
    public function save(){
        $this->db->trans_start();
        
        $data = array(
            'company_name'  => $this->input->post('company_name'),
            'address'       => $this->input->post('address'),
            'branch_code'   => $this->input->post('branch_code'),
            'contact_no'    => $this->input->post('contact_no'),
            'tin_no'        => $this->input->post('tin_no'),
            'InActive'      => 0
        );
        
        $this->db->insert('company_branch', $data);
        
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
    
    public function edit_save(){
        $this->db->trans_start();
        
        $data = array(
            'company_name'  => $this->input->post('company_name'),
            'address'       => $this->input->post('address'),
            'branch_code'   => $this->input->post('branch_code'),
            'contact_no'    => $this->input->post('contact_no'),
            'tin_no'        => $this->input->post('tin_no')
        );
        
        $this->db->where('branch_id', $this->input->post('id'));
        $this->db->update('company_branch', $data);
        
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
    
    public function delete($id){
        $this->db->where('branch_id', $id);
        $this->db->update('company_branch', array('InActive' => 1));
        return true;
    }
}