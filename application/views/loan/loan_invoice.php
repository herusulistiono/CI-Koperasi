<style type="text/css">
	.nota-container {
	   width: 720px;
	   color: #051f49;
	   min-height: 100px;
	}
	.nota-container img.logo {
	   float: left;
	   margin: 0 0 0 0;
	}
	.bold-line, .single-line {
	   clear: both;
	   width: 100%;
	   display: block;
	   margin: 5px 0 0 0;
	   border-bottom: 2px solid #003366;
	}
	.single-line {
	   margin: 1px 0 0 0;
	   border-bottom: 1px solid #003366;
	}
	div.kanan {
		width:450px;
		float:right;
		margin-left:10px;
		margin-top:5px;
  	}
  	div.kiri {
	  width:200px;
	  float:left;
	  display:inline;
  	}
  	table.paraf{table-layout:fixed;border-collapse: collapse;}
  .paraf th, .paraf td {
      padding: 5px 5px;
      border: 1px solid #051f49;
      font-size: 11px;
  	}
</style>
<div class="nota-container">
   <table>
	    <tr>
	    	<td>
	    		<div>
	    			<img src="assets/img/logo.png" class="logo" style="width:100px;height:100px"/>
	    		</div>
	    	</td>
	    	<td valign="top">
	    		<div style="width:380px; margin: 0 0 0 8px;">
	    			<font style="text-transform: uppercase; font-size:35px;color:#051f49;font-weight: bold;">
	    				KOPKAR UNINDRA
	    			</font>
	    			<font style="font-size:11px; color: #051f49;letter-spacing: 15px;">
	    				<br>
	    				Jl. Nangka No. 58C Tanjung Barat, Jagakarsa, Jakarta Selatan <br>
						Jl. Raya Tengah, Kelurahan Gedong, Pasar Rebo - Jakarta Timur<br>
						Handphone: 0815 1042 5951 - 0812 1341 9198, <br>Website :http://kopkar-unindra.com <br> E-mail :kopkar.unindra@gmail.com
					</font>
	    		</div>
	    	</td>
	    	<td>
	    		<div style="width:180px; margin: 0 0 0 0; font-size:13px; color: #051f49; text-align: right;">
		  			<font style="text-transform:capitalize;font-weight:bold;font-size:16px;">Bukti Pengeluaran Kas</font>
		  			<p></p>
		  			<p></p>
		  			<font style="font-weight:bold;font-size:14px;">
		  				<label>No. </label><span><u><?php echo $kd_pinj;?></u></span>
		  			</font>
		  		</div>
	    	</td>
	    </tr>
	</table>
	<div class="bold-line"></div>
	<br>
	<label><div style="border:1px solid #051f49; width:14px; height:14px; display: inline;"></div></label><span> TUNAI</span>
	<label style="margin-left: 50px;"><div style="border:1px solid #051f49; width:14px; height:14px; display: inline;"></div></label><span> CHEQUE No. </span>
	<div style="border-bottom: 1px solid #051f49; width: 500px; height:13px;"></div>
	<p></p>
	<table width="100%" style="table-layout:fixed">
		<tr>
			<td width="255">
				<table>
					<tr>
						<td>
							<label style="font-weight:bold;font-size:22px;color: #051f49;">Rp.</label>
						</td>
						<td style="border-bottom: 2px solid #051f49; background: url(assets/img/grid.png) repeat;">
							<font style="font-weight:bold;font-size:22px;color: #051f49; text-decoration: #051f49 overline;"> 
								<?php echo number_format($jml_pinj,0,',',','); ?>
							</font>
						</td>
					</tr>
				</table>
			</td>
			<td valign="top" align="justify" width="445" style="font-weight:bold; font-size: 15px; text-transform: capitalize; white-space:pre-wrap;white-space:-moz-pre-wrap;white-space:-pre-wrap;white-space:-o-pre-wrap;word-wrap:break-word;">
				<u><i><?php echo terbilang($jml_pinj); ?> Rupiah</i></u>
			</td>
		</tr>
		<tr>
			<td colspan="2" width="700" style="white-space:pre-wrap;white-space:-moz-pre-wrap;white-space:-pre-wrap;white-space:-o-pre-wrap;word-wrap:break-word; border-bottom:1px solid #051f49;">
				<br>
				<strong>Untuk Pembayaran</strong> <?php echo $ket_pinj;?>
			</td>
		</tr>
		<tr>
			<td colspan="2" width="700" style="white-space:pre-wrap;white-space:-moz-pre-wrap;white-space:-pre-wrap;white-space:-o-pre-wrap;word-wrap:break-word; border-bottom:1px solid #051f49;">
				<br>
			</td>
		</tr>
		<tr>
			<td colspan="2" width="700" style="white-space:pre-wrap;white-space:-moz-pre-wrap;white-space:-pre-wrap;white-space:-o-pre-wrap;word-wrap:break-word; border-bottom:1px solid #051f49;">
				<br>
			</td>
		</tr>
		<tr>
			<td colspan="2" width="700" style="white-space:pre-wrap;white-space:-moz-pre-wrap;white-space:-pre-wrap;white-space:-o-pre-wrap;word-wrap:break-word; border-bottom:1px solid #051f49;">
				<br>
			</td>
		</tr>
	</table>
	<!-- <table width="520" style="table-layout:fixed">
	    <tr>
	        <td valign="top" width="140">First Name:</td>
	        <td valign="top" width="380" style="white-space:pre-wrap;white-space:-moz-pre-wrap;white-space:-pre-wrap;white-space:-o-pre-wrap;word-wrap:break-word">Rp. <?php echo number_format($jml_pinj,0,',',','); ?></td>
	    </tr>
	    <tr>
	        <td valign="top" width="140">Last Name:</td>
	        <td valign="top" width="380" style="white-space:pre-wrap;white-space:-moz-pre-wrap;white-space:-pre-wrap;white-space:-o-pre-wrap;word-wrap:break-word">Yuen</td>
	    </tr>
	</table> -->
	<p></p>
	<table>
		<tr>
			<td>
				<table class="paraf" width="320">
			    	<tr>
			    		<th valign="top" align="center" width="100">Ketua</th>
			    		<th valign="top" align="center" width="100">Bendahara</th>
			    		<th valign="top" align="center" width="100">Kasir</th>
			    	</tr>
			    	<tr>
			    		<td valign="top" align="center" width="100"><br><br><br></td>
			    		<td valign="top" align="center" width="100"><br><br><br></td>
			    		<td valign="top" align="center" width="100"><br><br><br></td>
			    	</tr>
				</table>	
			</td>
			<td>
				<table width="220">
			    	<tr>
			    		<th width="100"></th>
			    		<th valign="top" align="center" width="200" style="white-space:pre-wrap;white-space:-moz-pre-wrap;white-space:-pre-wrap;white-space:-o-pre-wrap;word-wrap:break-word">
			    			Yang Menerima
			    			<br><br><br><br>
			    			(<u><?php echo $nm_angg;?></u>)
			    		</th>
			    	</tr>
				</table>
			</td>
		</tr>
	</table>
</div>

<?php
$content = ob_get_clean();
include APPPATH . 'third_party/html2pdf/html2pdf.class.php';
try{
	$html2pdf = new HTML2PDF('P', 'A4', 'en', false, 'UTF-8', array(10, 10, 4, 10));
	$html2pdf->writeHTML($content);
	$html2pdf->Output('bukti_pengeluaran_kas.pdf');
}
catch(HTML2PDF_exception $e) {
	echo $e;
	exit;
}
?>