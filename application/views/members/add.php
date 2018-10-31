<div class="box box-success">
    <div class="box-header with-border">
      <h3 class="box-title"><?php echo $title; ?></h3>
    </div>
    <div class="box-body">
	    <?php echo form_open('',array('id'=>'form','class'=>'','autocomplete'=>'off')); ?>
			<div class="form-group">
				<label class="control-label">Kode Anggota:</label>
				<input type="text" name="memberID" value="<?php echo $generate; ?>" class="form-control input-sm" readonly="readonly"/>
			</div>
			<div id="ktp_number-group" class="form-group">
				<label class="control-label">No KTP:</label>
				<input type="text" name="ktp_number" class="form-control input-sm" placeholder="KTP" onkeypress="javascript:return isNumber(event)" autofocus="autofocus"/>
			</div>
			<div id="fullname-group" class="form-group">
				<label class="control-label">Nama Anggota:</label>
				<input type="text" name="fullname" class="form-control input-sm" placeholder="Nama Anggota"/>
			</div>
			<div id="sex-group" class="form-group">
				<label class="control-label">Kelamin:</label>
				<p></p>
				<label>
              		<input type="radio" name="sex" value="L" class="flat-red"/> Laki-Laki
              		<input type="radio" name="sex" value="P" class="flat-red"/> Perempuan
            	</label>
			</div>
			<div id="place_of_birth-group" class="form-group">
				<label class="control-label">Tempat Lahir:</label>
				<input type="text" name="place_of_birth" class="form-control input-sm" placeholder="Tempat Lahir"/>
			</div>
			<div id="date_of_birth-group" class="form-group">
				<label class="control-label">Tanggal Lahir:</label>
				<input type="text" name="date_of_birth" class="form-control input-sm" placeholder="dd/mm/yyyy" id="datepicker"/>
			</div>
			<div id="phone-group" class="form-group">
				<label class="control-label">No Telp:</label>
				<input type="text" name="phone" class="form-control input-sm" placeholder="No Telp" onkeypress="javascript:return isNumber(event)"/>
			</div>
			<div id="address-group" class="form-group">
				<label class="control-label">Alamat:</label>
				<textarea name="address" class="form-control input-sm" placeholder="Alamat"></textarea>
			</div>
			<div id="registered-group" class="form-group">
				<label class="control-label">BERGABUNG SEJAK:</label>
				<input type="text" name="registered" class="form-control input-sm" placeholder="dd/mm/yyyy" id="registered"/>
			</div>
			<div class="form-group">
				<button type="button" class="btn btn-success btn-sm" onclick="save()">Simpan</button>
				<?php echo anchor('members','Batal',array('class'=>'btn btn-warning btn-sm'));?>
			</div>
		<?php echo form_close(); ?>	
    </div>
</div>
<script type="text/javascript">
	$(function() {
		/*$('.select2').select2({
    		placeholder: 'Pilih Pekerjaan',
    		allowClear: false
    	});*/
    	$('#registered').datepicker({
    		autoclose: true,
		    format: 'dd-mm-yyyy',
		    todayHighlight: true,
	        orientation: "top auto",
	        todayBtn: true,
	        todayHighlight: true
		})
    	//$('#datepicker').inputmask('dd-mm-yyyy', { 'placeholder': 'dd-mm-yyyy' })
	    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
	      checkboxClass: 'icheckbox_flat-green',
	      radioClass   : 'iradio_flat-green'
	    });
	    $('.form-group').removeClass('has-error');
    	$('.help-block').empty();
	});
	$('.select2').select2({
      placeholder: {
        id: '-1',
        text: 'Select an option'
      },
      allowClear: false
   	});
   	function isNumber(evt) {
	    var iKeyCode = (evt.which) ? evt.which : event.keyCode
	    if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57))
	      	return false;
	    return true;
	}
	function save() {
		$('.form-group').removeClass('has-error');
    	$('.help-block').empty();
		$.ajax({
	      url : '<?php echo site_url('members/insert/') ?>',
	      type: 'POST',
	      data: $('#form').serialize(),
	      dataType: 'JSON',
	      encode:true,
	      success: function(data){
	        console.log(data);
		      if (!data.success) {
		      	if (data.errors.ktp_number) {
		          $('#ktp_number-group').addClass('has-error');
		          $('#ktp_number-group').append('<div class="help-block">'+data.errors.ktp_number+'</div>'); 
		        }
		        if (data.errors.fullname) {
		          $('#fullname-group').addClass('has-error');
		          $('#fullname-group').append('<div class="help-block">'+data.errors.fullname+'</div>'); 
		        }
		        if (data.errors.sex) {
		          $('#sex-group').addClass('has-error');
		          $('#sex-group').append('<div class="help-block">'+data.errors.sex+'</div>'); 
		        }
		        if (data.errors.type_id) {
		          $('#type_id-group').addClass('has-error');
		          $('#type_id-group').append('<div class="help-block">'+data.errors.type_id+'</div>'); 
		        }
		        if (data.errors.place_of_birth) {
		          $('#place_of_birth-group').addClass('has-error');
		          $('#place_of_birth-group').append('<div class="help-block">'+data.errors.place_of_birth+'</div>'); 
		        }
		        if (data.errors.date_of_birth) {
		          $('#date_of_birth-group').addClass('has-error');
		          $('#date_of_birth-group').append('<div class="help-block">'+data.errors.date_of_birth+'</div>'); 
		        }
		        if (data.errors.phone) {
		          $('#phone-group').addClass('has-error');
		          $('#phone-group').append('<div class="help-block">'+data.errors.phone+'</div>'); 
		        }
		        if (data.errors.address) {
		          $('#address-group').addClass('has-error');
		          $('#address-group').append('<div class="help-block">'+data.errors.address+'</div>'); 
		        }
		        if (data.errors.registered) {
                  $('#registered-group').addClass('has-error');
                  $('#registered-group').append('<div class="help-block">'+data.errors.registered+'</div>'); 
                }

		      }else{
		        alert(data.message);
		        window.location.href='<?php echo site_url('members') ?>';
		      }
	       }
	    });
	}
</script>