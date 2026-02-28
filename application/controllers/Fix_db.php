<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fix_db extends CI_Controller {
    public function index(){
        $this->load->database();
        $this->db->query("ALTER TABLE iop_diagnosis MODIFY COLUMN iop_id VARCHAR(50)");
        echo "Table iop_diagnosis updated.<br>";
        
        $this->db->query("ALTER TABLE iop_complaints MODIFY COLUMN iop_id VARCHAR(50)");
        echo "Table iop_complaints updated.<br>";
        
        $this->db->query("ALTER TABLE iop_medication MODIFY COLUMN iop_id VARCHAR(50)");
        echo "Table iop_medication updated.<br>";
        
        $this->db->query("ALTER TABLE iop_vital_parameters MODIFY COLUMN iop_id VARCHAR(50)");
        echo "Table iop_vital_parameters updated.<br>";
        
        $this->db->query("ALTER TABLE iop_nurse_notes MODIFY COLUMN iop_id VARCHAR(50)");
        echo "Table iop_nurse_notes updated.<br>";
        
        $this->db->query("ALTER TABLE iop_progress_note MODIFY COLUMN iop_id VARCHAR(50)");
        echo "Table iop_progress_note updated.<br>";
        
        $this->db->query("ALTER TABLE iop_bed_side_procedure MODIFY COLUMN iop_id VARCHAR(50)");
        echo "Table iop_bed_side_procedure updated.<br>";
        
        $this->db->query("ALTER TABLE iop_laboratory MODIFY COLUMN iop_id VARCHAR(50)");
        echo "Table iop_laboratory updated.<br>";
        
        $this->db->query("ALTER TABLE iop_operation_theater MODIFY COLUMN iop_id VARCHAR(50)");
        echo "Table iop_operation_theater updated.<br>";
        
        $this->db->query("ALTER TABLE iop_discharge_summary MODIFY COLUMN iop_id VARCHAR(50)");
        echo "Table iop_discharge_summary updated.<br>";
    }
}
