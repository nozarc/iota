<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class Template
{
	
	function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->load->helper('url');
		$this->ci->load->model(array('users','sysdb'));
		//$this->folder=$this->ci->config->item('template');
	}
	public function display($content,$data=null)
	{
		$data['sysdb']=$this->ci->sysdb;
		$data['me']=$this->ci->users->get_person($_SESSION['sess_uid'])->row();
		$data['_tpath']=$this->ci->config->item('template');
		$data['_content']=$this->ci->load->view('template/content/'.$content,$data,true);
		$data['_header']=$this->ci->load->view('template/header',$data,true);
		$data['_footer']=$this->ci->load->view('template/footer',$data,true);
		$data['_sidebar']=$this->ci->load->view('template/sidebar',$data,true);
		$data['_top_nav']=$this->ci->load->view('template/top_nav',$data,true);
		$this->ci->load->view('template/main',$data);
	}
}