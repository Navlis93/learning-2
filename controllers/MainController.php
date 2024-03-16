<?php
namespace App\Controllers;

use App\ItemsRepository;
use App\User;

class MainController extends Controller  {

	public function __construct() {
		$user = User::getUser();
		if (!$user->isLogged) {
			return $this->redirect('/login');
		}
	}

	public function actionView() {		
		
		$items = ItemsRepository::getItems(User::getUser()->id);
		$errors = $this->getFlash('errors');
		return $this->render('view.php', [
			'items' => $items,
			'error' => isset($errors['AddItemForm']) ? $errors['AddItemForm'] : null
		]);
	}

	public function actionCreate() {
		$data = $this->request();
		$user = User::getUser();
		$res = ItemsRepository::createItem(isset($data->{'new-element'}) ? $data->{'new-element'} : '', (int) $user->id);
		if (isset($res['error'])) {
			$this->setFlash('errors', ['AddItemForm' => $res['error']]);
		}
		return $this->redirect('/');
	}

	public function actionComplete() {
		$data = $this->request();
		$user = User::getUser();
		$res = ItemsRepository::completeItem(isset($data->id) ? (int) $data->id : 0, (int) $user->id);
		
		return $this->json(['success'=>true]);
	}

	public function actionRemove() {
		$data = $this->request();
		$user = User::getUser();
		$res = ItemsRepository::deleteItem(isset($data->id) ? (int) $data->id : 0, (int) $user->id);
		
		return $this->json(['success'=>true]);
	}

}