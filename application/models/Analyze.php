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
	public function get_quiz($id=null)
	{
		$where=array('id_analyze'=>$id);
		return $this->db->get_where($this->db->dbprefix.'quiz',$where);
	}
	public function ins_quiz($value=null,$method=null)
	{
		switch ($method) {
			case 'batch':
				$value=array_chunk($value, 5);
				foreach ($value as $k => $val) {
					$this->db->insert_batch($this->db->dbprefix.'quiz',$val);
				}
				break;
			case null:
				$this->db->insert($this->db->dbprefix.'quiz',$value);
				break;
		}
		return true;
	}
	public function upd_quiz($value=null,$id=null)
	{
		$this->db->where('id',$id)->update($this->db->dbprefix.'quiz',$value);
		return true;
	}
	public function get_answer($value=null,$get='all',$id=null)
	{
		$where=array('id_analyze'=>$value);
		switch ($get) {
			case 'all':
				return $this->db->get_where($this->db->dbprefix.'quiz_answer',$where)->result_array();
				break;
			case 'allpeople':
				return $this->db
							->select('*,'.$this->db->dbprefix.'quiz_answer.id AS id')
							->join($this->db->dbprefix.'people',$this->db->dbprefix.'people.uid = '.$this->db->dbprefix.'quiz_answer.user_id')
							->where($where)
							->get($this->db->dbprefix.'quiz_answer')
							->result_array();
				break;
			case 'onlypeople':
				return $this->db
							->select('*,'.$this->db->dbprefix.'quiz_answer.id AS id')
							->join($this->db->dbprefix.'people',$this->db->dbprefix.'people.uid = '.$this->db->dbprefix.'quiz_answer.user_id')
							->group_by('user_id')
							->where($where)
							->get($this->db->dbprefix.'quiz_answer')
							->result_array();
				break;
		}
	}
	public function ins_answer($value=null,$method=null)
	{
		switch ($method) {
			case 'batch':
				$value=array_chunk($value, 5);
				foreach ($value as $k => $val) {
					$this->db->insert_batch($this->db->dbprefix.'quiz_answer',$val);
				}
				break;

			case null:
				$this->db->insert($this->db->dbprefix.'quiz_answer',$value);
				break;
		}
	}
}