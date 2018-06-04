<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/assets/classes/core.php'); ?>
<?php 
$AdminUserId = "";
$AdminUsername = "";
$UserPassword = "";
if (isset($_POST["AdminUserId"])) 
{
	$AdminUserId = $_POST["AdminUserId"];
}
if (isset($_POST["Email"])) 
{
	$AdminUsername = $_POST["Email"];
}
if (isset($_POST["Password"])) 
{
	$UserPassword = $_POST["Password"];
}
$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
if ($conn)
{
	mysql_select_db($db, $conn);
    //check email availability
    $sql = "select AdminUserId from AdminUsers where Username = '" . $AdminUsername . "'";
    $result=mysql_query($sql);
    $row = mysql_fetch_array($result);
    if ($row["AdminUserId"] > 0)
    {
        echo "<span class=\"red-text message\">Email address already exists!</span>";
        exit();
    }
    $AdminUserFactory = new AdminUserFactory();
    if ($AdminUserId != "" && $AdminUserId > 0)
    {
        $u = $AdminUserFactory->GetOne($AdminUserId);
    }
    $u->Username = $AdminUsername;
    if ($UserPassword != "")
    {
	    $u->Password = md5($UserPassword);
    }
    if ($u->AdminUserId > 0) 
    {
        $AdminUserFactory->Update($u);        
    }
    else
    {
        $AdminUserFactory->Insert($u);
        //send email
	    $subject = $systemName . " Registration";
	    $text = "An account has been created for you at $systemName. Your account username is '" . $u->Username . "' and your password is '" . $UserPassword . "'"; 
	    $html = "<p>An account has been created for you at $systemName. Your account username is '" . $u->Username . "' and your password is '" . $UserPassword . "'</p>";
	    utilitySendEmail($u->Username,$subject,$text,$html);
    }
    
    //echo "<span class=\"green-text message\">Save successful!</span><script type=\"text/javascript\"></script>";
    echo $u->AdminUserId;
}
if(is_resource($conn) && get_resource_type($conn) === 'mysql link')
{
    return mysql_close($conn);
}
?>