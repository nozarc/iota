<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
function batch_build($val=null,$id=null,$for='quiz')
	{
		if($val!=null)
		{
			switch ($for) {
				case 'quiz':
					$arr=array();
					$arrcount=count($val['answer_key']);
					for ($arrnum=1; $arrnum <= $arrcount; $arrnum++) { 
						$arrx=array();
						$arrx['id_analyze']=$id;
						$arrx['quiz_number']=$arrnum;
						$arrx['answer_key']=$val['answer_key'][$arrnum];
						$arrx['question']=$val['question'][$arrnum];
						$arrx['measured_capability']=$val['measured_capability'][$arrnum];
						array_push($arr,$arrx);
					}
					return $arr;
					break;
				
				case 'answer':
					$arr=array();
					foreach ($val as $key => $value) {
						$arrcount=count($val[$key]);
						for ($arrnum=1; $arrnum <= $arrcount; $arrnum++) { 
							$arrx=array();
							$arrx['id_analyze']=$id;
							$arrx['user_id']=$key;
							$arrx['quiz_number']=$arrnum;
							$arrx['answer']=$value[$arrnum];
							array_push($arr, $arrx);
						}
					}
					return $arr;
					break;
			}
		}
		else 
		{
			return false;
		}
	}

function batch_unbuild($data1=null,$data2=null,$method='answer')
	{
		if ($data1!=null) {
			switch ($method) {
				case 'answer':
					$arr=array();
					foreach ($data2 as $k2 => $val2) {
						$arrx['id_analyze']=$val2['id_analyze'];
						$arrx['user_id']=$val2['user_id'];
						$arrx['name']=$val2['name'];
						$arrx['userphoto']=$val2['userphoto'];
						foreach ($data1 as $k1 => $val1) {
							if ($val1['user_id']==$val2['user_id']) {
								$arry['quiz_number'][$val1['id']]=$val1['quiz_number'];
								$arry['answer'][$val1['id']]=$val1['answer'];
							}
						}
						$arrx['quiz_number']=$arry['quiz_number'];
						$arrx['answer']=$arry['answer'];
						unset($arry);
						array_push($arr, $arrx);
					}
					return $arr;
					break;
				
				default:
					# code...
					break;
			}
		}
		else{
			return false;
		}
	}