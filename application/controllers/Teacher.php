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
		$this->load->model(array('users','schooldata','analyze'));
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
	public function newanalyze($step='step_one')
	{
		extract($_SESSION);
		$data=$_SESSION;
		switch ($step) {
			case 'step_one':
				$data['score_scale']=$this->analyze->get_score_scale()->result();
				$this->form_validation->set_rules('subject','Subject','required');
				$this->form_validation->set_rules('test_type','Test Type','required');
				$this->form_validation->set_rules('score_scale','Score Scale','required|numeric');
				$this->form_validation->set_rules('min_score','Minimum Score','required|numeric');
				$this->form_validation->set_rules('test_date','Test Date','alpha_dash');
				$this->form_validation->set_rules('test_correction_date','Correction Date','alpha_dash');
				$this->form_validation->set_rules('test_report_date','Test Report Date','alpha_dash');
				$this->form_validation->set_rules('report_location','Report Location','required');
				if ($this->form_validation->run()) {
					$st1=$this->input->post(null,true);
					$st1['teacher_id']=$_SESSION['sess_uid'];
					$this->analyze->new($st1);
					$_SESSION['st1_id']=$this->analyze->get($st1)->row()->id;//tambah tgl ujian, biar lebih valid
					redirect($sess_level.'/newanalyze/step_two');
				}
				$this->template->display('newanalyze_st1',$data);
				break;
			case 'step_two':
				if (empty($st1_id)) {
					redirect($sess_level.'/newanalyze');
				}
				$answerskey=$this->input->post('answer_key',true);
				$questions=$this->input->post('question',true);
				$measured_capabilities=$this->input->post('measured_capability',true);
				if (!empty($answerskey)) {
					foreach ($answerskey as $k => $value) {
						$this->form_validation->set_rules('answer_key['.$k.']','Answer Key No '.$k,'alpha|required|max_length[1]');
					}
				}
				if ($this->form_validation->run()) {
					$ins=$this->analyze->ins_questions($this->input->post(null,true),$st1_id);
					redirect($sess_level.'/newanalyze/step_three');
				}
				$this->template->display('newanalyze_st2',$data);//perbaiki step_one, jadi ketika nekan back, data st1 ga hilang
				break;
			case 'step_three':
				$this->template->display('newanalyze_st3',$data);
				break;

			default:
				# code...
				break;
		}
	}

public function profile($hal='view',$done=null)
	{
		extract($_SESSION);
		$data=$_SESSION;
		switch($hal){
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
									'userphoto'	=>$this->config->item('template').'images/'.$sess_uid.'_photo.'.$ext,
								);
					$this->users->update($sess_uid,null,$userphoto);
					unset($_SESSION['temp_photo']);
					redirect($sess_level.'/profile');
				}
				$data['done']=$done;
				$data['lol']=$imgupload;
				$this->template->display('userphoto',$data);
			break;
			case 'edit':
				$this->form_validation->set_rules('username','Username','required|callback_check_username');
				$this->form_validation->set_rules('passwordconf','Password Confirmation','matches[password]');
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
			*/	$data['lol']=$done;
				$data['done']=$done;
				$this->template->display('editprofile',$data);
			break;
		}
	}
	
}