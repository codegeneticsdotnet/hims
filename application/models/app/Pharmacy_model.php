<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Pharmacy_model extends CI_Model{
	
    public function __construct(){
        parent::__construct();
        $this->_check_tables();
    }

    private function _check_tables(){
        $this->db->query("CREATE TABLE IF NOT EXISTS pharmacy_sales (sale_id INT AUTO_INCREMENT PRIMARY KEY, invoice_no VARCHAR(50), date_sale DATETIME, patient_no VARCHAR(50) DEFAULT NULL, patient_name VARCHAR(100) DEFAULT NULL, sub_total DECIMAL(10,2), discount DECIMAL(10,2), total_amount DECIMAL(10,2), remarks TEXT, payment_type VARCHAR(20) DEFAULT 'Cash', InActive INT DEFAULT 0)");
        $this->db->query("CREATE TABLE IF NOT EXISTS pharmacy_sales_details (detail_id INT AUTO_INCREMENT PRIMARY KEY, sale_id INT, drug_id INT, item_name VARCHAR(255), qty INT, price DECIMAL(10,2), total DECIMAL(10,2), InActive INT DEFAULT 0)");
        
        $this->db->query("CREATE TABLE IF NOT EXISTS pharmacy_inventory_in (inv_id INT AUTO_INCREMENT PRIMARY KEY, ref_no VARCHAR(50), date_received DATETIME, supplier_name VARCHAR(100) DEFAULT NULL, remarks TEXT, InActive INT DEFAULT 0)");
        $this->db->query("CREATE TABLE IF NOT EXISTS pharmacy_inventory_details (detail_id INT AUTO_INCREMENT PRIMARY KEY, inv_id INT, drug_id INT, item_name VARCHAR(255), qty INT, batch_no VARCHAR(50), expiry_date DATE, InActive INT DEFAULT 0)");
        
        // Check system options
        // Note: The system_option table in this database seems to have different columns than expected.
        // It likely has 'cCode' and 'cValue' but maybe not 'cDesc'.
        // Let's check first before inserting.
        
        $query = $this->db->get_where('system_option', array('cCode' => 'pharmacy_invoice_no'));
        if($query->num_rows() == 0){
             // Try insert without cDesc first if it fails
             $data = array('cCode' => 'pharmacy_invoice_no', 'cValue' => '0', 'InActive' => 0);
             if ($this->db->field_exists('cDesc', 'system_option'))
             {
                $data['cDesc'] = 'Pharmacy Invoice Number';
             }
             $this->db->insert('system_option', $data);
        }
        
        $query = $this->db->get_where('system_option', array('cCode' => 'pharmacy_rr_no'));
        if($query->num_rows() == 0){
             $data = array('cCode' => 'pharmacy_rr_no', 'cValue' => '0', 'InActive' => 0);
             if ($this->db->field_exists('cDesc', 'system_option'))
             {
                $data['cDesc'] = 'Pharmacy Receiving Report Number';
             }
             $this->db->insert('system_option', $data);
        }
    }

	public function getItems($limit = 10, $offset = 0){
		$this->db->select("
				A.drug_id as itemcode,
				A.drug_name as itemname,
				A.drug_desc as genericname,
				D.med_category_name as category,
                A.med_cat_id, 
				C.cValue as unit,
                A.uom as unit_id,
				A.nPrice as price,
				A.nStock as stock_on_hand,
                A.re_order_level
		",false);
		$where = " (A.drug_name LIKE '%" . $this->session->userdata("search_item") . "%' or 
					A.drug_desc LIKE '%" . $this->session->userdata("search_item") . "%')
					and A.InActive = 0";
		$this->db->where($where);
		$this->db->join("medicine_category D","D.cat_id = A.med_cat_id","left outer");
		$this->db->join("system_parameters C","C.param_id = A.uom","left outer");
		$this->db->order_by('A.drug_name','asc');
		$query = $this->db->get("medicine_drug_name A", $limit, $offset);
		$this->session->set_userdata("numrow_items",$query->num_rows());	
		return $query->result();
	}
    
    public function searchItems($keyword){
        $this->db->select("
            A.drug_id as item_id,
            A.drug_name as item_name,
            A.nPrice as price,
            A.nStock as stock_on_hand,
            D.med_category_name as category
        ", false);
        $this->db->like("A.drug_name", $keyword);
        $this->db->or_like("A.drug_desc", $keyword);
        $this->db->join("medicine_category D","D.cat_id = A.med_cat_id","left outer");
        $this->db->where("A.InActive", 0);
        $this->db->limit(20);
        $query = $this->db->get("medicine_drug_name A");
        return $query->result();
    }
    
    public function getPOSInvoiceNo(){
        $this->db->select("cValue");
        $this->db->where("cCode", "pharmacy_invoice_no");
        $query = $this->db->get("system_option");
        if($query->num_rows() > 0){
             $val = $query->row()->cValue + 1;
             // PA + YY + MM + 0001
             return 'PA' . date('ym') . str_pad($val, 4, '0', STR_PAD_LEFT);
        }
        return 'PA' . date('ym') . '0001';
    }
    
    public function getInventoryRefNo(){
        $this->db->select("cValue");
        $this->db->where("cCode", "pharmacy_rr_no");
        $query = $this->db->get("system_option");
        if($query->num_rows() > 0){
             $val = $query->row()->cValue + 1;
             // RA + YY + MM + 0001
             return 'RA' . date('ym') . str_pad($val, 4, '0', STR_PAD_LEFT);
        }
        return 'RA' . date('ym') . '0001';
    }
    
    public function updatePOSInvoiceNo($new_no){
        // Format is PA24020001
        // Length of PA + YY + MM is 2 + 2 + 2 = 6 chars
        $val = intval(substr($new_no, 6)); 
        $this->db->where("cCode", "pharmacy_invoice_no");
        $this->db->update("system_option", array("cValue" => $val));
    }
    
    public function savePOS($header, $details, $ipd_meds = array()){
        // Save Header
        $this->db->insert("pharmacy_sales", $header);
        $sale_id = $this->db->insert_id();
        
        // Save Details & Update Stock
        foreach($details as $detail){
            $detail['sale_id'] = $sale_id;
            $this->db->insert("pharmacy_sales_details", $detail);
            
            // Deduct Stock
            $this->db->set('nStock', 'nStock - ' . $detail['qty'], FALSE);
            $this->db->where('drug_id', $detail['drug_id']);
            $this->db->update('medicine_drug_name');
        }
        
        // Save IPD Medication (Billing)
        if(!empty($ipd_meds)){
            $this->db->insert_batch('iop_medication', $ipd_meds);
        }
        
        return $sale_id;
    }
    
    public function getPOSHeader($sale_id){
        $this->db->where('sale_id', $sale_id);
        return $this->db->get('pharmacy_sales')->row();
    }
    
    public function getPOSDetails($sale_id){
        $this->db->where('sale_id', $sale_id);
        return $this->db->get('pharmacy_sales_details')->result();
    }
    
    public function updateInventoryRefNo($new_no){
        // Format is RA24020001
        // Length of RA + YY + MM is 2 + 2 + 2 = 6 chars
        $val = intval(substr($new_no, 6)); 
        $this->db->where("cCode", "pharmacy_rr_no");
        $this->db->update("system_option", array("cValue" => $val));
    }
    
    public function saveInventoryIn($header, $details){
        // Save Header
        $this->db->insert("pharmacy_inventory_in", $header);
        $inv_id = $this->db->insert_id();
        
        // Save Details & Update Stock
        foreach($details as $detail){
            $detail['inv_id'] = $inv_id;
            $this->db->insert("pharmacy_inventory_details", $detail);
            
            // Increase Stock in medicine_drug_name table
            // IMPORTANT: Ensure nStock is treated as numeric
            $this->db->query("UPDATE medicine_drug_name SET nStock = nStock + " . intval($detail['qty']) . " WHERE drug_id = " . intval($detail['drug_id']));
        }
        return $inv_id;
    }
    public function getRecentInventory($limit = 5){
        $this->db->select("inv_id, ref_no, date_received, supplier_name, remarks");
        $this->db->where("InActive", 0);
        $this->db->order_by("inv_id", "DESC");
        $this->db->limit($limit);
        $query = $this->db->get("pharmacy_inventory_in");
        return $query->result();
    }
    
    public function getInventorySummary(){
        $this->db->select("A.ref_no, A.date_received, A.supplier_name, A.remarks, COUNT(B.detail_id) as total_items");
        $this->db->from("pharmacy_inventory_in A");
        $this->db->join("pharmacy_inventory_details B", "B.inv_id = A.inv_id", "left");
        $this->db->where("A.InActive", 0);
        $this->db->group_by("A.inv_id");
        $this->db->order_by("A.date_received", "DESC");
        $query = $this->db->get();
        return $query->result();
    }
    
    public function getInventoryDetails($inv_id){
        $this->db->select("
            A.*,
            B.drug_name
        ");
        $this->db->where("A.inv_id", $inv_id);
        $this->db->join("medicine_drug_name B", "B.drug_id = A.drug_id", "left");
        $query = $this->db->get("pharmacy_inventory_details A");
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