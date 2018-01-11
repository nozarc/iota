<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class Teacher extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url','form','teacher/db_batch','teacher/quiz_result','general/obj_to_array'));
		$this->load->model(array('users','schooldata','analyze'));
		$this->load->library(array('form_validation','access','template','pagination','table','image_lib','excel'));
		if ($this->access->level()!='teacher') 
		{
			redirect('');
		}
	
	} 
	public function index()
	{
		extract($_SESSION);
		$data=$_SESSION;
		$this->analyze->delete(array('teacher_id'=>$sess_uid,'done'=>'N'),'hard'); //to clear junk data on database
		unset($_SESSION['newanalyze']);unset($_SESSION['editanalyze']);
		$this->template->display('index',$data);
	}
	public function analyze($page='list',$data_x='step_one',$data_y=null)
	{
		extract($_SESSION);
		$data=$_SESSION;
		switch ($page) {
			case 'list':
				$data['table']=$this->analyze->show_all($sess_uid);
				$this->template->display('analyzeslist',$data);
				break;

			case 'new':
				switch ($data_x) {
					case 'step_one'://tambah nilai jika benar, salah, dan tidak dijawab
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
							if ($st1!=(!empty($newanalyze['st1_data'])?$newanalyze['st1_data']:null)) {
								if (empty($st1_id)) {
								 	$this->analyze->newanalyze($st1,null);
								}
								else{
									$this->analyze->updateNew($st1,$newanalyze['st1_id']);
								}
							}
							$_SESSION['newanalyze']['st1_id']=$this->analyze->get($st1)->id;
							$_SESSION['newanalyze']['st1_data']=$this->input->post(null,true);
							redirect($sess_level.'/analyze/new/step_two');
						}
						$data['newanalyze']['init']=true;
						$this->template->display('analyze_st1',$data);
						break;
					case 'step_two':
						if (empty($_SESSION['newanalyze']['st1_id'])) {
							redirect($sess_level.'/analyze/new/');
						}
						extract($newanalyze);
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
								$this->analyze->ins_quiz(batch_build($this->input->post(null,true),$st1_id),'batch');
								$_SESSION['newanalyze']['st2_data']=$this->input->post(null,true);
							}
							else{
								$dbQuests=$this->analyze->get_quiz($st1_id);
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
											if ($dqval['quiz_number']==$iqval['quiz_number']) {
												$this->analyze->upd_quiz($iqval,$dqval['id']);
											}
										}
									}
									if ($iqcount>$dqcount) {
										for ($a=$dqcount; $a < $iqcount; $a++) { 
											$this->analyze->ins_quiz($inputQuests[$a]);
										}
									}
								/*	elseif ($iqcount<$dqcount) {
										for ($b=$iqcount; $b < $dqcount; $b++) { 
											$data['lol'][0].=" |delete>".$dbQuests[$a]['id'].'_'.$dbQuests[$a]['id'].'=>'.$dbQuests[$a]['id'].' from '.count($inputQuests);
										}
									}
								*/	
								$_SESSION['newanalyze']['st2_data']=$this->input->post(null,true);
								}
							}
							redirect($sess_level.'/analyze/new/step_three');
						}
						$this->template->display('analyze_st2',$data);
						break;
					case 'step_three':
						if (empty($_SESSION['newanalyze']['st1_id'])) {
							redirect($sess_level.'/analyze/new/');
						}
						extract($newanalyze);
						if (!empty($this->input->post('class',true))) {
							$this->form_validation->set_rules('class','Class','numeric');
							if ($this->form_validation->run()) {
								$_SESSION['newanalyze']['st3_data']['choosen_class']=$this->input->post('class',true);
							}
						}
						if (!empty($this->input->post('answer',true))) {
							foreach ($this->input->post('answer',true) as $ky => $vl) {
								$this->form_validation->set_rules('answer['.$ky.']','Answer','alpha');
							}
							if ($this->form_validation->run()) {
								if (empty($st3_data['answer'])) {
									$this->analyze->ins_answer(batch_build($this->input->post(null,true)['answer'],$st1_id,'answer'),'batch');
								}
								else{
									$inAns=batch_build($this->input->post(null,true)['answer'],$st1_id,'answer');
									$dbAns=$this->analyze->get_answer($st1_id,'all');
									$dbAnswer=$dbAns;
									foreach ($dbAns as $k1 => $v1) {
										unset($dbAns[$k1]['id']);
									}
									
									if ($inAns!=$dbAns) {
										$this->analyze->upd_answer($inAns);
									}	
								}
								$_SESSION['newanalyze']['st3_data']['answer']=$this->analyze->get_answer($st1_id,'allpeople');
								$this->analyze->ins_score(score($this->analyze->get_answer($st1_id,'allpeople'),$st2_data,$this->analyze->show($st1_id,$sess_uid,'notdone')),'batch');
								$this->analyze->newanalyze($st1_id,'done');
								$id_analyze=$st1_id;
								unset($_SESSION['newanalyze']);
								redirect($sess_level.'/analyze/result/'.$id_analyze);
							}
						}
					@	$data['students']=$this->schooldata->classes('getmember','student',$_SESSION['newanalyze']['st3_data']['choosen_class']);
						$data['classes']=$this->schooldata->classes('get_all');
					@	$data['st3_data']=$_SESSION['newanalyze']['st3_data'];
						$this->template->display('analyze_st3',$data);
						break;
				}
				break;
			case 'edit':
				if (empty($data_x)) {
					redirect($sess_level.'/analyze/list/');
				}
				if (empty($data_y)) {
					$data_y='step_one';
				}
				switch ($data_y) {
					case 'step_one'://tambah nilai jika benar, salah, dan tidak dijawab
						$st1_data=obj_to_arr($this->analyze->get(array('id'=>$data_x,'teacher_id'=>$sess_uid)));
						$st1_id=$st1_data['id'];
						unset($st1_data['id']);
						unset($st1_data['done']);
						unset($st1_data['deleted']);
						if (empty($_SESSION['editanalyze']['st1_data'])) {
							$data['editanalyze']['st1_data']=$st1_data;
							$data['editanalyze']['st1_id']=$st1_id;
						}
						$_SESSION['editanalyze']['st1_data']=$st1_data;
						$_SESSION['editanalyze']['st1_id']=$st1_id;
						
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
							if ($st1!=(!empty($editanalyze['st1_data'])?$editanalyze['st1_data']:null)) {
								$this->analyze->updateNew($st1,$st1_id);
							}
							$_SESSION['editanalyze']['st1_data']=$this->input->post(null,true);
							redirect($sess_level.'/analyze/edit/'.$data_x.'/step_two');
						}
						$this->template->display('analyze_st1',$data);
						break;
					case 'step_two':
						if (empty($_SESSION['editanalyze']['st1_id'])) {
							redirect($sess_level.'/analyze/edit/'.$data_x.'/step_one');
						}
						extract($editanalyze);
						$st2_data=batch_unbuild($this->analyze->get_quiz($data_x),null,'quiz');
						if (empty($_SESSION['editanalyze']['st2_data'])) {
							$data['editanalyze']['st2_data']=$st2_data;
						}
						$_SESSION['editanalyze']=$data['editanalyze'];

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
								$this->analyze->ins_quiz(batch_build($this->input->post(null,true),$st1_id),'batch');
								$_SESSION['editanalyze']['st2_data']=$this->input->post(null,true);
							}
							else{
								$dbQuests=$this->analyze->get_quiz($st1_id);
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
											if ($dqval['quiz_number']==$iqval['quiz_number']) {
												$this->analyze->upd_quiz($iqval,$dqval['id']);
											}
										}
									}
									if ($iqcount>$dqcount) {
										for ($a=$dqcount; $a < $iqcount; $a++) { 
											$this->analyze->ins_quiz($inputQuests[$a]);
										}
									}
								/*	elseif ($iqcount<$dqcount) {
										for ($b=$iqcount; $b < $dqcount; $b++) { 
											$data['lol'][0].=" |delete>".$dbQuests[$a]['id'].'_'.$dbQuests[$a]['id'].'=>'.$dbQuests[$a]['id'].' from '.count($inputQuests);
										}
									}
								*/
								$_SESSION['editanalyze']['st2_data']=$this->input->post(null,true);
								}
							}
							redirect($sess_level.'/analyze/edit/'.$data_x.'/step_three');
						}
						$this->template->display('analyze_st2',$data);
						break;
					case 'step_three':
						if (empty($_SESSION['editanalyze']['st1_id'])) {
							redirect($sess_level.'/analyze/new/');
						}
						extract($editanalyze);
						$st3_data=$this->analyze->get_answer($st1_id,'allpeople');
						if (empty($_SESSION['editanalyze']['st3_data'])) {
							$data['st3_data']['choosen_class']=$st3_data[0]['class'];
							$data['st3_data']['answer']=$st3_data;
						}
						$_SESSION['editanalyze']['st3_data']['choosen_class']=$st3_data[0]['class'];
						$_SESSION['editanalyze']['st3_data']['answer']=$st3_data;
						if (!empty($this->input->post('class',true))) {
							$this->form_validation->set_rules('class','Class','numeric');
							if ($this->form_validation->run()) {
								$_SESSION['editanalyze']['st3_data']['choosen_class']=$this->input->post('class',true);
							}
						}
						if (!empty($this->input->post('answer',true))) {
							foreach ($this->input->post('answer',true) as $ky => $vl) {
								$this->form_validation->set_rules('answer['.$ky.']','Answer','alpha');
							}
							if ($this->form_validation->run()) {
								if (empty($st3_data['answer'])) {
									$this->analyze->ins_answer(batch_build($this->input->post(null,true)['answer'],$st1_id,'answer'),'batch');
								}
								else{
									$inAns=batch_build($this->input->post(null,true)['answer'],$st1_id,'answer');
									$dbAns=$this->analyze->get_answer($st1_id,'all');
									$dbAnswer=$dbAns;
									foreach ($dbAns as $k1 => $v1) {
										unset($dbAns[$k1]['id']);
									}
									
									if ($inAns!=$dbAns) {
										$this->analyze->upd_answer($inAns);
									}	
								}
								$_SESSION['editanalyze']['st3_data']['answer']=$this->analyze->get_answer($st1_id,'allpeople');
								$this->analyze->ins_score(score($this->analyze->get_answer($st1_id,'allpeople'),$st2_data,$this->analyze->show($st1_id,$sess_uid,'done')),'batch');
								$this->analyze->newanalyze($st1_id,'done');
								$id_analyze=$st1_id;
								unset($_SESSION['editanalyze']);
								redirect($sess_level.'/analyze/result/'.$id_analyze);
							}
						}
					@	$data['editanalyze']['students']=$this->schooldata->classes('getmember','student',$_SESSION['editanalyze']['st3_data']['choosen_class']);
						$data['editanalyze']['classes']=$this->schooldata->classes('get_all');
					@	$data['editanalyze']['st3_data']=$_SESSION['editanalyze']['st3_data'];
						$this->template->display('analyze_st3',$data);
						break;
				}
				break;
			
			case 'result':
				if (!empty($data_x)) {
					$data['analyze']=$this->analyze->show($data_x,$sess_uid);
					$data['quiz']=batch_unbuild($this->analyze->get_quiz($data_x),null,'quiz');
					$data['student']=$this->analyze->get_answer($data_x,'allpeople');
					if (empty($this->analyze->get_score($data_x))) {
						$this->analyze->ins_score(score($data['student'],$data['quiz'],$this->analyze->show($data_x,$sess_uid)),'batch');
					}
					$data['group']=batch_build($this->analyze->get_score($data_x),score($data['student'],$data['quiz'],$this->analyze->show($data_x,$sess_uid),'info'),'classgroup');
					$data['score']=batch_unbuild($this->analyze->get_score($data_x),score($data['student'],$data['quiz'],$this->analyze->show($data_x,$sess_uid),'info'),'score');
					$data['result']=analyze($data['quiz'],$data['group']);
				//	$data['lol']['quiz']=$data['quiz'];
				//	$data['lol']['result']=analyze($data['quiz'],$data['group']);
				//	$data['lol']['student']=$data['student'];
					$this->template->display('analyzeresult',$data);
				}
				break;
			case 'delete':
				if(!empty($data_x)){
					$id=array('id'=>$data_x);
					$this->analyze->delete($id,'soft');
					redirect($sess_level.'/analyze/list/');
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