<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Inventory_model extends CI_Model{
    
    public function __construct(){
        parent::__construct();    
    }
    
    // --- Stock Transfer ---
    
    public function save_transfer($header, $details){
        $this->db->trans_start();
        
        // 1. Save Header
        $this->db->insert("stock_transfer", $header);
        $transfer_id = $this->db->insert_id();
        
        // 2. Save Details & Deduct Stock from Source
        foreach($details as $item){
            $item['transfer_id'] = $transfer_id;
            $this->db->insert("stock_transfer_details", $item);
            
            // Deduct from Source
            // If from_dept is 0, it's Main Inventory (medicine_drug_name)
            // If from_dept is > 0, it's Department Stock
            if($header['from_dept'] == 0){
                // Main Inventory
                $this->db->set('nStock', 'nStock - ' . $item['qty_requested'], FALSE);
                $this->db->where('drug_id', $item['item_id']);
                $this->db->update('medicine_drug_name');
            } else {
                // Department Stock
                $this->db->set('qty', 'qty - ' . $item['qty_requested'], FALSE);
                $this->db->where('dept_id', $header['from_dept']);
                $this->db->where('item_id', $item['item_id']);
                $this->db->update('department_stock');
            }
        }
        
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
    
    public function get_transfer($id){
        $this->db->select("A.*, 
            concat(B.firstname, ' ', B.lastname) as created_by_name,
            concat(C.firstname, ' ', C.lastname) as received_by_name,
            D.company_name as from_branch_name,
            E.company_name as to_branch_name
        ");
        $this->db->from("stock_transfer A");
        $this->db->join("users B", "B.user_id = A.created_by", "left");
        $this->db->join("users C", "C.user_id = A.received_by", "left");
        $this->db->join("company_branch D", "D.branch_id = A.from_branch", "left");
        $this->db->join("company_branch E", "E.branch_id = A.to_branch", "left");
        $this->db->where("A.transfer_id", $id);
        return $this->db->get()->row();
    }
    
    public function get_transfer_details($id){
        $this->db->select("A.*, B.drug_name, B.uom, C.cValue as uom_name");
        $this->db->from("stock_transfer_details A");
        $this->db->join("medicine_drug_name B", "B.drug_id = A.item_id", "left");
        $this->db->join("system_parameters C", "C.param_id = B.uom", "left");
        $this->db->where("A.transfer_id", $id);
        return $this->db->get()->result();
    }
    
    public function receive_transfer($transfer_id, $received_by){
        $this->db->trans_start();
        
        // Get Transfer Info
        $transfer = $this->db->get_where('stock_transfer', array('transfer_id' => $transfer_id))->row();
        $details = $this->db->get_where('stock_transfer_details', array('transfer_id' => $transfer_id))->result();
        
        // Update Header
        $this->db->where('transfer_id', $transfer_id);
        $this->db->update('stock_transfer', array(
            'status' => 'Received',
            'received_by' => $received_by,
            'received_date' => date('Y-m-d H:i:s')
        ));
        
        // Add Stock to Destination
        foreach($details as $item){
            // Update Issued Qty (Assuming full receipt for now, logic can be enhanced)
            $this->db->where('detail_id', $item->detail_id);
            $this->db->update('stock_transfer_details', array('qty_issued' => $item->qty_requested));
            
            if($transfer->to_dept == 0){
                // Add to Main Inventory
                $this->db->set('nStock', 'nStock + ' . $item->qty_requested, FALSE);
                $this->db->where('drug_id', $item->item_id);
                $this->db->update('medicine_drug_name');
            } else {
                // Add to Department Stock
                // Check if record exists
                $query = $this->db->get_where('department_stock', array(
                    'dept_id' => $transfer->to_dept, 
                    'item_id' => $item->item_id
                ));
                
                if($query->num_rows() > 0){
                    $this->db->set('qty', 'qty + ' . $item->qty_requested, FALSE);
                    $this->db->where('id', $query->row()->id);
                    $this->db->update('department_stock');
                } else {
                    $this->db->insert('department_stock', array(
                        'dept_id' => $transfer->to_dept,
                        'item_id' => $item->item_id,
                        'qty' => $item->qty_requested
                    ));
                }
            }
        }
        
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
    
    public function cancel_transfer($transfer_id){
        $this->db->trans_start();
        
        // Get Transfer Info
        $transfer = $this->db->get_where('stock_transfer', array('transfer_id' => $transfer_id))->row();
        $details = $this->db->get_where('stock_transfer_details', array('transfer_id' => $transfer_id))->result();
        
        if($transfer->status != 'Pending'){
            return false; // Can only cancel pending transfers
        }
        
        // Update Status
        $this->db->where('transfer_id', $transfer_id);
        $this->db->update('stock_transfer', array('status' => 'Cancelled'));
        
        // Reverse Deduction (Add back to Source)
        foreach($details as $item){
            if($transfer->from_dept == 0){
                // Main Inventory
                $this->db->set('nStock', 'nStock + ' . $item->qty_requested, FALSE);
                $this->db->where('drug_id', $item->item_id);
                $this->db->update('medicine_drug_name');
            } else {
                // Department Stock
                $this->db->set('qty', 'qty + ' . $item->qty_requested, FALSE);
                $this->db->where('dept_id', $transfer->from_dept);
                $this->db->where('item_id', $item->item_id);
                $this->db->update('department_stock');
            }
        }
        
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
    
    // --- Stock Issuance ---
    
    public function save_issuance($header, $details){
        $this->db->trans_start();
        
        // Check if branch_id column exists
        if (!$this->db->field_exists('branch_id', 'stock_issuance')) {
            $this->db->query("ALTER TABLE stock_issuance ADD COLUMN branch_id INT(11) DEFAULT NULL AFTER created_date");
        }
        
        $this->db->insert("stock_issuance", $header);
        $issuance_id = $this->db->insert_id();
        
        foreach($details as $item){
            $item['issuance_id'] = $issuance_id;
            $this->db->insert("stock_issuance_details", $item);
            
            // Deduct from Main Inventory (Assuming issuance is from Central)
            // Could be enhanced to support Department Issuance later
            $this->db->set('nStock', 'nStock - ' . $item['qty'], FALSE);
            $this->db->where('drug_id', $item['item_id']);
            $this->db->update('medicine_drug_name');
        }
        
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
    
    public function get_issuance($id){
        $this->db->select("A.*, 
            concat(B.firstname, ' ', B.lastname) as created_by_name,
            concat(C.firstname, ' ', C.lastname) as issued_to_name
        ");
        $this->db->from("stock_issuance A");
        $this->db->join("users B", "B.user_id = A.created_by", "left");
        $this->db->join("users C", "C.user_id = A.issued_to", "left");
        $this->db->where("A.issuance_id", $id);
        return $this->db->get()->row();
    }

    public function get_issuance_details($id){
        $this->db->select("A.*, B.drug_name, B.uom, C.cValue as uom_name");
        $this->db->from("stock_issuance_details A");
        $this->db->join("medicine_drug_name B", "B.drug_id = A.item_id", "left");
        $this->db->join("system_parameters C", "C.param_id = B.uom", "left");
        $this->db->where("A.issuance_id", $id);
        return $this->db->get()->result();
    }
    
    // --- Dashboard & Reports ---
    
    public function get_low_stock_items(){
        $this->db->select("*");
        $this->db->from("medicine_drug_name");
        $this->db->where("nStock < re_order_level");
        $this->db->where("InActive", 0);
        return $this->db->get()->result();
    }
    
    public function get_expiring_items($days = 30){
        $target_date = date('Y-m-d', strtotime("+$days days"));
        $branch_id = $this->session->userdata('branch_id');
        $branch_id = $this->db->escape($branch_id); // Safe escaping

        $this->db->select("
            A.drug_id, 
            MAX(A.batch_no) as batch_no, 
            MAX(A.expiry_date) as expiry_date,
            (
                COALESCE((SELECT SUM(qty) FROM pharmacy_inventory_details pid JOIN pharmacy_inventory_in pii ON pii.inv_id = pid.inv_id WHERE pid.drug_id = A.drug_id AND pii.InActive = 0 AND (pii.branch_id = $branch_id OR pii.branch_id IS NULL)), 0)
                - COALESCE((SELECT SUM(qty) FROM pharmacy_sales_details psd JOIN pharmacy_sales ps ON ps.sale_id = psd.sale_id WHERE psd.drug_id = A.drug_id AND ps.InActive = 0 AND (ps.branch_id = $branch_id OR ps.branch_id IS NULL)), 0)
                + COALESCE((SELECT SUM(qty) FROM pharmacy_return_details prd JOIN pharmacy_returns pr ON pr.return_id = prd.return_id WHERE prd.drug_id = A.drug_id AND pr.InActive = 0 AND (pr.branch_id = $branch_id OR pr.branch_id IS NULL)), 0)
                + COALESCE((SELECT SUM(CASE WHEN pad.type = 'IN' THEN pad.adjust_qty ELSE -pad.adjust_qty END) FROM pharmacy_adjustment_details pad JOIN pharmacy_adjustments pa ON pa.adjust_id = pad.adjust_id WHERE pad.drug_id = A.drug_id AND pa.InActive = 0 AND (pa.branch_id = $branch_id OR pa.branch_id IS NULL)), 0)
                + COALESCE((SELECT SUM(psd.qty) FROM pharmacy_sales_details psd JOIN pharmacy_void_logs pvl ON pvl.sale_id = psd.sale_id WHERE psd.drug_id = A.drug_id AND pvl.InActive = 0 AND (pvl.branch_id = $branch_id OR pvl.branch_id IS NULL)), 0)
                - COALESCE((SELECT SUM(sid.qty) FROM stock_issuance_details sid JOIN stock_issuance si ON si.issuance_id = sid.issuance_id WHERE sid.item_id = A.drug_id AND si.InActive = 0 AND (si.branch_id = $branch_id OR si.branch_id IS NULL)), 0)
                - COALESCE((SELECT SUM(std.qty_requested) FROM stock_transfer_details std JOIN stock_transfer st ON st.transfer_id = std.transfer_id WHERE std.item_id = A.drug_id AND st.InActive = 0 AND st.from_branch = $branch_id), 0)
                + COALESCE((SELECT SUM(std.qty_requested) FROM stock_transfer_details std JOIN stock_transfer st ON st.transfer_id = std.transfer_id WHERE std.item_id = A.drug_id AND st.InActive = 0 AND st.status = 'Received' AND st.to_branch = $branch_id), 0)
            ) as qty,
            B.drug_name as item_name
        ", false);
        $this->db->from("pharmacy_inventory_details A");
        $this->db->join("medicine_drug_name B", "B.drug_id = A.drug_id", "left");
        
        // Removed the join with pharmacy_inventory_in here because it filters out items that were ONLY received via Transfer
        // The subqueries above handle the branch-specific stock calculation correctly.
        
        $this->db->where("A.expiry_date <=", $target_date);
        $this->db->where("A.expiry_date >=", date('Y-m-d')); 
        
        $this->db->group_by("A.drug_id"); 
        $this->db->having("qty >", 0);
        $this->db->order_by("expiry_date", "ASC");
        return $this->db->get()->result();
    }
    
    public function get_stock_transfers($limit = 10, $offset = 0, $start_date = null, $end_date = null){
        $this->db->select("A.*, B.company_name as from_branch_name, C.company_name as to_branch_name");
        $this->db->from("stock_transfer A");
        $this->db->join("company_branch B", "B.branch_id = A.from_branch", "left");
        $this->db->join("company_branch C", "C.branch_id = A.to_branch", "left");
        if($start_date && $end_date){
            $this->db->where("DATE(A.created_date) >=", $start_date);
            $this->db->where("DATE(A.created_date) <=", $end_date);
        }
        $this->db->order_by("A.created_date", "DESC");
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }
    
    public function get_stock_issuances($limit = 10, $offset = 0, $start_date = null, $end_date = null){
        $this->db->select("A.*, concat(B.firstname, ' ', B.lastname) as issued_to_name");
        $this->db->from("stock_issuance A");
        $this->db->join("users B", "B.user_id = A.issued_to", "left");
        if($start_date && $end_date){
            $this->db->where("DATE(A.created_date) >=", $start_date);
            $this->db->where("DATE(A.created_date) <=", $end_date);
        }
        $this->db->order_by("A.created_date", "DESC");
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }
    
    public function count_stock_transfers(){
        return $this->db->count_all("stock_transfer");
    }

    public function get_issuance_no($branch_code = 'A'){
        // SIM + YY + MM + 0001
        $prefix = "SIM" . date('ym');
        $query = $this->db->query("SELECT issuance_no FROM stock_issuance WHERE issuance_no LIKE '$prefix%' ORDER BY issuance_id DESC LIMIT 1");
        
        if($query->num_rows() > 0){
            $row = $query->row();
            // Prefix Length: SIM(3) + YY(2) + MM(2) = 7 chars
            $last_no = substr($row->issuance_no, 7); 
            $new_no = $prefix . str_pad($last_no + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $new_no = $prefix . '0001';
        }
        return $new_no;
    }

    public function get_transfer_no($branch_code = 'A'){
        // STA + YY + MM + 0001
        $prefix = "ST" . $branch_code . date('ym');
        $query = $this->db->query("SELECT transfer_no FROM stock_transfer WHERE transfer_no LIKE '$prefix%' ORDER BY transfer_id DESC LIMIT 1");
        
        if($query->num_rows() > 0){
            $row = $query->row();
            // Prefix Length: ST(2) + A(1) + YY(2) + MM(2) = 7 chars
            $last_no = substr($row->transfer_no, 7);
            $new_no = $prefix . str_pad($last_no + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $new_no = $prefix . '0001';
        }
        return $new_no;
    }
    
    public function get_branches(){
        $this->db->select("*");
        $this->db->from("company_branch");
        $this->db->where("InActive", 0);
        $this->db->order_by("company_name", "ASC");
        return $this->db->get()->result();
    }
    
    public function search_employees($keyword){
        $this->db->select("user_id, firstname, lastname");
        $this->db->like("firstname", $keyword);
        $this->db->or_like("lastname", $keyword);
        $this->db->where("InActive", 0);
        $this->db->limit(10);
        $query = $this->db->get("users");
        return $query->result();
    }
    
    public function search_branches($keyword){
        $this->db->select("*");
        $this->db->like("company_name", $keyword);
        $this->db->or_like("address", $keyword);
        $this->db->where("InActive", 0);
        $this->db->limit(10);
        $query = $this->db->get("company_branch");
        return $query->result();
    }
}
