<!DOCTYPE html>
<html>
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <title><?php echo $title; ?></title>
  <link rel="shortcut icon" href="<?php echo base_url('assets/img/favicon.ico') ?>" type="image/x-icon">
  <link rel="icon" href="<?php echo base_url('assets/img/favicon.ico') ?>" type="image/x-icon">
  <!-- Main CSS-->
   <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css');?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/font-awesome/css/font-awesome.min.css');?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/AdminLTE.min.css');?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/iCheck/square/blue.css');?>">
  </head>
  <body style="background-color: #ffffff;" class="hold-transition skin-green login-page" onload="document.login.identity.focus();">
    <div class="login-box">
      <div class="login-logo"><img src="<?php echo base_url('assets/img/logo.png');?>"/></div>
      <div class="login-box-body">
        <p class="login-box-msg">
          <div class="error"><?php echo $message;?></div>
        </p>
        <?php echo form_open('auth/login',array("name"=>"login","onSubmit"=>"return validate(this)","autocomplete"=>"off")); ?>
          <div class="form-group has-feedback">
            <?php echo form_input($identity);?>
            <span class="help-block"></span>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <?php echo form_input($password);?>
            <span class="help-block"></span>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-6">
              <div class="checkbox icheck">
                <label>
                  <input type="checkbox"> Remember Me
                </label>
              </div>
            </div>
            <div class="col-xs-6">
              <div class="checkbox icheck">
                <label>
                  <?php echo anchor('auth/forgot_password','Lost Password'); ?>
                </label>
              </div>
            </div>
          </div>
        <div class="social-auth-links text-center">
          <button type="submit" class="btn btn-success btn-block btn-flat">Login</button>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </body>
  <script src="<?php echo base_url('assets/plugins/jquery/dist/jquery.min.js');?>"></script>
  <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js');?>"></script>
  <script src="<?php echo base_url('assets/plugins/iCheck/icheck.min.js');?>"></script>
  <script type="text/javascript">
    $(function () {
      $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' /* optional */
      });
      /*$('input[type="text"]').change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
      });*/
      $('.form-group').removeClass('has-error');
      $('.help-block').empty();
    });
    function validate(form){
      $('.form-group').removeClass('has-error');
      $('.help-block').empty();
      if (form.identity.value == ""){
        //$('.error').html('Mohon Isikan').addClass('alert alert-danger');
        form.identity.focus();
        $('input[name="identity"]').parent().addClass('has-error'); 
        $('input[name="identity"]').next().text('Usename Wajib Diisi');
        return false;
      }
      if (form.password.value == ""){
        //$('.error').html('Mohon Isikan').addClass('alert alert-danger');
        form.password.focus();
        $('input[name="password"]').parent().addClass('has-error'); 
        $('input[name="password"]').next().text('Password Wajib Diisi');
        return false;
      }
      return (true);
    }
  </script>
</html>