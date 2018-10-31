<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_m extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	public function deposit_member($kd_angg,$first_date,$last_date)
	{
		$this->db->select_sum('simp.pokok','pokok')->select_sum('simp.wajib','wajib')->select_sum('simp.sukarela','sukarela')
			->select('angg.nm_angg,simp.kd_simp,simp.kd_angg,simp.tgl_simp,simp.sukarela')
			->from('tb_simpanan simp')
			->join('tb_anggota angg','angg.kd_angg=simp.kd_angg','INNER')
			->where('simp.kd_angg',$kd_angg)
			->where('simp.tgl_simp BETWEEN CAST("'.$first_date.'" AS DATE) AND CAST("'.$last_date.'" AS DATE)')
			->group_by('simp.kd_simp')
			->order_by('simp.tgl_simp','desc');
		return $this->db->get();
	}
	public function deposit_date($first_date,$last_date)
	{
		$this->db->select_sum('simp.pokok','pokok')->select_sum('simp.wajib','wajib')->select_sum('simp.sukarela','sukarela')
			->select('angg.nm_angg,simp.kd_simp,simp.kd_angg,simp.tgl_simp,simp.sukarela')
			->from('tb_simpanan simp')
			->join('tb_anggota angg','angg.kd_angg=simp.kd_angg','INNER')
			->where('simp.tgl_simp BETWEEN CAST("'.$first_date.'" AS DATE) AND CAST("'.$last_date.'" AS DATE)')
			->group_by('simp.kd_simp')
			->order_by('simp.tgl_simp','desc');
		return $this->db->get();
	}
	public function loan_member($kd_angg,$first_date,$last_date)
	{
		$this->db->select_sum('pinj.jml_pinj','total_pinjaman')
			->select('pinj.kd_pinj, pinj.kd_angg,pinj.tgl_pinj,pinj.jml_pinj,pinj.jml_angs,pinj.tenor,pinj.pinj_ke,a.nm_angg')
			->from('tb_pinjaman pinj')
			->join('tb_anggota a','pinj.kd_angg=a.kd_angg','INNER')
			->where('pinj.status',(int)2)
			->where('pinj.kd_angg',$kd_angg)
			->where('pinj.tgl_pinj BETWEEN CAST("'.$first_date.'" AS DATE) AND CAST("'.$last_date.'" AS DATE)')
			->group_by('pinj.kd_pinj')
			->order_by('pinj.tgl_pinj','desc');
		return $this->db->get();
	}
	public function loan_date($first_date,$last_date)
	{
		$this->db->select_sum('pinj.jml_pinj','total_pinjaman')
			->select('pinj.kd_pinj, pinj.kd_angg,pinj.tgl_pinj,pinj.jml_pinj,pinj.jml_angs,pinj.tenor,pinj.pinj_ke,a.nm_angg')
			->from('tb_pinjaman pinj')
			->join('tb_anggota a','pinj.kd_angg=a.kd_angg','INNER')
			->where('pinj.status',(int)2)
			->where('pinj.tgl_pinj BETWEEN CAST("'.$first_date.'" AS DATE) AND CAST("'.$last_date.'" AS DATE)')
			->group_by('pinj.kd_pinj')
			->order_by('pinj.tgl_pinj','desc');
		return $this->db->get();
	}
	public function installment($first_date,$last_date)
	{
		$this->db->select_sum('angs.jml_bayar','total_bayar')
			->select('angs.no_kwitansi,angs.kd_pinj,angs.tgl_bayar,angs.jml_bayar, angs.angs_ke, angs.status')
			->select('pinj.tgl_pinj,pinj.jml_pinj,pinj.jml_angs,pinj.tenor, a.kd_angg,a.nm_angg')
			->from('tb_angsuran angs')
			->join('tb_pinjaman pinj','angs.kd_pinj=pinj.kd_pinj','INNER')
			->join('tb_anggota a','pinj.kd_angg=a.kd_angg','INNER')
			->where('pinj.status',(int)2)
			->where('angs.tgl_bayar BETWEEN CAST("'.$first_date.'" AS DATE) AND CAST("'.$last_date.'" AS DATE)')
			->group_by('angs.no_kwitansi')
			->order_by('angs.tgl_bayar','desc');
		return $this->db->get();
	}
	//DETAIL SIMPANAN
	public function net_income($first_date,$last_date)
	{
		$this->db->select_sum('simp.pokok','pokok')
			->select_sum('simp.wajib','wajib')
			->select_sum('simp.sukarela','sukarela')
			->select('u.kd_angg, SUM(u.sembako) AS tot_sembako, SUM(u.btn) AS tot_btn, SUM(u.bsm) AS tot_bsm')
			->select('angg.nm_angg,simp.kd_angg,simp.tgl_simp')
			->from('tb_simpanan simp')
			->join('tb_anggota angg','angg.kd_angg=simp.kd_angg','INNER')
			->join('tb_usaha u','u.kd_angg=simp.kd_angg')
			->where('simp.tgl_simp BETWEEN CAST("'.$first_date.'" AS DATE) AND CAST("'.$last_date.'" AS DATE)')
			->where('u.tgl_rekap BETWEEN CAST("'.$first_date.'" AS DATE) AND CAST("'.$last_date.'" AS DATE)')
			->group_by('simp.kd_angg')
			->order_by('simp.kd_angg','ASC');
		return $this->db->get();
	}
	//TOTAL SIMPANAN
	public function amount_net_income($first_date,$last_date)
	{
		$this->db->select('SUM(simp.pokok + simp.wajib + simp.sukarela) AS total_simpanan')
			->from('tb_simpanan simp')
			->join('tb_anggota angg','angg.kd_angg=simp.kd_angg','INNER')
			->where('simp.tgl_simp BETWEEN CAST("'.$first_date.'" AS DATE) AND CAST("'.$last_date.'" AS DATE)');
		return $this->db->get();
	}
	//DETAIL USAHA
	public function profit($first_date,$last_date)
	{
		$this->db->select('u.kd_angg, SUM(u.sembako) AS tot_sembako, SUM(u.btn) AS tot_btn, SUM(u.bsm) AS tot_bsm')
			->from('tb_usaha u')
			//->join('tb_anggota a','a.kd_angg=u.kd_angg','INNER')
			->join('tb_simpanan s','u.kd_angg=s.kd_angg')
			->where('u.tgl_rekap BETWEEN CAST("'.$first_date.'" AS DATE) AND CAST("'.$last_date.'" AS DATE)')
			->group_by('u.kd_angg');
		return $this->db->get();
	}
	//TOTAL USAHA
	public function amount_profit($first_date,$last_date)
	{
		$this->db->select('SUM(us.sembako + us.btn + us.bsm) AS tot_profit')
			->from('tb_usaha us')
			->join('tb_simpanan s','s.kd_angg=us.kd_angg','INNER')
			->where('us.tgl_rekap BETWEEN CAST("'.$first_date.'" AS DATE) AND CAST("'.$last_date.'" AS DATE)')
			->order_by('us.kd_angg','ASC');
		return $this->db->get();
	}
	//PENJUALAN
	public function sales($first_date,$last_date)
	{
		$this->db->select('penj.kd_prod,penj.kd_prod,penj.tgl_jual,penj.qty')
			->select('p.nm_prod,p.harga_jual')
			->from('tb_penjualan penj')
			->join('tb_produk p','p.kd_prod=penj.kd_prod','INNER')
			->where('penj.tgl_jual BETWEEN CAST("'.$first_date.'" AS DATE) AND CAST("'.$last_date.'" AS DATE)')
			->order_by('penj.tgl_jual','desc');
		return $this->db->get();
	}
	public function inventory($first_date,$last_date																																						)
	{
		# code...
	}
}

/* End of file Report_m.php */
/* Location: ./application/models/Report_m.php */