<?php
namespace App;

use App\Database;

class User {

	private static $user;

	public $isLogged = false;
	public $name;
	public $id;

	function __construct() {
		if(isset($_SESSION['user']) && $_SESSION['user']) {
			$this->isLogged = true;
			$this->id = $_SESSION['user']['id'];
			$this->name = $_SESSION['user']['name'];
		}
	}


	public function login($name, $password) {
		$db = Database::getConnection();
		$stmt = $db->prepare("SELECT * FROM users WHERE name = ? and password = ?");
		$password = md5($_POST['password']);
		$stmt->bind_param("ss", $_POST['username'], $password);
		$stmt->execute();
		$res = $stmt->get_result();
		$user = $res->fetch_assoc();
		if ($user) {
			$_SESSION['user'] = $user;
			$this->isLogged = true;
			$this->id = $user['id'];
			$this->name = $user['name'];
			return true;
		} else {
			return false;
		}
	}

	public function register($name, $password, $password_confirm) {
		$errors = [];
		$name = trim($name);
		$password = trim($password);
		$password_confirm = trim($password_confirm);
		if ($name == '') {
			$errors['username'] = 'Заполните имя пользователя';
		}
		if ($password == '') {
			$errors['password'] = 'Заполните пароль';
		}
		if ($password != $password_confirm) {
			$errors['password_confirm'] = 'Пароли не совпадают';
		}
		$db = Database::getConnection();
		$stmt = $db->prepare("SELECT * FROM users WHERE name = ?");
		$stmt->bind_param("s", $name);
		$stmt->execute();
		$res = $stmt->get_result();
		$user = $res->fetch_assoc();
		if ($user) {
			$errors['username'] = 'Имя пользователя занято';
		}
		if (!empty($errors)) {
			return ['errors' => $errors];
		}

		$stmt = $db->prepare("INSERT INTO users (`name`, `password`) values (?, ?)");
		$new_password = md5($password_confirm);
		$stmt->bind_param("ss", $name, $new_password);
		$stmt->execute();
		$_SESSION['user'] = ['id'=> $stmt->insert_id, 'name' => $name, 'password' => $new_password];
		$this->isLogged = true;
		$this->name = $user->name;
		return [];
	}

	public function logout() {
		unset($_SESSION['user']);
		session_destroy();
		$this->isLogged = false;
	}

	public static function getUser() {
		if (self::$user == null) {
            self::$user = new User();
        }
        return self::$user;
	}

}