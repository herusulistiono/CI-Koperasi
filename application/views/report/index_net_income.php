<div class="box box-success">
    <div class="box-header">
      <h3 class="box-title"><?php echo $title; ?></h3>
    </div>
    <div class="box-body">
		<?php echo form_open('report/excel_net_income',array('id'=>'form_net_income','target'=>'_blank','onSubmit'=>'return validate(this)','autocomplete'=>'off')); ?>
    	<div class="form-group">
    		<div class="input-group date input-group-sm">
                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                <input name="f_date" id="f_date" class="form-control pull-right" type="text" placeholder="Tanggal Awal"/>
            	<div class="input-group-addon"><i>s/d</i></div>
                <input name="l_date" id="l_date" class="form-control pull-right" type="text" placeholder="Tanggal Akhir"/>
                <span class="input-group-btn">
                  <button type="button" class="btn btn-success btn-flat" onclick="show_report()"><i class="fa fa-search"></i> CEK</button>	
                  <button type="submit" name="xls" class="btn btn-success btn-flat"><i class="fa fa-file-excel-o"></i> XLS</button>
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
	          <th width="3%" rowspan="2">NO</th>
	          <th style="text-align:center;" rowspan="2">KODE</th>
	          <th style="text-align:center;" rowspan="2">NAMA ANGGOTA</th>
	          <th style="text-align:center;" colspan="3">SIMPANAN</th>
	          <th style="text-align:center;" rowspan="2">JUMLAH SIMPANAN</th>
	          <th style="text-align:center;" rowspan="2">MODAL</th>
	          <th style="text-align:center;" colspan="3">USAHA</th>
	          <th style="text-align:center;">JMLH LABA</th>
	          <th style="text-align:center;">TOTAL LABA</th>
	        </tr>
	        <tr>
	          <!-- <th width="3%">NO</th> -->
	          <!-- <th style="text-align:center;">TANGGAL</th> -->
	          <!-- <th style="text-align:center;">NAMA ANGGOTA</th> -->
	          <th style="text-align:center;">POKOK</th>
	          <th style="text-align:center;">WAJIB</th>
	          <th style="text-align:center;">SUKARELA</th>
	          <!-- <th style="text-align:center;">JUMLAH</th>
	          <th style="text-align:center;">MODAL</th> -->
	          <th style="text-align:center;">SEMBAKO</th>
	          <th style="text-align:center;">BTN</th>
	          <th style="text-align:center;">BSM</th>
	          <th style="text-align:center;">perANGGOTA</th>
	          <th style="text-align:center;">ANGGOTA</th>
	        </tr>
          </thead>
          <tbody></tbody>
          <tfoot>
            <tr>
             <th style="text-align:center"></th>
             <th style="text-align:center"></th>
             <th></th>
             <th style="text-align:right;"></th>
             <th style="text-align:right"></th>
             <th style="text-align:right"></th>
             <th style="text-align:right"></th>
             <th style="text-align:center"></th>
             <th style="text-align:right"></th>
             <th style="text-align:right"></th>
             <th style="text-align:right"></th>
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
		$('h3#output_title').text('SISA HASIL USAHA');
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
			"url": "<?php echo site_url('report/json_net_income'); ?>",
			"type": "POST",
			"data":function(data) {
				console.log(data);
				data.f_date=$('#f_date').val();
				data.l_date=$('#l_date').val();
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
	      var pokok = api
	        .column(3)
	        .data()
	        .reduce(function (a, b) {
	        return intVal(a) + intVal(b);
	      },0);
	      var wajib = api
	        .column(4)
	        .data()
	        .reduce(function (a, b) {
	        return intVal(a) + intVal(b);
	      },0);
	      var sukarela = api
	        .column(5)
	        .data()
	        .reduce(function (a, b) {
	        return intVal(a) + intVal(b);
	      },0);
	      var jumlah_simpanan = api
	        .column(6)
	        .data()
	        .reduce(function (a, b) {
	        return intVal(a) + intVal(b);
	      },0);
	      var sembako = api
	        .column(8)
	        .data()
	        .reduce(function (a, b) {
	        return intVal(a) + intVal(b);
	      },0);
	      var btn = api
	        .column(9)
	        .data()
	        .reduce(function (a, b) {
	        return intVal(a) + intVal(b);
	      },0);
	      var bsm = api
	        .column(10)
	        .data()
	        .reduce(function (a, b) {
	        return intVal(a) + intVal(b);
	      },0);
	      var jml_laba_peranggota = api
	        .column(11)
	        .data()
	        .reduce(function (a, b) {
	        return intVal(a) + intVal(b);
	      },0);
	        
	      // Update footer by showing the total with the reference of the column index 
	      $(api.column(0).footer()).html();
	      $(api.column(1).footer()).html();
	      $(api.column(2).footer()).html();
	      $(api.column(3).footer()).html(rupiah(pokok));
	      $(api.column(4).footer()).html(rupiah(wajib));
	      $(api.column(5).footer()).html(rupiah(sukarela));
	      $(api.column(6).footer()).html('Rp. '+rupiah(jumlah_simpanan)); 
	      $(api.column(7).footer()).html();
	      $(api.column(8).footer()).html(rupiah(sembako));
	      $(api.column(9).footer()).html(rupiah(btn));
	      $(api.column(10).footer()).html(rupiah(bsm));
	      $(api.column(11).footer()).html('Rp. '+rupiah(jml_laba_peranggota));
	      $(api.column(12).footer()).html();
	   },
      	"columnDefs": [
	      {className: 'text-center', targets: [0,7,12]},
	      {className: 'text-right', targets: [1,3,4,5,6,8,9,10,11]},
	   	]
	});
</script>