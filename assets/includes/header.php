<div class="container-fluid">
	<div class="row-fluid">
		<div class="col-md-12">
			<div class="bounding-box" style="margin-top:15px;">
				<div class="bounding-box-inner" style="padding:10px;">
					<div class="row">
						<div class="col-md-6">
					<?php
					if (isset($_SESSION['UserId']))
					{
						?>
						<a class="brand" href="<?php $fullUrl ?>dashboard.php"><?php echo $systemName; ?></a>
						<?php
					}
					else
					{
						?>
						<a class="brand" href="<?php $fullUrl ?>index.php"><?php echo $systemName; ?></a>
						<?php
					}
					?>
						</div>
						<div class="col-md-6" class="pull-right">
					<span id="logout-btn" class="pull-right">
						<?php 
						if (!isset($_SESSION['UserId']) || $_SESSION['UserId'] == "")
					    {
					        session_destroy();
					        if (isset($_COOKIE[$systemName])) {
								header('Location: handlers/auto-authenticate-user.php');
							}
					        if (curPageURL() !== $fullUrl && curPageURL() !== $fullUrl . 'index.php' && curPageURL() !== $fullUrl . 'forgot-password.php' && curPageURL() !== $fullUrl . 'register.php') 
					        {
					        	//redirect to login
					        	header('Location: ' . $fullUrl);
						    }
					    }
					    else
					    {
					    	if (curPageURL() === $fullUrl || curPageURL() === $fullUrl . 'index.php') 
					        {
					        	header('Location: ' . $fullUrl . 'dashboard.php');
					        }
					        else
					        {
						    	echo '<div style="display:inline-block;padding-top:8px;padding-right:10px;"><a href="' . $fullUrl . 'edit-account.php">' . $_SESSION['Lastname'] . ', ' . $_SESSION['Firstname'] . '</a></div><a class="btn btn-default btn-orange pull-right" style="padding-top:6px;font-size:18px;" href="' . $fullUrl . 'logout.php">LOGOUT</a>';
						    }
					    }
						?>
					</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>