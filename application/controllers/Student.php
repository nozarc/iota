<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
* 
*/
class Student extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url','form','db_batch','quiz_result','obj_to_array'));
		$this->load->model(array('users','schooldata','quiz'));
		$this->load->library(array('form_validation','access','template','table','image_lib','excel'));
		if ($this->access->level()!='student') 
		{
			redirect('');
		}
	}
	public function index()
	{
		extract($_SESSION);
		$data=$_SESSION;
		$data['table']=$this->quiz->show_all($sess_uid);
		$data['lol']=$data['table'];
		$this->template->display('quiz_list',$data);
	}
	//susun halaman profil dulu
}