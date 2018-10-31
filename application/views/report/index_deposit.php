<div class="row">
	<div class="col-md-6">
		<div class="box box-success">
		    <div class="box-header">
		      <h3 class="box-title"><?php echo $title; ?> PER ANGGOTA</h3>
		    </div>
		    <div class="box-body">
		    	<?php echo form_open('report/export_deposit_members/',array('id'=>'form_by_member','target'=>'_blank','onSubmit'=>'return validate(this)','autocomplete'=>'off')); ?>
		    	<div class="form-group">
                  <label>ANGGOTA</label>
                  <select name="kd_angg" class="form-control">
					<option value=""></option>
					<?php foreach ($members as $opt): ?>
					<?php echo '<option value="'.$opt->kd_angg.'">'.$opt->kd_angg.'-'.$opt->nm_angg.'</option>'; ?>
					<?php endforeach ?>
					</select>
                </div>
                <div class="form-group">
                	<div class="input-group input-group-sm">
                		<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
		              	<input name="first_date" id="first_date" class="form-control" type="text" placeholder="Tanggal Awal"/>
	                	<div class="input-group-addon"><i>s/d</i></div>
		                <input name="last_date" id="last_date" class="form-control pull-right" type="text" placeholder="Tanggal Akhir"/>
	                    <span class="input-group-btn">
	                      <button type="button" class="btn btn-success btn-flat" onclick="show_report_members()"><i class="fa fa-search"></i> CEK</button>	
	                      <button type="submit" name="pdf" class="btn btn-success btn-flat"><i class="fa fa-file-pdf-o"></i> PDF</button>
	                      <button type="submit" name="xls" class="btn btn-success btn-flat"><i class="fa fa-file-excel-o"></i> XLS</button>
	                    </span>
	              	</div>
                </div>
		    	<?php echo form_close(); ?>
		    </div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="box box-success">
		    <div class="box-header">
		      <h3 class="box-title"><?php echo $title; ?> PER TANGGAL</h3>
		    </div>
		    <div class="box-body">
				<?php echo form_open('report/export_deposit_date/',array('id'=>'form_deposit','target'=>'_blank','onSubmit'=>'return validate2(this)','autocomplete'=>'off')); ?>
	        	<div class="form-group">
	        		<div class="input-group date input-group-sm">
		                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
		                <input name="f_date" id="f_date" class="form-control pull-right" type="text" placeholder="Tanggal Awal"/>
	                	<div class="input-group-addon"><i>s/d</i></div>
		                <input name="l_date" id="l_date" class="form-control pull-right" type="text" placeholder="Tanggal Akhir"/>
	                    <span class="input-group-btn">
	                      <button type="button" class="btn btn-success btn-flat" onclick="show_report()"><i class="fa fa-search"></i> CEK</button>	
	                      <button type="submit" name="pdf" class="btn btn-success btn-flat"><i class="fa fa-file-pdf-o"></i> PDF</button>
	                      <button type="submit" name="xls" class="btn btn-success btn-flat"><i class="fa fa-file-excel-o"></i> XLS</button>
	                    </span>
	              	</div>
	        	</div>
	        	<?php echo form_close(); ?>
		    </div>
		</div>
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
	          <th width="3%" rowspan="2" valign="middle">NO</th>
	          <th rowspan="2">KODE</th>
	          <th rowspan="2">TANGGAL</th>
	          <th rowspan="2" style="text-align:center;">NAMA ANGGOTA</th>
	          <th colspan="3" style="text-align:center;">SIMPANAN</th>
	          <th rowspan="2">JUMLAH</th>
	        </tr>
	        <tr>
	          <th>POKOK</th>
	          <th>WAJIB</th>
	          <th>SUKARELA</th>
	        </tr>
         </thead>
         <tbody></tbody>
         <tfoot>
            <tr>
             <th style="text-align:right"></th>
             <th style="text-align:right"></th>
             <th style="text-align:right"></th>
             <th style="text-align:right"></th>
             <th style="text-align:center"></th>
             <th style="text-align:center"></th>
             <th style="text-align:center"></th>
             <th style="text-align:center"></th>
            </tr>
         </tfoot>
      </table>
  	</div>
