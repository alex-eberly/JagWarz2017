<?php
//Usage
/*
<?php include 'Role.gen.php' ?>
<?php
$RoleFactory = new RoleFactory();
$Role = $RoleFactory->GetOne(1);
echo $Role->Description . "<br />";
unset($Role);
$RoleArray = $RoleFactory->GetAll(' where RoleId = 1 ');
foreach ($RoleArray as &$value)
{
	echo $value->Description. "<br />";
}
unset($value);
?>
*/
//Core Class
//********************************************************************************
//File created to manage role entity
class Role {
	
	var $UserRoleId;
	var $UserGamesId;
	var $GameId;
	var $UserId;
	var $Username;
	//var $Username = $_POST['Username']; // <-- 10/27/17
	var $Title;
	//var $Title = $_POST['Title']; // <-- 10/27/17
	var $RoleType;
	var $Description;

	// Didn't use RoleId because the site needs the way it is so users can register successfully for games and have those games appear on their list of games to select - Austin 10-13-17

	//Set and Get functions
	function setUserRoleId($UserRoleId){
		$this->UserRoleId = $UserRoleId;
	}
	function getUserRoleId(){
		return $this->UserRoleId;
	}
	function setUserGamesId($UserGamesId){
		$this->UserGamesId = $UserGamesId;
	}
	function getUserGamesId(){
		return $this->UserGamesId;
	}
	function setGameId($GameId){
		$this->GameId = $GameId;
	}
	function getGameId(){
		return $this->GameId;
	}
	function setUserId($UserId){
		$this->UserId = $UserId;
	}
	function getUserId(){
		return $this->UserId;
	}
	function setUsername($Username){
		$this->Username = $Username;
	}
	function getUsername(){
		return $this->Username;
	}
	function setTitle($Title){
		$this->Title = $Title;
	}
	function getTitle(){
		return $this->Title;
	}
	function setRoleType($RoleType){
		$this->RoleType = $RoleType;
	}
	function getRoleType(){
		return $this->RoleType;
	}
	function setDescription($Description){
		$this->Description = $Description;
	}
	function getDescription(){
		return $this->Description;
	}
	
	//**** 10-27-17  ****//
	
	/*$Username = $_POST[''];
	$Title = $_POST[''];*/
	
	//****   ****//
}
//Factory Class
class RoleFactory {

	function GetOne($UserRoleId) {

		$Role = new Role();
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);

		if ($conn) {
			mysql_select_db($db, $conn);
			$sql = "select * from Role where UserRoleId = " . mysql_real_escape_string($UserRoleId);
			$result=mysql_query($sql);
			if (!$result) { // add this check.
			    die('Invalid query: ' . mysql_error());
			}
			while($row = mysql_fetch_array($result)) {
				$Role->UserRoleId = $row['UserRoleId'];
				$Role->UserGamesId = $row['UserGamesId'];
				$Role->GameId = $row['GameId'];
				$Role->UserId = $row['UserId'];
				$Role->Username = $row['Username'];
				$Role->Title = $row['Title'];
				$Role->RoleType = $row['RoleType'];
				$Role->Description = $row['Description'];
			}
		}
		mysql_close ($conn);
		return $Role;
	}
	function GetAll($filter) {
		$RoleArray = Array();
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);

		if ($conn)	{
			mysql_select_db($db, $conn);
			$sql = "select * from Role " . $filter;
			$result = mysql_query($sql);
			if (!$result) { // add this check.
					die('Invalid query: ' . mysql_error());
			}
			while($row = mysql_fetch_array($result)) {
				$Role = new Role();
				$Role->UserRoleId = $row['UserRoleId'];
				$Role->UserGamesId = $row['UserGamesId'];
				$Role->GameId = $row['GameId'];
				$Role->UserId = $row['UserId'];
				$Role->Username = $row['Username'];
				$Role->Title = $row['Title'];
				$Role->RoleType = $row['RoleType'];
				$Role->Description = $row['Description'];
				$RoleArray[] = $Role;
			}
		}
		mysql_close ($conn);
		return $RoleArray;
	}
	function Insert($Role) {
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);

		if ($conn) {
			mysql_select_db($db, $conn);
			$insert = "";
			$insert .= "'" . mysql_real_escape_string($Role->UserGamesId) . "',";
			$insert .= "'" . mysql_real_escape_string($Role->GameId) . "',";
			$insert .= "'" . mysql_real_escape_string($Role->UserId) . "',";
			$insert .= "'" . mysql_real_escape_string($Role->Username) . "',";// O.G.
			$insert .= "'" . mysql_real_escape_string($Role->Title) . "',"; // O.G.
			//$insert .= "'" . mysql_real_escape_string($Role->$Username) . "',"; // <-- 10-27-17
			//$insert .= "'" . mysql_real_escape_string($Role->$Title) . "',"; // <-- 10-27-17
			$insert .= "'" . mysql_real_escape_string($Role->RoleType) . "',";
			$insert .= "'" . mysql_real_escape_string($Role->Description) . "',";
			//$sql = "insert into Role (UserGamesId,GameId,UserId,Username,Title,RoleType,Description) values (" . $insert . ")";
			$sql = "insert into Role (Username,Title,RoleType,Description) values (" . $insert . ")";
			print_r($_POST);
			mysql_query($sql);
			$Role->UserRoleId = mysql_insert_id();
		}
		mysql_close ($conn);
		return $Role;
	}

	function Update($Role) {
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn) {
			mysql_select_db($db, $conn);
			$update = "";
			$update .= "UserGamesId = '" . mysql_real_escape_string($Role->UserGamesId) . "',";
			$update .= "GameId = '" . mysql_real_escape_string($Role->GameId) . "',";
			$update .= "UserId = '" . mysql_real_escape_string($Role->UserId) . "',";
			$update .= "Username = '" . mysql_real_escape_string($Role->Username) . "',";
			$update .= "Title = '" . mysql_real_escape_string($Role->Title) . "',";
			$update .= "RoleType = '" . mysql_real_escape_string($Role->RoleType) . "',";
			$update .= "Description = '" . mysql_real_escape_string($Role->Description) . "',";
			$sql = "update Role set " . $update . " where UserRoleId = " . mysql_real_escape_string($Role->UserRoleId);
			mysql_query($sql);
		}
		mysql_close ($conn);
	}
}
?>
