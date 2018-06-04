<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/assets/classes/core.php"; ?>
<?php 
$email = "";
$userpassword = "";
if (isset($_POST["email"])) 
{
	$email = $_POST["email"];
}
if (isset($_POST["password"])) 
{
	$userpassword = $_POST["password"];
}
$AdminUserFactory = new AdminUserFactory();
$AdminUserArray = $AdminUserFactory->GetAll(" where username = '" . escapeString($email) . "' and password = '" . md5(utf8_encode($userpassword)) . "'");
if (count($AdminUserArray) > 0)
{ 
	foreach ($AdminUserArray as &$value)
	{
		$_SESSION['AdminUserId'] = $value->AdminUserId;
        $_SESSION['Username'] = $value->Username;
        //log user authentication
        $LogAuthenticationFactory = new LogAuthenticationFactory();
        $LogAuthentication = new LogAuthentication();
		$LogAuthentication->Username = $value->Username;
		$LogAuthentication->IpAddress = getClientIP();
		$LogAuthentication->Successful = 1;
		$timestamp = time();
		$LogAuthentication->DateCreated = gmdate("Y-m-d H:i:s", $timestamp);
		$LogAuthenticationFactory->Insert($LogAuthentication);
		//setup a cookie for this user
		$expire=time()+60*60*24*30; //(60 sec * 60 min * 24 hours * 30 days).
		setcookie($systemName . "_Admin", $username, $expire, '/', $systemUrl);		
		echo "<script type=\"text/javascript\">window.location='".$fullUrl."admin/dashboard.php';</script>";
	}
}
else
{
	$AuthenticationLogFactory = new AuthenticationLogFactory();
    $AuthenticationLog = new AuthenticationLog();
	$AuthenticationLog->Username = $email;
	$AuthenticationLog->IpAddress = getClientIP();
	$AuthenticationLog->Successful = 0;
	$timestamp = time();
	$AuthenticationLog->DateCreated = gmdate("Y-m-d H:i:s", $timestamp);
	$AuthenticationLogFactory->Insert($AuthenticationLog);
	echo "<div class=\"alert alert-danger\">Username/Password incorrect!</div>";
}
unset($value);
?>