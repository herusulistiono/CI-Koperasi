<!-- Setting CSS bagian header/ kop -->
<style type="text/css">
  table.page_header {width: 1020px; border: none; background-color: #3C8DBC; color: #fff; border-bottom: solid 1mm #AAAADD; padding: 2mm }
  table.page_footer {width: 1020px; border: none; background-color: #3C8DBC; border-top: solid 1mm #AAAADD; padding: 2mm}
  h1 {color: #000033}
  h2 {color: #000055}
  h3 {color: #000077}
</style>
<!-- Setting Margin header/ kop -->
  <!-- Setting CSS Tabel data yang akan ditampilkan -->
  <style type="text/css">
  .tabel2 {border-collapse: collapse;margin-left: 5px;    }
  .tabel2 th, .tabel2 td {
      padding: 5px 5px;
      border: 1px solid #959595;
      font-size: 11px;
  	}

   div.kanan {
     width:300px;
	 float:right;
     margin-left:250px;
     margin-top:-140px;
  }

  div.kiri {
	  width:300px;
	  float:left;
	  margin-left:20px;
	  display:inline;
  }
  
  </style>
  <table>
    <tr>
      <th rowspan="3"><img src="assets/img/logo.png" style="width:100px;height:100px" /></th>
      <td align="center" style="width: 520px;">
      	<font style="font-size: 20px"><strong>KOPERASI PEGAWAI <br>UNIVERSITAS INDRAPRASTA PGRI</strong></font>
      	<br>
      		Kantor : Jl. Nangka No. 58C Tanjung Barat, Jagakarsa, Jakarta Selatan <br>
			Jl. Raya Tengah, Keluar Gedong, Pasar Rebo - Jakarta Timur, Jakarta Timur<br> 
			Telp: 021 - 333866055, +62815 11075 850 +62815 1042 5951 +62812 1341 9198 <br>
			Email : kopkar.unindra@gmail.com
      </td>
	  <th rowspan="3"><div style="width:100px;height:80px"></div></th>
    </tr>
  </table>
  <hr>
  <p align="center">
    <u style="font-weight: bold; font-size: 18px;">LAPORAN SIMPANAN</u><br>
    <strong><?php echo $periode; ?></strong>
  </p>
  <table class="tabel2" style="table-layout: fixed; width="100%">
    <thead>
      <tr>
         <th width="3%" rowspan="2" valign="middle">NO</th>
         <th rowspan="2" style="text-align:center;">KODE</th>
         <th rowspan="2" style="text-align:center;">TANGGAL</th>
         <th rowspan="2" style="text-align:center;">NAMA ANGGOTA</th>
         <th colspan="3" style="text-align:center;">SIMPANAN</th>
         <th rowspan="2" style="text-align:center;">TOTAL</th>
      </tr>
      <tr>
         <th style="text-align:center;">POKOK</th>
         <th style="text-align:center;">WAJIB</th>
         <th style="text-align:center;">SUKARELA</th>
      </tr>
    </thead>
    <tbody>
      <?php $no=(int)1;$total=(int)0;$total_wajib=(int)0; $total_pokok=(int)0;$total_sukarela=(int)0; 
        foreach ($result as $rows): ?>
          <tr>
            <td style="text-align:center;"><?php echo $no++; ?></td>
            <td style="text-align:center;"><?php echo $rows->kd_simp; ?></td>
            <td><?php echo tanggal_indo($rows->tgl_simp);?></td>
            <td style="word-wrap: break-word"><?php echo $rows->kd_angg.' - '.$rows->nm_angg;?></td>
            <td style="text-align:right;"><?php echo number_format($rows->pokok,0,',','.');?></td>
            <td style="text-align:right;"><?php echo number_format($rows->wajib,0,',','.');?></td>
            <td style="text-align:right;"><?php echo number_format($rows->sukarela,0,',','.');?></td>
            <td style="text-align:right;"><?php echo  number_format($rows->wajib+$rows->pokok+$rows->sukarela,0,',','.') ?></td>
          </tr>
        	<?php 
        		$total_wajib += $rows->wajib;
        		$total_pokok += $rows->pokok;
        		$total_sukarela += $rows->sukarela;
        		$total += $rows->wajib+$rows->pokok+$rows->sukarela;
        		endforeach 
        	?>
        	<tr>
				<td colspan="3"></td>
				<td style="text-align:right;">Total</td>
	  			<td>Rp. <?php echo number_format($total_pokok,2,',','.');?></td>
          <td>Rp. <?php echo number_format($total_wajib,2,',','.');?></td>
	  			<td>Rp. <?php echo number_format($total_sukarela,2,',','.');?></td>
	  			<td>Rp. <?php echo number_format($total,2,',','.');?></td>
	  		</tr>
    </tbody>
  </table>
  
  <div class="kiri">
      <p>Mengetahui :<br>Manajer</p>
      <br>
      <br>
      <br>
      <p><b><u>Nama</u><br>NIK : 123456789</b></p>
  </div>

  <div class="kanan">
      <p>Mengetahui :<br>Asisten Manajer </p>
      <br>
      <br>
      <br>
      <p><b><u>Nama</u><br>NIK : 1234567890</b></p>
  </div>

<!-- Memanggil fungsi bawaan HTML2PDF -->
<?php
$content = ob_get_clean();
include APPPATH . 'third_party/html2pdf/html2pdf.class.php';
try{
	$css = '<style>'.file_get_contents('assets/bootstrap/css/bootstrap.min.css').'</style>';
   $html2pdf = new HTML2PDF('P', 'A4', 'en', false, 'UTF-8', array(10, 10, 4, 10));
   //$html2pdf = new Html2Pdf('P', 'A4', 'en', false, 'UTF-8', array(0, 0, 0, 0));
   $html2pdf->pdf->SetDisplayMode('fullpage');
   $html2pdf->writeHTML($content);
   $html2pdf->Output('simpanan.pdf');
}
catch(HTML2PDF_exception $e) {
   echo $e;
   exit;
}
?>