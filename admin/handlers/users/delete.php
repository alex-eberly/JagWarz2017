<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/assets/classes/core.php"; ?>
<?php
$Id = "";
$Active = 0;
if (isset($_POST["Id"])) 
{
	$Id = $_POST["Id"];
}
$UserFactory = new UserFactory();
if ($Id != "" && $Id > 0)
{
    $u = $UserFactory->GetOne($Id);
	$u->IsActive = $Active;
}
if ($u->UserId > 0) 
{
    $UserFactory->Update($u);        
}
exit();
?>