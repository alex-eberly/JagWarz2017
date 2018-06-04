<?php
ob_start();
if (!isset($_SESSION)) {
  session_start();
  $_SESSION["timeout"] = 3600;
}
require_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";
foreach (glob($_SERVER['DOCUMENT_ROOT'] . "/assets/classes/generated/*.php") as $filename)
{
    include $filename;
}
foreach (glob($_SERVER['DOCUMENT_ROOT'] . "/assets/classes/*.php") as $filename)
{
	if (strpos($filename, 'core.php') === false)
	{
    	include $filename;
    }
}
//utilities
function getClientIP() {
     $ipaddress = '';
     if (getenv('HTTP_CLIENT_IP'))
         $ipaddress = getenv('HTTP_CLIENT_IP');
     else if(getenv('HTTP_X_FORWARDED_FOR'))
         $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
     else if(getenv('HTTP_X_FORWARDED'))
         $ipaddress = getenv('HTTP_X_FORWARDED');
     else if(getenv('HTTP_FORWARDED_FOR'))
         $ipaddress = getenv('HTTP_FORWARDED_FOR');
     else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
     else if(getenv('REMOTE_ADDR'))
         $ipaddress = getenv('REMOTE_ADDR');
     else
         $ipaddress = 'UNKNOWN';

     return $ipaddress; 
}
function escapeString($str)
{
	global $dbserver,$db,$dbuser,$dbpassword;
	$conn = new mysqli($dbserver, $dbuser, $dbpassword, $db);
	$escaped = '';
	if ($conn)
	{
		$escaped = $conn->real_escape_string($str);
		mysqli_close($conn); 
	}
	else
	{
		$escaped = $str;
	}
	return $escaped;
}
function curPageURL() {
	$pageURL = 'http';
	if (isset( $_SERVER["HTTPS"] ) && strtolower( $_SERVER["HTTPS"] ) == "on" )
	{
		$pageURL .= "s";
	}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") 
	{
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} 
	else 
	{
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	return $pageURL;
}
function utilitySendEmail($to,$subject,$msgText,$msgHtml)
{
    global $emailFrom,$emailHost,$emailPort,$emailUsername,$emailPassword;
    //send email
    require_once "Mail.php";
    require_once "Mail/mime.php";
    $from = $emailFrom;
    $body = "";
    $text = $msgText; 
    $html = $msgHtml;
    $crlf = "\n"; 
    $host = $emailHost;
    $port = $emailPort;
    $username = $emailUsername;
    $password = $emailPassword;
    $headers = array ('From' => $from,
      'To' => $to,
      'Subject' => $subject);
    $mime = new Mail_mime($crlf);
    $mime->setTXTBody($text);
    $mime->setHTMLBody($html);
    $body = $mime->get();
    $headers = $mime->headers($headers);
    $smtp = Mail::factory('smtp',
      array ('host' => $host,
      	'port' => $port,
        'auth' => true,
        'username' => $username,
        'password' => $password));
    $mail = $smtp->send($to, $headers, $body);
    
    if (PEAR::isError($mail)) 
    {   
        echo(" " . $mail->getMessage() . " ");
        LogEmail($subject,$html,$to,'','','',$from,$host,$username,0);
    } 
    else 
    {   
    	LogEmail($subject,$html,$to,'','','',$from,$host,$username,1);
    }
}
function LogEmail($subject,$message,$to,$cc,$bcc,$reply,$from,$host,$username,$success)
{
	$LogEmailFactory = new LogEmailFactory();
    $LogEmail = new LogEmail();
	$LogEmail->ToEmails = $to;
	$LogEmail->CcEmails = $cc;
	$LogEmail->BccEmails = $bcc;
	$LogEmail->FromEmail = $from;
	$LogEmail->ReplyEmail = $reply;
	$LogEmail->Subject = $subject;
	$LogEmail->Message = $message;
	$LogEmail->Successful = $success;
	$LogEmail->SmtpHost = $host;
	$LogEmail->SmtpUsername = $username;
	$timestamp = time();
	$LogEmail->DateSent = gmdate("Y-m-d H:i:s", $timestamp);
	$LogEmailFactory->Insert($LogEmail);
}
function isAuthenticated()
{
	
}
function generatePassword($length = 8)
{
    // start with a blank password
    $password = "";
    // define possible characters - any character in this string can be
    // picked for use in the password, so if you want to put vowels back in
    // or add special characters such as exclamation marks, this is where
    // you should do it
    $possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";
    // we refer to the length of $possible a few times, so let's grab it now
    $maxlength = strlen($possible);
    // check for length overflow and truncate if necessary
    if ($length > $maxlength) {
        $length = $maxlength;
    }
    // set up a counter for how many characters are in the password so far
    $i = 0; 
    // add random characters to $password until $length is reached
    while ($i < $length) { 
        // pick a random character from the possible ones
        $char = substr($possible, mt_rand(0, $maxlength-1), 1);
        // have we already used this character in $password?
        if (!strstr($password, $char)) { 
            // no, so it's OK to add it onto the end of whatever we've already got...
            $password .= $char;
            // ... and increase the counter by one
            $i++;
        }
    }
    return $password;
}
/**
 * mb_stripos all occurences
 * based on http://www.php.net/manual/en/function.strpos.php#87061
 *
 * Find all occurrences of a needle in a haystack
 *
 * @param string $haystack
 * @param string $needle
 * @return array or false
 */
function mb_stripos_all($haystack, $needle) {
 
  $s = 0;
  $i = 0;
 
  while(is_integer($i)) {
 
    $i = mb_stripos($haystack, $needle, $s);
 
    if(is_integer($i)) {
      $aStrPos[] = $i;
      $s = $i + mb_strlen($needle);
    }
  }
 
  if(isset($aStrPos)) {
    return $aStrPos;
  } else {
    return false;
  }
}
 
/**
 * Apply highlight to row label
 *
 * @param string $a_json json data
 * @param array $parts strings to search
 * @return array
 */
function apply_highlight($a_json, $parts) {
 
  $p = count($parts);
  $rows = count($a_json);
 
  for($row = 0; $row < $rows; $row++) {
 
    $label = $a_json[$row]["label"];
    $a_label_match = array();
 
    for($i = 0; $i < $p; $i++) {
 
      $part_len = mb_strlen($parts[$i]);
      $a_match_start = mb_stripos_all($label, $parts[$i]);
 
      foreach($a_match_start as $part_pos) {
 
        $overlap = false;
        foreach($a_label_match as $pos => $len) {
          if($part_pos - $pos >= 0 && $part_pos - $pos < $len) {
            $overlap = true;
            break;
          }
        }
        if(!$overlap) {
          $a_label_match[$part_pos] = $part_len;
        }
 
      }
 
    }
 
    if(count($a_label_match) > 0) {
      ksort($a_label_match);
 
      $label_highlight = '';
      $start = 0;
      $label_len = mb_strlen($label);
 
      foreach($a_label_match as $pos => $len) {
        if($pos - $start > 0) {
          $no_highlight = mb_substr($label, $start, $pos - $start);
          $label_highlight .= $no_highlight;
        }
        $highlight = '<span class="hl_results">' . mb_substr($label, $pos, $len) . '</span>';
        $label_highlight .= $highlight;
        $start = $pos + $len;
      }
 
      if($label_len - $start > 0) {
        $no_highlight = mb_substr($label, $start);
        $label_highlight .= $no_highlight;
      }
 
      $a_json[$row]["label"] = $label_highlight;
    }
 
  }
 
  return $a_json;
 
}

?>