<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title><?php echo $title; ?></title>
        <link href="<?php echo base_url('assets/css/custom-print.css') ?>" rel="stylesheet" type="text/css" />
    </head>
<body>
<div class="nota-container">
	<div>
        <img src="<?php echo base_url('/assets/img/logo.png') ?>" class="logo" style="width: 98px; height:98px;"/>
        <!-- <div class="right-box">
            <label>Tanggal</label><span><?php echo date('Y-m-d') ?></span><br />
            <label>Pembeli</label><span><?php ?></span><br/>
            <label>&nbsp;</label><span><?php ?></span><br/>
            <label>&nbsp;</label><span><?php ?></span>
        </div> -->
    </div>
    <div class="comp-profile">
        <h2>KOPERASI PEGAWAI <br><u>UNIVERSITAS INDRAPRASTA PGRI</u></h2>
        <div class="company-address">
            <p>
                Kantor : Jl. Nangka No. 58C Tanjung Barat, Jagakarsa, Jakarta Selatan <br>
                Jl. Raya Tengah, Keluar Gedong, Pasar Rebo - Jakarta Timur, Jakarta Timur<br>
                Telp : 021 - 333866055, +62815 11075 850 +62815 1042 5951 +62812 1341 9198 <br> 
                Mail : kopkar.unindra@gmail.com
            </p>
        </div>
    </div>
    <br/>
    <div>
        <storng>No.</storng> <?php echo $kd_pinj; ?>
    </div>
    <div class="bold-line"></div>
    <div class="single-line"></div>
    <h2 style="text-align: center; font-weight: bold; text-align: center; text-transform: uppercase;">PINJAMAN</h2>
    <?php 
    
    ?>
    <br>
    <table cellpadding="5" cellspacing="0">
        <tr>
            <td>Telah diterima dari</td>
            <td>:</td>
            <td>
                <?php echo $nm_angg; ?>
                <div class="single-line"></div>
            </td>
        </tr>
        <tr>
            <td>Uang Sejumlah</td>
            <td>:</td>
            <td style="text-transform: capitalize;">
                <?php  $angka=$jml_pinj; echo terbilang($angka);?> Rupiah
                <div class="single-line"></div>
            </td>
        </tr>
        <tr>
            <td>Untuk Keperluan</td>
            <td>:</td>
            <td style="text-transform: capitalize;">
                <?php 
                echo $ket_pinj .' dengan tenor <strong>'. $tenor.'('.terbilang($tenor) .')'.'</strong> Bulan';?>
                <div class="single-line"></div>
            </td>
        </tr>
    </table>
    <div>
        <div class="left-box">
            <label>Rp. </label><span> <?php echo number_format($jml_pinj,2,',','.'); ?></span>
        </div>
        <div class="right-box">
            <label>Jakarta, </label><span> <?php echo tanggal_indo(date('Y-m-d'));  ?></span>
            <br><br><br><br><br><br><br>
            <span>Ir. Pavel Nedved</span>
        </div>
    </div>
</div>
</body>
</html>