<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Test extends General{
	private $limit = 10;

	function __construct(){
		parent::__construct();
		$this->load->model("general_model");
		
		// Allow template preview without login
		if($this->uri->segment(3) == 'template'){
			 $this->mock_data();
		} else {
			if(General::is_logged_in() == FALSE){
				redirect(base_url().'login');    
			}
			General::variable();
		}
	}

	private function mock_data(){
		// Mock company info
		$this->data['companyInfo'] = (object) array(
			'logo' => 'logo.png',
			'company_name' => 'HIMS Preview'
		);
		
		// Mock user info
		$this->data['userInfo'] = (object) array(
			'firstname' => 'Preview',
			'lastname' => 'User',
			'picture' => '',
			'designation' => 'Administrator'
		);
		
		// Mock access rights (enable all for preview)
		$access_rights = array(
			'hasAccesstoDoctorAvail', 'hasAccesstoBilling', 'hasAccesstoPOS', 'hasAccesstoSurgical',
			'hasAccesstoAppointment', 'hasAccesstoAddAppointment', 'hasAccesstoPatient', 'hasAccesstoAddPatient',
			'hasAccesstoOPDRegistration', 'hasAccesstoOPDEnquiry', 'hasAccesstoIPDRegistration', 'hasAccesstoIPDEnquiry',
			'hasAccesstoRooms', 'hasAccesstoRoomsEnquiry', 'hasAccesstoNurse', 'hasAccesstoNurseBedSide',
			'hasAccesstoNurseInOutTake', 'hasAccesstoNurseIPRoomTransfer', 'hasAccesstoNurseDiagnosis', 'hasAccesstoNurseProgressNote',
			'hasAccesstoNurseDischarge', 'hasAccesstoNursePatientHistory', 'hasAccesstoNurseMedication', 'hasAccesstoNurseVitalSign',
			'hasAccesstoDoctor', 'hasAccesstoDoctorIPD', 'hasAccesstoDoctorOPD', 'hasAccesstoEMR', 'hasAccesstoEMRIPD',
			'hasAccesstoEMROPD', 'hasAccesstoUsers', 'hasAccesstoAddUsers', 'hasAccesstoAdmin', 'hasAccesstoAdminCompanyInfo',
			'hasAccesstoAdminDepartment', 'hasAccesstoAdminDesignation', 'hasAccesstoAdminBillGroupName', 'hasAccesstoAdminParticularBill',
			'hasAccesstoAdminComplain', 'hasAccesstoAdminDiagnosis', 'hasAccesstoAdminSurgicalPack', 'hasAccesstoAdminInsuranceCompany',
			'hasAccesstoAdminMedicineCategory', 'hasAccesstoAdminDrugName', 'hasAccesstoAdminAckReceipt', 'hasAccesstoAdminParameters',
			'hasAccesstoAdminBackup', 'hasAccesstoAdminPages', 'hasAccesstoReport', 'hasAccesstoReportPatient', 'hasAccesstoReportIndividualPatient',
			'hasAccesstoReportOPD', 'hasAccesstoReportAdmitted', 'hasAccesstoReportDischarge', 'hasAccesstoReportDailySales',
			'hasAccesstoReportDoctorsFee', 'hasAccesstoReportAR'
		);
		
		foreach($access_rights as $right){
			$this->data[$right] = TRUE;
		}
		
		// Other required vars
		$this->data['UserTitles'] = array();
		$this->data['gender'] = array();
		$this->data['civilStatus'] = array();
		$this->data['departmentList'] = array();
		$this->data['designationList'] = array();
		$this->data['userRoleList'] = array();
		$this->data['roomTypeList'] = array();
		$this->data['floorList'] = array();
		$this->data['roomMasterList'] = array();
		$this->data['bloodGroup'] = array();
		$this->data['religionList'] = array();
		$this->data['doctorList'] = array();
		$this->data['doctorList2'] = array();
		$this->data['insuranceCompList'] = array();
		$this->data['patientListRows'] = array();
	}
	
	public function index(){
		$this->test();	
	}
	public function test(){
		$this->load->view('app/test/index',$this->data);	
	}
	
	public function template(){
		$this->session->set_userdata(array(
				 'tab'			=>		'',
				 'module'		=>		'',
				 'subtab'		=>		'',
				 'submodule'	=>		''));
		$this->load->view('app/control_panel_template',$this->data);	
	}
}