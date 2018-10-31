<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('sales_m'));
	}
	public function index()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login', 'refresh');
		}elseif ($this->ion_auth->is_admin() || $this->ion_auth->in_group((int)2)){
			$this->data['title']='TRANSAKSI';
			$this->backend->display('sales/index_sales',$this->data);
		}else{
			return show_error('You must be an administrator to view this page.');
		}
	}
	public function check_data()
	{
		$barcode=$this->input->post('barcode');
		$data=$this->sales_m->check($barcode);
		echo json_encode($data);
	}
	public function addto_cart()
	{
		$price = str_replace(',', '', $this->input->post('harga_jual'));
		$data = array(
			'id'=>$this->input->post('kd_prod'),
			'name'=>$this->input->post('nm_prod'),
			'qty'=>$this->input->post('qty'),
			'price'=>$price,
		);
		$this->cart->insert($data);
		echo json_encode(array("status"=>TRUE));
	}
	public function list_transactions()
	{
		$cart_data=$this->cart->contents();
		$data=array();
		$no=(int)1;
		foreach ($cart_data as $rows) {
			array_push($data, 
				array(
					$no,
					$rows['id']. form_hidden('kd_prod[]', $rows['id']),
					$rows['name'],
					$rows['qty']. form_hidden('qty[]', $rows['qty']),
					number_format($rows['price'],0,',',','),
					number_format($rows['subtotal'],0,',',','),
					'<a href="javascript:void(0)" onclick="deleteCart('."'".$rows["rowid"]."'".','."'".$rows['subtotal']."'".')" class="btn btn-danger btn-xs"> <i class="fa fa-remove"></i></a>'
				)
			);
			$no++;
		}
		echo json_encode(array('data'=>$data));
	}
	public function delete_cart($rowid) 
	{
		$this->cart->update(array('rowid'=>$rowid,'qty'=>0));
		echo json_encode(array("status" => TRUE));
	}
	public function payment()
	{
		$kd_prod=$this->input->post('kd_prod[]');
		$data=array();
		foreach ($kd_prod as $key => $value) {
			$data[] = array(
				'kd_prod' => $this->input->post('kd_prod')[$key],
				'qty' => $this->input->post('qty')[$key],
				'user_id'=>$this->input->post('user_id')
			);
		}
		$this->sales_m->insert_payment($data);
		$this->cart->destroy();
		echo json_encode(array("status" => TRUE));
		//print_r($data);
	}
}

/* End of file Sales.php */
/* Location: ./application/controllers/Sales.php */
