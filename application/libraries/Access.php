<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*  
*/
class Access
{
	
	function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->load->library('session');
		$this->ci->load->model('login');
		$this->login=&$this->ci->login;
	}
	public function login($username,$password)
	{
		$password=md5($password);
		$result=$this->login->log($username,$password);
		if ($result) {
			$data=	array('sess_username'	=>$result->username,
							'sess_uid'		=>$result->uid,
							'sess_level'	=>$result->level,
							'sess_photo'	=>$result->userphoto
						);
			$this->ci->session->set_userdata($data);
			return true;
		}
		return false;
	}
	public function is_login()
	{
		return $this->ci->session->has_userdata('sess_uid');
	}
	public function level()
	{
		return $this->ci->session->userdata('sess_level');
	}
	public function logout()
	{
		$this->ci->session->sess_destroy();
	}
}