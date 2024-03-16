<?php
session_start();
// include classes (будет заменено на autoloader)
// require_once realpath(__DIR__.'/../Database.php');
// require_once realpath(__DIR__.'/../User.php');
// require_once realpath(__DIR__.'/../controllers/Controller.php');
// require_once realpath(__DIR__.'/../controllers/MainController.php');
// require_once realpath(__DIR__.'/../controllers/UserController.php');
// require_once realpath(__DIR__.'/../ItemsRepository.php');
// require_once realpath(__DIR__.'/../View.php');
//autoloader with composer
require realpath(__DIR__ . '/../vendor/autoload.php');


// router
$routes = [
	['GET', '/', App\Controllers\MainController::class, 'view'],
	['POST', '/', App\Controllers\MainController::class, 'create'],
	['POST', '/complete', App\Controllers\MainController::class, 'complete'],
	['POST', '/remove', App\Controllers\MainController::class, 'remove'],
	['GET', '/login', App\Controllers\UserController::class, 'loginForm'],
	['POST', '/login', App\Controllers\UserController::class, 'login'],
	['POST', '/logout', App\Controllers\UserController::class, 'logout'],
	['GET', '/register', App\Controllers\UserController::class, 'registerForm'],
	['POST', '/register', App\Controllers\UserController::class, 'register'],
];

try {
	$uri_info = parse_url($_SERVER['REQUEST_URI']);
	$found = false;
	foreach ($routes as $route) {
		if ($_SERVER['REQUEST_METHOD'] == $route[0] && $uri_info['path'] == $route[1]) {
			call_user_func($route[2].'::'.$route[3]);
			$found = true;
		}
	}
	if (!$found) {
		// TODO: переделать обработку 404 ошибки.
		echo '<h1>404</h1>';
	}
} catch(Exception $e) {
	echo $e->getMessage();
}

?>

