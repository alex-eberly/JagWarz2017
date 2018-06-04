<?php
	if (!isset($_SESSION['UserId']) || $_SESSION["UserId"] == "")
    {
        session_destroy();
        //redirect to login page
	    header('Location: ' . $fullUrl);
    }
?>