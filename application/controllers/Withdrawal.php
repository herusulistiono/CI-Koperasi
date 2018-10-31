<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Withdrawal extends CI_Controller {
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
			$this->data['title']='PENARIKAN SIMPANAN';
			$ID=$this->deposit_m->generate_code_deb()->row();
			$dep_code=$ID->kd_deb_simp;
			if ($dep_code){
				$setcode=substr($dep_code,2);
				$code=(int)$setcode;
			    $code=$code+1;
			    $this->data['generate']='DB'.str_pad($code, 4,'0',STR_PAD_LEFT);
			}else{
				$this->data['generate']='DB0001';
			}
			$this->data['members'] = $this->deposit_m->get_member()->result();
			$this->data['withdrawal']=$this->deposit_m->withdrawal()->result();
			$this->backend->display('deposit/index_withdrawal',$this->data);
		}else{
			return show_error('You must be an administrator to view this page.');
		}
	}
	public function get_savings()
	{
		$kd_angg=$this->input->post('kd_angg');
		$data=$this->deposit_m->get_savings($kd_angg)->row();
		echo json_encode($data);
	}
	public function save_withdrawal()
	{
		$errors=array();
		$info=array();
		if(empty($this->input->post('tgl_deb_simp')))
			$errors['tgl_deb_simp']='wajib Diisi';
		if(empty($this->input->post('kd_angg')))
			$errors['kd_angg']='wajib Diisi';
		if(empty($this->input->post('jml_deb')))
			$errors['jml_deb']='wajib Diisi';
		if(!empty($errors)) {
	        $info['success'] = false;
	        $info['errors']  = $errors;
	    }else {
	    	$jml_deb = str_replace(',', '', $this->input->post('jml_deb'));
	        $data=array(
	        	'kd_deb_simp'=>$this->input->post('code'),
				'kd_angg'=>$this->input->post('kd_angg'),
				'tgl_deb_simp'=>date('Y-m-d',strtotime($this->input->post('tgl_deb_simp'))),
				'jml_deb'=>$jml_deb,
				'user_id'=>$this->input->post('userID')
	        );
	        $this->deposit_m->withdrawal_insert($data);
	        $info['success']=true;
	        $info['message']='Berhasil Disimpan!';
	    }
	    echo json_encode($info);
	}
}

/* End of file Withdrawal.php */
/* Location: ./application/controllers/Withdrawal.php */