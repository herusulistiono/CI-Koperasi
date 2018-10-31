<div class="box box-success">
   <div class="box-header with-border">
      <h3 class="box-title"><?php echo $title; ?></h3>
   </div>
   <div class="box-body">
   	<?php echo form_open('',array('id'=>'form')); ?>
		<div class="row">
			<div class="col-xs-12">
                <div class="form-group">
                    <label>Kode Anggota:</label>
                    <?php echo form_input($memberID);?>
                </div>
				<div id="ktp_number-group" class="form-group">
					<label>No KTP:</label>
					<?php echo form_input($ktp_number);?>
				</div>
				<div id="fullname-group" class="form-group">
					<label>Nama Lengkap:</label>
					<?php echo form_input($fullname);?>
				</div>
				<div id="phone-group" class="form-group">
					<label>No Telp:</label>
					<?php echo form_input($phone);?>
				</div>
				<div id="sex-group" class="form-group">
					<label>Kelamin:</label>
					<p></p>
	       		    <?php $radio=$sex; $data_sex=array('L'=>'Laki-Laki','P'=>'Perempuan');
    	              foreach ($data_sex as $check => $name){
    	                if ($radio == $check) {
    						echo '&nbsp;<input type="radio" name="sex" class="minimal" value="'.$check.'" checked="checked"/>&nbsp;'.$name;
    	                } else {
    	                	echo '&nbsp;<input type="radio" name="sex" class="minimal" value="'.$check.'"/>&nbsp;'.$name;
    	                }
    	              }
    	            ?>
				</div>
			</div>
	        <div class="col-xs-6">
	         	<div id="place_of_birth-group" class="form-group">
	         		<label>Tempat Lahir:</label>
	            	<?php echo form_input($place_of_birth); ?>
	            </div>
	        </div>
	        <div class="col-xs-6">
	         	<div id="date_of_birth-group" class="form-group">
	         		<label>Tanggal Lahir:</label>
	            	<?php echo form_input($date_of_birth);?>
	            	<p>dd/mm/yyy</p>
	            </div>
	        </div>
	        <div class="col-xs-12">
				<div id="address-group" class="form-group">
					<label>Alamat Lengkap:</label>
					<?php echo form_textarea($address);?>
				</div>
				<div id="registered-group" class="form-group">
					<label>BERGABUNG SEJAK:</label>
					<?php echo form_input($registered);?>
				</div>
				<div class="form-group">
					<button type="button" class="btn btn-success btn-sm" onclick="save()">Ubah</button> <?php echo anchor('members','Batal',array('class'=>'btn btn-warning btn-sm'));?>
				</div>
			</div>
	    </div>
   	<?php echo form_close(); ?>
    </div>
</div>
<script type="text/javascript">
	$(function() {
		$('.select2').select2({
    		placeholder: 'Pilih Pekerjaan',
    		allowClear: false
    	});
    	
		//$('#date_of_birth, #registered').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
	    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
	      checkboxClass: 'icheckbox_flat-green',
	      radioClass   : 'iradio_flat-green'
	    })
	    $('#date_of_birth, #registered').datepicker({
			autoclose: true,
			format: "yyyy-mm-dd",
	        orientation: "top auto",
		});
	});
	function save() {
		$.ajax({
	      url : '<?php echo site_url('members/update/') ?>',
	      type: 'POST',
	      data: $('#form').serialize(),
	      dataType: 'JSON',
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
                if (data.errors.email) {
                    $('#email-group').addClass('has-error');
                    $('#email-group').append('<div class="help-block">'+data.errors.email+'</div>'); 
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
		       	window.location.href='<?php echo site_url('members');?>';
		     }
	      }
	    });
	}
	/*
	$('.datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,  
    });
	*/
</script>