<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/assets/classes/core.php"; ?>
<?php
$UserId = "";
$Active = 0;
if (isset($_POST["UserId"])) 
{
	$UserId = $_POST["UserId"];
}
//check username availability
$UserFactory = new UserFactory();
$timestamp = time();
if ($UserId != "" && $UserId > 0)
{
    $u = $UserFactory->GetOne($UserId);
    $u->UserModified = $_SESSION['UserId'];
	$u->DateModified = gmdate("Y-m-d H:i:s", $timestamp);
	$u->Active = $Active;
}
if ($u->UserId > 0) 
{
    $UserFactory->Update($u);        
}
exit();
?>