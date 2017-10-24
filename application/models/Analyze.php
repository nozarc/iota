<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class Analyze extends CI_Model
{
	
	function __construct()
		{
			parent::__construct();
			$this->load->database('default');
		}

	public function get_score_scale($val=null)
		{
			return $this->db->get($this->db->dbprefix.'score_scale');
		}
	public function new($data=null)
		{
			$this->db->insert($this->db->dbprefix.'analyze',$data);
			return true;
		}
	public function get($where=null)
		{
			return $this->db->get_where($this->db->dbprefix.'analyze',$where);
		}	
}