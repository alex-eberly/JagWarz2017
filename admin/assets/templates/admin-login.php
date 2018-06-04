<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/assets/classes/core.php'); ?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>JagWaRz - Admin</title>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<link rel="shortcut icon" href="<?php echo $fullUrl; ?>admin/favicon.gif">
	<!---CSS Files-->
	<link rel="stylesheet" href="<?php echo $fullUrl; ?>admin/assets/css/master.css">
	<link rel="stylesheet" href="<?php echo $fullUrl; ?>admin/assets/css/login.css">
	<link rel="stylesheet" href="<?php echo $fullUrl; ?>admin/assets/css/styles.css">
	<!---jQuery Files-->
	<script src="<?php echo $fullUrl; ?>admin/assets/js/jquery-1.7.1.min.js"></script>
	<!---Fonts-->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
	<!--[if lt IE 9]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>
<body>
	<?php include($content); ?>
	<script src="<?php echo $fullUrl; ?>admin/assets/js/jquery.spinner.js"></script>
	<script type="text/javascript" src="<?php echo $fullUrl; ?>assets/js/plugins/jvalidate/jquery.jvalidate.js"></script>
	<!-- analytics -->
	<!-- Piwik -->
	<script type="text/javascript">
	  var _paq = _paq || [];
	  _paq.push(["trackPageView"]);
	  _paq.push(["enableLinkTracking"]);
	
	  (function() {
	    var u=(("https:" == document.location.protocol) ? "https" : "http") + "://analytics.lindleworks.com/";
	    _paq.push(["setTrackerUrl", u+"piwik.php"]);
	    _paq.push(["setSiteId", "13"]);
	    var d=document, g=d.createElement("script"), s=d.getElementsByTagName("script")[0]; g.type="text/javascript";
	    g.defer=true; g.async=true; g.src=u+"piwik.js"; s.parentNode.insertBefore(g,s);
	  })();
	</script>
	<!-- End Piwik Code -->
	<!-- end analytics -->
</body>
</html>