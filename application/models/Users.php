<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
*/
class Users extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database('default');
		
	}
	public function show_list($limit=10,$offset=0,$order_column='',$order_type='asc')
	{
		if (empty($order_column||$order_type))
		{
			$this->db->order_by('uid','asc');
		}
		else
		{
			$this->db->order_by($order_column,$order_type);
		}
		return $this->db->get($this->db->dbprefix.'user',$limit,$offset);
	}
	public function show_all()
	{
		return $this->db->get_where($this->db->dbprefix.'user',array('status'=>'active'));
	}
	public function count_all()
	{
		return $this->db->count_all($this->db->dbprefix.'user');
	}
	public function get_person($uid)
	{
		return $this->db->select('*')->join($this->db->dbprefix.'people',$this->db->dbprefix.'people.uid = '.$this->db->dbprefix.'user.uid','left')->where($this->db->dbprefix.'user.uid',$uid)->get($this->db->dbprefix.'user');
	//	$this->db->where('uid',$uid); 
	//	return $this->db;
	}
	public function check_username($username,$uid=NULL)
	{
		if (isset($uid))
		{
			$where=array
			(
				'username'	=>$username,
				'uid !='	=>$uid
			);
		}
		else
		{
			$where=array
			(
				'username'	=>$username
			);
		}
		$this->db->where($where);
		if($this->db->get($this->db->dbprefix.'user')->num_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function insert($user,$person=null)
	{
		$username=$user['username'];$password=$user['password'];
		$this->db->set($user)->insert($this->db->dbprefix.'user');
		$person+=array(
			'uid'		=>$this->db->select('uid')
						->get_where($this->db->dbprefix.'user',array
									(
									'username'=>$username,
									'password'=>$password
									))
					->row()->uid
					);
		$person['userphoto']=$this->config->item('template').'images/defaultphoto.png';
		$this->db->set($person)->insert($this->db->dbprefix.'people');
		return $this->db->insert_id();
	//	return $person;
	/*
	perbaiki lagi bagian ini, kurang sip, kalo jadiin bisa insert ke user tapi gk keinsert ke people jika gk ada data person
	*/
	}
	public function update($uid,$user=null,$people=null)
	{
		
		if(!empty($user))
		{
			$this->db->where('uid',$uid);
			$this->db->set($user)->update($this->db->dbprefix.'user');
		}
		if(!empty($people))
		{
			$this->db->where('uid',$uid);
			$this->db->set($people)->update($this->db->dbprefix.'people');
		}
		return true;
		/*
		perbaiki juga bagian ini untuk fungsi update profil sendiri biar bisa update ke tabel people
		[update] cek fungsi update tabel people
		[update] done
		*/
	}
	public function delete($uid)
	{
		$this->db->where('uid',$uid);
		$this->db->update($this->db->dbprefix.'user',array('status'=>'nonactive'));
	}
}