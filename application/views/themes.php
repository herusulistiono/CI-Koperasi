<?php 
$id=$this->ion_auth->user()->row()->id;
$fullname = $this->ion_auth->user()->row()->first_name.'&nbsp;'.$this->ion_auth->user()->row()->last_name;
$photo = $this->ion_auth->user()->row()->photo;
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php echo $title ?></title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.7 -->
	<link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/font-awesome/css/font-awesome.min.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/Ionicons/css/ionicons.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/select2/css/select2.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css');?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/iCheck/all.css');?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/datatables.net-bs/css/dataTables.bootstrap.min.css');?>">
  <!-- Theme style -->
	<link rel="stylesheet" href="<?php echo base_url('assets/css/AdminLTE.min.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/css/skins/_all-skins.min.css');?>">
	<!-- Javascript -->
	<script src="<?php echo base_url('assets/plugins/jquery/dist/jquery.min.js');?>"></script>
  <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js');?>"></script>
  <script src="<?php echo base_url('assets/select2/js/select2.min.js');?>"></script>
  <script src="<?php echo base_url('assets/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js');?>"></script>
  <script src="<?php echo base_url('assets/datatables.net/js/jquery.dataTables.min.js');?>"></script>
  <script src="<?php echo base_url('assets/datatables.net-bs/js/dataTables.bootstrap.min.js')?>"></script>
  <script src="<?php echo base_url('assets/jquery-slimscroll/jquery.slimscroll.min.js');?>"></script>
  <script src="<?php echo base_url('assets/plugins/iCheck/icheck.min.js');?>"></script>
  <script src="<?php echo base_url('assets/fastclick/lib/fastclick.js');?>"></script>
  <script src="<?php echo base_url('assets/plugins/input-mask/jquery.inputmask.js')?>"></script>
  <script src="<?php echo base_url('assets/plugins/input-mask/jquery.inputmask.date.extensions.js')?>"></script>
  <script src="<?php echo base_url('assets/plugins/input-mask/jquery.inputmask.extensions.js')?>"></script>

  <script src="<?php echo base_url('assets/js/adminlte.min.js');?>"></script>
  <script src="<?php echo base_url('assets/js/apps.js');?>"></script>
</head>
<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">
  <header class="main-header">
    <a href="" class="logo">
      <span class="logo-mini"><img src="<?php echo base_url('assets/img/logo.png');?>" style="width: 30px; height: 30px"/></span>
      <span class="logo-lg"><b>Kop</b>Indra</span>
    </a>
    <nav class="navbar navbar-static-top">
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
            <a href="<?php echo site_url('auth/edit_user/'.$this->ion_auth->user()->row()->id)?>">
              <img src="<?php echo base_url('assets/img/'.$photo) ?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $fullname ?></span>
            </a>
            <!--
            <ul class="dropdown-menu">
              <li class="user-header">
                <img src="<?php echo base_url('assets/img/'.$photo) ?>" class="img-circle" alt="User Image">
                <p>
                  <?php echo $fullname ?>
                  <small></small>
                </p>
              </li>
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>
              </li> 
              <li class="user-footer">
                <div class="pull-left">
                  <?php //echo anchor('auth/edit_user/'.$this->ion_auth->user()->row()->id,'Profile',array('class'=>'btn btn-default btn-flat')); ?>
                </div>
                <div class="pull-right">
                  <?php //echo anchor('auth/change_password','Change Password',array('class'=>'btn btn-default btn-flat')); ?>
                </div>
              </li>
            </ul>
          -->
          </li>
          <li>
            <?php echo anchor('auth/logout','<i class="fa fa-power-off"></i>'); ?>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <aside class="main-sidebar">
    <section class="sidebar">
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo base_url('assets/img/'.$photo) ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $fullname;?></p>
          <i class="fa fa-circle text-success"></i> Online
        </div>
      </div>
      <?php $this->load->view('navleft'); ?>
    </section>
  </aside>
  <div class="content-wrapper">
    <section class="content">
     	<?php echo $_content; ?>
    </section>
  </div>
  <footer class="main-footer">
    <div class="pull-right hidden-xs"><?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></div>
    <strong>Copyright &copy; <?php echo date('Y') ?> <a href="https://herusulistiono.net">Heru Sulistiono</a>.</strong> All rights reserved.
  </footer>
  <div class="control-sidebar-bg"></div>
</div>
</body>
</html>