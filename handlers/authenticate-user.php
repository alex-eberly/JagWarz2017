<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/assets/classes/core.php"; ?>
<?php 
$username = "";
$userpassword = "";
if (isset($_POST["username"])) 
{
	$username = $_POST["username"];
}
if (isset($_POST["password"])) 
{
	$userpassword = $_POST["password"];
}
$UserFactory = new UserFactory();
$UserArray = $UserFactory->GetAll(" where Username = '" . escapeString($username) . "' and password = '" . md5(utf8_encode($userpassword)) . "' and IsActive = 1");
if (count($UserArray) > 0)
{ 
	foreach ($UserArray as &$value)
	{
		$_SESSION['UserId'] = $value->UserId;
        $_SESSION['Firstname'] = $value->Firstname;
        $_SESSION['Lastname'] = $value->Lastname;
        $_SESSION['Email'] = $value->Email;
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
		setcookie($systemName, $username, $expire, '/', $systemUrl);		
		echo "<script type=\"text/javascript\">window.location='".$fullUrl."dashboard.php';</script>";
	}
}
else
{
	$AuthenticationLogFactory = new AuthenticationLogFactory();
    $AuthenticationLog = new AuthenticationLog();
	$AuthenticationLog->Username = $username;
	$AuthenticationLog->IpAddress = getClientIP();
	$AuthenticationLog->Successful = 0;
	$timestamp = time();
	$AuthenticationLog->DateCreated = gmdate("Y-m-d H:i:s", $timestamp);
	$AuthenticationLogFactory->Insert($AuthenticationLog);
	echo "<div class=\"alert alert-danger\">Username/Password incorrect!</div>";
}
unset($value);
?>