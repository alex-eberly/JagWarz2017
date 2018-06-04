<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/assets/classes/core.php"; ?>
<?php 
$email = "";
$userpassword = "";
if (isset($_POST["email"])) 
{
	$email = $_POST["email"];
}
$UserFactory = new UserFactory();
$UserArray = $UserFactory->GetAll(" where (Email = '" . escapeString($email) . "' or Username = '" . escapeString($email) . "') and IsActive = 1");
if (count($UserArray) > 0)
{ 
	foreach ($UserArray as &$value)
	{
		$newPassword = generatePassword(8);
        $value->Password = md5($newPassword);
        $UserFactory->Update($value);
        //send email
        $subject = $systemName . " - Password Reset";
        $text = "Sorry you lost your password. Your new password is '$newPassword'."; 
        $html = "<p>Sorry you lost your password. Your new password is '$newPassword'.</p>";
        utilitySendEmail($value->Email,$subject,$text,$html);
        echo "<div class=\"alert alert-success\">Password emailed!</div>";
	}
}
else
{
	echo "<div class=\"alert alert-danger\">Email/Username not found!</div>";
}
unset($value);
?>