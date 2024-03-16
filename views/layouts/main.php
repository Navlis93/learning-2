<!DOCTYPE html>
<html>
<head>
	<title>Demo app</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
	<style type="text/css">
		.text-through {
			text-decoration: line-through;
		}
		.errored {
			border-color: red;
		}
		.remove-item {
			border: 1px solid;
			border-radius: 3px;
			background: #ccc;
			color: #fff;
			padding: 3px;
			cursor: pointer;
		}
		.complete-item {
			border: 1px solid;
			border-radius: 3px;
			background: #ccc;
			color: #fff;
			padding: 3px;
			cursor: pointer;
			margin: 0 4px;
		}
	</style>

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
</head>
<body>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/">Todo App</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    	<ul class="nav navbar-nav navbar-right">
	    	<?php if(!$user->isLogged): ?>
	        <li><a href="/login">Login</a></li>
	        <li><a href="/register">Register</a></li>
	        <?php endif; ?>
	        <?php if($user->isLogged): ?>
	        <li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Username: <?= $user->name ?> <span class="caret"></span></a>
	          <ul class="dropdown-menu">
	            <li><form method="post" action="/logout"><button class="btn btn-link btn-block" type="submit">Logout</button></form></li>
	          </ul>
	        </li>
	        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
	<div class="content">
		<?= $content ?>
	</div>
</body>
</html>