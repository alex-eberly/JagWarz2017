<?php
//global variables
$systemUrl = "jagwarz-dev.cit.iupui.edu";
$systemName = "jagwarz-dev";
$ssl = "http://";
$fullUrl = $ssl . $systemUrl . '/';
date_default_timezone_set('America/Indiana/Indianapolis');
ini_set("log_errors" , "1");
ini_set("display_errors" , "1");
$ajaxRefreshInSeconds = 5;
//some file types
$allowedExtensions = array("jpeg", "jpg", "png", "gif", "zip", "csv", "docx", "doc");
$jsAllowedExtensions = '"jpeg", "jpg", "png", "gif", "zip", "csv", "docx", "doc"';
//all file types
//$allowedExtensions = array();

/*
//db connection production
$dbserver = "localhost";
$db = "jagwarz";
$dbuser = "warzdb";
$dbpassword = "1be4testing";
*/

//db connection dev
$dbserver = "localhost";
$db = "dev_jagwarz";
$dbuser = "warzdb";
$dbpassword = "1be4testing";



/*

//email
$emailFrom = "livlab@iupui.edu";
$emailHost = "mail-relay.iu.edu";
$emailPort = 465;
$emailUsername = "livlab@iupui.edu";
$emailPassword = "rocketman burning on a fuel of air alone";

*/


$emailFrom = "iupuilivinglab@gmail.com";
$emailHost = "ssl://smtp.gmail.com";
$emailPort = 465;
$emailUsername = "iupuilivinglab@gmail.com";
$emailPassword = "JHRrApS7y8qvOBx3hHF0";






?>
