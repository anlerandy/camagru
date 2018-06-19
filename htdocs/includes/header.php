<?php
	require_once __DIR__.'/../class/user.class.php';
	session_start();
	$link = $_SERVER['REQUEST_URI'];
	if (isset($_POST['login']) && isset($_POST['passwd']) && !empty($_POST['passwd']) && !empty($_POST['login']))
	{
		$user = new User();
		$user->logIn($_POST['login'], $_POST['passwd']);
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
	<div id="signup" style="opacity: 0; display: none;">
	<div class="bg" onclick="openSignup()"></div>
	<form method="POST" action="<?=$link?>" >
		<h1>SignUp</h1>
		Username : <input type="text" id="bform.signup" name="login" placeholder="Your login" />
		Password : <input type="password" name="passwd" placeholder="Your password" />
		E-Mail : <input type="text" name="mail" placeholder="Your mail adress" />
		<button>SignUp</button>
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
					echo '<form method="POST" style="opacity: 0; display: none;" action="'.$link.'" id="form.login" >
					<input type="text" name="login" placeholder="Your login" />
					<input type="password" name="passwd" placeholder="Your password" />
					<button>LogIn</button>
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
