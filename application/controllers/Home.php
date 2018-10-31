<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('alert_model'));
	}
	public function index()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login', 'refresh');
		}else{
			$this->data['title']='Beranda';
			$this->data['members']=$this->alert_model->count_of_members()->row();
			$this->data['loan']=$this->alert_model->alert_on_loan()->row();
			$this->data['loan_acc']=$this->alert_model->loan_accepted()->row();
			$this->data['loan_den']=$this->alert_model->loan_cancel()->row();
			$this->data['amount_savings']=$this->alert_model->savings()->row();
			$this->backend->display('home',$this->data);
		}
	}

}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */