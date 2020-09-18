<?php

use \modules\dashboard\controllers\MainController;

class SalesOrderController extends MainController {

	public function index() {
		$this->model('salesorder','transaksi');
		$model = new SalesOrderModel();

		$data = $model->get_data();

		$this->template('transaksi/salesorder', array('salesorder' => $data));
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

	public function posting() {
		$id = isset($_GET["id"]) ? $_GET["id"] : 0;

		$this->model('salesorder','transaksi');
		$model = new SalesOrderModel();

		$data = $model->postingData($id);

		if($data) {
			$this->back();
		}
	}

	public function insert() {

		$this->model('salesorder','transaksi');
		$model = new SalesOrderModel();
		$customer = $model->getCustomer();

		$error    	= null;
		$success    = null;

		if($_SERVER["REQUEST_METHOD"] == "POST") {

			// $data = array(
			// 	'id_ar'       	=> trim($_POST["idarmada"]),
			// 	'NoPOL'			=> trim($_POST["nopol"]),
			// 	'Nama'			=> trim($_POST["nama"]),
			// 	'Keterangan'	=> trim($_POST["keterangan"]),
			// 	'status'       	=> 'Y',
			// 	'lastmodified' 	=> date("Y-m-d H:i:s"),
			// 	'user'			=> trim($_POST["userName"]),
			// );
			// $insert = $model->saveData($data);

			// if($insert) {
			$success = "Data Berhasil di simpan.";
			// }else{
				// $error = "Data Gagal di simpan.";
			// }

		}
		$this->template('transaksi/frmsalesorder', array('customer' => $customer, 'success' => $success, 'error' => $error, 'title' => 'Tambah Data'));

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
					);
				echo json_encode($arr_result);
			}
		}
	}
}
?>