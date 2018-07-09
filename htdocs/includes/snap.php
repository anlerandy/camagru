<?php
function printSnap($user, $db)
{
	$link = $_SERVER['REQUEST_URI'];
	if (!isset($db))
	{
		echo "Error while trying to connect to the server.";
		exit (0);
	}
	if (!isset($user) || $user === -1)
	{
		echo '
	<div class="logon" style="z-index:1;">
	<form method="POST" action="'.$link.'" >
		<h1>Connection</h1>
		<p>You need to be connected to access this page.</p>
		Username : <input type="text" id="bform.signup" name="login" placeholder="Your login"';
		if ($user === -1)
			echo 'style="background:crimson;color:white" ';
		echo '/>
		Password : <input type="password" name="passwd" placeholder="Your password"';
		if ($user === -1)
			echo 'style="background:crimson;color:white" ';
		echo '/>
		<button name="submit" value="login">LogIn</button>
		<center>
		<br />
		<p>Or</p>
		<a style="padding:10px;border-radius:5px" onclick="openSignup()">SignUp</a>
		</center>
	</form>
	</div>';
	}
	else
	{
		echo '
		<div id="snapContainer" >
			<div class="webcam">
			</div>
		</div>';
	}
}
?>
