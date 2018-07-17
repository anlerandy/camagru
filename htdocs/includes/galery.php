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
		echo '<div style="margin-bottom:54px;">';
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
				<textarea type="text" placeholder="Post a comment here..." name="com" style="resize:none;width:100%"></textarea>
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
		echo "404 NOT FOUND";
}
?>
