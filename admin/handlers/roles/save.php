<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/assets/classes/core.php"; ?>
<?php

//setup variables
//ajaxSave() pulls these variables, then places the values from load.php into it

//may use UserGamesId instead of using UserId and GameId

$UserRoleId = "";
$UserGamesId = "";
$GameId = "";
$UserId = "";
$Username = "";
$Title = "";
$RoleType = "";
$Description = "";


//pull in variables from form/post
if (isset($_POST["UserRoleId"]))
	$UserRoleId = $_POST["UserRoleId"];
/*if (isset($_POST["UserGamesId"]))
	$UserGamesId = $_POST["UserGamesId"];
if (isset($_POST["GameId"]))
	$GameId = $_POST["GameId"];
if (isset($_POST["UserId"]))
	$UserId = $_POST["UserId"];*/
if (isset($_POST["Username"]))
	$Username = $_POST["Username"];
if (isset($_POST["Title"]))
	$Title = $_POST["Title"];
if (isset($_POST["RoleType"]))
	$RoleType = $_POST["RoleType"];
if (isset($_POST["Description"]))
	$Description = $_POST["Description"];

//****  10-27-17 ****//

//echo $_POST['Username'];
print_r($_POST);
//echo "hi";


//****          ****//

$RoleFactory = new RoleFactory();
$newRecord = true;
$timestamp = time();
if ($UserRoleId != "" && $UserRoleId > 0){
    $Role = $RoleFactory->GetOne($UserRoleId);
    $newRecord = false;
}
else {
    $Role = new Role();
	$newRecord = true;
}
$Role->UserRoleId = $UserRoleId;
$Role->UserGamesId = $UserGamesId;
$Role->GameId = $GameId;
$Role->UserId = $UserId;
$Role->Username = $Username;
$Role->Title = $Title;
$Role->RoleType = $RoleType;
$Role->Description = $Description;


if ($Role->UserRoleId > 0) {
    $RoleFactory->Update($Role);
}
else{
    $RoleFactory->Insert($Role);
}
echo $Role->UserRoleId;
exit();
?>
