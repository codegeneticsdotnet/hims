<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Pharmacy_model extends CI_Model{
	public function __construct(){
		parent::__construct();	
	}
	public function getItems($limit = 10, $offset = 0){
		$this->db->select(" itemcode, itemname, barcode, genericname, category, unit, markup, minmarkup",false);
		$where = " (itemname LIKE '%" . $this->session->userdata("search_item") . "%' or 
					genericname LIKE '%" . $this->session->userdata("search_item") . "%')
					and itemstat = 0";
					//item_category
		$this->db->where($where);
		$this->db->order_by('itemname','asc');
		$query = $this->db->get("inv_items", $limit, $offset);
		$this->session->set_userdata("numrow_items",$query->num_rows());	
		return $query->result();
	}
	public function getCategory($limit = 10, $offset = 0){
		$this->db->select(" param_id, cValue as categoryname,
							cDesc as categorydesc",false);
		$where = "	cCode = 'item_category' AND 
					cValue LIKE '%" . $this->session->userdata("search_category") . "%' 
					and InActive = 0";
					//item_category
		$this->db->where($where);
		$this->db->order_by('cValue','asc');
		$query = $this->db->get("system_parameters", $limit, $offset);
		$this->session->set_userdata("numrow_category",$query->num_rows());	
		return $query->result();
	}
	public function getUnit($limit = 10, $offset = 0){
		$this->db->select(" param_id, cValue as unitname,
							cDesc as unitdesc",false);
		$where = "	cCode = 'item_uom' AND 
					cValue LIKE '%" . $this->session->userdata("search_unit") . "%' 
					and InActive = 0";
					//item_category
		$this->db->where($where);
		$this->db->order_by('cValue','asc');
		$query = $this->db->get("system_parameters", $limit, $offset);
		$this->session->set_userdata("numrow_category",$query->num_rows());	
		return $query->result();
	}
	public function saveCategory(){
		$this->data = array(
			'cCode'			=> 	"item_category",
			'cValue'		=> 	strtoupper($this->input->post('cCategory')),
			'cDesc'			=> 	strtoupper($this->input->post('cDescription')),
			'InActive'		=> 	0
		);	
		$this->db->insert('system_parameters',$this->data);
		return ($this->db->affected_rows() != 1) ? false : true;
	}
	public function saveUnit(){
		$this->data = array(
			'cCode'			=> 	"item_uom",
			'cValue'		=> 	strtoupper($this->input->post('cUnit')),
			'cDesc'			=> 	strtoupper($this->input->post('cUnitDescription')),
			'InActive'		=> 	0
		);	
		$this->db->insert('system_parameters',$this->data);
		return ($this->db->affected_rows() != 1) ? false : true;
	}
}