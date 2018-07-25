<?php
	require_once __DIR__.'/../class/galery.class.php';
function printUsers() {
	$u_pageInst = new User();
	$allUser = $u_pageInst->getAll();
	echo '<div id="users">';
	foreach ($allUser as $uId)
	{
		if (!file_exists(__DIR__ . '/../' . $uId['image']))
		{
			$uId['image'] = '/img/default.gif';
		}
	?>
		<a style="border-radius:15px;margin:12px;background: url('<?= $uId['image']?>') center center no-repeat; background-size:cover" href="/?users=<?=$uId['login']?>">
		<div style="width:250px;height:250px;position:relative;padding:0;">
			<p style="background:RGBA(255,255,255,0.7);width:100%;position:absolute;bottom:-18px;border-radius:0 0 15px 15px;"><span class="blaze" ><?= $uId['login']?></span></p>
		</div>
		</a>
	<?php
	}
	echo '</div>';
}

function printAdmUsers() {
	$u_pageInst = new User();
	$allUser = $u_pageInst->getAll();
	echo '<div id="users">';
	foreach ($allUser as $uId)
	{
		if (!file_exists(__DIR__ . '/../' . $uId['image']))
		{
			$uId['image'] = '/img/default.gif';
		}
	?>
		<a style="border-radius:15px;margin:12px;background: url('<?= $uId['image']?>') center center no-repeat; background-size:cover" href="?admin=users&login=<?=$uId['login']?>">
		<div style="width:250px;height:250px;position:relative;padding:0;">
			<p style="background:RGBA(255,255,255,0.7);width:100%;position:absolute;bottom:-18px;border-radius:0 0 15px 15px;">
				<span class="blaze" ><?= $uId['login']?></span>
			</p>
		</div>
		</a>
	<?php
	}
	echo '</div>';
}

function printOwnUser($u_login, $u_id) {
	$u_page = new User();
	$u_info = $u_page->getUserInfo($u_login);
	if (isset($_POST))
	{
		if (isset($_POST['err']))
		{
			$errP = 1;
		}
		if (isset($_POST['udelete']))
		{
			$u_page->delUser($u_info['login'], $u_info['id']);
			header('location: /?disconnect');
		}
		if (isset($_POST['delete']))
		{
			$img = new Galery();
			$img->deleteImg($_POST['delete']);
			header('location: /?profil');
		}
		if (isset($_POST['update']))
		{
			$path = '/images/users/'.$_POST['login'].'.jpg';
			$imgDir = __DIR__.'/../images/users/'.$_POST['login'].'.jpg';
			if (isset($_FILES) && !empty($_FILES) && !empty($_FILES['img']['name']))
			{
				try {
					echo "Téléchargement de l'image!\n";
					move_uploaded_file($_FILES['img']['tmp_name'], $imgDir);
					} catch (PDOException $e)
					{
						echo "Echec de téléversement de votre image.";
						$path = null;
						$imgDir = null;
					}
			}
			else
			{
				$path = null;
				$imgDir = null;
			}
			if ((!$u_page->exist($_POST['login'], null) || $_POST['login'] == $u_info['login'])
				&& (!$u_page->exist(null, $_POST['mail']) || $_POST['mail'] == $u_info['mail']))
			{
				$u_info = $u_page->getUserInfo($u_info['login']);
				if (($u_info['level'] == 2 || $u_info['level'] == 4) && $_POST['notif'] == 0)
					$u_info['level'] = $u_info['level'] - 1;
				else if (($u_info['level'] <= 1 || $u_info['level'] == 3) && $_POST['notif'] == 1)
					$u_info['level'] = $u_info['level'] + 1;
				$u_page->updateUser($u_info['id'], $_POST['login'], $u_info['level'], $_POST['mail'], $path);
				if ($_SESSION['user_data']['id'] == $u_info['id'])
				{
					$_SESSION['user_data'] = $u_page->getUserInfo($_POST['login']);
					$_SESSION['login'] = $_POST['login'];
				}
				if (!empty($_POST['oPass']) && !empty($_POST['nPass']) && !empty($_POST['cPass']))
				{
					if (hash('whirlpool', $_POST['oPass']) === $u_info['pass'])
					{
						if ($_POST['nPass'] === $_POST['cPass'])
							$u_page->updatePass($_POST['nPass'], $_POST['login']);
						else
							$erro = 1;
					}
					else
					{
						$erro = 1;
					}
					if (isset($erro))
					{
?>
					<body onload="document.fPass.submit()">
						<form method="POST" action="/?profil" name="fPass">
							<input type="hidden" name="err" />
						</form>
					</body>
<?php
					}
				}
				isset($erro) ? 0 : header('location: /?profil');
			}
			else
				$err = 1;
		}
	}
?>


<div id="delete" style="opacity: 0; display: none;">
	<div class="bg" onclick="openDelete()"></div>
		<form method="POST" action="/?profil" >
			<h1>Delete <?= $u_info['login'] ?></h1>
			You're about to delete your account.
			<br/>Are your sure ?
			<br/>
			<br/>
			<button name="udelete" value="<?=$u_info['login']?>">Proceed</button>
			<button name="cancel" >Cancel</button>
		</form>
</div>

<div id="UserContainer" >
	<?php if (isset($err)) { ?><h2>Erreur durant l'update...</h2><?php } ?>
	<form enctype="multipart/form-data" method="POST" action="/?profil" >
		<div class="Userprofil">
			<div>
				<input type="file" style="display:none;" name="img" id="upImg" />
				<label for="upImg"><img src="<?=$u_info['image'] ?>" class="aImg"  /></label>
			</div>
			<div style="flex-basis:80%;padding:15px" >
				<div style="flex-basis:80%;">
					<input size="10" type="text" name="login" class="aUserName" id="aUserName" value="<?= $u_info['login'] ?>" />
					<label for="aUserName">
					<img width="50px" src="http://<?= $_SERVER['HTTP_HOST']?>/img/edit.png" />
					</label>
				</div>
				<div style="flex-basis:80%;">
					<input size="10" type="text" name="mail" class="aUserMail" id="aUserMail" value="<?= $u_info['mail'] ?>" />
					<label for="aUserMail">
						<img width="25px" src="http://<?= $_SERVER['HTTP_HOST']?>/img/edit.png" />
					</label>
				</div>
				<div style="flex-basis:80%;">
					<fieldset>
						<legend>Receive e-mail notification ?</legend>
						<input <?php if ($u_info['level'] == 2 || $u_info['level'] == 4) echo "checked" ?> type="radio" name="notif" value="1" id="yes" />
						<label for="yes">Yes</label>
						<input <?php if ($u_info['level'] <= 1 || $u_info['level'] == 3) echo "checked" ?> type="radio" name="notif" value="0" id="no" />
						<label for="no">No</label>
					</fieldset>
				<div style="flex-basis:80%;display:flex;flex-direction:column;justify-content:center;">
				<input <?php if (isset($errP)) echo 'style="background:firebrick;"';?> type="password" name="oPass" class="aUserPass" placeholder="Old password" />
					<input <?php if (isset($errP)) echo 'style="background:firebrick;"';?> type="password" name="nPass" class="aUserPass" placeholder="New password" />
					<input <?php if (isset($errP)) echo 'style="background:firebrick;"';?> type="password" name="cPass" class="aUserPass" placeholder="Confirm password" />
				</div>
					<div class="aBtn">
						<input type="submit" name="update" value="update" />
						<a onclick="openDelete()">Delete my account</a>
					</div>
				</div>
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
	printOwnGalery($u_login);
}
?>
