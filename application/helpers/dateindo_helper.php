<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function tanggal_indo($tanggal) {
	$bulan = array(1=>'Januari', 
					  'Februari',
					  'Maret',
					  'April',
					  'Mei',
					  'Juni',
					  'Juli',
					  'Agustus',
					  'September',
					  'Oktober',
					  'November',
					  'Desember');
	$split = explode('-', $tanggal);
	$tanggal_indo = $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];
	return $tanggal_indo;
}
function tgl_indo($tanggal){
	$bulan = array (
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	$split = explode('-', $tanggal);
	// variabel pecahkan 0 = tahun
	// variabel pecahkan 1 = bulan
	// variabel pecahkan 2 = tanggal
	return $bulan[(int)$split[1]] . ' ' . $split[0];
}
/* End of file indotgl_helper.php */
/* Location: ./application/helpers/indotgl_helper.php */