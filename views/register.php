<h1>Регистрация</h1>
<form method="POST" action="/register">
	<div><input type="text" name="username" value="<?= $username ?>"></div>
	<?= isset($error['username']) ? '<div style="color:red;">'.$error['username'].'</div>' : '' ?>
	<div><input type="password" name="password" value="<?= $password ?>"></div>
	<?= isset($error['password']) ? '<div style="color:red;">'.$error['password'].'</div>' : '' ?>
	<div><input type="password" name="password_confirm" value="<?= $password_confirm ?>"></div>
	<?= isset($error['password_confirm']) ? '<div style="color:red;">'.$error['password_confirm'].'</div>' : '' ?>
	<div>
		<button type="submit">ok</button>
	</div>
</form>