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
		$this->load->helper(array('url','form','student/batch','general/obj_to_array'));
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
		redirect($sess_level.'/quiz/list/');
	}
	public function quiz($page='list')
	{
		extract($_SESSION);
		$data=$_SESSION;
		switch ($page) {
			case 'list':
				$data['table']=$this->quiz->show_all($sess_uid);
				$data['quizWithAnswer']=batch_unbuild($this->quiz->get_quizWithAnswer($sess_uid),'quizWithAnswer');
				$this->template->display('quiz_list',$data);
				break;
			
		}
	}
	//susun halaman profil dulu
	public function profile($page='view',$done=null)
	{
		extract($_SESSION);
		$data=$_SESSION;
		switch($page){
			case 'view':
				$this->template->display('profile',$data);
			break;
			case 'photo':
				$imgupload=array
				(
					'allowed_types'		=>'jpg|png',
					'upload_path'		=>$this->config->item('template_dir').'images/',
					'overwrite'			=>true,
					'file_ext_tolower'	=>true,
					'file_name'			=>$sess_uid.'_temp',
				);
				$this->load->library('upload',$imgupload);
				if($this->upload->do_upload('userphoto'))
				{
					$imgedit=array
								(
									'source_image'		=> $this->upload->data()['full_path'],
									'maintain_ratio'	=> false,
								);
					if($this->upload->data()['image_height'] > $this->upload->data()['image_width'] )
					{
						//orientasi portrait
						$imgedit['height'] = $this->upload->data()['image_width'];
						$imgedit['width'] = $this->upload->data()['image_width'];
						$imgedit['y_axis'] = ($this->upload->data()['image_height']/2) - ($imgedit['height']/2);
					}
					else
					{
						//orientasi landscape
						$imgedit['height'] = $this->upload->data()['image_height'];
						$imgedit['width'] = $this->upload->data()['image_height'];
						$imgedit['x_axis'] = ($this->upload->data()['image_width']/2) - ($imgedit['width']/2);

					}
					$this->image_lib->initialize($imgedit);
					$this->image_lib->crop();
					$this->image_lib->clear();
					unset($imgedit);
					$imgedit=array
								(
									'height'			=>200,
									'width'				=>200,
									'source_image'		=>$this->upload->data()['full_path'],
								);
					$this->image_lib->initialize($imgedit);
					$this->image_lib->resize();
					$this->image_lib->clear();
					$_SESSION['temp_photo'] = $this->upload->data()['file_name'];
					redirect($sess_level.'/profile/photo/confirm');
				}
				else
				{
					$data['error'] = $this->upload->display_errors();
					//buat tampilan errornya seperti di form lain
				}
				if($done=='done')
				{
					$ext=explode('.', $temp_photo)[1];
					$newname=$this->config->item('template_dir').'images/'.$sess_uid.'_photo.'.$ext;
					rename($this->config->item('template_dir').'images/'.$temp_photo, $newname);
					$userphoto=array
								(
									'userphoto'	=>'images/'.$sess_uid.'_photo.'.$ext,
								);
					$this->users->update($sess_uid,null,$userphoto);
					unset($_SESSION['temp_photo']);
					redirect($sess_level.'/profile');
				}
				$data['done']=$done;
				$this->template->display('userphoto',$data);
			break;
			case 'edit':
				if ($this->input->post('username',true)!=$sess_username) {
						$callback_check_username='|callback_check_username';
					}
					else{
						$callback_check_username=null;
					}
				$this->form_validation->set_rules('username','Username','required'.$callback_check_username);
				if (!empty($this->input->post('password',true))) {
					$this->form_validation->set_rules('password','Password','min_length[5]');
					$this->form_validation->set_rules('passwordconf','Password Confirmation','matches[password]');
				}
				$this->form_validation->set_rules('fullname','Name','callback_check_headmaster_name');
				$this->form_validation->set_rules('identity_number','Identity Number','is_natural');
				$this->form_validation->set_rules('gender','Gender','alpha');
				$this->form_validation->set_rules('email','Email','valid_email');
				$this->form_validation->set_rules('phone','Phone Number','numeric');
				if ($this->form_validation->run())
				{
					if (empty($this->input->post('password',true))) {
						$user=array
							(
								'username'	=> $this->input->post('username',true),
							);
					}
					else
					{
						$user=array
							(
								'username'	=> $this->input->post('username',true),
								'password'	=>md5($this->input->post('password',true))
							);
					}
					$person=array
					(
						'name'				=> $this->input->post('fullname',true),
						'identity_number'	=> $this->input->post('identity_number',true),
						'gender'			=> $this->input->post('gender',true),
						'email'				=> $this->input->post('email',true),
						'phone'				=> $this->input->post('phone',true),
						'address'			=> $this->input->post('address',true)
					);

					$this->users->update($data['sess_uid'],$user,$person);
					redirect($sess_level.'/profile/edit/done');
				}
			/*	else
				{
					$data['lol']=$this->input->post(null,true);
				}
			*/
				$data['done']=$done;
				$this->template->display('editprofile',$data);
			break;
		}
	}
		public function check_headmaster_name()
	{
		$headmaster=$this->input->post('level',true);
		$fullname=$this->input->post('fullname',true);
		if($headmaster=='headmaster' && empty($fullname))
		{
			$this->form_validation->set_message('check_headmaster_name','Sorry, we need Headmaster\'s {field}');
			return false;
		}
		else
		{
			return true;
		}
	//	troubel ada pada cek fullname apakah sudah ada isinya atau belum
	// 120517 kayaknya sudah beres, coba cek lagi
	}
	public function check_username()
	{
		$username=$this->input->post('username',true);
		$uid=$this->input->post('uid',true);
		if($this->users->check_username($username,$uid))
		{
			$this->form_validation->set_message('check_username','Sorry, {field} is already exists');
			return false;
		}
		else
		{
			
			return true;
		}
	}
}