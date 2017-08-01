<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class Teacher extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url','form'));
		$this->load->model(array('create_db','users','schooldata'));
		$this->create_db->install_db();
		$this->load->library(array('form_validation','access','template','pagination','table','image_lib'));
		if ($this->access->level()!='teacher') 
		{
			redirect('');
		}
	
	} 
	public function index()
	{
		$data=$_SESSION;
		$this->template->display('index',$data);
	}
}