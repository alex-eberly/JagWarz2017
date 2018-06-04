<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/assets/classes/core.php"; ?>
<?php
	if (!isset($_SESSION['UserId']) || $_SESSION["UserId"] == "")
    {
        session_destroy();
        //redirect to login
	    echo "<script type=\"text/javascript\">window.location='".$fullUrl."';</script>";
    }
?>