<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/assets/classes/core.php"; ?>
<?php
$Id = "";
if (isset($_POST["Id"])) 
{
	$Id = $_POST["Id"];
}
$UserGameFactory = new GameChallengeFactory();
$UserGameArray = $GameChallengeFactory->GetAllByGame(" where UserGamesId = " . escapeString($Id));

foreach($UserGameArray as $i){
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