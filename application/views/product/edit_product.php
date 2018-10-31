<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $title; ?></h3>
  </div>
  <div class="box-body">
  	<?php echo form_open('#',array('id'=>'form','autocomplete'=>'off')); ?>
		<div class="form-group">
			<label class="control-label">KODE:</label>
			<?php echo form_input($kd_prod);?>
		</div>
		<div id="barcode-group" class="form-group">
			<label class="control-label">BARCODE (Gunakan Perangkat):</label>
			<?php echo form_input($barcode);?>
		</div>
		<div id="nm_prod-group" class="form-group">
			<label class="control-label">NAMA PRODUK:</label>
			<?php echo form_input($nm_prod);?>
		</div>
		<div id="id_kat-group" class="form-group">
			<label class="control-label">KATEGORI:</label>
			<select name="id_kat" class="form-control">
				<option value=""></option>
				<?php foreach ($category as $opt){
                  if ($id_kat==$opt->id_kat) {
                    $selected= 'selected="selected"';
                  }else{
                    $selected='';
                  }
                 echo '<option value="'.$opt->id_kat.'"'.$selected.'>'.$opt->nm_kategori.'</option>';
                }?>
			</select>
		</div>
		<div id="harga_beli-group" class="form-group">
			<label class="control-label">HARGA BELI:</label>
			<?php echo form_input($harga_beli); ?>
		</div>
		<div id="harga_jual-group" class="form-group">
			<label class="control-label">HARGA JUAL:</label>
			<?php echo form_input($harga_jual); ?>
		</div>
		<div id="stok-group" class="form-group">
			<label class="control-label">STOK:</label>
			<?php echo form_input($stok); ?>
		</div>
		<!-- <div  class="form-group">
			<label class="control-label">DISKON (Jika Ada):</label>
			<input type="text" name="diskon" class="form-control" placeholder="DISKON"/>
		</div> -->
		<div id="satuan-group" class="form-group">
			<label class="control-label">SATUAN:</label>
			<?php echo form_input($satuan); ?>
		</div>
		<div class="form-group">
			<button type="button" class="btn btn-success btn-sm" onclick="process()">Ubah</button>
			<?php echo anchor('product','Batal',array('class'=>'btn btn-warning btn-sm'));?>
		</div>
	<?php echo form_close(); ?>
  </div>
</div>
<script type="text/javascript">
	$(function() {
		var extra = 0;
	    var $input = $('#harga_beli, #harga_jual');
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
	});
	$(document).ready(function() {
		$('select').select2({
    		placeholder: 'PILIH KATEGORI',
    		allowClear: false
    	});
		$('.form-group').removeClass('has-error');
    	$('.help-block').empty();
	});
	$(function() {
		var extra = 0;
	    var $input = $('#harga_beli, #harga_jual');
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
	});
	function process() {
		$('.form-group').removeClass('has-error');
    	$('.help-block').empty();
		$.ajax({
	      url : '<?php echo site_url('product/update/') ?>',
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
	function isNumber(evt) {
	    var iKeyCode = (evt.which) ? evt.which : evt.keyCode
	    if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57))
	      return false;
	    return true;
	}
	function dont_enter(evt) {
	    var evt = (evt) ? evt : ((event) ? event : null);
	    var node = (evt.target) ? evt.target:((evt.srcElement) ? evt.srcElement : null);
	    if ((evt.keyCode == 13) && (node.type=="text")){return false;}
	}
	document.onkeypress=dont_enter;
</script>