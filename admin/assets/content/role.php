<div class="content container_12">
	<div id="edit-container"></div> <!-- /edit-container -->
	<div class="box grid_12" id="box">
		<div class="box-head" style="text-align:center;"><h2>Roles</h2></div>
		<div class="box-content no-pad">
			<table class="display" id="datatable">
				<thead>
					<tr>
						<th>Username</th>
						<th>Title</th>
						<th>RoleType</th>
						<th>Description</th>
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
		"sAjaxSource": "<?php echo $fullUrl; ?>admin/handlers/dataTables/Roles.DataTables.Ajax.gen.php",
		"sServerMethod": "GET",
		"bServerSide": true,
		"bStateSave": false,
		"bProcessing": true,
		"iDisplayLength": 50,
		"bAutoWidth": false,
		"bLengthChange": true,
	    "aoColumnDefs": [
			{ "bSortable": false, "aTargets": ["nosort"] }
		],
		"aoColumns": [
			//{ "mData": "0", sDefaultContent: "" }, //UserRoleId
			//{ "mData": "1", sDefaultContent: "" }, //UserGamesId
		  //{ "mData": "2", sDefaultContent: "" }, //GameId
			//{ "mData": "3", sDefaultContent: "" }, //UserId
			{ "mData": "4", sDefaultContent: "" }, //Username
			{ "mData": "5", sDefaultContent: "" }, //Title
			{ "mData": "6", sDefaultContent: "" }, //RoleType
			{ "mData": "7", sDefaultContent: "" }, //Description
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
	//$('#txtTitle').focus();
	//$('.date').datepicker();
}


function ajaxSave() {
	$('#modal-loader').show();
	$.post('<?php echo $fullUrl; ?>admin/handlers/roles/save.php', {
		UserRoleId: $('#hdnId').val(),
		//UserGamesId: $('#UserGamesId').val(),
		//GameId: $('#GameId').val(),
		//UserId: $('#UserId').val(),
		Username: $('#Username').val(),
		Title: $('#Title').val(),
		RoleType: $('#RoleType').val(),
		Description: $('#txtDescription').val()
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
	$.post('<?php echo $fullUrl; ?>admin/handlers/roles/load.php', {
		Id: id
		}, function(output) {
			$('#edit-container').html(output).show();
			$('#modal-loader').hide();
			ReloadMethods();
	});
}
function ajaxDeleteItem(id) {
	$('#modal-loader').show();
	$.post('<?php echo $fullUrl; ?>admin/handlers/roles/delete.php', {
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
	$('#UserGamesId').val('');
	$('#GameId').val('');
	$('#UserId').val('');
	$('#Username').val('');
	$('#Title').val('');
	$('#RoleType').val('');
	$('#txtDescription').val('');
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
function BlueClick(){
	//$("#gameCTF").click(function(){
	$("#RoleRed").css('background-color', '#5cb85c');
	$("#RoleBlue").css('background-color', 'darkblue');
	$("#RoleType").val("Blue");
	//});
}
function RedClick(){
	//$("#gameRvB").click(function(){
	$("#RoleBlue").css('background-color', '#5cb85c');
	$("#RoleRed").css('background-color', 'darkred');
	$("#RoleType").val("Red");
	//});
}
</script>
