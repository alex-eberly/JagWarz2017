<?php
//Usage
/*
<?php include 'Game.gen.php' ?>
<?php
$GameFactory = new GameFactory();
$Game = $GameFactory->GetOne(1);
echo $Game->Title . "<br />";
unset($Game);
$GameArray = $GameFactory->GetAll(' where GameId = 1 ');
foreach ($GameArray as &$value)
{
	echo $value->Title . "<br />";
}
unset($value);
?>
*/
//Core Class
class Game
{
	var $GameId;//mdata in admin/assets/content/games.php represents this list
	var $Title;
	var $Description;
	var $ClosedDescription;
	var $OpenDate;
	var $CloseDate;
	var $Code;
	var $Active;
	var $GameType;//RvB or CTF; created by John
	function setGameId($GameId)
	{
		$this->GameId = $GameId;
	}
	function getGameId()
	{
		return $this->GameId;
	}
	function setTitle($Title)
	{
		$this->Title = $Title;
	}
	function getTitle()
	{
		return $this->Title;
	}
	function setDescription($Description)
	{
		$this->Description = $Description;
	}
	function getDescription()
	{
		return $this->Description;
	}
	function setClosedDescription($ClosedDescription)
	{
		$this->ClosedDescription = $ClosedDescription;
	}
	function getClosedDescription()
	{
		return $this->ClosedDescription;
	}
	function setOpenDate($OpenDate)
	{
		$this->OpenDate = $OpenDate;
	}
	function getOpenDate()
	{
		return $this->OpenDate;
	}
	function setCloseDate($CloseDate)
	{
		$this->CloseDate = $CloseDate;
	}
	function getCloseDate()
	{
		return $this->CloseDate;
	}
	function setCode($Code)
	{
		$this->Code = $Code;
	}
	function getCode()
	{
		return $this->Code;
	}
	function setActive($Active)
	{
		$this->Active = $Active;
	}
	function getActive()
	{
		return $this->Active;
	}
	function setGameType($GameType)//setter & getter for GameType; created by John
	{
		$this->GameType = $GameType;
	}
	function getGameType()
	{
		return $this->GameType;
	}
}
//Factory Class //9-23-17, Austin made changes to code and in database in order to try to get editing working properly starting down below
class GameFactory//Added GameType into each function of GameFactory
{
	function GetOne($GameId)
	{
		$Game = new Game();
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$sql = "select * from Game where GameId = " . mysql_real_escape_string($GameId);
			$result=mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{
				$Game->GameId = $row['GameId'];
				$Game->Title = $row['Title'];
				$Game->Description = $row['Description']; //=== NULL) ? "" : $row['Description'];
				$Game->ClosedDescription = $row['ClosedDescription']; //=== NULL) ? "" : $row['ClosedDescription'];
				$Game->OpenDate = $row['OpenDate']; //=== NULL); ? "" : $row['OpenDate'];
				$Game->CloseDate = $row['CloseDate']; //=== NULL); ? "" : $row['CloseDate'];
				$Game->Code = $row['Code']; //=== NULL); ? "" : $row['Code'];
				$Game->Active = $row['Active'];
				$Game->GameType = ($row['GameType'] === NULL) ? "" : $row['GameType'];
				//$Game->GameType = $row['GameType']; //=== NULL) ? "" : $row['GameType']; <-- 9-23-17
			}
		}
		mysql_close ($conn);
		return $Game;
	}
	function GetAll($filter) {
		$GameArray = Array();
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);

		if ($conn)	{
			mysql_select_db($db, $conn);
			$sql = "select * from Game " . $filter;
			$result=mysql_query($sql);

			while($row = mysql_fetch_array($result)) {
				$Game = new Game();
				$Game->GameId = $row['GameId'];
				$Game->Title = $row['Title'];
				$Game->Description = $row['Description']; //=== NULL) ? "" : $row['Description'];
				$Game->ClosedDescription = $row['ClosedDescription']; //=== NULL) ? "" : $row['ClosedDescription'];
				$Game->OpenDate = $row['OpenDate']; //=== NULL) ? "" : $row['OpenDate'];
				$Game->CloseDate = $row['CloseDate']; //=== NULL) ? "" : $row['CloseDate'];
				$Game->Code = $row['Code']; //=== NULL) ? "" : $row['Code'];
				$Game->Active = $row['Active'];
				$Game->GameType = $row['GameType'];
				$GameArray[] = $Game;
			}
		}
		mysql_close ($conn);
		return $GameArray;
	}
	function Insert($Game)
	{
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$insert = "";
			$insert .= "'" . mysql_real_escape_string($Game->Title) . "',";
			$insert .= "'" . mysql_real_escape_string($Game->Description) . "',"; //=== "") ? "NULL," : "'" . mysql_real_escape_string($Game->Description) . "',";
			$insert .= "'" . mysql_real_escape_string($Game->ClosedDescription) . "',"; //=== "") ? "NULL," : "'" . mysql_real_escape_string($Game->ClosedDescription) . "',";
			$insert .= "'" . mysql_real_escape_string($Game->OpenDate) . "',"; //=== "") ? "NULL," : "'" . mysql_real_escape_string($Game->OpenDate) . "',";
			$insert .= "'" . mysql_real_escape_string($Game->CloseDate) . "',"; //=== "") ? "NULL," : "'" . mysql_real_escape_string($Game->CloseDate) . "',";
			$insert .= "'" . mysql_real_escape_string($Game->Code) . "',"; //=== "") ? "NULL," : "'" . mysql_real_escape_string($Game->Code) . "',";
			$insert .= "'" . mysql_real_escape_string($Game->Active) . "',";
			$insert .= (mysql_real_escape_string($Game->GameType) === "") ? "NULL," : "'" . mysql_real_escape_string($Game->GameType) . "'";
			//$insert .= "'" . mysql_real_escape_string($Game->GameType) . "'"; //=== "") ? "NULL," : "'" . mysql_real_escape_string($Game->GameType) . "'"; <-- 9-23-17
			$sql = "insert into Game (Title,Description,ClosedDescription,OpenDate,CloseDate,Code,Active,GameType) values (" . $insert . ")";
			mysql_query($sql);
			$Game->GameId = mysql_insert_id();
		}
		mysql_close ($conn);
		return $Game;
	}
	function Update($Game)
	{
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$update = "";
			$update .= "Title = '" . mysql_real_escape_string($Game->Title) . "',";
			$update .= "Description = '" . mysql_real_escape_string($Game->Description) . "',"; //=== "") ? "" : "Description = '" . mysql_real_escape_string($Game->Description) . "',";
			$update .= "ClosedDescription = '" . mysql_real_escape_string($Game->ClosedDescription) . "',"; //=== "") ? "" : "ClosedDescription = '" . mysql_real_escape_string($Game->ClosedDescription) . "',";
			$update .= "OpenDate = '" . mysql_real_escape_string($Game->OpenDate) . "',"; //=== "") ? "" : "OpenDate = '" . mysql_real_escape_string($Game->OpenDate) . "',";
			$update .= "CloseDate = '" . mysql_real_escape_string($Game->CloseDate) . "',"; //=== "") ? "" : "CloseDate = '" . mysql_real_escape_string($Game->CloseDate) . "',";
			$update .= "Code = '" . mysql_real_escape_string($Game->Code) . "',"; //=== "") ? "" : "Code = '" . mysql_real_escape_string($Game->Code) . "',";
			$update .= "Active = '" . mysql_real_escape_string($Game->Active) . "',";
			$update .= (mysql_real_escape_string($Game->GameType) === "") ? "" : "GameType = '" . mysql_real_escape_string($Game->GameType) . "'";
			//$update .= "GameType = '" . mysql_real_escape_string($Game->GameType) . "'"; //=== "") ? "" : "GameType = '" . mysql_real_escape_string($Game->GameType) . "'"; <-- 9-23-17
			$sql = "update Game set " . $update . " where GameId = " . mysql_real_escape_string($Game->GameId);
			mysql_query($sql);
		}
		mysql_close ($conn);
	}
}
?>
