<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*   
*/
class Admin extends CI_Controller
{
//	$session=$_SESSION;
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url','form'));
		$this->load->model(array('create_db','users','schooldata'));
		$this->create_db->install_db();
		$this->load->library(array('form_validation','access','template','pagination','table','image_lib'));
		if ($this->access->level()!='admin') 
		{
			redirect('');
		}
	
	} 
	public function index()
	{
		$data=$_SESSION;
		$this->template->display('index',$data);
	}
	public function viewusers()
	{
		$data=$_SESSION;
		$data['table']=$this->users->show_all()->result();
		$this->template->display('viewusers',$data);

	}
	public function edituser($uid=null)
	{
		$data=$_SESSION;
		$data['lol']=$uid;
		///form data
		$this->form_validation->set_rules('username','Username','required|callback_check_username');
		$this->form_validation->set_rules('uid','UID','required|integer');
		$this->form_validation->set_rules('password','Password','matches[passwordconf]');
		$this->form_validation->set_rules('passwordconf','Password Confirmation','matches[password]');
	/*	$this->form_validation->set_rules('fullname','Name','callback_check_headmaster_name');
	//	$this->form_validation->set_rules('identity_number','Identity Number','is_natural');
	//	$this->form_validation->set_rules('gender','Gender','alpha');
	//	$this->form_validation->set_rules('email','Email','valid_email');
	//	$this->form_validation->set_rules('phone_num','Phone Number','numeric');
	*/
		if ($this->form_validation->run())
		{
			if (empty($this->input->post('password',true))) {
				$update=array
					(
						'username'	=> $this->input->post('username',true),
						'level'		=> $this->input->post('level',true),
					);
			}
			else
			{
				$update=array
					(
						'username'	=> $this->input->post('username',true),
						'level'		=> $this->input->post('level',true),
						'password'	=> md5($this->input->post('password',true))
					);
			}
			$this->users->update($this->input->post('uid',true),$update);
		}
		$data['user']=$this->users->get_person($uid)->row();
		$this->template->display('edituser',$data);

	}
	public function adduser($q=null)
	{
		$data=$_SESSION;
		$this->form_validation->set_rules('username','Username','required|callback_check_username');
		$this->form_validation->set_rules('password','Password','required|matches[passwordconf]');
		$this->form_validation->set_rules('passwordconf','Password Confirmation','required|matches[password]');
		$this->form_validation->set_rules('fullname','Name','callback_check_headmaster_name');
		$this->form_validation->set_rules('reg_number','Registration Number','is_natural');
		$this->form_validation->set_rules('gender','Gender','alpha');
		$this->form_validation->set_rules('email','Email','valid_email');
		$this->form_validation->set_rules('phone_num','Phone Number','numeric');
		if ($this->form_validation->run())
		{
			$username=$this->input->post('username',true);
			$dbprefix=$this->db->dbprefix;
			$password=md5($this->input->post('password',true));
			$user=array
				(
					'username'	=>$username,
					'password'	=>$password,
					'level'		=>$this->input->post('level',true)
				);
			$person=array
				(
					'name'				=>$this->input->post('fullname',true),
					'identity_number'	=>$this->input->post('identity_number',true),
					'address'			=>$this->input->post('address',true),
					'gender'			=>$this->input->post('gender',true),
					'phone'				=>$this->input->post('phone',true),
					'userphoto'			=>$this->input->post('userphoto',true),
					'email'				=>$this->input->post('email',true)
				);
			$this->users->insert($user,$person);
		}
		$this->template->display('adduser',$data);
	}
	public function deleteuser($id=null)
	{
		$this->users->delete($id);
		redirect('admin/viewusers');
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
	public function schooldata($submit=null,$done='')
	{
		$data=$_SESSION;
		extract($_SESSION);
		$data['done']=$done;
		$data['school']=$this->schooldata->get();
		//$data['lol']=$submit;
		switch ($submit) {
			case 'data':
				$this->form_validation->set_rules('schoolname','School Name','required');
				$this->form_validation->set_rules('schoolemail','School Email','valid_email');
				$this->form_validation->set_rules('schooladdress','School Address','required');
				$this->form_validation->set_rules('schoolphone','School Phone','numeric');
				$this->form_validation->set_rules('schoolwebsite','School Name','valid_url');
				if ($this->form_validation->run())
					{
						$schoolinfo=array
									(
										'schoolname' 	=> $this->input->post('schoolname',true),
										'schooladdress' => $this->input->post('schooladdress',true),
										'schoolemail' 	=> $this->input->post('schoolemail',true),
										'schoolphone' 	=> $this->input->post('schoolphone',true),
										'schoolwebsite' => $this->input->post('schoolwebsite',true),
									);
						$this->schooldata->update($schoolinfo);
						redirect($sess_level.'/schooldata');
					}
				$data['lol']=$this->input->post(null,true);
				break;
			case 'logo':
				$imgupload=array
						(
							'allowed_types'		=>'jpg|png',
							'upload_path'		=>$this->config->item('template_dir').'images/',
							'overwrite'			=>true,
							'file_ext_tolower'	=>true,
							'file_name'			=>'school_logo',
						);
				$this->load->library('upload',$imgupload);
				if($this->upload->do_upload('school_logo'))
						{
							//start crop dan center gambar terupload 
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
							//end of crop dan center
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
							$data['lol']=$this->upload->data();
							$logo=$this->config->item('template').'/images/'.$this->upload->data()['file_name'];
							$this->schooldata->update(array('schoollogo'=>$logo));
							redirect($sess_level.'/schooldata/','refresh');
						}
						else
						{
							$data['error'] = $this->upload->display_errors();
							//buat tampilan errornya seperti di form lain
						}
				break;
			default:
				break;
		}
		$this->template->display('schooldata',$data);
	}
	public function schoolclasses($value='',$id=null,$act=null,$id2=null)
	{
		$data=$_SESSION;
		extract($_SESSION);
		switch ($value) {
			case 'add':
				$this->schooldata->classes('add',$this->input->post(null,true));
				$data['lol']=$this->input->post(null,true);
				redirect($sess_level.'/schoolclasses/');
				break;
			case 'edit':
				$data['classid']=$id;
				$data['classname']=$this->schooldata->classes('getclass',$id)->classname;
				$data['classes']=$this->schooldata->classes();
				$data['unlistedstudent']=$this->schooldata->classes('getunlisted','student');
				$data['unlistedteacher']=$this->schooldata->classes('getunlisted','teacher');
				$data['member']=$this->schooldata->classes('getmember',null,$id);
				$data['teacher']=$this->schooldata->classes('getmember','teacher',$id);
				$data['students']=$this->schooldata->classes('getmember','student',$id);
				$data['lol']=$data['students'];
				switch ($act) {
					case 'addstudent':
						$this->schooldata->classes('addmember',$this->input->post('addstudent',true),$id);
						redirect($sess_level.'/schoolclasses/edit/'.$id);
						break;
					case 'addteacher':
						//cek apakah sudah ada wali kelas, jika ada -> hapus 
						if (isset($data['teacher'])) {
							$this->schooldata->classes('deletemember',$data['teacher']->uid,$id);
						}
						$this->schooldata->classes('addmember',$this->input->post('teacher',true),$id);
						redirect($sess_level.'/schoolclasses/edit/'.$id);
						break;
					case 'delete':
						$this->schooldata->classes('deletemember',$id2,$id);
						redirect($sess_level.'/schoolclasses/edit/'.$id);
						break;
					case 'move':
						$this->schooldata->classes('move',$data['students'],$this->input->post('move',true));
						redirect($sess_level.'/schoolclasses/edit/'.$id);
						break;
					default:
						# code...
						break;
				}
				$this->template->display('editclass',$data);
				break;
			case 'delete':
				$this->schooldata->classes('delete',$id);
				redirect($sess_level.'/schoolclasses/');
				break;
			default:
				$data['classes']=$this->schooldata->classes();
				$this->template->display('schoolclasses',$data);
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
	public function perkalian()
	{
/*		if ($this->access->is_login()===false) {
			redirect('');
		}
*/		$this->load->model('oper_db');
		$this->form_validation->set_rules('v1','Variabel 1','required|integer');
		$this->form_validation->set_rules('v2','Variabel 2','required|integer');
		if($this->form_validation->run())
		{
			$data['v1']=$this->input->post('v1',true);
			$data['v2']=$this->input->post('v2',true);
			$data['hasil']=$data['v1']*$data['v2'];
			//extract($data);
			$this->oper_db->input_log($data['v1'],$data['v2'],$data['hasil']);
		}
		else
		{
			$data['v1']="0";
			$data['v2']="0";
			$data['hasil']="0";
		}
		$data['outlog']=$this->oper_db->out_log()->result('array');
		$data['d_error']='';
		$this->load->view('perkalian',$data);
		//$this->oper_db->tes_input('xxx','ssss','cccc');
	}
	
	public function pembagian($offset=0,$column='uid',$ordertype='asc')
	{
		$limit=4;
		$offset=empty($offset)?0:$offset;
		$column=empty($column)?'uid':$column;
		$ordertype=empty($ordertype)?'asc':$ordertype;
		$users=$this->users->show_list($limit,$offset,$column,$ordertype)->result();
		//pagination
		$cfg['base_url']=site_url('admin/pembagian/');
		$cfg['total_rows']=$this->users->count_all();
		$cfg['per_page']=$limit;
		$cfg['uri_segment']=3;
		$this->pagination->initialize($cfg);
		$data['page']=$this->pagination->create_links();

		//table
		$this->table->set_empty("&nbsp;");
		$order=($ordertype=='asc'?'desc':'asc');
		$this->table->set_heading(
			'No',
			anchor($cfg['base_url'].'/'.$offset.'/uid/'.$order,'Uid'),
			anchor($cfg['base_url'].'/'.$offset.'/username/'.$order,'Username'),
			anchor($cfg['base_url'].'/'.$offset.'/level/'.$order,'Level'),
			anchor($cfg['base_url'].'/'.$offset.'/status/'.$order,'Status'),
			'Actions'
			);
		$no=$offset;
		foreach ($users as $user) {
			$this->table->add_row(
				++$no,
				$user->uid,
				$user->username,
				$user->level,
				$user->status,
				anchor('hitung/view/'.$user->uid,'View'),
				anchor('hitung/update/'.$user->uid,'Update'),
				anchor('hitung/delete/'.$user->uid,'Delete',array('onclick'=>'return confirm("Are your sure to delete it?")'))
				);
		}
		$data['table']=$this->table->generate();
		$data['lol']=$users;
		$this->load->view('pembagian',$data);
	}
	public function logout()
	{
		$this->access->logout();
		redirect('');
	}
}