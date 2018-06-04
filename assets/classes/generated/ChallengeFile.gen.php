<?php
//Usage
/*
<?php include 'ChallengeFile.gen.php' ?>
<?php
$ChallengeFileFactory = new ChallengeFileFactory();
$ChallengeFile = $ChallengeFileFactory->GetOne(1);
echo $ChallengeFile->ChallengeId . "<br />";
unset($ChallengeFile);
$ChallengeFileArray = $ChallengeFileFactory->GetAll(' where ChallengeFileId = 1 ');
foreach ($ChallengeFileArray as &$value)
{
	echo $value->ChallengeId . "<br />";
}
unset($value);
?>
*/
//Core Class
class ChallengeFile
{
	var $ChallengeFileId;
	var $ChallengeId;
	var $Filename;
	var $Path;
	function setChallengeFileId($ChallengeFileId)
	{
		$this->ChallengeFileId = $ChallengeFileId;
	}
	function getChallengeFileId()
	{
		return $this->ChallengeFileId;
	}
	function setChallengeId($ChallengeId)
	{
		$this->ChallengeId = $ChallengeId;
	}
	function getChallengeId()
	{
		return $this->ChallengeId;
	}
	function setFilename($Filename)
	{
		$this->Filename = $Filename;
	}
	function getFilename()
	{
		return $this->Filename;
	}
	function setPath($Path)
	{
		$this->Path = $Path;
	}
	function getPath()
	{
		return $this->Path;
	}
}
//Factory Class
class ChallengeFileFactory
{
	function GetOne($ChallengeFileId)
	{
		$ChallengeFile = new ChallengeFile();
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$sql = "select * from ChallengeFile where ChallengeFileId = " . mysql_real_escape_string($ChallengeFileId);
			$result=mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{
				$ChallengeFile->ChallengeFileId = $row['ChallengeFileId'];
				$ChallengeFile->ChallengeId = $row['ChallengeId'];
				$ChallengeFile->Filename = $row['Filename'];
				$ChallengeFile->Path = $row['Path'];
			}
		}
		mysql_close ($conn);
		return $ChallengeFile;
	}
	function GetAll($filter)
	{
		$ChallengeFileArray = Array();
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$sql = "select * from ChallengeFile " . $filter;
			$result=mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{
				$ChallengeFile = new ChallengeFile();
				$ChallengeFile->ChallengeFileId = $row['ChallengeFileId'];
				$ChallengeFile->ChallengeId = $row['ChallengeId'];
				$ChallengeFile->Filename = $row['Filename'];
				$ChallengeFile->Path = $row['Path'];
				$ChallengeFileArray[] = $ChallengeFile;
			}
		}
		mysql_close ($conn);
		return $ChallengeFileArray;
	}
	function Insert($ChallengeFile)
	{
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$insert = "";
			$insert .= mysql_real_escape_string($ChallengeFile->ChallengeId) . ",";
			$insert .= "'" . mysql_real_escape_string($ChallengeFile->Filename) . "',";
			$insert .= "'" . mysql_real_escape_string($ChallengeFile->Path) . "'";
			$sql = "insert into ChallengeFile (ChallengeId,Filename,Path) values (" . $insert . ")";
			mysql_query($sql);
			$ChallengeFile->ChallengeFileId = mysql_insert_id();
		}
		mysql_close ($conn);
		return $ChallengeFile;
	}
	function Update($ChallengeFile)
	{
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$update = "";
			$update .= "ChallengeId = " . mysql_real_escape_string($ChallengeFile->ChallengeId) . ",";
			$update .= "Filename = '" . mysql_real_escape_string($ChallengeFile->Filename) . "',";
			$update .= "Path = '" . mysql_real_escape_string($ChallengeFile->Path) . "'";
			$sql = "update ChallengeFile set " . $update . " where ChallengeFileId = " . mysql_real_escape_string($ChallengeFile->ChallengeFileId);
			mysql_query($sql);
		}
		mysql_close ($conn);
	}
}
?>