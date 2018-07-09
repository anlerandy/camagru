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
	public $img_info;

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
			echo 'Error 05: ' . $e->getMessage();
		}
		return (0);
	}

	public function newUserGal($user_id)
	{
	}

	public function getInfo($g_img)
	{
		
	}
}
