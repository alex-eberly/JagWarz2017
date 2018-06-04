<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/assets/classes/core.php"; ?>
<?php
$Id = "";
if (isset($_POST["Id"])) 
{
	$Id = $_POST["Id"];
}
$AdminUserFactory = new AdminUserFactory();
$AdminUserArray = $AdminUserFactory->GetAll(" where AdminUserId = " . escapeString($Id));
if (count($AdminUserArray) > 0)
{ 
	foreach ($AdminUserArray as &$value)
	{
		?>
<div class="box grid_12">
	<div class="box-head"><h2>Admin User Edit</h2></div>
		<div class="box-content bootstrap">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<input type="hidden" name="hdnId" id="hdnId" value="<?php echo $value->AdminUserId ?>" />
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<span class="form-label">Email *</span> <span id="email-validation"></span>
						<input type="hidden" id="hdnEmailValidation" class="required" requiredby="txtEmail" value="<?php echo $value->Username ?>">
						<input type="hidden" id="hdnEmailCurrent" value="<?php echo $value->Username ?>">
						<input type="text" class="required email form-control" name="txtEmail" onblur="VerifyEmail();" id="txtEmail" value="<?php echo $value->Username ?>" />
					</div>
					<div class="col-md-6">
						<span class="form-label">Password</span>
						<input type="password" class="form-control" name="txtPassword" id="txtPassword" />
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
		<?php
	}
}
else
{
?>
<div class="box grid_12">
	<div class="box-head"><h2>Admin User Add</h2></div>
		<div class="box-content bootstrap">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<input type="hidden" name="hdnId" id="hdnId" />
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<span class="form-label">Email *</span> <span id="email-validation"></span>
						<input type="hidden" id="hdnEmailValidation" class="required" requiredby="txtEmail">
						<input type="hidden" id="hdnEmailCurrent">
						<input type="text" class="required email form-control" name="txtEmail" onblur="VerifyEmail();" id="txtEmail" />
					</div>
					<div class="col-md-6">
						<span class="form-label">Password</span>
						<input type="password" class="form-control" name="txtPassword" id="txtPassword" />
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 center">
						<a class="btn btn-default btn-success default-button" href="javascript:void(0);" onclick="CancelEdit();">Cancel</a> <a class="btn btn-default btn-success" href="javascript:void(0);" onclick="ajaxSave();">Save</a>
					</div>
				</div>
			</div>
		</div> <!-- /edit-container -->
	</div> <!-- /container -->
</div>
<?php
}
?>