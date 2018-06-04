<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/assets/classes/core.php"; ?>
<?php 
$firstname = "";
$lastname = "";
$emailaddress = "";
$gameCode = "";
$userpassword = "";
$username = "";
if (isset($_POST["username"])) 
{
	$username = $_POST["username"];
}
if (isset($_POST["password"])) 
{
	$userpassword = $_POST["password"];
}
if (isset($_POST["firstname"])) 
{
	$firstname = $_POST["firstname"];
}
if (isset($_POST["lastname"])) 
{
	$lastname = $_POST["lastname"];
}
if (isset($_POST["emailaddress"])) 
{
	$emailaddress = $_POST["emailaddress"];
}
if (isset($_POST["gameCode"])) 
{
	$gameCode = $_POST["gameCode"];
}
$UserFactory = new UserFactory();
$timestamp = time();
//check username availability
$Users = $UserFactory->GetAll(" where Username = '" . escapeString($username) . "'");
if (count($Users) > 0)
{
	echo "<div class=\"alert alert-danger\">Username already exists!</div>";
    exit();
}
//check email availability
$Users = $UserFactory->GetAll(" where Email = '" . escapeString($emailaddress) . "'");
if (count($Users) > 0)
{
	echo "<div class=\"alert alert-danger\">Email already exists!</div>";
    exit();
}
//check game availability
$gameId = 0;
$GameFactory = new GameFactory();
$Games = $GameFactory->GetAll(" where Code = '" . escapeString($gameCode) . "'");
if (count($Games) > 0) 
{
	$gameId = $row["GameId"];
	echo "$gameId";
}
else
{
	echo "<div class=\"alert alert-danger\">No game found!</div>";
    exit();
}
$u = new User();
$u->Username = $username;
$u->Firstname = $firstname;
$u->Lastname = $lastname;
$u->Password = md5($userpassword);
$u->DateCreated = gmdate("Y-m-d H:i:s", $timestamp);
$u->Email = $emailaddress;
$u->IsActive = 1;
$UserFactory->Insert($u);
if ($u->UserId > 0)
{
	//setup the game connection
	$UserGameFactory = new UserGameFactory();
	$UserGame = new UserGame; 
	$UserGame->UserId = $u->UserId;
	$UserGame->GameId = $gameId;
	$UserGameFactory->Insert($UserGame);
    $_SESSION['UserId'] = $u->UserId;
    $_SESSION['Firstname'] = $u->Firstname;
    $_SESSION['Lastname'] = $u->Lastname;
    $_SESSION['Email'] = $u->Email;
		
    //send email
    $subject = $systemName . " Registration";
    $text = "Thank you for registering. Your account username is '$username' and your password is '$userpassword'"; 
    $html = "<p>Thank you for registering. Your account username is '$username' and your password is '$userpassword'</p>";
    utilitySendEmail($emailaddress,$subject,$text,$html);
    echo "<script type=\"text/javascript\">window.location='dashboard.php';</script>";
}
?>