<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Members extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('members_m'));
	}
	public function index()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login', 'refresh');
		}elseif (!$this->ion_auth->is_admin() && !$this->ion_auth->in_group((int)2)){
			return show_error('You must be an administrator to view this page.');
		}else{
			$this->data['title']='ANGGOTA';
			//$this->data['members'] = $this->members_m->get_all()->result();
			$this->backend->display('members/index',$this->data);
		}
	}
	public function json_members()
	{
        $data=array();
		$no=(int)1;
		$members=$this->members_m->get_all()->result();
		foreach ($members as $rows) {
			array_push($data, 
				array(
					$no++,
					$rows->kd_angg,
					$rows->ktp,
					$rows->nm_angg,
					$rows->kelamin,
					$rows->telp,
					$rows->tmpt_lahir.', '.date('d M Y',strtotime($rows->tgl_lahir)),
					tanggal_indo($rows->sejak),
					$rows->aktif,
					anchor('members/edit/'.$rows->kd_angg,'<i class="fa fa-pencil"></i>',array('class'=>'btn btn-xs btn-success','data-toggle'=>'tooltip','title'=>'EDIT'))
				)
			);
		}
		echo json_encode(array('data'=>$data));
	}
	public function add()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login', 'refresh');
		}elseif (!$this->ion_auth->is_admin() && !$this->ion_auth->in_group((int)2)){
			return show_error('You must be an administrator to view this page.');
		}else{
			$this->data['title']='ANGGOTA';
			//Set Increment Member ID
			$rowID=$this->members_m->generate_code()->row();
			$member_code=$rowID->kd_angg;
			if ($member_code){
				$setcode=substr($member_code,2);
				$code=(int)$setcode;
			    $code=$code+1;
			    $this->data['generate']='AG'.str_pad($code, 3,'0',STR_PAD_LEFT);
			}else{
				$this->data['generate']='AG001';
			}
			$this->backend->display('members/add',$this->data);
		}
	}
	public function edit($kd_angg)
	{
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login', 'refresh');
		}elseif (!$this->ion_auth->is_admin() && !$this->ion_auth->in_group((int)2)){
			return show_error('You must be an administrator to view this page.');
		}else{
			$this->data['title']='Ubah Data Anggota';
			$members = $this->members_m->get_member_id($kd_angg)->row();
			$this->data['memberID'] = array(
				'name'  => 'memberID',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('memberID', $members->kd_angg),
				'class'	=> 'form-control',
				'readonly'=>'readonly input-sm'
			);
			$this->data['ktp_number'] = array(
				'name'  => 'ktp_number',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('ktp_number', $members->ktp),
				'class'	=> 'form-control input-sm'
			);
			$this->data['fullname'] = array(
				'name'  => 'fullname',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('fullname', $members->nm_angg),
				'class'	=> 'form-control input-sm'
			);
			$this->data['sex'] = $members->kelamin;
			//$this->data['type_id'] = $members->type_id;
			$this->data['phone'] = array(
				'name'  => 'phone',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('phone', $members->telp),
				'class'	=> 'form-control input-sm'
			);
			$this->data['place_of_birth'] = array(
				'name'  => 'place_of_birth',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('place_of_birth', $members->tmpt_lahir),
				'class' => 'form-control input-sm'
			);
			//$dob=($members->date_of_birth == '00-00-0000') ? '' : $members->date_of_birth;
			$this->data['date_of_birth'] = array(
				'name'  => 'date_of_birth',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('date_of_birth',$members->tgl_lahir),
				'id'    => 'date_of_birth',
				'class' => 'form-control input-sm'
			);
			$this->data['address'] = array(
				'name'  => 'address',
				'cols'  => 10,
				'rows'  => 5,
				'value' => $this->form_validation->set_value('address',$members->alamat),
				'class' => 'form-control'
			);
			$this->data['registered'] = array(
				'name'  => 'registered',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('registered',$members->sejak),
				'id'    => 'registered',
				'class' => 'form-control input-sm'
			);
			$this->backend->display('members/edit',$this->data);
		}
	}
	public function insert()
	{
		$errors=array();
		$info=array();
		if(empty($this->input->post('ktp_number')))
        	$errors['ktp_number']='No KTP Wajib Diisi.';
		if(empty($this->input->post('fullname')))
        	$errors['fullname']='Nama Anggota Wajib Diisi.';
        if (empty($this->input->post('sex')))
        	$errors['sex']='Pilih Jenis Kelamin';
        if(empty($this->input->post('place_of_birth'))) 
        	$errors['place_of_birth']='Tempat Lahir Wajib Diisi';
        if(empty($this->input->post('date_of_birth')))
        	$errors['date_of_birth']='Tanggal Lahir Wajib Diisi';
        if(empty($this->input->post('phone')))
        	$errors['phone']='No Telp Wajib Diisi';
        if(empty($this->input->post('address')))
        	$errors['address']='Alamat Wajib Diisi';
        if(empty($this->input->post('registered')))
        	$errors['registered']='Wajib Diisi';
		if (!empty($errors)) {
	        $info['success'] = false;
	        $info['errors']  = $errors;
	    } else {
	    	$dob=date('Y-m-d',strtotime($this->input->post('date_of_birth')));
	        $data=array(
				'kd_angg'=>$this->input->post('memberID'),
				'ktp'=>$this->input->post('ktp_number'),
				'nm_angg'=>$this->input->post('fullname'),
				'kelamin'=>$this->input->post('sex'),
				'tgl_lahir'=>$dob,
				'tmpt_lahir'=>$this->input->post('place_of_birth'),
				'telp'=>$this->input->post('phone'),
				'alamat'=>$this->input->post('address'),
				'sejak'=>$this->input->post('registered')
			);
			$this->members_m->insert($data);
	        $info['success'] = true;
	        $info['message'] = 'Berhasil Tersimpan!';
	    }
	    echo json_encode($info);
	}
	public function update()
	{
		$errors=array();
		$info=array();
		if(empty($this->input->post('ktp_number')))
        	$errors['ktp_number']='No KTP Wajib Diisi.';
		if(empty($this->input->post('fullname')))
        	$errors['fullname']='Nama Anggota Wajib Diisi.';
        if (empty($this->input->post('sex')))
        	$errors['sex']='Pilih Jenis Kelamin';
        if(empty($this->input->post('place_of_birth'))) 
        	$errors['place_of_birth']='Tempat Lahir Wajib Diisi';
        if(empty($this->input->post('date_of_birth')))
        	$errors['date_of_birth']='Tanggal Lahir Wajib Diisi';
        if(empty($this->input->post('phone')))
        	$errors['phone']='No Telp Wajib Diisi';
        if(empty($this->input->post('address')))
        	$errors['address']='Alamat Wajib Diisi';
        if(empty($this->input->post('registered')))
        	$errors['registered']='Wajib Diisi';
		if (!empty($errors)) {
	        $info['success'] = false;
	        $info['errors']  = $errors;
	    } else {
	        $dob=date('Y-m-d',strtotime($this->input->post('date_of_birth')));
	        $data=array(
				'kd_angg'=>$this->input->post('memberID'),
				'ktp'=>$this->input->post('ktp_number'),
				'nm_angg'=>$this->input->post('fullname'),
				'kelamin'=>$this->input->post('sex'),
				'tgl_lahir'=>$dob,
				'tmpt_lahir'=>$this->input->post('place_of_birth'),
				'telp'=>$this->input->post('phone'),
				'alamat'=>$this->input->post('address'),
				'sejak'=>$this->input->post('registered')
			);
			$this->members_m->update($data);
	        $info['success'] = true;
	        $info['message'] = 'Berhasil Diubah!';
	    }
	    echo json_encode($info);
	}
}

/* End of file Members.php */
/* Location: ./application/controllers/Members.php */