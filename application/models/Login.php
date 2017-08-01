<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*  
*/
class Login extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database('default');
	}
	public function log($username,$pass)
	{
		$r=$this->db->select('*')
			->join($this->db->dbprefix.'people',$this->db->dbprefix.'people.uid = '.$this->db->dbprefix.'user.uid','left')
			->where($this->db->dbprefix.'user.username',$username)
			->where($this->db->dbprefix.'user.password',$pass)
			->get($this->db->dbprefix.'user');
		//$this->db->get_where($this->db->dbprefix.'user',array('username'=>$username,'password'=>$pass));
		return ($r->num_rows()>0)?$r->row():false;
	}
}