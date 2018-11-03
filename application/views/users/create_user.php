<div class="box box-primary">
  <div class="box-header with-border"><h3 class="box-title"><?php echo $title; ?></h3></div>
  <div class="box-body">
    <div class="col-md-12"><div id="msg"><?php echo $message;?></div></div>
    <div class="col-md-6">
      <?php echo form_open("users/create_user",array("onSubmit"=>"return validate(this)","autocomplete"=>"off"));?>
        <div class="form-group">
          <?php echo lang('create_user_fname_label', 'first_name');?>
          <?php echo form_input($first_name);?>
        </div>
        <div class="form-group">
          <?php echo lang('create_user_lname_label', 'last_name');?>
          <?php echo form_input($last_name);?>
        </div>
        <?php
          if($identity_column!=='email') {
            echo '<div class="form-group">';
            echo lang('create_user_identity_label', 'identity');
            echo form_error('identity');
            echo form_input($identity);
            echo '</div>';
           }?>
        <div class="form-group">
          <?php echo lang('create_user_company_label','company');?>
          <?php echo form_input($company);?>
        </div>
        <div class="form-group">
          <?php echo lang('create_user_email_label','email');?>
          <?php echo form_input($email);?>
        </div>
        <div class="form-group">
          <?php echo lang('create_user_phone_label','phone');?>
          <?php echo form_input($phone);?>
        </div>
        <div class="form-group">
          <?php echo lang('create_user_password_label','password');?>
          <?php echo form_input($password);?>
        </div>
        <div class="form-group">
          <?php echo lang('create_user_password_confirm_label','password_confirm');?>
          <?php echo form_input($password_confirm);?>
        </div>
        <div class="form-group">
          <?php echo form_submit('submit', lang('create_user_submit_btn'),array('class'=>'btn btn-primary'));?>
          <?php echo anchor('users', 'Cancel',array('class'=>'btn btn-warning')); ?>
        </div>
      <?php echo form_close();?>
    </div>
    <div class="col-md-6"></div>
  </div>
</div>

<script type="text/javascript">
  function validate(form){
    if (form.first_name.value == ""){
      $('#msg').html('Please Enter Firstname').addClass('alert alert-danger');
      form.first_name.focus();
      return false;
    }
    if (form.last_name.value == ""){
      $('#msg').html('Please Enter Lastname').addClass('alert alert-danger');
      form.last_name.focus();
      return false;
    }
    if (form.email.value == ""){
      $('#msg').html('Please Enter Email').addClass('alert alert-danger');
      form.email.focus();
      return false;
    }
    if (form.password.value == ""){
      $('#msg').html('Please Enter Password').addClass('alert alert-danger');
      form.password.focus();
      return false;
    }
    if (form.password_confirm.value == ""){
      $('#msg').html('Please Enter Confirm Password').addClass('alert alert-danger');
      form.password_confirm.focus();
      return false;
    }
    return (true);
  }
</script>