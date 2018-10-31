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
                    <label>Pembeli</label><span></span><br>
                    <label>&nbsp;</label><span></span><br>
                    <label>&nbsp;</label><span></span>
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
            
            <table class="table-nota" cellspacing="0">
                <thead>
                    <tr>
                        <th width="3%">No.</th>
                        <th>Jasa / Sparepart</th>
                        <th>Merk / Brand</th>
                        <th>Kuantitas</th>
                        <th>Harga Satuan (Rp)</th>
                        <th>Sub Total (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td align="right">1.</td>
                        <td>Jasa Penanganan (Services)</td>
                        <td>-</td>
                        <td align="right">1</td>
                        <td align="right"><?php //echo indo_curs($obj->service_prices) ?>,00</td>
                        <td align="right"><?php //echo indo_curs($obj->service_prices) ?>,00</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" align="right"><b>Total Biaya</b></td>
                        <td align="right"><b><?php //echo indo_curs($totals) ?>,00</b></td>
                    </tr>
                </tfoot>
            </table>
            
            <div class="single-line"></div>
            <div class="bold-line"></div>
            <br />
            <table>
                <tr>
                    <td align="center">
                        Penerima,<br />
                        <p>
                            <u><b><?php //echo //contact_id()[$obj->title_id].' '. $obj->name ?></b></u>
                        </p>
                    </td>
                    <td width="70%">&nbsp;</td>
                    <td align="center">
                        Hormat Kami,<br />
                        <p>
                            <u><b><i>Customer Services</i></b></u>
                        </p>
                    </td>
                </tr>
            </table>
        </div>
</body>
</html>