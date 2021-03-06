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
  <body style="background-color: #ffffff;" class="hold-transition skin-green login-page">
	<div class="login-box">
      <div class="login-logo"><img src="<?php echo base_url('assets/img/logo.png');?>"/></div>
      <div class="login-box-body">
        <p class="login-box-msg">
          <div class="error"><?php echo $message;?></div>
        </p>
        <?php echo form_open('auth/reset_password/' . $code);?>
          <div class="form-group has-feedback">
            <label for=""><?php echo sprintf(lang('reset_password_new_password_label'), $min_password_length);?></label>
            <?php echo form_input($new_password);?>
          </div>
          <div class="form-group has-feedback">
            <?php echo lang('reset_password_new_password_confirm_label', 'new_password_confirm');?>
            <?php echo form_input($new_password_confirm);?>
          </div>
          <?php echo form_input($user_id);?>
          <?php echo form_hidden($csrf); ?>
          <div class="social-auth-links text-center">
            <button type="submit" class="btn btn-success btn-block btn-flat"><?php echo lang('reset_password_submit_btn') ?></button>
            <?php //echo form_submit('submit', lang('reset_password_submit_btn'));?>
          </div>
        <?php echo form_close(); ?>
      </div>
    </div>
	<script src="<?php echo base_url('assets/plugins/jquery/dist/jquery.min.js');?>"></script>
    <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js');?>"></script>
</body>
</html>