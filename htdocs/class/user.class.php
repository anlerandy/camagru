<?php

require_once __DIR__.'/../database/libdb.php';

class User
{
	public $id;
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

	public function newUser($u_login, $u_passwd, $u_mail)
	{
		$u_passwd = hash('whirlpool', $u_passwd);
		if (!($db = db_conn()))
			header('Location: /');
		if (!($db->exec("INSERT INTO `users` ('login', 'pass', 'mail') VALUES (`$u_login`, `$u_passwd`, `$u_mail`);")))
			header('Location: /');
	}
}

?>
