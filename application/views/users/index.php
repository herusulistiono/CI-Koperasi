<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $title; ?></h3>
    <small class="pull-right">
      <?php echo anchor('users/create_user','Add User',array('class'=>'btn btn-success btn-sm'));?>
      <?php echo anchor('users/create_group','Create Group',array('class'=>'btn btn-warning btn-sm'));?>
    </small>
  </div>
  <div class="box-body table-responsive no-padding">
    <table id="table-data" class="table table-hover">
      <thead>
        <tr>
          <th width="5%">No</th>
          <th>Username</th>
          <th>Fullname</th>
          <th>Email</th>
          <th>Role</th>
          <th>Status</th>
          <th>Last Login</th>
          <th>#</th>
        </tr>
      </thead>
      <tbody>
        <?php $no=1; foreach ($users as $user):?>
          <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo htmlspecialchars($user->username,ENT_QUOTES,'UTF-8');?></td>
            <td><?php echo htmlspecialchars($user->first_name.' '.$user->last_name,ENT_QUOTES,'UTF-8');?></td>
            <td><?php echo htmlspecialchars($user->email,ENT_QUOTES,'UTF-8');?></td>
            <td>
              <?php foreach ($user->groups as $group):?>
                <?php //echo anchor("users/edit_group/".$group->id, htmlspecialchars($group->name.' |',ENT_QUOTES,'UTF-8')) ;?>
                <?php echo anchor('users/edit_group/'.$group->id,$group->name,array('class'=>'btn btn-success btn-xs')); ?>
              <?php endforeach?>
            </td>
            <td><?php echo ($user->active) ? anchor("users/deactivate/".$user->id, lang('index_active_link')) : anchor("users/activate/". $user->id, lang('index_inactive_link'));?></td>
            <td><?php echo date('d M Y H:i:s',$user->last_login) ?></td>
            <td><?php echo anchor("users/edit_user/".$user->id, '<i class="fa fa-edit"></i>', array('class'=>'btn btn-success btn-xs')) ;?></td>
          </tr>
        <?php endforeach;?>
      </tbody>
    </table>
  </div>
</div>
<script type="text/javascript">
  $('#table-data').DataTable({
    "processing": true,
    //"sPaginationType": "full_numbers",
    "lengthMenu": [[15,50,100,500, -1], [15,50,100,500, "All"]],
    "order":[[0,"asc" ]],
    "columnDefs": [{
      "targets": [ 0,7],
      orderable: false
    }]
  });
</script>