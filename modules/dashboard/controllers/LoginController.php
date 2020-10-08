<?php

class LoginController extends Controller {

	public function index() {

		$login = isset($_SESSION["loginasiantexsb"]) ? $_SESSION["loginasiantexsb"] : '';

		if($login!=='') {
			$this->redirect('index.php');
		}

		$masuk = null;

		if($_SERVER["REQUEST_METHOD"] == "POST") {

			$masuk = false;

			$username = isset($_POST["username"]) ? $_POST["username"] : '';
			$password = isset($_POST["password"]) ? $_POST["password"] : '';

			
			$this->model('user','dashboard');
			$model = new UserModel();

			$user = $model->get_data($username, $password);

			if(count($user) > 0) {
				//berhasil masuk
				if ($user[0]->group_id == '1' || $user[0]->group_id =='4' || $user[0]->group_id =='5') {
					$masuk = true;
					$_SESSION["loginasiantexsb"] = $user[0];

					$this->redirect('index.php');
				}else {
					$masuk = false;
				}
			}
		}
		$view = $this->view('dashboard/login')->bind('masuk', $masuk);
	}

	public function logout() {
		unset($_SESSION["loginasiantexsb"]);
		$this->redirect('index.php');
	}
	
}
?>