<?php

use \modules\dashboard\controllers\MainController;

class SalesOrderController extends MainController {

	public function index() {
		$this->model('salesorder','transaksi');
		$model = new SalesOrderModel();

		$data = $model->get_data();

		$this->template('transaksi/salesorder', array('salesorder' => $data));
	}

	public function ajaxbarang() {
		if (isset($_POST['barang']) && $_POST['barang'] != "") { 
			$this->model('salesorder','transaksi');
			$model = new SalesOrderModel();

			$data = $model->get_barang($_POST['barang']);

			echo json_encode($data);
		} 
	}

	public function delete() {
		$id = isset($_GET["id"]) ? $_GET["id"] : 0;

		$this->model('salesorder','transaksi');
		$model = new SalesOrderModel();

		$data = $model->deleteData($id);

		if($data) {
			$this->back();
		}
	}

	public function deleteDet() {
		$iddet = isset($_GET["iddet"]) ? $_GET["iddet"] : 0;

		$this->model('salesorder','transaksi');
		$model = new SalesOrderModel();

		$data = $model->deleteDetail($iddet);

		if($data) {
			$this->back();
		}
	}

	public function posting() {
		$id = isset($_GET["id"]) ? $_GET["id"] : 0;

		$this->model('salesorder','transaksi');
		$model = new SalesOrderModel();

		$data = $model->postingData($id);

		if($data) {
			$this->back();
		}
	}

	public function list()
	{
		if (isset($_POST['idtrans']) && $_POST['idtrans'] != "") { 
			$this->model('salesorder','transaksi');
			$model = new SalesOrderModel();

			$data = $model->getID($_POST['idtrans']);

			echo json_encode($data);
		} 
	}

	public function insert() {

		$this->model('salesorder','transaksi');
		$model = new SalesOrderModel();
		$customer = $model->getCustomer();
		$jenis = $model->getJenis();

		$error    	= null;
		$success    = null;

		if($_SERVER["REQUEST_METHOD"] == "POST") {

			if (trim($_POST["totqty"])=='0') {
				//Jika tabel keranjang kosong.
				$error = "Tabel Keranjang kosong.";
			} else {
				//generate id transaksi
				$id=$model->kodeoto();
				foreach ($id as $idny ) {
					$idtrans = $idny->awal;
				}

				// insert master
				$data = array(
				'id_trans'       	=> $idtrans, //auto generate
				'kode'				=> ' ',
				'tgl_trans'			=> date("Y-m-d H:i:s"),
				'id_supplier'		=> trim($_POST["customer"]),
				'perintah'    	 	=> '',
				'keluhan'      		=> ' ',
				'biaya'     	  	=> '0',
				'faktur'       		=> '0',
				'totalqty' 			=> trim($_POST["totqty"]),
				'totalfaktur' 		=> '0',
				'tunai'     		=> '0',
				'transfer'       	=> '0',
				'kartu'       		=> '0',
				'deposit'       	=> '0',
				'simpan_deposit' 	=> '0',
				'piutang'      		=> '0',
				'pelunasan'      	=> '0',
				'id_user'			=> trim($_POST["iduser"]),
				'deleted'       	=> '0',
				'state'       		=> '0',
			);
				$master = $model->saveMaster($data);

				//insert detail
				$kdbrg=$_POST['kd_brg'];
				for ($i=0; $i < count($kdbrg); $i++) {
					if ($_POST['kd_brg'][$i]!=='' && $_POST['qty'][$i]!=='0') {
						$brg=$model->getBarang($_POST['kd_brg'][$i]);
						if ($_POST['jenis'][$i]=='0' || $_POST['jenis'][$i]=="" || $_POST['jenis'][$i]=='selected') {
							$jenis = 1;
						} else {
							$jenis = $_POST['jenis'][$i];
						}

						$dataDet['kode_brg'] = $_POST['kd_brg'][$i];
						$dataDet['id_jenis'] = $jenis;
						$dataDet['id_barang'] = $_POST['id_brg'][$i];
						$dataDet['id_trans'] = $idtrans;
						$dataDet['harga'] = 0;
						$dataDet['id_karyawan'] = trim($_POST["iduser"]);
						$dataDet['qty'] = $_POST['qty'][$i];
						$dataDet['qty_kirim'] = 0;
						$detail = $model->saveDetail($dataDet);
					} 
				}

				if($master && $detail) {
					$success = "Data Berhasil di simpan.";
				}else{
					$error = "Data Gagal di simpan.";
				}
			}		

		}
		$this->template('transaksi/frmsalesorder', array('customer' => $customer, 'jenis' => $jenis, 'success' => $success, 'error' => $error, 'title' => 'Tambah Data'));
	}

