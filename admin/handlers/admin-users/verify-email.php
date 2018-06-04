<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/assets/classes/core.php"; ?>
<?php 
$emailaddress = "";
if (isset($_POST["email"])) 
{
	$emailaddress = $_POST["email"];
}
$AdminUserFactory = new AdminUserFactory();
$AdminUserArray = $AdminUserFactory->GetAll(" where Username = '" . escapeString($emailaddress) . "'");
if (count($AdminUserArray) > 0)
{
    echo "<span class=\"red-text message\">Not Available!</span>";
    exit();
}
else
{
    echo "<span class=\"green-text message\">Available!</span>";
}
?>