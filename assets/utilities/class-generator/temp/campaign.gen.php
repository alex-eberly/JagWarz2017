<?php
//Globals
$dbserver = "localhost";
$db = "mlindle_pledgeforge";
$dbuser = "mlindle_dbuser";
$dbpassword = "zombiept2";
//Usage
/*
<?php include 'campaign.gen.php' ?>
<?php
$campaignFactory = new campaignFactory();
$campaign = $campaignFactory->GetOne(1);
echo $campaign->AccountId . "<br />";
unset($campaign);
$campaignArray = $campaignFactory->GetAll(' where CampaignId = 1 ');
foreach ($campaignArray as &$value)
{
	echo $value->AccountId . "<br />";
}
unset($value);
?>
*/
//Core Class
class campaign
{
	var $CampaignId;
	var $AccountId;
	var $Name;
	var $Description;
	var $RecipientEmails;
	var $GoalAmount;
	var $AutoResponseEmailMessage;
	var $LogoPath;
	var $ProgressFillColor;
	var $ProgressCompleteFillColor;
	var $LinkColor;
	var $HeaderLinkColor;
	var $HeaderActiveLinkColor;
	var $MainBarBgColor;
	var $MainBarTopGradientColor;
	var $MainBarBottomGradientColor;
	var $NavBarActiveBgColor;
	var $PledgePercentageColor;
	var $DateCreated;
	var $IsActive;
	function setCampaignId($CampaignId)
	{
		$this->CampaignId = $CampaignId;
	}
	function getCampaignId()
	{
		return $this->CampaignId;
	}
	function setAccountId($AccountId)
	{
		$this->AccountId = $AccountId;
	}
	function getAccountId()
	{
		return $this->AccountId;
	}
	function setName($Name)
	{
		$this->Name = $Name;
	}
	function getName()
	{
		return $this->Name;
	}
	function setDescription($Description)
	{
		$this->Description = $Description;
	}
	function getDescription()
	{
		return $this->Description;
	}
	function setRecipientEmails($RecipientEmails)
	{
		$this->RecipientEmails = $RecipientEmails;
	}
	function getRecipientEmails()
	{
		return $this->RecipientEmails;
	}
	function setGoalAmount($GoalAmount)
	{
		$this->GoalAmount = $GoalAmount;
	}
	function getGoalAmount()
	{
		return $this->GoalAmount;
	}
	function setAutoResponseEmailMessage($AutoResponseEmailMessage)
	{
		$this->AutoResponseEmailMessage = $AutoResponseEmailMessage;
	}
	function getAutoResponseEmailMessage()
	{
		return $this->AutoResponseEmailMessage;
	}
	function setLogoPath($LogoPath)
	{
		$this->LogoPath = $LogoPath;
	}
	function getLogoPath()
	{
		return $this->LogoPath;
	}
	function setProgressFillColor($ProgressFillColor)
	{
		$this->ProgressFillColor = $ProgressFillColor;
	}
	function getProgressFillColor()
	{
		return $this->ProgressFillColor;
	}
	function setProgressCompleteFillColor($ProgressCompleteFillColor)
	{
		$this->ProgressCompleteFillColor = $ProgressCompleteFillColor;
	}
	function getProgressCompleteFillColor()
	{
		return $this->ProgressCompleteFillColor;
	}
	function setLinkColor($LinkColor)
	{
		$this->LinkColor = $LinkColor;
	}
	function getLinkColor()
	{
		return $this->LinkColor;
	}
	function setHeaderLinkColor($HeaderLinkColor)
	{
		$this->HeaderLinkColor = $HeaderLinkColor;
	}
	function getHeaderLinkColor()
	{
		return $this->HeaderLinkColor;
	}
	function setHeaderActiveLinkColor($HeaderActiveLinkColor)
	{
		$this->HeaderActiveLinkColor = $HeaderActiveLinkColor;
	}
	function getHeaderActiveLinkColor()
	{
		return $this->HeaderActiveLinkColor;
	}
	function setMainBarBgColor($MainBarBgColor)
	{
		$this->MainBarBgColor = $MainBarBgColor;
	}
	function getMainBarBgColor()
	{
		return $this->MainBarBgColor;
	}
	function setMainBarTopGradientColor($MainBarTopGradientColor)
	{
		$this->MainBarTopGradientColor = $MainBarTopGradientColor;
	}
	function getMainBarTopGradientColor()
	{
		return $this->MainBarTopGradientColor;
	}
	function setMainBarBottomGradientColor($MainBarBottomGradientColor)
	{
		$this->MainBarBottomGradientColor = $MainBarBottomGradientColor;
	}
	function getMainBarBottomGradientColor()
	{
		return $this->MainBarBottomGradientColor;
	}
	function setNavBarActiveBgColor($NavBarActiveBgColor)
	{
		$this->NavBarActiveBgColor = $NavBarActiveBgColor;
	}
	function getNavBarActiveBgColor()
	{
		return $this->NavBarActiveBgColor;
	}
	function setPledgePercentageColor($PledgePercentageColor)
	{
		$this->PledgePercentageColor = $PledgePercentageColor;
	}
	function getPledgePercentageColor()
	{
		return $this->PledgePercentageColor;
	}
	function setDateCreated($DateCreated)
	{
		$this->DateCreated = $DateCreated;
	}
	function getDateCreated()
	{
		return $this->DateCreated;
	}
	function setIsActive($IsActive)
	{
		$this->IsActive = $IsActive;
	}
	function getIsActive()
	{
		return $this->IsActive;
	}
}
//Factory Class
class campaignFactory
{
	function GetOne($CampaignId)
	{
		$campaign = new campaign();
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$sql = "select * from campaign where CampaignId = " . mysql_real_escape_string($CampaignId);
			$result=mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{
				$campaign->CampaignId = $row['CampaignId'];
				$campaign->AccountId = $row['AccountId'];
				$campaign->Name = $row['Name'];
				$campaign->Description = $row['Description'];
				$campaign->RecipientEmails = $row['RecipientEmails'];
				$campaign->GoalAmount = $row['GoalAmount'];
				$campaign->AutoResponseEmailMessage = $row['AutoResponseEmailMessage'];
				$campaign->LogoPath = $row['LogoPath'];
				$campaign->ProgressFillColor = $row['ProgressFillColor'];
				$campaign->ProgressCompleteFillColor = $row['ProgressCompleteFillColor'];
				$campaign->LinkColor = $row['LinkColor'];
				$campaign->HeaderLinkColor = $row['HeaderLinkColor'];
				$campaign->HeaderActiveLinkColor = $row['HeaderActiveLinkColor'];
				$campaign->MainBarBgColor = $row['MainBarBgColor'];
				$campaign->MainBarTopGradientColor = $row['MainBarTopGradientColor'];
				$campaign->MainBarBottomGradientColor = $row['MainBarBottomGradientColor'];
				$campaign->NavBarActiveBgColor = $row['NavBarActiveBgColor'];
				$campaign->PledgePercentageColor = $row['PledgePercentageColor'];
				$campaign->DateCreated = $row['DateCreated'];
				$campaign->IsActive = $row['IsActive'];
			}
		}
		mysql_close ($conn);
		return $campaign;
	}
	function GetAll($filter)
	{
		$campaignArray = Array();
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$sql = "select * from campaign " . $filter;
			$result=mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{
				$campaign = new campaign();
				$campaign->CampaignId = $row['CampaignId'];
				$campaign->AccountId = $row['AccountId'];
				$campaign->Name = $row['Name'];
				$campaign->Description = $row['Description'];
				$campaign->RecipientEmails = $row['RecipientEmails'];
				$campaign->GoalAmount = $row['GoalAmount'];
				$campaign->AutoResponseEmailMessage = $row['AutoResponseEmailMessage'];
				$campaign->LogoPath = $row['LogoPath'];
				$campaign->ProgressFillColor = $row['ProgressFillColor'];
				$campaign->ProgressCompleteFillColor = $row['ProgressCompleteFillColor'];
				$campaign->LinkColor = $row['LinkColor'];
				$campaign->HeaderLinkColor = $row['HeaderLinkColor'];
				$campaign->HeaderActiveLinkColor = $row['HeaderActiveLinkColor'];
				$campaign->MainBarBgColor = $row['MainBarBgColor'];
				$campaign->MainBarTopGradientColor = $row['MainBarTopGradientColor'];
				$campaign->MainBarBottomGradientColor = $row['MainBarBottomGradientColor'];
				$campaign->NavBarActiveBgColor = $row['NavBarActiveBgColor'];
				$campaign->PledgePercentageColor = $row['PledgePercentageColor'];
				$campaign->DateCreated = $row['DateCreated'];
				$campaign->IsActive = $row['IsActive'];
				$campaignArray[] = $campaign;
			}
		}
		mysql_close ($conn);
		return $campaignArray;
	}
	function Insert($campaign)
	{
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$insert = "";
			$insert .= mysql_real_escape_string($campaign->AccountId) . ",";
			$insert .= "'" . mysql_real_escape_string($campaign->Name) . "',";
			$insert .= "'" . mysql_real_escape_string($campaign->Description) . "',";
			$insert .= "'" . mysql_real_escape_string($campaign->RecipientEmails) . "',";
			$insert .= mysql_real_escape_string($campaign->GoalAmount) . ",";
			$insert .= "'" . mysql_real_escape_string($campaign->AutoResponseEmailMessage) . "',";
			$insert .= "'" . mysql_real_escape_string($campaign->LogoPath) . "',";
			$insert .= "'" . mysql_real_escape_string($campaign->ProgressFillColor) . "',";
			$insert .= "'" . mysql_real_escape_string($campaign->ProgressCompleteFillColor) . "',";
			$insert .= "'" . mysql_real_escape_string($campaign->LinkColor) . "',";
			$insert .= "'" . mysql_real_escape_string($campaign->HeaderLinkColor) . "',";
			$insert .= "'" . mysql_real_escape_string($campaign->HeaderActiveLinkColor) . "',";
			$insert .= "'" . mysql_real_escape_string($campaign->MainBarBgColor) . "',";
			$insert .= "'" . mysql_real_escape_string($campaign->MainBarTopGradientColor) . "',";
			$insert .= "'" . mysql_real_escape_string($campaign->MainBarBottomGradientColor) . "',";
			$insert .= "'" . mysql_real_escape_string($campaign->NavBarActiveBgColor) . "',";
			$insert .= "'" . mysql_real_escape_string($campaign->PledgePercentageColor) . "',";
			$insert .= "'" . mysql_real_escape_string($campaign->DateCreated) . "',";
			$insert .= mysql_real_escape_string($campaign->IsActive);
			$sql = "insert into campaign (AccountId,Name,Description,RecipientEmails,GoalAmount,AutoResponseEmailMessage,LogoPath,ProgressFillColor,ProgressCompleteFillColor,LinkColor,HeaderLinkColor,HeaderActiveLinkColor,MainBarBgColor,MainBarTopGradientColor,MainBarBottomGradientColor,NavBarActiveBgColor,PledgePercentageColor,DateCreated,IsActive) values (" . $insert . ")";
			mysql_query($sql);
			$campaign->CampaignId = mysql_insert_id();
		}
		mysql_close ($conn);
		return $campaign;
	}
	function Update($campaign)
	{
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$update = "";
			$update .= "AccountId = " . mysql_real_escape_string($campaign->AccountId) . ",";
			$update .= "Name = '" . mysql_real_escape_string($campaign->Name) . "',";
			$update .= "Description = '" . mysql_real_escape_string($campaign->Description) . "',";
			$update .= "RecipientEmails = '" . mysql_real_escape_string($campaign->RecipientEmails) . "',";
			$update .= "GoalAmount = " . mysql_real_escape_string($campaign->GoalAmount) . ",";
			$update .= "AutoResponseEmailMessage = '" . mysql_real_escape_string($campaign->AutoResponseEmailMessage) . "',";
			$update .= "LogoPath = '" . mysql_real_escape_string($campaign->LogoPath) . "',";
			$update .= "ProgressFillColor = '" . mysql_real_escape_string($campaign->ProgressFillColor) . "',";
			$update .= "ProgressCompleteFillColor = '" . mysql_real_escape_string($campaign->ProgressCompleteFillColor) . "',";
			$update .= "LinkColor = '" . mysql_real_escape_string($campaign->LinkColor) . "',";
			$update .= "HeaderLinkColor = '" . mysql_real_escape_string($campaign->HeaderLinkColor) . "',";
			$update .= "HeaderActiveLinkColor = '" . mysql_real_escape_string($campaign->HeaderActiveLinkColor) . "',";
			$update .= "MainBarBgColor = '" . mysql_real_escape_string($campaign->MainBarBgColor) . "',";
			$update .= "MainBarTopGradientColor = '" . mysql_real_escape_string($campaign->MainBarTopGradientColor) . "',";
			$update .= "MainBarBottomGradientColor = '" . mysql_real_escape_string($campaign->MainBarBottomGradientColor) . "',";
			$update .= "NavBarActiveBgColor = '" . mysql_real_escape_string($campaign->NavBarActiveBgColor) . "',";
			$update .= "PledgePercentageColor = '" . mysql_real_escape_string($campaign->PledgePercentageColor) . "',";
			$update .= "DateCreated = '" . mysql_real_escape_string($campaign->DateCreated) . "',";
			$update .= "IsActive = " . mysql_real_escape_string($campaign->IsActive);
			$sql = "update campaign set " . $update . " where CampaignId = " . mysql_real_escape_string($campaign->CampaignId);
			mysql_query($sql);
		}
		mysql_close ($conn);
	}
}
?>