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
			$db = new PDO("mysql:host=$r_server;dbname=$r_db", $r_user, $r_passwd);
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
				echo 'Error 03:' . $e->getMessage();
			}
				if (!($db->exec("CREATE DATABASE `$r_db`")))
					return (0);
				else
				{
					$db->exec("CREATE TABLE `$r_db`.`users` ( `id` INT NOT NULL AUTO_INCREMENT , `login` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , `pass` VARCHAR(255) NOT NULL , `level` INT NULL DEFAULT NULL , `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, `mail` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , UNIQUE (`id`), UNIQUE (`login`), UNIQUE (`mail`)) ENGINE = InnoDB;");
					$db->exec("CREATE TABLE `$r_db`.`images` ( `id` INT NOT NULL AUTO_INCREMENT , `user_id` INT NOT NULL , `likes` INT NULL DEFAULT NULL , `date` DATE NOT NULL, `state` INT NULL DEFAULT NULL , PRIMARY KEY (`user_id`, `date`), UNIQUE (`id`)) ENGINE = InnoDB;");
					$u_passwd = hash('whirlpool', $r_passwd);
					$db->exec("INSERT INTO `$r_db`.`users`(`login`, `pass`, `level`, `mail`) VALUES ('admin','$u_passwd',3,'admin@admin.fr')");
				}
		}
		return ($db);
	}
	return (0);
}
?>
