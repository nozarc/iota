<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
function score($data_x=null,$data_y=null,$data_z=null)
{
	foreach ($data_z as $key => $value) {
		$data_temp[$key]=$value;
	}
	$data_z=$data_temp;
	foreach ($data_x as $key => $val) {
		$score[$key]['id_analyze']=$data_z['id'];
		$score[$key]['user_id']=$val['uid'];
		$wrong_answer=array_diff_assoc($val['answer'], $data_y['answer_key']);
		$diffcount=count($wrong_answer);
		$count=count($data_y['answer_key']);
		$score[$key]['score']=($count-$diffcount)/$count*$data_z['score_scale'];
		/*
		$score[$key]['wrong_answer']=$wrong_answer;
		$score[$key]['diffcount']=$diffcount;
		$score[$key]['count']=$count;
		*/
	}
	return $score;
}