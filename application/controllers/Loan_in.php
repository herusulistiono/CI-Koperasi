<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loan_in extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('loan_m','deposit_m'));
	}
	public function index()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login', 'refresh');
		}elseif ($this->ion_auth->is_admin() || $this->ion_auth->in_group((int)2)){
			$this->data['title']='DATA PINJAMAN KOPERASI';
			$this->data['members'] = $this->deposit_m->get_member()->result();
			$this->data['loan']=$this->loan_m->get_all_internal()->result();
			//Set Increment Loan ID
			$rowID=$this->loan_m->generate_code()->row();
			$loan_code=$rowID->kd_pinj;
			if ($loan_code){
				$setcode=substr($loan_code,2);
				$code=(int)$setcode;
			    $code=$code+1;
			    $this->data['generate']='PJ'.str_pad($code,4,'0',STR_PAD_LEFT);
			}else{
				$this->data['generate']='PJ0001';
			}
			$this->backend->display('loan/index_internal',$this->data);
		}else{
			return show_error('You must be an administrator to view this page.');
		}
	}
	public function get_by_id()
	{
		$kd_pinj=$this->input->post('kd_pinj');
		$data=$this->loan_m->get_primary($kd_pinj)->row();
		$data->tgl_pinj=date('d-m-Y',strtotime($data->tgl_pinj));
		echo json_encode($data);
	}
	public function save()
	{
		$errors=array();
		$info=array();
		if(empty($this->input->post('tgl_pinj')))
        	$errors['tgl_pinj'] = 'Tanggal Harus Diisi.';
		if(empty($this->input->post('kd_angg')))
        	$errors['kd_angg'] = 'Anggota Harus Diisi.';
        if(empty($this->input->post('jml_pinj')))
        	$errors['jml_pinj'] = 'Jumlah Pinjaman Harus Diisi.';
        if(empty($this->input->post('tenor')))
        	$errors['tenor']='Tenor Harus Diisi.';
        if(empty($this->input->post('ket_pinj')))
        	$errors['ket_pinj']='Keterangan Pinjaman Harus Diisi.';
		if(!empty($errors)) {
	        $info['success'] = false;
	        $info['errors']  = $errors;
	    }else {
	    	$jml_pinj = str_replace(',', '', $this->input->post('jml_pinj'));
	    	$jml_angs = str_replace(',', '', $this->input->post('jml_angs'));
	        $data=array(
	        	'kd_pinj'=>$this->input->post('code'),
				'kd_angg'=>$this->input->post('kd_angg'),
				'tgl_pinj'=>date('Y-m-d',strtotime($this->input->post('tgl_pinj'))),
				'jml_pinj'=>$jml_pinj,
				'tenor'=>$this->input->post('tenor'),
				'bunga'=>$this->input->post('bunga'),
				'jml_angs'=>$jml_angs,
				'pinj_ke'=>$this->input->post('pinj_ke'),
				'ket_pinj'=>$this->input->post('ket_pinj')
	        );
	        $this->loan_m->insert($data);
	        $info['success']=true;
	        $info['message']='Berhasil Disimpan!';
	    }
	    echo json_encode($info);
	}
	public function update()
	{
		$errors=array();
		$info=array();
		if(empty($this->input->post('tgl_pinj')))
        	$errors['tgl_pinj'] = 'Tanggal Harus Diisi.';
		if(empty($this->input->post('kd_angg')))
        	$errors['kd_angg'] = 'Anggota Belum Diisi.';
        if(empty($this->input->post('jml_pinj')))
        	$errors['jml_pinj'] = 'Jumlah Pinjaman.';
        if(empty($this->input->post('tenor')))
        	$errors['tenor']='Tenor Harus Diisi.';
        if(empty($this->input->post('ket_pinj')))
        	$errors['ket_pinj']='Keterangan Pinjaman Harus Diisi.';
		if(!empty($errors)) {
	        $info['success'] = false;
	        $info['errors']  = $errors;
	    }else {
	    	$jml_pinj = str_replace(',', '', $this->input->post('jml_pinj'));
	    	$jml_angs= str_replace(',', '', $this->input->post('jml_angs'));
	        $data=array(
	        	'kd_pinj'=>$this->input->post('code'),
				'kd_angg'=>$this->input->post('kd_angg'),
				'tgl_pinj'=>date('Y-m-d',strtotime($this->input->post('tgl_pinj'))),
				'jml_pinj'=>$jml_pinj,
				'tenor'=>$this->input->post('tenor'),
				'bunga'=>$this->input->post('bunga'),
				'jml_angs'=>$jml_angs,
				'pinj_ke'=>$this->input->post('pinj_ke'),
				'ket_pinj'=>$this->input->post('ket_pinj')
	        );
	        $this->loan_m->update($data);
	        $info['success']=true;
	        $info['message']='Berhasil Diubah!';
	    }
	    echo json_encode($info);
	}
	public function invoice($kd_pinj)
	{
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login', 'refresh');
		}elseif ($this->ion_auth->is_admin() || $this->ion_auth->in_group((int)2)){
			$this->data['title']='BUKTI PENGELURAN KAS';
			$pinjam=$this->loan_m->get_detail($kd_pinj)->row();
			$this->data['kd_pinj'] = $pinjam->kd_pinj;
			$this->data['kd_angg'] = $pinjam->kd_angg;
			$this->data['nm_angg'] = $pinjam->nm_angg;
			$this->data['tgl_pinj'] = $pinjam->tgl_pinj;
			$this->data['jml_pinj'] = $pinjam->jml_pinj;
			$this->data['ket_pinj'] = $pinjam->ket_pinj;
			$this->data['ka_koperasi']= $pinjam->ka_koperasi;
			$this->data['ka_keu']= $pinjam->ka_keu;
			$this->data['manajer']= $pinjam->manajer;
			$this->load->view('loan/loan_invoice', $this->data);
		}else{
			return show_error('Bukan Halaman Otoritas Anda.');
		}
	}
	public function receipt($kd_pinj)
	{
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login', 'refresh');
		}elseif ($this->ion_auth->is_admin() || $this->ion_auth->in_group((int)2)){
			$this->data['title']='RECEIPT';
			$pinjam=$this->loan_m->get_detail($kd_pinj)->row();
			$this->data['kd_pinj'] = $pinjam->kd_pinj;
			$this->data['kd_angg'] = $pinjam->kd_angg;
			$this->data['nm_angg'] = $pinjam->nm_angg;
			$this->data['tgl_pinj'] = $pinjam->tgl_pinj;
			$this->data['jml_pinj'] = $pinjam->jml_pinj;
			$this->data['tenor'] = $pinjam->tenor;
			$this->data['jml_angs'] = $pinjam->jml_angs;
			$this->data['ket_pinj'] = $pinjam->ket_pinj;
			$this->data['total'] = $pinjam->total;
			$this->data['ka_koperasi']= $pinjam->ka_koperasi;
			$this->data['ka_keu']= $pinjam->ka_keu;
			$this->data['manajer']= $pinjam->manajer;
			$this->load->view('loan/loan_installment', $this->data);
		}else{
			return show_error('Bukan Halaman Otoritas Anda.');
		}
	}
	public function view($kd_pinj)
	{
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login', 'refresh');
		}elseif ($this->ion_auth->is_admin() || $this->ion_auth->in_group((int)2)){
			$this->data['title']='DETAIL';
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
}

/* End of file Loan_in.php */
/* Location: ./application/controllers/Loan_in.php */