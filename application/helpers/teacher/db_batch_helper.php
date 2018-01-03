<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
function batch_build($data1=null,$data2=null,$for='quiz')
	{
		if($data1!=null)
		{
			switch ($for) {
				case 'quiz':
					$arr=array();
					$arrcount=count($data1['answer_key']);
					for ($arrnum=1; $arrnum <= $arrcount; $arrnum++) { 
						$arrx=array();
						$arrx['id_analyze']=$data2;
						$arrx['quiz_number']=$arrnum;
						$arrx['answer_key']=$data1['answer_key'][$arrnum];
						$arrx['question']=$data1['question'][$arrnum];
						$arrx['measured_capability']=$data1['measured_capability'][$arrnum];
						array_push($arr,$arrx);
					}
					return $arr;
					break;
				
				case 'classgroup':
					function sortbyscoredesc($a, $b)
					{
						return $b['correct'] - $a['correct'];
					}
					function sortbyscoreasc($a, $b)
					{
						return $a['correct'] - $b['correct'];
					}
					foreach ($data1 as $key => $value) {
						foreach ($value as $k => $v) {
							$arrx[$value->user_id][$k]=$v;
							foreach ($data2 as $k2 => $v2) {
								if ($value->user_id==$v2['user_id']) {
									$arrx[$value->user_id]['correct']=$v2['correct'];
									$arrx[$value->user_id]['alpha']=$v2['alpha'];
									$arrx[$value->user_id]['answer']=$v2['answer'];

								}
							}
						}
					}
					$arrxcount=count($arrx);
					switch (true) {
						
						case ($arrxcount<100 and ($arrxcount%2==0)):
							$size=$arrxcount*(50/100);
							break;
						
						case ($arrxcount>=100 or ($arrxcount%2!=0)):
							$size=ceil($arrxcount*(27/100));
							break;
					}
					uasort($arrx, 'sortbyscoredesc');
					$analysis['all']=$arrx;
					$analysis['upper']=array_slice($arrx, 0, $size, true);
					$analysis['lower']=array_reverse(array_slice(array_reverse($arrx,true), 0, $size, true),true);
				//	$analysis['size']=$arrx;
					return $analysis;
					break;

				case 'answer':
					$arr=array();
					foreach ($data1 as $key => $value) {
						$arrcount=count($data1[$key]);
						for ($arrnum=1; $arrnum <= $arrcount; $arrnum++) { 
							$arrx=array();
							$arrx['id_analyze']=$data2;
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

function batch_unbuild($data1=null,$data2=null,$for='answer')
	{
		if ($data1!=null) {
			switch ($for) {
				case 'answer':
					$arr=array();
					foreach ($data2 as $k2 => $val2) {
						$arrx['id_analyze']=$val2['id_analyze'];
						$arrx['uid']=$val2['user_id'];
						$arrx['name']=$val2['name'];
						$arrx['userphoto']=$val2['userphoto'];
						$arrx['class']=$val2['class'];
						foreach ($data1 as $k1 => $val1) {
							if ($val1['user_id']==$val2['user_id']) {
								$arry['answer'][$val1['quiz_number']]=$val1['answer'];
							}
						}
						$arrx['answer']=$arry['answer'];
						unset($arry);
						array_push($arr, $arrx);
					}
					return $arr;
					break;
				case 'score':
					foreach ($data1 as $key => $value) {
						foreach ($value as $k => $v) {
							$arrx[$value->user_id][$k]=$v;
							foreach ($data2 as $k2 => $v2) {
								if ($value->user_id==$v2['user_id']) {
									$arrx[$value->user_id]['correct']=$v2['correct'];
									$arrx[$value->user_id]['alpha']=$v2['alpha'];
									$arrx[$value->user_id]['status']=$v2['status'];
								}
							}
						}
					}
					return $arrx;
					break;
				case 'quiz':
					foreach ($data1 as $key => $val) {
						$arr['answer_key'][$val['quiz_number']]=$val['answer_key'];
						$arr['question'][$val['quiz_number']]=$val['question'];
						$arr['measured_capability'][$val['quiz_number']]=$val['measured_capability'];
					}
					return $arr;
					break;
			}
		}
		else{
			return false;
		}
	}