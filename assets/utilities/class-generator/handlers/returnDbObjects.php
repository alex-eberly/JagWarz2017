<?php include("../includes/dataObjects.php"); ?>
<?php 
$dbserver = "";
$db = "";
$user = "";
$password = "";
if (isset($_POST["dbServer"])) 
{
	$dbserver = $_POST["dbServer"];
	$_SESSION['txtDbServer']=$dbserver;
}
if (isset($_POST["database"])) 
{
	$db = $_POST["database"];
	$_SESSION['txtDatabase']=$db;
}
if (isset($_POST["username"])) 
{
	$user = $_POST["username"];
	$_SESSION['txtUsername']=$user;
}
if (isset($_POST["password"])) 
{
	$password = $_POST["password"];
	$_SESSION['txtPassword']=$password;
}
$conn = mysql_connect($dbserver,$user,$password);
if ($conn)
{
	mysql_select_db($db, $conn);
	$sql = "select * from INFORMATION_SCHEMA.tables where table_type = 'base table' and table_schema = '" . $db . "' order by table_name"; 
	//this function will execute the sql satament
	$result=mysql_query($sql);
	echo "<select class=\"lbTables\" id=\"lbTables\" name=\"lbTables\" size=\"8\">";
	while($row = mysql_fetch_array($result)) // getting data
	{
		$name=$row['TABLE_NAME'];
		echo "<option value=\"$name\">$name</option>";
	}
	echo "</select>";
}
mysql_close ($conn);
?>