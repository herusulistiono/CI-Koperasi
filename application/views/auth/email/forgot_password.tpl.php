<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
 	<style type="text/css" media="screen">
		.nota-container {
		   width: 600px;
		   color: #051f49;
		   min-height: 100px;
		}
		.nota-container img.logo {
		   float: left;
		   margin: 0 0 0 0;
		}
		.bold-line, .single-line {
		   clear: both;
		   width: 80%;
		   display: block;
		   margin: 5px 0 0 0;
		   border-bottom: 2px solid #003366;
		}
		.single-line {
		   margin: 1px 0 0 0;
		   border-bottom: 1px solid #003366;
		}
		.button {
		    background-color: #4CAF50; /* Green */
		    border: none;
		    color: white;
		    padding: 10px 28px;
		    text-align: center;
		    text-decoration: none;
		    display: inline-block;
		    font-size: 14px;
		}
	</style>
</head>
<body>
<div class="nota-container">
   <table width="100%">
	    <tr>
	    	<td>
	    		<div>
	    			<img src="<?php echo base_url('assets/img/logo.png');?>" width="100px" height="100px"/>
	    		</div>
	    	</td>
	    	<td valign="top">
	    		<div style=" margin: 0 0 0 3px;">
	    			<font style="text-transform: uppercase; font-size:35px;color:#051f49;font-weight: bold;">
	    				KOPKAR UNINDRA
	    			</font>
	    			<font style="font-size:11px; color: #051f49;">
	    				<br>
	    				Jl. Nangka No. 58C Tanjung Barat, Jagakarsa, Jakarta Selatan <br>
						Jl. Raya Tengah, Kelurahan Gedong, Pasar Rebo - Jakarta Timur<br>
						Handphone: 0815 1042 5951 - 0812 1341 9198, <br>Website :http://kopkarunindra.com || E-mail :kopkar.unindra@gmail.com
					</font>
	    		</div>
	    	</td>
	    </tr>
	</table>
	<div class="bold-line"></div>
	<h3><?php echo sprintf(lang('email_forgot_password_heading'), $identity);?></h3>
	<p><?php echo sprintf(lang('email_forgot_password_subheading'), anchor('auth/reset_password/'. $forgotten_password_code, lang('email_forgot_password_link')));?></p>
</div>
</body>
</html>