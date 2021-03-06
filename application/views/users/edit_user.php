<div class="box box-primary">
  <div class="box-header with-border"><h3 class="box-title"><?php echo $title; ?></h3></div>
  <div class="box-body">
    <div id="infoMessage"><?php echo $message;?></div>
    <?php echo form_open(uri_string());?>
      <div class="form-group">
        <?php echo lang('edit_user_fname_label', 'first_name');?>
        <?php echo form_input($first_name);?>
      </div>
      <div class="form-group">
        <?php echo lang('edit_user_lname_label', 'last_name');?>
        <?php echo form_input($last_name);?>
      </div>
      <div class="form-group">
        <?php echo lang('edit_user_company_label', 'company');?>
        <?php echo form_input($company);?>
      </div>
      <div class="form-group">
        <?php echo lang('edit_user_phone_label', 'phone');?>
        <?php echo form_input($phone);?>
      </div>
      <div class="form-group">
        <?php echo lang('edit_user_password_label', 'password');?>
        <?php echo form_input($password);?>
      </div>
      <div class="form-group">
        <?php echo lang('edit_user_password_confirm_label', 'password_confirm');?>
        <?php echo form_input($password_confirm);?>
      </div>
      <?php if ($this->ion_auth->is_admin()): ?>
        <h3><?php echo lang('edit_user_groups_heading');?></h3>
        <?php foreach ($groups as $group):?>
          <div class="checkbox icheck">
            <label>
              <?php
                $gID=$group['id'];
                $checked = null;
                $item = null;
                foreach($currentGroups as $grp) {
                  if ($gID == $grp->id) {
                    $checked= ' checked="checked"';
                    break;
                  }
                }
              ?>
            <input type="checkbox" name="groups[]" value="<?php echo $group['id'];?>"<?php echo $checked;?>>
            <?php echo htmlspecialchars($group['name'],ENT_QUOTES,'UTF-8');?>
            </label>
          </div>
        <?php endforeach?>
      <?php endif ?>
      <?php echo form_hidden('id', $user->id);?>
      <?php echo form_hidden($csrf); ?>
      <div class="form-group">
        <?php echo form_submit('submit', lang('edit_user_submit_btn'),array('class'=>'btn btn-primary btn-rounded'));?>
        <?php echo anchor('users', 'Cancel',array('class'=>'btn btn-warning btn-rounded')); ?>
      </div>
    <?php echo form_close();?>
  </div>
</div>
<script type="text/javascript">
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>