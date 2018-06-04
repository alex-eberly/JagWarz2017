<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/assets/classes/core.php"; ?>
<?php
$Id = "";
if (isset($_POST["Id"])) 
{
	$Id = $_POST["Id"];
}
$GameChallengeFactory = new GameChallengeFactory();
$GameChallengeArray = $GameChallengeFactory->GetAllByGame(" where GameId = " . escapeString($Id));

foreach($GameChallengeArray as $i){
	$max = max($max, $i[3]);
//ajaxSave(aData[row][0]);	
						
}
echo $max;
/*if (count($GameChallengeArray) > 0)
{ 
	foreach ($GameChallengeArray as &$value)
	{
		?>

		<?php
	}
}
else
{
?>

<?php
}*/
?>