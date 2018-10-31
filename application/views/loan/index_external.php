<style type="text/css">
  table.dataTable thead th {
    clear: both;
    vertical-align: middle;
    /*padding: 10px 18px 10px 5px;*/
  }
  table.dataTable tbody td {
    vertical-align: top;
  }
</style>
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
          <th style="text-align:center;">KODE</th>
          <th style="text-align:center;">TANGGAL</th>
          <th style="text-align:center;">NAMA ANGGOTA</th>
          <th style="text-align:center;">PINJAMAN</th>
          <th style="text-align:center;">TENOR</th>
          <th style="text-align:center;">ANGSURAN/BULAN</th>
          <th style="text-align:center;">STATUS</th>
          <th width="10%">AKSI</th>
        </tr>
      </thead>
      <tbody>
        <?php $no=(int)1;foreach ($loan as $rows): $status=$rows->status;?>
          <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $rows->kd_pinj; ?></td>
            <td><?php echo tanggal_indo($rows->tgl_pinj);?></td>
            <td><?php echo $rows->kd_angg.' - '.$rows->nm_angg;?></td>
            <td><?php echo number_format($rows->jml_pinj,0,',','.');?></td>
            <td><?php echo $rows->tenor ?></td>
            <td><?php echo number_format($rows->jml_angs,0,',','.'); ?></td>
            <td>
              <?php if ($status==(int)1): ?>
                <span class="badge bg-light-blue">BARU</span>
              <?php elseif($status==(int)2): ?>
                <span class="badge bg-green">DISETUJUI</span>
              <?php else: ?>
                 <a href="javascript:void(0)" class="badge bg-red" onclick="alert('<?php echo $rows->ket_tolak ?>')">TOLAK</a>
              <?php endif ?>
            </td>
            <td>
              <?php if ($status==(int)1): ?>
                <?php echo '<a href="javascript:void(0)" class="btn btn-success btn-xs" data-toggle="tooltip" title="EDIT" onclick="edit('."'".$rows->kd_pinj."'".')"><i class="fa fa-pencil"></i></a>';?>
              <?php elseif($status==(int)2): ?>
                <?php echo anchor('loan_out/view/'.$rows->kd_pinj,'<i class="fa fa-search"></i>',array('class'=>'btn btn-info btn-xs','target'=>'_blank','data-toggle'=>'tooltip','title'=>' SURAT PERMOHONAN')); ?>
                <?php echo anchor('loan_out/receipt/'.$rows->kd_pinj,'<i class="fa fa-print"></i>',array('class'=>'btn btn-success btn-xs','target'=>'_blank','data-toggle'=>'tooltip','title'=>'SURAT PERSETUJUAN')); ?>
                <?php echo anchor('loan_out/invoice/'.$rows->kd_pinj,'<i class="fa fa-newspaper-o"></i>',array('class'=>'btn btn-warning btn-xs','target'=>'_blank','data-toggle'=>'tooltip','title'=>'BUKTI PENGELUARAN KAS')); ?>
              <?php else: ?>
                <a href="javascript:void(0)" class="badge bg-red" onclick="alert('Data Terkunci Karena Permohonan Ditolak')"><i class="fa fa-remove"></i></a>
              <?php endif ?>
            </td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>
