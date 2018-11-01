<div class="box box-primary">
  <div class="box-header with-border"><h3 class="box-title"><?php echo $title; ?></h3></div>
  <div class="box-body">
  	<div id="infoMessage"><?php echo $message;?></div>
	<?php echo form_open(current_url());?>
      <div class="form-group">
        <?php echo lang('edit_group_name_label','group_name');?>
        <?php echo form_input($group_name);?>
      </div>
      <div class="form-group">
        <?php echo lang('edit_group_desc_label','description');?>
        <?php echo form_input($group_description);?>
      </div>
      <div class="form-group">
      	<?php echo form_submit('submit',lang('edit_group_submit_btn'),array('class'=>'btn btn-primary btn-rounded'));?>
      	<?php echo anchor('users', 'Cancel',array('class'=>'btn btn-warning btn-rounded')); ?>
      </div>
	<?php echo form_close();?>
	</div>
</div>