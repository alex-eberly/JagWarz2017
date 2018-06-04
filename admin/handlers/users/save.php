<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/assets/classes/core.php'); ?>
<?php 
$UserId = "";
$Firstname = "";
$Lastname = "";
$Email = "";
$CurrentEmail = "";
$Username = "";
$CurrentUsername = "";
$UserPassword = "";
$IsActive = 1;
if (isset($_POST["UserId"])) 
{
	$UserId = $_POST["UserId"];
}
if (isset($_POST["Firstname"])) 
{
	$Firstname = $_POST["Firstname"];
}
if (isset($_POST["Lastname"])) 
{
	$Lastname = $_POST["Lastname"];
}
if (isset($_POST["Username"])) 
{
	$Username = $_POST["Username"];
}
if (isset($_POST["CurrentUsername"])) 
{
	$CurrentUsername = $_POST["CurrentUsername"];
}
if (isset($_POST["Email"])) 
{
	$Email = $_POST["Email"];
}
if (isset($_POST["CurrentEmail"])) 
{
	$CurrentEmail = $_POST["CurrentEmail"];
}
if (isset($_POST["Password"])) 
{
	$UserPassword = $_POST["Password"];
}
if (isset($_POST["IsActive"])) 
{
	$IsActive = $_POST["IsActive"];
}
$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
if ($conn)
{
	mysql_select_db($db, $conn);
	if ($CurrentEmail != $Email)
	{
	    //check email availability
	    $sql = "select UserId from User where Email = '" . $Email . "' and IsActive = 1";
	    $result=mysql_query($sql);
	    $row = mysql_fetch_array($result);
	    if ($row["UserId"] > 0)
	    {
	        echo "<span class=\"red-text message\">Email address already exists!</span>";
	        exit();
	    }
    }
    if ($CurrentUsername != $Username)
	{
	    //check email availability
	    $sql = "select UserId from User where Username = '" . $Username . "' and IsActive = 1";
	    $result=mysql_query($sql);
	    $row = mysql_fetch_array($result);
	    if ($row["UserId"] > 0)
	    {
	        echo "<span class=\"red-text message\">Username already exists!</span>";
	        exit();
	    }
    }
    $UserFactory = new UserFactory();
    if ($UserId != "" && $UserId > 0)
    {
        $u = $UserFactory->GetOne($UserId);
    }
    else 
    {
        $u = new users();
        $timestamp = time();
    	$u->DateCreated = gmdate("Y-m-d H:i:s", $timestamp);
    }
    $u->Firstname = $Firstname;
    $u->Lastname = $Lastname;
    $u->Email = $Email;
    $u->Username = $Username;
    if ($UserPassword != "")
    {
	    $u->Password = md5($UserPassword);
    }
    $u->IsActive = $IsActive;
    if ($u->UserId > 0) 
    {
        $UserFactory->Update($u);        
    }
    else
    {
        $UserFactory->Insert($u);
        //send email
	    $subject = $systemName . " Registration";
	    $text = "An account has been created for you at $systemName. Your account username is '$Username' and your password is '$UserPassword'"; 
	    $html = "<p>An account has been created for you at $systemName. Your account username is '$Username' and your password is '$UserPassword'</p>";
	    utilitySendEmail($emailaddress,$subject,$text,$html);
    }
    
    //echo "<span class=\"green-text message\">Save successful!</span><script type=\"text/javascript\"></script>";
    echo $u->UserId;
    exit();
}
if(is_resource($conn) && get_resource_type($conn) === 'mysql link')
{
    return mysql_close($conn);
}
?>