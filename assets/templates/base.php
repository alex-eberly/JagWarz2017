<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/assets/classes/core.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/assets/includes/head.php'); ?>
</head>
<body>
<div id="wrapper">
	<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/assets/includes/header.php'); ?>
	<div class="container-fluid" style="margin-bottom:40px;">
		<div class="row-fluid">
			<div class="col-md-7">
				<?php include($content); ?>
			</div>
			<div class="col-md-5">
				<div class="row">
					<?php 
					if (isset($sideScore))
					{
						include($sideScore);
					}
					if (isset($sideContent))
					{
						include($sideContent);
					}
					?>
					<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/assets/includes/global-progress.php'); ?>
				</div>
			</div>
		</div> <!-- /row -->
	</div>
	<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/assets/includes/footer.php'); ?>
</div>
</body>
</html>