<head>
	<title>Camagru | Installation</title>
	<link rel="stylesheet" type="text/css" href="/css/default.css" />
	<link rel="icon" type="image/ico" href="/img/favicon.ico" />
	<meta charset="utf-8" />
</head>
<?php
	include_once __DIR__ . '/libdb.php';
	if (db_conn())
		;
	else
	{
		echo '<h1><br/>Configure your database</h1>
			<form action="/database/newconfig.php" method="POST">
			Database Server : <input type="text" name="r_server" /><br/>
			DB user : <input type="text" name="r_user" /><br/>
			DB password : <input type="password" name="r_passwd" /><br/>
			DB name : <input type="text" name="r_db" /><br/>
			<button>Configure</button>
			</form>';
	}
?>
