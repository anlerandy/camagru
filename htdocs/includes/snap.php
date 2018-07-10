<?php

function snapLogIn($user, $link)
{
	echo '
	<div class="logon" style="z-index:1;">
	<form method="POST" action="'.$link.'" >
		<h1>Connection</h1>
		<p>You need to be connected to access this page.</p>
		Username : <input type="text" id="bform.login" name="login" placeholder="Your login"';
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
		snapLogIn($user, $link);
	}
	else
	{
		echo '
		<div id="snapContainer" >
			<div class="webcam" style="width:50%;">
				<video autoplay="true" id="videoElement">
				</video>
					<center>
						<button onclick="Shot()">Take a shot!</button>
					</center>
			</div>
		</div>
	<script src="../libs/webcam.js" type="text/javascript"></script>';
	}
}
?>
