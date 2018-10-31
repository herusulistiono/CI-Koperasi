<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_m extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	public function generate_code()
	{
		$this->db->select_max('kd_prod');
		return $this->db->get('tb_produk');
	}
	public function barcode_exists($barcode)
	{
		$this->db->select('barcode')
			->from('tb_produk')
			->where('barcode',$barcode)
			->limit(1);
		$query=$this->db->get();
		if ($query->num_rows() >0) {
			return $query->row_array();
		}else{
			return false;
		}
	}
	public function get_primary($kd_prod)
	{
		$this->db->where('kd_prod',$kd_prod);
		return $this->db->get('tb_produk');
	}
	public function get_product()
	{
		$this->db->select('p.kd_prod,p.barcode,p.nm_prod,p.id_kat,p.harga_beli,p.harga_jual,p.diskon,p.satuan,p.stok,p.keluar,p.dijual,p.sisa,p.gambar')
			->select('k.id_kat,k.nm_kategori')
			->from('tb_produk p')
			->join('tb_kategori k','p.id_kat=k.id_kat','INNER')
			->order_by('p.kd_prod','DESC');
		return $this->db->get();
	}
	public function insert($data)
	{
		$this->db->insert('tb_produk', $data);
		return TRUE;
	}
	public function update($data)
	{
		$this->db->update('tb_produk', $data, array('kd_prod'=>$data['kd_prod']));
        return $this->db->affected_rows();
	}
}

/* End of file Product_m.php */
/* Location: ./application/models/Product_m.php */