<?php
	require_once __DIR__.'/../class/user.class.php';
	session_start();
	$user = NULL;
	$u_err = 0;
	$link = $_SERVER['REQUEST_URI'];
	if (isset($_SESSION['login']))
	{
		$user = new User();
		$user->setUser();
	}
	else if (isset($_POST['login']) && isset($_POST['passwd']) && !empty($_POST['passwd']) && !empty($_POST['login']))
	{
		$user = new User();
		$u_err = $user->logIn($_POST['login'], $_POST['passwd']);
		$u_err === -1 ? $user = -1 : 0;
	}
?>
	<script>
		function openLogin()
		{
			let form = document.getElementById('form.login');
			let other = document.getElementById('signup');
			console.log(form);
			if (form.style.opacity == 0)
			{
				form.style.opacity = 1;
				form.style.display = 'block';
				other.style.display = 'none';
				other.style.opacity = 0;
			}
			else
			{
				form.style.opacity = 0;
				form.style.display = 'none';
			}
		}
		function openSignup()
		{
			let form = document.getElementById('signup');
			let other = document.getElementById('form.login');
			console.log(form);
			if (form.style.opacity == 0)
			{
				form.style.opacity = 1;
				form.style.display = 'block';
				other.style.display = 'none';
				other.style.opacity = 0;
			}
			else
			{
				form.style.opacity = 0;
				form.style.display = 'none';
			}
		}
	</script>
	<div id="signup"
	<?php
	if ((!isset($_POST['submit']) || $_POST['submit'] !== 'signup') && (!isset($_POST['signin'])))
		echo 'style="opacity: 0; display: none;'
	?>
	">
	<div class="bg" onclick="openSignup()"></div>
	<form enctype="multipart/form-data" method="POST" action="/includes/signup.php" >
		<h1>SignUp</h1>
<?php 
		if(isset($_POST['signin']))
			echo '<p style="color:red">' . $_POST['signin'] . '</p>';
		?>
		Username : <input type="text" id="bform.signup" name="login" placeholder="Your login" required />
		Password : <input type="password" name="passwd" placeholder="Your password" required />
		E-Mail : <input type="text" name="mail" placeholder="Your mail adress" required />
		Avatar : <input type="file" name="img" />
		<button name="submit" value="signup">SignUp</button>
	</form>
	</div>
	<header>
		<div id="title">
			<h3><span style="font-size:40px;">PhotoBOMB!</span><br/>The website</h3>
			<h1>Camagru</h1>
		</div>
		<nav>
			<div id="menu">
			<a href="/">Home</a>
			<a href="/?snap">Snap</a>
			<a href="/?users">Users</a>
			</div>
			<div id="log">
			<?php
				if (!isset($_SESSION['login']))
				{
					echo '<form method="POST" ';
					if ((!isset($_POST['submit']) || $_POST['submit'] !== 'login') && $u_err < 1)
						echo 'style="opacity: 0; display: none;" ';
					echo 'action="'.$link.'" id="form.login" >
					<input type="text" name="login" placeholder="Your login"';
					if ($u_err === -1)
						echo 'style="background:crimson;color:white" ';
					echo '/>
					<input type="password" name="passwd" placeholder="Your password"';
					if ($u_err === -1)
						echo 'style="background:crimson;color:white" ';
					echo '/>
					<button name="submit" value="login">LogIn</button>
					</form>
					<a onclick="openLogin()">LogIn</a>
					<a onclick="openSignup()">SignUp</a>';
				}
				else
				{
					echo	'<a href="#">'.$_SESSION['login'].'</a>';
					if (isset($_SESSION['user_data']['level']) && $_SESSION['user_data']['level'] === '3')
						echo '<a href="#">Administration</a>';
					echo	'<a href="/?disconnect">LogOut</a>';
				}
			?>
			</div>
		</nav>
	</header>
