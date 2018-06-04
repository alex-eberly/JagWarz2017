<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/assets/classes/core.php"; ?>
<?php 
$emailaddress = "";
if (isset($_POST["email"])) 
{
	$emailaddress = $_POST["email"];
}
$UserFactory = new UserFactory();
$UserArray = $UserFactory->GetAll(" where Email = '" . escapeString($emailaddress) . "' and IsActive = 1");
if (count($UserArray) > 0)
{
    echo "<span class=\"red-text message\">Not Available!</span>";
    exit();
}
else
{
    echo "<span class=\"green-text message\">Available!</span>";
}
?>