</div>
<div class="modal modal-default fade" id="modal-loan">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-loan"></h4>
      </div>
      <div class="modal-body">
        <?php echo form_open('',array('id'=>'form','autocomplete'=>'off','name'=>'calc'));?>
        <div id="message"></div>
        <div class="form-group">
          <label class="control-label">KODE:</label>
            <input type="text" name="code" class="form-control input-sm" value="<?php echo $generate;?>" readonly="readonly"/>
        </div>
        <div id="tgl_pinj-group" class="form-group">
          <label class="control-label">TANGGAL:</label>
            <input type="text" name="tgl_pinj" id="datepicker" class="form-control input-sm" placeholder="dd/mm/yyyy"/>
        </div>
        <div id="kd_angg-group" class="form-group">
          <label class="control-label">NAMA ANGGOTA:</label>
          <select name="kd_angg" class="form-control select2 input-sm" style="width: 100%;">
            <option value=""></option>
            <?php foreach ($members as $opt): ?>
              <option value="<?php echo $opt->kd_angg;?>"><?php echo $opt->kd_angg.' - '.$opt->nm_angg;?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div id="jml_pinj-group" class="form-group">
          <label class="control-label">JUMLAH PINJAMAN:</label>
          <input type="text" id="rp1" name="jml_pinj" class="form-control input-sm" placeholder="0"/>
        </div>
        <div id="tenor-group" class="form-group">
          <label class="control-label">TENOR:</label>
          <input min="0" type="number" name="tenor" id="tenor" class="form-control input-sm" placeholder="0" onkeypress="show_payment()" onkeyup="show_payment()"/>
        </div>
        <div id="bunga-group" class="form-group">
          <label class="control-label">SUKU BUNGA</label>
          <input type="number" name="bunga" id="bunga" class="form-control input-sm" placeholder="0" onkeypress="show_payment()" value="0.0001" tabindex="1" min="0.0001"/>
        </div>
        <div class="form-group">
          <label class="control-label">ANGSURAN PERBULAN:</label>
          <input type="text" name="jml_angs" id="payment" class="form-control input-sm" placeholder="0" readonly="readonly"/>
        </div>
        <div id="ket_pinj-group" class="form-group">
          <label class="control-label">KETERANGAN PINJAM:</label>
          <textarea name="ket_pinj" id="" cols="3" rows="3" class="form-control input-sm" placeholder="KETERANGAN PINJAM"></textarea>
        </div>
        <?php echo form_hidden('pinj_ke',(int)2); ?>
        <?php echo form_close(); ?>
      </div>
      <div class="modal-footer">
        <button type="button" id="save" class="btn btn-success btn-sm" onclick="save()">Simpan</button>
        <button type="button" id="update" class="btn btn-warning btn-sm" onclick="update()" disabled="disabled">Ubah</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(function() {
    $('#table-data').DataTable({
      "processing": true,
      "lengthMenu": [[15,50,100,500, -1], [15,50,100,500, "All"]],
      //"order":[[0,"asc" ]],
      "columnDefs": [
        {"targets": [ 0,8],orderable: false},
        {className: 'text-center', targets: [1,4,5,6,7]},
        {className: 'text-right', targets: [2]},
      ]
    });
  });
  function show_payment() {
    $('.form-group').removeClass('has-error');
    $('.help-block').remove();
    if ((document.calc.jml_pinj.value == null || document.calc.jml_pinj.value.length == 0)){ 
      $('#jml_pinj-group').addClass('has-error');
      $('#jml_pinj-group').append('<div class="help-block">Jangan Dikosongkan</div>');
    }else if ((document.calc.tenor.value == null || document.calc.tenor.value.length == 0)){ 
      $('#tenor-group').addClass('has-error');
      $('#tenor-group').append('<div class="help-block">Jangan Dikosongkan</div>');
    }else if ((document.calc.bunga.value == null || document.calc.bunga.value.length == 0)){ 
      $('#bunga-group').addClass('has-error');
      $('#bunga-group').append('<div class="help-block">Jangan Dikosongkan dan Jangan Dengan Koma</div>');
      return false;
    }else{
      var jml_pinj= document.getElementById('rp1').value.replace(/,/g,"");
      var tenor = document.getElementById('tenor').value;
      var bunga = document.getElementById('bunga').value.replace(/,/g,".");
      var xRate = bunga/1200;
      var angsuran = rupiah(jml_pinj * xRate / (1-(Math.pow(1/(1+xRate),tenor))));
      if(typeof angsuran != 'undefined'){ 
        document.getElementById('payment').value = angsuran;
      }
    }
  }
  function add() {
    $('.form-group').removeClass('has-error');
    $('.help-block').empty();
    $('.select2,.type_id').select2({
      placeholder: 'NAMA ANGGOTA',
      allowClear: false
    });
    $('#form')[0].reset();
    $('#modal-loan').modal('show');
    $('.text-loan').text('TAMBAH DATA PINJAMAN EKSTERNAL');
    $('#update').attr('disabled','disabled');
    $('#save').removeAttr('disabled');
  }
  function edit(kd_pinj) {
    $('#form')[0].reset();
    $('.form-group').removeClass('has-error');
    $('.help-block').empty();
    $('#save').attr('disabled','disabled');
    $('#update').removeAttr('disabled');
    $.ajax({
      url : '<?php echo site_url('loan_out/get_by_id/')?>',
      type: 'POST',
      data: 'kd_pinj='+kd_pinj,
      dataType: "JSON",
      success: function(data){
        console.log(data);
        $('#modal-loan').modal('show');
        $('.text-loan').text('UBAH DATA PINJAMAN EKSTERNAL');
        $('input[name="code"]').val(data.kd_pinj);
        $('input[name="tgl_pinj"]').datepicker('update',data.tgl_pinj);
        $('select[name="kd_angg"]').val(data.kd_angg).select2({allowClear:true});
        $('input[name="jml_pinj"]').val(rupiah(data.jml_pinj));
        $('input[name="tenor"]').val(rupiah(data.tenor));
        $('input[name="bunga"]').val(data.bunga);
        $('input[name="jml_angs"]').val(data.jml_angs);
        $('input[name="pinj_ke"]').val(data.pinj_ke);
        $('textarea[name="ket_pinj"]').val(data.ket_pinj);
      }
    });
  }
  function save() {
    $('.form-group').removeClass('has-error');
    $('.help-block').remove();
    $.ajax({
      url : '<?php echo site_url('loan_out/save/') ?>',
      type: 'POST',
      data: $('#form').serialize(),
      dataType: 'JSON',
      success: function(data){
        console.log(data);
        if (!data.success) {
          if (data.errors.tgl_pinj) {
            $('#datepicker').focus();
            $('#tgl_pinj-group').addClass('has-error');
            $('#tgl_pinj-group').append('<div class="help-block">'+data.errors.tgl_pinj+'</div>'); 
          }
          if (data.errors.kd_angg) {
            $('#kd_angg-group').addClass('has-error');
            $('#kd_angg-group').append('<div class="help-block">'+data.errors.kd_angg+'</div>'); 
          }
          if (data.errors.jml_pinj) {
            $('#jml_pinj-group').addClass('has-error');
            $('#jml_pinj-group').append('<div class="help-block">'+data.errors.jml_pinj+'</div>'); 
          }
          if (data.errors.tenor) {
            $('#tenor-group').addClass('has-error');
            $('#tenor-group').append('<div class="help-block">'+data.errors.tenor+'</div>'); 
          }
          if (data.errors.bunga) {
            $('#bunga-group').addClass('has-error');
            $('#bunga-group').append('<div class="help-block">'+data.errors.bunga+'</div>'); 
          }
          if (data.errors.ket_pinj) {
            $('#ket_pinj-group').addClass('has-error');
            $('#ket_pinj-group').append('<div class="help-block">'+data.errors.ket_pinj+'</div>'); 
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
  function update() {
    $('.form-group').removeClass('has-error');
    $('.help-block').remove();
    $.ajax({
      url : '<?php echo site_url('loan_out/update/') ?>',
      type: 'POST',
      data: $('#form').serialize(),
      dataType: 'JSON',
      success: function(data){
        console.log(data);
        if (!data.success) {
          if (data.errors.tgl_pinj) {
            $('#tgl_pinj-group').addClass('has-error');
            $('#tgl_pinj-group').append('<div class="help-block">'+data.errors.tgl_pinj+'</div>'); 
          }
          if (data.errors.kd_angg) {
            $('#kd_angg-group').addClass('has-error');
            $('#kd_angg-group').append('<div class="help-block">'+data.errors.kd_angg+'</div>'); 
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
</script>