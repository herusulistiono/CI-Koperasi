<div class="row">
  <div class="col-md-8">
    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title"><?php echo $title ?></h3>
        <small class="pull-right"></small>
      </div>
      <div class="box-body">
        <?php echo form_open('#',array('id'=>'add_cart','autocomplete'=>'off')); ?>
        <input type="hidden" name="kd_prod">
        <div class="form-group">
          <input type="text" name="barcode" id="barcode" class="form-control input-sm" placeholder="SCAN BARCODE" autofocus="autofocus" onchange="return checkData(this.value)" onkeypress="javascript:return doEnter(event)"/>
          <!-- onkeypress="javascript:return tabbed(event)" -->
        </div>
        <div class="form-group">
          <input type="text" name="nm_prod" class="form-control input-sm" placeholder="NAMA BARANG" readonly="readonly"/>
        </div>
        <div class="form-group">
          <input type="number" name="qty" id="qty" class="form-control input-sm" min="0" placeholder="QTY" onchange="javascript:return subTotal(this.value)" onkeyup="javascript:return subTotal(this.value)" onkeypress="javascript:return subTotal(this.value)"/>
        </div>
        <div class="form-group">
          <input type="text" name="harga_jual" id="harga" class="form-control input-sm" placeholder="HARGA" readonly="readonly"/>
        </div>
        <div class="form-group">
          <input type="text" name="subtotal" id="sub_total" class="form-control input-sm" placeholder="0" readonly="readonly"/>
        </div>
        <div class="form-group">
          <div class="pull-right">
            <button type="button" id="save" class="btn btn-success btn-sm" onclick="addCart()">TAMBAH</button>
          </div>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">TOTAL BELANJA</h3>
        <small class="pull-right"></small>
      </div>
      <div class="box-body">
        <?php echo form_open('#',array('id'=>'form','autocomplete'=>'off')); ?>
        <div class="form-group">
          <label class="control-label">TOTAL (RP):</label>
          <input type="text" name="totalbelanja" id="totalbelanja" class="form-control input-sm" placeholder="0" readonly="readonly"/>
        </div>
        <div id="xPay-group" class="form-group">
          <label class="control-label">BAYAR (RP):</label>
          <input type="text" name="bayar" id="rp1" class="form-control input-sm" placeholder="0" onchange="calcPayment(this.value)" onkeyup="calcPayment(this.value)" onkeypress="javascript:return doPrint(event)"/>
        </div>
        <div class="form-group">
          <label class="control-label">KEMBALI (RP):</label>
          <input type="text" name="kembali" id="kembali" class="form-control input-sm" placeholder="0" readonly="readonly"/>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
  <div class="col-md-12">
    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">DAFTAR BELANJA</h3>
        <small class="pull-right"></small>
      </div>
      <div class="box-body">
        <?php echo form_open('#',array('id'=>'form_payment','autocomplete'=>'off')); ?>
          <?php echo form_hidden('user_id', $this->ion_auth->user()->row()->id) ?>
          <table class="table table-striped table-hover" id="table-data">
            <thead>
              <tr>
                <th width="3%">NO</th>
                <th>KODE</th>
                <th>PRODUK</th>
                <th>QTY</th>
                <th>HARGA</th>
                <th>SUBTOTAL</th>
                <th width="8%">#</th>
              </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
              <tr>
                <th colspan="5" style="text-align:right">TOTAL:</th>
                <th></th>
                <th></th>
              </tr>
            </tfoot>
          </table>
          <br>
          <div class="form-group">
            <div class="pull-right">
              <button type="button" class="btn btn-success btn-sm" onclick="return saveData()">SIMPAN TRANSAKSI</button>
              <button type="button" class="btn btn-warning btn-sm" onclick="return alert('Print')">CETAK</button>
            </div>
          </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  function doEnter(evt) {
    if(evt.which==13){
      $("#qty").focus();
    }
  }
  function checkData() {
    $.ajax({
      url: "<?php echo site_url('sales/check_data'); ?>",
      type: 'POST',
      dataType: 'json',
      data: 'barcode='+$('#barcode').val(),
      cache: false,
      encode  : true,
      success:function(data) {
        $('input[name="kd_prod"]').val(data.kd_prod);
        $('input[name="nm_prod"]').val(data.nm_prod);
        $('input[name="qty"]').val(1);
        $('input[name="harga_jual"]').val(rupiah(data.harga_jual));
      },error: function (jqXHR, textStatus, errorThrown){
        alert('Error get data from ajax');
      }
    });
  }
  function subTotal(qty){
    var harga = $('#harga').val().replace(",", "").replace(",", "");
    var sub_total = harga * qty;
    $('#sub_total').val(rupiah(sub_total));
  }
  function addCart(){
    var barcode = $('input[name="barcode"]').val();
    var qty = $('input[name="qty"]').val();
    if (barcode == '') {
      $('input[name="barcode"]').focus();
    }else if(qty == ''){
      $('input[name="qty"]').focus();
    }else{
      $.ajax({
        url: "<?php echo site_url('sales/addto_cart'); ?>",
        type: 'POST',
        dataType: 'json',
        data: $('#add_cart').serialize(),
        success:function(data) {
          console.log(data);
          reload_table();
          $('#add_cart')[0].reset();
          //$('input[name="barcode"]').focus('');
        },error: function (jqXHR, textStatus, errorThrown){
          alert('Error get data from ajax');
        }
      });
    }
  }
  function deleteCart(id,sub_total){
    if (confirm('Anda Yakin Mau menghapus Transaksi Ini?')) {
      $.ajax({
        url : "<?php echo site_url('sales/delete_cart')?>/"+id,
        type: "POST",
        dataType: "JSON",
        success: function(data){
          reload_table();
        },
        error: function (jqXHR, textStatus, errorThrown){
          alert('Error deleting data');
        }
      });
    }
  }
  var table;
  $(document).ready(function(){
    //Ambil Transaksi
    table=$('#table-data').DataTable({ 
      "paging": false,
      "info": false,
      "searching": false,
      "processing": true,
      "serverSide": true,
      "bSort" : false,
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
        var grandTotal = api
          .column(5)
          .data()
          .reduce(function (a, b) {
          return intVal(a) + intVal(b);
        },0);
        // Update footer by showing the total with the reference of the column index 
        $(api.column(0).footer()).html('TOTAL');
        //$(api.column(5).footer()).addClass('grandTotal').html(rupiah(grandTotal));
        $(api.column(5).footer()).addClass('grandTotal').html(rupiah(grandTotal)+'<input type="hidden" name="grandTotal" value="'+rupiah(grandTotal)+'">');
        $('input[name="totalbelanja"]').val(rupiah(grandTotal));
      },
      "ajax": {
        "url": "<?php echo site_url('sales/list_transactions')?>",
        "type": "POST"
      },
      "columnDefs": [
        //{"targets": [ 0],"orderable": false,},
        //{className: 'sub_total', targets: [5]},
      ],
    });
  });
  function reload_table(){
    table.ajax.reload(null,false);
  }
  function calcPayment() {
    $('.form-group').removeClass('has-error');
    $('.help-block').remove();
    var bayar = $('#rp1').val().replace(/,/g,"");
    var belanja = $('input[name="totalbelanja"]').val().replace(",","");
    totalBelanja = belanja;
    var kembali = bayar-totalBelanja;
    $('#kembali').val(rupiah(kembali));
  }
  function saveData() {
    $('.form-group').removeClass('has-error');
    $('.help-block').remove();
    var bayar = $('input[name="bayar"]').val();
    if (bayar=='') {
      $('#xPay-group').addClass('has-error');
      $('#xPay-group').append('<div class="help-block">Harap Diisi Terlebih Dahulu</div>');
      $('input[name="bayar"]').focus();
    }else{
      $.ajax({
        url: '<?php echo site_url('sales/payment') ?>',
        type: 'POST',
        dataType: 'JSON',
        data: $('#form_payment').serialize(),
        success:function(data) {
          console.log(data);
          alert('success');
          window.location.reload();
        },error: function (jqXHR, textStatus, errorThrown){
          alert('Error get data from ajax');
        }
      });
    }
  }
  function doPrint(evt) {
    if(evt.which==13){
      alert('Printer');
    }
  }
</script>