<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- CETAK ANGSURAN PINJAMAN -->
<style type="text/css">
  table.page_header {width: 1020px; border: none; background-color: #3C8DBC; color: #fff; border-bottom: solid 1mm #AAAADD; padding: 2mm }
  table.page_footer {width: 1020px; border: none; background-color: #3C8DBC; border-top: solid 1mm #AAAADD; padding: 2mm}
  h1 {color: #000033}
  h2 {color: #000055}
  h3 {color: #000077}
  hr {clear: both;}
</style>
<!-- STYLE TANDA TANGAN -->
<style type="text/css">
  .tabel2 {border-collapse: collapse;margin-left: 5px;}
  .tabel2 th, .tabel2 td {padding: 5px 5px;border: 1px solid #959595;font-size: 12px;}
  div.top-left {width:300px;float:left;margin:0;padding: 0px;}
  div.kanan {width:300px;float:right;margin-left:250px;margin-top:-140px;}
  div.kiri {width:300px;float:left;margin-left:20px;display:inline;}
</style>

<table>
	<tr>
		<th rowspan="3"><img src="assets/img/logo.png" style="width:98px;height:98px" /></th>
		<th align="center" style="width: 520px;">
			<font style="font-size: 20px">
				<strong>KOPERASI KARYAWAN DAN DOSEN <br>UNIVERSITAS INDRAPRASTA PGRI</strong>
			</font><br>
  		<font style="font-size: 12px;font-weight: normal;">
  			Kantor : Jl. Nangka No. 58C Tanjung Barat, Jagakarsa, Jakarta Selatan <br>
  			Telp: 021 - 333866055, 3386608 Email : kopkar.unindra@gmail.com
  		</font>
  	</th>
  	<th rowspan="3"><div style="width:100px;height:80px"></div></th>
	</tr>
</table>
<hr>
<p align="center">
  FORM : <strong><?php echo $kd_pinj;?></strong><br>
  <u style="font-weight: bold; font-size: 18px;">SURAT PERSETUJUAN PEMBAYARAN</u><br>
  <strong><?php //echo $periode; ?></strong>
</p>
<div style="margin-left: 0; margin-right: 5px;">
<p align="justify">
  Berdasarkan surat permohonan <strong><?php echo $nm_angg; ?></strong>pada tanggal <strong><?php echo tanggal_indo($tgl_pinj);?></strong> diberitahukan bahwa permohonan tersebut dapat kami setujui, dengan ketentuan sebagai berikut:
</p>
<table style="table-layout: fixed; width="100%">
  <tr>
    <td>Jumlah Pembiayaan</td><td>:</td><td><strong>Rp. <?php echo number_format($jml_pinj,0,',','.');?></strong></td>
  </tr>
  <tr>
    <td>Jangka Waktu</td><td>:</td><td><strong><?php echo $tenor;?> Bulan</strong></td>
  </tr>
  <tr>
    <td>Cara Pembayaran</td><td>:</td><td><strong>Debet Rekening Gaji</strong></td>
  </tr>
</table>
</div>
<br>
<div style="margin-left: 50px;">
  <table class="tabel2" style="table-layout: fixed; width="100%" cellspacing="0" cellpadding="2">
    <thead>
      <tr><th colspan="5" align="center">TABEL ANGSURAN PINJAMAN</th></tr>
      <tr>
        <th align="center">BULAN KE</th>
        <th align="center">BULAN</th>
        <th align="center">TOTAL PINJAMAN</th>
        <th align="center">ANGSURAN PERBULAN</th>
        <th align="center">SALDO TOTAL PINJAMAN</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $pokok = $jml_angs*$tenor;
      $kumulatif = $pokok-$jml_angs;
      $bulan_pinjam = $tgl_pinj;
      for($i=1;$i<=$tenor;$i++){
        $bulan_pinjam = date('Y-m-d', strtotime('+'.$i.' month', strtotime($tgl_pinj)));
      ?>
        <tr>
          <td align="center"><?=$i?></td>
          <td align="right"><?=tgl_indo($bulan_pinjam)?></td>
          <td align="right"><?=number_format($pokok,0,',','.')  ?></td>
          <td align="right"><?=number_format($jml_angs,0,',','.')?></td>
          <td align="right"><?=number_format($kumulatif,0,',','.')?></td>
        </tr>
      <?php
        $pokok = $kumulatif;
        $kumulatif = $pokok-$jml_angs;
      }
      ?>
    </tbody>
  </table>
</div>
<br>
<div class="kiri">
  <p>Mengetahui :<br>Manajer</p><br><br><br>
  <p><strong><u><?php echo $manajer; ?></u><br><!-- NIK : 123456789 --></strong></p>
</div>
<div class="kanan">
  <p>Dibuat Oleh :<br>Staff Administrasi </p><br><br><br>
  <p><strong><u>Nama</u><br>NIK : 1234567890</strong></p>
</div>
<?php
$content = ob_get_clean();
include APPPATH . 'third_party/html2pdf/html2pdf.class.php';
try{
	$html2pdf = new HTML2PDF('P', 'A4', 'en', false, 'UTF-8', array(10, 10, 10, 10));
	//$html2pdf = new Html2Pdf('P', 'A4', 'en', false, 'UTF-8', array(0, 0, 0, 0));
	$html2pdf->pdf->SetDisplayMode('fullpage');
	$html2pdf->writeHTML($content);
	$html2pdf->Output('SURAT-PERSETUJUAN-PEMBAYARAN.pdf');
}
catch(HTML2PDF_exception $e) {
   echo $e;
   exit;
}
?>