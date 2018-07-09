<?php
	require_once __DIR__.'/../class/galery.class.php';
function printGalery() {
	$gal = new Galery();

	$display = $gal->newGal();
	echo	'<h1>Galery</h1>
			 <div style="margin-bottom:54px;">';
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
		<div class="comContainer">
			<div class="comment">
				<div class="comAuthor">
					<img src="img/default.gif"></img>
					<h4>ComAuthor</h4>
				</div>
				<p>
					Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l\'imprimerie depuis les années 1500, quand un peintre anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. Il n\'a pas fait que survivre cinq siècles, mais s\'est aussi adapté à la bureautique informatique, sans que son contenu n\'en soit modifié. Il a été popularisé dans les années 1960 grâce à la vente de feuilles Letraset contenant des passages du Lorem Ipsum, et, plus récemment, par son inclusion dans des applications de mise en page de texte, comme Aldus PageMaker.
				</p>
			</div>
		</div>
	</div>
</div>';
	}
echo '</div>';
}
?>
