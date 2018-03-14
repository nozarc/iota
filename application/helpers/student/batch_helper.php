<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| about this helper
| batch_build is used when you want to convert your inputted data into database, and batch_unbuild is the opposite
*/
function build($data1=null)
{
	
}
function batch_unbuild($data1=null,$data2='quizWithAnswer')
{
	if (isset($data1)) {
		switch ($data2) {
			case 'quizWithAnswer':
				foreach ($data1 as $k => $v) {
					$arr[$v['id_analyze']]['user_id']=$v['user_id'];
					$arr[$v['id_analyze']]['quiz'][$v['quiz_number']]=
						array(
							'quiz_id'				=>$v['quiz_id'],
							'answer_id'				=>$v['answer_id'],
							'question'				=>$v['question'],
							'measured_capability'	=>$v['measured_capability'],
							'answer_key'			=>$v['answer_key'],
							'answer'				=>$v['answer']
							);
				}
				break;
		}
		return $arr;
	}
	else return false;
}