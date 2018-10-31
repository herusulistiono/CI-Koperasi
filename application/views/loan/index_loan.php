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

    </small>
  </div>
  <div class="box-body table-responsive no-padding">
    <div id="info"></div>
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
          <th style="text-align:center;">PINJAM KE</th>
          <th width="11%">AKSI</th>
        </tr>
      </thead>
      <tbody>
        <?php $no=(int)1;foreach ($loan as $rows): 
          $status=$rows->status;$loan_to=$rows->pinj_ke;?>
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
                 <a href="javascript:void(0)" class="badge bg-red" onclick="alert('<?php echo $rows->ket_tolak ?>')">DITOLAK</a>
              <?php endif ?>
            </td>
            <td>
              <?php if ($loan_to==(int)1): ?>
                <span class="badge bg-light-blue">KOPERASI</span>
              <?php elseif($loan_to==(int)2): ?>
                <span class="badge bg-green">BANK</span>
              <?php else: ?>
                 <a href="javascript:void(0)" class="badge bg-red" onclick="alert('<?php echo $rows->ket_tolak ?>')">DITOLAK</a>
              <?php endif ?>
            </td>
            <td>
              <?php if ($status==(int)1): ?>
                <?php echo '<a href="javascript:void(0)" class="btn btn-info btn-xs" data-toggle="tooltip" title="APPROVE" onclick="approved('."'".$rows->kd_pinj."'".')"><i class="fa fa-check"></i></a>';?>
                <?php echo '<a href="javascript:void(0)" class="btn btn-danger btn-xs" data-toggle="tooltip" title="REJECT" onclick="rejected('."'".$rows->kd_pinj."'".')"><i class="fa fa-remove"></i></a>';?>
                <?php echo anchor('loan/view/'.$rows->kd_pinj, '<i class="fa fa-search"></i>',array('class'=>'btn btn-success btn-xs','data-toggle'=>'tooltip','title'=>'VIEW','target'=>'_blank')); ?>
              <?php elseif($status==(int)2): ?>
                <span class="badge bg-green">DONE</span>
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
<div class="modal modal-default fade" id="modal-approval">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-approval"></h4>
      </div>
      <div class="modal-body">
        <div id="message"></div>
        <?php echo form_open('',array('id'=>'approval'));?>
        <div class="form-group">
          <label class="control-label">Kode:</label>
          <input type="text" name="kd_pinj" class="form-control" readonly="readonly"/>
        </div>
        <div id="ket_tolak-group" class="form-group">
          <label class="control-label">KETERANGAN PENOLAKAN:</label>
          <textarea name="ket_tolak" cols="3" rows="3" id="ket_tolak" class="form-control" placeholder="KETERANGAN PENOLAKAN"></textarea>
        </div>
        <?php echo form_close(); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="process()">Simpan</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  function approved(kd_pinj) {
    if (confirm('Anda yakin, Apakah Berkas Sudah Diverifikasi?')) {
      $.ajax({
          url: '<?php echo site_url('loan/approved') ?>',
          type: 'POST',
          dataType: 'JSON',
          data: 'kd_pinj='+kd_pinj,
          encode:true,
          success:function (data) {
            if (!data.success) {
              alert('Proses Gagal');
              window.location.reload();
            }else{
              $('#info').html(data.message).addClass('alert alert-info');
              setTimeout(function () {
                window.location.reload();
              },1500);
            }
        }
      });
    }
  }
  function rejected(kd_pinj) {
    $('#approval')[0].reset();
    $('.form-group').removeClass('has-error');
    $('.help-block').empty();
    $.ajax({
      url : '<?php echo site_url('loan/get_by_id/')?>',
      type: 'POST',
      data: 'kd_pinj='+kd_pinj,
      dataType: "JSON",
      success: function(data){
        console.log(data);
        $('input[name="kd_pinj"]').val(data.kd_pinj);
        $('textarea[name="ket_tolak"]').val(data.ket_tolak);
        $('#modal-approval').modal('show');
        $('.text-approval').text('Tolak Proses Pinjaman');
      }
    });
  }
  function process() {
    $('.form-group').removeClass('has-error');
    $('.help-block').empty();
    $.ajax({
      url : '<?php echo site_url('loan/rejected/') ?>',
      type: 'POST',
      data: $('#approval').serialize(),
      dataType: 'JSON',
      success: function(data){
        console.log(data);
        if (!data.success) {
          if (data.errors.ket_tolak) {
            $('#ket_tolak').focus();
            $('#ket_tolak-group').addClass('has-error');
            $('#ket_tolak-group').append('<div class="help-block">'+data.errors.ket_tolak+'</div>'); 
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
  $('#table-data').DataTable({
    "processing": true,
    "lengthMenu": [[15,50,100,500, -1], [15,50,100,500, "All"]],
    //"order":[[0,"asc" ]],
    "columnDefs": [
      {"targets": [ 0,9],orderable: false},
      {className: 'text-center', targets: [1,4,5,6,9]},
      {className: 'text-right', targets: [2]},
    ]
  });
</script>