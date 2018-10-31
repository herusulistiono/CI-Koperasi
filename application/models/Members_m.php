<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Members_m extends CI_Model {	
	public function __construct()
	{
		parent::__construct();
		//Members =kd_angg,ktp,nm_angg,kelamin,tgl_lahir,tmpt_lahir,telp,alamat,aktif,sejak
	}
	public function generate_code()
	{
		$this->db->select_max('kd_angg');
		return $this->db->get('tb_anggota');
	}
	public function get_all()
	{
		$this->db->select('kd_angg,ktp,nm_angg,kelamin,tgl_lahir,tmpt_lahir,telp,alamat,aktif,sejak');
		$this->db->from('tb_anggota');
		$this->db->order_by('kd_angg','DESC');
		return $this->db->get();
	}
	public function get_member_id($kd_angg)
	{
		$this->db->where('kd_angg',$kd_angg);
	   return $this->db->get('tb_anggota');
	}
	public function insert($data)
	{
		$this->db->insert('tb_anggota', $data);
		return TRUE;
	}
	public function update($data)
	{
		$this->db->update('tb_anggota', $data, array('kd_angg'=>$data['kd_angg']));
        return $this->db->affected_rows();
	}
}

/* End of file Members_m.php */
/* Location: ./application/models/Members_m.php */