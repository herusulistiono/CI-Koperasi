<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $title; ?></h3>
    <small class="pull-right">
      <button class="btn btn-success btn-sm" onclick="add()">Tambah</button>
    </small>
  </div>
  <div class="box-body table-responsive no-padding">
  	<table id="table-data" class="table table-striped table-hover table-bordered">
      <thead>
        <tr>
          <th width="3%">NO</th>
          <th>KODE</th>
          <th>TANGGAL</th>
          <th>NAMA ANGGOTA</th>
          <th>JUMLAH PENARIKAN</th>
          <th>#</th>
        </tr>
      </thead>
      <tbody>
        <?php $no=(int)1; foreach ($withdrawal as $rows): ?>
          <tr>
            <td><?php echo $no++ ?></td>
            <td><?php echo $rows->kd_deb_simp; ?></td>
            <td><?php echo tanggal_indo($rows->tgl_deb_simp); ?></td>
            <td><?php echo $rows->kd_angg. '-'. $rows->nm_angg; ?></td>
            <td><?php echo number_format($rows->jml_deb,0,',','.') ?></td>
            <td>#</td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>
</div>
<div class="modal modal-default fade" id="modal-deposit">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-deposit"></h4>
      </div>
      <div class="modal-body">
        <?php echo form_open('',array('id'=>'form','autocomplete'=>'off'));?>
        <div id="message"></div>
        <div class="form-group">
          <label class="control-label">KODE:</label>
            <input type="text" name="code" class="form-control input-sm" value="<?php echo $generate;?>" readonly="readonly"/>
        </div>
        <div id="tgl_deb_simp-group" class="form-group">
          <label class="control-label">TANGGAL:</label>
            <input type="text" name="tgl_deb_simp" id="datepicker" class="form-control input-sm" placeholder="dd/mm/yyyy"/>
        </div>
        <div id="kd_angg-group" class="form-group">
          <label class="control-label">NAMA ANGGOTA:</label>
          <select name="kd_angg" id="kd_angg" class="form-control select2 input-sm" style="width: 100%;" onchange="return get_savings(this.value)">
            <option value=""></option>
            <?php foreach ($members as $opt): ?>
              <option value="<?php echo $opt->kd_angg;?>"><?php echo $opt->kd_angg.' - '.$opt->nm_angg;?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="form-group">
          <label class="control-label">TOTAL SIMPANAN SUKARELA:</label>
          <input type="text" name="" id="sukarela" class="form-control input-sm" value="0"/>
        </div>
        <div id="jml_deb-group" class="form-group">
          <label class="control-label">JUMLAH PENARIKAN:</label>
          <input type="text" id="rp1" name="jml_deb" class="form-control input-sm" placeholder="0"/>
        </div>
        <input type="hidden" name="userID" value="<?php echo $this->ion_auth->user()->row()->id; ?>"/>
        <?php echo form_close(); ?>
      </div>
      <div class="modal-footer">
        <button type="button" id="save" class="btn btn-success btn-sm" onclick="save_withdrawal()">Simpan</button>
        <button type="button" id="update" class="btn btn-warning btn-sm" onclick="update()" disabled="disabled">Ubah</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
    $('.form-group').removeClass('has-error');
    $('.help-block').remove();
    $('#table-data').DataTable({

    });
  });
	function add() {
	  $('.form-group').removeClass('has-error');
	  $('.help-block').empty();
	  $('.select2').select2({
	    placeholder: 'NAMA ANGGOTA',
	    allowClear: false
	  });
	  $('#form')[0].reset();
	  $('#modal-deposit').modal('show');
	  $('.text-deposit').text('TAMBAH DATA');
	  $('#update').attr('disabled','disabled');
	  $('#save').removeAttr('disabled');
	}
  function get_savings() {
    $.ajax({
      url: "<?php echo site_url('withdrawal/get_savings'); ?>",
      type: 'POST',
      dataType: 'json',
      data: 'kd_angg='+$('#kd_angg').val(),
      cache: false,
      encode  : true,
      success:function(data) {
        var amount  = rupiah(data.total_simpanan);
        $('#sukarela').val(amount).attr('readonly','readonly');
      },error: function (jqXHR, textStatus, errorThrown){
        alert('Error get data from ajax');
      }
    });
  }
  function save_withdrawal() {
    $('.form-group').removeClass('has-error');
    $('.help-block').remove();
    $.ajax({
      url : '<?php echo site_url('withdrawal/save_withdrawal/') ?>',
      type: 'POST',
      data: $('#form').serialize(),
      dataType: 'JSON',
      success: function(data){
        console.log(data);
        if (!data.success) {
          if (data.errors.tgl_deb_simp) {
            $('#tgl_deb_simp-group').addClass('has-error');
            $('#tgl_deb_simp-group').append('<div class="help-block">'+data.errors.tgl_deb_simp+'</div>'); 
          }
          if (data.errors.kd_angg) {
            $('#kd_angg-group').addClass('has-error');
            $('#kd_angg-group').append('<div class="help-block">'+data.errors.kd_angg+'</div>'); 
          }
          if (data.errors.jml_deb) {
            $('#jml_deb-group').addClass('has-error');
            $('#jml_deb-group').append('<div class="help-block">'+data.errors.jml_deb+'</div>'); 
          }
        }else{
          $('#message').html(data.message).addClass('alert alert-info');
          setTimeout(function () {
            window.location.reload();
          },1500);
        }
      }
    });
  }
</script>