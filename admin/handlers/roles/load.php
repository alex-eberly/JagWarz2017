<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/assets/classes/core.php"; ?>
<?php
$Id = "";

if (isset($_POST["Id"])) {
	$Id = $_POST["Id"];
}

$RoleFactory = new RoleFactory();
$RoleArray = $RoleFactory->GetAll(" where UserRoleId = " . escapeString($Id));

if (count($RoleArray) > 0) {
	foreach ($RoleArray as &$value) {
		?>
		<div class="box grid_12">
			<div class="box-head" style="text-align:center;"><h2>Role Edit</h2></div> <!--  Don't think we should allow assigning roles to be changed/edited - Austin 10/26/17 -->
			<div class="box-content bootstrap">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<input type="hidden" name="hdnId" id="hdnId" value="<?php echo $value->UserRoleId ?>" />
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<span class="form-label">Username *</span>
							<input type="hidden" name="Username" id="Username" value="<?php echo $value->Username ?>" />
							</div>
							<div class="col-md-3">
								<span class="form-label">Game Title*</span>
							<input type="hidden" name="Title" id="Title" value="<?php echo $value->Title ?>" />
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<span class="form-label">Role Type *</span><br>
								<input type="hidden" name="RoleType" id="RoleType" value="<?php echo $value->RoleType ?>" />
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<span class="form-label">Description</span>
								<textarea id="txtDescription" class="form-control" style="width:100%;height:100px;"><?php echo $value->Description ?></textarea>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 center">
								<a class="btn btn-default btn-success default-button" href="javascript:void(0);" onclick="CancelEdit();">Cancel</a> <!--<a class="btn btn-default btn-success" href="javascript:void(0);" onclick="ajaxSave();">Save</a>-->
							</div>
						</div>
					</div> <!-- /edit-container -->
				</div>
			</div> <!-- /container -->
		</div>
		<?php
	}
}
else
{
?>
<div class="box grid_12">
	<div class="box-head" style="text-align:center;"><h2>Role Add</h2></div>
	<div class="box-content bootstrap">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<input type="hidden" name="hdnId" id="hdnId" />
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						    <span class="form-label">Username *</span>
							
					<?php

					//*** Use this for displaying error messages //***
						  ini_set('error_reporting', E_ALL);
						  ini_set('display_errors', 1);

					//*** Create connection with mysqli (Works) //***
						  global $dbserver,$db,$dbuser,$dbpassword;
						  $conn = mysqli_connect($dbserver,$dbuser,$dbpassword);
						  
					//*** Check connection //***
						 if ($conn->connect_error) {
						       die("Connection failed: " . $conn->connect_error);
						 }
 
					//*** Create Query //***
						 $sql = "SELECT DISTINCT ug.UserId AS UserId, u.Username AS Username FROM dev_jagwarz.UserGame ug, dev_jagwarz.User u WHERE u.UserId = ug.UserId "; // also works, use DISTINCT for one time names
						 //$sql = "SELECT UserId, Username FROM dev_jagwarz.User"; one that works
						 
						 //$sql = "SELECT u.Username AS Username, u.UserId AS UserId, g.Title AS Title, g.GameId as GameId, ug.UserGamesId as UserGamesId FROM dev_jagwarz.User u, dev_jagwarz.Game g, dev_jagwarz.UserGame ug WHERE u.UserId = ug.UserId AND g.GameId = ug.GameId AND g.GameType = 'RvB' ";
						 
						 $query = mysqli_query($conn, $sql);
						 if (!$query) {
							die('Invalid query: ' . mysqli_error($conn));
						}
						
						
						$menu = "<select id='Username' name='Username' class='dropdown'>";
						
						 //$menu = "<select id='Username' name='Username' value=''>";
						/* $menu = "<input list='Username' name='Username'>
						 <datalist id='Username'>"; */
						
					// Add options to the drop down
						 while($row = mysqli_fetch_array($query)) {
							
							 //$menu .="<option value=" . $row['UserId'] . ">" . $row['Username'] . "</option>";
							 
							 //$menu .="<option value=" . $row['Username'] . ">" . $row['Username'] . "</option>";
							 
							 //$menu .="<option id=" . $row['Username'] . ">" . $row['Username'] . "</option>"; <-- no work
							 
							 //$menu .="<option id='" . $row['Username'] . "' value='" . $row['Username'] . "'>" . $row['Username'] . "</option>";
							 
							 $Username = $row['Username'];
							 //$menu .="<option value='" . $row['Username'] . "'>" . $row['Username'] . "</option>";
							 $menu .="<option value='" . $Username . "'>" . $Username . "</option>";
							 
							 //$menu .="<option value=" . $row['UserGamesId'] . ">" . $row['Username'] . ", " . $row['Title'] . "</option>";
							 
						 }
						
					//*** Close Menu Form //***
					$menu .= "</select>";
						 //$menu .= "</datalist>";
						
						 echo $menu;
						
						$Username = "";
						if (isset($_POST["Username"])) {
							$Username = $_POST["Username"];
						}
						echo $Username;
						
					?>
						
						  </div>
						  <div class="col-md-6">
						    <span class="form-label">Game Title *</span>
							
						  <?php

						//*** Use this for displaying error messages //***
						  ini_set('error_reporting', E_ALL);
						  ini_set('display_errors', 1);

						//*** Create connection with mysqli (Works) //***
						  global $dbserver,$db,$dbuser,$dbpassword;
						  
						  $conn = mysqli_connect($dbserver,$dbuser,$dbpassword);

						//*** Check connection //***
						 if ($conn->connect_error) {
						       die("Connection failed: " . $conn->connect_error);
						 }
 
						//*** Create Query //***
						 $sql = "SELECT DISTINCT ug.GameId AS GameId, g.Title AS Title, g.GameType AS GameType FROM dev_jagwarz.UserGame ug, dev_jagwarz.Game g WHERE g.GameId = ug.GameId AND g.GameType = 'RvB' AND g.Active = 1 ";
						 //$sql = "SELECT GameId, Title, GameType FROM dev_jagwarz.Game WHERE GameType = 'RvB'"; one that works
						 
						 //$sql = "SELECT u.Username AS Username, u.UserId AS UserId, g.Title AS Title, g.GameId as GameId, ug.UserGamesId as UserGamesId FROM dev_jagwarz.User u, dev_jagwarz.Game g, dev_jagwarz.UserGame ug WHERE g.GameId = ug.GameId AND u.UserId = ug.UserGame AND g.GameType = 'RvB' ";
						 
						 $query = mysqli_query($conn, $sql);
						 if (!$query) {
							die('Invalid query: ' . mysqli_error($conn));
						}
						
						
						
						//************  DROP DOWN MENU STUFF ************//
						
						//$menu = "<select id='Title' name='Title' value=''>";
						 /*$menu = "<input list='Title' name='Title'>
						 <datalist id='Title'>";*/
						
						$menu = "<select id='Title' name='Title' class='dropdown'>";
						//$menu = "<select name=\'Title\'>\n";
			
						
					// Add options to the drop down
						 while($row = mysqli_fetch_array($query)) {
							 
							 $menu .="<option value='" . $row['Title'] . "'>" . $row['Title'] . "</option>";
							 //$menu .="<option value=\" . $row['Title'] . \">" . $row['Title'] . "</option>\n";
							 
							 //$menu .="<option value=" . $row['GameId'] . ">" . $row['Title'] . "</option>";
							 
							 //$menu .="<option value=" . $row['Title'] . ">" . $row['Title'] . "</option>";
							 
							 //$menu .="<option id=" . $row['Title'] . ">" . $row['Title'] . "</option>";
							 
							 //$menu .="<option id='" . $row['Title'] . "' value='" . $row['Title'] . "'>" . $row['Title'] . "</option>";
							 
							 //$menu ="<option id=" . $row['Title'] . "value=" . $row['Title'] . ">" . $row['Title'] . "</option>";
							 
							 //$menu .="<option value=" . $row['UserGamesId'] . ">" . $row['Username'] . ", " . $row['Title'] . "</option>";
							 
						 }
						
					//*** Close Menu Form //***
						 $menu .= "</select>";
						// $menu .= "</datalist>";
						
						 echo $menu;
						
						$Title = "";
						if (isset($_POST["Title"])) {
							$Title = $_POST["Title"];
						}
						echo $Title;
						
						//************ END OF DROP DOWN MENU STUFF ************//	
					
					?>
						
						  </div>
						</div>
				<div class="row">
					<div class="col-md-3">
						<span class="form-label">Role Type *</span><br>
						<input type="hidden" class="required form-control" name="RoleType" id="RoleType" value=""/>
						<input type="button" class="btn btn-default btn-success" name="RoleBlue" id="RoleBlue" value="Blue" onclick="BlueClick()">
						<input type="button" class="btn btn-default btn-success" name="RoleRed" id="RoleRed" value="Red" onclick="RedClick()">
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<span class="form-label">Description</span>
						<textarea id="txtDescription" class="form-control" style="width:100%;height:100px;"></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 center">
						<a class="btn btn-default btn-success default-button" href="javascript:void(0);" onclick="CancelEdit();">Cancel</a> <a class="btn btn-default btn-success" href="javascript:void(0);" onclick="ajaxSave();">Save</a>
					</div>
				</div>
			</div> <!-- /edit-container -->
		</div>
	</div> <!-- /container -->
</div>
<?php } ?>
