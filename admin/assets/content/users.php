<div class="content container_12">
	<div id="edit-container"></div> <!-- /edit-container -->
	<div class="box grid_12" id="box">
		<div class="box-head" style="text-align:center;"><h2>Users</h2></div>
		<div class="box-content no-pad">
			<table class="display" id="datatable">
				<thead>
					<tr>
						<th>Username</th>
						<th>Email</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th class="nosort" style="width:120px;text-align:center;"><a class="tablelink opsrc add-item" href="javascript:void(0);" onclick="ajaxLoadRecord(0);"></a></th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
	var tableElement = $('#datatable');
	tableElement.dataTable({
		"bJQueryUI": true,
		"sAjaxSource": "<?php echo $fullUrl; ?>admin/handlers/dataTables/User.DataTables.Ajax.gen.php",
		"sServerMethod": "GET",
		"bServerSide": true,
		"bStateSave": false,
		"bProcessing": true,
		"bAutoWidth": false,
		"bLengthChange": true,
	    "aoColumnDefs": [
			{ "bSortable": false, "aTargets": ["nosort"] }
		],
		"aoColumns": [
			{ "mData": "6", sDefaultContent: "" }, //username
			{ "mData": "3", sDefaultContent: "" }, //email
			{ "mData": "1", sDefaultContent: "" }, //firstname
			{ "mData": "2", sDefaultContent: "" }, //lastname
			{ "mData": function ( source, type, val ) {
		        if (type === 'set') {
		          return "<a href=\"javascript:void(0);\" onclick=\"ajaxLoadRecord(" + source[0] + ");ShowEdit();\" class=\"tablelink opsrc edit\"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"javascript:void(0);\" onclick=\"if(!confirm(\'Are you sure you want delete this item?\')) return false;ajaxDeleteItem(" + source[0] + ");\" class=\"tablelink opsrc recycle-full\"></a>";
		        }
		        else if (type === 'display') {
		          return "<a href=\"javascript:void(0);\" onclick=\"ajaxLoadRecord(" + source[0] + ");ShowEdit();\" class=\"tablelink opsrc edit\"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"javascript:void(0);\" onclick=\"if(!confirm(\'Are you sure you want delete this item?\')) return false;ajaxDeleteItem(" + source[0] + ");\" class=\"tablelink opsrc recycle-full\"></a>";
		        }
		        else if (type === 'filter') {
		          return "<a href=\"javascript:void(0);\" onclick=\"ajaxLoadRecord(" + source[0] + ");ShowEdit();\" class=\"tablelink opsrc edit\"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"javascript:void(0);\" onclick=\"if(!confirm(\'Are you sure you want delete this item?\')) return false;ajaxDeleteItem(" + source[0] + ");\" class=\"tablelink opsrc recycle-full\"></a>";
		        }
		        // 'sort', 'type' and undefined all just use the integer
		        return "<a href=\"javascript:void(0);\" onclick=\"ajaxLoadRecord(" + source[0] + ");ShowEdit();\" class=\"tablelink opsrc edit\"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"javascript:void(0);\" onclick=\"if(!confirm(\'Are you sure you want delete this item?\')) return false;ajaxDeleteItem(" + source[0] + ");\" class=\"tablelink opsrc recycle-full\"></a>";
		      },
		      "sClass": "CenteredColumn" }
		]
	});
	ReloadMethods();
});
function ReloadMethods() {
	$('#edit-container').jvalidate();
	$('#txtEmail').focus();
}
function VerifyUsername() {
	if ($('#txtUsername').val() != "") {
		if ($('#hdnUsernameCurrent').val() != $('#txtUsername').val()) {
			$.post('<?php echo $fullUrl; ?>admin/handlers/users/verify-username.php', { username: $('#txtUsername').val()  }, function(output) {
				$('#username-validation').html(output).show();
				if (output == "<span class=\"red-text message\">Not Available!</span>") {
					$('#hdnUsernameValidation').val('');
				}
				else {
					$('#hdnUsernameValidation').val('true');
				}
			});
		}
	}
}
function VerifyEmail() {
	if ($('#txtEmail').val() != "") {
		if ($('#hdnEmailCurrent').val() != $('#txtEmail').val()) {
			$.post('<?php echo $fullUrl; ?>admin/handlers/users/verify-email.php', { email: $('#txtEmail').val()  }, function(output) {
				$('#email-validation').html(output).show();
				if (output == "<span class=\"red-text message\">Not Available!</span>") {
					$('#hdnEmailValidation').val('');
				}
				else {
					$('#hdnEmailValidation').val('true');
				}
			});
		}
	}
}
function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
    return pattern.test(emailAddress);
};
function ajaxSave() {
	$('#modal-loader').show();
	$.post('<?php echo $fullUrl; ?>admin/handlers/users/save.php', { 
		UserId: $('#hdnId').val(),
		Email: $('#txtEmail').val(),
		Username: $('#txtUsername').val(),
		CurrentUsername: $('#hdnUsernameCurrent').val(),
		CurrentEmail: $('#hdnEmailCurrent').val(),
		Firstname: $('#txtFirstname').val(),
		Lastname: $('#txtLastname').val(),
		Password: $('#txtPassword').val()
	}, function(output) {
		$('#lblSaveResponse').html(output).show();
		$('#modal-loader').hide();
		CancelEdit();
		ajaxLoadRecords();
	});
}
function ajaxLoadRecords() {
	$table = $('#datatable').dataTable();
	$table.fnDraw();
}
function ajaxLoadRecord(id) {
	$('#modal-loader').show();
	$.post('<?php echo $fullUrl; ?>admin/handlers/users/load.php', { 
		Id: id
		}, function(output) {
			$('#edit-container').html(output).show();
			$('#modal-loader').hide();
			ReloadMethods();
	});
}
function ajaxDeleteItem(id) {
	$('#modal-loader').show();
	$.post('<?php echo $fullUrl; ?>admin/handlers/users/delete.php', { 
		Id: id
		}, function(output) {
			$('#edit-container').html(output).show();
			$('#modal-loader').hide();
			ajaxLoadRecords();
	});
}
function CancelEdit() {
	ClearFields();
	HideEdit();
}
function ClearFields() {
	$('#hdnId').val('');
	$('#txtEmail').val('');
	$('#txtUsername').val('');
	$('#txtFirstname').val('');
	$('#txtLastname').val('');
	$('#txtPassword').val('');
}
function HideEdit() {
	$('#edit-container').slideUp(400,function() {
		AnimateScroll('box');
	});
}
function ShowEdit() {
	ClearFields();
	$('#edit-container').jvalidate();
	$('#edit-container').slideDown();
	AnimateScroll('edit-container');
}
</script>