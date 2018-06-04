<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/assets/classes/core.php"; ?>
<?php 
$username = "";
if (isset($_POST["username"])) 
{
	$username = $_POST["username"];
}
$UserFactory = new UserFactory();
$UserArray = $UserFactory->GetAll(" where Username = '" . escapeString($username) . "' and IsActive = 1");
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