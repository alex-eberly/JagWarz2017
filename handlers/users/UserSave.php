<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/assets/classes/core.php"; ?>
<?php
$UserId = "";
$Firstname = "";
$Lastname = "";
$Username = "";
$Username2 = "";
$Email = "";
$Email2 = "";
$UserPassword = "";
$Active = 1;
if (isset($_POST["UserId"])) 
{
	$UserId = $_POST["UserId"];
}
if (isset($_POST["username"])) 
{
	$Username = $_POST["username"];
}
if (isset($_POST["usernameCurrent"])) 
{
	$Username2 = $_POST["usernameCurrent"];
}
if (isset($_POST["firstname"])) 
{
	$Firstname = $_POST["firstname"];
}
if (isset($_POST["lastname"])) 
{
	$Lastname = $_POST["lastname"];
}
if (isset($_POST["emailaddress"])) 
{
	$Email = $_POST["emailaddress"];
}
if (isset($_POST["emailaddressCurrent"])) 
{
	$Email2 = $_POST["emailaddressCurrent"];
}
if (isset($_POST["password"])) 
{
	$UserPassword = $_POST["password"];
}
if (isset($_POST["Active"])) 
{
	$Active = $_POST["Active"];
}
//check username availability
$UserFactory = new UserFactory();
$newUser = true;
$timestamp = time();
if ($UserId != "" && $UserId > 0)
{
    $u = $UserFactory->GetOne($UserId);
    $newUser = false;
    if ($Email != $Email2) 
    {
	    $UserArray = $UserFactory->GetAll(" where Email = '" . escapeString($Email) . "' and IsActive = 1");
		if (count($UserArray) > 0)
		{
		    echo "<div class=\"alert alert-danger\">Email address already exists!</div>";
		    exit();
		}
    }
    if ($Username != $Username2)
    {
	    $UserArray = $UserFactory->GetAll(" where Username = '" . escapeString($Username) . "' and IsActive = 1");
		if (count($UserArray) > 0)
		{
		    echo "<div class=\"alert alert-danger\">Username already exists!</div>";
		    exit();
		}
    }
}
else 
{
    $u = new User();
	$u->DateCreated = gmdate("Y-m-d H:i:s", $timestamp);
	$newUser = true;
	$UserArray = $UserFactory->GetAll(" where Email = '" . escapeString($Email) . "' and IsActive = 1");
	if (count($UserArray) > 0)
	{
	    echo "<div class=\"alert alert-danger\">Email address already exists!</div>";
	    exit();
	}
}
$u->Firstname = $Firstname;
$u->Lastname = $Lastname;
$u->Email = $Email;
$u->Username = $Username;
if ($UserPassword != "")
{
    $u->Password = md5($UserPassword);
}
$u->Active = $Active;
if ($u->UserId > 0) 
{
    $UserFactory->Update($u);        
}
else
{
    $UserFactory->Insert($u);
}
echo "<div class=\"alert alert-success\">Save successful!</div>";
exit();
?>