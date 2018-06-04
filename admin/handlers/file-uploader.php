<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/assets/classes/core.php"; ?>
<?php

//NOW saved in config.php
//some file types
//$allowedExtensions = array("jpeg", "jpg", "png", "gif", "zip", "csv", "docx", "doc");
//all file types
//$allowedExtensions = array();

$sizeLimit = 50 * 1024 * 1024;
require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/handlers/file-upload-handler.php';

$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);

$result = $uploader->handleUpload('../../files/');

echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);

?>

