<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		// Load models if needed
	}

	public function mobile($token = ''){
		if(empty($token)){
			show_404();
		}
		
		// Simple Base64 Decode
		$json = base64_decode($token);
		$decoded = json_decode($json);
		
		if(!$decoded || !isset($decoded->case_no) || !isset($decoded->exp)){
			show_error('Invalid Token', 403);
			return;
		}
		
		if(time() > $decoded->exp){
			show_error('Link Expired. Please request a new QR code.', 403);
			return;
		}
		
		$data['token'] = $token;
		$data['case_no'] = $decoded->case_no;
		$data['patient_no'] = $decoded->patient_no;
		$data['error'] = '';
		
		$this->load->view('app/upload/mobile', $data);
	}
	
	public function do_upload(){
		$token = $this->input->post('token');
		
		if(empty($token)){
			show_error('Missing Token', 403);
		}
		
		$json = base64_decode($token);
		$decoded = json_decode($json);
		
		if(!$decoded || time() > $decoded->exp){
			show_error('Link Expired.', 403);
			return;
		}
		
		$config['upload_path'] = './public/uploads/';
		$config['allowed_types'] = 'gif|jpg|png|pdf|jpeg';
		$config['max_size']	= '10000'; // 10MB
		$config['file_name'] = $decoded->case_no . '_' . time();
		
		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$data['error'] = $this->upload->display_errors();
			$data['token'] = $token;
			$data['case_no'] = $decoded->case_no;
			$data['patient_no'] = $decoded->patient_no;
			$this->load->view('app/upload/mobile', $data);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			
			// Save metadata to DB (Optional: iop_consultation_files)
			// $this->db->insert('iop_consultation_files', array(
			//    'iop_id' => $decoded->case_no,
			//    'filename' => $data['upload_data']['file_name'],
			//    'uploaded_at' => date('Y-m-d H:i:s')
			// ));
			
			$this->load->view('app/upload/success', $data);
		}
	}
}
?>