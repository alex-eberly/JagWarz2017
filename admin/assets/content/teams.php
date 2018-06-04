<div class="content container_12">
	<div id="edit-container"></div> <!-- /edit-container -->
	<div class="box grid_12" id="box">
		<div class="box-head" style="text-align:center;"><h2>Teams</h2></div>
		<div class="box-content no-pad">
			<table class="display" id="datatable">
				<thead>
					<tr>
						<th>Game</th>
						<th>User</th>
						<th>Team</th>
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
		"sAjaxSource": "<?php echo $fullUrl; ?>admin/handlers/dataTables/Teams.DataTables.Ajax.gen.php",
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
			{ "mData": "6", sDefaultContent: "" }, //game
			{ "mData": "3", sDefaultContent: "" }, //user
			{ "mData": "1", sDefaultContent: "" }, //role
			{ "mData": "2", sDefaultContent: "" }, //description
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
