<?php
	require_once __DIR__.'/../class/galery.class.php';
function printUsers() {
	$userInst = new User();
	$allUser = $userInst->getAll();
	echo '<div id="users">';
	foreach ($allUser as $uId)
	{
		if (!file_exists(__DIR__ . '/../' . $uId['image']))
		{
			$uId['image'] = '/img/default.gif';
		}
		echo '
			<a style="border-radius:15px;margin:12px;background: url(\'' . $uId['image'] . '\') center center no-repeat; background-size:cover" href="/?users=' . $uId['login'] .'">
			<div style="width:250px;height:250px;position:relative;padding:0;">
				<p style="background:RGBA(255,255,255,0.7);width:100%;position:absolute;bottom:-20px;border-radius:0 0 15px 15px;"><span class="blaze" >' . $uId['login'] . '</span></p>
			</div>
			</a>';
	}
	echo '</div>';
}
?>
