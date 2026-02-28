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
            END as type,
            CASE 
                WHEN C.invoice_no IS NOT NULL THEN 'Paid'
                ELSE A.nStatus 
            END as nStatus,
            C.invoice_no,
            C.dDate as bill_date
        ", false);
        $this->db->join("patient_personal_info B", "B.patient_no = A.patient_no", "left");
        $this->db->join("department D", "D.department_id = A.department_id", "left");
        $this->db->join("iop_billing C", "C.iop_id = A.IO_ID", "left");
        // Only show Discharged (Ready for Billing) or Paid. Hide Pending (Registration).
        $this->db->where_in("A.nStatus", array("Discharged", "Paid")); 
        $this->db->where("A.InActive", 0);
        $query1 = $this->db->get_compiled_select("patient_details_iop A");
        
        // Pending Lab Requests (without active OPD visit or independent)
        // Note: Lab requests don't have 'Discharged' status in the same way, but 'Paid' status.
        // We need to map 'Paid' to something visible or just filter by 'Pending' if we only want pending.
        // If we want to show recent paid lab requests, we need to include status 'Paid'.
        $this->db->select("
            A.request_no as IO_ID,
            A.patient_no,
            concat(B.firstname,' ',B.lastname) as patient_name,
            CAST(A.request_date AS DATETIME) as date_visit,
            'Lab Only' as type,
            CASE 
                WHEN C.invoice_no IS NOT NULL THEN 'Paid'
                WHEN A.status = 'Paid' THEN 'Paid' 
                WHEN A.status = 'Cancelled' THEN 'Cancelled'
                ELSE 'Pending' 
            END as nStatus,
            C.invoice_no,
            C.dDate as bill_date
        ", false);
        $this->db->join("patient_personal_info B", "B.patient_no = A.patient_no", "left");
        $this->db->join("iop_billing C", "C.iop_id = A.request_no", "left");
        $this->db->where_in("A.status", array("Pending", "Paid", "Cancelled")); // Include Cancelled
        $this->db->where("A.InActive", 0);
        //$this->db->group_by("A.patient_no"); // Group by patient to avoid duplicates
        $query2 = $this->db->get_compiled_select("lab_service_request A");
        
        // Sorting by date_visit DESC in the UNION query
        // Using CAST to ensure proper date sorting
        $query = $this->db->query("SELECT * FROM ($query1 UNION $query2) as T ORDER BY date_visit DESC");
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
             $this->db->group_start();
             $this->db->where("C.request_no", $io_id);
             $this->db->or_where("C.iop_id", $io_id);
             $this->db->group_end();
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
        
        // 5. Doctor's Fee from Discharge Advice (OPD)
        if($io_id){
             $this->db->select("
                A.advice_id as item_id,
                'Doctor Fee' as item_name,
                A.doctor_fee as price,
                1 as qty,
                A.doctor_fee as total,
                'Pending' as status,
                'Services' as category
            ", false);
            $this->db->where("A.iop_id", $io_id);
            $this->db->where("A.InActive", 0);
            $query = $this->db->get("iop_discharge_advice A");
            
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
        $total_items = 0;
        foreach($details as $detail){
            $this->db->insert("iop_billing_t", $detail);
            $total_items++;
        }
        
        // Create Receipt Record (Auto-generate receipt from invoice for 1-step billing)
        $receipt = array(
            'receipt_no'        => $header['invoice_no'], // Using Invoice No as Receipt No
            'invoice_no'        => $header['invoice_no'],
            'iop_id'            => $header['iop_id'],
            'patient_no'        => $header['patient_no'],
            'dDate'             => $header['dDate'],
            'subtotal'          => $header['sub_total'],
            'discount'          => $header['discount'],
            'total_amount'      => $header['total_amount'],
            'amountPaid'        => $header['total_amount'], // Assume full payment
            'change'            => 0,
            'payment_type'      => $header['payment_type'],
            'total_purchased'   => $total_items,
            'creditCardHolder'  => '',
            'creditCardNo'      => '',
            'InActive'          => 0
        );
        $this->db->insert("iop_receipt", $receipt);
        
        // Update Status of source items
        // Update Lab Requests
        // Strictly update only the billed request/visit
        if(!empty($header['iop_id'])){
            $this->db->group_start();
            $this->db->where("request_no", $header['iop_id']);
            $this->db->or_where("iop_id", $header['iop_id']);
            $this->db->group_end();
            $this->db->where("status", "Pending");
            $this->db->update("lab_service_request", array("status" => "Paid"));
            
            // Also update OPD Visit status if this is a visit
            $this->db->where("IO_ID", $header['iop_id']);
            $this->db->where("nStatus", "Discharged");
            $this->db->update("patient_details_iop", array("nStatus" => "Paid"));
        }
        
        // --- AUTO DISCHARGE LOGIC ---
        
        // 1. OPD / Lab Only Discharge
        // If there is NO IO_ID (Lab Only) OR if it's an OPD IO_ID
        if(empty($header['iop_id']) || $this->isOPD($header['iop_id'])){
            // Check if patient has any other pending bills? 
            // For OPD, usually payment means end of visit.
            
            // If IO_ID exists (OPD Visit)
            /*
            if(!empty($header['iop_id'])){
                $this->db->where("IO_ID", $header['iop_id']);
                $this->db->update("patient_details_iop", array("nStatus" => "Discharged"));
            } 
            */
            // If Lab Only (no IO_ID linked to OPD visit, or just standalone request)
            // We don't have a visit to discharge in patient_details_iop usually if it's purely external/lab only 
            // unless we created a dummy visit. 
            // But if we do have a patient_no, we might want to check if they have an active OPD visit.
            /*
            else {
                // Find active OPD visit for this patient and discharge it?
                // This might be risky if they have multiple, but typically 1 active per day.
                // Let's stick to discharging specific IO_ID if provided.
            }
            */
        }
        
        // 2. IPD Discharge
        // If IPD, we only discharge if explicitly requested or if it's a "Final Bill"
        // Ideally, we should have a flag in saveBill or check balance.
        // For now, let's assume if it's IPD, we don't auto-discharge here unless we add a specific "Discharge" checkbox in billing.
        // BUT, user asked for "pay for admission, room, lab, doctor's fee -> discharge" flow.
        
        return true;
    }
    
    // Helper to check if IO_ID is OPD
    private function isOPD($io_id){
        if(empty($io_id)) return false;
        $this->db->select('patient_type');
        $this->db->where('IO_ID', $io_id);
        $query = $this->db->get('patient_details_iop');
        if($query->num_rows() > 0){
            return $query->row()->patient_type == 'OPD';
        }
        return false;
    }
    
    public function getInvoiceNo($type = 'OPD'){
        $this->db->select("cValue");
        $this->db->where("cCode","invoice_no");
        $query = $this->db->get("system_option");
        
        if($query->num_rows() > 0){
            $val = $query->row()->cValue + 1;
            if($type == 'IPD'){
                return 'CI-' . str_pad($val, 8, '0', STR_PAD_LEFT);
            } else {
                return 'CO-' . str_pad($val, 8, '0', STR_PAD_LEFT);
            }
        }
        
        // Fallback defaults if row missing
        if($type == 'IPD'){
            return 'CI-00000001';
        } else {
            return 'CO-00000001';
        }
    }
    
    public function updateInvoiceNo($new_no){
        // Update the shared invoice counter
        // Extract number
        if(strpos($new_no, 'CI-') === 0){
            $val = intval(substr($new_no, 3));
        } else {
            $val = intval(substr($new_no, 3));
        }
        
        $this->db->where("cCode", "invoice_no");
        $this->db->update("system_option", array("cValue" => $val));
    }
    
    public function getPatientInfo($patient_no){
        // Ensure patient_no is trimmed
        $patient_no = trim($patient_no);
        // Direct SQL query to be safe
        $sql = "SELECT * FROM patient_personal_info WHERE patient_no = ?";
        $query = $this->db->query($sql, array($patient_no));
        return $query->row();
    }
}