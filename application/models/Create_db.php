<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
*  
*/
class Create_db extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->config->load('database',true);
		$cfg=$this->config->item('createdb','database');	
		$this->load->database($cfg);
		$this->load->dbforge();
	//	print_r($cfg);
	}
	public function cek_db()
	{
		if ($this->db->query('use '.$this->db->dtbase))
		{
		//	echo "jalan";
			return true;
		}
		else
		{
		//	echo "gagal";
			return false;
		}
	}
	public function c_table($prefix='')
	{
		$this->db->query("use ".$this->db->dtbase);
//		admin stuffs		
		$this->db->query('create table if not exists '.$prefix.'log(
			id int(5) primary key auto_increment,
			angka1 int(5), 
			angka2 int(5), 
			hasil int(10)
			)');
		$this->db->query('create table if not exists '.$prefix.'user(
			uid int(5) primary key auto_increment,
			username varchar(20), 
			password varchar(32),
			level enum("admin","headmaster","teacher","officer","student"),
			status enum("active","nonactive") default "active"
			)');
		$this->db->query('
			create table if not exists '.$prefix.'schooldata(
			id int(2) primary key auto_increment,
			keyword varchar(30),
			value text
			)');
		$this->db->query('create table if not exists '.$prefix.'classes(
			class_id int(5) primary key auto_increment,
			classname varchar(20),
			classinfo text
			)');
		$this->db->query('create table if not exists '.$prefix.'people(
			id int(5) primary key auto_increment,
			uid int(5), foreign key(uid) references '.$prefix.'user(uid) on update cascade on delete cascade,
			name varchar(50), 
			identity_number varchar(50), 
			address text,
			gender enum("m","f") default null,
			phone varchar(15),
			userphoto text, 
			email varchar(30),
			class int(5) default null, foreign key (class) references '.$prefix.'classes(class_id) on update cascade on delete restrict
			)');
		$this->db->query('create table if not exists '.$prefix.'sidebar(
			id int(5) primary key auto_increment,
			name varchar(20),
			href text,
			class text,
			class_2 text,
			parent int(5),
			owner enum("admin","headmaster","teacher","officer","student")
			)');
//		end of admin stuffs		

//		analyze tables
		$this->db->query('create table if not exists '.$prefix.'score_scale(
			id int(5) primary key auto_increment,
			scores int (5)
			)');
		$this->db->query('create table if not exists '.$prefix.'analyze(
			id int(5) primary key auto_increment,
			teacher_id int(5), foreign key(teacher_id) references '.$prefix.'user(uid) on delete set null on update cascade,
			subject varchar(50),
			test_type varchar(50),
			score_scale int(5), foreign key(score_scale) references '.$prefix.'score_scale(id) on delete set null on update cascade,
			min_score int(5),
			test_date date,
			test_correction_date date,
			test_report_date date,
			report_location varchar(50)
			)');

		$this->db->query('create table if not exists '.$prefix.'quiz(
			id int(5) primary key auto_increment,
			id_analyze int(5), foreign key(id_analyze) references '.$prefix.'analyze(id) on update cascade on delete set null,
			quiz_number int(3),
			question text,
			answer_key varchar(2),
			measured_capability text
			)');

		$this->db->query('create table if not exists '.$prefix.'quiz_answer(
			id int(5) primary key auto_increment,
			id_analyze int(5), foreign key(id_analyze) references '.$prefix.'analyze(id) on update cascade on delete set null,
			user_id int(5), foreign key(user_id) references '.$prefix.'user(uid) on update cascade on delete cascade,
			quiz_number int(3),
			answer varchar(1)
			)');

		$this->db->query('create table if not exists '.$prefix.'test_scores(
			id int(5) primary key auto_increment,
			id_analyze int(5), foreign key(id_analyze) references '.$prefix.'analyze(id) on update cascade on delete set null,
			user_id int(5), foreign key(user_id) references '.$prefix.'user(uid) on update cascade on delete cascade,
			scores int(3)
			)');
//		end of analyze tables

/**/
	}
	public function c_admin($prefix='')
	{
		$user=array(
			'username'	=>	'admin',
			'password'	=>	md5('admin'),
			'level'		=>	'admin',
			);
		if($this->db->get_where($prefix.'user',array('level'=>'admin'))->num_rows()==0)
		{
			$this->db->insert($prefix.'user',$user);
			$person=array(
				'uid'		=>$this->db->select('uid')
							->get_where($this->db->dbprefix.'user',array
										(
										'username'=>$user['username'],
										'password'=>$user['password']
										))
							->row()->uid,
				'userphoto'	=>$this->config->item('template').'images/defaultphoto.png',
						);
			$this->db->set($person)->insert($prefix.'people');
		}
	//	return $non;
	}
	public function c_sidebar($prefix='')
	{
		$sidebar=array_chunk($this->config->item('sidebar','database'), 5); //entah kenapa, si insert_batch cuma bisa insert sampai 5 baris, jadi gw potong2 aja
		if($this->db->get($prefix.'sidebar')->num_rows()==0)
		{
			foreach ($sidebar as $sidekey => $sideval) {
				$this->db->insert_batch($prefix.'sidebar',$sideval);
			}
		}
	}
	public function c_analyze($prefix='')
	{
		$scores=array
				(
					array('scores' => 4),
					array('scores' => 10),
					array('scores' => 100)
				);
		if($this->db->get($prefix.'score_scale')->num_rows()==0)
		{
			$this->db->insert_batch($prefix.'score_scale',$scores);
		}
	}
	public function c_fordev($prefix=null)
	{
		$users=array(
				array(
					'username'	=>	'guru',
					'password'	=>	md5('guru'),
					'level'		=>	'teacher',
					'name'		=>	'guru_1',
					'class'		=>	'1'
					),
				array(
					'username'	=>	'guru2',
					'password'	=>	md5('guru2'),
					'level'		=>	'teacher',
					'name'		=>	'guru_2',
					'class'		=>	'2'
					),
				array(
					'username'	=>	'siswa',
					'password'	=>	md5('siswa'),
					'level'		=>	'student',
					'name'		=>	'siswa_1',
					'class'		=>	'1'
					),
				array(
					'username'	=>	'siswa2',
					'password'	=>	md5('siswa2'),
					'level'		=>	'student',
					'name'		=>	'siswa_2',
					'class'		=>	'1'
					),
				array(
					'username'	=>	'siswa3',
					'password'	=>	md5('siswa3'),
					'level'		=>	'student',
					'name'		=>	'siswa_3',
					'class'		=>	'1'
					),
				);
		$classes=array(
					array(
						'class_id'	=>'1',
						'classname'	=>'XI IPS 1'
					),
					array(
						'class_id'	=>'2',
						'classname'	=>'XI IPS 2'
					),
					array(
						'class_id'	=>'3',
						'classname'	=>'XI IPS 3'
					),
				);
		foreach ($classes as $classkey => $classval) {
			if ($this->db->where($classval)->get($prefix.'classes')->num_rows()==0) {
				$this->db->insert($prefix.'classes',$classval);
			}
		}
		foreach ($users as $key => $val) {
			$find=array(
					'username'	=>$users[$key]['username'],
					'password'	=>$users[$key]['password'],
					'level'		=>$users[$key]['level']
				);
			if ($this->db->where($find)->get($prefix.'user')->num_rows()==0) {
				$this->db->insert($prefix.'user',$find);
				$persons=array(
							'uid'	=>$this->db->select('uid')
									->get_where($prefix.'user',array(
												'username'	=>$val['username'],
												'password'	=>$val['password']
												))
									->row()->uid,
							'userphoto'	=>$this->config->item('template').'images/defaultphoto.png',
							'name'		=>$val['name'],
							'class'		=>$val['class']
							);
				$this->db->set($persons)->insert($prefix.'people');
			}
		}
	}
	public function install_db()
	{
		if ($this->cek_db()==false) 
		{
			$this->dbforge->create_database($this->db->dtbase);
		}
		$this->c_table($this->db->dbprefix);
		$this->c_admin($this->db->dbprefix);
		$this->c_sidebar($this->db->dbprefix);
		$this->c_analyze($this->db->dbprefix);
		if ($this->config->item('state')=='development') {
			$this->c_fordev($this->db->dbprefix);
		}
//		$this->db->query('create table if not exists tes1(id int(5) primary key auto_increment,nama varchar(20),status enum("active","disactive") default "active")');
		//$non=$this->db->dbprefix;
		$this->db->close();
		//return $non;
	}
}