<?php

use \modules\dashboard\controllers\MainController;

class SalesOrderController extends MainController {

	public function index() {
		$this->template('transaksi/salesorder', array('test' => 'test'));
	}
}
?>