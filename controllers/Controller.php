<?php
namespace App\Controllers;

use App\View;

class Controller {

	protected $layout;

	protected $flash;

	private $default_layout = 'main';

	function __construct() {
		$this->layout = $this->default_layout;
	}

	public static function __callStatic($name, $arguments) {
		if (!method_exists(get_called_class(), 'action'.ucfirst($name))){
			throw new \Exception('Method doesnt exist in controller');
		}
		$className = get_called_class();
		$controller = new $className();
		$controller->initFlash();
		call_user_func([$controller, 'action'.ucfirst($name)]);

	}

	protected function request() {
		$payload = file_get_contents('php://input');
		switch ($_SERVER['CONTENT_TYPE']) {
			case 'application/x-www-form-urlencoded':
				parse_str($payload, $data);
				break;
			case 'application/json':
				$data = json_decode($payload, true);
				break;
			default:
				$data = [];
		}
		return (object) $data;
	}

	protected function initFlash() {
		$this->flash = isset($_SESSION['flash']) ? $_SESSION['flash'] : [];
		unset($_SESSION['flash']);
	}

	protected function getFlash($name) {
		return isset($this->flash[$name]) ? $this->flash[$name] : NULL;
	}

	protected function setFlash($key, $value) {
		$_SESSION['flash'][$key] = $value;
		$this->flash[$key] = $value;
	}

	protected function render($template, $data = []) {
		ob_start();
		extract($data);
		require(realpath(__DIR__.'/../views/'.$template));
		$content = ob_get_contents();
		ob_end_clean();

		$view = new View($this->layout ? $this->layout : $this->default_layout);
		$view->render(['content' => $content]);

	}

	protected function json($data) {
		header('Content-Type: application/json');
		echo json_encode($data);
		return;
	}

	protected function redirect($path = '/') {
		header('Location: '.$path);
		return;
	}
}