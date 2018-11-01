<div class="box box-primary">
  <div class="box-header with-border">
  	<h3 class="box-title"><?php echo lang('deactivate_heading');?></h3>
  </div>
  <div class="box-body">
	<h3><?php echo sprintf(lang('deactivate_subheading'), $user->username);?></h3>
	<?php echo form_open("users/deactivate/".$user->id);?>
	  <div class="form-group">
	  	<?php echo lang('deactivate_confirm_y_label', 'confirm');?>
	    <input type="radio" class="minimal" name="confirm" value="yes" checked="checked"/>
	    <?php echo lang('deactivate_confirm_n_label', 'confirm');?>
	    <input type="radio" class="minimal" name="confirm" value="no" />
	  </div>
	  <?php echo form_hidden($csrf); ?>
	  <?php echo form_hidden(array('id'=>$user->id)); ?>
	  <div class="form-group">
	  	<?php echo form_submit('submit', lang('deactivate_submit_btn'),array('class'=>'btn btn-primary'));?>
	  	<?php echo anchor('users', 'Cancel',array('class'=>'btn btn-warning')); ?>
	  </div>
	<?php echo form_close();?>
  </div>
</div>
<script type="text/javascript">
  $(function () {
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass: 'iradio_square-blue',
      //radioClass   : 'iradio_minimal-blue'
    })
  });
</script>