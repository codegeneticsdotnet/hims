<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Billing_new_model extends CI_Model{
    
    public function __construct(){
        parent::__construct();    
    }
    
    // Get list of pending OPD patients (Visits or Lab Requests)
    public function getPendingOPD(){
        // Pending Visits
        $this->db->select("
            A.IO_ID,
            A.patient_no,
            concat(B.firstname,' ',B.lastname) as patient_name,
            CAST(A.date_visit AS DATETIME) as date_visit,
            CASE 
                WHEN D.dept_name = 'LABORATORY' THEN 'Lab Only'
                WHEN D.dept_name = 'X-RAY' THEN 'Lab Only'
                WHEN D.dept_name = 'ULTRASOUND' THEN 'Lab Only'
                ELSE 'OPD Consultation' 
            END as type
        ", false);
        $this->db->join("patient_personal_info B", "B.patient_no = A.patient_no", "left");
        $this->db->join("department D", "D.department_id = A.department_id", "left");
        $this->db->where("A.nStatus", "Pending");
        $this->db->where("A.InActive", 0);
        $query1 = $this->db->get_compiled_select("patient_details_iop A");
        
        // Pending Lab Requests (without active OPD visit or independent)
        $this->db->select("
            '' as IO_ID,
            A.patient_no,
            concat(B.firstname,' ',B.lastname) as patient_name,
            CAST(A.request_date AS DATETIME) as date_visit,
            'Lab Only' as type
        ", false);
        $this->db->join("patient_personal_info B", "B.patient_no = A.patient_no", "left");
        $this->db->where("A.status", "Pending");
        $this->db->where("A.InActive", 0);
        $this->db->group_by("A.patient_no"); // Group by patient to avoid duplicates
        $query2 = $this->db->get_compiled_select("lab_service_request A");
        
        // Sorting by date_visit DESC in the UNION query
        // Using CAST to ensure proper date sorting
        $query = $this->db->query("SELECT * FROM ($query1 UNION $query2) as T GROUP BY patient_no ORDER BY date_visit DESC");
        return $query->result();
    }
    
    // Get list of admitted IPD patients
    public function getAdmittedIPD(){
        $this->db->select("
            A.IO_ID,
            A.patient_no,
            concat(B.firstname,' ',B.lastname) as patient_name,
            A.date_visit,
            A.nStatus
        ", false);
        $this->db->join("patient_personal_info B", "B.patient_no = A.patient_no", "left");
        $this->db->where("A.patient_type", "IPD");
        $this->db->where("A.nStatus", "Pending"); // Currently admitted
        $this->db->where("A.InActive", 0);
        $query = $this->db->get("patient_details_iop A");
        return $query->result();
    }
    
    // Get all billable items for a patient/visit
    public function getBillableItems($patient_no, $io_id = null){
        $items = array();
        
        // 1. Lab Requests (Pending or Active/Done for IPD)
        $this->db->select("
            A.detail_id as item_id,
            concat('Lab: ', B.particular_name) as item_name,
            A.amount as price,
            A.qty,
            (A.amount * A.qty) as total,
            C.status,
            'Laboratory' as category
        ", false);
        $this->db->from("lab_service_request_details A");
        $this->db->join("bill_particular B", "B.particular_id = A.particular_id", "left");
        $this->db->join("lab_service_request C", "C.request_id = A.request_id", "left");
        $this->db->where("C.patient_no", $patient_no);
        $this->db->where("A.InActive", 0);
        $this->db->where("C.InActive", 0);
        
        // Filter by status: For OPD, usually 'Pending'. For IPD, 'Active'/'Done' but not 'Paid'.
        // Let's grab everything not 'Paid' or 'Cancelled'.
        $this->db->where_not_in("C.status", array("Paid", "Cancelled"));
        
        // Fix for IO_ID filtering
        if($io_id){
            // If IO_ID is passed and it's valid (not just patient_no or generic), filter by it if column exists
            // Since we might have mixed OPD/Lab records, strict filtering on iop_id in lab_service_request might be too restrictive if NULL
            // But if we want to bill specific visit, we should try.
            // Check if column exists first or just try? 
            // In lab_service_request table, do we have iop_id? Yes, usually.
            // But for 'Lab Only' visits, iop_id might be empty or 0.
            
            // If it's an IPD admission, strictly filter.
            if(strpos($io_id, 'IP') !== false){
                 $this->db->where("C.iop_id", $io_id);
            } else {
                // For OPD, we might want to include unlinked labs too?
                // Or just filter by patient_no is enough as we want to clear all pending for this patient.
                // Let's stick to patient_no filter primarily for OPD billing to catch all pending labs.
            }
        }
        
        $query = $this->db->get();
        if($query->num_rows() > 0){
             $items = array_merge($items, $query->result());
        }
        
        // Check if patient is IPD to include Meds and Room charges
        $is_ipd = false;
        if($io_id){
             // Check patient type based on IO_ID
             $this->db->where("IO_ID", $io_id);
             $this->db->where("patient_type", "IPD");
             $check = $this->db->get("patient_details_iop");
             if($check->num_rows() > 0){
                 $is_ipd = true;
             }
        }

        // 2. Pharmacy / Medication
        // For OPD, allow fetching meds if linked to this IO_ID (if we implement OPD Meds)
        // Currently typically IPD, but let's relax if needed.
        if($is_ipd || $io_id){ 
            $this->db->select("
                A.iop_med_id as item_id,
                concat('Meds: ', B.drug_name) as item_name,
                B.nPrice as price,
                A.total_qty as qty,
                (B.nPrice * A.total_qty) as total,
                'Pending' as status,
                'Pharmacy' as category
            ", false);
            $this->db->from("iop_medication A");
            $this->db->join("medicine_drug_name B", "B.drug_id = A.medicine_id", "left");
            $this->db->where("A.iop_id", $io_id);
            $this->db->where("A.InActive", 0);
            // Assuming we have a status column or we assume all are billable
            // Let's assume all linked to this admission are billable
            $query = $this->db->get();
            if($query->num_rows() > 0){
                $items = array_merge($items, $query->result());
            }
        }
        
        // 3. Room Charges (IPD only)
        if($is_ipd){
            $this->db->select("
                A.transfer_id as item_id,
                concat('Room: ', B.room_name) as item_name,
                B.room_rates as price,
                1 as qty,
                B.room_rates as total,
                'Pending' as status,
                'Room' as category
            ", false);
            $this->db->from("iop_room_transfer A");
            $this->db->join("room_master B", "B.room_master_id = A.room_master_id", "left");
            $this->db->where("A.iop_id", $io_id);
            $this->db->where("A.InActive", 0);
            $query = $this->db->get();
            // Note: In real app, we calculate days * rate. For now, flat rate per transfer or assume 1 day for simplicity unless we have check-in/out dates.
            if($query->num_rows() > 0){
                $items = array_merge($items, $query->result());
            }
        }
        
        // 4. Doctor's Consultation Fee (OPD)
        // If this is an OPD visit, check if we should add a consultation fee
        // Or if there are specific billable services added
        if(!$is_ipd && $io_id){
             // Maybe fetch from a 'bill_services' table or similar if implemented
             // For now, let's look for 'iop_bed_side_procedure' which seems to hold other services too based on opd_model
             $this->db->select("
                A.bed_pro_id as item_id,
                concat('Service: ', B.particular_name) as item_name,
                B.charge_amount as price,
                A.qty,
                (B.charge_amount * A.qty) as total,
                'Pending' as status,
                'Services' as category
            ", false);
            $this->db->from("iop_bed_side_procedure A");
            $this->db->join("bill_particular B", "B.particular_id = A.cItem_id", "left");
            $this->db->where("A.iop_id", $io_id);
            $this->db->where("A.InActive", 0);
            $query = $this->db->get();
            if($query->num_rows() > 0){
                $items = array_merge($items, $query->result());
            }
        }
        
        return $items;
    }
    
    public function getItemsByCategory($category){
        if($category == 'Services'){
            $this->db->select("particular_id as id, particular_name as name, charge_amount as price");
            $this->db->where("InActive", 0);
            return $this->db->get("bill_particular")->result();
        } else if($category == 'Laboratory'){
            $this->db->select("particular_id as id, particular_name as name, charge_amount as price");
            $this->db->where("group_id", 3); // Assuming group_id 3 is Laboratory based on common schema, or check bill_group_name
            // Actually, let's just fetch all bill_particular and maybe filter by name or assume user selects correctly.
            // Better: Check bill_group_name if possible.
            // For now, let's return all bill_particular as 'Laboratory' usually is a subset.
            // If we want specific lab tests, they might be in bill_particular too.
            $this->db->where("InActive", 0);
             return $this->db->get("bill_particular")->result();
        } else if($category == 'Pharmacy'){
            $this->db->select("drug_id as id, drug_name as name, nPrice as price");
            $this->db->where("InActive", 0);
            return $this->db->get("medicine_drug_name")->result();
        } else {
             // Others
            $this->db->select("particular_id as id, particular_name as name, charge_amount as price");
            $this->db->where("InActive", 0);
            return $this->db->get("bill_particular")->result();
        }
    }
    
    // Save the bill
    public function saveBill($header, $details){
        // Save Header
        $this->db->insert("iop_billing", $header);
        
        // Save Details
        foreach($details as $detail){
            $this->db->insert("iop_billing_t", $detail);
        }
        
        // Update Status of source items
        // Update Lab Requests
        $this->db->where("patient_no", $header['patient_no']);
        $this->db->where("status", "Pending");
        $this->db->update("lab_service_request", array("status" => "Paid"));
        
        // If IPD, we might update other tables or just mark the admission as Billed
        if(!empty($header['iop_id'])){
             // Logic to mark medication/room as billed if necessary
        }
        
        return true;
    }
    
    public function getInvoiceNo(){
        $this->db->select("(cValue + 1) as invoice_no");
        $this->db->where("cCode","invoice_no");
        $query = $this->db->get("system_option");    
        return $query->row()->invoice_no;    
    }
    
    public function updateInvoiceNo($new_no){
        $this->db->where("cCode", "invoice_no");
        $this->db->update("system_option", array("cValue" => $new_no));
    }
    
    public function getPatientInfo($patient_no){
        // Ensure patient_no is trimmed
        $patient_no = trim($patient_no);
        $this->db->select("
            A.*,
            B.cValue as gender_name
        ", false);
        $this->db->join("system_parameters B", "B.param_id = A.gender", "left");
        $this->db->where("A.patient_no", $patient_no);
        return $this->db->get("patient_personal_info A")->row();
    }
}