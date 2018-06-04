<?php
//Globals
$dbserver = "localhost";
$db = "mlindle_pledgeforge";
$dbuser = "mlindle_dbuser";
$dbpassword = "zombiept2";
//Usage
/*
<?php include 'pledge.gen.php' ?>
<?php
$pledgeFactory = new pledgeFactory();
$pledge = $pledgeFactory->GetOne(1);
echo $pledge->CampaignId . "<br />";
unset($pledge);
$pledgeArray = $pledgeFactory->GetAll(' where PledgeId = 1 ');
foreach ($pledgeArray as &$value)
{
	echo $value->CampaignId . "<br />";
}
unset($value);
?>
*/
//Core Class
class pledge
{
	var $PledgeId;
	var $CampaignId;
	var $Firstname;
	var $Lastname;
	var $Email;
	var $Phone;
	var $Address1;
	var $Address2;
	var $Address3;
	var $Address4;
	var $Address5;
	var $Amount;
	var $IsAnonymous;
	var $DateCreated;
	function setPledgeId($PledgeId)
	{
		$this->PledgeId = $PledgeId;
	}
	function getPledgeId()
	{
		return $this->PledgeId;
	}
	function setCampaignId($CampaignId)
	{
		$this->CampaignId = $CampaignId;
	}
	function getCampaignId()
	{
		return $this->CampaignId;
	}
	function setFirstname($Firstname)
	{
		$this->Firstname = $Firstname;
	}
	function getFirstname()
	{
		return $this->Firstname;
	}
	function setLastname($Lastname)
	{
		$this->Lastname = $Lastname;
	}
	function getLastname()
	{
		return $this->Lastname;
	}
	function setEmail($Email)
	{
		$this->Email = $Email;
	}
	function getEmail()
	{
		return $this->Email;
	}
	function setPhone($Phone)
	{
		$this->Phone = $Phone;
	}
	function getPhone()
	{
		return $this->Phone;
	}
	function setAddress1($Address1)
	{
		$this->Address1 = $Address1;
	}
	function getAddress1()
	{
		return $this->Address1;
	}
	function setAddress2($Address2)
	{
		$this->Address2 = $Address2;
	}
	function getAddress2()
	{
		return $this->Address2;
	}
	function setAddress3($Address3)
	{
		$this->Address3 = $Address3;
	}
	function getAddress3()
	{
		return $this->Address3;
	}
	function setAddress4($Address4)
	{
		$this->Address4 = $Address4;
	}
	function getAddress4()
	{
		return $this->Address4;
	}
	function setAddress5($Address5)
	{
		$this->Address5 = $Address5;
	}
	function getAddress5()
	{
		return $this->Address5;
	}
	function setAmount($Amount)
	{
		$this->Amount = $Amount;
	}
	function getAmount()
	{
		return $this->Amount;
	}
	function setIsAnonymous($IsAnonymous)
	{
		$this->IsAnonymous = $IsAnonymous;
	}
	function getIsAnonymous()
	{
		return $this->IsAnonymous;
	}
	function setDateCreated($DateCreated)
	{
		$this->DateCreated = $DateCreated;
	}
	function getDateCreated()
	{
		return $this->DateCreated;
	}
}
//Factory Class
class pledgeFactory
{
	function GetOne($PledgeId)
	{
		$pledge = new pledge();
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$sql = "select * from pledge where PledgeId = " . mysql_real_escape_string($PledgeId);
			$result=mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{
				$pledge->PledgeId = $row['PledgeId'];
				$pledge->CampaignId = $row['CampaignId'];
				$pledge->Firstname = $row['Firstname'];
				$pledge->Lastname = $row['Lastname'];
				$pledge->Email = $row['Email'];
				$pledge->Phone = $row['Phone'];
				$pledge->Address1 = $row['Address1'];
				$pledge->Address2 = $row['Address2'];
				$pledge->Address3 = $row['Address3'];
				$pledge->Address4 = $row['Address4'];
				$pledge->Address5 = $row['Address5'];
				$pledge->Amount = $row['Amount'];
				$pledge->IsAnonymous = $row['IsAnonymous'];
				$pledge->DateCreated = $row['DateCreated'];
			}
		}
		mysql_close ($conn);
		return $pledge;
	}
	function GetAll($filter)
	{
		$pledgeArray = Array();
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$sql = "select * from pledge " . $filter;
			$result=mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{
				$pledge = new pledge();
				$pledge->PledgeId = $row['PledgeId'];
				$pledge->CampaignId = $row['CampaignId'];
				$pledge->Firstname = $row['Firstname'];
				$pledge->Lastname = $row['Lastname'];
				$pledge->Email = $row['Email'];
				$pledge->Phone = $row['Phone'];
				$pledge->Address1 = $row['Address1'];
				$pledge->Address2 = $row['Address2'];
				$pledge->Address3 = $row['Address3'];
				$pledge->Address4 = $row['Address4'];
				$pledge->Address5 = $row['Address5'];
				$pledge->Amount = $row['Amount'];
				$pledge->IsAnonymous = $row['IsAnonymous'];
				$pledge->DateCreated = $row['DateCreated'];
				$pledgeArray[] = $pledge;
			}
		}
		mysql_close ($conn);
		return $pledgeArray;
	}
	function Insert($pledge)
	{
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$insert = "";
			$insert .= mysql_real_escape_string($pledge->CampaignId) . ",";
			$insert .= "'" . mysql_real_escape_string($pledge->Firstname) . "',";
			$insert .= "'" . mysql_real_escape_string($pledge->Lastname) . "',";
			$insert .= "'" . mysql_real_escape_string($pledge->Email) . "',";
			$insert .= "'" . mysql_real_escape_string($pledge->Phone) . "',";
			$insert .= "'" . mysql_real_escape_string($pledge->Address1) . "',";
			$insert .= "'" . mysql_real_escape_string($pledge->Address2) . "',";
			$insert .= "'" . mysql_real_escape_string($pledge->Address3) . "',";
			$insert .= "'" . mysql_real_escape_string($pledge->Address4) . "',";
			$insert .= "'" . mysql_real_escape_string($pledge->Address5) . "',";
			$insert .= mysql_real_escape_string($pledge->Amount) . ",";
			$insert .= mysql_real_escape_string($pledge->IsAnonymous) . ",";
			$insert .= "'" . mysql_real_escape_string($pledge->DateCreated) . "'";
			$sql = "insert into pledge (CampaignId,Firstname,Lastname,Email,Phone,Address1,Address2,Address3,Address4,Address5,Amount,IsAnonymous,DateCreated) values (" . $insert . ")";
			mysql_query($sql);
			$pledge->PledgeId = mysql_insert_id();
		}
		mysql_close ($conn);
		return $pledge;
	}
	function Update($pledge)
	{
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$update = "";
			$update .= "CampaignId = " . mysql_real_escape_string($pledge->CampaignId) . ",";
			$update .= "Firstname = '" . mysql_real_escape_string($pledge->Firstname) . "',";
			$update .= "Lastname = '" . mysql_real_escape_string($pledge->Lastname) . "',";
			$update .= "Email = '" . mysql_real_escape_string($pledge->Email) . "',";
			$update .= "Phone = '" . mysql_real_escape_string($pledge->Phone) . "',";
			$update .= "Address1 = '" . mysql_real_escape_string($pledge->Address1) . "',";
			$update .= "Address2 = '" . mysql_real_escape_string($pledge->Address2) . "',";
			$update .= "Address3 = '" . mysql_real_escape_string($pledge->Address3) . "',";
			$update .= "Address4 = '" . mysql_real_escape_string($pledge->Address4) . "',";
			$update .= "Address5 = '" . mysql_real_escape_string($pledge->Address5) . "',";
			$update .= "Amount = " . mysql_real_escape_string($pledge->Amount) . ",";
			$update .= "IsAnonymous = " . mysql_real_escape_string($pledge->IsAnonymous) . ",";
			$update .= "DateCreated = '" . mysql_real_escape_string($pledge->DateCreated) . "'";
			$sql = "update pledge set " . $update . " where PledgeId = " . mysql_real_escape_string($pledge->PledgeId);
			mysql_query($sql);
		}
		mysql_close ($conn);
	}
}
?>