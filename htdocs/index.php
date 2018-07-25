<html>
<head>
	<title>Camagru</title>
	<link rel="stylesheet" type="text/css" href="css/default.css" />
	<link rel="icon" type="image/ico" href="img/favicon.ico" />
	<meta charset="utf-8" />
</head>
<?php
	if (isset($_GET['disconnect']))
	{
		session_start();
		session_destroy();
		header('Location: /');
	}
	include_once 'database/libdb.php';
	if (!($db = db_conn()))
	{
		if (isset($_SESSION))
			header('location: /?disconnect');
		include_once 'database/connect.php';
		exit ;
	}
?>
<body>
	<?php
		include_once 'includes/header.php';
		include_once 'includes/galery.php';
		include_once 'includes/users.php';
		include_once 'includes/snap.php';
	?>
	<div style="margin:0;flex:1;padding-bottom:42px;padding-top:42px;background:rgba(255, 255, 255, 0.8);" >
	<?php
		if (empty($_GET))
			printGalery(0);
		else if (isset($_GET['snap']))
			printSnap($user, $db);
		else if (isset($_GET['users']))
		{
			if (!empty($_GET['users']))
				printGalery($_GET['users']);
			else
				printUsers();
		}
		else if (isset($_GET['admin']))
			include_once 'includes/admin/admin.php';
		else if (isset($_GET['profil']))
			printOwnUser($_SESSION['login'], $_SESSION['user_data']['id']);
		else
			echo "404 NOT FOUND";
	?>
	<footer>
		<div id="fnav">

		</div>
	</footer>
	</div>
</body>
</html>
