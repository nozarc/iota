<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class Teacher extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url','form','db_batch'));
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
	public function newanalyze($step='step_one',$phase='chooseclass')
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
					if ($st1!=$st1_data) {
						if (empty($st1_id)) {
							$this->analyze->new($st1);
						}
						else{
							$this->analyze->updateNew($st1,$st1_id);
						}
					}
					$_SESSION['st1_id']=$this->analyze->get($st1)->row()->id;
					$_SESSION['st1_data']=$this->input->post(null,true);
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
						$this->form_validation->set_rules('answer_key['.$k.']','Answer Key No '.$k,'required|max_length[1]');
					}
				}
			
				if ($this->form_validation->run()) {

					if(empty($st2_data)){
						$this->analyze->ins_question(batch_build($this->input->post(null,true),$st1_id),'batch');
						$_SESSION['st2_data']=$this->input->post(null,true);
					}
					else{
						$dbQuests=$this->analyze->get_quests($st1_id)->result_array();
						$quests=$dbQuests;
						foreach ($quests as $k1 => $v1) {
							unset($quests[$k1]['id']);
						}
						$inputQuests=batch_build($this->input->post(null,true),$st1_id);
						$dqcount=count($dbQuests);
						$iqcount=count($inputQuests);
						if($quests!=$inputQuests){
							foreach ($dbQuests as $dqkey => $dqval) {
								foreach ($inputQuests as $iqkey => $iqval) {
									if ($dqval['q_number']==$iqval['q_number']) {
										$this->analyze->upd_question($iqval,$dqval['id']);
									}
								}
							}
							if ($iqcount>$dqcount) {
								for ($a=$dqcount; $a < $iqcount; $a++) { 
									$this->analyze->ins_question($inputQuests[$a]);
								}
							}
							elseif ($iqcount<$dqcount) {
								for ($b=$iqcount; $b < $dqcount; $b++) { 
									$data['lol'][0].=" |delete>".$dbQuests[$a]['id'].'_'.$dbQuests[$a]['id'].'=>'.$dbQuests[$a]['id'].' from '.count($inputQuests);
								}
							}
						$_SESSION['st2_data']=$this->input->post(null,true);
						}
					}
					redirect($sess_level.'/newanalyze/step_three');
				}
				$this->template->display('newanalyze_st2',$data);
				/*solusi biar ga mumet, mikirnya sambil kayang*/
				break;
			case 'step_three':
				switch ($phase) {
					case 'chooseclass': //buat validasi form pilih kelas, jika run maka terset sesi kelas
					//	$data['choosen_class']=$this->input->post('class',true);
						$this->form_validation->set_rules('class','Class','numeric');
						if ($this->form_validation->run()) {
							$_SESSION['st3_data']['choosen_class']=$this->input->post('class',true);
						}
					@	$data['students']=$this->schooldata->classes('getmember','student',$_SESSION['st3_data']['choosen_class']);
						$data['classes']=$this->schooldata->classes('get_all');
					@	$data['lol']['st3_data']=$_SESSION['st3_data'];
					//	$data['lol']['choosen_class']=$data['choosen_class'];
						$data['lol']['post']=$this->input->post(null,true);
						$this->template->display('newanalyze_st3',$data); //jangan lupa unset session st1-st3 baik id dan data
						break;
				}
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