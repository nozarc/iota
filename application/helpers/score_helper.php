<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
function score($data_x=null,$data_y=null,$data_z=null,$method=null)
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
		$correct=$count-$diffcount;
		$score[$key]['score']=$correct/$count*$data_z['score_scale'];
		switch ($method) {
			case 'info':
				$score[$key]['correct']=$correct;
				break;
			
			default:
				# code...
				break;
		}
		/*
		$score[$key]['wrong_answer']=$wrong_answer;
		$score[$key]['diffcount']=$diffcount;
		$score[$key]['count']=$count;
		*/
	}
	return $score;
	$x=$data_z['score_scale']/5;
		for ($i=1; $i <= 5; $i++) { 
			$y=$i*$x;
			$xy=$y/2;
			for ($j=1; $j <= 2; $j++) { 
				$z=$j*$xy;
			@	$a.=", $z";
			}
		}
		//test this and combine with switch
}