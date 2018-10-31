<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Net_income extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('deposit_m'));
	}
	public function index()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login', 'refresh');
		}elseif ($this->ion_auth->is_admin() || $this->ion_auth->in_group((int)2)){
			$this->data['title']='RINCIAN SHU';
			$this->data['members']=$this->deposit_m->get_member()->result();
			$this->backend->display('net_income/index', $this->data);
		}else{
			return show_error('Bukan Halaman Otoritas Anda.');
		}
	}
	public function savings_amount()
	{
		$first_date = date('Y-m-d',strtotime($this->input->post('f_date')));
		$last_date  = date('Y-m-d',strtotime($this->input->post('l_date')));
      	$data=$this->deposit_m->net_incomes($first_date,$last_date)->row();
		echo json_encode($data);
	}
	public function members_amount()
	{
		$members_id = $this->input->post('m_id');
		$first_date = date('Y-m-d',strtotime($this->input->post('f_date')));
		$last_date  = date('Y-m-d',strtotime($this->input->post('l_date')));
      	$data=$this->deposit_m->net_incomes_member($members_id,$first_date,$last_date)->row();
		echo json_encode($data);
	}
	public function save_net_income()
	{
		$errors=array();
		$info=array();
		if(empty($this->input->post('kd_angg')))
        	$errors['kd_angg'] = 'Anggota Harus Diisi.';
		if(empty($this->input->post('tgl_rekap')))
        	$errors['tgl_rekap'] = 'Tanggal Harus Diisi.';
		if(!empty($errors)) {
	        $info['success'] = false;
	        $info['errors']  = $errors;
	    }else {
	    	$sembako = str_replace(',', '', $this->input->post('sembako'));
	    	$btn = str_replace(',', '', $this->input->post('btn'));
	    	$bsm = str_replace(',', '', $this->input->post('bsm'));
	        $data=array(
	        	'kd_angg'=>$this->input->post('kd_angg'),
				'tgl_rekap'=>date('Y-m-d',strtotime($this->input->post('tgl_rekap'))),
				'sembako'=>$sembako,
				'btn'=>$btn,
				'bsm'=>$bsm
	        );
	        $this->deposit_m->save_net_income($data);
	        $info['success']=true;
	        $info['message']='Berhasil Disimpan!';
	    }
	    echo json_encode($info);
	}
}

/* End of file Net_income.php */
/* Location: ./application/controllers/Net_income.php */