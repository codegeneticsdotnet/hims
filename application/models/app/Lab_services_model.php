<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Lab_services_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}
	
	public function getRequestIdByNo($no){
        $this->db->select('request_id');
        $this->db->where('request_no', $no);
        $query = $this->db->get('lab_service_request');
        if($query->num_rows() > 0){
            return $query->row()->request_id;
        }
        return false;
    }

    public function getRequests($limit = 10, $offset = 0){
		$this->db->select("
			A.request_id,
			A.request_no,
			A.request_date,
			A.request_type,
			A.status,
			A.patient_no,
			concat(B.firstname,' ',B.lastname) as patient_name,
			(SELECT count(*) FROM lab_service_request_details WHERE request_id = A.request_id AND InActive = 0) as item_count,
			(SELECT sum(total_amount) FROM lab_service_request_details WHERE request_id = A.request_id AND InActive = 0) as total_amount
		", false);
		
		// Date Filter
		if($this->input->post('cFrom') && $this->input->post('cTo')){
			$this->db->where("A.request_date BETWEEN '".$this->input->post('cFrom')." 00:00:00' AND '".$this->input->post('cTo')." 23:59:59'");
		} else {
			// Default to previous day to current day if no filter provided (handled in controller usually, but good fallback)
            // But strict to what's posted
		}

        if($this->input->post('search')){
            $search = $this->input->post('search');
            $this->db->group_start();
            $this->db->like('A.request_no', $search);
            $this->db->or_like('A.patient_no', $search);
            $this->db->or_like('B.firstname', $search);
            $this->db->or_like('B.lastname', $search);
            $this->db->group_end();
        }

		$this->db->where('A.InActive', 0);
		$this->db->join("patient_personal_info B", "B.patient_no = A.patient_no", "left");
		$this->db->order_by('A.request_date', 'DESC');
		
		$query = $this->db->get("lab_service_request A", $limit, $offset);
		return $query->result();
	}
	
	public function count_all(){
		$this->db->where('InActive', 0);
        
        // Date Filter
		if($this->input->post('cFrom') && $this->input->post('cTo')){
			$this->db->where("request_date BETWEEN '".$this->input->post('cFrom')." 00:00:00' AND '".$this->input->post('cTo')." 23:59:59'");
		}

         if($this->input->post('search')){
            $search = $this->input->post('search');
            $this->db->group_start();
            $this->db->like('request_no', $search);
            $this->db->or_like('patient_no', $search);
            // Can't easily join in count_all usually in CI unless using Active Record fully before get
            // But for simple count, let's stick to base table or do a join if needed.
            // Simplified for now.
             $this->db->group_end();
        }

		return $this->db->count_all_results("lab_service_request");
	}

    public function getRequestDetails($id){
        $this->db->select("
            A.*,
            B.particular_name,
            B.particular_desc
        ");
        $this->db->from("lab_service_request_details A");
        $this->db->join("bill_particular B", "B.particular_id = A.particular_id", "left");
        $this->db->where("A.request_id", $id);
        $this->db->where("A.InActive", 0);
        return $this->db->get()->result();
    }
    
    public function updateDetailStatus($detail_id, $status, $remarks){
        $this->db->where('detail_id', $detail_id);
        $this->db->update('lab_service_request_details', array(
            'status' => $status,
            'result_remarks' => $remarks
        ));
    }

    public function getRequestHeader($id){
        $this->db->select("
            A.*,
            concat(B.firstname,' ',B.lastname) as patient_name,
            B.age,
            B.gender
        ");
        $this->db->from("lab_service_request A");
        $this->db->join("patient_personal_info B", "B.patient_no = A.patient_no", "left");
        $this->db->where("A.request_id", $id);
        return $this->db->get()->row();
    }
	
	public function generateRequestNo($type){
        // Prefix map
        $prefix = '';
        if($type == 'Laboratory') $prefix = 'L';
        else if($type == 'X-ray') $prefix = 'X';
        else if($type == 'Ultrasound') $prefix = 'U';
        else return false;

        $this->db->select('request_no');
        $this->db->where('request_type', $type);
        $this->db->like('request_no', $prefix, 'after');
        $this->db->order_by('request_id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('lab_service_request');

        if($query->num_rows() > 0){
            $row = $query->row();
            $last_no = $row->request_no;
            // Extract number part (assuming L00000001 format)
            $num = (int) substr($last_no, 1);
            $new_num = $num + 1;
        } else {
            $new_num = 1;
        }

        return $prefix . str_pad($new_num, 8, '0', STR_PAD_LEFT);
    }

    public function getParticulars($search, $category){
        $this->db->select('particular_id, particular_name, charge_amount');
        $this->db->from('bill_particular A');
        $this->db->join('bill_group_name B', 'B.group_id = A.group_id');
        $this->db->like('A.particular_name', $search);
        
        // Filter by category name
        // The user selects "Laboratory", "X-ray", "Ultrasound"
        // We match this against bill_group_name.group_name
        // Using LIKE to be safe or EXACT match if we are sure
        $this->db->like('B.group_name', $category);
        
        $this->db->where('A.InActive', 0);
        $this->db->limit(10);
        return $this->db->get()->result();
    }

    public function saveRequest(){
        $this->db->trans_start();

        // Header
        $data = array(
            'request_no' => $this->input->post('request_no'),
            'patient_no' => $this->input->post('patient_no'),
            'request_date' => date('Y-m-d H:i:s'),
            'request_type' => $this->input->post('service_category'),
            'remarks' => $this->input->post('remarks'),
            'status' => 'Pending',
            'created_by' => $this->session->userdata('user_id'), // Assuming user_id is in session
            'created_date' => date('Y-m-d H:i:s'),
            'InActive' => 0
        );
        $this->db->insert('lab_service_request', $data);
        $request_id = $this->db->insert_id();

        // Details
        $particulars = $this->input->post('particular_id'); // Array
        $qtys = $this->input->post('qty'); // Array
        $amounts = $this->input->post('amount'); // Array
        $discounts = $this->input->post('discount'); // Array
        $discount_remarks = $this->input->post('discount_remarks'); // Array
        $totals = $this->input->post('total_amount'); // Array

        if(is_array($particulars)){
            foreach($particulars as $key => $val){
                if(!empty($val)){
                    $detail_data = array(
                        'request_id' => $request_id,
                        'particular_id' => $val,
                        'qty' => $qtys[$key],
                        'amount' => $amounts[$key],
                        'discount' => $discounts[$key],
                        'discount_remarks' => $discount_remarks[$key],
                        'total_amount' => $totals[$key],
                        'InActive' => 0
                    );
                    $this->db->insert('lab_service_request_details', $detail_data);
                }
            }
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }
    
    public function getReports($from, $to){
        $this->db->select("
            A.request_id,
            A.request_no,
            A.request_date,
            A.request_type,
            A.status,
            A.patient_no,
            concat(B.firstname,' ',B.lastname) as patient_name,
            (SELECT sum(total_amount) FROM lab_service_request_details WHERE request_id = A.request_id AND InActive = 0) as total_amount
        ", false);
        
        $this->db->where("DATE(A.request_date) >=", $from);
        $this->db->where("DATE(A.request_date) <=", $to);
        $this->db->where('A.InActive', 0);
        $this->db->join("patient_personal_info B", "B.patient_no = A.patient_no", "left");
        $this->db->order_by('A.request_date', 'ASC');
        
        $query = $this->db->get("lab_service_request A");
        return $query->result();
    }
    
    public function updateStatus($id, $status){
        $this->db->where('request_id', $id);
        $this->db->update('lab_service_request', array('status' => $status));
    }
}
