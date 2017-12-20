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
		$answer=$val['answer'];
		$answer_key=$data_y['answer_key'];
		$wrong_answer=array_diff_assoc($val['answer'], $data_y['answer_key']);
		$diffcount=count($wrong_answer);
		$count=count($answer_key);
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
			case ($scorex<$data_z['min_score']):
				$score[$key]['status']='Didn\'t Pass';
				break;
			case ($scorex>=$data_z['min_score']):
				$score[$key]['status']='Pass';
				
				break;
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
		unset($a);
		switch ($method) {
			case 'info':
				$score[$key]['correct']=$correct;
				$score[$key]['alpha']=$alpha;
				$score[$key]['answer']=$answer;
				$score[$key]['answer_key']=$answer_key;
				break;
		}
	}
	return $score;
}
function analyze($data_x=null,$data_y=null,$data_z=null)
{
	$student=array_merge($data_y['upper'],$data_y['lower']);
	$uppergroup=$data_y['upper'];
	$lowergroup=$data_y['lower'];
	$totalstudent=count($student);
	$totalupper=count($uppergroup);
	$totallower=count($lowergroup);
	foreach ($data_x['answer_key'] as $key => $value) {
		$totalcorrect=0;
		$totalcorrectupper=0;
		$totalcorrectlower=0;
		foreach ($student as $k1 => $v1) {
			if ($value==$v1['answer'][$key]) {
				$totalcorrect=$totalcorrect+1;
			}
		}
		foreach ($uppergroup as $kupper => $vupper) {
			if ($value==$vupper['answer'][$key]) {
				$totalcorrectupper=$totalcorrectupper+1;
			}
		}
		foreach ($lowergroup as $klower => $vlower) {
			if ($value==$vlower['answer'][$key]) {
				$totalcorrectlower=$totalcorrectlower+1;
			}
		}
		$analyze[$key]['totalcorrect']=$totalcorrect;
		$difficult_coefficient=number_format($totalcorrect/$totalstudent, 2);
		$analyze[$key]['difficulty_level']['coefficient']=$difficult_coefficient;
		switch (true) {
			case (0.00<=$difficult_coefficient and $difficult_coefficient<=0.30):
				$analyze[$key]['difficulty_level']['classification']='Difficult';
				break;
			case (0.30<$difficult_coefficient and $difficult_coefficient<=0.70):
				$analyze[$key]['difficulty_level']['classification']='Moderate';
				break;
			case (0.70<$difficult_coefficient and $difficult_coefficient<=1):
				$analyze[$key]['difficulty_level']['classification']='Easy';
				break;
		}
		$analyze[$key]['totalcorrectupper']=$totalcorrectupper;
		$analyze[$key]['totalcorrectlower']=$totalcorrectlower;
		$distinguish_coefficient=number_format(($totalcorrectupper/$totalupper)-($totalcorrectlower/$totallower),2);
		$analyze[$key]['distinguish_power']['coefficient']=$distinguish_coefficient;
		switch (true) {
			case ($distinguish_coefficient<0):
				$analyze[$key]['distinguish_power']['classification']='Awful';
				break;
			case (0<=$distinguish_coefficient and $distinguish_coefficient<=0.30):
				$analyze[$key]['distinguish_power']['classification']='Bad';
				break;
			case (0.30<$distinguish_coefficient and $distinguish_coefficient<=0.40):
				$analyze[$key]['distinguish_power']['classification']='Fair';
				break;
			case (0.40<$distinguish_coefficient and $distinguish_coefficient<=0.70):
				$analyze[$key]['distinguish_power']['classification']='Good';
				break;
			case (0.70<$distinguish_coefficient and $distinguish_coefficient<=1.00):
				$analyze[$key]['distinguish_power']['classification']='Excellent';
				break;
		}
	}

//	$analyze['data_z']=$data_z;
	return $analyze;
}