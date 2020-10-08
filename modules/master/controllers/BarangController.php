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
}
?>