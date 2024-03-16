<?php
namespace App;

use App\Database;

class ItemsRepository {
	

	public static function getItems($user_id = null) {
		$db = Database::getConnection();
		if ($user_id) {
			$stmt = $db->prepare("SELECT * FROM items WHERE user_id = ?");
			$stmt->bind_param('i', $user_id);
			$stmt->execute();
			$res = $stmt->get_result();
		} else {
			$res = $db->query("SELECT * FROM items");
		}
		$result = [];
		while ($row = $res->fetch_assoc()) {
			$result[] = $row;
		}
		return $result;
	}

	public static function createItem($text, $user_id = 0) {
		$text = trim($text);
		if ($text == '') {
			return ['error' => 'Некорректное значение'];
		}
		$db = Database::getConnection();
		$stmt = $db->prepare("INSERT INTO items (`text`, `status`, `user_id`) values (?, 0, ?)");
		$stmt->bind_param("si", $text, $user_id);
		$stmt->execute();
		return ['text' => $text];
	}

	public static function completeItem($id, $user_id) {
		$db = Database::getConnection();
		$stmt = $db->prepare("SELECT * from items WHERE id = ? and user_id = ?");
		$stmt->bind_param("ii", $id, $user_id);
		$stmt->execute();
		$res = $stmt->get_result();
		$row = $res->fetch_assoc();
		if (!$row) {
			return ['errors' => 'Нет доступа'];
		} 
		$status = $row['status'] == 0 ? 1 : 0;
		$stmt = $db->prepare("UPDATE items SET status = ? WHERE id = ? and user_id = ?");
		$stmt->bind_param("iii", $status, $id, $user_id);
		$stmt->execute();
		return ['result' => true];
	}

	public static function deleteItem($id, $user_id) {
		$db = Database::getConnection();
		$stmt = $db->prepare("DELETE FROM items WHERE id = ? and user_id = ?");
		$stmt->bind_param("ii", $id, $user_id);
		$stmt->execute();
		return ['result' => true];
	}

}