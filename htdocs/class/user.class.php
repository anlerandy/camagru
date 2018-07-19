<?php

require_once __DIR__.'/../database/libdb.php';

class User
{
	public $id = 0;
	public $login;
	public $mail;
	public $level;
	public $data;

	public function export()
	{
		$_SESSION['user_data'] = $this->data;
		$_SESSION['login'] = $this->data['login'];
	}

	public function setUser()
	{
		$this->data = $_SESSION['user_data'];
		$this->set();
	}

	public function set()
	{
		$this->id = $this->data['id'];
		$this->login = $this->data['login'];
		$this->mail = $this->data['mail'];
		$this->level = $this->data['level'];
	}

	public function logIn($u_login, $u_passwd)
	{
		$u_passwd = hash('whirlpool', $u_passwd);
		if (!($db = db_conn()))
			header('Location: /');
		try {
			$stmt = $db->prepare("SELECT * FROM `users` WHERE `login` = :u_login AND `pass` = :u_passwd");
			if ($stmt->execute(array(':u_login' => $u_login, ':u_passwd' => $u_passwd)))
			{
				$data = $stmt->fetchAll();
				if (isset($data[0]))
				{
					$this->data = $data[0];
					$this->set();
					$this->export();
					return (1);
				}
			}
			return (-1);
		}
		catch (PDOException $e)
		{
			echo 'Error 04:' . $e->getMessage();
			exit (0);
		}
	}

	public function getUserInfo($u_login)
	{
		if (!($db = db_conn()))
			header('Location: /');
		try {
			$stmt = $db->prepare("SELECT * FROM `users` WHERE `login` = :u_login");
			if ($stmt->execute(array(':u_login' => $u_login)))
			{
				$data = $stmt->fetchAll();
				if (isset($data[0]))
				{
					return ($data[0]);
				}
			}
			return (0);
		}
		catch (PDOException $e)
		{
			echo 'Error 19:' . $e->getMessage();
			exit (0);
		}
	}

	public function exist($u_login, $u_mail)
	{
		try {
		if (!($db = db_conn()))
			header('Location: /');
		$stmt = $db->prepare("SELECT COUNT('login') FROM `users` WHERE `login` = :u_login");
		$stmt->execute(array(':u_login' => $u_login));
		if ($stmt->fetchColumn() == 1)
			return (1);
		$stmt = $db->prepare("SELECT COUNT('login') FROM `users` WHERE `mail` = :u_mail");
		$stmt->execute(array(':u_mail' => $u_mail));
		if ($stmt->fetchColumn() == 1)
			return (2);
		return (0);
		} catch (PDOException $e)
		{
			echo 'Error 06: ' . $e->getMessage();
		}
	}

	public function updateImg($u_img, $u_login)
	{
		if (!($db = db_conn()))
			header('Location: /');
		try {
			$stmt = $db->prepare("UPDATE users SET image = :u_img WHERE login = :u_login");
			$stmt->execute(array(':u_img' => $u_img, ':u_login' => $u_login));
		} catch (PDOException $e) {
			echo 'Error 07: ' . $e->getMessage();
		}
	}

	public function newUser($u_login, $u_passwd, $u_mail, $u_img)
	{
		$u_passwd = hash('whirlpool', $u_passwd);
		if (!($db = db_conn()))
			header('Location: /');
		try {
			$stmt = $db->prepare("INSERT INTO users (login, pass, mail) VALUES (:u_login, :u_passwd, :u_mail)");
			$stmt->execute(array(':u_login' => $u_login, ':u_passwd' => $u_passwd, ':u_mail' => $u_mail));
			if (isset($u_img))
			{
				$this->updateImg($u_img, $u_login);
			}
			return (1);
		}
		catch (PDOException $e)
		{
			echo 'Error 05: ' . $e->getMessage();
		}
		return (0);
	}

	public function updateUser($u_id, $u_login, $u_lvl, $u_mail, $u_img)
	{
		if (!($db = db_conn()))
			header('Location: /');
		try {
			$stmt = $db->prepare("UPDATE users SET login = :u_login, level = :u_lvl WHERE id = :u_id");
			$stmt->execute(array(':u_login' => $u_login, ':u_lvl' => $u_lvl, ':u_id' => $u_id));
			if (isset($u_mail))
			{
				$stmt = $db->prepare("UPDATE users SET mail = :u_mail WHERE login = :u_login");
				$stmt->execute(array(':u_mail' => $u_mail, ':u_login' => $u_login));
			}
			if (isset($u_img))
			{
				$this->updateImg($u_img, $u_login);
			}
			return (1);
		}
		catch (PDOException $e)
		{
			echo 'Error 05: ' . $e->getMessage();
			exit(0);
		}
		return (0);
	}

	public function delUser($u_login, $u_id)
	{
		if (!($db = db_conn()))
			header('Location: /');
		try {
			$stmt = $db->prepare("DELETE FROM images WHERE user_id = :u_id");
			$stmt->execute(array(':u_id' => $u_id));
			$stmt = $db->prepare("DELETE FROM comms WHERE user_id = :u_id");
			$stmt->execute(array(':u_id' => $u_id));
			$stmt = $db->prepare("DELETE FROM users WHERE login = :u_login");
			$stmt->execute(array(':u_login' => $u_login));
		}
		catch (PDOException $e)
		{
			echo 'Error 20: ' . $e->getMessage();
			exit (0);
		}
	}

	public function getAll()
	{
		if (!($db = db_conn()))
			header('Location: /');
		try {
			$stmt = $db->prepare("SELECT id, login, image FROM `users`");
			if ($stmt->execute())
			{
				$data = $stmt->fetchAll();
				if (isset($data))
				{
					return ($data);
				}
			}
			return (0);
		}
		catch (PDOException $e)
		{
			echo 'Error 10:' . $e->getMessage();
			exit (0);
		}
	}
}

?>
