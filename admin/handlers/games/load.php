<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/assets/classes/core.php"; ?>
<?php
$Id = "";
if (isset($_POST["Id"])) 
{
	$Id = $_POST["Id"];
}
$GameFactory = new GameFactory();
$GameArray = $GameFactory->GetAll(" where GameId = " . escapeString($Id));
if (count($GameArray) > 0)
{ 
	foreach ($GameArray as &$value)
	{
		?>
<div class="box grid_12">
	<div class="box-head" style="text-align:center;"><h2>Game Edit</h2></div>
		<div class="box-content bootstrap">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<input type="hidden" name="hdnId" id="hdnId" value="<?php echo $value->GameId ?>" />
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<span class="form-label">Title *</span>
						<input type="text" class="required form-control" name="txtTitle" id="txtTitle" value="<?php echo $value->Title ?>" />
					</div>
					<div class="col-md-6">
						<span class="form-label">Code *</span> <span id="code-validation"></span>
						<input type="hidden" id="hdnCodeValidation" class="required" requiredby="txtCode" value="<?php echo $value->Code ?>">
						<input type="hidden" id="hdnCurrentCode" value="<?php echo $value->Code ?>">
						<input type="text" class="required form-control" name="txtCode" id="txtCode" onblur="VerifyCode();" value="<?php echo $value->Code ?>" />
					</div>
				</div>
				<div class="row">
					<div class="col-md-3">
						<span class="form-label">Open Date *</span>
						<input type="text" class="required date form-control" name="txtOpenDate" id="txtOpenDate" value="<?php $date = new DateTime($value->OpenDate); echo $date->format('m/d/Y'); ?>" />
					</div>
					<div class="col-md-3">
						<span class="form-label">Close Date *</span>
						<input type="text" class="required date form-control" name="txtCloseDate" id="txtCloseDate" value="<?php $date = new DateTime($value->CloseDate); echo $date->format('m/d/Y'); ?>" />
					</div>
					<div class="col-md-3">
						<span class="form-label">Game Type (Disabled in Edit)</span><br>
						<input type="hidden" class="form-control" name="gameType" id="gameType" value="<?php echo $value->GameType ?>"/>
						<input type="button" class="btn btn-default btn-success" name="gameCTF" id="gameCTF" value="Capture the Flag" onclick="CTFclick() disabled /">
						<input type="button" class="btn btn-default btn-success" name="gameRvB" id="gameRvB" value="Red vs Blue" onclick="RvBclick() disabled /">
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<span class="form-label">Description</span>
						<textarea id="txtDescription" class="form-control" style="width:100%;height:100px;"><?php echo $value->Description ?></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<span class="form-label">Closed Description</span>
						<textarea id="txtClosedDescription" class="form-control" style="width:100%;height:100px;"><?php echo $value->ClosedDescription ?></textarea>
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
	<div class="box-head" style="text-align:center;"><h2>Game Add</h2></div>
		<div class="box-content bootstrap">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<input type="hidden" name="hdnId" id="hdnId" />
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<span class="form-label">Title *</span>
						<input type="text" class="required form-control" name="txtTitle" id="txtTitle" />
					</div>
					<div class="col-md-6">
						<span class="form-label">Code *</span> <span id="code-validation"></span>
						<input type="hidden" id="hdnCodeValidation" class="required" requiredby="txtCode">
						<input type="hidden" id="hdnCurrentCode">
						<input type="text" class="required form-control" name="txtCode" onblur="VerifyCode();" id="txtCode" />
					</div>
				</div>
				<div class="row">
					<div class="col-md-3">
						<span class="form-label">Open Date *</span>
						<input type="text" class="required date form-control" name="txtOpenDate" id="txtOpenDate" />
					</div>
					<div class="col-md-3">
						<span class="form-label">Close Date *</span>
						<input type="text" class="required date form-control" name="txtCloseDate" id="txtCloseDate" />
					</div>
					<div class="col-md-3">
						<span class="form-label">Game Type *</span><br>
						<input type="hidden" class="required form-control" name="gameType" id="gameType" value=""/>
						<input type="button" class="btn btn-default btn-success" name="gameCTF" id="gameCTF" value="Capture the Flag" onclick="CTFclick()">
						<input type="button" class="btn btn-default btn-success" name="gameRvB" id="gameRvB" value="Red vs Blue" onclick="RvBclick()">
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<span class="form-label">Description</span>
						<textarea id="txtDescription" class="form-control" style="width:100%;height:100px;"></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<span class="form-label">Closed Description</span>
						<textarea id="txtClosedDescription" class="form-control" style="width:100%;height:100px;"></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 center">
						<a class="btn btn-default btn-success default-button" href="javascript:void(0);" onclick="CancelEdit();">Cancel</a> <a class="btn btn-default btn-success" href="javascript:void(0);" onclick="ajaxSave();">Save</a>
					</div>
				</div>
			</div> <!-- /edit-container -->
		</div> <!-- /edit-container -->
	</div> <!-- /container -->
</div>
<?php } ?>