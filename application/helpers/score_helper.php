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
		$scorex=$correct/$count*$data_z['score_scale'];
		$score[$key]['score']=$scorex;
		$x=$data_z['score_scale']/5;
		///alpha score//-->need to improve this 
		for ($i=1; $i <= 5; $i++) { 
			$y=$i*$x;
			$xy=$y/2;
			for ($j=1; $j <= 2; $j++) { 
				$z=$j*$xy;
				$alph[$i][$j]=$z;
			}
		}
		switch (true) {
			case ($scorex<=$alph[1][1]):
				$alpha='E-';
				break;
			case ($alph[1][1]<$scorex and $scorex<=$alph[1][2]):
				$alpha='E';
				break;
			case ($alph[1][2]<$scorex and $scorex<=$alph[2][1]):
				$alpha='D-';
				break;
			case ($alph[2][1]<$scorex and $scorex<=$alph[2][2]):
				$alpha='D';
				break;
			case ($alph[2][2]<$scorex and $scorex<=$alph[3][1]):
				$alpha='C-';
				break;
			case ($alph[3][1]<$scorex and $scorex<=$alph[3][2]):
				$alpha='C';
				break;
			case ($alph[3][2]<$scorex and $scorex<=$alph[4][1]):
				$alpha='B-';
				break;
			case ($alph[4][1]<$scorex and $scorex<=$alph[4][2]):
				$alpha='B';
				break;
			case ($alph[4][2]<$scorex and $scorex<=$alph[5][1]):
				$alpha='A-';
				break;
			case ($alph[5][1]< $scorex and $scorex<=$alph[5][2]):
				$alpha='A';
				break;
		}
		///End of Alpha Score///
	//	$score[$key]['alphax']=$alpha;
		unset($a);
		switch ($method) {
			case 'info':
				$score[$key]['correct']=$correct;
				$score[$key]['alpha']=$alpha;
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
}