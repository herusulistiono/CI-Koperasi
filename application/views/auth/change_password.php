<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $title;?></h3>
  </div>
  <div class="box-body">
    <?php echo form_open("auth/change_password");?>
      <?php echo $message;?>
      <div class="form-group">
        <?php echo lang('change_password_old_password_label', 'old_password');?>
        <?php echo form_input($old_password);?>
      </div>
      <div class="form-group">
        <label for="new_password"><?php echo sprintf(lang('change_password_new_password_label'), $min_password_length);?></label>
          <?php echo form_input($new_password);?>
      </div>
      <div class="form-group">
        <?php echo lang('change_password_new_password_confirm_label','new_password_confirm');?>
        <?php echo form_input($new_password_confirm);?>
      </div>
      <?php echo form_input($user_id);?>
      <?php echo form_submit('submit', lang('change_password_submit_btn'),array('class'=>'btn btn-success btn-sm'));?>
      <?php echo anchor('home','Cancel',array('class'=>'btn btn-warning btn-sm')); ?>
    <?php echo form_close();?>
  </div>
</div>