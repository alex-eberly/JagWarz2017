<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/assets/classes/core.php"; ?>
<?php
$UserId = "";
if (isset($_POST["UserId"])) 
{
	$UserId = $_POST["UserId"];
}
$UserFactory = new UserFactory();
$UserArray = $UserFactory->GetAll(" where UserId = " . escapeString($UserId) . " and Active = 1");
if (count($UserArray) > 0)
{ 
	foreach ($UserArray as &$value)
	{
		?>
<div class="container">
	<div class="edit-container">
		<div class="row">
			<h1>User Record</h1>
		</div> <!-- /row -->
		<div class="row">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-4">
						<input type="hidden" id="hdnUserId" name="hdnUserId" value="<?php echo $value->UserId ?>" />
						<input type="hidden" id="hdnUsername" name="hdnUsername" value="<?php echo $value->Username ?>" />
						<input type="text" name="txtUsername" id="txtUsername" onchange="ajaxCheckUsername();" value="<?php echo $value->Username ?>" class="required form-control" placeholder="Username" />
						<div class="message-container">
							<img src="<?php echo $fullUrl; ?>assets/img/ajax-loader.gif" alt="Loading" id="loaderUsername" style="vertical-align:middle;display:none;" /> <span id="lblResponseUsername"></span>
						</div>
					</div> <!-- /col-md-4 -->
					<div class="col-md-4">
						<input type="password" name="txtPassword" id="txtPassword" class="form-control" placeholder="Password" />
					</div> <!-- /col-md-4 -->
				</div> <!-- /row -->
				<div class="row">
					<div class="col-md-4">
						<input type="text" name="txtFirstname" id="txtFirstname" class="required form-control" value="<?php echo $value->Firstname ?>" placeholder="First Name" />
					</div> <!-- /col-md-4 -->
					<div class="col-md-4">
						<input type="text" name="txtLastname" id="txtLastname" class="required form-control" value="<?php echo $value->Lastname ?>" placeholder="Last Name" />
					</div> <!-- /col-md-4 -->
					<div class="col-md-4">
						<input type="hidden" id="hdnEmail" name="hdnEmail" value="<?php echo $value->Email ?>" />
						<input type="text" name="txtEmail" id="txtEmail" onchange="ajaxCheckEmailAddress();" value="<?php echo $value->Email ?>" class="required form-control" placeholder="Email" />
						<div class="message-container">
							<img src="<?php echo $fullUrl; ?>assets/img/ajax-loader.gif" alt="Loading" id="loaderEmail" style="vertical-align:middle;display:none;" /> <span id="lblResponseEmail"></span>
						</div>
					</div> <!-- /col-md-4 -->
				</div> <!-- /row -->
				<div class="row">
					<div class="col-md-4">
						<input type="text" name="txtPhone" id="txtPhone" class="form-control" placeholder="Phone" value="<?php echo $value->Phone ?>" />
					</div> <!-- /col-md-4 -->
				</div> <!-- /row -->
				<div class="row">
					<div class="col-md-4">
						<input type="text" name="txtAddress1" id="txtAddress1" class="form-control" placeholder="Address 1" value="<?php echo $value->Address1 ?>" />
					</div> <!-- /col-md-4 -->
					<div class="col-md-4">
						<input type="text" name="txtAddress2" id="txtAddress2" class="form-control" placeholder="Address 2" value="<?php echo $value->Address2 ?>" />
					</div> <!-- /col-md-4 -->
				</div> <!-- /row -->
				<div class="row">
					<div class="col-md-4">
						<input type="text" name="txtAddress3" id="txtAddress3" class="form-control" placeholder="City" value="<?php echo $value->Address3 ?>" />
					</div> <!-- /col-md-4 -->
					<div class="col-md-4">
						<input type="text" name="txtAddress4" id="txtAddress4" class="form-control" placeholder="State" value="<?php echo $value->Address4 ?>" />
					</div> <!-- /col-md-4 -->
					<div class="col-md-4">
						<input type="text" name="txtAddress5" id="txtAddress5" class="form-control" placeholder="Zip" value="<?php echo $value->Address5 ?>" />
					</div> <!-- /col-md-4 -->
				</div> <!-- /row -->
				<div class="row">
					<div class="col-md-12 center">
						<a class="btn btn-default btn-orange default-button" href="javascript:void(0);" onclick="ajaxSave();">SAVE</a> 
						<a class="btn btn-default btn-orange" href="javascript:void(0);" onclick="HideEdit();">CANCEL</a>
					</div> <!-- /col-md-4 -->
				</div> <!-- /row -->
				<div class="row">
						<div class="col-md-4">
							<div class="styled-select">
								<select id="ddlRole" name="ddlRole" class="required form-control" placeholder="Role">
									<option value="">-Select Role-</option>
									<?php
										$roleFactory = new roleFactory();
										$roleArray = $roleFactory->GetAll(' order by Name ');
										if (count($roleArray) > 0)
										{
											foreach ($roleArray as &$value)
											{
												$userRoleFactory = new userRoleFactory();
												$userRoleArray = $userRoleFactory->GetAll(" where UserId = " . escapeString($UserId));
												$roleIds = '';
												foreach ($userRoleArray as &$value2)
												{
													if ($value->RoleId == $value2->RoleId)
													{
														echo '<option selected="selected" value="' . $value->RoleId . '">' . $value->Name . '</option>';
														$roleIds .= $value->RoleId . ',';
													}
												}
												if (strpos($roleIds,$value->RoleId) === false) {
												    echo '<option value="' . $value->RoleId . '">' . $value->Name . '</option>';
												}
											}
										}
									?>
								</select>
							</div>
						</div> <!-- /col-md-4 -->
					</div> <!-- /row -->
			</div> <!-- /col-md-9 -->
		</div> <!-- /row -->
	</div> <!-- /edit-container -->
</div> <!-- /container -->
		<?php
	}
}
else
{
	?>
	<div class="container">
		<div class="edit-container">
			<div class="row">
				<h1>User Record</h1>
			</div> <!-- /row -->
			<div class="row">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-4">
							<input type="hidden" id="hdnUserId" name="hdnUserId" />
							<input type="hidden" id="hdnUsername" name="hdnUsername" />
							<input type="text" name="txtUsername" id="txtUsername" onchange="ajaxCheckUsername();" class="required form-control" placeholder="Username" />
							<div class="message-container">
								<img src="<?php echo $fullUrl; ?>assets/img/ajax-loader.gif" alt="Loading" id="loaderUsername" style="vertical-align:middle;display:none;" /> <span id="lblResponseUsername"></span>
							</div>
						</div> <!-- /col-md-4 -->
						<div class="col-md-4">
							<input type="password" name="txtPassword" id="txtPassword" class="form-control" placeholder="Password" />
						</div> <!-- /col-md-4 -->
					</div> <!-- /row -->
					<div class="row">
						<div class="col-md-4">
							<input type="text" name="txtFirstname" id="txtFirstname" class="required form-control" placeholder="First Name" />
						</div> <!-- /col-md-4 -->
						<div class="col-md-4">
							<input type="text" name="txtLastname" id="txtLastname" class="required form-control" placeholder="Last Name" />
						</div> <!-- /col-md-4 -->
						<div class="col-md-4">
							<input type="hidden" id="hdnEmail" name="hdnEmail" />
							<input type="text" name="txtEmail" id="txtEmail" onchange="ajaxCheckEmailAddress();" class="required form-control" placeholder="Email" />
							<div class="message-container">
								<img src="<?php echo $fullUrl; ?>assets/img/ajax-loader.gif" alt="Loading" id="loaderEmail" style="vertical-align:middle;display:none;" /> <span id="lblResponseEmail"></span>
							</div>
						</div> <!-- /col-md-4 -->
					</div> <!-- /row -->
					<div class="row">
						<div class="col-md-4">
							<input type="text" name="txtPhone" id="txtPhone" class="form-control" placeholder="Phone" />
						</div> <!-- /col-md-4 -->
					</div> <!-- /row -->
					<div class="row">
						<div class="col-md-4">
							<input type="text" name="txtAddress1" id="txtAddress1" class="form-control" placeholder="Address 1" />
						</div> <!-- /col-md-4 -->
						<div class="col-md-4">
							<input type="text" name="txtAddress2" id="txtAddress2" class="form-control" placeholder="Address 2" />
						</div> <!-- /col-md-4 -->
					</div> <!-- /row -->
					<div class="row">
						<div class="col-md-4">
							<input type="text" name="txtAddress3" id="txtAddress3" class="form-control" placeholder="City" />
						</div> <!-- /col-md-4 -->
						<div class="col-md-4">
							<input type="text" name="txtAddress4" id="txtAddress4" class="form-control" placeholder="State" />
						</div> <!-- /col-md-4 -->
						<div class="col-md-4">
							<input type="text" name="txtAddress5" id="txtAddress5" class="form-control" placeholder="Zip" />
						</div> <!-- /col-md-4 -->
					</div> <!-- /row -->
					<div class="row">
						<div class="col-md-4">
							<div class="styled-select">
								<select id="ddlRole" name="ddlRole" class="required form-control" placeholder="Role">
									<option value="">-Select Role-</option>
									<?php
										$roleFactory = new roleFactory();
										$roleArray = $roleFactory->GetAll(' order by Name ');
										if (count($roleArray) > 0)
										{
											foreach ($roleArray as &$value)
											{
												echo '<option value="' . $value->RoleId . '">' . $value->Name . '</option>';
											}
										}
									?>
								</select>
							</div>
						</div> <!-- /col-md-4 -->
					</div> <!-- /row -->
					<div class="row">
						<div class="col-md-12 center">
							<a class="btn btn-default btn-orange default-button" href="javascript:void(0);" onclick="ajaxSave();">SAVE</a> 
							<a class="btn btn-default btn-orange" href="javascript:void(0);" onclick="HideEdit();">CANCEL</a>
						</div> <!-- /col-md-4 -->
					</div> <!-- /row -->
				</div> <!-- /col-md-9 -->
			</div> <!-- /row -->
		</div> <!-- /edit-container -->
	</div> <!-- /container -->
	<?php
}
?>