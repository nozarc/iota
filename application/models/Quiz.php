<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*  
*/
class Quiz extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database('default');
	}
	public function show_all($id=null)
	{
		return	$this->db
					->select('*,'.$this->db->dbprefix.'analyze.id AS id,'.$this->db->dbprefix.'quiz_answer.id_analyze AS id_analyze,'.$this->db->dbprefix.'quiz_answer.user_id as user_id')
					->join($this->db->dbprefix.'quiz_answer',$this->db->dbprefix.'quiz_answer.id_analyze = '.$this->db->dbprefix.'analyze.id')
					->join($this->db->dbprefix.'test_scores',$this->db->dbprefix.'test_scores.id_analyze='.$this->db->dbprefix.'analyze.id')
					->where(array($this->db->dbprefix.'quiz_answer.user_id'=>$id,'deleted'=>'N'))
					->group_by($this->db->dbprefix.'quiz_answer.id_analyze')
					->get($this->db->dbprefix.'analyze')
					->result();
	}
}