<!DOCTYPE html>
<html>
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <title><?php echo $title; ?></title>
  <link rel="shortcut icon" href="<?php echo base_url('images/favicon.ico') ?>" type="image/x-icon">
  <link rel="icon" href="<?php echo base_url('images/favicon.ico') ?>" type="image/x-icon">
  <!-- Main CSS-->
  <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css');?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/font-awesome/css/font-awesome.min.css');?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/AdminLTE.min.css');?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/iCheck/square/blue.css');?>">
  </head>
  <body class="hold-transition skin-green login-page" onload="document.login.identity.focus();">
    <div class="login-box">
      <div class="login-logo"><img src="<?php echo base_url('assets/img/logo.png');?>"/></div>
      <div class="login-box-body">
        <p class="login-box-msg">
          <div class="error"><?php echo $message;?></div>
        </p>
        <?php echo form_open('auth/forgot_password',array("name"=>"login","onSubmit"=>"return validate(this)","autocomplete"=>"off")); ?>
          <div class="form-group has-feedback">
            <?php echo form_input($identity);?>
            <span class="help-block"></span>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="social-auth-links text-center">
            <button type="submit" class="btn btn-success btn-block btn-flat">Login</button>
            <br>
              <?php echo anchor('auth/login/', '<i class="fa fa-angle-double-right"></i> Back to Login');?>
          </div>
        <?php echo form_close(); ?>
      </div>
    </div>
    <script src="<?php echo base_url('assets/plugins/jquery/dist/jquery.min.js');?>"></script>
    <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js');?>"></script>
    <script type="text/javascript">
      $('.form-group').removeClass('has-error');
      $('.help-block').empty();
      function validate(form){
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();
        if (form.identity.value == ""){
          form.identity.focus();
          $('input[name="identity"]').parent().addClass('has-error'); 
          $('input[name="identity"]').next().text('Wajib Diisi');
          return false;
        }
        return (true);
      }
  </script>
  </body>
</html>