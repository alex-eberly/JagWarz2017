<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/assets/classes/core.php"; ?>
<?php
    session_start();
	// set the expiration date to one hour ago
	setcookie($systemName . "_Admin", '', time()-3600, '/', $systemUrl);
	session_destroy();
	//send back to login page
	header('Location: /admin/');
?>