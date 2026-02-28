<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Pharmacy extends General{
	private $limit = 10;

	function __construct(){
		parent::__construct();
		$this->load->model("app/pharmacy_model");
		$this->load->model("app/Drug_name_model");
		$this->load->model("general_model");
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}
	
	public function index(){
		$this->pharmacy();	
	}
    // Item Management
    public function items(){
        $this->session->set_userdata(array(
            'tab'           =>      'pharmacy',
            'module'        =>      'items',
            'subtab'        =>      '',
            'submodule'     =>      ''));
            
        $this->data['items'] = $this->pharmacy_model->getItems(1000); 
        $this->data['categories'] = $this->Drug_name_model->getCategory();
        $this->data['units'] = $this->Drug_name_model->getUOM();
        
        $this->load->view('app/pharmacy/items', $this->data);
    }
    
    public function save_item(){
        $this->form_validation->set_rules("item_name", "Item Name", "required");
        $this->form_validation->set_rules("category", "Category", "required");
        
        if($this->form_validation->run()){
            $data = array(
                'drug_name'         => strtoupper($this->input->post('item_name')),
                'drug_desc'         => $this->input->post('generic_name'),
                'med_cat_id'        => $this->input->post('category'),
                'uom'               => $this->input->post('unit') ? $this->input->post('unit') : 0, // Ensure not null
                'nPrice'            => $this->input->post('price'),
                're_order_level'    => $this->input->post('reorder_level'),
                'cType'             => 0, // Default value for cType
                'InActive'          => 0
            );
            
            // Check if Edit or Add
            $id = $this->input->post('item_id');
            if($id){
                $this->db->where('drug_id', $id);
                $this->db->update('medicine_drug_name', $data);
                $this->session->set_flashdata('message', 'Item updated successfully!');
            } else {
                // Initial Stock (Optional, usually 0)
                $data['nStock'] = 0; 
                $this->db->insert('medicine_drug_name', $data);
                $new_id = $this->db->insert_id();
                $this->session->set_flashdata('message', 'Item added successfully!');
                $this->session->set_flashdata('new_item_id', $new_id);
            }
            
            // Redirect based on source
            if($this->input->post('redirect_to') == 'inventory_in'){
                redirect(base_url().'app/pharmacy/inventory_in');
            } else {
                redirect(base_url().'app/pharmacy/items');
            }
        } else {
            $this->items();
        }
    }
    
    public function delete_item($id){
        $this->db->where('drug_id', $id);
        $this->db->update('medicine_drug_name', array('InActive' => 1));
        $this->session->set_flashdata('message', 'Item deleted successfully!');
        redirect(base_url().'app/pharmacy/items');
    }
    
    public function update_item_price(){
        $item_id = $this->input->post('item_id');
        $price = $this->input->post('price');
        
        $this->db->where('drug_id', $item_id);
        $this->db->update('medicine_drug_name', array('nPrice' => $price));
        
        echo json_encode(array('status' => true));
    }
    
    // Inventory In
    public function inventory_in(){
         $this->session->set_userdata(array(
             'tab'           =>      'pharmacy',
             'module'        =>      'inventory_in',
             'subtab'        =>      '',
             'submodule'     =>      ''));
             
         $this->data['ref_no'] = $this->pharmacy_model->getInventoryRefNo();
         // Load recent inventory entries
         $this->data['recent_inventory'] = $this->pharmacy_model->getRecentInventory(5);
         
         // Load Categories and Units for Add Item Modal
         $this->load->model('app/drug_name_model');
         $this->data['categories'] = $this->drug_name_model->getCategory();
         $this->data['units'] = $this->drug_name_model->getUOM();
         
         $this->load->view('app/pharmacy/inventory_in', $this->data);
     }
     
     public function save_inventory_in(){
         $this->form_validation->set_rules("ref_no", "Reference No", "required");
         $this->form_validation->set_rules("supplier_name", "Supplier Name", "required"); // Made required
         
         if($this->form_validation->run()){
             $ref_no = $this->input->post('ref_no');
             
             $header = array(
                 'ref_no' => $ref_no,
                 'date_received' => date('Y-m-d H:i:s'),
                 'supplier_name' => $this->input->post('supplier_name'),
                 'remarks' => $this->input->post('remarks'),
                 'InActive' => 0
             );
             
             $items = $this->input->post('item_id');
             $qtys = $this->input->post('qty');
             $batch_nos = $this->input->post('batch_no');
             $expiry_dates = $this->input->post('expiry_date');
             
             $details = array();
             
             if($items){
                 foreach($items as $key => $id){
                     $details[] = array(
                         'drug_id' => $id,
                         'item_name' => $this->input->post('item_name')[$key],
                         'qty' => $qtys[$key],
                         'batch_no' => $batch_nos[$key],
                         'expiry_date' => $expiry_dates[$key],
                         'InActive' => 0
                     );
                 }
             }
             
             $inv_id = $this->pharmacy_model->saveInventoryIn($header, $details);
             $this->pharmacy_model->updateInventoryRefNo($ref_no);
             
             $this->session->set_flashdata('message', 'Stock added successfully!');
             $this->session->set_flashdata('print_inv_id', $inv_id);
             redirect(base_url().'app/pharmacy/inventory_in');
         } else {
             redirect(base_url().'app/pharmacy/inventory_in');
         }
     }
    
    public function get_inventory_summary(){
        $summary = $this->pharmacy_model->getInventorySummary();
        echo json_encode($summary);
    }

    public function get_inventory_details($inv_id){
        $details = $this->pharmacy_model->getInventoryDetails($inv_id);
        echo json_encode($details);
    }
    
    public function print_inventory($inv_id){
        $this->data['header'] = $this->pharmacy_model->getInventoryHeader($inv_id);
        $this->data['details'] = $this->pharmacy_model->getInventoryDetails($inv_id);
        $this->load->view('app/pharmacy/print_inventory', $this->data);
    }
    
    // POS Functionality
    public function pos(){
        $this->data['invoice_no'] = $this->pharmacy_model->getPOSInvoiceNo();
        $this->load->view('app/pharmacy/pos', $this->data);
    }
    
    public function get_items($keyword = ''){
        $keyword = urldecode($keyword);
        $items = $this->pharmacy_model->searchItems($keyword);
        echo json_encode($items);
    }
    
    public function search_patient($keyword = ''){
        $keyword = urldecode($keyword);
        $this->db->select("patient_no, CONCAT(lastname, ', ', firstname) as patient_name", FALSE);
        $this->db->like("lastname", $keyword);
        $this->db->or_like("firstname", $keyword);
        $this->db->limit(10);
        $query = $this->db->get("patient_personal_info");
        echo json_encode($query->result());
    }
    
    public function search_ipd_patient($keyword = ''){
        $keyword = urldecode($keyword);
        $this->db->select("
            A.patient_no, 
            A.IO_ID,
            CONCAT(B.lastname, ', ', B.firstname) as patient_name
        ", FALSE);
        $this->db->join("patient_personal_info B", "B.patient_no = A.patient_no", "left");
        $this->db->where("A.patient_type", "IPD");
        $this->db->where("A.nStatus", "Pending");
        $this->db->where("A.InActive", 0);
        $this->db->group_start();
        $this->db->like("B.lastname", $keyword);
        $this->db->or_like("B.firstname", $keyword);
        $this->db->or_like("A.IO_ID", $keyword);
        $this->db->group_end();
        $this->db->limit(10);
        $query = $this->db->get("patient_details_iop A");
        echo json_encode($query->result());
    }
    
    public function save_pos(){
        // Validation
        $this->form_validation->set_rules("total_amount", "Total Amount", "required");
        
        if($this->form_validation->run()){
            $invoice_no = $this->input->post('invoice_no');
            $payment_type = $this->input->post('payment_type');
            
            $header = array(
                'invoice_no' => $invoice_no,
                'date_sale' => date('Y-m-d H:i:s'),
                'patient_no' => $this->input->post('patient_no'), // Optional
                'patient_name' => $this->input->post('patient_name'), // Optional
                'sub_total' => $this->input->post('total_amount'),
                'discount' => $this->input->post('discount'),
                'total_amount' => $this->input->post('net_total'),
                'remarks' => $this->input->post('remarks'),
                'payment_type' => $payment_type,
                'InActive' => 0
            );
            
            $items = $this->input->post('item_id');
            $qtys = $this->input->post('qty');
            $prices = $this->input->post('price');
            $details = array();
            
            // For IPD Billing
            $iop_id = $this->input->post('iop_id');
            $ipd_meds = array();
            
            if($items){
                foreach($items as $key => $id){
                    $details[] = array(
                        'drug_id' => $id,
                        'item_name' => $this->input->post('item_name')[$key],
                        'qty' => $qtys[$key],
                        'price' => $prices[$key],
                        'total' => $qtys[$key] * $prices[$key],
                        'InActive' => 0
                    );
                    
                    if($payment_type == 'Charge' && $iop_id){
                        $ipd_meds[] = array(
                            'iop_id' => $iop_id,
                            'medicine_id' => $id,
                            'total_qty' => $qtys[$key],
                            'dDate' => date('Y-m-d h:i:s'),
                            'cPreparedBy' => $this->session->userdata('user_id'),
                            'InActive' => 0
                        );
                    }
                }
            }
            
            $sale_id = $this->pharmacy_model->savePOS($header, $details, $ipd_meds);
            $this->pharmacy_model->updatePOSInvoiceNo($invoice_no);
            
            // Redirect to print
            $this->session->set_flashdata('message', 'Transaction Successful!');
            redirect(base_url().'app/pharmacy/print_pos/'.$sale_id);
        } else {
             redirect(base_url().'app/pharmacy/pos');
        }
    }
    
    public function print_pos($sale_id){
        $this->data['header'] = $this->pharmacy_model->getPOSHeader($sale_id);
        $this->data['details'] = $this->pharmacy_model->getPOSDetails($sale_id);
        
        // Load Company Info if not in session (optional check)
        if(!$this->session->userdata('company_name')){
             $this->db->select("*");
             // $this->db->where("inActive", 0); // Removed as column might not exist
             $company = $this->db->get("company_info")->row();
             if($company){
                 $this->session->set_userdata('company_name', $company->company_name);
                 $this->session->set_userdata('company_address', $company->company_address);
                 $this->session->set_userdata('company_contact', $company->company_contactNo);
                 //$this->session->set_userdata('company_email', $company->company_email);
             }
        }
        
        $this->load->view('app/pharmacy/print_pos', $this->data);
    }
	
	public function pharmacy(){
		$this->session->set_userdata(array(
			'tab'			=>		'',
			'module'		=>		'',
			'subtab'		=>		'',
			'submodule'	=>		''));
		   // user restriction function
		   $this->session->set_userdata('page_name','receipt_lists');
		   $page_id = $this->general_model->getPageID();
		   $userRole = $this->general_model->getUserLoggedIn($this->session->userdata('username'));
		   //if(General::has_rights_to_access($page_id->page_id,$userRole->user_role) == FALSE){
			//	   redirect(base_url().'access_denied');
		   //}
		   // end of user restriction function		 	
		$this->load->view('app/pharmacy/index',$this->data);	
	}

	//for item table list
	public function tableitems(){
		//pass value to session
		$this->session->set_userdata("search_item",$this->input->post('catitem'));	
		$this->data['items'] = $this->pharmacy_model->getItems($this->limit);
		$this->data['tabletoload'] = "tableitems";
		$this->load->view('app/pharmacy/viewtables',$this->data);	
	}

	//for category table list
	public function tablecategory(){
		//pass value to session
		$this->session->set_userdata("search_category",$this->input->post('catsearch'));	
		$this->data['categories'] = $this->pharmacy_model->getCategory($this->limit);
		$this->data['tabletoload'] = "tablecategory";
		$this->load->view('app/pharmacy/viewtables',$this->data);	
	}

	//for category table list
	public function tableunit(){
		//pass value to session
		$this->session->set_userdata("search_unit",$this->input->post('unitsearch'));	
		$this->data['units'] = $this->pharmacy_model->getUnit($this->limit);
		$this->data['tabletoload'] = "tableunit";
		$this->load->view('app/pharmacy/viewtables',$this->data);	
	}

	// save category
	public function savecategory(){
		$this->form_validation->set_rules("cCategory","Category Name","trim|xss_clean|required");	
		$this->form_validation->set_rules("cDescription","Category Description","trim|xss_clean|required");	
		$data = (object)[];
		$data->status = "";
		$data->message = "";
		if($this->form_validation->run()){
			//save the data
			$added = $this->pharmacy_model->saveCategory();
			if($added){
				$data->status = "SUCCESS";
			}else{
				$data->status = "ERROR";
			}
		}else{
			$validate = "";
			$data->status = "NOTVALID";
			if(form_error('cCategory')){
				$validate .= "<br /> * Category Name";
			}
			if(form_error('cDescription')){
				$validate .= "<br /> * Category Description";
			}
			$data->message = $validate;
		}	
		echo json_encode($data);
	}

	// save unit
	public function saveunit(){
		$this->form_validation->set_rules("cUnit","Unit Name","trim|xss_clean|required");	
		$this->form_validation->set_rules("cUnitDescription","Unit Description","trim|xss_clean|required");	
		$data = (object)[];
		$data->status = "";
		$data->message = "";
		if($this->form_validation->run()){
			//TODO: Check for Duplicate
			//save the data
			$added = $this->pharmacy_model->saveUnit();
			if($added){
				$data->status = "SUCCESS";
			}else{
				$data->status = "ERROR";
			}
		}else{
			$validate = "";
			$data->status = "NOTVALID";
			if(form_error('cUnit')){
				$validate .= "<br /> * Unit Name";
			}
			if(form_error('cUnitDescription')){
				$validate .= "<br /> * Unit Description";
			}
			$data->message = $validate;
		}	
		echo json_encode($data);
	}

	//for category ajax
	public function fillcategory(){
		//pass value to session
		$this->session->set_userdata("search_category",$this->input->post('search'));	
		$this->data['items'] = $this->pharmacy_model->getCategory($this->limit);
		$response = array();
		foreach ($this->data['items'] as $item){
			$value = $item->param_id;
			$value .= "$$" . $item->categoryname;
			$value .= "$$" . $item->categorydesc;
			$item = $item->categoryname; 
			$response[] = array("id"=>$value,"name"=>$item);
		}
		echo json_encode($response);
	}
	//for category ajax
	public function fillunit(){
		//pass value to session
		$this->session->set_userdata("search_unit",$this->input->post('search'));	
		$this->data['items'] = $this->pharmacy_model->getUnit($this->limit);
		$response = array();
		foreach ($this->data['items'] as $item){
			$value = $item->param_id;
			$value .= "$$" . $item->unitname;
			$value .= "$$" . $item->unitdesc;
			$item = $item->unitname; 
			$response[] = array("id"=>$value,"name"=>$item);
		}
		echo json_encode($response);
	}


	//for category ajax
	public function filllcategory(){
		//pass value to session
		$this->session->set_userdata("search_category",$this->input->post('search'));	
		$this->data['items'] = $this->pharmacy_model->getCategory($this->limit);
		$results = array();
		foreach ($this->data['items'] as $item){
			$value = $item->param_id;
			$value .= "$$" . $item->categoryname;
			$value .= "$$" . $item->categorydesc;
			$item = $item->categoryname; 
			$results[] = array("id"=>$value,"text"=>$item);
		}
		$response = array(
			"results" => $results,
			"pagination" => array("more" => false)
		);
		header('Content-Type: application/json');
		echo json_encode($response);
	}
	public function filllunit(){
		//pass value to session
		$this->session->set_userdata("search_unit",$this->input->post('search'));	
		$this->data['items'] = $this->pharmacy_model->getUnit($this->limit);
		$results = array();
		foreach ($this->data['items'] as $item){
			$value = $item->param_id;
			$value .= "$$" . $item->unitname;
			$value .= "$$" . $item->unitdesc;
			$item = $item->unitname; 
			$results[] = array("id"=>$value,"text"=>$item);
		}
		$response = array(
			"results" => $results,
			"pagination" => array("more" => false)
		);
		header('Content-Type: application/json');
		echo json_encode($response);
	}
}