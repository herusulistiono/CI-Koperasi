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
                <img src="<?php echo base_url('assets/img/logo.png') ?>" class="logo" width="90px"/>
                <div class="right-box">
                    <label>Tanggal</label><span></span><br>
                    <label>No</label><span><?php echo $no_kwitansi; ?></span><br>
                    <!--<label>&nbsp;</label><span></span><br>
                    <label>&nbsp;</label><span></span> -->
                </div>
            </div>
            <div class="comp-profile">
                <h2>KOPKAR UNINDRA</h2>
                <div class="company-address">
                    Jl. Nangka No. 58C Tanjung Barat, Jagakarsa, Jakarta Selatan <br>
		            JL. Raya Tengah, Kelurahan Gedong, Pasar Rebo, Jakarta Timur
		            <br/><b>Telp.</b> 021 - 333866055, 3386608
		            <br/><b>Email.</b> kopkar.unindra@gmail.com
                </div>
            </div>
            <br><br>
            <div class="bold-line"></div>
            <div class="single-line"></div>
            <table>
                <tr>
                    <td align="center">
                       <input type="checkbox"/> TUNAI
                    </td>
                    <td>&nbsp;</td>
                    <td align="center">
                       <input type="checkbox"/> CHEQUE No.
                    </td>
                </tr>
                <tr>
                    <td align="center">
                       <h2>RP. <?php echo number_format($jml_bayar,0,',','.') ?></h2>
                    </td>
                    <td>&nbsp;</td>
                    <td align="center">
                       Terbilang
                    </td>
                </tr>
                <tr>
                    <td align="center">Untuk Pembayaran</td>
                    <td>&nbsp;</td>
                    <td align="center"><?php echo strtoupper(terbilang($jml_bayar)); ?></td>
                </tr>
            </table>
            
            <br>
            <table>
                <tr>
                    <td align="center">
                        Ketua<br>
                        <p>
                            <u><b><?php //echo //contact_id()[$obj->title_id].' '. $obj->name ?></b></u>
                        </p>
                    </td>
                    <td width="70%">&nbsp;</td>
                    <td align="center">
                        Yang Menerima,<br/>
                        <p>
                            <u><b><i>()</i></b></u>
                        </p>
                    </td>
                </tr>
            </table>
        </div>
</body>
</html>