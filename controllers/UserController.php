<?php
namespace App\Controllers;

use App\User;

class UserController extends Controller {

	public function actionLoginForm() {
		$errors = $this->getFlash('errors');
		$data = $this->getFlash('data');
		return $this->render('login.php', [
			'username' => isset($data->username) ? $data->username : '',
			'password' => isset($data->password) ? $data->password : '',
			'error' => isset($errors['LoginForm']) ? $errors['LoginForm'] : null
		]);
	}

	public function actionLogin() {
		$data = $this->request();
		$user = User::getUser();
		if (!$user->login(isset($data->username) ? $data->username : '', isset($data->password) ? $data->password : '')) {
			$this->setFlash('errors', ['LoginForm' => 'Неверное имя пользователя или пароль']);
			$this->setFlash('data', $data);
			return $this->redirect('/login');
		}
		return $this->redirect('/');
	}

	public function actionRegisterForm() {
		$errors = $this->getFlash('errors');
		$data = $this->getFlash('data');
		return $this->render('register.php', [
			'username' => isset($data->username) ? $data->username : '',
			'password' => isset($data->password) ? $data->password : '',
			'password_confirm' => isset($data->password_confirm) ? $data->password_confirm : '',
			'error' => isset($errors['RegisterForm']) ? $errors['RegisterForm'] : null
		]);
	}

	public function actionRegister() {
		$data = $this->request();
		$user = User::getUser();
		$result = $user->register(isset($data->username) ? $data->username : '', isset($data->password) ? $data->password : '', isset($data->password_confirm) ? $data->password_confirm : '');
		if (isset($result['errors'])) {
			$this->setFlash('errors', ['RegisterForm' => $result['errors']]);
			$this->setFlash('data', $data);
			return $this->redirect('/register');
		}
		return $this->redirect('/');
	}

	public function actionLogout() {
		$user = User::getUser();
		$user->logout();
		return $this->redirect('/login');
	}


}