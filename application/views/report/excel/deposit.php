<?php
$save_filename = "data_simpanan.xls";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=".$save_filename);
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
header("Pragma: public");

$workbook = new Workbook();
$worksheet1 =& $workbook->add_worksheet('DATA SIMPANAN');

$top =& $workbook->add_format();
$top->set_size(14);
$top->set_bold();
$top->set_align("center");
$top->set_top(0);
$top->set_bottom(0);
$top->set_left(0);
$top->set_right(0);

//$worksheet1->set_column(1, 1, 5);
for ($i = 1; $i < 7; $i++) {
    $worksheet1->set_column(1, $i, 15);
}
$worksheet1->set_column(1, 7, 20);
$worksheet1->merge_cells(1, 0, 1, 7);
$worksheet1->write_string(1, 0, "LAPORAN SIMPANAN", $top);

$worksheet1->set_column(2, 7, 20);
$worksheet1->merge_cells(2, 0, 2, 7);
$worksheet1->write_string(2, 0, "PERIODE : " .$periode, $top);
for ($i = 1; $i < 7; $i++) {
    $worksheet1->write_blank(2, $i, $top);
}

$header =& $workbook->add_format();
//$header->set_color('blue');
$header->set_border_color('black');
$header->set_size(12);
$header->set_align("center");
$header->set_bold();
$header->set_top(2);
$header->set_bottom(2);
$header->set_left(2);
$header->set_right(2);

//set baris ke 4 di excel
$worksheet1->write_string(4,0,'Kode',$header);
$worksheet1->set_column(4,0,9);

$worksheet1->write_string(4,1,'Tanggal',$header);
$worksheet1->set_column(4,1,20);

$worksheet1->write_string(4,2,'Nama Anggota',$header);
$worksheet1->set_column(4,2,20);

$worksheet1->write_string(4,3,'Pokok',$header);
$worksheet1->set_column(4,3,10);

$worksheet1->write_string(4,4,'Wajib',$header);
$worksheet1->set_column(4,4,10);

$worksheet1->write_string(4,5,'Sukarela',$header);
$worksheet1->set_column(4,5,10);

$worksheet1->write_string(4,6,'Total',$header);
$worksheet1->set_column(4,6,10);

$content =& $workbook->add_format();
$content->set_size(11);
$content->set_top(2);
$content->set_bottom(2);
$content->set_left(2);
$content->set_right(2); 
$row = 5; //set baris ke 5 di excel
foreach ($result as $rows) {
    $worksheet1->write_string($row,0, $rows->kd_simp,$content);
    $worksheet1->write_string($row,1, tanggal_indo($rows->tgl_simp),$content);
    $worksheet1->write_string($row,2, $rows->kd_angg.' - '.$rows->nm_angg,$content);
    $worksheet1->write_string($row,3, $rows->pokok,$content);
    $worksheet1->write_string($row,4, $rows->wajib,$content);
    $worksheet1->write_string($row,5, $rows->sukarela,$content);
    $worksheet1->write_string($row,6, $rows->total_wajib+$rows->total_pokok+$rows->total_sukarela,$content);
    $row++;
}
$workbook->close();