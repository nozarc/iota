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
			$this->load->helper('db_batch');
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
	public function updateNew($data=null,$id=null)
		{
			$this->db->where('id',$id)->update($this->db->dbprefix.'analyze',$data);
			return true;
		}
	public function get($where=null)
		{
			return $this->db->get_where($this->db->dbprefix.'analyze',$where);
		}
	public function get_quests($id=null)
	{
		$where=array('id_analyze'=>$id);
		return $this->db->get_where($this->db->dbprefix.'test_questions',$where);
	}
	public function ins_question($value=null,$method=null)
	{
		switch ($method) {
			case 'batch':
				$this->db->insert_batch($this->db->dbprefix.'test_questions',$value);
				break;
			case null:
				$this->db->insert($this->db->dbprefix.'test_questions',$value);
				break;
		}
		return true;
	}
	public function upd_question($value=null,$id=null)
	{
		$this->db->where('id',$id)->update($this->db->dbprefix.'test_questions',$value);
		return true;
	}
}