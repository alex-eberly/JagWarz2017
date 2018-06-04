<?php
//Usage
/*
<?php include 'LogEmail.gen.php' ?>
<?php
$LogEmailFactory = new LogEmailFactory();
$LogEmail = $LogEmailFactory->GetOne(1);
echo $LogEmail->DateSent . "<br />";
unset($LogEmail);
$LogEmailArray = $LogEmailFactory->GetAll(' where EmailLogId = 1 ');
foreach ($LogEmailArray as &$value)
{
	echo $value->DateSent . "<br />";
}
unset($value);
?>
*/
//Core Class
class LogEmail
{
	var $EmailLogId;
	var $DateSent;
	var $ToEmails;
	var $CcEmails;
	var $BccEmails;
	var $FromEmail;
	var $ReplyEmail;
	var $Subject;
	var $Message;
	var $Successful;
	var $SmtpHost;
	var $SmtpUsername;
	function setEmailLogId($EmailLogId)
	{
		$this->EmailLogId = $EmailLogId;
	}
	function getEmailLogId()
	{
		return $this->EmailLogId;
	}
	function setDateSent($DateSent)
	{
		$this->DateSent = $DateSent;
	}
	function getDateSent()
	{
		return $this->DateSent;
	}
	function setToEmails($ToEmails)
	{
		$this->ToEmails = $ToEmails;
	}
	function getToEmails()
	{
		return $this->ToEmails;
	}
	function setCcEmails($CcEmails)
	{
		$this->CcEmails = $CcEmails;
	}
	function getCcEmails()
	{
		return $this->CcEmails;
	}
	function setBccEmails($BccEmails)
	{
		$this->BccEmails = $BccEmails;
	}
	function getBccEmails()
	{
		return $this->BccEmails;
	}
	function setFromEmail($FromEmail)
	{
		$this->FromEmail = $FromEmail;
	}
	function getFromEmail()
	{
		return $this->FromEmail;
	}
	function setReplyEmail($ReplyEmail)
	{
		$this->ReplyEmail = $ReplyEmail;
	}
	function getReplyEmail()
	{
		return $this->ReplyEmail;
	}
	function setSubject($Subject)
	{
		$this->Subject = $Subject;
	}
	function getSubject()
	{
		return $this->Subject;
	}
	function setMessage($Message)
	{
		$this->Message = $Message;
	}
	function getMessage()
	{
		return $this->Message;
	}
	function setSuccessful($Successful)
	{
		$this->Successful = $Successful;
	}
	function getSuccessful()
	{
		return $this->Successful;
	}
	function setSmtpHost($SmtpHost)
	{
		$this->SmtpHost = $SmtpHost;
	}
	function getSmtpHost()
	{
		return $this->SmtpHost;
	}
	function setSmtpUsername($SmtpUsername)
	{
		$this->SmtpUsername = $SmtpUsername;
	}
	function getSmtpUsername()
	{
		return $this->SmtpUsername;
	}
}
//Factory Class
class LogEmailFactory
{
	function GetOne($EmailLogId)
	{
		$LogEmail = new LogEmail();
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$sql = "select * from LogEmail where EmailLogId = " . mysql_real_escape_string($EmailLogId);
			$result=mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{
				$LogEmail->EmailLogId = $row['EmailLogId'];
				$LogEmail->DateSent = $row['DateSent'];
				$LogEmail->ToEmails = $row['ToEmails'];
				$LogEmail->CcEmails = $row['CcEmails'];
				$LogEmail->BccEmails = $row['BccEmails'];
				$LogEmail->FromEmail = $row['FromEmail'];
				$LogEmail->ReplyEmail = $row['ReplyEmail'];
				$LogEmail->Subject = $row['Subject'];
				$LogEmail->Message = $row['Message'];
				$LogEmail->Successful = $row['Successful'];
				$LogEmail->SmtpHost = $row['SmtpHost'];
				$LogEmail->SmtpUsername = $row['SmtpUsername'];
			}
		}
		mysql_close ($conn);
		return $LogEmail;
	}
	function GetAll($filter)
	{
		$LogEmailArray = Array();
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$sql = "select * from LogEmail " . $filter;
			$result=mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{
				$LogEmail = new LogEmail();
				$LogEmail->EmailLogId = $row['EmailLogId'];
				$LogEmail->DateSent = $row['DateSent'];
				$LogEmail->ToEmails = $row['ToEmails'];
				$LogEmail->CcEmails = $row['CcEmails'];
				$LogEmail->BccEmails = $row['BccEmails'];
				$LogEmail->FromEmail = $row['FromEmail'];
				$LogEmail->ReplyEmail = $row['ReplyEmail'];
				$LogEmail->Subject = $row['Subject'];
				$LogEmail->Message = $row['Message'];
				$LogEmail->Successful = $row['Successful'];
				$LogEmail->SmtpHost = $row['SmtpHost'];
				$LogEmail->SmtpUsername = $row['SmtpUsername'];
				$LogEmailArray[] = $LogEmail;
			}
		}
		mysql_close ($conn);
		return $LogEmailArray;
	}
	function Insert($LogEmail)
	{
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$insert = "";
			$insert .= "'" . mysql_real_escape_string($LogEmail->DateSent) . "',";
			$insert .= "'" . mysql_real_escape_string($LogEmail->ToEmails) . "',";
			$insert .= "'" . mysql_real_escape_string($LogEmail->CcEmails) . "',";
			$insert .= "'" . mysql_real_escape_string($LogEmail->BccEmails) . "',";
			$insert .= "'" . mysql_real_escape_string($LogEmail->FromEmail) . "',";
			$insert .= "'" . mysql_real_escape_string($LogEmail->ReplyEmail) . "',";
			$insert .= "'" . mysql_real_escape_string($LogEmail->Subject) . "',";
			$insert .= "'" . mysql_real_escape_string($LogEmail->Message) . "',";
			$insert .= mysql_real_escape_string($LogEmail->Successful) . ",";
			$insert .= "'" . mysql_real_escape_string($LogEmail->SmtpHost) . "',";
			$insert .= "'" . mysql_real_escape_string($LogEmail->SmtpUsername) . "'";
			$sql = "insert into LogEmail (DateSent,ToEmails,CcEmails,BccEmails,FromEmail,ReplyEmail,Subject,Message,Successful,SmtpHost,SmtpUsername) values (" . $insert . ")";
			mysql_query($sql);
			$LogEmail->EmailLogId = mysql_insert_id();
		}
		mysql_close ($conn);
		return $LogEmail;
	}
	function Update($LogEmail)
	{
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$update = "";
			$update .= "DateSent = '" . mysql_real_escape_string($LogEmail->DateSent) . "',";
			$update .= "ToEmails = '" . mysql_real_escape_string($LogEmail->ToEmails) . "',";
			$update .= "CcEmails = '" . mysql_real_escape_string($LogEmail->CcEmails) . "',";
			$update .= "BccEmails = '" . mysql_real_escape_string($LogEmail->BccEmails) . "',";
			$update .= "FromEmail = '" . mysql_real_escape_string($LogEmail->FromEmail) . "',";
			$update .= "ReplyEmail = '" . mysql_real_escape_string($LogEmail->ReplyEmail) . "',";
			$update .= "Subject = '" . mysql_real_escape_string($LogEmail->Subject) . "',";
			$update .= "Message = '" . mysql_real_escape_string($LogEmail->Message) . "',";
			$update .= "Successful = " . mysql_real_escape_string($LogEmail->Successful) . ",";
			$update .= "SmtpHost = '" . mysql_real_escape_string($LogEmail->SmtpHost) . "',";
			$update .= "SmtpUsername = '" . mysql_real_escape_string($LogEmail->SmtpUsername) . "'";
			$sql = "update LogEmail set " . $update . " where EmailLogId = " . mysql_real_escape_string($LogEmail->EmailLogId);
			mysql_query($sql);
		}
		mysql_close ($conn);
	}
}
?>