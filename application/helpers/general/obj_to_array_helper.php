<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
function obj_to_arr($data_x=null,$data_y=null)
{
	if (!empty($data_x)) {
		foreach ($data_x as $key => $value) {
			$arr[$key]=$value;
		}
		return $arr;
	}
	else return false;
}