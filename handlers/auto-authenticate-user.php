<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/assets/classes/core.php"; ?>
<?php 
$username = "";
if (isset($_COOKIE[$systemName])) {
	$username = $_COOKIE[$systemName];
}
else {
	header('Location: ' . $fullUrl);
}
$UserFactory = new UserFactory();
$UserArray = $UserFactory->GetAll(" where Username = '" . escapeString($username) . "' and IsActive = 1");
if (count($UserArray) > 0)
{ 
	foreach ($UserArray as &$value)
	{
		$_SESSION['UserId'] = $value->UserId;
        $_SESSION['Username'] = $value->Username;
        $_SESSION['Firstname'] = $value->Firstname;
        $_SESSION['Lastname'] = $value->Lastname;
        $_SESSION['Email'] = $value->Email;
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
		header('Location: ' . $fullUrl . 'dashboard.php');
	}
}
else
{
	echo "<span class=\"error\">Username/Password incorrect!</span>";
}
unset($value);
?>