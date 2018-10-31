<div class="row">
	<div class="col-md-6">
		<div class="box box-success">
		  <div class="box-header with-border"></div>
		  <div class="box-body">
	  		<div class="form-group">
	  			<label>SIMPANAN PER</label>
	  			<select name="m_id" id="members_id" class="form-control pull-right select2">
	                <option value=""></option>
			        <?php foreach ($members as $opt): ?>
			        <?php echo '<option value="'.$opt->kd_angg.'">'.$opt->kd_angg.' - '.$opt->nm_angg.'</option>';?>
			        <?php endforeach ?>
	            </select>
	    		<div class="input-group date input-group-sm">
	                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
	                <input name="f_date" id="f_date" class="form-control pull-right" type="text" placeholder="Tanggal Awal"/>
	            	<div class="input-group-addon"><i>s/d</i></div>
	                <input name="l_date" id="l_date" class="form-control pull-right" type="text" placeholder="Tanggal Akhir"/>
	                <span class="input-group-btn">
	                  <button type="button" class="btn btn-success btn-flat" onclick="show_report()"><i class="fa fa-search"></i> CEK</button>	
	                </span>
	          	</div>
	    	</div>
		  	<hr>
		  	<div id="output">
		  		<label>SIMPANAN ANGGOTA</label>
		  		<input type="text" name="" id="jumlah" class="form-control" readonly="readonly"/>
		  		<label>TOTAL SIMPANAN</label>
		  		<input type="text" name="" id="total" class="form-control" readonly="readonly"/>
		  		<label>MODAL %</label>
		  		<input type="text" name="" id="modal" class="form-control" readonly="readonly"/>
		  	</div>
		  </div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="box box-success">
		  <div class="box-header with-border">
		    <h3 class="box-title"><?php echo $title; ?></h3>
		  </div>
		  <div class="box-body">
		  	<div id="rincian">
		  		<?php echo form_open('#',array('id'=>'net_income','autocomplete'=>'off')); ?>
		  			<div id="message"></div>
		  			<div class="form-group">
		  				<label>ANGGOTA</label>
		  				<input type="text" id="anggota" class="form-control" placeholder="ANGGOTA" readonly="readonly"/>
		  			</div>
		  			<input type="hidden" name="kd_angg" id="kd_angg"/>
		  			<div id="tgl_rekap-group" class="form-group">
			  			<label>TANGGAL REKAP</label>
				  		<input type="text" name="tgl_rekap" id="datepicker" class="form-control" placeholder="dd-mm-yyyy" />
				  	</div>
				  	<div class="form-group">
			  			<label>SEMBAKO</label>
			  			<input type="text" name="sembako" id="rp1" class="form-control" placeholder="Rp.0"/>
			  		</div>
			  		<div class="form-group">
			  			<label>BTN</label>
			  			<input type="text" name="btn" id="rp2" class="form-control" placeholder="Rp.0"/>
			  		</div>
			  		<div class="form-group">
			  			<label>BSM</label>
			  			<input type="text" name="bsm" id="rp3" class="form-control" placeholder="Rp.0"/>
			  		</div>
			  		<div class="form-group">
			  			<button type="button" class="btn btn-success btn-sm" onclick="process()">REKAP</button>
			  		</div>
		  		<?php echo form_close(); ?>
		  	</div>
		  </div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$('#output, #rincian').hide();
	$(document).ready(function() {
		$('#members_id').select2({
	      placeholder: 'ANGGOTA',
	      allowClear: false
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
	});
	function show_report() {
		$('h4#output_title').text('SISA HASIL USAHA');
		var members_id = $('#members_id').val();
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
    	if (members_id == ""){
			$('#members_id').focus();
			alert('Anggota Belum Diisi');
	      return false;
	   	}
    	else if (first_date == ""){
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
	    	$('#output, #rincian').show();
	    	get_savings();
	    	get_savings_members();
	   	}
	}
	function get_savings() {
		var first_date = $('#f_date').val();
		var last_date  = $('#l_date').val();
		$.ajax({
			type : 'POST',
			url : '<?php echo site_url('net_income/savings_amount') ?>',
			data : {
				f_date : first_date,
				l_date : last_date,
			},
			cache : false,
			dataType : 'JSON',
			success : function(data) {
				var total = data.total_simpanan
				$('#total').val(rupiah(total));
			},
			error : function(jqXHR, textStatus, errorThrown) {
				alert(xhr.statusText);
				alert(errorThrown);
			}
		});
	}
	function get_savings_members() {
		var members_id = $('#members_id').val()
		var first_date = $('#f_date').val();
		var last_date  = $('#l_date').val();
		$.ajax({
			type : 'POST',
			url : '<?php echo site_url('net_income/members_amount') ?>',
			data : {
				m_id   : members_id,
				f_date : first_date,
				l_date : last_date,
			},
			cache : false,
			dataType : 'JSON',
			success : function(data) {
				var kd_angg = data.kd_angg;
				var nm_angg = data.nm_angg;
				var jml = data.jumlah_simpanan;
				var tot = $('#total').val().replace(/,/g,"");
				var modal = (jml/tot).toFixed(2);
				document.getElementById('jumlah').value = rupiah(jml);
				document.getElementById('kd_angg').value=kd_angg;
				document.getElementById('anggota').value= kd_angg+' - '+nm_angg;
				if(typeof modal != 'undefined'){ 
					document.getElementById('modal').value = modal;
			    }
			},
			error : function(jqXHR, textStatus, errorThrown) {
				alert(xhr.statusText);
				alert(errorThrown);
			}
		});
	}
	function process() {
		$('.form-group').removeClass('has-error');
    	$('.help-block').empty();
		$.ajax({
			url: '<?php echo site_url('net_income/save_net_income');?>',
			type: 'POST',
			dataType: 'JSON',
			data: $('#net_income').serialize(),
			encode:true,
			success:function (data) {
				if (!data.success) {
					if (data.errors.tgl_rekap) {
			            $('#tgl_rekap-group').addClass('has-error');
			            $('#tgl_rekap-group').append('<div class="help-block">'+data.errors.tgl_rekap+'</div>'); 
			         }
				}else{
		          $('#message').html(data.message).addClass('alert alert-info');
		          setTimeout(function () {
		            window.location.reload();
		          },1500);
		        }
			},error: function (jqXHR, textStatus, errorThrown){
		        alert('Error get data from ajax');
		    }
		});
	}
</script>