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
	public function ins_questions($value=null,$id=null)
	{
		$questions=$this->batch_builder($value,$id);
		$this->db->insert_batch($this->db->dbprefix.'test_questions',$questions);
		return true;
	}
	public function batch_builder($val=null,$id=null)
		{
			if($val!=null)
			{
				$arr=array();
				$arrcount=count($val['answer_key']);
				for ($arrnum=1; $arrnum <= $arrcount; $arrnum++) { 
					$arrx=array();
					$arrx['id_analyze']=$id;
					$arrx['q_number']=$arrnum;
					$arrx['answer_key']=$val['answer_key'][$arrnum];
					$arrx['question']=$val['question'][$arrnum];
					$arrx['measured_capability']=$val['measured_capability'][$arrnum];
					array_push($arr,$arrx);
				}
				return $arr;
			}
			else 
			{
				return false;
			}
		}
}