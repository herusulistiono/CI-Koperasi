<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Deposit extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('deposit_m','members_m'));
	}
	public function index()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login', 'refresh');
		}elseif ($this->ion_auth->is_admin()){
			$this->data['title']='DATA SIMPANAN';
			$this->data['deposit']=$this->deposit_m->get_all()->result();
			$this->data['members'] = $this->members_m->get_all()->result();
			//Generate Code Deposit
			$rowID=$this->deposit_m->generate_code()->row();
			$dep_code=$rowID->kd_simp;
			if ($dep_code){
				$setcode=substr($dep_code,2);
				$code=(int)$setcode;
			    $code=$code+1;
			    $this->data['generate']='SP'.str_pad($code, 4,'0',STR_PAD_LEFT);
			}else{
				$this->data['generate']='SP0001';
			}
			$this->backend->display('deposit/index',$this->data);
		}elseif($this->ion_auth->in_group((int)2)){
			$this->data['title']='DATA SIMPANAN';
			$this->data['deposit']=$this->deposit_m->get_all()->result();
			$this->data['members'] = $this->members_m->get_all()->result();
			//Generate Code Deposit
			$rowID=$this->deposit_m->generate_code()->row();
			$dep_code=$rowID->kd_simp;
			if ($dep_code){
				$setcode=substr($dep_code,2);
				$code=(int)$setcode;
			    $code=$code+1;
			    $this->data['generate']='SP'.str_pad($code, 4,'0',STR_PAD_LEFT);
			}else{
				$this->data['generate']='SP0001';
			}
			$this->backend->display('deposit/index_staff',$this->data);
		}else{
			return show_error('You must be an administrator to view this page.');
		}
	}
	public function get_by_id()
	{
		$kd_simp=$this->input->post('kd_simp');
		$data=$this->deposit_m->get_primary($kd_simp)->row();
		$data->tgl_simp=date('d-m-Y',strtotime($data->tgl_simp));
		echo json_encode($data);
	}
	public function save()
	{
		$errors=array();
		$info=array();
		if(empty($this->input->post('tgl_simp')))
        	$errors['tgl_simp'] = 'Tanggal Harus Diisi.';
		if(empty($this->input->post('kd_angg')))
        	$errors['kd_angg'] = 'Anggota Belum Diisi.';
		if(!empty($errors)) {
	        $info['success'] = false;
	        $info['errors']  = $errors;
	    }else {
	    	$wajib = str_replace(',', '', $this->input->post('wajib'));
	    	$pokok = str_replace(',', '', $this->input->post('pokok'));
	    	$sukarela = str_replace(',', '', $this->input->post('sukarela'));
	        $data=array(
	        	'kd_simp'=>$this->input->post('code'),
				'kd_angg'=>$this->input->post('kd_angg'),
				'tgl_simp'=>date('Y-m-d',strtotime($this->input->post('tgl_simp'))),
				'wajib'=>$wajib,
				'pokok'=>$pokok,
				'sukarela'=>$sukarela
	        );
	        $this->deposit_m->insert($data);
	        $info['success']=true;
	        $info['message']='Berhasil Disimpan!';
	    }
	    echo json_encode($info);
	}
	public function update()
	{
		$errors=array();
		$info=array();
		if(empty($this->input->post('tgl_simp')))
        	$errors['tgl_simp'] = 'Tanggal Harus Diisi.';
		if(empty($this->input->post('kd_angg')))
        	$errors['kd_angg'] = 'Anggota Belum Diisi.';
		if(!empty($errors)) {
	        $info['success'] = false;
	        $info['errors']  = $errors;
	    }else {
	    	$wajib = str_replace(',', '', $this->input->post('wajib'));
	    	$pokok = str_replace(',', '', $this->input->post('pokok'));
	    	$sukarela = str_replace(',', '', $this->input->post('sukarela'));
	        $data=array(
	        	'kd_simp'=>$this->input->post('code'),
				'kd_angg'=>$this->input->post('kd_angg'),
				'tgl_simp'=>date('Y-m-d',strtotime($this->input->post('tgl_simp'))),
				'wajib'=>$wajib,
				'pokok'=>$pokok,
				'sukarela'=>$sukarela
	        );
	        $this->deposit_m->update($data);
	        $info['success']=true;
	        $info['message']='Berhasil Diubah!';
	    }
	    echo json_encode($info);
	}
	public function delete()
	{
		$depoID=$this->input->post('depoID');
		$this->deposit_m->delete($depoID);
		echo json_encode(array("status" => TRUE));
	}
}

/* End of file Deposit.php */
/* Location: ./application/controllers/Deposit.php */