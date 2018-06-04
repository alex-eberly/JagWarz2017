<!--- HEADER -->
<div class="header">
	<a href="<?php echo $fullUrl; ?>admin/dashboard.php"></a> 
</div>

<div class="top-bar">
	<ul id="nav">
		<li id="user-panel">
			<img src="<?php echo $fullUrl; ?>admin/assets/img/nav/usr-avatar.jpg" id="usr-avatar" alt="" />
			<div id="usr-info">
				<p id="usr-name"><?php echo $_SESSION["Username"]; ?></p>
				<p id="usr-notif">&nbsp;</p>
				<p><a href="<?php echo $fullUrl; ?>admin/profile.php">Profile</a><a href="<?php echo $fullUrl; ?>admin/logout.php">Log out</a></p>
				<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/admin/handlers/check-session.php'); ?>
			</div>
		</li>
		<li>
			<ul id="top-nav">
				<li class="nav-item">
					<a href="<?php echo $fullUrl; ?>admin/dashboard.php"><img src="<?php echo $fullUrl; ?>admin/assets/img/nav/dash.png" alt="" /><p>Dashboard</p></a>
				</li>
				<!--<li class="nav-item"> -->    <!-- Austin commented out Analytics tab becaause it served no purpose, was annoying -->
					<!-- <a href="http://google.com/analytics" target="_blank"><img src="<?php echo $fullUrl; ?>admin/assets/img/nav/anlt.png" alt="" /><p>Analytics</p></a> -->
				<!--</li>-->    <!-- Austin commented out Analytics tab becaause it served no purpose, was annoying -->
				<li class="nav-item">
					<a href="<?php echo $fullUrl; ?>admin/games.php"><img src="<?php echo $fullUrl; ?>admin/assets/img/nav/tb.png" alt="" /><p>Games</p></a>
				</li>
				<li class="nav-item">
					<a href="<?php echo $fullUrl; ?>admin/challenge_library.php"><img src="<?php echo $fullUrl; ?>admin/assets/img/nav/icn.png" alt="" /><p>Challenge Library</p></a>
				</li>
				<li class="nav-item">
					<a href="<?php echo $fullUrl; ?>admin/users.php"><img src="<?php echo $fullUrl; ?>admin/assets/img/nav/cal.png" alt="" /><p>Users</p></a>
				</li>
				<li class="nav-item">
					<a href="<?php echo $fullUrl; ?>admin/admin-users.php"><img src="<?php echo $fullUrl; ?>admin/assets/img/nav/widgets.png" alt="" /><p>Admin Users</p></a>
				</li>
				<li class="nav-item"> <!-- Austin added Roles tab on 9-29-17 -->
					<a href="<?php echo $fullUrl; ?>admin/role.php"><img src="<?php echo $fullUrl; ?>admin/assets/img/nav/grid.png" alt="" /><p>User Roles</p></a>
				</li>  <!-- Austin added Roles tab on 9-29-17 -->
				<li class="nav-item">
					<a href="<?php echo $fullUrl; ?>admin/teams.php"><img src="<?php echo $fullUrl; ?>admin/assets/img/nav/tb.png" alt="" /><p>Teams</p></a>
				
			</ul>
		</li>
	</ul>
</div>
<script type="text/javascript">
$(document).ready(function() {
	MarkActiveNav();
});
function MarkActiveNav() {
	$('#top-nav').find('li').each(function() {
		if ($(this).find('a').attr('href') == window.location.href.split('?')[0]) {
			$(this).addClass('active');
			var imageName = $(this).find('a').find('img').attr('src').replace(/^.*(\\|\/|\:)/, '');
			imageName = '<?php echo $fullUrl; ?>admin/assets/img/nav/' + imageName.replace('.png','') + '-active.png';
			$(this).find('a').find('img').attr('src', imageName);
		}
		else {
			var otherLinks = $(this).find('a').attr('otherlinks');
			if (otherLinks != null && otherLinks.indexOf(window.location.href.split('?')[0]) > -1) {
				$(this).addClass('active');
			}
			else {
				$(this).removeClass('active');
			}
		}
	});
}
</script>