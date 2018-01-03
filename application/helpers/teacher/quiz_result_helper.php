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
				$status='Didn\'t Pass';
				break;
			case ($scorex>=$data_z['min_score']):
				$status='Pass';
				
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
				$score[$key]['status']=$status;
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
	$student=$data_y['all'];
	$uppergroup=$data_y['upper'];
	$lowergroup=$data_y['lower'];
	$totalstudent=count($student);
	$totalupper=count($uppergroup);
	$totallower=count($lowergroup);

	foreach ($data_x['answer_key'] as $key => $value) {
		$total_correct_student=0;
		$totalcorrectupper=0;
		$totalcorrectlower=0;
		$student_score=array();
		$total_quiz_score=0;
		$total_all_score=0;
		$sum_X=0;
		//part of validity test
		
		//end of part of validity test

		///difficulty level//
		foreach ($student as $k1 => $v1) {
			
			//part of validity test
			$total_all_score=$total_all_score+$v1['score'];
			//end of part of validity test
			
			if ($value==$v1['answer'][$key]) {
				$total_correct_student=$total_correct_student+1;
				$analyze[$key]['correct_student'][]=$v1['user_id'];

				//part of validity test
				$student_score[$v1['user_id']]=$v1['score'];
				$total_quiz_score=$v1['score']+$total_quiz_score;
				//end of part of validity test
			
			}
		}

		$analyze[$key]['total_correct_student']=$total_correct_student;
		$difficult_coefficient=number_format($total_correct_student/$totalstudent, 2);
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
		///end of difficulty level////////////

		///distinguish power//////
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
		$analyze[$key]['totalcorrectupper']=$totalcorrectupper;
		$analyze[$key]['totalupper']=$totalupper;
		$analyze[$key]['totalcorrectlower']=$totalcorrectlower;
		$analyze[$key]['totallower']=$totallower;
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
		///end of distinguish ////
		//validity test
		if ($total_correct_student!=0) {
			$Mp=$total_quiz_score/$total_correct_student;
		}
		else{
			$Mp=0;
		}
		if ($total_all_score!=0) {
			$Mt=$total_all_score/$totalstudent;
		}
		else{
			$Mt=0;
		}
		foreach ($student as $k2 => $v2) {
			$x_sqrd=pow(($v2['score']-$Mt),2);
			$X_sqrd[$v2['user_id']]=$x_sqrd;
			$sum_X=$x_sqrd+$sum_X;
		}
		$p=$total_correct_student/$totalstudent;
		$q=1-$p;
	@	$sqrtpq=sqrt($p/$q); //warning, division by zero, seharusnya engga karena berupa desimal bukan 0
		$St=sqrt($sum_X/$totalstudent);
		$df=$totalstudent-2;
		$Rpbi=(($Mp-$Mt)/$St)*$sqrtpq;
		$t_table=PHPExcel_Calculation_Statistical::TINV((5/100),$df); // you need to load excel library first
	@	$r_table=$t_table/sqrt($df+pow($t_table,2));
		if (@$Rpbi>$r_table) {
			$validity='Valid';
		}
		else $validity='Invalid';
		$analyze[$key]['validity']['coefficient']=number_format($Rpbi,4);
		$analyze[$key]['r_table']=$r_table;
		$analyze[$key]['validity']['classification']=$validity;
		///end of validity test
		//log for debugging
		$analyze[$key]['log']['total_all_score']=$total_all_score;
		$analyze[$key]['log']['totalstudent']=$totalstudent;
		$analyze[$key]['log']['Mt']=$Mt;
		$analyze[$key]['log']['total_quiz_score']=$total_quiz_score;
		$analyze[$key]['log']['total_correct_student']=$total_correct_student;
		$analyze[$key]['log']['Mp']=$Mp;
		$analyze[$key]['log']['X_sqrd']=$X_sqrd;
		$analyze[$key]['log']['sum_X_sqrd']=$sum_X;
		$analyze[$key]['log']['St']=$St;
		$analyze[$key]['log']['sqrtpq']=$sqrtpq;
		$analyze[$key]['log']['Rpbi']=$Rpbi;
		$analyze[$key]['log']['p']=$p;
		$analyze[$key]['log']['q']=$q;
		$analyze[$key]['log']['t_table']=$t_table;
		$analyze[$key]['log']['r_table']=$r_table;
		//end of log for debugging
	}

//	$analyze['data_y']=$data_y;
	return $analyze;
}