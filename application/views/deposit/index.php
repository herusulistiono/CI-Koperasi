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
      <button class="btn btn-success" onclick="add()">Tambah</button>
    </small>
  </div>
  <div class="box-body table-responsive no-padding">
    <table id="table-data" class="table table-striped table-hover table-bordered">
      <thead>
        <tr>
          <th width="3%" rowspan="2" valign="middle">NO</th>
          <th rowspan="2">KODE</th>
          <th rowspan="2">TANGGAL</th>
          <th rowspan="2" style="text-align:center;">NAMA ANGGOTA</th>
          <th colspan="3" style="text-align:center;">SIMPANAN</th>
          <th rowspan="2">#</th>
        </tr>
        <tr>
          <th>POKOK</th>
          <th>WAJIB</th>
          <th>SUKARELA</th>
        </tr>
      </thead>
      <tbody>
        <?php $no=(int)1;foreach ($deposit as $rows): ?>
          <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $rows->kd_simp; ?></td>
            <td><?php echo tanggal_indo($rows->tgl_simp);?></td>
            <td><?php echo $rows->nm_angg;?></td>
            <td><?php echo number_format($rows->pokok,0,',','.');?></td>
            <td><?php echo number_format($rows->wajib,0,',','.');?></td>
            <td><?php echo number_format($rows->sukarela,0,',','.');?></td>
            <td>
              <?php echo '<a href="javascript:void(0)" class="btn btn-success btn-xs" data-toggle="tooltip" title="Edit" onclick="edit('."'".$rows->kd_simp."'".')"><i class="fa fa-pencil"></i></a>';?>
            </td>
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
            <input type="text" name="code" class="form-control" value="<?php echo $generate;?>" readonly="readonly"/>
        </div>
        <div id="tgl_simp-group" class="form-group">
          <label class="control-label">TANGGAL:</label>
            <input type="text" name="tgl_simp" id="datepicker" class="form-control" placeholder="dd/mm/yyyy"/>
        </div>
        <div id="kd_angg-group" class="form-group">
          <label class="control-label">NAMA ANGGOTA:</label>
          <select name="kd_angg" class="form-control select2" style="width: 100%;">
            <option value="" selected="selected">Pilih</option>
            <?php foreach ($members as $opt): ?>
              <option value="<?php echo $opt->kd_angg;?>"><?php echo $opt->kd_angg.' - '.$opt->nm_angg;?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div id="pokok-group" class="form-group">
          <label class="control-label">SIMPANAN POKOK:</label>
          <input type="text" id="num1" name="pokok" class="form-control" placeholder="0"/>
        </div>
        <div id="wajib-group" class="form-group">
          <label class="control-label">SIMPANAN WAJIB:</label>
          <input type="text" id="num" name="wajib" class="form-control" placeholder="0"/>
        </div>
        <div id="sukarela-group" class="form-group">
          <label class="control-label">SIMPANAN SUKARELA:</label>
          <input type="text" id="num2" name="sukarela" class="form-control" placeholder="0"/>
        </div>

        <input type="hidden" name="userID" value="<?php echo $this->ion_auth->user()->row()->id; ?>"/>
        <?php echo form_close(); ?>
      </div>
      <div class="modal-footer">
        <button type="button" id="save" class="btn btn-success" onclick="save()">Simpan</button>
        <button type="button" id="update" class="btn btn-warning" onclick="update()" disabled="disabled">Ubah</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(function() {
    var extra = 0;
    var $input = $('#num, #num1, #num2');
    
    $input.on("keyup", function(event) {
      // When user select text in the document, also abort.
      var selection = window.getSelection().toString();
      if (selection !== '') {
        return;
      }
      // When the arrow keys are pressed, abort.
      if ($.inArray(event.keyCode, [38, 40, 37, 39]) !== -1) {
        if (event.keyCode == 38) {
          extra = 1000;
        } else if (event.keyCode == 40) {
          extra = -1000;
        } else {
          return;
        }
      }
      var $this = $(this);
      // Get the value.
      var input = $this.val();
      var input = input.replace(/[\D\s\._\-]+/g, "");
      input = input ? parseInt(input, 10) : 0;
      input += extra;
      extra = 0;
      $this.val(function() {
        return (input === 0) ? "" : input.toLocaleString("en-US");
      });
    });

    $('#table-data').DataTable({
      "processing": true,
      "lengthMenu": [[15,50,100,500, -1], [15,50,100,500, "All"]],
      //"order":[[0,"asc" ]],
      "columnDefs": [
        {"targets": [ 0,7],orderable: false},
        {className: 'text-center', targets: [1,2,4,5,6,7]},
      ]
    });
    $('#datepicker').inputmask('dd-mm-yyyy',{'placeholder':'dd-mm-yyyy'})
  });
  function add() {
    $('.form-group').removeClass('has-error');
    $('.help-block').empty();
    $('.select2,.type_id').select2({
      placeholder: {
        id: '-1',
        text: 'Select an option'
      },
      allowClear: false
    });
    $('#form')[0].reset();
    $('#modal-deposit').modal('show');
    $('.text-deposit').text('TAMBAH DATA SIMPANAN');
    $('#update').attr('disabled','disabled');
    $('#save').removeAttr('disabled');
  }
  function edit(kd_simp) {
    $('#form')[0].reset();
    $('.form-group').removeClass('has-error');
    $('.help-block').empty();
    $('#save').attr('disabled','disabled');
    $('#update').removeAttr('disabled');
    $.ajax({
      url : '<?php echo site_url('deposit/get_by_id/')?>',
      type: 'POST',
      data: 'kd_simp='+kd_simp,
      dataType: "JSON",
      success: function(data){
        console.log(data);
        $('#modal-deposit').modal('show');
        $('.text-deposit').text('UBAH DATA SIMPANAN');
        $('input[name="code"]').val(data.kd_simp);
        $('input[name="tgl_simp"]').val(data.tgl_simp);
        $('select[name="kd_angg"]').val(data.kd_angg).select2({allowClear:true});
        $('input[name="wajib"]').val(rupiah(data.wajib));
        $('input[name="pokok"]').val(rupiah(data.pokok));
        $('input[name="sukarela"]').val(rupiah(data.sukarela));
      }
    });
  }
  function save() {
    $('.form-group').removeClass('has-error');
    $('.help-block').remove();
    $.ajax({
      url : '<?php echo site_url('deposit/save/') ?>',
      type: 'POST',
      data: $('#form').serialize(),
      dataType: 'JSON',
      success: function(data){
        console.log(data);
        if (!data.success) {
          if (data.errors.tgl_simp) {
            $('#tgl_simp-group').addClass('has-error');
            $('#tgl_simp-group').append('<div class="help-block">'+data.errors.tgl_simp+'</div>'); 
          }
          if (data.errors.kd_angg) {
            $('#kd_angg-group').addClass('has-error');
            $('#kd_angg-group').append('<div class="help-block">'+data.errors.kd_angg+'</div>'); 
          }
          /*if (data.errors.wajib) {
            $('#wajib-group').addClass('has-error');
            $('#wajib-group').append('<div class="help-block">'+data.errors.wajib+'</div>'); 
          }
          if (data.errors.pokok) {
            $('#pokok-group').addClass('has-error');
            $('#pokok-group').append('<div class="help-block">'+data.errors.pokok+'</div>'); 
          }
          if (data.errors.sukarela) {
            $('#sukarela-group').addClass('has-error');
            $('#sukarela-group').append('<div class="help-block">'+data.errors.sukarela+'</div>'); 
          }*/
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
      url : '<?php echo site_url('deposit/update/') ?>',
      type: 'POST',
      data: $('#form').serialize(),
      dataType: 'JSON',
      success: function(data){
        console.log(data);
        if (!data.success) {
          if (data.errors.tgl_simp) {
            $('#tgl_simp-group').addClass('has-error');
            $('#tgl_simp-group').append('<div class="help-block">'+data.errors.tgl_simp+'</div>'); 
          }
          if (data.errors.kd_angg) {
            $('#kd_angg-group').addClass('has-error');
            $('#kd_angg-group').append('<div class="help-block">'+data.errors.kd_angg+'</div>'); 
          }
          /*if (data.errors.wajib) {
            $('#wajib-group').addClass('has-error');
            $('#wajib-group').append('<div class="help-block">'+data.errors.wajib+'</div>'); 
          }
          if (data.errors.pokok) {
            $('#pokok-group').addClass('has-error');
            $('#pokok-group').append('<div class="help-block">'+data.errors.pokok+'</div>'); 
          }
          if (data.errors.sukarela) {
            $('#sukarela-group').addClass('has-error');
            $('#sukarela-group').append('<div class="help-block">'+data.errors.sukarela+'</div>'); 
          }*/
        }else{
          $('#message').html(data.message).addClass('alert alert-success');
          setTimeout(function () {
            window.location.reload();
          },1500);
        }
      }
    });
  }
  function rupiah(angka){
    var rev = parseInt(angka, 10).toString().split('').reverse().join('');
    var rev2    = '';
    for(var i = 0; i < rev.length; i++){
      rev2  += rev[i];
      if((i + 1) % 3 === 0 && i !== (rev.length - 1)){
        rev2 += ',';
      }
    }
    return rev2.split('').reverse().join('');
  }

</script>