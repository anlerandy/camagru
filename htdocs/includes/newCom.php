<?php
	require_once __DIR__.'/../class/user.class.php';
	require_once __DIR__.'/../class/galery.class.php';
	session_start();
	$user = new User();
	$img = new Galery();
	if (isset($_SESSION) && isset($_SESSION['user_data']))
	{
		if ($user->exist($_SESSION['login'], 0))
		{
			$user->setUser();
		}
	}
	if ($user->id && isset($_POST) && !empty($_POST))
	{
		if (isset($_POST['img']) && !empty($_POST['img']) && isset($_POST['com']) && !empty($_POST['com']))
		{
			$img->newCom($user->id, $_POST['img'], $_POST['com']);
				header('location:' . $_SERVER['HTTP_REFERER']);
		}
	}
	else
	{
		echo 'You are not connected. Error 850';
		if (isset($_SESSION) && isset($_SESSION['user_data']))
			session_destroy();
		header("Refresh:2; url=/?snap");
	}
?>
