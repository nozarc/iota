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
			$this->load->helper('db_batch','score');
		}
	public function show_all($value=null)
	{
		$where=array('teacher_id' => $value, 'done' => 'Y', 'deleted'=>'N');
		return $this->db
				->select('*,'.$this->db->dbprefix.'analyze.id AS id,'.$this->db->dbprefix.'score_scale.score_scale AS score_scale')
				->join($this->db->dbprefix.'score_scale',$this->db->dbprefix.'score_scale.id='.$this->db->dbprefix.'analyze.score_scale')
				->order_by($this->db->dbprefix.'analyze.id','ASC')
				->where($where)
				->get($this->db->dbprefix.'analyze')
				->result();
	}
	public function show($id=null,$value=null,$target='done')
	{
		switch ($target) {
			case 'notdone':
				$where=array($this->db->dbprefix.'analyze.id'=>$id,'teacher_id' => $value, 'done' => 'N', 'deleted'=>'N');
				return $this->db
						->select('*,'.$this->db->dbprefix.'analyze.id AS id,'.$this->db->dbprefix.'score_scale.score_scale AS score_scale')
						->join($this->db->dbprefix.'score_scale',$this->db->dbprefix.'score_scale.id='.$this->db->dbprefix.'analyze.score_scale')
						->where($where)
						->get($this->db->dbprefix.'analyze')
						->row();
				break;
			case 'done':
				$where=array($this->db->dbprefix.'analyze.id'=>$id,'teacher_id' => $value, 'done' => 'Y', 'deleted'=>'N');
				return $this->db
						->select('*,'.$this->db->dbprefix.'analyze.id AS id,'.$this->db->dbprefix.'score_scale.score_scale AS score_scale')
						->join($this->db->dbprefix.'score_scale',$this->db->dbprefix.'score_scale.id='.$this->db->dbprefix.'analyze.score_scale')
						->where($where)
						->get($this->db->dbprefix.'analyze')
						->row();
				break;		
			default:
				return false;
				break;
		}
	}
	public function get_score_scale($val=null)
		{
			return $this->db->get($this->db->dbprefix.'score_scale');
		}

	public function newanalyze($data=null,$done=null)
		{
			if (empty($done)) {
				$this->db->insert($this->db->dbprefix.'analyze',$data);
			}
			elseif ($done='done') {
				$this->db->where('id',$data)->update($this->db->dbprefix.'analyze',array('done'=>'Y'));
			}
			return true;
		}
	public function updateNew($data=null,$id=null)
		{
			$this->db->where('id',$id)->update($this->db->dbprefix.'analyze',$data);
			return true;
		}
	public function get($where=null)
		{
			return $this->db->get_where($this->db->dbprefix.'analyze',$where)->row();
		}
	public function get_quiz($id=null)
	{
		$where=array('id_analyze'=>$id);
		return $this->db->get_where($this->db->dbprefix.'quiz',$where)->result_array();
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
		$allpeople=$this->db
					->select('*,'.$this->db->dbprefix.'quiz_answer.id AS id')
					->join($this->db->dbprefix.'people',$this->db->dbprefix.'people.uid = '.$this->db->dbprefix.'quiz_answer.user_id')
					->where($where)
					->get($this->db->dbprefix.'quiz_answer')
					->result_array();
		$onlypeople=$this->db
					->select('*,'.$this->db->dbprefix.'quiz_answer.id AS id')
					->join($this->db->dbprefix.'people',$this->db->dbprefix.'people.uid = '.$this->db->dbprefix.'quiz_answer.user_id')
					->group_by('user_id')
					->where($where)
					->get($this->db->dbprefix.'quiz_answer')
					->result_array();
		switch ($get) {
			case 'all':
				return $this->db->get_where($this->db->dbprefix.'quiz_answer',$where)->result_array();
				break;
			case 'allpeople':
				return batch_unbuild($allpeople,$onlypeople,'answer');
				break;
			case 'onlypeople':
				return $onlypeople;
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
				return true;
				break;

			case null:
				$this->db->insert($this->db->dbprefix.'quiz_answer',$value);
				return true;
				break;
		}
	}
	public function upd_answer($value=null)
	{
		foreach ($value as $key => $val) {
			$upd=array('answer'=>$val['answer']);
			$where=array(
							'id_analyze' => $val['id_analyze'],
							'user_id' => $val['user_id'],
							'quiz_number' => $val['quiz_number']
						);
			$this->db->where($where)->update($this->db->dbprefix.'quiz_answer',$upd);
		}
		return true;
	}
	public function get_score($id=null,$for='all')
	{
		switch ($for) {
			case 'all':
				return $this->db->get_where($this->db->dbprefix.'test_scores',array('id_analyze'=>$id))->result();
				break;
			case 'one':
				return $this->db->get_where($this->db->dbprefix.'test_scores',array('user_id'=>$id))->row();
				break;
		}
	}
	public function ins_score($value=null,$method=null)
	{
		switch ($method) {
			case 'batch':
				$this->db->insert_batch($this->db->dbprefix.'test_scores',$value);
				return true;
				break;
			case null:
				$this->db->insert($this->db->dbprefix.'test_scores',$value);
				return true;
				break;
			default:
				return false;
				break;
		}
	}
	public function delete($value=null,$method='soft')
	{
		switch ($method) {
			case 'hard':
				$this->db->where($value)->delete($this->db->dbprefix.'analyze');
				break;
			case 'soft':
				$this->db->where($value)->update($this->db->dbprefix.'analyze',array('deleted'=>'Y'));
				break;
		}
	}
}