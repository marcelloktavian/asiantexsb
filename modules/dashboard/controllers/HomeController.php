<?php

use \modules\dashboard\controllers\MainController;

class HomeController extends MainController {

	public function index() {
		$data = $_SESSION["loginasiantexsb"];
		
		$this->template('dashboard/home', array('userData' => $data));
	}

}
?>