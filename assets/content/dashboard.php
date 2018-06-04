<div class="row">
	<div class="col-md-12">
		<div class="bounding-box">
			<div class="bounding-box-inner">
				<h1>MY GAMES</h1>
				<?php 
					$GameFactory = new GameFactory();
					$GamesArray = $GameFactory->GetAll(" where Active = 1 and GameId in (select GameId from UserGame where UserId = " . $_SESSION["UserId"] . ") ");
					if (count($GamesArray) > 0)
					{
						foreach ($GamesArray as $Game)
						{
							echo "<a href=\"" . $fullUrl . "game.php?GameId=" . $Game->GameId . "\" class=\"list-group-item\">";
							echo "<h4 class=\"list-group-item-heading\">$Game->Title</h4>";
							$timestamp = time();
							if($timestamp >= strtotime($Game->OpenDate) && $timestamp <= strtotime($Game->CloseDate))
							{
								echo "<p class=\"list-group-item-text\">" . $Game->Description . "</p>";
							}
							else 
							{
								echo "<p class=\"list-group-item-text\">" . $Game->ClosedDescription . "</p>";
							}
							echo "<p class=\"list-group-item-text\">" . $Game->GameType . " Game" . "</p>";
							echo "</a>";
						}
					}
					else
					{
						echo "<h4 class=\"list-group-item-heading center\">You have no games!</h4>";
					}
				?>
			</div> <!-- /bounding-box-inner -->
		</div> <!-- /bounding-box -->
	</div> <!-- /col-md-6 -->
</div> <!-- /row -->
<div class="row">
	<div class="col-md-12">
		<div class="bounding-box">
			<div class="bounding-box-inner">
				<h1>ALL GAMES</h1>
				<input type="text" id="mySearch" onkeyup="searchFunction()" placeholder="Search for games..">
				<div class="list-group">
				<?php 
					$GameFactory = new GameFactory();
					$GamesArray = $GameFactory->GetAll(" where Active = 1 and GameId not in (select GameId from UserGame where UserId = " . $_SESSION["UserId"] . ") ");
					if (count($GamesArray) > 0)
					{
						echo "<ul id='GamesArray' style='padding:0'>";
						foreach ($GamesArray as $Game)
						{
							echo "<li style='list-style-type:none'><a href=\"" . $fullUrl . "game.php?GameId=" . $Game->GameId . "\" class=\"list-group-item\">";
							echo "<h4 class=\"list-group-item-heading\">$Game->Title</h4>";
							$timestamp = time();
							if($timestamp >= strtotime($Game->OpenDate) && $timestamp <= strtotime($Game->CloseDate))
							{
								echo "<p class=\"list-group-item-text\">" . $Game->Description . "</p>";
							}
							else 
							{
								echo "<p class=\"list-group-item-text\">" . $Game->ClosedDescription . "</p>";
							}
							echo "<p class=\"list-group-item-text\">" . $Game->GameType . " Game" . "</p>";
							echo "</a></li>";
						}
						echo "</ul>";
					}
					else
					{
						echo "<h4 class=\"list-group-item-heading center\">There are no games!</h4>";
					}
				?>
				</div>
			</div> <!-- /bounding-box-inner -->
		</div> <!-- /bounding-box -->
	</div> <!-- /col-md-6 -->
</div> <!-- /row -->
<script type="text/javascript" src="<?php echo $fullUrl; ?>assets/js/plugins/passstrength/jquery.passstrength.min.js"></script>
<script>

function searchFunction() {
    // Declare variables
    var input, filter, ul, li, a, i;
    input = document.getElementById('mySearch');
    filter = input.value.toUpperCase();
    ul = document.getElementById('GamesArray');
    li = ul.getElementsByTagName('li');

    // Loop through all list items, and hide those who don't match the search query
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
}</script> 