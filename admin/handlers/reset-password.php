<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/assets/classes/core.php"; ?>
<?php 
$email = "";
if (isset($_POST["email"])) 
{
	$email = $_POST["email"];
}
$AdminUserFactory = new AdminUserFactory();
$AdminUserArray = $AdminUserFactory->GetAll(" where Username = '" . escapeString($email) . "'");
if (count($AdminUserArray) > 0)
{ 
	foreach ($AdminUserArray as &$value)
	{
		$newPassword = generatePassword(8);
        $value->Password = md5($newPassword);
        $AdminUserFactory->Update($value);
        //send email
        $subject = $systemName . " - Admin Password Reset";
        $text = "Sorry you lost your admin password. Your new password is '$newPassword'."; 
        $html = "<p>Sorry you lost your admin password. Your new password is '$newPassword'.</p>";
        utilitySendEmail($value->Username,$subject,$text,$html);
        echo "<div class=\"alert alert-success\">Password emailed!</div>";
	}
}
else
{
	echo "<div class=\"alert alert-danger\">Email not found!</div>";
}
unset($value);
?>