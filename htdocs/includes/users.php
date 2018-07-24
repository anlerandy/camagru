<?php
	require_once __DIR__.'/../class/galery.class.php';
function printUsers() {
	$userInst = new User();
	$allUser = $userInst->getAll();
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
	$userInst = new User();
	$allUser = $userInst->getAll();
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
?>

<div id="UserContainer" >
	<form enctype="multipart/form-data" method="POST" action="/?profil" >
		<div class="Userprofil">
			<div>
				<input type="file" style="display:none;" name="img" id="upImg" />
				<label for="upImg"><img src="<?=$u_info['image'] ?>" class="aImg"  /></label>
			</div>
			<div style="flex-basis:80%;" >
				<div style="flex-basis:80%;">
					<input size="10" type="text" name="login" class="aUserName" id="aUserName" value="<?= $u_info['login'] ?>" />
					<label for="aUserName">
						<img width="50px" src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/67/Feedbin-Icon-home-edit.svg/2000px-Feedbin-Icon-home-edit.svg.png" />
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
					<div class="aBtn">
						<input type="submit" name="update" value="Update" />
						<a onclick="openDelete()">Delete my account</a>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<?php
	printOwnGalery($u_login);
}
?>
