<div class="box box-success">
    <div class="box-header">
      <h3 class="box-title"><?php echo $title; ?></h3>
    </div>
    <div class="box-body">
		<?php echo form_open('report/',array('id'=>'form_deposit','target'=>'_blank','onSubmit'=>'return validate(this)','autocomplete'=>'off')); ?>
    	<div class="form-group">
    		<div class="input-group date input-group-sm">
                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                <input name="f_date" id="f_date" class="form-control pull-right" type="text" placeholder="Tanggal Awal"/>
            	<div class="input-group-addon"><i>s/d</i></div>
                <input name="l_date" id="l_date" class="form-control pull-right" type="text" placeholder="Tanggal Akhir"/>
                <span class="input-group-btn">
                  <button type="button" class="btn btn-success btn-flat" onclick="show_report()"><i class="fa fa-search"></i> CEK</button>	
                  <button type="submit" name="pdf" class="btn btn-success btn-flat"><i class="fa fa-file-excel-o"></i> XLS</button>
                </span>
          	</div>
    	</div>
    	<?php echo form_close(); ?>
    </div>
</div>
<div id="output" class="box box-success">
  	<div class="box-header with-border">
    	<h3 id="output_title" class="box-title"></h3>
  	</div>
  	<div class="box-body table-responsive no-padding">
  		<h4 id="output_date" style="text-align:center"></h4>
  		<table id="table-data" class="table table-bordered table-striped table-hover" width="100%">
          <thead>
            <tr>
	          <th width="3%">NO</th>
	          <th>KWITANSI - KODE</th>
	          <th style="text-align:center;">TANGGAL BAYAR</th>
	          <th style="text-align:center;">NAMA ANGGOTA</th>
	          <th style="text-align:center;">(RP) PINJAMAN</th>
	          <th style="text-align:center;">ANGSURAN KE</th>
	          <th style="text-align:center;">(RP) BAYAR</th>
	          <th style="text-align:center;">STATUS</th>
	        </tr>
          </thead>
          <tbody></tbody>
          <tfoot>
            <tr>
             <th style="text-align:right"></th>
             <th style="text-align:center"></th>
             <th style="text-align:right"></th>
             <th style="text-align:center"></th>
             <th style="text-align:right"></th>
             <th style="text-align:center"></th>
             <th style="text-align:right"></th>
             <th style="text-align:center"></th>
            </tr>
         </tfoot>
        </table>
  	</div>
</div>
<script type="text/javascript">
	$('#output').hide();
	$('#f_date').datepicker({
		autoclose: true,
	    format: 'dd-mm-yyyy',
	    todayHighlight: true,
        orientation: "bottom auto",
        todayBtn: true,
        todayHighlight: true,
	}).on('changeDate', function (selected) {
	    var startDate = new Date(selected.date.valueOf());
	    $('#l_date').datepicker('setStartDate', startDate);
	}).on('clearDate', function (selected) {
	    $('#l_date').datepicker('setStartDate', null);
	});
   	$("#l_date").datepicker({
	   	autoclose: true,
	    format: 'dd-mm-yyyy',
	    todayHighlight: true,
        orientation: "bottom auto",
        todayBtn: true,
        todayHighlight: true,
	}).on('changeDate', function (selected) {
	   var endDate = new Date(selected.date.valueOf());
	   $('#f_date').datepicker('setEndDate', endDate);
	}).on('clearDate', function (selected) {
	   $('#f_date').datepicker('setEndDate', null);
	});
	function show_report() {
		$('h3#output_title').text('ANGSURAN TERBAYAR');
		var first_date = $('#f_date').val();
		var last_date 	= $('#l_date').val();
    	var bulan = ['Januari', 'Februari', 'Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    	var bulann = ['Januari', 'Februari', 'Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    	var t_awal=$('#f_date').val();
    	var t_akhir=$('#l_date').val();
    	var fdate = t_awal.split("-").reverse().join("-");
    	var ldate = t_akhir.split("-").reverse().join("-");
	    var tanggal = new Date(fdate).getDate();
	    var xbulan = new Date(fdate).getMonth();
	    var xtahun = new Date(fdate).getYear();

	    var xtanggal = new Date(ldate).getDate();
	    var xxbulan = new Date(ldate).getMonth();
	    var xxtahun = new Date(ldate).getYear();

	    var bulan = bulan[xbulan];
	    var tahun = (xtahun < 1000)?xtahun + 1900 : xtahun;
	    var awal = tanggal+' '+bulan+' '+tahun;
	    var bulanx = bulann[xxbulan];
	    var tahunx = (xxtahun < 1000)?xxtahun + 1900 : xxtahun;
	    var akhir = xtanggal+' '+bulanx+' '+tahunx;

    	$('h4#output_date').html(awal+ ' s/d '+akhir);
    	if (first_date == ""){
			$('#f_date').focus();
			alert('Tanggal Awal Belum Diisi');
	      return false;
	   	}
	   	else if (last_date== ""){
			$('#l_date').focus();
			alert('Tanggal Akhir Belum Diisi');
	      return false;
	   	}
	   	else{
	    	$('#output').show();
	    	dataTables.draw();
	   	}
	}
	function validate(form){
		$('#output').hide();
		if ($('input[name="f_date"]').val() == ""){
			$('input[name="f_date"]').focus();
			alert('Tanggal Awal Belum Diisi');
	        return false;
	    }
	    if ($('input[name="l_date"]').val() == ""){
			$('input[name="l_date"]').focus();
			alert('Tanggal Akhir Belum Diisi');
	        return false;
	    }
	    return (true);
	}
	var dataTables=$('#table-data').DataTable({
		"paging":   false,
		"searching": false,
      	"ordering": false,
      	"processing": true,
      	"serverSide": true,
      	"info":false,
      	"ajax": {
			"url": "<?php echo site_url('report/report_installment'); ?>",
			"type": "POST",
			"data":function(data) {
				data.f_date=$('#f_date').val();
				data.l_date=$('#l_date').val();
				data.<?php echo $this->security->get_csrf_token_name(); ?> = "<?php echo $this->security->get_csrf_hash(); ?>"
			},
		},
      	/*"footerCallback": function (row,data,start,end,display) {
	      var api = this.api(), data;
	      var intVal = function (i) {
	         return typeof i === 'string' ?
	         i.replace(/[\$,]/g,'')*1 :
	         typeof i === 'number' ?
	         i : 0;
	      };
	      var jml_bayar = api
	        .column(4)
	        .data()
	        .reduce(function (a, b) {
	        return intVal(a) + intVal(b);
	      },0);
	      var kumulatif = api
	        .column(5)
	        .data()
	        .reduce(function (a, b) {
	        return intVal(a) + intVal(b);
	      },0);
	      $(api.column(0).footer()).html();
	      $(api.column(4).footer()).html('Rp. '+rupiah(jml_bayar));
	      $(api.column(5).footer()).html('Rp. '+rupiah(kumulatif));
	   },*/
      	"columnDefs": [
	      {className: 'text-center', targets: [0,1,5,7]},
	      {className: 'text-right', targets: [2,4,6]},
	   	]
	});
</script>