<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- STYLE TANDA TANGAN -->
<style type="text/css">
  .data_content{border-collapse: collapse;}
  .data_content th, .data_content td {
    padding: 5px 5px;
    /* border: 1px solid #051f49; */
    font-size: 12px;
  }

  div.top-left {width:300px;float:left;margin:0;padding: 0px;}
  div.kanan {width:300px;float:right;margin-left:180px;margin-top:-140px;}
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
  NO : <?php echo $kd_pinj;?><br>
  <u style="font-weight: bold; font-size: 18px;">SURAT PERMOHONAN PENGAJUAN PINJAMAN</u><br>
</p>
<div style="margin-left: 0; margin-right: 5px;">
<br><br>
<p align="justify">
  Yang bertanda tangan dibawah ini: <br>
</p>
  <table class="data_content" width="100%" style="table-layout:fixed">
    <tr>
      <td width="160">Nama</td>
      <td align="center">:</td>
      <td valign="top" width="480" style="white-space:pre-wrap;white-space:-moz-pre-wrap;white-space:-pre-wrap;white-space:-o-pre-wrap;word-wrap:break-word">
        <strong><?php echo $nm_angg;?></strong>
      </td>
    </tr>
    <tr>
      <td width="160">Tempat/Tanggal Lahir</td>
      <td align="center">:</td>
      <td valign="top" width="480" style="white-space:pre-wrap;white-space:-moz-pre-wrap;white-space:-pre-wrap;white-space:-o-pre-wrap;word-wrap:break-word">
        <?php echo $tmpt_lahir.', '. tanggal_indo($tgl_lahir); ?>
      </td>
    </tr>
    <tr>
      <td width="160">Kelamin</td>
      <td align="center">:</td>
      <td valign="top" width="480" style="white-space:pre-wrap;white-space:-moz-pre-wrap;white-space:-pre-wrap;white-space:-o-pre-wrap;word-wrap:break-word">
        <?php if ($kelamin=='L'): ?>
          Laki-Laki
        <?php else: ?>
          Perempuan
        <?php endif ?>
      </td>
    </tr>
    <tr>
      <td width="160">Alamat</td>
      <td align="center">:</td>
      <td valign="top" width="480" style="white-space:pre-wrap;white-space:-moz-pre-wrap;white-space:-pre-wrap;white-space:-o-pre-wrap;word-wrap:break-word">
        <?php echo $alamat;?>
      </td>
    </tr>
    <tr>
      <td width="160">No. HP/Telepon</td>
      <td align="center">:</td>
      <td valign="top" width="480" style="white-space:pre-wrap;white-space:-moz-pre-wrap;white-space:-pre-wrap;white-space:-o-pre-wrap;word-wrap:break-word">
        <?php echo $telp;?>
      </td>
    </tr>
    <tr>
      <td width="160">Mengajukan Permohonan Pinjaman Dana Sebesar</td>
      <td align="center">:</td>
      <td valign="top" width="480" style="white-space:pre-wrap;white-space:-moz-pre-wrap;white-space:-pre-wrap;white-space:-o-pre-wrap;word-wrap:break-word">
        <strong><?php echo number_format($jml_pinj,0,',','.');?></strong><br><br>
        <i style="text-transform: capitalize;"><?php echo terbilang($jml_pinj);?> Rupiah</i>
      </td>
    </tr>
    <tr>
      <td width="160">Jangka waktu pelunasan</td>
      <td align="center">:</td>
      <td valign="top" width="480" style="white-space:pre-wrap;white-space:-moz-pre-wrap;white-space:-pre-wrap;white-space:-o-pre-wrap;word-wrap:break-word">
        <strong><?php echo $tenor;?> Bulan</strong>
      </td>
    </tr>
    <tr>
      <td width="160">Untuk Keperluan </td>
      <td align="center">:</td>
      <td valign="top" width="480" style="white-space:pre-wrap;white-space:-moz-pre-wrap;white-space:-pre-wrap;white-space:-o-pre-wrap;word-wrap:break-word">
        <?php echo $ket_pinj;?>
      </td>
    </tr>
  </table>
  <p></p>
  <table width="100%" style="table-layout:fixed">
    <tr>
      <td valign="top" align="justify" width="100%" style="white-space:pre-wrap;white-space:-moz-pre-wrap;white-space:-pre-wrap;white-space:-o-pre-wrap;word-wrap:break-word">
        Saya bersedia melunasi pinjaman dengan melakukan pembayaran angsuran setiap bulan sesuai jangka waktu pelunasan. Saya tidak keberatan pembayaran ini dilakukan melalui bagian keuangan dengan memotong langsung gaji/honor yang saya terima setiap bulan.
      </td>
    </tr>
    <tr>
      <td>
        <ul style="list-style-type:none;">
          <li>** 6% dari pinjaman berupa voucher belanja di KopKar Unindra</li>
          <li>** Harap melampirkan fotocopy buku tabungan yang masih aktif/berlaku.</li>
        </ul>    
      </td>
    </tr>
  </table>
  <div class="kiri">
    <p>Jakarta, <?php echo tanggal_indo($tgl_pinj); ?></p>
    <p>Pemohon <br></p><br><br>
    <p><strong><u><?php echo $nm_angg;?></u><br></strong></p>
  </div>
  <div class="kanan">
    <p>Mengetahui dan Menyetujui <br>Pejabat/Atasan </p><br><br><br>
    <p><strong><u><?php echo $ka_koperasi ?></u><br><!-- NIK : 1234567890 --></strong></p>
  </div>
</div>

<?php
$content = ob_get_clean();
include APPPATH . 'third_party/html2pdf/html2pdf.class.php';
try{
	$html2pdf = new HTML2PDF('P', 'A4', 'en', false, 'UTF-8', array(10, 10, 10, 10));
	//$html2pdf = new Html2Pdf('P', 'A4', 'en', false, 'UTF-8', array(0, 0, 0, 0));
	$html2pdf->pdf->SetDisplayMode('fullpage');
	$html2pdf->writeHTML($content);
	$html2pdf->Output('surat_permohonan_pengajuan_pinjaman.pdf');
}
catch(HTML2PDF_exception $e) {
   echo $e;
   exit;
}
?>