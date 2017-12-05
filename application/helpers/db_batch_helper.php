<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
function batch_build($val=null,$id=null)
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