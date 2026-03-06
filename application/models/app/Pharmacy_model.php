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
        
        $this->db->query("CREATE TABLE IF NOT EXISTS pharmacy_returns (return_id INT AUTO_INCREMENT PRIMARY KEY, return_no VARCHAR(50), date_return DATETIME, patient_no VARCHAR(50) DEFAULT NULL, remarks TEXT, InActive INT DEFAULT 0)");
        $this->db->query("CREATE TABLE IF NOT EXISTS pharmacy_return_details (detail_id INT AUTO_INCREMENT PRIMARY KEY, return_id INT, drug_id INT, qty INT, InActive INT DEFAULT 0)");
        
        $this->db->query("CREATE TABLE IF NOT EXISTS pharmacy_adjustments (adjust_id INT AUTO_INCREMENT PRIMARY KEY, reference_no VARCHAR(50), date_adjust DATETIME, remarks TEXT, cPreparedBy VARCHAR(50), InActive INT DEFAULT 0)");
        $this->db->query("CREATE TABLE IF NOT EXISTS pharmacy_adjustment_details (detail_id INT AUTO_INCREMENT PRIMARY KEY, adjust_id INT, drug_id INT, old_stock INT, adjust_qty INT, new_stock INT, type VARCHAR(10), reason VARCHAR(255), InActive INT DEFAULT 0)");
        
        $this->db->query("CREATE TABLE IF NOT EXISTS pharmacy_void_logs (void_id INT AUTO_INCREMENT PRIMARY KEY, sale_id INT, invoice_no VARCHAR(50), date_voided DATETIME, voided_by VARCHAR(50), reason TEXT, InActive INT DEFAULT 0)");
        
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
        
        // Add is_dispensed column to iop_medication if not exists
        if ($this->db->table_exists('iop_medication') && !$this->db->field_exists('is_dispensed', 'iop_medication'))
        {
            $this->db->query("ALTER TABLE iop_medication ADD COLUMN is_dispensed INT DEFAULT 0");
        }
    }

    public function getItems($limit = 10, $offset = 0){
        $branch_id = $this->session->userdata('branch_id');
        $branch_id = $this->db->escape($branch_id); // Safe escaping
        
		$this->db->select("
				A.drug_id as itemcode,
				A.drug_name as itemname,
				A.drug_desc as genericname,
				D.med_category_name as category,
                A.med_cat_id, 
				C.cValue as unit,
                A.uom as unit_id,
				A.nPrice as price,
				(
                    COALESCE((SELECT SUM(qty) FROM pharmacy_inventory_details pid JOIN pharmacy_inventory_in pii ON pii.inv_id = pid.inv_id WHERE pid.drug_id = A.drug_id AND pii.InActive = 0 AND (pii.branch_id = $branch_id OR pii.branch_id IS NULL)), 0)
                    - COALESCE((SELECT SUM(qty) FROM pharmacy_sales_details psd JOIN pharmacy_sales ps ON ps.sale_id = psd.sale_id WHERE psd.drug_id = A.drug_id AND ps.InActive = 0 AND (ps.branch_id = $branch_id OR ps.branch_id IS NULL)), 0)
                    + COALESCE((SELECT SUM(qty) FROM pharmacy_return_details prd JOIN pharmacy_returns pr ON pr.return_id = prd.return_id WHERE prd.drug_id = A.drug_id AND pr.InActive = 0 AND (pr.branch_id = $branch_id OR pr.branch_id IS NULL)), 0)
                    + COALESCE((SELECT SUM(CASE WHEN pad.type = 'IN' THEN pad.adjust_qty ELSE -pad.adjust_qty END) FROM pharmacy_adjustment_details pad JOIN pharmacy_adjustments pa ON pa.adjust_id = pad.adjust_id WHERE pad.drug_id = A.drug_id AND pa.InActive = 0 AND (pa.branch_id = $branch_id OR pa.branch_id IS NULL)), 0)
                    + COALESCE((SELECT SUM(psd.qty) FROM pharmacy_sales_details psd JOIN pharmacy_void_logs pvl ON pvl.sale_id = psd.sale_id WHERE psd.drug_id = A.drug_id AND pvl.InActive = 0 AND (pvl.branch_id = $branch_id OR pvl.branch_id IS NULL)), 0)
                    - COALESCE((SELECT SUM(sid.qty) FROM stock_issuance_details sid JOIN stock_issuance si ON si.issuance_id = sid.issuance_id WHERE sid.item_id = A.drug_id AND si.InActive = 0 AND (si.branch_id = $branch_id OR si.branch_id IS NULL)), 0)
                    - COALESCE((SELECT SUM(std.qty_requested) FROM stock_transfer_details std JOIN stock_transfer st ON st.transfer_id = std.transfer_id WHERE std.item_id = A.drug_id AND st.InActive = 0 AND st.from_branch = $branch_id), 0)
                    + COALESCE((SELECT SUM(std.qty_requested) FROM stock_transfer_details std JOIN stock_transfer st ON st.transfer_id = std.transfer_id WHERE std.item_id = A.drug_id AND st.InActive = 0 AND st.status = 'Received' AND st.to_branch = $branch_id), 0)
                ) as stock_on_hand,
                A.re_order_level,
                A.bin_location
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
        $branch_id = $this->session->userdata('branch_id');
        $branch_id = $this->db->escape($branch_id); // Safe escaping
        
        $this->db->select("
            A.drug_id as item_id,
            A.drug_name as item_name,
            A.nPrice as price,
            (
                COALESCE((SELECT SUM(qty) FROM pharmacy_inventory_details pid JOIN pharmacy_inventory_in pii ON pii.inv_id = pid.inv_id WHERE pid.drug_id = A.drug_id AND pii.InActive = 0 AND (pii.branch_id = $branch_id OR pii.branch_id IS NULL)), 0)
                - COALESCE((SELECT SUM(qty) FROM pharmacy_sales_details psd JOIN pharmacy_sales ps ON ps.sale_id = psd.sale_id WHERE psd.drug_id = A.drug_id AND ps.InActive = 0 AND (ps.branch_id = $branch_id OR ps.branch_id IS NULL)), 0)
                + COALESCE((SELECT SUM(qty) FROM pharmacy_return_details prd JOIN pharmacy_returns pr ON pr.return_id = prd.return_id WHERE prd.drug_id = A.drug_id AND pr.InActive = 0 AND (pr.branch_id = $branch_id OR pr.branch_id IS NULL)), 0)
                + COALESCE((SELECT SUM(CASE WHEN pad.type = 'IN' THEN pad.adjust_qty ELSE -pad.adjust_qty END) FROM pharmacy_adjustment_details pad JOIN pharmacy_adjustments pa ON pa.adjust_id = pad.adjust_id WHERE pad.drug_id = A.drug_id AND pa.InActive = 0 AND (pa.branch_id = $branch_id OR pa.branch_id IS NULL)), 0)
                + COALESCE((SELECT SUM(psd.qty) FROM pharmacy_sales_details psd JOIN pharmacy_void_logs pvl ON pvl.sale_id = psd.sale_id WHERE psd.drug_id = A.drug_id AND pvl.InActive = 0 AND (pvl.branch_id = $branch_id OR pvl.branch_id IS NULL)), 0)
                - COALESCE((SELECT SUM(sid.qty) FROM stock_issuance_details sid JOIN stock_issuance si ON si.issuance_id = sid.issuance_id WHERE sid.item_id = A.drug_id AND si.InActive = 0 AND (si.branch_id = $branch_id OR si.branch_id IS NULL)), 0)
                - COALESCE((SELECT SUM(std.qty_requested) FROM stock_transfer_details std JOIN stock_transfer st ON st.transfer_id = std.transfer_id WHERE std.item_id = A.drug_id AND st.InActive = 0 AND st.from_branch = $branch_id), 0)
                + COALESCE((SELECT SUM(std.qty_requested) FROM stock_transfer_details std JOIN stock_transfer st ON st.transfer_id = std.transfer_id WHERE std.item_id = A.drug_id AND st.InActive = 0 AND st.status = 'Received' AND st.to_branch = $branch_id), 0)
            ) as stock_on_hand,
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
    
    public function generateDoctorOrderNo(){
        $this->load->model('general_model');
        return $this->general_model->generateID('DO', 'iop_medication', 'doctor_order_no');
    }

    public function getPOSInvoiceNo(){
        $this->load->model('general_model');
        return $this->general_model->generateID('PA', 'pharmacy_sales', 'invoice_no');
    }
    
    public function getInventoryRefNo(){
        $this->load->model('general_model');
        return $this->general_model->generateID('RA', 'pharmacy_inventory_in', 'ref_no');
    }
    
    public function updatePOSInvoiceNo($new_no){
        // Deprecated: using generateID based on table max ID
    }
    
    public function savePOS($header, $details, $ipd_meds = array()){
        // Add branch_id
        $header['branch_id'] = $this->session->userdata('branch_id');
        
        // Save Header
        $this->db->insert("pharmacy_sales", $header);
        $sale_id = $this->db->insert_id();
        
        // Save Details & Update Stock
        foreach($details as $detail){
            $detail['sale_id'] = $sale_id;
            $this->db->insert("pharmacy_sales_details", $detail);
            
            // Deduct Stock (Global - Legacy)
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
        // Deprecated: using generateID based on table max ID
    }
    
    public function saveInventoryIn($header, $details){
        // Add branch_id
        $header['branch_id'] = $this->session->userdata('branch_id');
        
        // Save Header
        $this->db->insert("pharmacy_inventory_in", $header);
        $inv_id = $this->db->insert_id();
        
        // Save Details & Update Stock
        foreach($details as $detail){
            $detail['inv_id'] = $inv_id;
            $this->db->insert("pharmacy_inventory_details", $detail);
            
            // Increase Stock in medicine_drug_name table (Global - Legacy)
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
    
    public function getInventoryHeader($inv_id){
        $this->db->where("inv_id", $inv_id);
        return $this->db->get("pharmacy_inventory_in")->row();
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
    
    public function getItemLedger($item_id){
        $branch_id = $this->session->userdata('branch_id');
        
        // Inventory In
        $sql = "SELECT 
                    A.date_received as ref_date, 
                    A.ref_no, 
                    'Inventory In' as type, 
                    (B.qty * C.nPrice) as amount,
                    B.qty as qty_in, 
                    0 as qty_out, 
                    A.remarks,
                    B.expiry_date
                FROM pharmacy_inventory_in A 
                JOIN pharmacy_inventory_details B ON A.inv_id = B.inv_id 
                JOIN medicine_drug_name C ON B.drug_id = C.drug_id
                WHERE B.drug_id = ? AND A.InActive = 0 AND (A.branch_id = ? OR A.branch_id IS NULL)";
        
        // Sales (Out)
        $sql .= " UNION ALL SELECT 
                    A.date_sale as ref_date, 
                    A.invoice_no as ref_no, 
                    CONCAT(A.payment_type, ' Sales') as type, 
                    B.total as amount,
                    0 as qty_in, 
                    B.qty as qty_out, 
                    A.remarks,
                    NULL as expiry_date
                FROM pharmacy_sales A 
                JOIN pharmacy_sales_details B ON A.sale_id = B.sale_id 
                WHERE B.drug_id = ? AND A.InActive = 0 AND (A.branch_id = ? OR A.branch_id IS NULL)";
                
        // Returns (In)
        $sql .= " UNION ALL SELECT 
                    A.date_return as ref_date, 
                    A.return_no as ref_no, 
                    'Return' as type, 
                    0 as amount, 
                    B.qty as qty_in, 
                    0 as qty_out, 
                    A.remarks,
                    NULL as expiry_date
                FROM pharmacy_returns A 
                JOIN pharmacy_return_details B ON A.return_id = B.return_id 
                WHERE B.drug_id = ? AND A.InActive = 0 AND (A.branch_id = ? OR A.branch_id IS NULL)";
                
        // Adjustments
        $sql .= " UNION ALL SELECT 
                    A.date_adjust as ref_date, 
                    A.reference_no as ref_no, 
                    CONCAT('Adjustment (', B.type, ')') as type, 
                    0 as amount, 
                    CASE WHEN B.type = 'IN' THEN B.adjust_qty ELSE 0 END as qty_in, 
                    CASE WHEN B.type = 'OUT' THEN B.adjust_qty ELSE 0 END as qty_out, 
                    B.reason as remarks,
                    NULL as expiry_date
                FROM pharmacy_adjustments A 
                JOIN pharmacy_adjustment_details B ON A.adjust_id = B.adjust_id 
                WHERE B.drug_id = ? AND A.InActive = 0 AND (A.branch_id = ? OR A.branch_id IS NULL)";
                
        // Void (In) - Show reversal of sales
        $sql .= " UNION ALL SELECT 
                    A.date_voided as ref_date, 
                    A.invoice_no as ref_no, 
                    'Void Transaction' as type, 
                    0 as amount, 
                    B.qty as qty_in, 
                    0 as qty_out, 
                    CONCAT('Voided: ', A.reason) as remarks,
                    NULL as expiry_date
                FROM pharmacy_void_logs A 
                JOIN pharmacy_sales_details B ON A.sale_id = B.sale_id 
                WHERE B.drug_id = ? AND A.InActive = 0 AND (A.branch_id = ? OR A.branch_id IS NULL)";

        // Stock Issuance (Out)
        $sql .= " UNION ALL SELECT 
                    A.issue_date as ref_date, 
                    A.issuance_no as ref_no, 
                    'Stock Issuance' as type, 
                    0 as amount, 
                    0 as qty_in, 
                    B.qty as qty_out, 
                    A.remarks,
                    NULL as expiry_date
                FROM stock_issuance A 
                JOIN stock_issuance_details B ON A.issuance_id = B.issuance_id 
                WHERE B.item_id = ? AND A.InActive = 0 AND (A.branch_id = ? OR A.branch_id IS NULL)";

        // Stock Transfer (Out - Source)
        $sql .= " UNION ALL SELECT 
                    A.created_date as ref_date, 
                    CONCAT('S-', SUBSTRING(C.company_name, 1, 1), SUBSTRING(A.transfer_no, 4)) as ref_no, 
                    'Stock Transfer' as type, 
                    0 as amount, 
                    0 as qty_in, 
                    B.qty_requested as qty_out, 
                    CONCAT('Transfer to ', D.company_name) as remarks,
                    NULL as expiry_date
                FROM stock_transfer A 
                JOIN stock_transfer_details B ON A.transfer_id = B.transfer_id 
                JOIN company_branch C ON C.branch_id = A.from_branch
                JOIN company_branch D ON D.branch_id = A.to_branch
                WHERE B.item_id = ? AND A.InActive = 0 AND A.from_branch = ?";

        // Stock Transfer (In - Destination)
        $sql .= " UNION ALL SELECT 
                    A.received_date as ref_date, 
                    CONCAT('S+', SUBSTRING(C.company_name, 1, 1), SUBSTRING(A.transfer_no, 4)) as ref_no, 
                    'Stock Transfer' as type, 
                    0 as amount, 
                    B.qty_requested as qty_in, 
                    0 as qty_out, 
                    CONCAT('Received from ', C.company_name) as remarks,
                    NULL as expiry_date
                FROM stock_transfer A 
                JOIN stock_transfer_details B ON A.transfer_id = B.transfer_id 
                JOIN company_branch C ON C.branch_id = A.from_branch
                WHERE B.item_id = ? AND A.InActive = 0 AND A.status = 'Received' AND A.to_branch = ?";
                
        $sql .= " ORDER BY ref_date ASC";
        
        $query = $this->db->query($sql, array(
            $item_id, $branch_id, 
            $item_id, $branch_id, 
            $item_id, $branch_id, 
            $item_id, $branch_id, 
            $item_id, $branch_id,
            $item_id, $branch_id, // For Stock Issuance
            $item_id, $branch_id, // For Stock Transfer Out
            $item_id, $branch_id  // For Stock Transfer In
        ));
        return $query->result();
    }
    
    public function getAdjustmentRefNo(){
        $this->load->model('general_model');
        return $this->general_model->generateID('AA', 'pharmacy_adjustments', 'reference_no');
    }
    
    public function saveAdjustment($header, $details){
        // Add branch_id
        $header['branch_id'] = $this->session->userdata('branch_id');
        
        $this->db->trans_start();
        $this->db->insert('pharmacy_adjustments', $header);
        $adjust_id = $this->db->insert_id();
        
        foreach($details as $item){
            $item['adjust_id'] = $adjust_id;
            $this->db->insert('pharmacy_adjustment_details', $item);
            
            // Update Stock (Global - Legacy)
            if($item['type'] == 'IN'){
                $this->db->query("UPDATE medicine_drug_name SET nStock = nStock + " . $item['adjust_qty'] . " WHERE drug_id = " . $item['drug_id']);
            } else {
                $this->db->query("UPDATE medicine_drug_name SET nStock = nStock - " . $item['adjust_qty'] . " WHERE drug_id = " . $item['drug_id']);
            }
        }
        
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
    
    public function getReturnNo(){
        $this->load->model('general_model');
        return $this->general_model->generateID('RT', 'pharmacy_returns', 'return_no');
    }
    
    public function getSaleByInvoice($invoice_no){
        $this->db->select("A.*, B.patient_no, B.middlename, B.firstname, B.lastname");
        $this->db->join("patient_personal_info B", "B.patient_no = A.patient_no", "left");
        $this->db->where("A.invoice_no", $invoice_no);
        $query = $this->db->get("pharmacy_sales A");
        return $query->row();
    }
    
    public function getSaleDetails($sale_id){
        $this->db->select("A.*, B.drug_name");
        $this->db->join("medicine_drug_name B", "B.drug_id = A.drug_id", "left");
        $this->db->where("A.sale_id", $sale_id);
        $query = $this->db->get("pharmacy_sales_details A");
        return $query->result();
    }
    
    public function saveReturn($header, $details){
        // Add branch_id
        $header['branch_id'] = $this->session->userdata('branch_id');
        
        $this->db->trans_start();
        $this->db->insert('pharmacy_returns', $header);
        $return_id = $this->db->insert_id();
        
        foreach($details as $item){
            $item['return_id'] = $return_id;
            $this->db->insert('pharmacy_return_details', $item);
            
            // Update Stock (Global - Legacy)
            $this->db->query("UPDATE medicine_drug_name SET nStock = nStock + " . $item['qty'] . " WHERE drug_id = " . $item['drug_id']);
        }
        
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
    
    public function voidTransaction($invoice_no, $reason, $user_id){
        $this->db->trans_start();
        
        // 1. Get Sale Info
        $sale = $this->getSaleByInvoice($invoice_no);
        if(!$sale) return false;
        
        // 2. Mark as Void/Inactive
        $this->db->where('sale_id', $sale->sale_id);
        $this->db->update('pharmacy_sales', array('InActive' => 1, 'remarks' => $reason . ' (VOIDED)'));
        
        // 3. Log Void
        $log = array(
            'sale_id' => $sale->sale_id,
            'invoice_no' => $invoice_no,
            'date_voided' => date('Y-m-d H:i:s'),
            'voided_by' => $user_id,
            'reason' => $reason,
            'InActive' => 0,
            'branch_id' => $this->session->userdata('branch_id')
        );
        $this->db->insert('pharmacy_void_logs', $log);
        
        // 4. Restore Stock (Global - Legacy)
        $details = $this->getSaleDetails($sale->sale_id);
        foreach($details as $item){
            $this->db->query("UPDATE medicine_drug_name SET nStock = nStock + " . $item->qty . " WHERE drug_id = " . $item->drug_id);
        }
        
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
}