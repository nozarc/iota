<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class Schooldata extends CI_Model
{
	
	function __construct()
		{
			parent::__construct();
			$this->load->database('default');
		}
	public function create($value='')
		{
			$keys=array
				(
				'schoolname',
				'schooladdress',
				'schoolemail',
				'schoolphone',
				'schoolwebsite',
				'schoollogo',
				);
			foreach ($keys as $key) 
				{
					$this->db->set('keyword',$key)->insert($this->db->db->dbprefix.'schooldata');
				}
		}
	public function checkkey()
		{
			return $this->db->get_where($this->db->dbprefix.'schooldata',array('keyword'=>'schoolname'))->num_rows()>0?true:false;
		}
	public function update($value='')
	{
		if($this->checkkey()==false)
			{
			$this->create();		
			}
		foreach ($value as $k => $data) 
			{
				$this->db->where('keyword',$k)->update($this->db->dbprefix.'schooldata',array('value'=>$data));
			}
	}
	public function get()
	{
		$rows=$this->db->get($this->db->dbprefix.'schooldata')->result_id->num_rows;
		$data=$this->db->get($this->db->dbprefix.'schooldata')->result();
		$data2=array();
		foreach ($data as $key => $val) 
			{
				$data2[$val->keyword]=$val->value;
			}
		return $data2;
	}
	public function classes($fun=null,$data=null,$data2=null)
	{
			switch ($fun) {
				case 'add':
					$this->db->set($data)->insert($this->db->dbprefix.'classes');
					break;
				case 'delete':
					$this->db->where('class_id',$data)->delete($this->db->dbprefix.'classes');
					break;
				case 'get_all':
					return $this->db->get($this->db->dbprefix.'classes')->result();
					break;
				case 'getaclass':
					return $this->db->where('class_id',$data)->get($this->db->dbprefix.'classes')->row();
					break;
				case 'getunlisted':
					return $this->db
								->join($this->db->dbprefix.'people',$this->db->dbprefix.'people.uid = '.$this->db->dbprefix.'user.uid','left')
								->where('level',$data)
								->where('class',NULL)
								->get($this->db->dbprefix.'user')
								->result();
					break;
				case 'getmember':
					$level=$data;
					switch ($level) {
						case 'teacher':
							return $this->db
								->join($this->db->dbprefix.'people',$this->db->dbprefix.'people.uid = '.$this->db->dbprefix.'user.uid','left')
								->where('level',$data)
								->where('class',$data2)
								->get($this->db->dbprefix.'user')
								->row();
							break;
						case 'student':
							return $this->db
								->join($this->db->dbprefix.'people',$this->db->dbprefix.'people.uid = '.$this->db->dbprefix.'user.uid','left')
								->where('level',$data)
								->where('class',$data2)
								->get($this->db->dbprefix.'user')
								->result();
							break;
						default:
							return $this->db
								->join($this->db->dbprefix.'people',$this->db->dbprefix.'people.uid = '.$this->db->dbprefix.'user.uid','left')
								->where('class',$data2)
								->get($this->db->dbprefix.'user')
								->result();
							break;
					}
					break;
				case 'addmember':
					$class_id=array('class' => $data2);
					if(is_array($data))
					{
						foreach ($data as $key => $val) 
						{
							$this->db->set($class_id)->where('uid',$val)->update($this->db->dbprefix.'people');
						}
					}
					else
					{
						$this->db->set($class_id)->where('uid',$data)->update($this->db->dbprefix.'people');
					}
					break;
				case 'deletemember':
					$this->db->set(
									array(
										'class'=>null
										)
									)
							->where('uid',$data)
							->where('class',$data2)
							->update($this->db->dbprefix.'people');
					break;
				case 'move':
					$class_id=array('class' => $data2);
					if(is_array($data))
					{
						foreach ($data as $key => $val) 
						{
							$this->db->set($class_id)->where('uid',$val->uid)->update($this->db->dbprefix.'people');
						}
					}
					else
					{
						$this->db->set($class_id)->where('uid',$data)->update($this->db->dbprefix.'people');
					}
					break;
				default:
					return $this->db->get($this->db->dbprefix.'classes')->result();
					break;
			}
	}
}