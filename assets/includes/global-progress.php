<div class="col-md-12">
	<div class="bounding-box">
		<div class="bounding-box-inner" style="padding:10px;">
			<h1>GLOBAL PROGRESS</h1>
			<div id="global-progress">
			<?php
			$ProgressFactory = new ProgressFactory();
			$ProgressArray = $ProgressFactory->GetAll(" order by DateCreated desc limit 10 ");
			if (count($ProgressArray) > 0)
			{
				echo "<ul class=\"progress-list\">";
				foreach($ProgressArray as $Progress)
				{
					echo "<li class=\"progress-item\">";
					//return user
					$UserFactory = new UserFactory();
					$User = $UserFactory->GetOne($Progress->UserId);
					if ($User->UserId > 0)
					{
						echo "<span class=\"username\">" . $User->Username . "</span> ";
					}
					echo $Progress->Status;
					echo "</li>";
				}
				echo "</ul>";
			}
			?>
			</div>
		</div> <!-- /bounding-box-inner -->
	</div> <!-- /bounding-box -->
</div>
<script type="text/javascript">
$(document).ready(function() {
	setTimeout('checkForGlobalProgressUpdates()', <?php echo $ajaxRefreshInSeconds * 1000; ?>);
});
function checkForGlobalProgressUpdates() {
	$.post('<?php echo $fullUrl; ?>handlers/refresh-global-progress.php', {  }, function (output) {
		$('#global-progress').html(output);
	});
	setTimeout('checkForGlobalProgressUpdates()', <?php echo $ajaxRefreshInSeconds * 1000; ?>);
}
</script>