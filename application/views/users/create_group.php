<div class="box box-primary">
  <div class="box-header with-border"><h3 class="box-title"><?php echo $title; ?></h3></div>
  <div class="box-body">
    <div class="col-md-6">
    	<?php echo form_open("users/create_group");?>
      	<h5><?php echo $message;?></h5>
      	<div class="form-group">
      		<?php echo lang('create_group_name_label', 'group_name');?>
      		<?php echo form_input($group_name);?>
      	</div>
      	<div class="form-group">
      		<?php echo lang('create_group_desc_label', 'description');?>
      		<?php echo form_input($description);?>
      	</div>
      	<?php echo form_submit('submit', lang('create_group_submit_btn'),array('class'=>'btn btn-primary btn-rounded'));?>
      	<?php echo anchor('users', 'Cancel',array('class'=>'btn btn-warning btn-rounded')); ?>
      <?php echo form_close();?>
    </div>
    <div class="col-md-6"></div>
  </div>
</div>