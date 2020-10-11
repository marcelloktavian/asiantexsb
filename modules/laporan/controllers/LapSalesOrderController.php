<?php

use \modules\dashboard\controllers\MainController;

class LapSalesOrderController extends MainController {

	public function index() {
		$this->template('laporan/lapsalesorder', array());
	}

	public function list()
	{
		if (isset($_POST['idtrans']) && $_POST['idtrans'] != "") { 
			$this->model('lapsalesorder','laporan');
			$model = new LapSalesOrderModel();

			$data = $model->getID($_POST['idtrans']);

			echo json_encode($data);
		} 
	}

	public function ajaxso() {
		$dari = isset($_GET["dari"]) ? $_GET["dari"] : '';
		$sampai = isset($_GET["sampai"]) ? $_GET["sampai"] : '';

		$this->model('lapsalesorder','laporan');
		$model = new LapSalesOrderModel();

		$data = $model->get_data($dari, $sampai);

		echo json_encode($data);
	}

	public function pdf(){
		include "resources/assets/plugins/fpdf182/fpdf.php";
		
		$pdf = new FPDF('l','mm','A4');
		$pdf->AddPage();

		//title
		$pdf->SetTitle('Laporan Sales Order - '.$_GET['idtrans']);
		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(275,7,'Laporan Sales Order (Satuan)',0,1,'C');

		$this->model('lapsalesorder','laporan');
		$model = new LapSalesOrderModel();

		$data = $model->getID($_GET['idtrans']);
		foreach ($data as $row){
			$idtrans = $row->id_trans;
			$tgl = $row->tgl_trans;
			$customer = $row->namaperusahaan;
			$total  = $row->totalqty;
			break;
		}

		//master
		$pdf->SetFont('Arial','B',12);
		$pdf->setXY(10,25);
		$pdf->Cell(20,0,'ID Trans', 0, '0', 'L');
		$pdf->Cell(30,0,':', 0, '0', 'C');
		$pdf->Cell(10,0,$idtrans, 0, '0', 'L');

		$pdf->SetFont('Arial','B',12);
		$pdf->setXY(10,33);
		$pdf->Cell(20,0,'Tanggal Trans', 0, '0', 'L');
		$pdf->Cell(30,0,':', 0, '0', 'C');
		$pdf->Cell(10,0,$tgl, 0, '0', 'L');

		$pdf->SetFont('Arial','B',12);
		$pdf->setXY(10,41);
		$pdf->Cell(20,0,'Customer', 0, '0', 'L');
		$pdf->Cell(30,0,':', 0, '0', 'C');
		$pdf->Cell(10,0,$customer, 0, '0', 'L');
		$pdf->Ln(5);

        // Detail
		$pdf->Cell(10,7,'',0,1);
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(15,7,'No.',1,0);
		$pdf->Cell(60,7,'Kode Barang',1,0,'C');
		$pdf->Cell(60,7,'ID Barang',1,0,'C');
		$pdf->Cell(116,7,'Nama Barang',1,0,'C');
		$pdf->Cell(25,7,'Qty',1,1,'C');

		$pdf->SetFont('Arial','',11);

		$no = 1;
		foreach ($data as $row){
			$pdf->Cell(15,7,$no.'.',1,0);
			$pdf->Cell(60,7,$row->kode_brg,1,0,'C');
			$pdf->Cell(60,7,$row->id_barang,1,0,'C');
			$pdf->Cell(116,7,$row->nm_barang.'   ('.$row->jns.')',1,0,'C');
			$pdf->Cell(25,7,$row->qty,1,1,'R'); 
			$no++;
		}

		//footer
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(475,10,'Total Qty',0,0,'C');
		$pdf->Cell(0,10,$total,0,0,'R');

		$pdf->Output();
	}
}
?>