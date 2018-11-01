<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title><?php echo $title; ?></title>
    <!-- Main CSS-->
    <link rel="stylesheet" href="<?php echo base_url('dist/vendor/font-awesome/css/fontawesome-all.min.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('dist/css/styles.css');?>"/>
    <link rel="stylesheet" href="<?php echo base_url('dist/css/notify.css');?>"/>
  </head>
  <body onload="document.login.identity.focus();">
	<h1><?php echo lang('reset_password_heading');?></h1>

	<div id="infoMessage"><?php echo $message;?></div>

	<?php echo form_open('dashboard/auth/reset_password/' . $code);?>

		<p>
			<label for="new_password"><?php echo sprintf(lang('reset_password_new_password_label'), $min_password_length);?></label> <br />
			<?php echo form_input($new_password);?>
		</p>

		<p>
			<?php echo lang('reset_password_new_password_confirm_label', 'new_password_confirm');?> <br />
			<?php echo form_input($new_password_confirm);?>
		</p>

		<?php echo form_input($user_id);?>
		<?php echo form_hidden($csrf); ?>

		<p><?php echo form_submit('submit', lang('reset_password_submit_btn'));?></p>

	<?php echo form_close();?>
</body>
</html>