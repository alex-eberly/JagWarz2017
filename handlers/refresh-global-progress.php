<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/assets/classes/core.php"; ?>
<?php
$ProgressFactory = new ProgressFactory();
$ProgressArray = $ProgressFactory->GetAll(" order by DateCreated desc limit 10 ");
if (count($ProgressArray) > 0)
{
	echo "<ul class=\"progress-list\">";
	foreach($ProgressArray as $Progress)
	{
		echo "<li class=\"progress-item\">";
		//return user
		$UserFactory = new UserFactory();
		$User = $UserFactory->GetOne($Progress->UserId);
		if ($User->UserId > 0)
		{
			echo "<span class=\"username\">" . $User->Username . "</span> ";
		}
		echo $Progress->Status;
		echo "</li>";
	}
	echo "</ul>";
}
?>