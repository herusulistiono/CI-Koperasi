<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loan_m extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		//Cols=>kd_pinj,kd_angg,tgl_pinj,jml_pinj,jml_angs,tenor,status,ket_pinj
	}
	public function generate_code()
	{
		$this->db->select_max('kd_pinj');
		return $this->db->get('tb_pinjaman');
	}
	//JIKA ADA PINJAMAN => BARU BISA CETAK KWITANSI
	public function get_member()
	{
		$this->db->select('pinj.kd_angg,angg.kd_angg,angg.nm_angg')
			->from('tb_pinjaman pinj')
			->join('tb_anggota angg','pinj.kd_angg=angg.kd_angg','INNER')
			->group_by('pinj.kd_angg');
		return $this->db->get();
	}
	public function get_all_loan()
	{
		$this->db->select('pinj.kd_pinj,pinj.kd_angg,pinj.tgl_pinj,pinj.jml_pinj,pinj.tenor,pinj.bunga,pinj.jml_angs,pinj.pinj_ke,pinj.status,pinj.ket_pinj,pinj.ket_tolak')
			->select('a.kd_angg,a.nm_angg')
			->from('tb_pinjaman pinj')
			->join('tb_anggota a','pinj.kd_angg=a.kd_angg','INNER')
			->order_by('pinj.tgl_pinj','DESC');
		return $this->db->get();
	}
	public function get_all_internal()
	{
		$this->db->select('pinj.kd_pinj,pinj.kd_angg,pinj.tgl_pinj,pinj.jml_pinj,pinj.tenor,pinj.bunga,pinj.jml_angs,pinj.pinj_ke,pinj.status,pinj.ket_pinj,pinj.ket_tolak')
			->select('a.kd_angg,a.nm_angg')
			->from('tb_pinjaman pinj')
			->join('tb_anggota a','pinj.kd_angg=a.kd_angg','INNER')
			->where('pinj.pinj_ke',1)
			->order_by('pinj.tgl_pinj','DESC');
		return $this->db->get();
	}
	public function get_all_external()
	{
		$this->db->select('pinj.kd_pinj,pinj.kd_angg,pinj.tgl_pinj,pinj.jml_pinj,pinj.tenor,pinj.bunga,pinj.jml_angs,pinj.pinj_ke,pinj.status,pinj.ket_pinj,pinj.ket_tolak')
			->select('a.kd_angg,a.nm_angg')
			->from('tb_pinjaman pinj')
			->join('tb_anggota a','pinj.kd_angg=a.kd_angg','INNER')
			->where('pinj.pinj_ke',2)
			->order_by('pinj.tgl_pinj','DESC');
		return $this->db->get();
	}
	public function get_primary($kd_pinj)
	{
		$this->db->from('tb_pinjaman');
		$this->db->where('kd_pinj',$kd_pinj);
		return $this->db->get();
	}
	public function insert($data)
	{
		$this->db->insert('tb_pinjaman', $data);
		return TRUE;
	}
	public function update($data)
	{
		$this->db->update('tb_pinjaman', $data, array('kd_pinj'=>$data['kd_pinj']));
      	return $this->db->affected_rows();
	}
	public function get_detail($kd_pinj)
	{
		$this->db->select('SUM(pinj.jml_angs) AS total')
			->select('pinj.kd_pinj,pinj.kd_angg,pinj.tgl_pinj,pinj.jml_pinj,pinj.tenor,pinj.bunga,pinj.jml_angs,pinj.pinj_ke,pinj.status,pinj.ket_pinj,pinj.ket_tolak')
			->select('a.kd_angg,a.nm_angg,a.kelamin,a.tgl_lahir,a.tmpt_lahir,a.telp,a.alamat')
			->select('kop.ka_koperasi,kop.ka_keu,kop.manajer')
			->from('tb_pinjaman pinj, tb_paraf kop')
			->join('tb_anggota a','pinj.kd_angg=a.kd_angg','INNER')
			->where('kd_pinj', $kd_pinj)
			->order_by('pinj.tgl_pinj','DESC');
		return $this->db->get();
	}
	//tb_angsuran=no_kwitansi,kd_pinj,tgl_bayar,jml_bayar,angs_ke
	public function generate_invoice()
	{
		$this->db->select_max('no_kwitansi');
		return $this->db->get('tb_angsuran');
	}
	//TAMPIL PINJAMAN YG DISETUJUI
	public function get_loan_approve()
	{
		$this->db->select('pinj.kd_pinj,pinj.kd_angg,pinj.tgl_pinj,pinj.jml_pinj,pinj.tenor,pinj.bunga,pinj.jml_angs,pinj.pinj_ke,pinj.status,pinj.ket_pinj,pinj.ket_tolak')
			->select('a.kd_angg,a.nm_angg')
			->from('tb_pinjaman pinj')
			->join('tb_anggota a','pinj.kd_angg=a.kd_angg','INNER')
			->where('status', (int)2)
			->group_by('pinj.kd_angg');
		return $this->db->get();
	}
	//TAMPIL DATA PINJAMAN BERDASAR KODE DAN SET ANGSURAN KE FIELD
	public function get_loan($kd_pinj='')
	{
		$this->db->select('IF(p.status=2,p.tenor,(p.tenor*12)) AS tenor,p.kd_pinj,p.jml_pinj,p.jml_angs,a.kd_angg,a.nm_angg',TRUE)
			->select('IFNULL((SELECT (i.angs_ke+1) FROM tb_angsuran i WHERE i.kd_pinj = p.kd_pinj ORDER BY i.angs_ke DESC LIMIT 1),1) AS lama',false)
			->from('tb_pinjaman p')
			->join('tb_anggota a','a.kd_angg=p.kd_angg');
			if($kd_pinj!= ''){
				$this->db->where('p.kd_pinj', $kd_pinj);
			}
			$this->db->limit(1);
			return $this->db->get();
	}
	//TAMPIL ANGSURAN 
	public function get_installment($kd_pinj)
	{
		$this->db->select('pinj.jml_pinj')
			->select('inst.*')
			->select('pinj.kd_pinj')
			->from('tb_angsuran inst')
			->join('tb_pinjaman pinj','pinj.kd_pinj=inst.kd_pinj','INNER')
			->where('inst.kd_pinj', $kd_pinj)
			->order_by('inst.tgl_bayar', 'desc')
			->group_by('inst.no_kwitansi');
		return $this->db->get();
	}
	public function create_invoice($no_kwitansi)
	{
		$this->db->select('pinj.jml_pinj')
			->select('inst.*')
			->select('pinj.kd_pinj')
			->from('tb_angsuran inst')
			->join('tb_pinjaman pinj','pinj.kd_pinj=inst.kd_pinj','INNER')
			->where('inst.no_kwitansi', $no_kwitansi)
			->order_by('inst.tgl_bayar', 'desc')
			->group_by('inst.no_kwitansi');
		return $this->db->get();
	}
	public function insert_installment($data)
	{
		$this->db->insert('tb_angsuran', $data);
		return TRUE;
	}
}

/* End of file Loan_m.php */
/* Location: ./application/models/Loan_m.php */