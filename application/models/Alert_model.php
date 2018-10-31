<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alert_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	//Paraf Laporan
	public function get_by_name()
	{
		# code...
	}
	//Count Active Members
	public function count_of_members()
	{
		$this->db->select('COUNT(kd_angg) AS member_active')
			->from('tb_anggota')
			->where('aktif','Y');
		return $this->db->get();
	}
	//Alert New Loan
	public function alert_on_loan()
	{
		$this->db->select('COUNT(kd_pinj) AS new_loan')
		->from('tb_pinjaman')
		->where('status',(int)1);
		return $this->db->get();
	}
	//Loan Approve
	public function loan_accepted()
	{
		$this->db->select('COUNT(kd_pinj) AS acc')
			->from('tb_pinjaman')
			->where('status',(int)2);
		return $this->db->get();
	}
	//Loan Cancel
	public function loan_cancel()
	{
		$this->db->select('COUNT(kd_pinj) AS acc')
			->from('tb_pinjaman')
			->where('status',(int)3);
		return $this->db->get();
	}
	public function savings()
	{
		$this->db->select('SUM(pokok + wajib + sukarela) AS total_simpanan')
			->from('tb_simpanan');
			//->where('status',(int)3);
		return $this->db->get();
	}
}

/* End of file Alert_model.php */
/* Location: ./application/models/Alert_model.php */