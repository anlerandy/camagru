<?php
require_once 'libdb.php';
if (!isset($_POST['r_server']) || !isset($_POST['r_user']) || !isset($_POST['r_passwd']) || !isset($_POST['r_db']) || empty($_POST['r_server']) || empty($_POST['r_user']) || empty($_POST['r_passwd']) || empty($_POST['r_db']))
	header('Location: /');
else
{
	if (!file_exists(__DIR__ . "/config.php"))
		touch(__DIR__ . "/config.php");
	if (db_conn_test($_POST['r_server'], $_POST['r_user'], $_POST['r_passwd']))
		if (file_put_contents(__DIR__ . "/config.php", "<?php\n\$r_server = '" . $_POST['r_server'] . "';\n\$r_user = '" . $_POST['r_user'] . "';\n\$r_passwd = '" . $_POST['r_passwd'] . "';\n\$r_db ='" . $_POST['r_db'] . "';\n?>"))
			header('Location: /');
	else
		echo "Error while writing config.ini";
}
?>
