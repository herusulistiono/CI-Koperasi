<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loan extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('loan_m','alert_model'));
	}
	public function index()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login', 'refresh');
		}elseif ($this->ion_auth->is_admin() || $this->ion_auth->in_group((int)6) || $this->ion_auth->in_group((int)3)){
			$this->data['title']='PERSETUJUAN PINJAMAN';
			$this->data['alert']=$this->alert_model->alert_on_loan()->row();
			$this->data['loan']=$this->loan_m->get_all_loan()->result();
			$this->backend->display('loan/index_loan',$this->data);
		}else{
			return show_error('You must be an administrator to view this page.');
		}
	}
	public function view($kd_pinj)
	{
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login', 'refresh');
		}elseif ($this->ion_auth->is_admin() || $this->ion_auth->in_group((int)6)){
			$this->data['title']='DETAIL PINJAMAN';
			$pinjam=$this->loan_m->get_detail($kd_pinj)->row();
			$this->data['kd_pinj'] = $pinjam->kd_pinj;
			$this->data['kd_angg'] = $pinjam->kd_angg;
			$this->data['nm_angg'] = $pinjam->nm_angg;
			$this->data['kelamin'] = $pinjam->kelamin;
			$this->data['tgl_lahir'] = $pinjam->tgl_lahir;
			$this->data['tmpt_lahir'] = $pinjam->tmpt_lahir;
			$this->data['telp'] = $pinjam->telp;
			$this->data['alamat'] = $pinjam->alamat;
			$this->data['tgl_pinj'] = $pinjam->tgl_pinj;
			$this->data['jml_pinj'] = $pinjam->jml_pinj;
			$this->data['tenor'] = $pinjam->tenor;
			$this->data['jml_angs'] = $pinjam->jml_angs;
			$this->data['ket_pinj'] = $pinjam->ket_pinj;
			$this->data['total'] = $pinjam->total;
			$this->data['ka_koperasi']= $pinjam->ka_koperasi;
			$this->data['ka_keu']= $pinjam->ka_keu;
			$this->data['manajer']= $pinjam->manajer;
			$this->load->view('loan/loan_detail', $this->data);
		}else{
			return show_error('Bukan Halaman Otoritas Anda.');
		}
	}
	public function get_by_id()
	{
		$kd_pinj=$this->input->post('kd_pinj');
		$data=$this->loan_m->get_primary($kd_pinj)->row();
		$data->tgl_pinj=date('d-m-Y',strtotime($data->tgl_pinj));
		echo json_encode($data);
	}
	public function approved()
	{
		$data=array(
			'kd_pinj'=>$this->input->post('kd_pinj'),
			'status'=>(int)2
		);
		$this->loan_m->update($data);
		$info['success'] = true;
	    $info['message'] = 'Data Berhasil Disetujui!';
	    echo json_encode($info);
	}
	public function rejected()
	{
		$errors=array();
		$info=array();
		if (empty($this->input->post('ket_tolak')))
        	$errors['ket_tolak'] = 'Alasan Wajib Diisi.';
        if (!empty($errors)) {
	        $info['success'] = false;
	        $info['errors']  = $errors;
	    } else {
			$data=array(
				'kd_pinj'=>$this->input->post('kd_pinj'),
				'status'=>(int)3,
				'ket_tolak'=>$this->input->post('ket_tolak')
			);
			$this->loan_m->update($data);
			$info['success'] = true;
	        $info['message'] = 'Data Diproses!';
		}
		echo json_encode($info);
	}
}

/* End of file Loan.php */
/* Location: ./application/controllers/Loan.php */