<div class="row">
  <div class="col-md-6">
    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title"><?php echo $title; ?></h3>
        <small class="pull-right"></small>
      </div>
      <div class="box-body">
      	<table class="table table-striped table-hover" id="table-data">
      		<thead>
            <tr>
              <th width="3%">NO</th>
              <th>NAMA KATEGORI</th>
              <th width="3%">#</th>
            </tr>
          </thead>
          <tbody>
            <?php $no=(int)1; foreach ($category as $rows): ?>
              <tr>
                <td><?php echo $no++;?></td>
                <td><?php echo $rows->nm_kategori;?></td>
                <td>
                  <?php echo '<a href="javascript:void(0)" class="btn btn-success btn-xs" data-toggle="tooltip" title="Edit" onclick="edit('."'".$rows->id_kat."'".')"><i class="fa fa-pencil"></i></a>';?>
                </td>
              </tr>
            <?php endforeach ?>
          </tbody>
      	</table>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="box box-success">
      <div class="box-header with-border"></div>
      <div class="box-body">
        <?php echo form_open('',array('id'=>'form','autocomplete'=>'off')); ?>
          <div id="message"></div>
          <input type="hidden" name="id_kat">
          <div id="nm_kategori-group" class="form-group">
            <label>NAMA KATEGORI</label>
            <input type="text" name="nm_kategori" class="form-control input-sm" placeholder="NAMA KATEGORI" autofocus="autofocus"/>
          </div>
          <button type="button" id="save" class="btn btn-success btn-sm" onclick="process()">Simpan</button>
          <button type="button" id="update" class="btn btn-warning btn-sm" onclick="processUpdate()" disabled="disabled">Ubah</button>
          <button type="button" class="btn btn-primary btn-sm" onclick="return window.location.reload()"><i class="fa fa-refresh"></i></button>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $('#table-data').DataTable({
    "processing": true,
    "lengthMenu": [[15,50,100,500, -1], [15,50,100,500, "All"]],
    //"order":[[0,"asc" ]],
    "columnDefs": [
      {"targets": [0,2],orderable: false},
      //{className: 'text-center', targets: [1,2,4,5,6,7]},
    ]
  });
  function edit(id_kat) {
    $('#form')[0].reset();
    $('.form-group').removeClass('has-error');
    $('.help-block').empty();
    $('#save').attr('disabled','disabled');
    $('#update').removeAttr('disabled');
    $.ajax({
      url : '<?php echo site_url('category/get_by_id/')?>',
      type: 'POST',
      data: 'id_kat='+id_kat,
      dataType: "JSON",
      success: function(data){
        console.log(data);
        $('input[name="id_kat"]').val(data.id_kat);
        $('input[name="nm_kategori"]').val(data.nm_kategori);
      }
    });
  }
  function process() {
    $('.form-group').removeClass('has-error');
    $('.help-block').remove();
    $.ajax({
      url : '<?php echo site_url('category/save') ?>',
      type: 'POST',
      data: $('#form').serialize(),
      dataType: 'JSON',
      success: function(data){
        console.log(data);
        if (!data.success) {
          if (data.errors.nm_kategori) {
            $('#nm_kategori-group').addClass('has-error');
            $('#nm_kategori-group').append('<div class="help-block">'+data.errors.nm_kategori+'</div>');
            $('input[name="nm_kategori"]').focus();
          }
        }else{
          $('#message').html(data.message).addClass('alert alert-success');
          setTimeout(function () {
            window.location.reload();
          },1500);
        }
      }
    });
  }
  function processUpdate() {
    $('.form-group').removeClass('has-error');
    $('.help-block').remove();
    $.ajax({
      url : '<?php echo site_url('category/update') ?>',
      type: 'POST',
      data: $('#form').serialize(),
      dataType: 'JSON',
      success: function(data){
        console.log(data);
        if (!data.success) {
          if (data.errors.nm_kategori) {
            $('#nm_kategori-group').addClass('has-error');
            $('#nm_kategori-group').append('<div class="help-block">'+data.errors.nm_kategori+'</div>');
            $('input[name="nm_kategori"]').focus();
          }
        }else{
          $('#message').html(data.message).addClass('alert alert-success');
          setTimeout(function () {
            window.location.reload();
          },1500);
        }
      }
    });
  }
  function dontEnter(evt) {
    var evt = (evt) ? evt : ((event) ? event : null);
    var node = (evt.target) ? evt.target:((evt.srcElement) ? evt.srcElement : null);
    if ((evt.keyCode == 13) && (node.type=="text")){return false;}
  }
  document.onkeypress=dontEnter;
</script>