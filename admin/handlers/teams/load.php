<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/assets/classes/core.php"; ?>
<?php
$Id = "";
if (isset($_POST["Id"])) 
{
	$Id = $_POST["Id"];
}
$TeamFactory = new TeamFactory();
$TeamArray = $TeamFactory->GetAll(" where TeamId = " . escapeString($Id));
if (count($TeamArray) > 0)
{ 
	foreach ($TeamArray as &$value)
	{
		?>
<div class="box grid_12">
	<div class="box-head" style="text-align:center;"><h2>Team Edit</h2></div>
		<div class="box-content bootstrap">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<input type="hidden" name="hdnId" id="hdnId" value="<?php echo $value->TeamId ?>" />
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<span class="form-label">Title *</span>
						<input type="text" class="required form-control" name="txtTitle" id="txtTitle" value="<?php echo $value->Title ?>" />
					</div>
					<div class="col-md-6">
						<span class="form-label">Correct Answer *</span>
						<input type="text" class="required form-control" name="txtCorrectAnswer" maxlength="100" id="txtCorrectAnswer" value="<?php echo $value->CorrectAnswer ?>" />
					</div>
				</div>
				<div class="row">
					<div class="col-md-3">
						<span class="form-label">Point Value *</span>
						<input type="text" class="required positive-integer form-control" maxlength="11" name="txtPointValue" id="txtPointValue" value="<?php echo $value->PointValue; ?>" />
					</div>
					<div class="col-md-3">
						<br />
						<input type="checkbox" id="chbIsOpen" <?php echo ($value->IsOpen == 1) ? "checked=\"checked\"" : ""; ?>> <label for="chbIsOpen">Open</label>
					</div>
					<div class="col-md-3">
						<br />
						<input type="checkbox" id="chbIsComplete" <?php echo ($value->IsComplete == 1) ? "checked=\"checked\"" : ""; ?>> <label for="chbIsComplete">Completed</label>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<span class="form-label">Tags (Separated by a comma)</span>
						<textarea id="txtTags" class="form-control" style="width:100%;height:100px;"><?php echo $value->Tags ?></textarea>
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
						<span class="form-label">Files</span>
						<div id="file-fine-uploader" class="file"></div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<?php
							$ChallengeFileFactory = new ChallengeFileFactory();
							$ChallengeFileArray = $ChallengeFileFactory->GetAll(" where ChallengeId = " . escapeString($value->ChallengeId) . " order by Filename");
							foreach ($ChallengeFileArray as $ChallengeFile)
							{
								echo "<div class=\"alert alert-dismissable alert-success\">";
								echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" onclick=\"DeleteFile(" . $ChallengeFile->ChallengeFileId . ",'" . $ChallengeFile->Filename . "', this);\" aria-hidden=\"true\">&times;</button>";
								echo "<a target=\"_blank\" href=\"" . $fullUrl . "files/" . $ChallengeFile->Filename . "\" class=\"alert-link\">";
								echo $ChallengeFile->Filename;
								echo "</a>";
								echo "</div>";
							}
						?>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 center">
						<a class="btn btn-default btn-success default-button" href="javascript:void(0);" onclick="ajaxSave();">save</a> <a class="btn btn-default btn-success" href="javascript:void(0);" onclick="CancelEdit();">cancel</a>
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
	<div class="box-head" style="text-align:center;"><h2>Challenge Add</h2></div>
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
						<span class="form-label">Correct Answer *</span>
						<input type="text" class="required form-control" name="txtCorrectAnswer" maxlength="100" id="txtCorrectAnswer" />
					</div>
				</div>
				<div class="row">
					<div class="col-md-3">
						<span class="form-label">Point Value *</span>
						<input type="text" class="required positive-integer form-control" maxlength="11" name="txtPointValue" id="txtPointValue" />
					</div>
					<div class="col-md-3">
						<br />
						<input type="checkbox" id="chbIsOpen"> <label for="chbIsOpen">Open</label>
					</div>
					<div class="col-md-3">
						<br />
						<input type="checkbox" id="chbIsCompleted"> <label for="chbIsCompleted">Completed</label>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<span class="form-label">Tags (Separated by a comma)</span>
						<textarea id="txtTags" class="form-control" style="width:100%;height:100px;"></textarea>
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
						<span class="form-label">Files</span>
						<div id="file-fine-uploader" class="file"></div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 center">
						<a class="btn btn-default btn-success default-button" href="javascript:void(0);" onclick="ajaxSave();">save</a> <a class="btn btn-default btn-success" href="javascript:void(0);" onclick="CancelEdit();">cancel</a>
					</div>
				</div>
			</div> <!-- /edit-container -->
		</div> <!-- /edit-container -->
	</div> <!-- /container -->
</div>
<?php
}
?>		
		