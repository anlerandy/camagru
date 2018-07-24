<?php
function db_conn_test($r_server, $r_user, $r_passwd)
{
	try {
		$db = new PDO("mysql:host=$r_server", $r_user, $r_passwd);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch (PDOException $e) {
		echo 'Error 01: ' . $e->getMessage();
		header('Location: '. $_SERVER['HTTP_REFERER']);
	}
	return (1);
}
function db_conn()
{
	if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/database/config.php"))
	{
		try {
			include $_SERVER['DOCUMENT_ROOT'] . "/database/config.php";
			$db = new PDO("mysql:host=$r_server;dbname=$r_db;charset=utf8mb4", $r_user, $r_passwd);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch (PDOException $e)
		{
			try {
				include_once $_SERVER['DOCUMENT_ROOT'] . "/database/config.php";
				$db = new PDO("mysql:host=$r_server", $r_user, $r_passwd);
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}
			catch (PDOException $e)
			{
				echo 'Error 03: ' . $e->getMessage();
				exit (0);
			}
				$default = '/img/default.gif';
				if (!($db->exec("CREATE DATABASE `$r_db`")))
					return (0);
				else
				{
					$db->exec("CREATE TABLE `$r_db`.`users` ( `id` INT NOT NULL AUTO_INCREMENT , `login` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , `pass` VARCHAR(255) NOT NULL , `level` INT NULL DEFAULT '0' , `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, `mail` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE iutf8mb4_unicode_ci NOT NULL , `image` VARCHAR(255) NOT NULL DEFAULT '$default' , UNIQUE (`id`), UNIQUE (`login`), UNIQUE (`mail`)) ENGINE = InnoDB;");
					$db->exec("CREATE TABLE `$r_db`.`images` ( `id` INT NOT NULL AUTO_INCREMENT , `user_id` INT NOT NULL , `likes` INT NULL DEFAULT NULL , `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, `state` INT NULL DEFAULT NULL, `path` LONGTEXT NOT NULL , `desc` LONGTEXT NULL DEFAULT NULL , PRIMARY KEY (`id`), UNIQUE (`id`)) ENGINE = InnoDB;");
					$db->exec("INSERT INTO `$r_db`.`images` (`user_id`, `state`, `path`, `desc`) VALUES ('1', 3, '/images/02.jpg', 'Exemple de description'), ('1', 3, '/images/01.jpg', 'Description de la deuxième image témoin.')");
					$u_passwd = hash('whirlpool', $r_passwd);
					$db->exec("INSERT INTO `$r_db`.`users`(`login`, `pass`, `level`, `mail`) VALUES ('admin','$u_passwd',3,'admin@admin.fr')");
					$db->exec("CREATE TABLE `$r_db`.`comms` ( `id` INT NOT NULL AUTO_INCREMENT , `user_id` INT NOT NULL, `img_id` INT NOT NULL , `text` LONGTEXT CHARACTER SET utf8mb4 COLLATE iutf8mb4_unicode_ci NOT NULL , `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (`id`), UNIQUE (`id`)) ENGINE = InnoDB;");
					$db->exec("INSERT INTO `$r_db`.`comms` (`id`, `user_id`, `img_id`, `text`, `date`) VALUES ('1', '1', '1', 'Voici un bon exemple de commentaire !', CURRENT_TIMESTAMP), ('2', '1', '1', 'Et un deuxième pour la route !', CURRENT_TIMESTAMP)");
				}
			if (isset($_SESSION))
			{
				session_destroy();
				unset($_SESSION);
			}
		}
		return ($db);
	}
	return (0);
}
?>
