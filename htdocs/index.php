<html>
<head>
	<title>Camagru</title>
	<link rel="stylesheet" type="text/css" href="css/default.css" />
	<link rel="icon" type="image/ico" href="img/favicon.ico" />
	<meta charset="utf-8" />
</head>
<?php
	include_once 'database/libdb.php';
	if (!($db = db_conn()))
	{
		include_once 'database/connect.php';
		exit ;
	}
?>
<body>
	<?php
		include_once 'includes/header.php';
		include_once 'includes/galery.php';
		include_once 'includes/snap.php';
		if (empty($_GET))
			printGalery();
		else if (isset($_GET['disconnect']))
		{
			session_destroy();
			header('Location: /');
		}
		else if (isset($_GET['snap']))
		{
			printSnap($user, $db);
		}
		else
			echo "404 NOT FOUND";
	?>
	<footer>
		<div id="fnav">

		</div>
	</footer>
</body>
</html>
