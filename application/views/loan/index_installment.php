<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $title; ?></h3>
  </div>
  <div class="box-body">
    <?php echo form_open('#',array('id'=>'form_payment','autocomplete'=>'off'));?>
      <div id="message"></div>
        <div class="form-group">
          <label class="control-label">KODE KWITANSI:</label>
          <input type="text" name="code" class="form-control" value="<?php echo $generate;?>" readonly="readonly"/>
        </div>
        <div id="kd_pinj-group" class="form-group">
          <label class="control-label">KODE PINJAMAN:</label>
           <select id="pinjam" class="form-control input-sm select2" style="width: 100%;" onchange="get_amount(this.value)">
            <option value=""></option>
            <?php foreach ($loan_code as $opt): ?>
              <option value="<?php echo $opt->kd_pinj;?>"><?php echo $opt->kd_pinj;?></option>
            <?php endforeach ?>
          </select>
          <input type="hidden" name="kd_pinj" id="kd_pinj"/>
        </div>
        <div class="form-group">
          <label class="control-label">ANGGOTA:</label>
          <input type="text" name="anggota" id="anggota" class="form-control" readonly="readonly"/>
        </div>
        <div id="tgl_bayar-group" class="form-group">
          <label class="control-label">TANGGAL BAYAR:</label>
          <input type="text" name="tgl_bayar" id="datepicker" class="form-control input-sm" placeholder="dd/mm/yyyy"/>
        </div>
        <div id="jml_bayar-group" class="form-group">
          <label class="control-label">JUMLAH BAYAR:</label>
          <input type="text" name="jml_bayar" id="amount" class="form-control input-sm" placeholder="JUMLAH BAYAR"/>
        </div>
        <div id="angs_ke-group" class="form-group">
          <label class="control-label">ANGSURAN KE: <span id="payment_tenor"></span></label>
          <input type="text" name="angs_ke" id="angs_ke" class="form-control input-sm"/>
        </div>
        <div class="form-group">
          <button type="button" id="save" class="btn btn-success btn-sm" onclick="save_installment()">BAYAR</button>
        </div>
    <?php echo form_close(); ?>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">ANGSURAN YANG TERBAYAR</h3>
      </div>
      <div class="box-body table-responsive no-padding">
        <table id="table-data" class="table table-striped table-hover table-bordered" width="100%">
          <thead>
            <tr>
              <th style="text-align:center;">NO KWITANSI</th>
              <th style="text-align:center;">TANGGAL BAYAR</th>
              <th style="text-align:center;">ANGSURAN KE</th>
              <th style="text-align:center;">DIBAYAR</th>
              <th style="text-align:center;">STATUS</th>
              <th style="text-align:center;">AKSI</th>
            </tr>
          </thead>
          <tbody></tbody>
          <tfoot>
            <tr>
             <th style="text-align:center;"></th>
             <th style="text-align:right;"></th>
             <th style="text-align:center;"></th>
             <th style="text-align:center;"></th>
             <th style="text-align:center;"></th>
             <th style="text-align:center;"></th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function() {
    $('.form-group').removeClass('has-error');
    $('.help-block').empty();
    $('.select2').select2({
      placeholder: 'KODE PINJAMAN',
      allowClear: false
    });
  });
  var dataTable=$('#table-data').DataTable({
    "paging":   false,
    "searching": false,
    "ordering": false,
    "processing": true,
    "serverSide": true,
    "info":false,
    "ajax": {
      "url": "<?php echo site_url('installment/show_installment'); ?>",
      "type": "POST",
      "data":function(data) {
        data.kd_pinj=$('#kd_pinj').val();
        data.<?php echo $this->security->get_csrf_token_name(); ?> = "<?php echo $this->security->get_csrf_hash(); ?>"
      },
    },
    "footerCallback": function (row,data,start,end,display) {
        var api = this.api(), data;
        //converting to integer to find total
        var intVal = function (i) {
          return typeof i === 'string' ?
          i.replace(/[\$,]/g,'')*1 :
          typeof i === 'number' ?
          i : 0;
        };
        //computing column Total of the complete result 
        var jml_bayar = api
            .column(3)
            .data()
            .reduce( function (a, b) {
            return intVal(a) + intVal(b);
         },0);
        // Update footer by showing the total with the reference of the column index 
        $(api.column(0).footer()).html();
        $(api.column(1).footer()).html();
        $(api.column(3).footer()).html('Rp '+rupiah(jml_bayar));
    },
    "columnDefs": [
      {className: 'text-center', targets: [0,2]},
      {className: 'text-right', targets: [1]},
    ]
  });
  function get_amount() {
    var kd_pinj = $('#pinjam').val();
    $.ajax({
      url: "<?php echo site_url('installment/check_amount_loan'); ?>",
      type: 'POST',
      dataType: 'json',
      data : {
        kd_pinj : kd_pinj,
      },
      cache: false,
      encode  : true,
      success:function(data) {
        var amount  = rupiah(data.jml_angs);
        var tenor   = data.lama;
        var pembayaran   = (data.lama+'/'+data.tenor);
        $('#kd_pinj').val(data.kd_pinj);
        $('#anggota').val(data.kd_angg+' - '+data.nm_angg)
        $('#amount').val(amount).attr('readonly', 'readonly');
        $('#angs_ke').val('');
        $('#angs_ke').attr('max',tenor).val(tenor);
        //$('#payment_tenor').html(pembayaran);
        dataTable.draw();
      },error: function (jqXHR, textStatus, errorThrown){
        alert('Error get data from ajax');
      }
    });
  }
  function save_installment() {
    $('.form-group').removeClass('has-error');
    $('.help-block').empty();
    $.ajax({
      url : '<?php echo site_url('installment/save_installment/') ?>',
      type: 'POST',
      data: $('#form_payment').serialize(),
      dataType: 'JSON',
      success: function(data){
        console.log(data);
        if (!data.success) {
          if (data.errors.kd_pinj) {
            $('#kd_pinj-group').addClass('has-error');
            $('#kd_pinj-group').append('<div class="help-block">'+data.errors.kd_pinj+'</div>'); 
          }
          if (data.errors.tgl_bayar) {
            $('#tgl_bayar-group').addClass('has-error');
            $('#tgl_bayar-group').append('<div class="help-block">'+data.errors.tgl_bayar+'</div>'); 
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