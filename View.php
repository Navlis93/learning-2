<?php
namespace App;

use App\User;

class View {
	private $layout;

	function __construct($layout) {
		$this->layout = $layout;
	}


	public function render($data) {
		extract($data);
		$user = User::getUser();
		require(realpath(__DIR__.'/views/layouts/'.$this->layout.'.php'));
	}
}