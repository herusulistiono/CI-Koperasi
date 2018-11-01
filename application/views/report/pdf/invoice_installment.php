<style type="text/css">
    body, table {
    font-size: 14px;
    color: #003366;
}

body {
    margin: 0 auto;
    width: 100%;
}

h1, h2, h3, h4, h5, h6 {
    padding: 0;
    margin: 0;
    font-weight: normal;
}

#container {
    display: block;
    min-height: 100%;
    padding: 20px;
}

img.logo {
    float: right;
    margin: 0 25px 20x 0;
}

br, hr {clear: both}

table.table-data, table.table-info {
    margin: 20px 0 30px 0;
    border-top: 1px solid #555555;
    border-left: 1px solid #555555;
}

table.table-data th {font-weight: bold}

table.table-data th, table.table-data td {
    border-right: 1px solid #555555;
    border-bottom: 1px solid #555555;
    padding: 5px;
}

table.table-info { border: none; }
table.table-info caption { 
    padding: 5px 0 5px 0;
    border-bottom: 1px solid #cacaca; 
    text-align: left;
}
table.table-info th, table.table-info td {
    border: none;
    border-bottom: 1px dashed #cacaca;
    padding: 5px 0 5px 0;
}

img.imgpp {
    z-index: 10;
    position: absolute;
    right: 1%;
    width: 100px;
    height: 100px;
    margin-top: 50px;
    border: 2px solid #999999;
    padding: 2px;
}

.nota-container {
    width: 700px;
    border: 1px solid #006699;
    margin: 10px;
    padding: 10px;
    min-height: 500px;
}

.nota-container img.logo {
    float: left;
    margin: 0 0 0 0;
}

.comp-profile {
    float: left;
    margin-left: 10px;
    margin-right: 5px;
    width: 55%;
    font-size: 11px;
    /* border: 2px solid #003366; */
}

.comp-profile h2 {
    font-size: 32px;
    font-weight: bold;
    letter-spacing: 5px;
    color: #003366;
    text-transform: uppercase;
}

.right-box {
    float: right;
    width: 200px;
    font-size: 11px;
    /* border: 2px solid #003366; */
}

.right-box label, .right-box span {
    width: 50px;
    float: left;
    color: #000000;
    font-weight: bold;
    margin: 0 3px 3px 0;
}

.right-box span {
    width: 143px;
    font-weight: normal;
    border-bottom: 1px solid #000000;
}

.bold-line, .single-line {
    clear: both;
    width: 100%;
    display: block;
    margin: 2px 0 2px 0;
    border-bottom: 3px solid #003366;
}

.single-line {
    margin: 0;
    border-bottom: 1px solid #003366;
}

table.table-nota {
    font-size: 12px;
    border-top: 1px solid #006699;
    border-left: 1px solid #006699;
    margin: 5px 0 5px 0;
}

table.table-nota tr th, table.table-nota tr td {
    border-right: 1px solid #006699;
    border-bottom: 1px solid #006699;
    padding: 5px;
}

table.table-nota tr th {
    background: #0088cc;
    color: #ffffff;
}
</style>
<div class="nota-container">
        <div>
            <img src="assets/img/logo.png" class="logo" width="90px"/>
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
<?php
$content = ob_get_clean();
include APPPATH . 'third_party/html2pdf/html2pdf.class.php';
try{
   $html2pdf = new HTML2PDF('P', 'A4', 'en', false, 'UTF-8', array(10, 10, 4, 10));
   //$html2pdf = new Html2Pdf('P', 'A4', 'en', false, 'UTF-8', array(0, 0, 0, 0));
   $html2pdf->pdf->SetDisplayMode('fullpage');
   $html2pdf->writeHTML($content);
   $html2pdf->Output('pembayaran-angsuran.pdf');
}
catch(HTML2PDF_exception $e) {
   echo $e;
   exit;
}
?>