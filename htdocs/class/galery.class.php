<?php

require_once __DIR__.'/../database/libdb.php';

class Galery
{
	public $id;
	public $user_id;
	public $likes;
	public $date;
	public $level;
	public $state;
	public $current;
	public $i_coms;

	public function export()
	{
	}

	public function newGal()
	{
		if (!($db = db_conn()))
			header('Location: /');
		try {
			$stmt = $db->prepare("SELECT * FROM images INNER JOIN users ON images.user_id = users.id ORDER BY images.id DESC");
			$stmt->execute();
			$data = $stmt->fetchAll();
			if (isset($data))
			{
				$this->current = $data;
			}
			return ($this->current);
		}
		catch (PDOException $e)
		{
			echo 'Error 08: ' . $e->getMessage();
		}
		return (0);
	}

	public function getComs($i_id)
	{
		if (!($db = db_conn()))
			header('Location: /');
		try {
			$stmt = $db->prepare("SELECT * FROM comms INNER JOIN users ON comms.user_id = users.id WHERE comms.img_id = :i_id ORDER BY comms.date DESC");
			$stmt->execute(array(':i_id' => $i_id));
			$data = $stmt->fetchAll();
			if (isset($data))
			{
				$this->i_coms = $data;
			}
			return ($this->i_coms);
		}
		catch (PDOException $e)
		{
			echo 'Error 09: ' . $e->getMessage();
		}
		return (0);
	}

	public function newCom($u_id, $i_id, $com)
	{
		if (!($db = db_conn()))
			header('Location: /');
		try {
			$stmt = $db->prepare("INSERT INTO `comms` (`user_id`, `img_id`, `text`) VALUES (:u_id, :i_id, :com)");
			$stmt->execute(array('u_id' => $u_id, ':i_id' => $i_id, ':com' => $com));
		}
		catch (PDOException $e)
		{
			echo 'Error 16: ' . $e->getMessage();
			exit();
		}
		return (0);
	}

	public function newUserGal($user_log)
	{
		if (!($db = db_conn()))
			header('Location: /');
		try {
			$stmt = $db->prepare("SELECT * FROM images INNER JOIN users ON images.user_id = users.id WHERE login = :user_log ORDER BY images.id DESC");
			$stmt->execute(array(':user_log' => $user_log));
			$data = $stmt->fetchAll();
			if (isset($data))
			{
				$this->current = $data;
			}
			return ($this->current);
		}
		catch (PDOException $e)
		{
			echo 'Error 08: ' . $e->getMessage();
		}
		return (0);
	}

	public function newImage($u_id, $i_desc, $i_path)
	{
		if (!($db = db_conn()))
			header('Location: /');
		try {
			$stmt = $db->prepare("INSERT INTO `images` (`user_id`, `state`, `path`, `desc`) VALUES (:u_id, '3', :i_path, :i_desc)");
			$stmt->execute(array(':u_id' => $u_id, ':i_path' => $i_path, ':i_desc' => $i_desc));
		}
		catch (PDOException $e)
		{
			echo 'Error 14: ' . $e->getMessage();
		}
	}

	public function countImg($u_id)
	{
		if (!($db = db_conn()))
			header('Location: /');
		try {
			$stmt = $db->prepare("SELECT * FROM images WHERE user_id = :u_id");
			$stmt->execute(array(':u_id' => $u_id));
			$data = $stmt->fetchAll();
			if (isset($data) && !empty($data))
			{
				$off = count($data) - 1;
				$off = $off < 0 ? 0 : $off;
				$nbr = $data[$off]['id'];
				return ($nbr);
			}
		}
		catch (PDOException $e)
		{
			echo 'Error 15: ' . $e->getMessage();
		}
		return (0);
	}
}
