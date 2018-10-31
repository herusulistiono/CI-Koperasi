<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// Load library phpspreadsheet
require('./excel/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
// End load library phpspreadsheet

class Report extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('report_m','deposit_m','loan_m'));
	}
	public function index()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login', 'refresh');
		}else{
			$this->data['title']='MENU LAPORAN';
			$this->backend->display('report/index',$this->data);
		}
	}
	//DEPOSIT FORM
	public function deposit()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login', 'refresh');
		}else{
			$this->data['title']='LAPORAN SIMPANAN';
			$this->data['members'] = $this->deposit_m->get_member()->result();
			$this->backend->display('report/index_deposit',$this->data);
		}
	}
	public function json_deposit_members()
	{
        $kd_angg  = $this->input->post('kd_angg');
		$first_date = date('Y-m-d',strtotime($this->input->post('first_date')));
		$last_date  = date('Y-m-d',strtotime($this->input->post('last_date')));
        $savings=$this->report_m->deposit_member($kd_angg,$first_date,$last_date)->result();
        $data=array();
		$no=(int)1;
		foreach ($savings as $rows) {
			$total_simpanan = ($rows->pokok)+($rows->wajib)+($rows->sukarela);
			array_push($data, 
				array(
					$no++,
					$rows->kd_simp,
					tanggal_indo($rows->tgl_simp),
					$rows->kd_angg.'-'.$rows->nm_angg,
					number_format($rows->pokok,0,',',','),
					number_format($rows->wajib,0,',',','),
					number_format($rows->sukarela,0,',',','),
					number_format($total_simpanan,0,',',',')
				)
			);
		}
		echo json_encode(array('data'=>$data));
	}
	public function json_deposit_date()
	{
		$first_date = date('Y-m-d',strtotime($this->input->post('f_date')));
		$last_date  = date('Y-m-d',strtotime($this->input->post('l_date')));
		$savings=$this->report_m->deposit_date($first_date,$last_date)->result();
		$data=array();
		$no=(int)1;
		foreach ($savings as $rows) {
			$amount = ($rows->wajib)+($rows->pokok)+($rows->sukarela);
			array_push($data, 
				array(
					$no++,
					$rows->kd_simp,
					tanggal_indo($rows->tgl_simp),
					$rows->kd_angg.'-'.$rows->nm_angg,
					number_format($rows->pokok,0,',',','),
					number_format($rows->wajib,0,',',','),
					number_format($rows->sukarela,0,',',','),
					number_format($amount,0,',',',')
				)
			);
		}
		echo json_encode(array('data'=>$data));
	}
	public function export_deposit_members()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login', 'refresh');
		}else{
			if (isset($_POST['pdf'])) {
				$member_id  = $this->input->post('kd_angg');
				$first_date = date('Y-m-d',strtotime($this->input->post('first_date')));
				$last_date  = date('Y-m-d',strtotime($this->input->post('last_date')));
				$this->data['result']=$this->report_m->deposit_member($member_id,$first_date,$last_date)->result();
				$this->data['periode']= tanggal_indo($first_date) .' s/d '. tanggal_indo($last_date);
				$this->load->view('report/pdf/deposit',$this->data);
			} else if(isset($_POST['xls'])){
				$member_id  = $this->input->post('kd_angg');
				$first_date = date('Y-m-d',strtotime($this->input->post('first_date')));
				$last_date  = date('Y-m-d',strtotime($this->input->post('last_date')));
				$result=$this->report_m->deposit_member($member_id,$first_date,$last_date)->result();
				$periode= tanggal_indo($first_date) .' s/d '. tanggal_indo($last_date);
				$spreadsheet = new Spreadsheet();
				// Set document properties
				$spreadsheet->getProperties()->setCreator('Heru - herusulistiono.net')
				->setLastModifiedBy('Heru - herusulistiono.net')
				->setTitle('Koperasi Karyawan dan Dosen UNINDRA')
				->setSubject('Koperasi Karyawan dan Dosen UNINDRA')
				->setDescription('Koperasi Karyawan dan Dosen UNINDRA')
				->setKeywords('Koperasi Karyawan dan Dosen UNINDRA')
				->setCategory('DATA SIMPANAN');
				// Add some data
				$spreadsheet->setActiveSheetIndex(0)
				    ->setCellValue('A8', 'NO')
				    ->setCellValue('B8', 'KODE')
				    ->setCellValue('C8', 'TANGGAL')
				    ->setCellValue('D8', 'ANGGOTA')
				    ->setCellValue('E8', 'POKOK')
				    ->setCellValue('F8', 'WAJIB')
				    ->setCellValue('G8', 'SUKARELA')
				    ->setCellValue('H8', 'TOTAL');

				// Miscellaneous glyphs, UTF-8
				$i=(int)9;
				$no=(int)1;
				foreach ($result as $rows) {
				    $spreadsheet->setActiveSheetIndex(0)
				        ->setCellValue('A'.$i, $no++)
				        ->setCellValue('B'.$i, $rows->kd_simp)
				        ->setCellValue('C'.$i, tanggal_indo($rows->tgl_simp))
				        ->setCellValue('D'.$i, $rows->kd_angg.' - '.$rows->nm_angg)
				        ->setCellValue('E'.$i, $rows->pokok)
				        ->setCellValue('F'.$i, $rows->wajib)
				        ->setCellValue('G'.$i, $rows->sukarela)
				        ->setCellValue('H'.$i, $rows->wajib+$rows->pokok+$rows->sukarela);
				    $i++;
				}

				// Rename worksheet
				$spreadsheet->getActiveSheet()->setTitle('DATA SIMPANAN ANGGOTA');
				// Set active sheet index to the first sheet, so Excel opens this as the first sheet
				$spreadsheet->setActiveSheetIndex(0);
				$save_filename = "simpanan_peranggota.xlsx";
				// Redirect output to a client’s web browser (Xlsx)
				header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				header('Content-Disposition: attachment;filename="'.$save_filename.'"');
				header('Cache-Control: max-age=0');
				// If you're serving to IE 9, then the following may be needed
				header('Cache-Control: max-age=1');

				// If you're serving to IE over SSL, then the following may be needed
				//header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
				header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
				header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
				header('Pragma: public'); // HTTP/1.0

				$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
				$writer->save('php://output');
				exit;
			}
			
		}
	}
	public function export_deposit_date()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login', 'refresh');
		}else{
			if (isset($_POST['pdf'])) {
				$first_date = date('Y-m-d',strtotime($this->input->post('f_date')));
				$last_date  = date('Y-m-d',strtotime($this->input->post('l_date')));
				$this->data['result']=$this->report_m->deposit_date($first_date,$last_date)->result();
				$this->data['periode']= tanggal_indo($first_date) .' s/d '. tanggal_indo($last_date);
				$this->load->view('report/pdf/deposit',$this->data);
			} else  {
				$first_date = date('Y-m-d',strtotime($this->input->post('f_date')));
				$last_date  = date('Y-m-d',strtotime($this->input->post('l_date')));
				$result=$this->report_m->deposit_date($first_date,$last_date)->result();
				$periode= tanggal_indo($first_date) .' s/d '. tanggal_indo($last_date);
				$spreadsheet = new Spreadsheet();
				// Set document properties
				$spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
				$spreadsheet->getDefaultStyle()->getFont()->setSize(11);
				$spreadsheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(12);
				$spreadsheet->getActiveSheet()->getDefaultRowDimension()->setRowHeight(14);
				$spreadsheet->getProperties()->setCreator('Heru - herusulistiono.net')
				->setLastModifiedBy('Heru - herusulistiono.net')
				->setTitle('Koperasi Karyawan dan Dosen UNINDRA')
				->setSubject('Koperasi Karyawan dan Dosen UNINDRA')
				->setDescription('Koperasi Karyawan dan Dosen UNINDRA')
				->setKeywords('Koperasi Karyawan dan Dosen UNINDRA')
				->setCategory('DATA SIMPANAN');
				// Add some data
				$top = [
				    'font' => [
				        'bold' => true,
				        'size'=>14,
				    ],
				    'alignment' => [
				        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				    ]
				];
				$spreadsheet->getActiveSheet()->getStyle('A1:A6')->applyFromArray($top);
				//$sheet->getStyle($column.$style)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$th_cell = [
				    'font' => [
				        'bold' => true,
				        'size'=>11,
				    ],
				    'alignment' => [
				        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
				    ],
				    'borders' => [
				        'allBorders' => [
				            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
				        ],
				    ],
				    'fill' => [
				        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
				        'rotation' => 90,
				        'startColor' => [
				            'argb' => 'FFA0A0A0',
				        ],
				        'endColor' => [
				            'argb' => 'FFFFFFFF',
				        ],
				    ],
				];
				$spreadsheet->getActiveSheet()->getStyle('A6:H7')->applyFromArray($th_cell);
				$td_cell = [
				    'borders' => [
				        'allBorders' => [
				            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
				        ],
				    ]
				];
				$spreadsheet->getActiveSheet()->getStyle('A6:H1000')->applyFromArray($td_cell);
				$spreadsheet->getActiveSheet()
					->mergeCells('A1:H1')
					->setCellValue('A1','KOPKAR UNINDRA');
				$spreadsheet->getActiveSheet()
					->mergeCells('A2:H2')
					->setCellValue('A2','SIMPANAN ANGGOTA KOPERASI');
				$spreadsheet->getActiveSheet()
					->mergeCells('A4:H4')
					->setCellValue('A4','PERIODE - '.$periode);
				$spreadsheet->setActiveSheetIndex(0)
				    ->mergeCells('A6:A7')->setCellValue('A6', 'NO')
				    ->mergeCells('B6:B7')->setCellValue('B6', 'KODE')
				    ->mergeCells('C6:C7')->setCellValue('C6', 'TANGGAL')
				    ->mergeCells('D6:D7')->setCellValue('D6', 'ANGGOTA')
				    ->mergeCells('E6:G6')->setCellValue('E6', 'SIMPANAN')
				    ->setCellValue('E7', 'POKOK')
				    ->setCellValue('F7', 'WAJIB')
				    ->setCellValue('G7', 'SUKARELA')
				    ->mergeCells('H6:H7')->setCellValue('H6', 'TOTAL');

				// Miscellaneous glyphs, UTF-8
				$i=(int)8;
				$no=(int)1;
				foreach ($result as $rows) {
				    $spreadsheet->setActiveSheetIndex(0)
				        ->setCellValue('A'.$i,$no++)
				        ->setCellValue('B'.$i,$rows->kd_simp)
				        ->setCellValue('C'.$i,tanggal_indo($rows->tgl_simp))
				        ->setCellValue('D'.$i,$rows->kd_angg.' - '.$rows->nm_angg)
				        ->setCellValue('E'.$i,$rows->pokok)
				        ->setCellValue('F'.$i,$rows->wajib)
				        ->setCellValue('G'.$i,$rows->sukarela)
				        ->setCellValue('H'.$i,$rows->wajib+$rows->pokok+$rows->sukarela);
				    $i++;
				}

				// Rename worksheet
				$spreadsheet->getActiveSheet()->setTitle('DATA SIMPANAN -'.date('d-m-Y'));
				// Set active sheet index to the first sheet, so Excel opens this as the first sheet
				$spreadsheet->setActiveSheetIndex(0);
				$save_filename = "data_simpanan.xlsx";
				// Redirect output to a client’s web browser (Xlsx)
				header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				header('Content-Disposition: attachment;filename="'.$save_filename.'"');
				header('Cache-Control: max-age=0');
				// If you're serving to IE 9, then the following may be needed
				header('Cache-Control: max-age=1');

				// If you're serving to IE over SSL, then the following may be needed
				//header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
				header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
				header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
				header('Pragma: public'); // HTTP/1.0

				$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
				$writer->save('php://output');
				exit;
			}
			
		}
	}
	//LOAN FORM
	public function loan()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login', 'refresh');
		}else{
			$this->data['title']='LAPORAN PINJAMAN';
			$this->data['members'] = $this->loan_m->get_member()->result();
			$this->backend->display('report/index_loan',$this->data);
		}
	}
	public function json_loan_members()
	{
		$kd_angg  = $this->input->post('kd_angg');
		$first_date = date('Y-m-d',strtotime($this->input->post('first_date')));
		$last_date  = date('Y-m-d',strtotime($this->input->post('last_date')));
        $loan=$this->report_m->loan_member($kd_angg,$first_date,$last_date)->result();
        $data=array();
		$no=(int)1;
		if(count($loan>0)){
			foreach ($loan as $rows) {
				array_push($data, 
					array(
						$no++,
						$rows->kd_pinj,
						tanggal_indo($rows->tgl_pinj),
						$rows->kd_angg.' - '.$rows->nm_angg,
						$rows->tenor,
						number_format($rows->jml_angs,0,',',','),
						number_format($rows->total_pinjaman,0,',',',')
					)
				);
			}
			echo json_encode(array('data'=>$data));
		}
	}
	public function json_loan_date()
	{
		$first_date = date('Y-m-d',strtotime($this->input->post('f_date')));
		$last_date  = date('Y-m-d',strtotime($this->input->post('l_date')));
        $loan=$this->report_m->loan_date($first_date,$last_date)->result();
        $data=array();
		$no=(int)1;
		foreach ($loan as $rows) {
			array_push($data, 
				array(
					$no++,
					$rows->kd_pinj,
					tanggal_indo($rows->tgl_pinj),
					$rows->kd_angg.' - '.$rows->nm_angg,
					$rows->tenor,
					number_format($rows->jml_angs,0,',',','),
					number_format($rows->total_pinjaman,0,',',',')
				)
			);
		}
		echo json_encode(array('data'=>$data));
	}
	public function export_loan_members()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login', 'refresh');
		}else{
			if (isset($_POST['pdf'])) {
				$member_id  = $this->input->post('kd_angg');
				$first_date = date('Y-m-d',strtotime($this->input->post('first_date')));
				$last_date  = date('Y-m-d',strtotime($this->input->post('last_date')));
				$this->data['result']=$this->report_m->loan_member($member_id,$first_date,$last_date)->result();
				$this->data['periode']= tanggal_indo($first_date) .' s/d '. tanggal_indo($last_date);
				$this->load->view('report/pdf/loan',$this->data);
			} else if(isset($_POST['xls'])){
				$member_id  = $this->input->post('kd_angg');
				$first_date = date('Y-m-d',strtotime($this->input->post('first_date')));
				$last_date  = date('Y-m-d',strtotime($this->input->post('last_date')));
				$result=$this->report_m->loan_member($member_id,$first_date,$last_date)->result();
				$periode= tanggal_indo($first_date) .' s/d '. tanggal_indo($last_date);

				$spreadsheet = new Spreadsheet();
				// Set document properties
				$spreadsheet->getProperties()->setCreator('Heru - herusulistiono.net')
				->setLastModifiedBy('Heru - herusulistiono.net')
				->setTitle('Koperasi Karyawan dan Dosen UNINDRA')
				->setSubject('Koperasi Karyawan dan Dosen UNINDRA')
				->setDescription('Koperasi Karyawan dan Dosen UNINDRA')
				->setKeywords('Koperasi Karyawan dan Dosen UNINDRA')
				->setCategory('DATA PINJAMAN');
				// Add some data
				$spreadsheet->setActiveSheetIndex(0)
				    ->setCellValue('A8', 'NO')
				    ->setCellValue('B8', 'KODE')
				    ->setCellValue('C8', 'TANGGAL')
				    ->setCellValue('D8', 'ANGGOTA')
				    ->setCellValue('E8', 'TENOR')
				    ->setCellValue('F8', 'ANGSURAN')
				    ->setCellValue('G8', 'JUMLAH');
				// Miscellaneous glyphs, UTF-8
				$i=(int)9;
				$no=(int)1;
				foreach ($result as $rows) {
				    $spreadsheet->setActiveSheetIndex(0)
				        ->setCellValue('A'.$i,$no++)
				        ->setCellValue('B'.$i,$rows->kd_pinj)
				        ->setCellValue('C'.$i,tanggal_indo($rows->tgl_pinj))
				        ->setCellValue('D'.$i,$rows->kd_angg.' - '.$rows->nm_angg)
				        ->setCellValue('E'.$i,$rows->tenor)
				        ->setCellValue('F'.$i,$rows->jml_angs)
				        ->setCellValue('G'.$i,$rows->total_pinjaman);
				    $i++;
				}
				// Rename worksheet
				$spreadsheet->getActiveSheet()->setTitle('DATA PINJAMAN-'.date('d-m-Y H'));
				// Set active sheet index to the first sheet, so Excel opens this as the first sheet
				$spreadsheet->setActiveSheetIndex(0);
				$save_filename = "data_pinjaman.xlsx";
				// Redirect output to a client’s web browser (Xlsx)
				header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				header('Content-Disposition: attachment;filename="'.$save_filename.'"');
				header('Cache-Control: max-age=0');
				// If you're serving to IE 9, then the following may be needed
				header('Cache-Control: max-age=1');

				// If you're serving to IE over SSL, then the following may be needed
				//header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
				header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
				header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
				header('Pragma: public'); // HTTP/1.0

				$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
				$writer->save('php://output');
				exit;
			}
			
		}
	}
	public function export_loan_date()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login', 'refresh');
		}else{
			if (isset($_POST['pdf'])) {
				$first_date = date('Y-m-d',strtotime($this->input->post('f_date')));
				$last_date  = date('Y-m-d',strtotime($this->input->post('l_date')));
				$this->data['result']=$this->report_m->loan_date($first_date,$last_date)->result();
				$this->data['periode']= tanggal_indo($first_date) .' s/d '. tanggal_indo($last_date);
				$this->load->view('report/pdf/loan',$this->data);
			} else if(isset($_POST['xls'])) {
				$first_date = date('Y-m-d',strtotime($this->input->post('f_date')));
				$last_date  = date('Y-m-d',strtotime($this->input->post('l_date')));
				$result=$this->report_m->loan_date($first_date,$last_date)->result();
				$periode= tanggal_indo($first_date) .' s/d '. tanggal_indo($last_date);
				$spreadsheet = new Spreadsheet();
				// Set document properties
				$spreadsheet->getProperties()->setCreator('Heru - herusulistiono.net')
				->setLastModifiedBy('Heru - herusulistiono.net')
				->setTitle('Koperasi Karyawan dan Dosen UNINDRA')
				->setSubject('Koperasi Karyawan dan Dosen UNINDRA')
				->setDescription('Koperasi Karyawan dan Dosen UNINDRA')
				->setKeywords('Koperasi Karyawan dan Dosen UNINDRA')
				->setCategory('DATA PINJAMAN');
				// Add some data

				$spreadsheet->setActiveSheetIndex(0)
				    ->setCellValue('A8', 'NO')
				    ->setCellValue('B8', 'KODE')
				    ->setCellValue('C8', 'TANGGAL')
				    ->setCellValue('D8', 'ANGGOTA')
				    ->setCellValue('E8', 'TENOR')
				    ->setCellValue('F8', 'ANGSURAN')
				    ->setCellValue('G8', 'JUMLAH');
				// Miscellaneous glyphs, UTF-8
				$i=(int)9;
				$no=(int)1;
				foreach ($result as $rows) {
				    $spreadsheet->setActiveSheetIndex(0)
				        ->setCellValue('A'.$i,$no++)
				        ->setCellValue('B'.$i,$rows->kd_pinj)
				        ->setCellValue('C'.$i,tanggal_indo($rows->tgl_pinj))
				        ->setCellValue('D'.$i,$rows->kd_angg.' - '.$rows->nm_angg)
				        ->setCellValue('E'.$i,$rows->tenor)
				        ->setCellValue('F'.$i,$rows->jml_angs)
				        ->setCellValue('G'.$i,$rows->total_pinjaman);
				    $i++;
				}
				// Rename worksheet
				$spreadsheet->getActiveSheet()->setTitle('DATA PINJAMAN-'.date('d-m-Y H'));
				// Set active sheet index to the first sheet, so Excel opens this as the first sheet
				$spreadsheet->setActiveSheetIndex(0);
				$save_filename = "data_pinjaman.xlsx";
				// Redirect output to a client’s web browser (Xlsx)
				header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				header('Content-Disposition: attachment;filename="'.$save_filename.'"');
				header('Cache-Control: max-age=0');
				// If you're serving to IE 9, then the following may be needed
				header('Cache-Control: max-age=1');

				// If you're serving to IE over SSL, then the following may be needed
				//header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
				header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
				header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
				header('Pragma: public'); // HTTP/1.0

				$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
				$writer->save('php://output');
				exit;
			}else{
				redirect('report/loan','refresh');
			}
			
		}
	}
	//INSTALLMENT FORM
	public function installment()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login', 'refresh');
		}else{
			$this->data['title']='LAPORAN ANGSURAN';
			$this->data['members'] = $this->loan_m->get_member()->result();
			$this->backend->display('report/index_installment',$this->data);
		}
	}
	public function report_installment()
	{
		$first_date = date('Y-m-d',strtotime($this->input->post('f_date')));
		$last_date  = date('Y-m-d',strtotime($this->input->post('l_date')));
        $installment=$this->report_m->installment($first_date,$last_date)->result();
        $data=array();
		$no=(int)1;
		foreach ($installment as $rows) {
			array_push($data, 
				array(
					$no++,
					$rows->no_kwitansi.' - '.$rows->kd_pinj,
					tanggal_indo($rows->tgl_bayar),
					$rows->kd_angg.' - '.$rows->nm_angg,
					number_format($rows->jml_pinj,0,',',','),
					$rows->angs_ke,
					number_format($rows->jml_bayar,0,',',','),
					$rows->status
				)
			);
		}
		echo json_encode(array('data'=>$data));
	}
	public function export_installment()
	{
		if (!$this->ion_auth->logged_in()){

		}else{

		}
	}
	public function invoice_installment()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login', 'refresh');
		}else{
			if (isset($_POST['pdf'])) {
				$first_date = date('Y-m-d',strtotime($this->input->post('f_date')));
				$last_date  = date('Y-m-d',strtotime($this->input->post('l_date')));
				$this->data['periode']= tanggal_indo($first_date) .' s/d '. tanggal_indo($last_date);
				$this->data['result']=$this->report_m->installment($first_date,$last_date)->result();
				$invoice=$this->report_m->installment($first_date,$last_date)->row();
				$this->data['no_kwitansi']=$invoice->no_kwitansi;
				$this->data['kd_pinj']=$invoice->kd_pinj;
				$this->data['jml_bayar']=$invoice->jml_bayar;
				$this->load->view('report/pdf/invoice_installment',$this->data);
			} else {
				
			}
			
		}
	}
	//SISA HASIL USAHA
	public function net_income()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login', 'refresh');
		}else{
			$this->data['title']='LAPORAN SISA HASIL USAHA';
			$this->backend->display('report/index_net_income',$this->data);
		}
	}
	public function json_net_income()
	{
		$first_date = date('Y-m-d',strtotime($this->input->post('f_date')));
		$last_date  = date('Y-m-d',strtotime($this->input->post('l_date')));
        $det_simpanan=$this->report_m->net_income($first_date,$last_date)->result();
        $tot_simpanan=$this->report_m->amount_net_income($first_date,$last_date)->row();
        //$det_usaha=$this->report_m->profit($first_date,$last_date)->row();
        $amount_profit=$this->report_m->amount_profit($first_date,$last_date)->row();
        $data=array();
		$no=(int)1;
		foreach ($det_simpanan as $rows) {
			$sembako=$rows->tot_sembako;
			$btn=$rows->tot_btn;
			$bsm=$rows->tot_bsm;
			$jumlah_simpanan=($rows->pokok + $rows->wajib + $rows->sukarela);
			$modal=round($jumlah_simpanan/$tot_simpanan->total_simpanan,2, PHP_ROUND_HALF_UP);
			$jml_laba_peranggota=($sembako + $btn + $bsm);
			$tot_laba_peranggota=$amount_profit->tot_profit;
			//round($jml_laba_peranggota/$amount_profit->tot_profit,2,PHP_ROUND_HALF_UP);
			array_push($data, 
				array(
					$no++,
					$rows->kd_angg,
					$rows->nm_angg,
					number_format($rows->pokok,0,',',','),
					number_format($rows->wajib,0,',',','),
					number_format($rows->sukarela,0,',',','),
					number_format($jumlah_simpanan,0,',',','),
					$modal,
					number_format($sembako,0,',',','),
					number_format($btn,0,',',','),
					number_format($bsm,0,',',','),
					number_format($jml_laba_peranggota,0,',',','),
					$tot_laba_peranggota
				)
			);
		}
		echo json_encode(array('data'=>$data));
	}
	public function excel_net_income()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login', 'refresh');
		}else{
			if(isset($_POST['xls'])){
				$first_date = date('Y-m-d',strtotime($this->input->post('f_date')));
				$last_date  = date('Y-m-d',strtotime($this->input->post('l_date')));
		        $det_simpanan=$this->report_m->net_income($first_date,$last_date)->result();
		        $tot_simpanan=$this->report_m->amount_net_income($first_date,$last_date)->row();
		        $amount_profit=$this->report_m->amount_profit($first_date,$last_date)->row();

		        $periode= tanggal_indo($first_date) .' s/d '. tanggal_indo($last_date);
				$spreadsheet = new Spreadsheet();
				// Set document properties
				$spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
				$spreadsheet->getDefaultStyle()->getFont()->setSize(11);
				$spreadsheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(12);
				$spreadsheet->getActiveSheet()->getDefaultRowDimension()->setRowHeight(14);
				$spreadsheet->getProperties()->setCreator('Heru - herusulistiono.net')
				->setLastModifiedBy('Heru - herusulistiono.net')
				->setTitle('Koperasi Karyawan dan Dosen UNINDRA')
				->setSubject('Koperasi Karyawan dan Dosen UNINDRA')
				->setDescription('Koperasi Karyawan dan Dosen UNINDRA')
				->setKeywords('Koperasi Karyawan dan Dosen UNINDRA')
				->setCategory('DATA SIMPANAN');
				// Add some data
				$top = [
				    'font' => [
				        'bold' => true,
				        'size'=>14,
				    ],
				    'alignment' => [
				        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				    ]
				];
				$spreadsheet->getActiveSheet()->getStyle('A1:A6')->applyFromArray($top);
				$th_cell = [
				    'font' => [
				        'bold' => true,
				    ],
				    'alignment' => [
				        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				    ],
				    'borders' => [
				        'allBorders' => [
				            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
				        ],
				    ],
				    'fill' => [
				        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
				        'rotation' => 90,
				        'startColor' => [
				            'argb' => 'FFA0A0A0',
				        ],
				        'endColor' => [
				            'argb' => 'FFFFFFFF',
				        ],
				    ],
				];
				$spreadsheet->getActiveSheet()->getStyle('A8:Y9')->applyFromArray($th_cell);
				$td_cell = [
				    'borders' => [
				        'allBorders' => [
				            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
				        ],
				    ]
				];
				$spreadsheet->getActiveSheet()->getStyle('A10:Y1000')->applyFromArray($td_cell);

				$spreadsheet->getActiveSheet()
					->mergeCells('A1:Y1')
					->setCellValue('A1','KOPKAR UNINDRA');
				$spreadsheet->getActiveSheet()
					->mergeCells('A2:Y2')
					->setCellValue('A2','SHU ANGGOTA');
				$spreadsheet->getActiveSheet()
					->mergeCells('A3:Y3')
					->setCellValue('A3','PERIODE - '.$periode);

				$spreadsheet->setActiveSheetIndex(0)
				    ->mergeCells('A8:A9')->setCellValue('A8', 'NO')
				    ->mergeCells('B8:B9')->setCellValue('B8', 'KODE')
				    ->mergeCells('C8:C9')->setCellValue('C8', 'NAMA ANGGOTA')
				    ->mergeCells('D8:F8')->setCellValue('D8', 'SIMPANAN')
				    ->setCellValue('D9', 'POKOK')
				    ->setCellValue('E9', 'WAJIB')
				    ->setCellValue('F9', 'SUKARELA')
				    ->setCellValue('G8', 'JUMLAH')
				    ->setCellValue('G9', 'SIMPANAN')
				    ->setCellValue('H8', 'TOTAL')
				    ->setCellValue('H9', 'SIMPANAN')
				    ->setCellValue('I9', 'MODAL')
				    ->mergeCells('J8:L8')->setCellValue('J8', 'USAHA')
				    ->setCellValue('J9', 'SEMBAKO')
				    ->setCellValue('K9', 'BTN')
				    ->setCellValue('L9', 'BSM')
				    ->setCellValue('M8', 'JUMLAH LABA')
				    ->setCellValue('M9', 'per ANGGOTA')
				    ->setCellValue('N8', 'TOTAL LABA')
				    ->setCellValue('N9', 'ANGGOTA')
				    ->setCellValue('O8', '% LABA')
				    ->setCellValue('O9', 'per ANGGOTA')
				    ->mergeCells('P8:Q8')->setCellValue('P8', 'JASA YANG DIBAGIKAN')
				    ->setCellValue('P9', 'MODAL 30%')
				    ->setCellValue('Q9', 'USAHA 70%')
				    ->mergeCells('R8:S8')->setCellValue('R8', 'SHU')
				    ->setCellValue('R9', 'MODAL')
				    ->setCellValue('S9', 'USAHA')
				    ->setCellValue('T8', 'SHU DITERIMA DARI')
				    ->setCellValue('T9', 'TRANSAKSI ANGG')
				    ->setCellValue('U8', 'ALOKASI SHU')
				    ->setCellValue('U9', 'NON ANGGOTA')
				    ->setCellValue('V8', 'JUMLAH')
				    ->setCellValue('V8', 'ANGGOTA')
				    ->setCellValue('W8', 'SHU DARI')
				    ->setCellValue('W8', 'NON ANGGOTA')
				    ->setCellValue('X8', 'TOTAL SHU')
				    ->setCellValue('X9', 'per ANGGOTA')
				    ->setCellValue('Y8', 'REALISASI')
				    ->setCellValue('Y9', 'PEMBAGIAN');

				$i=(int)10;
				$no=(int)1;
				foreach ($det_simpanan as $rows) {
					$sembako=$rows->tot_sembako;
					$btn=$rows->tot_btn;
					$bsm=$rows->tot_bsm;
					$jumlah_simpanan=($rows->pokok + $rows->wajib + $rows->sukarela);
					$modal=round($jumlah_simpanan/$tot_simpanan->total_simpanan,2,PHP_ROUND_HALF_UP);
					$jml_laba_peranggota=($sembako + $btn + $bsm);
					$tot_laba_peranggota=$amount_profit->tot_profit;
					$persen_laba=round($jml_laba_peranggota/$tot_laba_peranggota,2,PHP_ROUND_HALF_UP);
				    $spreadsheet->setActiveSheetIndex(0)
				        ->setCellValue('A'.$i,$no++)
				        ->setCellValue('B'.$i,$rows->kd_angg)
				        ->setCellValue('C'.$i,$rows->nm_angg)
				        ->setCellValue('D'.$i,$rows->pokok)
				        ->setCellValue('E'.$i,$rows->wajib)
				        ->setCellValue('F'.$i,$rows->sukarela)
				        ->setCellValue('G'.$i,$jumlah_simpanan)
				        ->setCellValue('H'.$i,$tot_simpanan->total_simpanan)
				        ->setCellValue('I'.$i,$modal)
				        ->setCellValue('J'.$i,$sembako)
				        ->setCellValue('K'.$i,$btn)
				        ->setCellValue('L'.$i,$bsm)
				        ->setCellValue('M'.$i,$jml_laba_peranggota)
				        ->setCellValue('N'.$i,$tot_laba_peranggota)
				        ->setCellValue('O'.$i,$persen_laba)
				        ->setCellValue('P'.$i,'!NULL')
				        ->setCellValue('Q'.$i,'!NULL')
				        ->setCellValue('R'.$i,'!NULL')
				        ->setCellValue('S'.$i,'!NULL')
				        ->setCellValue('T'.$i,'!NULL')
				        ->setCellValue('U'.$i,'!NULL')
				        ->setCellValue('V'.$i,'!NULL')
				        ->setCellValue('W'.$i,'!NULL')
				        ->setCellValue('X'.$i,'!NULL')
				        ->setCellValue('Y'.$i,'!NULL');
				    $i++;
				}

				// Rename worksheet
				$spreadsheet->getActiveSheet()->setTitle('SHU -'.date('d-m-Y H'));
				// Set active sheet index to the first sheet, so Excel opens this as the first sheet
				$spreadsheet->setActiveSheetIndex(0);
				$save_filename = "data_shu.xlsx";
				// Redirect output to a client’s web browser (Xlsx)
				header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				header('Content-Disposition: attachment;filename="'.$save_filename.'"');
				header('Cache-Control: max-age=0');
				// If you're serving to IE 9, then the following may be needed
				header('Cache-Control: max-age=1');

				// If you're serving to IE over SSL, then the following may be needed
				//header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
				header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
				header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
				header('Pragma: public'); // HTTP/1.0

				$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
				$writer->save('php://output');
				exit;
			}else{
				redirect('report/net_income','refresh');
			}
		}
	}
	//FORM SALES
	public function sales()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login', 'refresh');
		}else{
			$this->data['title']='LAPORAN PENJUALAN';
			$this->data['members'] = $this->loan_m->get_member()->result();
			$this->backend->display('report/index_sales',$this->data);
		}
	}
	public function json_sales()
	{
		$first_date = date('Y-m-d',strtotime($this->input->post('f_date')));
		$last_date  = date('Y-m-d',strtotime($this->input->post('l_date')));
        $sales=$this->report_m->sales($first_date,$last_date)->result();
        $data=array();
		$no=(int)1;
		foreach ($sales as $rows) {
			array_push($data, 
				array(
					$no++,
					tanggal_indo($rows->tgl_jual),
					$rows->kd_prod,
					$rows->nm_prod,
					$rows->qty,
					number_format($rows->harga_jual,0,',',','),
					number_format($rows->harga_jual * $rows->qty,0,',',',')
				)
			);
		}
		echo json_encode(array('data'=>$data));
	}
	public function excel_sales()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login', 'refresh');
		}else{
			if(isset($_POST['xls'])) {
				$first_date = date('Y-m-d',strtotime($this->input->post('f_date')));
				$last_date  = date('Y-m-d',strtotime($this->input->post('l_date')));
				$result=$this->report_m->sales($first_date,$last_date)->result();
				$periode= tanggal_indo($first_date) .' s/d '. tanggal_indo($last_date);
				$spreadsheet = new Spreadsheet();
				// Set document properties
				$spreadsheet->getProperties()->setCreator('Heru - herusulistiono.net')
				->setLastModifiedBy('Heru - herusulistiono.net')
				->setTitle('Koperasi Karyawan dan Dosen UNINDRA')
				->setSubject('Koperasi Karyawan dan Dosen UNINDRA')
				->setDescription('Koperasi Karyawan dan Dosen UNINDRA')
				->setKeywords('Koperasi Karyawan dan Dosen UNINDRA')
				->setCategory('DATA PENJUALAN');
				// Add some data
				$top = [
				    'font' => [
				        'bold' => true,
				        'size'=>14,
				    ],
				    'alignment' => [
				        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				    ]
				];
				$spreadsheet->getActiveSheet()->getStyle('A1:A6')->applyFromArray($top);
				$th_cell = [
				    'font' => [
				        'bold' => true,
				    ],
				    'alignment' => [
				        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				    ],
				    'borders' => [
				        'allBorders' => [
				            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
				        ],
				    ],
				    'fill' => [
				        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
				        'rotation' => 90,
				        'startColor' => [
				            'argb' => 'FFA0A0A0',
				        ],
				        'endColor' => [
				            'argb' => 'FFFFFFFF',
				        ],
				    ],
				];
				$spreadsheet->getActiveSheet()->getStyle('A8:G8')->applyFromArray($th_cell);
				$td_cell = [
				    'borders' => [
				        'allBorders' => [
				            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
				        ],
				    ]
				];
				$spreadsheet->getActiveSheet()->getStyle('A8:G1000')->applyFromArray($td_cell);

				$spreadsheet->getActiveSheet()
					->mergeCells('A1:G1')
					->setCellValue('A1','KOPKAR UNINDRA');
				$spreadsheet->getActiveSheet()
					->mergeCells('A2:G2')
					->setCellValue('A2','PENJUALAN');
				$spreadsheet->getActiveSheet()
					->mergeCells('A3:G3')
					->setCellValue('A3','PERIODE - '.$periode);
				$spreadsheet->setActiveSheetIndex(0)
				    ->setCellValue('A8', 'NO')
				    ->setCellValue('B8', 'TANGGAL')
				    ->setCellValue('C8', 'KODE')
				    ->setCellValue('D8', 'DESKSRIPSI PRODUK')
				    ->setCellValue('E8', 'QTY')
				    ->setCellValue('F8', 'HARGA')
				    ->setCellValue('G8', 'SUBTOTAL');
				// Miscellaneous glyphs, UTF-8
				$i=(int)9;
				$no=(int)1;
				foreach ($result as $rows) {
				    $spreadsheet->setActiveSheetIndex(0)
				        ->setCellValue('A'.$i,$no++)
				        ->setCellValue('B'.$i,tanggal_indo($rows->tgl_jual))
				        ->setCellValue('C'.$i,$rows->kd_prod)
				        ->setCellValue('D'.$i,$rows->nm_prod)
				        ->setCellValue('E'.$i,$rows->qty)
				        ->setCellValue('F'.$i,$rows->harga_jual)
				        ->setCellValue('G'.$i,$rows->harga_jual*$rows->qty);
				    $i++;
				}
				// Rename worksheet
				$spreadsheet->getActiveSheet()->setTitle('DATA PENJUALAN-'.date('d-m-Y H'));
				// Set active sheet index to the first sheet, so Excel opens this as the first sheet
				$spreadsheet->setActiveSheetIndex(0);
				$save_filename = "data_penjualan.xlsx";
				// Redirect output to a client’s web browser (Xlsx)
				header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				header('Content-Disposition: attachment;filename="'.$save_filename.'"');
				header('Cache-Control: max-age=0');
				// If you're serving to IE 9, then the following may be needed
				header('Cache-Control: max-age=1');

				// If you're serving to IE over SSL, then the following may be needed
				//header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
				header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
				header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
				header('Pragma: public'); // HTTP/1.0

				$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
				$writer->save('php://output');
				exit;
			}else{
				redirect('report/loan','refresh');
			}
		}
	}
	//INVENTORY FORM
	public function inventory()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login', 'refresh');
		}else{
			$this->data['title']='LAPORAN PERSEDIAAN';
			$this->data['members'] = $this->loan_m->get_member()->result();
			$this->backend->display('report/index_inventory',$this->data);
		}
	}
}

/* End of file Report.php */
/* Location: ./application/controllers/Report.php */