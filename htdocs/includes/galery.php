<?php
	require_once __DIR__.'/../class/galery.class.php';
	require_once __DIR__.'/../class/user.class.php';
function printGalery($id) {
	$gal = new Galery();
	$user = new User();

	$display = !$id ? $gal->newGal() : $gal->newUserGal($id);
	if (!empty($display))
	{
		if ($id)
			echo '<h1>' . $display[0]['login'] . '\'s galery</h1>';
		else
			echo '<h1>Galery</h1>';
		echo '<div style=";">';
	foreach ($display as $view)
	{
		echo '
<div class="templateContainer" id="' . $view[0] . '">
	<div id="imgContainer">
		<img src="' . $view['path'] . '" />
	</div>
	<div id="sidebar">
		<div class="author">
			<div style="display:flex;align-items:center;justify-content:center;">
				<img src="' . $view['image'] . '" />
				<h3>' . $view['login'] . '</h3>
			</div>
			<p>
				' . $view['desc'] . '
			</p>
		</div>
		<h3>Comments</h3>';
		if (isset($_SESSION) && isset($_SESSION['user_data']))
		{
			echo '<div class="comForm" style="width:100%">
				<form method="POST" action="/includes/newCom.php" style="display:flex;width:100%">
				<textarea required type="text" placeholder="Post a comment here..." name="com" style="resize:none;width:100%"></textarea>
				<input type="hidden" name="img" value="' . $view['0'] . '" />
				<button type="submit" style="margin:10px;border-radius:10px;">Send</button>
				</form>
			</div>';
		}
		echo '<div class="comContainer">';
		$coms = $gal->getComs($view['0']);
		foreach ($coms as $com)
		{
		echo '
			<div class="comment">
				<div class="comAuthor">
					<img src="' . $com['image'] . '"></img>
					<h4>' . $com['login'] . '</h4>
				</div>
				<p>
					' . $com['text'] . '
				</p>
			</div>
		';
		}
	echo '
		</div>
	</div>
</div>';
	}
	echo '</div>';
	}
	else if ($user->exist($id, 0))
		echo '<h1>' . $id . '\'s galery is empty!</h1>';
	else
		echo "<h1>No snaps yet...<center><br/><a href=\"/?snap\" >Be the first to post a snap!</a></center></h1>";
}

function printOwnGalery($u_login) {
	$gal = new Galery();
	$user = new User();
	$u_info = $user->getUserInfo($u_login);
	$display = $gal->newUserGal($u_login);

	if (!empty($display))
	{
?>
		<div>
			<h1>Your snaps</h1>
			<div id="oImgContainer">
				<?php foreach($display as $img) { ?>
				<div class="oImg" style="background: url('<?=$img['path']?>');background-size:cover" >
					<form action="/?profil" method="POST">
						<button type="hidden" name="delete" value="<?= $img['0']?>" id="img<?= $img['0']?>" />
						<label for="img<?=$img['0']?>"><img src="https://cdn3.iconfinder.com/data/icons/simple-web-navigation/165/cross-512.png" /></label>
					</form>
				</div>
			<?php } ?>
			</div>
		</div>
<?php
	}
	else if ($user->exist($u_login, 0))
		echo '<h1>You have no snaps yet.</h1>';
	else
		echo "404 NOT FOUND";
}

function printAllOwnGalery() {
	$gal = new Galery();
	$user = new User();
	$u_all = $user->getAll();
	$i = 0;

?>
	<h1>All snaps</h1>
	<div id="oImgContainer">
<?php
	foreach($u_all as $u_info)
	{
		$display = $gal->newUserGal($u_info['login']);
		if (!empty($display))
		{
			$i = $i + 1;
?>
				<?php foreach($display as $img) { ?>
				<div class="oImg" style="background: url('<?=$img['path']?>');background-size:cover" >
					<form action="/?admin=photos" method="POST">
						<button type="hidden" name="iDelete" value="<?= $img['0']?>" id="img<?= $img['0']?>" />
						<label for="img<?=$img['0']?>"><img src="https://cdn3.iconfinder.com/data/icons/simple-web-navigation/165/cross-512.png" /></label>
					</form>
				</div>
			<?php } ?>
<?php
		}
	}
	if ($i <= 0)
	{
?>
		<h2>No snaps yet..</h2>
<?php
	}
?>
	</div>
<?php
}
?>
