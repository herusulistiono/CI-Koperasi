<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('category_m');
	}
	public function index()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login', 'refresh');
		}elseif ($this->ion_auth->is_admin() || $this->ion_auth->in_group((int)2)){
			$this->data['title']='KATEGORI';
			$this->data['category']=$this->category_m->get_category()->result();
			$this->backend->display('product/index_category',$this->data);
		}else{
			return show_error('You must be an administrator to view this page.');
		}
	}
	public function get_by_id()
	{
		$id_kat=$this->input->post('id_kat');
		$data=$this->category_m->get_primary($id_kat)->row();
		echo json_encode($data);
	}
	public function save()
	{
		$errors=array();
		$info=array();
		if(empty($this->input->post('nm_kategori')))
        	$errors['nm_kategori'] = 'NAMA KATEGORI HARUS DIISI.';
		if(!empty($errors)) {
	        $info['success'] = false;
	        $info['errors']  = $errors;
	    }else {
	    	$data=array(
	    		'nm_kategori'=>$this->input->post('nm_kategori'),
	    		'seo'=>url_title($this->input->post('nm_kategori'), 'dash', TRUE)
	    	);
	        $this->category_m->insert($data);
	        $info['success']=true;
	        $info['message']='Berhasil Disimpan!';
	    }
	    echo json_encode($info);
	}
	public function update()
	{
		$errors=array();
		$info=array();
		if(empty($this->input->post('nm_kategori')))
        	$errors['nm_kategori'] = 'NAMA KATEGORI HARUS DIISI.';
		if(!empty($errors)) {
	        $info['success'] = false;
	        $info['errors']  = $errors;
	    }else {
	    	$data=array(
	    		'id_kat'=>$this->input->post('id_kat'),
	    		'nm_kategori'=>$this->input->post('nm_kategori'),
	    		'seo'=>url_title($this->input->post('nm_kategori'), 'dash', TRUE)
	    	);
	        $this->category_m->update($data);
	        $info['success']=true;
	        $info['message']='Berhasil Diubah!';
	    }
	    echo json_encode($info);
	}

}

/* End of file Category.php */
/* Location: ./application/controllers/Category.php */