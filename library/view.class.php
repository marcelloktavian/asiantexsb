<?php
class View {

	public $viewName = NULL;
	public $fileName = NULL;
	public $data = array();
	public $isRender =  FALSE;

	public function __construct($view){
		$file = explode('/', $view);
		$this->fileName = $file[0];
		$this->viewName = $file[1];
	}

	public function bind($name, $value = ''){
		if(is_array($name)){
			foreach($name as $attr=>$val){
				$this->data[$attr] = $val;
			}
		}
		else $this->data[$name] = $value;
	}

	public function forceRender(){
		$this->isRender = TRUE;
		extract($this->data);
		$view = ROOT . DS . 'modules' . DS . $this->fileName . DS . 'views' . DS . $this->viewName . '.view.php';
		if(file_exists($view)) require_once $view;
		else echo('View Not Found !');
	}

	public function __destruct(){
		if(! $this->isRender) $this->forceRender();
	}
}
?>