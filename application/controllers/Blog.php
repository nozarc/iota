<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		$data['title']='test Blog';
		$data['isi']='Hello world';
		$out=$this->load->view('hello',$data,true);
		echo "$out";
	}
}

/* End of file Blog.php */
/* End of file ./applications/controllers/blog.php */