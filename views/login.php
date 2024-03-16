<h1>Логин</h1>
<form method="POST" action="/login">
	<div><input type="text" name="username" value="<?= $username ?>"></div>
	<div><input type="password" name="password" value="<?= $password ?>"></div>
	<?= $error ? '<div style="color:red;">'.$error.'</div>' : '' ?>
	<div>
		<button type="submit">ok</button>
	</div>
</form>