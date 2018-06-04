<?php
//Usage
/*
<?php include 'UserGame.gen.php' ?>
<?php
$UserGameFactory = new UserGameFactory();
$UserGame = $UserGameFactory->GetOne(1);
echo $UserGame->GameId . "<br />";
unset($UserGame);
$UserGameArray = $UserGameFactory->GetAll(' where UserGamesId = 1 ');
foreach ($UserGameArray as &$value)
{
	echo $value->GameId . "<br />";
}
unset($value);
?>
*/
//Core Class
class UserGame
{
	var $UserGamesId;
	var $GameId;
	var $UserId;
	var $RoleId;
	function setUserGamesId($UserGamesId)
	{
		$this->UserGamesId = $UserGamesId;
	}
	function getUserGamesId()
	{
		return $this->UserGamesId;
	}
	function setGameId($GameId)
	{
		$this->GameId = $GameId;
	}
	function getGameId()
	{
		return $this->GameId;
	}
	function setUserId($UserId)
	{
		$this->UserId = $UserId;
	}
	function getUserId()
	{
		return $this->UserId;
	}
//Set and get created 7/08/2016 to handle the roles
	function setRoleId($RoleId)
	{
		$this->RoleId = $RoleId;
	}
	function getRoleId()
	{
		return $this->RoleId;
	}
}
//Factory Class
class UserGameFactory
{
	function GetOne($UserGamesId)
	{
		$UserGame = new UserGame();
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$sql = "select * from UserGame where UserGamesId = " . mysql_real_escape_string($UserGamesId);
			$result=mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{
				$UserGame->UserGamesId = $row['UserGamesId'];
				$UserGame->GameId = $row['GameId'];
				$UserGame->UserId = $row['UserId'];
				$UserGame->RoleId = $row['RoleId'];
			}
		}
		mysql_close ($conn);
		return $UserGame;
	}
	function GetAll($filter)
	{
		$UserGameArray = Array();
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$sql = "select * from UserGame " . $filter;
			$result=mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{
				$UserGame = new UserGame();
				$UserGame->UserGamesId = $row['UserGamesId'];
				$UserGame->GameId = $row['GameId'];
				$UserGame->UserId = $row['UserId'];
				$UserGame->RoleId = $row['RoleId'];
				$UserGameArray[] = $UserGame;
			}
		}
		mysql_close ($conn);
		return $UserGameArray;
	}
	function Insert($UserGame)
	{
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$insert = "";
			$insert .= mysql_real_escape_string($UserGame->GameId) . ",";
			$insert .= mysql_real_escape_string($UserGame->UserId) . ",";
			$insert .= mysql_real_escape_string($UserGame->RoleId);
			$insert .= mysql_real_escape_string(1);
			$sql = "insert into UserGame (GameId,UserId,RoleId) values (" . $insert . ")";
			mysql_query($sql);
			$UserGame->UserGamesId = mysql_insert_id();
		}
		mysql_close ($conn);
		return $UserGame;
	}
	function Update($UserGame)
	{
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$update = "";
			$update .= "GameId = " . mysql_real_escape_string($UserGame->GameId) . ",";
			$update .= "UserId = " . mysql_real_escape_string($UserGame->UserId) . ",";
			$update .= "RoleId = " . mysql_real_escape_string($UserGame->RoleId);
			$sql = "update UserGame set " . $update . " where UserGamesId = " . mysql_real_escape_string($UserGame->UserGamesId);
			mysql_query($sql);
		}
		mysql_close ($conn);
	}
}
?>
