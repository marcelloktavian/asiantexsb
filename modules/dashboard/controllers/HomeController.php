<?php

use \modules\dashboard\controllers\MainController;

class HomeController extends MainController {

	public function index() {
		$data = $_SESSION["loginasiantexsb"];

		$this->model('user','dashboard');
		$model = new UserModel();
		$total = $model->get_total();
		
		$this->template('dashboard/home', array('userData' => $data, 'total' => $total));
	}

}
?>