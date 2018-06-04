<?php ob_start(); ?>
<?php include("includes/dataObjects.php"); ?>
<?php
$txtDbServer = "";
$txtDatabase = "";
$txtUsername = "";
$txtPassword = "";
if (isset($_GET['reset']))
{
	if ($_GET['reset'] == 1)
	{
		session_destroy();
		header('Location: index.php');
	}
}
if (isset($_SESSION['txtDbServer'])) {
	$txtDbServer = $_SESSION['txtDbServer'];
}
if (isset($_SESSION['txtDatabase'])) {
	$txtDatabase = $_SESSION['txtDatabase'];
}
if (isset($_SESSION['txtUsername'])) {
	$txtUsername = $_SESSION['txtUsername'];
}
if (isset($_SESSION['txtPassword'])) {
	$txtPassword = $_SESSION['txtPassword'];
}
?>
<html>
<head>
<title>Class Generator</title>
<script type="text/javascript" src="includes/jquery.min.js"></script>
<link href="includes/styles.css" type="text/css" />
<script type="text/javascript">
	$(document).ready(function() {
		SetDefaultButtons();
		$('#user_login').focus();
	});
	function SetDefaultButtons() {
		//setup default form buttons
		var $btn = $('.default-button');
		var $form = $btn.parents('.form-container');

		$form.keypress(function(e) {
			if (e.which == 13 && e.target.type != 'textarea') {
				$btn[0].click();
				return false;
			}
		});
	}
	function ajaxGetDatabaseObjects() {
		if (ValidateConnectionForm()) {
			$('#loader1').show();
			$.post('handlers/returnDbObjects.php', { dbServer: $('#txtDbServer').val(), database: $('#txtDatabase').val(), username: $('#txtUsername').val(), password: $('#txtPassword').val() }, function(output) {
				$('#dbObjects').html(output).show();
				$('#loader1').hide();
				if (output.length > 0)
				{
					$('#dbObjectSelection').show();
					$('#dbConnection').hide();
					//load hidden values
					$('#hdnDbServer').val($('#txtDbServer').val());
					$('#hdnDatabase').val($('#txtDatabase').val());
					$('#hdnUsername').val($('#txtUsername').val());
					$('#hdnPassword').val($('#txtPassword').val());
				}
				else
				{
					$('#dbObjectSelection').hide();
					$('#dbConnection').show();
				}
			});
		}
	}
	function ajaxGenerateClass() {
		if (ValidateCreateForm()) {
			$('#loader2').show();
			var includeDbConnection = 0;
			if ($('#chbIncludeDbConnection').is(":checked")) {
				includeDbConnection = 1;
			}
			$.post('handlers/createClass.php', { dbServer: $('#txtDbServer').val(), database: $('#txtDatabase').val(), username: $('#txtUsername').val(), password: $('#txtPassword').val(), table: $('#lbTables').val(), includeDbConnection: includeDbConnection  }, function(output) {
				$('#classFile').html(output).show();
				$('#loader2').hide();
				if (output.length > 0)
				{
					$('#classFile').show();
				}
				else
				{
					$('#classFile').hide();
				}
			});
		}
	}
	function ValidateCreateForm() 
	{
		var errors = 0;
		if ($('#lbTables option:selected').length == 0) {
			errors += 1;
			$('#lbTables').css({
				'backgroundColor': '#FFEBE8',
				'border': 'solid 1px #C00'
			});
			$('#lbTables').bind('blur', function() {
				if ($('#lbTables').val() != "") {
					$('#lbTables').css({
						'backgroundColor': '',
						'border': ''
					});
				}
			});
		}
		if (errors == 0) {
			return true;
		}
		else {
			return false;
		}
	}
	function ValidateConnectionForm() 
	{
		var errors = 0;
		if ($('#txtDbServer').val() == "") {
			errors += 1;
			$('#txtDbServer').css({
				'backgroundColor': '#FFEBE8',
				'border': 'solid 1px #C00'
			});
			$('#txtDbServer').bind('blur', function() {
				if ($('#txtDbServer').val() != "") {
					$('#txtDbServer').css({
						'backgroundColor': '',
						'border': ''
					});
				}
			});
		}
		if ($('#txtDatabase').val() == "") {
			errors += 1;
			$('#txtDatabase').css({
				'backgroundColor': '#FFEBE8',
				'border': 'solid 1px #C00'
			});
			$('#txtDatabase').bind('blur', function() {
				if ($('#txtDatabase').val() != "") {
					$('#txtDatabase').css({
						'backgroundColor': '',
						'border': ''
					});
				}
			});
		}
		if ($('#txtUsername').val() == "") {
			errors += 1;
			$('#txtUsername').css({
				'backgroundColor': '#FFEBE8',
				'border': 'solid 1px #C00'
			});
			$('#txtUsername').bind('blur', function() {
				if ($('#txtUsername').val() != "") {
					$('#txtUsername').css({
						'backgroundColor': '',
						'border': ''
					});
				}
			});
		}
		if (errors == 0) {
			return true;
		}
		else {
			return false;
		}
	}
</script>
</head>
<body>
<form name="dbConnection" method="post" action="#" id="dbConnection">
	<div class="form-container">
		<strong>Enter your database information</strong>
		<br />
		Database Server
		<br />
		<input type="text" style="width:98%" name="txtDbServer" id="txtDbServer" value="<?php echo $txtDbServer; ?>" />
		<br /><br />
		Database Name
		<br />
		<input type="text" style="width:98%" name="txtDatabase" id="txtDatabase" value="<?php echo $txtDatabase; ?>" />
		<br /><br />
		Username
		<br />
		<input type="text" style="width:98%" name="txtUsername" id="txtUsername" value="<?php echo $txtUsername; ?>" />
		<br /><br />
		Password 
		<input type="text" style="width:98%" name="txtPassword" id="txtPassword" value="<?php echo $txtPassword; ?>" />
		<br /><br />
		<input type="checkbox" name="chbIncludeDbConnection" id="chbIncludeDbConnection" /> <label for="chbIncludeDbConnection">Include Db Connection</label>
		<br /><br />
		<input type="button" value="Connect" class="default-button" onclick="ajaxGetDatabaseObjects()" /><img src="includes/ajax-loader.gif" alt="Loading" id="loader1" style="vertical-align:middle;display:none;" />
	</div>
</form>
<form name="dbObjectSelection" id="dbObjectSelection" method="post" action="#" style="display:none;">
	<div class="form-container">
		<div id="dbObjects"></div>
		<br />
		<input type="button" value="Generate" class="default-button" onclick="ajaxGenerateClass()" /><img src="includes/ajax-loader.gif" alt="Loading" id="loader2" style="vertical-align:middle;display:none;" />
		<div id="classFile"></div>
	</div>
</form>
<form name="formReset" id="formReset" method="get" action="#">
	<input type="button" value="Choose Another" class="default-button" onclick="javascript:window.location='index.php';" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Reset" class="default-button" onclick="javascript:window.location='index.php?reset=1';" />
</form>
<!-- Piwik --> 
<script type="text/javascript">
var pkBaseURL = (("https:" == document.location.protocol) ? "https://analytics.lindleworks.com/" : "http://analytics.lindleworks.com/");
document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
</script><script type="text/javascript">
try {
var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", 1);
piwikTracker.trackPageView();
piwikTracker.enableLinkTracking();
} catch( err ) {}
</script><noscript><p><img src="http://analytics.lindleworks.com/piwik.php?idsite=1" style="border:0" alt="" /></p></noscript>
<!-- End Piwik Tracking Code -->
</body>
</html>
<?php ob_flush(); ?>