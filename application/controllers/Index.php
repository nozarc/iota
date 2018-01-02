<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class Index extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url','form'));
		$this->load->model(array('create_db','users'));
		$this->create_db->install_db();
		$this->load->library(array('form_validation','access','template'));
		
	}
	public function index()
	{
		$data['_tpath']=$this->config->item('template');
		$this->load->model('login');
		if ($this->access->is_login()) {
			redirect($this->access->level());
		}
		
		$this->form_validation->set_rules('username','Username','required');
		$this->form_validation->set_rules('password','Password','required');
		$this->form_validation->set_rules('token','token','callback_cek_login');
		if ($this->form_validation->run()) 
		{
			redirect($this->access->level());
		}
		else
		{
		//	$data['lol']=$this->input->post('password');
			//$this->config->item('template');
		}
		$this->load->view('template/login',$data);
	}
	public function cek_login()
	{
		$username=$this->input->post('username',true);
		$password=$this->input->post('password',true);
		$log=$this->access->login($username,$password);
		if ($log) {
			return true;
		}
		else
		{
			$this->form_validation->set_message('cek_login','username or password is wrong');
			return false;
		}
	}
	public function logout()
	{
		$this->access->logout();
		redirect('');
	}
}