<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Login_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}
	
	public function validate_login(){
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        
		$this->db->select("user_id, username, password");
		$this->db->where(array(
                'username'      =>      $username,
				'InActive'		=>		0
        ));
        $query = $this->db->get('users');
		if($query->num_rows() == 1){
            $user = $query->row();
            
            // Check if password matches (BCRYPT)
            if(password_verify($password, $user->password)){
                return true;
            } 
            // Check if password matches (MD5 - Legacy Support & Auto Upgrade)
            else if($user->password === md5($password)){
                // Password matches old MD5, so we upgrade it to BCRYPT now
                $new_hash = password_hash($password, PASSWORD_BCRYPT);
                $this->db->where('user_id', $user->user_id);
                $this->db->update('users', array('password' => $new_hash));
                return true;
            }
            
            return false;
        }else{
            return false;
        }
	}
	
	public function getMyModule($user_id){
		$this->db->select("B.module");
		$this->db->where("user_id",$user_id);
		$this->db->join("user_roles B","B.role_id = A.user_role","left outer");
		$query = $this->db->get("users A");
		return $query->row();	
	}
	
	
}