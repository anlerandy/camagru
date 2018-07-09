<?php
	require_once __DIR__.'/../class/galery.class.php';
function printUsers() {
	$userInst = new User();
	$allUser = $userInst->getAll();
	echo '<div style="display:flex;flex-wrap:wrap;margin-top:42px;margin-bottom:42px;">';
	foreach ($allUser as $uId)
	{
		echo '
			<div style="width:250px;margin:12px;">
			<form method="GET" action=' . $_SERVER['HTTP_REFERER'] . '>
			<input style="max-width:250px;" src="' . $uId['image'] . '" type="image" name="users" value="' . $uId['id'] . '" />
			<center>
			<p style="">' . $uId['login'] . '</p>
			</center>
			</input>
			</form>
			</div>';
	}
	echo '</div>';
}
?>
