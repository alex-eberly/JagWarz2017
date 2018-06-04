<?php
session_start();
function ninja_mysql_num_rows($sql){
	$count=0;
	global $dbserver,$db,$user,$password;
	$con = mysql_connect($dbserver,$user,$password);
	if ($con)
	{
		mysql_select_db($db, $con);
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)){
			$count++;
		}
	}
	return $count;
}
?>