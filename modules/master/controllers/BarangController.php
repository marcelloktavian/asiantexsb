<?php

use \modules\dashboard\controllers\MainController;

class BarangController extends MainController {

	public function index() {
		$this->model('barang','master');
		$model = new BarangModel();

		$data = $model->get_data();

		$this->template('master/barang', array('barang' => $data));
	}

	public function ajaxbarang() {
		$this->model('barang','master');
		$model = new BarangModel();

		$data = $model->get_data();

		echo json_encode($data);
	}

	public function exportbrg(){
		include "resources/assets/plugins/fpdf182/fpdf.php";
		$cari = isset($_GET["cari"]) ? $_GET["cari"] : '';

		$pdf = new FPDF('l','mm','A4');
		$pdf->AddPage();

		//title
		$pdf->SetTitle('Data Barang');
		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(275,7,'Data Barang',0,1,'C');

		$pdf->Cell(10,7,'',0,1);
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(15,7,'No.',1,0);
		$pdf->Cell(60,7,'Kode Barang',1,0,'C');
		$pdf->Cell(60,7,'ID Barang',1,0,'C');
		$pdf->Cell(111,7,'Nama Barang',1,0,'C');
		$pdf->Cell(30,7,'Alias',1,1,'C');

		$pdf->SetFont('Arial','',11);

		$no = 1;

		$this->model('barang','master');
		$model = new BarangModel();
		$data = $model->get_where($cari);
		foreach ($data as $row){
			$pdf->Cell(15,7,$no.'.',1,0);
			$pdf->Cell(60,7,$row->kode_brg,1,0,'C');
			$pdf->Cell(60,7,$row->id_barang,1,0,'C');
			$pdf->Cell(111,7,$row->nm_barang,1,0,'C');
			$pdf->Cell(30,7,$row->alias,1,1,'C'); 
			$no++;
		}

		$pdf->Output();
	}
}
?>