<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $title; ?></h3>
    <small class="pull-right">
      <?php echo anchor('members/add','Tambah Anggota',array('class'=>'btn btn-success btn-sm'));?>
    </small>
  </div>
  <div class="box-body table-responsive no-padding">
  	<table class="table table-striped table-hover" id="table-data">
  		<thead>
        <tr>
          <th>NO</th>
          <th style="text-align:center;">KODE</th>
          <th>KTP</th>
          <th>NAMA LENGKAP</th>
          <th style="text-align:center;">JK</th>
          <th>TELP</th>
          <th>LAHIR, TGL LAHIR</th>
          <th>SEJAK</th>
          <th style="text-align:center;">AKTIF</th>
          <th style="text-align:center;">#</th>
        </tr>
      </thead>
      <tbody></tbody>
  	</table>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function() {
    var members=$('#table-data').DataTable({ 
      "sPaginationType": "full_numbers",
      "lengthMenu": [[10,20,50,100.250,500, -1], [10,20,50,100,250,500, "All"]],
      "order":[[0,"asc" ]],
      "processing": true,
      "serverSide": false,
      "ajax": {
        "url": "<?php echo site_url('members/json_members')?>",
        "type": "POST",
        "data":function(data) {
          data.<?php echo $this->security->get_csrf_token_name();?>="<?php echo $this->security->get_csrf_hash(); ?>"
        },
      },
    });
  });
  function reload_table(){
    members.ajax.reload(null,false);
  }
</script>