<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/assets/classes/core.php"; ?>
<?php
$Id = "";
$Active = 0;
if (isset($_POST["Id"])) 
{
	$Id = $_POST["Id"];
}
$GameFactory = new GameFactory();
$u = new Game();
if ($Id != "" && $Id > 0)
{
    $u = $GameFactory->GetOne($Id);
	$u->Active = $Active;
}
if ($u->GameId > 0) 
{
    $GameFactory->Update($u);        
}
exit();
?>