	public function update() {

		$id = isset($_GET["id"]) ? $_GET["id"] : '0';

		$this->model('salesorder','transaksi');
		$model = new SalesOrderModel();

		$data = $model->getID($id);
		$custEdit = $model->getCustEdit($id);
		$jenisEdit = $model->getJenisEdit($id);

		$customer = $model->getCustomer();
		$jenis = $model->getJenis();

		$error    	= null;
		$success    = null;

		if($_SERVER["REQUEST_METHOD"] == "POST") {
			if (trim($_POST["totqty"])=='0') {
				//Jika tabel keranjang kosong.
				$error = "Tabel Keranjang kosong.";
			} else {
				// update master
				if (trim($_POST["customer"])=='selected') {
					//jika select customer tidak dipilih kembali
					$datamaster = array(
						'kode'				=> ' ',
						'tgl_trans'			=> date("Y-m-d H:i:s"),
						'perintah'    	 	=> '',
						'keluhan'      		=> ' ',
						'biaya'     	  	=> '0',
						'faktur'       		=> '0',
						'totalqty' 			=> trim($_POST["totqty"]),
						'totalfaktur' 		=> '0',
						'tunai'     		=> '0',
						'transfer'       	=> '0',
						'kartu'       		=> '0',
						'deposit'       	=> '0',
						'simpan_deposit' 	=> '0',
						'piutang'      		=> '0',
						'pelunasan'      	=> '0',
						'id_user'			=> trim($_POST["iduser"]),
					);
				} else {
					//jika select customer dipilih kembali
					$datamaster = array(
						'kode'				=> ' ',
						'tgl_trans'			=> date("Y-m-d H:i:s"),
						'id_supplier'		=> trim($_POST["customer"]),
						'perintah'    	 	=> '',
						'keluhan'      		=> ' ',
						'biaya'     	  	=> '0',
						'faktur'       		=> '0',
						'totalqty' 			=> trim($_POST["totqty"]),
						'totalfaktur' 		=> '0',
						'tunai'     		=> '0',
						'transfer'       	=> '0',
						'kartu'       		=> '0',
						'deposit'       	=> '0',
						'simpan_deposit' 	=> '0',
						'piutang'      		=> '0',
						'pelunasan'      	=> '0',
						'id_user'			=> trim($_POST["iduser"]),
					);
				}

				$master = $model->updateMaster($datamaster, trim($_POST["idtrans"]));

				//kondisi detail
				$kdbrg=$_POST['kd_brg'];
				for ($i=0; $i < count($kdbrg); $i++) {
					//get id jenis setiap barang
					$brg=$model->getBarang($_POST['kd_brg'][$i]);
					if ($_POST['jenis'][$i]=='0' || $_POST['jenis'][$i]=="" || $_POST['jenis'][$i]=='selected') {
						$jenis = 1;
					} else {
						$jenis = $_POST['jenis'][$i];
					}

					if ($_POST['iddetail'][$i]=='' && $_POST['qty'][$i]!=='0') {
						//insert detail
						$dataDet['kode_brg'] = $_POST['kd_brg'][$i];
						$dataDet['id_jenis'] = $jenis;
						$dataDet['id_barang'] = $_POST['id_brg'][$i];
						$dataDet['id_trans'] = trim($_POST["idtrans"]);
						$dataDet['harga'] = 0;
						$dataDet['id_karyawan'] = trim($_POST["iduser"]);
						$dataDet['qty'] = $_POST['qty'][$i];
						$dataDet['qty_kirim'] = 0;
						$detail = $model->saveDetail($dataDet);
					} else {
						//update detail
						$dataDet['id_jenis'] = $jenis;
						$dataDet['harga'] = 0;
						$dataDet['id_karyawan'] = trim($_POST["iduser"]);
						$dataDet['qty'] = $_POST['qty'][$i];
						$detail = $model->updateDetail($dataDet, $_POST['iddetail'][$i]);

					}
				}

				if($master && $detail) {
					$success = "Data Berhasil di ubah.";
				}else{
					$error = "Data Gagal di simpan.";
				}
			}
		}

		$this->template('transaksi/frmsalesorder', array('customer' => $customer, 'jenis' => $jenis, 'so' => $data, 'custEdit' => $custEdit[0], 'jenisEdit' => $jenisEdit, 'success' => $success, 'error' => $error, 'title' => 'Ubah Data'));

	}

	public function autobarang(){
		// var_dump($_GET['term']);
		// $this->redirect($_GET['term']);
		if (isset($_GET['term'])) {
			$this->model('salesorder','transaksi');
			$model = new SalesOrderModel();
			$result = $model->completebarang($_GET['term']);
			if (count($result) > 0) {
				foreach ($result as $row)
					$arr_result[] = array(
						'label'         => $row->id_barang,
						'description'   => $row->kode_brg,
						'nmbrg'  		=> $row->nm_barang,
					);
				echo json_encode($arr_result);
			}
		}
	}
}
?>