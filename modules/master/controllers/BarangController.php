<?php

use \modules\dashboard\controllers\MainController;

class BarangController extends MainController {

	public function index() {
		$this->model('barang','master');
		$model = new BarangModel();

		$data = $model->get_data();
		$success = null;

		if($_SERVER["REQUEST_METHOD"] == "POST") {
			require_once "resources/assets/plugins/PHPExcel/Classes/PHPExcel.php";
			require_once "resources/assets/plugins/PHPExcel/Classes/PHPExcel/IOFactory.php";

			$file = $_FILES['fileimport']['tmp_name'];
			$load = PHPExcel_IOFactory::load($file);
			$sheets = $load->getActiveSheet()->toArray(null,true,true,true);

			$i = 1;
			foreach ($sheets as $sheet) {

				if ($i > 1) {
					$sql = '';

					$this->model('barang','master');
					$model = new BarangModel();
					$data = $model->get_num_where($sheet['A']);

					foreach ($data as $row){
						$numrow = $row->jml;
					}
					// var_dump($numrow);
					if ($numrow == 1) {
						//udate
						$sql = 'UPDATE temp_barang SET id_barang="'.$sheet['B'].'", nm_barang="'.$sheet['C'].'" WHERE kode_brg="'.$sheet['A'].'"';
					} else {
						//insert
						$sql = 'INSERT INTO temp_barang SET';
						$sql .= ' kode_brg="'.$sheet['A'].'",';
						$sql .= ' id_barang="'.$sheet['B'].'",';
						$sql .= ' nm_barang="'.$sheet['C'].'"';
					}
					$model->importdata($sql);
				}

				$i++;
			}
			$success = "Data Berhasil di Upload.";
		}

		$this->template('master/barang', array('barang' => $data, 'sukses' => $success));

	}

	public function ajaxbarang() {
		$this->model('barang','master');
		$model = new BarangModel();

		$data = $model->get_data();

		echo json_encode($data);
	}

	public function listpost() {
		$this->model('barang','master');
		$model = new BarangModel();

		$data = $model->get_data_post();

		echo json_encode($data);
	}

	public function ajaxposting()
	{
		$this->model('barang','master');
		$model = new BarangModel();

		$row = $model->get_data_post();
		for ($i=0; $i < count($row); $i++) { 
			$cek = $model->get_num_where_id($row[$i]->kode_brg);
			$jml = $cek[0]->jml;
			if ($jml==0) {
				//insert
				$sql = 'INSERT INTO barang SET';
				$sql .= ' kode_brg="'.$row[$i]->kode_brg.'",';
				$sql .= ' id_barang="'.$row[$i]->id_barang.'",';
				$sql .= ' nm_barang="'.$row[$i]->nm_barang.'", lastmodified=NOW()';
			} else {
				//update
				$sql = 'UPDATE barang SET id_barang="'.$row[$i]->kode_brg.'", nm_barang="'.$row[$i]->id_barang.'", lastmodified=NOW() WHERE kode_brg="'.$row[$i]->kode_brg.'"';
			}
			$model->importdata($sql);
		}
		$model->truncateTemp();
		echo json_encode('');
	}

	public function exportbrgexcel()
	{
		$cari = isset($_GET["cari"]) ? $_GET["cari"] : '';

		$filename="Data Barang - ".date('Ymd').".xls";

		header("Content-Type: application/vnd-ms-excel"); 
		header('Content-Disposition: attachment; filename="' . $filename . '";');

		$this->model('barang','master');
		$model = new BarangModel();
		$data = $model->get_where($cari);

		//title
		echo '<h2 align="center">Data Barang</h2>';

		//head
		$head = '<table border="solid black 1px">'.
		'<thead><tr><td>No.</td>'.
		'<td align="center">Kode Barang</td>'.
		'<td align="center">ID Barang</td>'.
		'<td align="center">Nama Barang</td>'.
		'<td align="center">Alias</td></tr></thead>';

		//detail
		$no = 1;
		$detail = '<tbody>';
		foreach ($data as $row){
			$detail = $detail.'<tr><td align="left">'.$no.'</td>';
			$detail = $detail.'<td align="center">'.$row->kode_brg.'</td>';
			$detail = $detail.'<td align="center">'.$row->id_barang.'</td>';
			$detail = $detail.'<td align="center">'.$row->nm_barang.'</td>';
			$detail = $detail.'<td align="center">'.$row->alias.'</td></tr>';
			$no++;
		}

		$detail = $detail.'</tbody></table>';

		echo $head;
		echo $detail;

		exit;
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