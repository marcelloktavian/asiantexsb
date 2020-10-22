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

	public function excelall()
	{
		$filename="Laporan Sales Order - ".date('Ymd').".xls";

		header("Content-Type: application/vnd-ms-excel"); 
		header('Content-Disposition: attachment; filename="' . $filename . '";');

		$dari = isset($_GET["dari"]) ? $_GET["dari"] : '';
		$sampai = isset($_GET["sampai"]) ? $_GET["sampai"] : '';

		//title
		echo '<h2 align="center">Laporan Sales Order (Semua)</h2>';

		//head
		$head = '<table border="solid black 1px">'.
		'<thead><tr><td>No.</td><td align="center">Tanggal Trans</td>'.
		'<thead><td align="center">ID Trans</td><td align="center">Kode Barang</td>'.
		'<thead><td align="center">ID Barang</td><td align="center">Nama Barang</td><td align="center">Qty</td></tr></thead>';

		$this->model('lapsalesorder','laporan');
		$model = new LapSalesOrderModel();
		$data = $model->getdet($dari, $sampai);

		$no = 1;
		$tgl='';
		$idtrans='';

		//detail
		$detail = '<tbody>';
		foreach ($data as $row){
			$detail = $detail.'<tr><td align="left">'.$no.'</td>';

			if ($row->tgl_trans==$tgl) {
				$detail = $detail.'<td align="center">-</td>';
			}else{
				$detail = $detail.'<td align="center">'.$row->tgl_trans.'</td>';
			}
			$tgl = $row->tgl_trans;

			if ($row->id_trans==$idtrans) {
				$detail = $detail.'<td align="center">-</td>';
			}else{
				$detail = $detail.'<td align="center">'.$row->id_trans.'</td>';
			}
			$idtrans = $row->id_trans;

			$detail = $detail.'<td align="center">'.$row->kode_brg.'</td>';
			$detail = $detail.'<td align="center">'.$row->id_barang.'</td>';
			$detail = $detail.'<td align="center">'.$row->nm_barang.'   ('.$row->jns.')</td>';
			$detail = $detail.'<td>'.$row->qty.'</td></tr>';
			$no++;
		}

		$total = $model->countdet($dari, $sampai);
		foreach ($total as $tot){
			$detail = $detail.'<tr><td colspan="6" align="right"><b>Total Qty    :</b></td><td><b>'.$tot->total.'</b></td></tr>';
		}
		$detail = $detail.'</tbody></table>';

		echo $head;
		echo $detail;

		//keterangan
		echo "* Untuk bagian tabel yang kosong, artinya data sama seperti diatasnya";

		exit;
	}

	public function pdfall(){
		include "resources/assets/plugins/fpdf182/fpdf.php";

		$dari = isset($_GET["dari"]) ? $_GET["dari"] : '';
		$sampai = isset($_GET["sampai"]) ? $_GET["sampai"] : '';

		$pdf = new FPDF('l','mm','A4');
		$pdf->AddPage();

		//title
		$pdf->SetTitle('Laporan Sales Order '.$dari.' sampai '.$sampai);
		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(275,7,'Laporan Sales Order (Semua)',0,1,'C');

		$pdf->Ln(3);

		// Detail
		$pdf->Cell(10,7,'',0,1);
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(13,7,'No.',1,0);
		$pdf->Cell(45,7,'Tanggal Trans',1,0,'C');
		$pdf->Cell(40,7,'ID Trans',1,0,'C');
		$pdf->Cell(37,7,'Kode Barang',1,0,'C');
		$pdf->Cell(37,7,'ID Barang',1,0,'C');
		$pdf->Cell(84,7,'Nama Barang',1,0,'C');
		$pdf->Cell(20,7,'Qty',1,1,'C');

		$pdf->SetFont('Arial','',11);

		$no = 1;
		$y = 0;


		$this->model('lapsalesorder','laporan');
		$model = new LapSalesOrderModel();
		$data = $model->getdet($dari, $sampai);

		$tgl='';
		$idtrans='';
		foreach ($data as $row){
			$pdf->Cell(13,7,$no.'.',1,0);
			if ($row->tgl_trans==$tgl) {
				$pdf->Cell(45,7,'-',1,0,'C');
			}else{
				$pdf->Cell(45,7,$row->tgl_trans,1,0,'C');
			}
			$tgl = $row->tgl_trans;

			if ($row->id_trans==$idtrans) {
				$pdf->Cell(40,7,'-',1,0,'C');
			}else{
				$pdf->Cell(40,7,$row->id_trans,1,0,'C');
			}
			$idtrans = $row->id_trans;

			$pdf->Cell(37,7,$row->kode_brg,1,0,'C');
			$pdf->Cell(37,7,$row->id_barang,1,0,'C');
			$pdf->Cell(84,7,$row->nm_barang.'   ('.$row->jns.')',1,0,'C');
			$pdf->Cell(20,7,$row->qty,1,1,'R'); 
			$no++;
			$y = $y+7;
		}

		//footer
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(10,10,'* Untuk bagian tabel - , artinya data sama seperti diatasnya',0,0,'L');

		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(475,10,'Total Qty',0,0,'C');

		$total = $model->countdet($dari, $sampai);
		foreach ($total as $tot){
			$pdf->Cell(0,10,$tot->total,0,0,'R');
		}
		$pdf->Line(10,36+$y+10,286,36+$y+10);

		$pdf->Output();
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
		$y = 0;
		foreach ($data as $row){
			$pdf->Cell(15,7,$no.'.',1,0);
			$pdf->Cell(60,7,$row->kode_brg,1,0,'C');
			$pdf->Cell(60,7,$row->id_barang,1,0,'C');
			$pdf->Cell(116,7,$row->nm_barang.'   ('.$row->jns.')',1,0,'C');
			$pdf->Cell(25,7,$row->qty,1,1,'R'); 
			$no++;
			$y = $y+7;
		}

		//footer
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(475,10,'Total Qty',0,0,'C');
		$pdf->Cell(0,10,$total,0,0,'R');
		$pdf->Line(10,60+$y+10,286,60+$y+10);

		$pdf->Output();
	}

	public function excel()
	{
		$filename="Laporan Sales Order - ".$_GET['idtrans']." - ".date('Ymd').".xls";

		header("Content-Type: application/vnd-ms-excel"); 
		header('Content-Disposition: attachment; filename="' . $filename . '";');

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
		$master = '<table><tr><td colspan="2">ID Trans</td><td> : '.$idtrans.'</td></tr>'.
		'<tr><td colspan="2">Tanggal Trans</td><td> : '.$tgl.'</td></tr>'.
		'<tr><td colspan="2">Customer</td><td> : '.$customer.'</td></tr></table><br>';

		//title
		echo '<h2 align="center">Laporan Sales Order (Satuan)</h2>';

		//head
		$head = '<table border="solid black 1px">'.
		'<thead><tr><td>No.</td>'.
		'<thead><td align="center">Kode Barang</td>'.
		'<thead><td align="center">ID Barang</td>'.
		'<td align="center">Nama Barang</td>'.
		'<td align="center">Qty</td></tr></thead>';

		//detail
		$no = 1;
		$detail = '<tbody>';
		foreach ($data as $row){
			$detail = $detail.'<tr><td align="left">'.$no.'</td>';
			$detail = $detail.'<td align="center">'.$row->kode_brg.'</td>';
			$detail = $detail.'<td align="center">'.$row->id_barang.'</td>';
			$detail = $detail.'<td align="center">'.$row->nm_barang.'   ('.$row->jns.')</td>';
			$detail = $detail.'<td>'.$row->qty.'</td></tr>';
			$no++;
		}

		$detail = $detail.'<tr><td colspan="4" align="right"><b>Total Qty    :</b></td><td><b>'.$total.'</b></td></tr>';
		$detail = $detail.'</tbody></table>';

		echo $master;
		echo $head;
		echo $detail;

		exit;
	}
}
?>