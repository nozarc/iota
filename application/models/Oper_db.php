<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class Oper_db extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database('default');
	}
	public function input_log($angka1,$angka2,$hasil)
	{
		/*$this->db->set('angka1',$angka1);
		$this->db->set('angka2',$angka2);
		$this->db->set('hasil',$hasil);
		$this->db->insert('log');
		*///also can be done like this
		
		$data=array('angka1'=>$angka1,'angka2'=>$angka2,'hasil'=>$hasil);
		$this->db->insert('log',$data);
		
	}
	public function tes_input($angka1,$angka2,$hasil)
	{
		/*$this->db->set('angka1',$angka1);
		$this->db->set('angka2',$angka2);
		$this->db->set('hasil',$hasil);
		$this->db->insert('log');
		*///also can be done like this
		
		$data=array('tes1'=>$angka1,'tes2'=>$angka2,'tes3'=>$hasil);
		$this->db->insert('tes',$data);
	}
	public function out_log($jml=10,$mulai=0)
	{
		$this->db->select('*'); // also can be done with $this->db->get('log')
		$this->db->from('log');
		$this->db->limit($jml,$mulai);
		$this->db->order_by('id','desc');
		return $this->db->get();
	}
}