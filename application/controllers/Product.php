<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('product_m','category_m'));
	}
	public function index()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login', 'refresh');
		}elseif ($this->ion_auth->is_admin() || $this->ion_auth->in_group((int)2)){
			$this->data['title']='DATA PRODUK';
			$this->data['product']=$this->product_m->get_product()->result();
			$this->backend->display('product/index_product',$this->data);
		}else{
			return show_error('You must be an administrator to view this page.');
		}
	}
	public function check_barcode()
	{
		$barcode=$this->input->post('barcode');
		$data=$this->product_m->barcode_exists($barcode);
		echo json_encode($data);
	}
	public function add()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login', 'refresh');
		}elseif ($this->ion_auth->is_admin() || $this->ion_auth->in_group((int)2)){
			$this->data['title']='TAMBAH DATA PRODUK';
			//Set Increment Loan ID
			$rowID=$this->product_m->generate_code()->row();
			$kd_prod=$rowID->kd_prod;
			if ($kd_prod){
				$setcode=substr($kd_prod,2);
				$code=(int)$setcode;
			    $code=$code+1;
			    $this->data['generate']='BR'.str_pad($code,4,'0',STR_PAD_LEFT);
			}else{
				$this->data['generate']='BR0001';
			}
			$this->data['category']=$this->category_m->get_category()->result();
			$this->data['product']=$this->product_m->get_product()->result();
			$this->backend->display('product/add_product',$this->data);
		}else{
			return show_error('You must be an administrator to view this page.');
		}
	}
	public function edit($kd_prod)
	{
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login', 'refresh');
		}elseif ($this->ion_auth->is_admin() || $this->ion_auth->in_group((int)2)){
			$this->data['title']='UBAH DATA PRODUK';
			$this->data['category']=$this->category_m->get_category()->result();
			$product = $this->product_m->get_primary($kd_prod)->row();
			$this->data['kd_prod'] = array(
				'name'  => 'kd_prod',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('kd_prod', $product->kd_prod),
				'class'	=> 'form-control input-sm',
				'readonly'=>'readonly'
			);
			$this->data['barcode'] = array(
				'name'  => 'barcode',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('barcode', $product->barcode),
				'class'	=> 'form-control input-sm',
			);
			$this->data['nm_prod'] = array(
				'name'  => 'nm_prod',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('nm_prod', $product->nm_prod),
				'class'	=> 'form-control input-sm',
			);
			$this->data['harga_beli'] = array(
				'name'  => 'harga_beli',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('harga_beli', $product->harga_beli),
				'id'    => 'rp1',
				'class'	=> 'form-control input-sm',
			);
			$this->data['harga_jual'] = array(
				'name'  => 'harga_jual',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('harga_jual', $product->harga_jual),
				'id'    => 'rp2',
				'class'	=> 'form-control input-sm',
			);
			$this->data['stok'] = array(
				'name'  => 'stok',
				'type'  => 'number',
				'value' => $this->form_validation->set_value('stok', $product->stok),
				'class'	=> 'form-control input-sm',
			);
			$this->data['satuan'] = array(
				'name'  => 'satuan',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('satuan', $product->satuan),
				'class'	=> 'form-control input-sm',
			);
			$this->data['id_kat'] = $product->id_kat;
			$this->backend->display('product/edit_product',$this->data);
		}else{
			return show_error('You must be an administrator to view this page.');
		}
	}
	public function save()
	{
		$errors=array();
		$info=array();
		if(empty($this->input->post('barcode')))
        	$errors['barcode']='Wajib Diisi.';
        if(empty($this->input->post('nm_prod')))
        	$errors['nm_prod']='Wajib Diisi.';
        if(empty($this->input->post('id_kat')))
        	$errors['id_kat']='Wajib Diisi.';
        if(empty($this->input->post('harga_beli')))
        	$errors['harga_beli']='Wajib Diisi.';
        if(empty($this->input->post('harga_jual')))
        	$errors['harga_jual']='Wajib Diisi.';
        if(empty($this->input->post('stok')))
        	$errors['stok']='Wajib Diisi.';
        if(empty($this->input->post('satuan')))
        	$errors['satuan']='Wajib Diisi.';

        if (!empty($errors)) {
	        $info['success'] = false;
	        $info['errors']  = $errors;
	    } else {
	    	$harga_beli = str_replace(',', '', $this->input->post('harga_beli'));
	    	$harga_jual = str_replace(',', '', $this->input->post('harga_jual'));
	    	$data=array(
	        	'kd_prod'=>$this->input->post('kd_prod'),
	        	'barcode'=>$this->input->post('barcode'),
	        	'nm_prod'=>$this->input->post('nm_prod'),
	        	'id_kat'=>$this->input->post('id_kat'),
	        	'harga_beli'=>$harga_beli,
	        	'harga_jual'=>$harga_jual,
	        	'stok'=>$this->input->post('stok'),
	        	'satuan'=>$this->input->post('satuan')
			);
			$this->product_m->insert($data);
	        $info['success'] = true;
	        $info['message'] = 'Berhasil Tersimpan!';
	    }
	    echo json_encode($info);
	}
	public function update()
	{
		$errors=array();
		$info=array();
		if(empty($this->input->post('barcode')))
        	$errors['barcode']='Wajib Diisi.';
        if(empty($this->input->post('nm_prod')))
        	$errors['nm_prod']='Wajib Diisi.';
        if(empty($this->input->post('id_kat')))
        	$errors['id_kat']='Wajib Diisi.';
        if(empty($this->input->post('harga_beli')))
        	$errors['harga_beli']='Wajib Diisi.';
        if(empty($this->input->post('harga_jual')))
        	$errors['harga_jual']='Wajib Diisi.';
        if(empty($this->input->post('stok')))
        	$errors['stok']='Wajib Diisi.';
        if(empty($this->input->post('satuan')))
        	$errors['satuan']='Wajib Diisi.';

        if (!empty($errors)) {
	        $info['success'] = false;
	        $info['errors']  = $errors;
	    } else {
	    	$harga_beli = str_replace(',', '', $this->input->post('harga_beli'));
	    	$harga_jual = str_replace(',', '', $this->input->post('harga_jual'));
	    	$data=array(
	        	'kd_prod'=>$this->input->post('kd_prod'),
	        	'barcode'=>$this->input->post('barcode'),
	        	'nm_prod'=>$this->input->post('nm_prod'),
	        	'id_kat'=>$this->input->post('id_kat'),
	        	'harga_beli'=>$harga_beli,
	        	'harga_jual'=>$harga_jual,
	        	'stok'=>$this->input->post('stok'),
	        	'satuan'=>$this->input->post('satuan')
			);
			$this->product_m->update($data);
	        $info['success'] = true;
	        $info['message'] = 'Berhasil Diubah!';
	    }
	    echo json_encode($info);
	}

}

/* End of file Product.php */
/* Location: ./application/controllers/Product.php */