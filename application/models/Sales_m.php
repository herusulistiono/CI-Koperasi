<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_m extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	public function check($barcode)
	{
		$this->db->select('barcode,kd_prod,nm_prod,harga_jual,diskon,stok,keluar');
		$this->db->from('tb_produk');
		$this->db->where('barcode',$barcode);
		$this->db->limit(1);
		$query=$this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row_array();
		}else{
			return FALSE;
		}
	}
	public function insert_payment($data)
	{
		$this->db->trans_start();
		$this->db->insert_batch('tb_penjualan',$data);
		$this->db->trans_complete();
		return TRUE;
	}
}

/* End of file Sales_m.php */
/* Location: ./application/models/Sales_m.php */