</div>
<div id="output2" class="box box-success">
  	<div class="box-header with-border">
    	<h3 id="output_title2" class="box-title"></h3>
  	</div>
  	<div class="box-body table-responsive no-padding">
  		<h4 id="output_date2" style="text-align:center"></h4>
  		<table id="table-data2" class="table table-bordered table-striped table-hover" width="100%">
         <thead>
            <tr>
	          <th width="3%" rowspan="2" valign="middle">NO</th>
	          <th rowspan="2">KODE</th>
	          <th rowspan="2">TANGGAL</th>
	          <th rowspan="2" style="text-align:center;">NAMA ANGGOTA</th>
	          <th colspan="3" style="text-align:center;">SIMPANAN</th>
	          <th rowspan="2">JUMLAH</th>
	        </tr>
	        <tr>
	          <th>POKOK</th>
	          <th>WAJIB</th>
	          <th>SUKARELA</th>
	        </tr>
         </thead>
         <tbody></tbody>
         <tfoot>
            <tr>
             <th style="text-align:right"></th>
             <th style="text-align:right"></th>
             <th style="text-align:right"></th>
             <th style="text-align:right"></th>
             <th style="text-align:center"></th>
             <th style="text-align:center"></th>
             <th style="text-align:center"></th>
             <th style="text-align:center"></th>
            </tr>
         </tfoot>
      </table>
  	</div>
