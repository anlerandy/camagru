<?php

function snapLogIn($user, $link)
{
	echo '
	<div class="logon" style="z-index:1;">
	<form method="POST" action="'.$link.'" >
		<h1>Connection</h1>
		<p>You need to be connected to access this page.</p>
		Username : <input autocomplete="username" type="text" id="bform.login" name="login" placeholder="Your login"';
	if ($user === -1)
		echo 'style="background:crimson;color:white" ';
	echo '/>
		Password : <input autocomplete=\'current-password\'  type="password" name="passwd" placeholder="Your password"';
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
?>
		<h1>SnapThat</h1>
		<div id="snapContainer">
			<div class="webcam">
				<img style="display:none;" id="preview" class="imgFilt" />
				<video autoplay="true" id="videoElement">
				</video>
				<img id="image" style="display:none;" class="imgElement" />
				<img id="tmp" style="display:none;" class="imgTmp" />
				<center>
					<button onclick="shot()" id="shot">Take a shot!</button>
					<input id="byFile" type='file' accept=".png, .jpg, .gif" onchange="readURL(this);"/>
					<button onclick="retry()" id="retry" style="display:none;">Another</button>
				</center>
			</div>
			<div id="set">
				<div class="publish" style="display:none;">
					<h1>Publish this one!</h1>
					<form method="POST" action="/includes/newImage.php">
						<input id="img" name="img" type="hidden" />
						<center>
						<textarea type="text" name="desc" placeholder="Title or description here." ></textarea>
						<div>
							<button type="submit">Publish</button>
						</div>
						</center>
					<form>
				</div>
				<div class="filter">
					<form>
						<fieldset class="filtField">
						<legend>Choose your filter :</legend>
							<input onchange="changeBg()" type="radio" name="filt" value="1" id="rain" checked/>
							<label for="rain" class="labeled"><img src="/img/filter/01.png" />Rain</label>
							<input onchange="changeBg()" type="radio" name="filt" value="2" id="drop" />
							<label for="drop" class="labeled"><img src="/img/filter/02.png" />Drop</label>
							<input onchange="changeBg()" type="radio" name="filt" value="3" id="glitter" />
							<label for="glitter" class="labeled"><img src="/img/filter/03.png" />Glitter</label>
							<input onchange="changeBg()" type="radio" name="filt" value="4" id="broke" />
							<label for="broke" class="labeled"><img src="/img/filter/04.png" />Broke</label>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	<script src="../libs/webcam.js" type="text/javascript"></script>
<?php
	}
}
?>
