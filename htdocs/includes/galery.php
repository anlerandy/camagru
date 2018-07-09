<?php
	require_once __DIR__.'/../class/galery.class.php';
function printGalery($id) {
	$gal = new Galery();

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
<div id="templateContainer">
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
		<h3>Comments</h3>
		<div class="comContainer">';
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
	else
		echo "404 NOT FOUND";
}
?>