</div>
<script type="text/javascript">
	$('#output,#output2').hide();
	$('select[name="kd_angg"]').select2({
		placeholder: 'NAMA ANGGOTA',
		allowClear: false
    });
   	$('#first_date').datepicker({
		autoclose: true,
	    format: 'dd-mm-yyyy',
	    todayHighlight: true,
        orientation: "bottom auto",
        todayBtn: true,
        todayHighlight: true,
	}).on('changeDate', function (selected) {
	    var startDate = new Date(selected.date.valueOf());
	    $('#last_date').datepicker('setStartDate', startDate);
	}).on('clearDate', function (selected) {
	    $('#last_date').datepicker('setStartDate', null);
	});
   	$("#last_date").datepicker({
	   	autoclose: true,
	    format: 'dd-mm-yyyy',
	    todayHighlight: true,
        orientation: "bottom auto",
        todayBtn: true,
        todayHighlight: true,
	}).on('changeDate', function (selected) {
	   var endDate = new Date(selected.date.valueOf());
	   $('#first_date').datepicker('setEndDate', endDate);
	}).on('clearDate', function (selected) {
	   $('#first_date').datepicker('setEndDate', null);
	});

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
	function show_report_members() {
		$('h3#output_title').text('DATA SIMPANAN');
		var kd_anggota = $('select[name="kd_angg"]').val();
		var first_date = $('#first_date').val();
		var last_date 	= $('#last_date').val();
    	var bulan = ['Januari', 'Februari', 'Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    	var bulann = ['Januari', 'Februari', 'Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    	var t_awal=$('#first_date').val();
    	var t_akhir=$('#last_date').val();
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
		if (kd_anggota== ""){
			$('select[name="kd_angg"]').focus();
			alert('Nama Anggota Belum Diisi');
	      return false;
	   	}else if (first_date == ""){
			$('#first_date').focus();
			alert('Tanggal Awal Belum Diisi');
	      return false;
	   	}else if (last_date== ""){
			$('#last_date').focus();
			alert('Tanggal Akhir Belum Diisi');
	      return false;
	   	}else{
	    	$('#output').show();
	    	$('#output2').hide();
	    	dataTable.draw();
	   	}
	}
	var dataTable=$('#table-data').DataTable({
		"paging":   false,
		"searching": false,
      	"ordering": false,
      	"processing": true,
      	"serverSide": true,
      	"info":false,
      	"ajax": {
			"url": "<?php echo site_url('report/json_deposit_members'); ?>",
			"type": "POST",
			"data":function(data) {
				data.kd_angg=$('select[name="kd_angg"]').val();
				data.first_date=$('input[name="first_date"]').val();
				data.last_date=$('input[name="last_date"]').val();
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
            .column(4)
            .data()
            .reduce( function (a, b) {
            return intVal(a) + intVal(b);
         },0);
	      var wajib = api
	         .column(5)
	         .data()
	         .reduce(function (a, b) {
	         return intVal(a) + intVal(b);
	      },0);
	      var sukarela = api
            .column(6)
            .data()
            .reduce( function (a, b) {
            return intVal(a) + intVal(b);
         },0);
         var total_simpanan = api
            .column(7)
            .data()
            .reduce( function (a, b) {
            return intVal(a) + intVal(b);
         },0);
	      // Update footer by showing the total with the reference of the column index 
	      $(api.column(0).footer()).html();
	      $(api.column(4).footer()).html('Rp. '+rupiah(pokok));
	      $(api.column(5).footer()).html('Rp. '+rupiah(wajib));
	      $(api.column(6).footer()).html('Rp. '+rupiah(sukarela));
	      $(api.column(7).footer()).html('Rp. '+rupiah(total_simpanan));
	   },
      	"columnDefs": [
	      {className: 'text-center', targets: [0,1,2,4,5,6,7]},
	   	]
	});
	function show_report() {
		$('h3#output_title2').text('DATA SIMPANAN');
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

    	$('h4#output_date2').html(awal+ ' s/d '+akhir);
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
	    	$('#output').hide();
	    	$('#output2').show();
	    	dataTables.draw();
	   	}
	}
	var dataTables=$('#table-data2').DataTable({
		"paging":   false,
		"searching": false,
      	"ordering": false,
      	"processing": true,
      	"serverSide": true,
      	"info":false,
      	"ajax": {
			"url": "<?php echo site_url('report/json_deposit_date') ?>",
			"type": "POST",
			"data":function(data) {
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
            .column(4)
            .data()
            .reduce( function (a, b) {
            return intVal(a) + intVal(b);
         },0);
	      var wajib = api
	         .column(5)
	         .data()
	         .reduce(function (a, b) {
	         return intVal(a) + intVal(b);
	      },0);
	      var sukarela = api
            .column(6)
            .data()
            .reduce( function (a, b) {
            return intVal(a) + intVal(b);
         },0);
         var amount = api
            .column(7)
            .data()
            .reduce( function (a, b) {
            return intVal(a) + intVal(b);
         },0);
	      // Update footer by showing the total with the reference of the column index 
	      $(api.column(0).footer()).html();
	      $(api.column(4).footer()).html('Rp. '+rupiah(pokok));
	      $(api.column(5).footer()).html('Rp. '+rupiah(wajib));
	      $(api.column(6).footer()).html('Rp. '+rupiah(sukarela));
	      $(api.column(7).footer()).html('Rp. '+rupiah(amount));
	   },
      "columnDefs": [
	      {className: 'text-center', targets: [0,1,2,4,5,6,7]},
	   ]
	});
	function validate(form){
		$('#output').hide();
		if ($('select[name="kd_angg"]').val() == ""){
			$('select[name="kd_angg"]').focus();
			alert('Nama Anggota Belum Diisi');
	        return false;
	    }
	    if ($('input[name="first_date"]').val() == ""){
			$('input[name="first_date"]').focus();
			alert('Tanggal Awal Belum Diisi');
	        return false;
	    }
	    if ($('input[name="last_date"]').val() == ""){
			$('input[name="last_date"]').focus();
			alert('Tanggal Akhir Belum Diisi');
	        return false;
	    }
	    return (true);
	}
	function validate2(form){
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
</script>