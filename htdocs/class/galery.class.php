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
			$stmt = $db->prepare("SELECT * FROM images INNER JOIN users ON images.user_id = users.id");
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
			$stmt = $db->prepare("SELECT * FROM comms INNER JOIN users ON comms.user_id = users.id WHERE comms.img_id = :i_id");
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

	public function newUserGal($user_id)
	{
		if (!($db = db_conn()))
			header('Location: /');
		try {
			$stmt = $db->prepare("SELECT * FROM images INNER JOIN users ON images.user_id = users.id WHERE images.user_id = :user_id");
			$stmt->execute(array(':user_id' => $user_id));
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
}
