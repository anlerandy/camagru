<?php
	if (isset($_SESSION) && isset($_SESSION['user_data']))
	{
		if ($_SESSION['user_data']['level'] == 3)
		{
			$user = new User();
		}
		else
			echo "You're not allowed to be here.";
	}
	else
		echo "You're not allowed to be here.";
	if ($user)
	{
?>

<center>
<div id="adminPanel">
	<div class="sidenav">
		<ul>
			<li><a>TEST</a></li>
			<li><a>TEST</a></li>
			<li><a>TEST</a></li>
		</ul>
	</div>
</div>
</center>

<?php
	}
?>
