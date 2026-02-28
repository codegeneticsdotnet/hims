<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Pharmacy_reports_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}
	
    public function getDailySales($cFrom, $cTo){
        $this->db->select("
            A.sale_id,
            A.invoice_no,
            A.date_sale,
            A.patient_name,
            A.patient_no,
            A.payment_type,
            A.sub_total,
            A.discount,
            A.total_amount,
            A.remarks,
            CONCAT(B.lastname, ', ', B.firstname) as patient_full_name
        ", false);
        
        $where = "DATE_FORMAT(A.date_sale, '%Y-%m-%d') BETWEEN '".$cFrom."' AND '".$cTo."' AND A.InActive = 0";
        $this->db->where($where);
        $this->db->join("patient_personal_info B", "B.patient_no = A.patient_no", "left");
        $this->db->order_by("A.date_sale", "ASC");
        $query = $this->db->get("pharmacy_sales A");
        return $query->result();
    }
    
    public function getDailyDispense($cFrom, $cTo){
        $this->db->select("
            A.invoice_no,
            A.date_sale,
            B.item_name,
            B.qty,
            B.price,
            B.total,
            '' as category_name
        ", false);
        
        $where = "DATE_FORMAT(A.date_sale, '%Y-%m-%d') BETWEEN '".$cFrom."' AND '".$cTo."' AND A.InActive = 0 AND B.InActive = 0";
        $this->db->where($where);
        $this->db->join("pharmacy_sales_details B", "B.sale_id = A.sale_id", "left outer");
        $this->db->join("medicine_drug_name M", "M.drug_id = B.drug_id", "left outer");
        // $this->db->join("system_parameters C", "C.param_id = M.nCategory", "left outer"); 
        $this->db->order_by("A.date_sale", "ASC");
        $query = $this->db->get("pharmacy_sales A");
        // Manually join category if needed or just skip for now to fix error
        return $query->result();
    }
}
