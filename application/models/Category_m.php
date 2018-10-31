<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_m extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	public function get_category()
	{
		$this->db->select('id_kat,nm_kategori,seo');
		$this->db->from('tb_kategori');
		return $this->db->get();
	}
	public function get_primary($id_kat)
	{
		$this->db->from('tb_kategori');
		$this->db->where('id_kat',$id_kat);
		return $this->db->get();
	}
	public function insert($data)
	{
		$this->db->insert('tb_kategori', $data);
		return TRUE;
	}
	public function update($data)
	{
		$this->db->update('tb_kategori', $data, array('id_kat'=>$data['id_kat']));
      	return $this->db->affected_rows();
	}
}

/* End of file Category_m.php */
/* Location: ./application/models/Category_m.php */