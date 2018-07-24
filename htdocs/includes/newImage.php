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
		if (isset($_POST['img']) && !empty($_POST['img']))
		{
			$nbr = $img->nextImg($user->id) + 1;
			$name = $nbr . hash('crc32b', $user->login);
			$data = $_POST['img'];
			list($type, $data) = explode(';', $data);
			list(, $data)      = explode(',', $data);
			$data = base64_decode($data);
			if (file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/images/' . $name . '.png', $data))
			{
				$img->newImage($user->id, $_POST['desc'], '/images/' . $name . '.png');
				header('location: /?users=' . $user->login);
			}
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
