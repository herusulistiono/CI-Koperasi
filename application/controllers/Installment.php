<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Installment extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('loan_m'));
	}
	public function index()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login', 'refresh');
		}elseif ($this->ion_auth->is_admin() || $this->ion_auth->in_group((int)2)){
			$this->data['title']='ANGSURAN PEMBAYARAN';
			$this->data['loan_code'] = $this->loan_m->get_loan_approve()->result();
			$this->data['members'] = $this->loan_m->get_loan_approve()->result();
			//Generate Kwitansi Code
			$ID=$this->loan_m->generate_invoice()->row();
			$invoice_no=$ID->no_kwitansi;
			if ($invoice_no){
				$setcode=substr($invoice_no,2);
				$code=(int)$setcode;
			    $code=$code+1;
			    $this->data['generate']='KW'.str_pad($code, 4,'0',STR_PAD_LEFT);
			}else{
				$this->data['generate']='KW0001';
			}
			$this->backend->display('loan/index_installment', $this->data);
		}else{
			return show_error('Bukan Halaman Otoritas Anda.');
		}
	}
	public function check_amount_loan()
	{
		$kd_pinj = $this->input->post('kd_pinj');
		$data=$this->loan_m->get_loan($kd_pinj)->row_array();
		echo json_encode($data);
	}
	public function show_installment()
	{
		$kd_pinj=$this->input->post('kd_pinj');
		$loan=$this->loan_m->get_installment($kd_pinj)->result();
        $data=array();
		$no=(int)1;
		foreach ($loan as $rows) {
			$status=$rows->status;
			array_push($data, 
				array(
					$rows->no_kwitansi.' / '. $rows->kd_pinj,
					tanggal_indo($rows->tgl_bayar),
					$rows->angs_ke,
					number_format($rows->jml_bayar,0,',',','),
					$status,
					anchor('installment/invoice/'.$rows->no_kwitansi,'<i class="fa fa-print"></i>',array('class'=>'btn btn-success btn-xs','target'=>'_blank'))
				)
			);
		}
		echo json_encode(array('data'=>$data));
	}
	public function save_installment()
	{
		$errors=array();
		$info=array();
		if(empty($this->input->post('kd_pinj')))
			$errors['kd_pinj']= 'WAJIB DIISI';
		if(empty($this->input->post('tgl_bayar')))
			$errors['tgl_bayar']= 'WAJIB DIISI';
		if(!empty($errors)) {
	        $info['success'] = false;
	        $info['errors']  = $errors;
	    }else {
	    	$jml_bayar = str_replace(',', '', $this->input->post('jml_bayar'));
	    	$data=array(
	    		'no_kwitansi'=>$this->input->post('code'),
	    		'kd_pinj'=>$this->input->post('kd_pinj'),
	    		'tgl_bayar'=>date('Y-m-d',strtotime($this->input->post('tgl_bayar'))),
	    		'jml_bayar'=>$jml_bayar,
	    		'angs_ke'=>$this->input->post('angs_ke')
	    	);
	        $this->loan_m->insert_installment($data);
	        $info['success']=true;
	        $info['message']='Berhasil Disimpan!';
	    }
	    echo json_encode($info);
	}
	public function invoice($no_kwitansi)
	{
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login', 'refresh');
		}elseif ($this->ion_auth->is_admin() || $this->ion_auth->in_group((int)2) || $this->ion_auth->in_group((int)6)){
			$this->data['title']='KWITANSI';
			$invoice=$this->loan_m->create_invoice($no_kwitansi)->row();
			$this->data['no_kwitansi']=$invoice->no_kwitansi;
			$this->data['kd_pinj']=$invoice->kd_pinj;
			$this->data['jml_bayar']=$invoice->jml_bayar;
			$this->load->view('loan/loan_invoice_installment',$this->data);
		}else{
			return show_error('You must be an administrator to view this page.');
		}
	}
}

/* End of file Installment.php */
/* Location: ./application/controllers/Installment.php */