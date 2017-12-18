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
		}
	}
	return $score;
}
function analyze($data_x=null,$data_y=null)
{
	$totalstudent=count($data_y);
	foreach ($data_x as $key => $value) {
		$totalcorrect=0;
		foreach ($data_y as $k1 => $v1) {
			if ($value==$v1['answer'][$key]) {
				$totalcorrect=$totalcorrect+1;
			}
		}
		$analyze[$key]['totalcorrect']=$totalcorrect;
		$coefficient=number_format($totalcorrect/$totalstudent, 2);
		$analyze[$key]['coefficient']=$coefficient;
		switch (true) {
			case (0.00<=$coefficient and $coefficient<=0.30):
				$analyze[$key]['classification']='Difficult';
				break;
			case (0.30<$coefficient and $coefficient<=0.70):
				$analyze[$key]['classification']='Moderate';
				break;
			case (0.70<$coefficient and $coefficient<=1):
				$analyze[$key]['classification']='Easy';
				break;
		}
	}
	
	return $analyze;
}