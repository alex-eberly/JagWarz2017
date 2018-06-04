<?php include("../includes/dataObjects.php"); ?>
<?php
$filename = "";
if (isset($_GET["filename"])) 
{
	$filename = $_GET["filename"];
}
$file = "../temp/" . $filename;
if(!file_exists($file))
{
	// File doesn't exist, output error
	die('File not found');
}
else
{
	// Set headers
	header("Cache-Control: public");
	header("Content-Description: File Transfer");
	header("Content-Disposition: attachment; filename=$filename");
	header("Content-Type: text/php");
	header("Content-Transfer-Encoding: binary");
	// Read the file from disk
	readfile($file);
	unlink($file);
}
?>