<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Deposit_m extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	public function generate_code()
	{
		$this->db->select_max('kd_simp');
		return $this->db->get('tb_simpanan');
	}
	public function generate_code_deb()
	{
		$this->db->select_max('kd_deb_simp');
		return $this->db->get('tb_deb_simpanan');
	}
	//JIKA ADA SIMPANAN => BISA PINJAM => DITARIK
	public function get_member()
	{
		$this->db->select('simp.kd_angg,a.nm_angg')
			->from('tb_simpanan simp')
			->join('tb_anggota a','a.kd_angg=simp.kd_angg','INNER')
			->group_by('simp.kd_angg')
			->order_by('simp.kd_angg', 'ASC');
		return $this->db->get();
	}
	//TOTAL SIMPANAN SUKARELA
	public function get_savings($kd_angg)
	{
		$this->db->select('SUM(simp.sukarela) AS total_simpanan')
			->select('simp.wajib,simp.pokok')
			->from('tb_simpanan simp')
			->where('simp.kd_angg',$kd_angg)
			->group_by('simp.kd_angg');
		return $this->db->get();
	}
	//TOTAL PINJAMAN
	public function loans($kd_angg)
	{
		$this->db->select('SUM(pinj.jml_pinj) AS total_pinjam')
			->from('tb_pinjaman pinj')
			->where('pinj.kd_angg', $kd_angg)
			->group_by('pinj.kd_angg');
		return $this->db->get();
	}
	public function get_all()
	{
		$this->db->select('simp.kd_simp,simp.kd_angg,simp.tgl_simp,simp.pokok,simp.wajib, simp.sukarela')
			->select('a.kd_angg,a.nm_angg')
			->from('tb_simpanan simp')
			->join('tb_anggota a','a.kd_angg=simp.kd_angg','INNER')
			->order_by('simp.tgl_simp','DESC');
		return $this->db->get();
	}
	public function get_primary($kd_simp)
	{
		$this->db->from('tb_simpanan');
		$this->db->where('kd_simp',$kd_simp);
		return $this->db->get();
	}
	public function insert($data)
	{
		$this->db->insert('tb_simpanan', $data);
		return TRUE;
	}
	public function update($data)
	{
		$this->db->update('tb_simpanan', $data, array('kd_simp'=>$data['kd_simp']));
      	return $this->db->affected_rows();
	}
	public function delete($kd_simp)
	{
		$this->db->where('kd_simp',$kd_simp);
		$this->db->delete('tb_simpanan');
	}
	//SAVNGS WITHDRWAWAL DATA
	public function withdrawal()
	{
		$this->db->select('wd.kd_deb_simp,wd.kd_angg,wd.tgl_deb_simp,wd.jml_deb')
			->select('a.nm_angg')
			->from('tb_deb_simpanan wd')
			->join('tb_anggota a','a.kd_angg=wd.kd_angg','INNER')
			->order_by('wd.tgl_deb_simp','DESC');
		return $this->db->get();
	}
	public function withdrawal_insert($data)
	{
		$this->db->insert('tb_deb_simpanan', $data);
		return TRUE;
	}
	public function withdrawal_update($data)
	{
		$this->db->update('tb_deb_simpanan', $data, array('kd_deb_simp'=>$data['kd_deb_simp']));
		return $this->db->affected_rows();
	}
	//GET SAVINGS ALL
	public function net_incomes($first_date,$last_date)
	{
		$this->db->select('SUM(simp.pokok + simp.wajib + simp.sukarela) AS total_simpanan')
			->from('tb_simpanan simp')
			->join('tb_anggota angg','angg.kd_angg=simp.kd_angg','INNER')
			->where('simp.tgl_simp BETWEEN CAST("'.$first_date.'" AS DATE) AND CAST("'.$last_date.'" AS DATE)');
		return $this->db->get();
	}
	public function net_incomes_member($members_id,$first_date,$last_date)
	{
		$this->db->select('SUM(simp.pokok + simp.wajib + simp.sukarela) AS jumlah_simpanan')
			->select('simp.kd_angg,angg.nm_angg')
			->from('tb_simpanan simp')
			->join('tb_anggota angg','angg.kd_angg=simp.kd_angg','INNER')
			->where('simp.kd_angg',$members_id)
			->where('simp.tgl_simp BETWEEN CAST("'.$first_date.'" AS DATE) AND CAST("'.$last_date.'" AS DATE)')
			->order_by('simp.tgl_simp','desc');
		return $this->db->get();
	}
	public function save_net_income($data)
	{
		$this->db->insert('tb_usaha', $data);
		return TRUE;
	}
}

/* End of file Deposit_m.php */
/* Location: ./application/models/Deposit_m.php */