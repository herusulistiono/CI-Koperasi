<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $title; ?></h3>
  </div>
  <div class="box-body">
  	<?php echo form_open('#',array('id'=>'form','autocomplete'=>'off')); ?>
		<div class="form-group">
			<label class="control-label">KODE:</label>
			<input type="text" name="kd_prod" value="<?php echo $generate;?>" class="form-control input-sm" readonly="readonly"/>
		</div>
		<div id="barcode-group" class="form-group">
			<label class="control-label">BARCODE (Gunakan Perangkat):</label>
			<input type="text" name="barcode" id="barcode" class="form-control input-sm" placeholder="BARCODE" autofocus="autofocus" onkeypress="return dont_enter(event)" onkeyup="already_exists()"/>
			<!-- onchange="already_exists()" -->
		</div>
		<div id="nm_prod-group" class="form-group">
			<label class="control-label">NAMA PRODUK:</label>
			<input type="text" name="nm_prod" class="form-control input-sm" placeholder="NAMA PRODUK"/>
		</div>
		<div id="id_kat-group" class="form-group">
			<label class="control-label">KATEGORI:</label>
			<select name="id_kat" class="form-control input-sm">
				<option value=""></option>
				<?php foreach ($category as $opt): ?>
					<option value="<?php echo $opt->id_kat;?>"><?php echo $opt->nm_kategori;?></option>
				<?php endforeach ?>
			</select>
		</div>
		<div id="harga_beli-group" class="form-group">
			<label class="control-label">HARGA BELI:</label>
			<input type="text" name="harga_beli" id="rp1" class="form-control input-sm" placeholder="HARGA BELI"/>
		</div>
		<div id="harga_jual-group" class="form-group">
			<label class="control-label">HARGA JUAL:</label>
			<input type="text" name="harga_jual" id="rp2" class="form-control input-sm" placeholder="HARGA JUAL"/>
		</div>
		<div id="stok-group" class="form-group">
			<label class="control-label">STOK:</label>
			<input type="number" name="stok" class="form-control input-sm" placeholder="STOK"/>
		</div>
		<!-- <div  class="form-group">
			<label class="control-label">DISKON (Jika Ada):</label>
			<input type="text" name="diskon" class="form-control" placeholder="DISKON"/>
		</div> -->
		<div id="satuan-group" class="form-group">
			<label class="control-label">SATUAN:</label>
			<input type="text" name="satuan" class="form-control input-sm" placeholder="SATUAN"/>
		</div>
		<div class="form-group">
			<button type="button" class="btn btn-success btn-sm" onclick="process()">Simpan</button>
			<?php echo anchor('product','Batal',array('class'=>'btn btn-warning btn-sm'));?>
		</div>
	<?php echo form_close(); ?>
  </div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('select').select2({
    		placeholder: 'PILIH KATEGORI',
    		allowClear: false
    	});
		$('.form-group').removeClass('has-error');
    	$('.help-block').empty();
	});
	$('#barcodes').keyup(function(e) {
		e.preventDefault();
		$.ajax({
			url: "<?php echo site_url('product/check_barcode'); ?>",
			type: 'POST',
			dataType: 'json',
			data: 'barcode='+$('#barcode').val(),
			cache   : false,
	        encode  : true,
	        success:function(data) {
	        	if (data.barcode > 0) {
        			alert('Data Sudah Ada');
    				$('input[name="barcode"]').focus();
        			return false;
        		}else{
        			return true;
        		}
	        }
		});
	});
	function already_exists() {
		$.ajax({
			url: "<?php echo site_url('product/check_barcode'); ?>",
			type: 'POST',
			dataType: 'json',
			data: 'barcode='+$('#barcode').val(),
			cache: false,
        	//contentType : false,
        	//processData : false,
	        encode  : true,
	        success:function(data) {
	        	if (data.barcode > 0) {
        			alert('Data Sudah Ada');
    				$('input[name="barcode"]').focus().val('');
        			return false;
        		}else{
        			return true;
        		}
	        },error: function (jqXHR, textStatus, errorThrown){
	        	alert('Error get data from ajax');}
		});
	}
	function process() {
		$('.form-group').removeClass('has-error');
    	$('.help-block').empty();
		$.ajax({
	      url : '<?php echo site_url('product/save') ?>',
	      type: 'POST',
	      data: $('#form').serialize(),
	      dataType: 'JSON',
	      encode:true,
	      success: function(data){
	        console.log(data);
		      if (!data.success) {
		      	if (data.errors.barcode) {
		          $('#barcode-group').addClass('has-error');
		          $('#barcode-group').append('<div class="help-block">'+data.errors.barcode+'</div>'); 
		        }
		        if (data.errors.nm_prod) {
		          $('#nm_prod-group').addClass('has-error');
		          $('#nm_prod-group').append('<div class="help-block">'+data.errors.nm_prod+'</div>'); 
		        }
		        if (data.errors.id_kat) {
		          $('#id_kat-group').addClass('has-error');
		          $('#id_kat-group').append('<div class="help-block">'+data.errors.id_kat+'</div>'); 
		        }
		        if (data.errors.harga_beli) {
		          $('#harga_beli-group').addClass('has-error');
		          $('#harga_beli-group').append('<div class="help-block">'+data.errors.harga_beli+'</div>'); 
		        }
		        if (data.errors.harga_jual) {
		          $('#harga_jual-group').addClass('has-error');
		          $('#harga_jual-group').append('<div class="help-block">'+data.errors.harga_jual+'</div>'); 
		        }
		        if (data.errors.stok) {
		          $('#stok-group').addClass('has-error');
		          $('#stok-group').append('<div class="help-block">'+data.errors.stok+'</div>'); 
		        }
		        if (data.errors.satuan) {
		          $('#satuan-group').addClass('has-error');
		          $('#satuan-group').append('<div class="help-block">'+data.errors.satuan+'</div>'); 
		        }
		      }else{
		        alert(data.message);
		        window.location.href='<?php echo site_url('product') ?>';
		      }
	       }
	    });
	}
	function dont_enter(evt) {
	    var evt = (evt) ? evt : ((event) ? event : null);
	    var node = (evt.target) ? evt.target:((evt.srcElement) ? evt.srcElement : null);
	    if ((evt.keyCode == 13) && (node.type=="text")){return false;}
	}
	document.onkeypress=dont_enter;
</script>