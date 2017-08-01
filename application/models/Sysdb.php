<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class Sysdb extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database('default');
	}
	public function sidebar($val=null,$data=null)
	{
		switch ($val) {
			case 'parent':
				return $this->db->group_by('parent')->where('owner',$data)->get($this->db->dbprefix.'sidebar')->result();
				break;
			case 'children':
				return $this->db->where('parent',$data)->get($this->db->dbprefix.'sidebar')->result();
				break;
			default:
				# code...
				break;
		}
	}
}