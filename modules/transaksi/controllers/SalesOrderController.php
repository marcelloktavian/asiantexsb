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
}
?>