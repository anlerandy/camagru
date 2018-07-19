<?php
	require_once __DIR__.'/../users.php';
function get_data($url) {
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch, CURLOPT_URL, $url);
	$userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)';
	curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}

	if (isset($_SESSION) && isset($_SESSION['user_data']))
	{
		if ($_SESSION['user_data']['level'] == 3)
		{
			$user = new User();
		}
		else
		{
			echo "You're not allowed to be here.\n";
			exit();
		}
	}
	else
	{
		echo "You're not allowed to be here.\n";
		exit();
	}
	if ($user && isset($_POST))
	{
		if (isset($_POST['update']))
		{
			$path = '/images/users/'.$_POST['login'].'.jpg';
			$imgDir = __DIR__.'/../../images/users/'.$_POST['login'].'.jpg';
			if (isset($_FILES) && !empty($_FILES) && !empty($_FILES['img']['name']))
			{
				try {
					echo "Téléchargement de l'image!\n";
					move_uploaded_file($_FILES['img']['tmp_name'], $imgDir);
					} catch (PDOException $e)
					{
						echo "Echec de téléversement de votre image.";
					}
			}
			else
			{
				$path = null;
				$imgDir = null;
			}
			if (!$user->exist($_POST['login'], null) || $_POST['login'] == $_GET['login'])
			{
				$u_info = $user->getUserInfo($_GET['login']);
				$_POST['level'] = $_POST['level'] == 0 ? 3 + $_POST['notif'] : $_POST['level'] + $_POST['notif'];
				$user->updateUser($u_info['id'], $_POST['login'], $_POST['level'], null, $path);
				if ($_SESSION['user_data']['id'] == $u_info['id'])
				{
					$_SESSION['user_data'] = $user->getUserInfo($_POST['login']);
					$_SESSION['login'] = $_POST['login'];
				}
				header('location: /?admin=users&login='.$_POST['login']);
			}
			else
				$err = 1;
		}
		if (isset($_POST['delete']))
		{
			$delUser = $user->getUserInfo($_POST['delete']);
			$user->delUser($_POST['delete'], $delUser['id']);
			header('location: /?admin=users');
		}
	}
	if ($user)
	{
?>

<center>
<h1> Administration panel </h1>
<div id="adminPanel">
	<div class="sidenav">
		<a href='?admin'>Logs</a>
		<a href='?admin=users'>Users</a>
		<a>Photos</a>
		<hr/>
	</div>
<?php
	if ($_GET['admin'] == 'users')
	{
		if (isset($_GET['login']) && $user->exist($_GET['login'], 0))
		{
			if (($u_info = $user->getUserInfo($_GET['login'])))
			{
			//	print_r($u_info);
?>

<div id="delete" style="opacity: 0; display: none;">
	<div class="bg" onclick="openDelete()"></div>
		<form method="POST" action="<?= $_SERVER['HTTP_REFERER']?>&login=<?=$u_info['login']?>" >
			<h1>Delete <?= $u_info['login'] ?></h1>
			You're about to delete <?= $u_info['login'] ?>.
			<br/>Are your sure ?
			<br/>
			<button name="delete" value="<?=$u_info['login']?>">Proceed</button>
			<button name="cancel" >Cancel</button>
		</form>
</div>

<div id="aUserContainer" >
	<form enctype="multipart/form-data" method="POST" action="<?= $_SERVER['HTTP_REFERER']?>&login=<?=$u_info['login']?>" >
		<div class="aUserprofil">
			<input type="file" style="display:none;" name="img" id="upImg" />
			<label for="upImg"><img src="<?=$u_info['image'] ?>" class="aImg"  /></label>
			<h1><input type="text" name="login" class="aUserName" value="<?= $u_info['login'] ?>" /></h1>
			<img width="50px" src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/67/Feedbin-Icon-home-edit.svg/2000px-Feedbin-Icon-home-edit.svg.png" />
		</div>
		<div class="aUserField">
			<div style="display:flex;">
				<fieldset <?php if ($u_info['id'] == 1) echo "disabled" ?> >
					<legend>User level</legend>
					<input <?php if ($u_info['level'] <= 2) echo "checked" ?> type="radio" name="level" value="1" id="1" />
					<label for="1">User</label>
					<input <?php if ($u_info['level'] >= 3) echo "checked" ?> type="radio" name="level" value="3" id="3" />
					<label for="3">Admin</label>
				</fieldset>
				<fieldset>
					<legend>Receive e-mail notification ?</legend>
					<input <?php if ($u_info['level'] == 2 || $u_info['level'] == 4) echo "checked" ?> type="radio" name="notif" value="1" id="yes" />
					<label for="yes">Yes</label>
					<input <?php if ($u_info['level'] <= 1 || $u_info['level'] == 3) echo "checked" ?> type="radio" name="notif" value="0" id="no" />
					<label for="no">No</label>
				</fieldset>
			</div>
			<div class="aBtn">
				<input type="submit" name="update" value="Update" />
				<a href="/?admin=users" >Cancel</a>
				<?php if ($_SESSION['user_data']['id'] != $u_info['id'] && $u_info['id'] != 1) {?><a onclick="openDelete()">Delete this user</a><?php } ?>
			</div>
		</div>
	</form>
</div>
<script>
	function openDelete()
	{
		let form = document.getElementById('delete');
		console.log(form);
		if (form.style.opacity == 0)
		{
			form.style.opacity = 1;
			form.style.display = 'block';
		}
		else
		{
			form.style.opacity = 0;
			form.style.display = 'none';
		}
	}
</script>

<?php
			}
			else
				echo 'Wait for it...';
		}
		else
			printAdmUsers();
	}
	else
	{
		echo "<h1> Log </h1>";
		$tab = json_decode(get_data('https://api.github.com/repos/anlerandy/camagru/commits'), true);
		foreach($tab as $comit)
		{
?>
	<p>
		<a target="_blank" href="<?= $comit['html_url'] ?>">
		<strong>
			<?= $comit['commit']['author']['date'] ?> :
		</strong>
		<?php echo $comit['commit']['message']; ?>
		</a>
	</p>
<?php
		}
	}
?>
</div>
</center>

<?php
	}
	else
		echo "Error 500";
?>
