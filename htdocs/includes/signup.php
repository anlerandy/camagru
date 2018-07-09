<?php
	require_once __DIR__.'/../class/user.class.php';
	session_start();

	$user = new User();
	$path = '/images/users/'.$_POST['login'].'.jpg';
	$imgDir = __DIR__.'/../images/users/'.$_POST['login'].'.jpg';
	if (isset($_FILES) && !empty($_FILES) && !empty($_FILES['img']['name']))
		try {
			echo "Téléchargement de l'image!\n";
			move_uploaded_file($_FILES['img']['tmp_name'], $imgDir);
		} catch (PDOException $e)
		{
			echo "Echec de téléversement de votre image.";
		}
	else
	{
		$path = null;
		$imgDir = null;
	}
	if (isset($_POST) && !empty($_POST))
	{
		if (($err_sign = $user->exist($_POST['login'], $_POST['mail'])))
		{
			if ($err_sign === 1)
				$err_sign = 'Cet utilisateur';
			if ($err_sign === 2)
				$err_sign = 'Cette adresse mail';
			echo '<html>
				<body onload="document.frm1.submit()">
				<form method="POST" action="'.$_SERVER['HTTP_REFERER'].'" name="frm1">
				<input type="hidden" name="signin" value="' . $err_sign . '" />
				</form>
				</body>
				</html>';
			exit ;
		}
		else
			if ($user->newUser($_POST['login'], $_POST['passwd'], $_POST['mail'], $path))
				$user->LogIn($_POST['login'], $_POST['passwd']);
	}
	$link = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
	header('location: ' . $link);
?>
