<?php

use \modules\dashboard\controllers\MainController;

class LapSalesOrderController extends MainController {

	public function index() {
		$this->model('lapsalesorder','laporan');
		$model = new LapSalesOrderModel();

		$data = $model->get_data();

		$this->template('laporan/lapsalesorder', array('salesorder' => $data));
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
		$this->model('lapsalesorder','laporan');
		$model = new LapSalesOrderModel();

		$data = $model->get_data();

		echo json_encode($data);
	}
}
?>