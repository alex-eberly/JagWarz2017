<div class="content container_12">
	<div id="edit-container"></div> <!-- /edit-container -->
	<div class="box grid_12" id="box">
		<div class="box-head"><h2>Games</h2></div>
		<div class="box-content no-pad">
			<table class="display" id="datatable">
				<thead>
					<tr> 
						<th>Title</th>
						<th style="width:100px;text-align:center;">Open Date</th>
						<th style="width:100px;text-align:center;">Close Date</th>
						<th style="width:100px;text-align:center;">Code</th>
						<th style="width:100px;text-align:center;">Game Type</th>
						<th class="nosort" style="width:140px;text-align:center;"><a class="tablelink opsrc add-item" href="javascript:void(0);" onclick="ajaxLoadRecord(0);"></a></th>
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
		"sAjaxSource": "<?php echo $fullUrl; ?>admin/handlers/dataTables/Game.DataTables.Ajax.gen.php",
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
			{ "mData": "1", sDefaultContent: "" }, //Title
			{ "mData": function ( source, type, val ) { //Open Date
		        if (type === 'set') {
		        	// Split timestamp into [ Y, M, D, h, m, s ]
		        	if (source[4] != null) {
			        	var t = source[4].split(/[- :]/);
						// Apply each element to the Date function
						var d = new Date(t[0], t[1], t[2], t[3], t[4], t[5]);
			        	source[4] = d.getMonth() + '/' + d.getDate() + '/' + d.getFullYear();
		        	}
					return;
		        }
		        else if (type === 'display') {
		          	return source[4];
		        }
		        else if (type === 'filter') {
		          	return source[4];
		        }
		        // 'sort', 'type' and undefined all just use the integer
		        return source[4];
		      },
		      "sClass": "CenteredColumn"},
			{ "mData": function ( source, type, val ) { //Close Date
		        if (type === 'set') {
		        	if (source[5] != null) {
			        	// Split timestamp into [ Y, M, D, h, m, s ]
						var t = source[5].split(/[- :]/);
						// Apply each element to the Date function
						var d = new Date(t[0], t[1], t[2], t[3], t[4], t[5]);
			        	source[5] = d.getMonth() + '/' + d.getDate() + '/' + d.getFullYear();
		        	}
					return;
		        }
		        else if (type === 'display') {
		          	return source[5];
		        }
		        else if (type === 'filter') {
		          	return source[5];
		        }
		        // 'sort', 'type' and undefined all just use the integer
		        return source[5];
		      },
		      "sClass": "CenteredColumn"},
		    { "mData": "6", sDefaultContent: "", //Code
		      "sClass": "CenteredColumn" },
			{ "mData": "8", sDefaultContent: "", //GameType
		      "sClass": "CenteredColumn" }, 
			{ "mData": function ( source, type, val ) {
		        if (type === 'set') {
		          return "<a href=\"<?php echo $fullUrl; ?>admin/challenges.php?gameid=" + source[0] + "\" class=\"tablelink opsrc tree\"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"javascript:void(0);\" onclick=\"ajaxLoadRecord(" + source[0] + ");ShowEdit();\" class=\"tablelink opsrc edit\"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"javascript:void(0);\" onclick=\"if(!confirm(\'Are you sure you want delete this item?\')) return false;ajaxDeleteItem(" + source[0] + ");\" class=\"tablelink opsrc recycle-full\"></a>";
		        }
		        else if (type === 'display') {
		          return "<a href=\"<?php echo $fullUrl; ?>admin/challenges.php?gameid=" + source[0] + "\" class=\"tablelink opsrc tree\"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"javascript:void(0);\" onclick=\"ajaxLoadRecord(" + source[0] + ");ShowEdit();\" class=\"tablelink opsrc edit\"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"javascript:void(0);\" onclick=\"if(!confirm(\'Are you sure you want delete this item?\')) return false;ajaxDeleteItem(" + source[0] + ");\" class=\"tablelink opsrc recycle-full\"></a>";
		        }
		        else if (type === 'filter') {
		          return "<a href=\"<?php echo $fullUrl; ?>admin/challenges.php?gameid=" + source[0] + "\" class=\"tablelink opsrc tree\"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"javascript:void(0);\" onclick=\"ajaxLoadRecord(" + source[0] + ");ShowEdit();\" class=\"tablelink opsrc edit\"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"javascript:void(0);\" onclick=\"if(!confirm(\'Are you sure you want delete this item?\')) return false;ajaxDeleteItem(" + source[0] + ");\" class=\"tablelink opsrc recycle-full\"></a>";
		        }
		        // 'sort', 'type' and undefined all just use the integer
		        return "<a href=\"<?php echo $fullUrl; ?>admin/challenges.php?gameid=" + source[0] + "\" class=\"tablelink opsrc tree\"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"javascript:void(0);\" onclick=\"ajaxLoadRecord(" + source[0] + ");ShowEdit();\" class=\"tablelink opsrc edit\"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"javascript:void(0);\" onclick=\"if(!confirm(\'Are you sure you want delete this item?\')) return false;ajaxDeleteItem(" + source[0] + ");\" class=\"tablelink opsrc recycle-full\"></a>";
		      },
		      "sClass": "CenteredColumn" }
		]
	});
	ReloadMethods();
});
function ReloadMethods() {
	$('#edit-container').jvalidate();
	$('#txtTitle').focus();
	$('.date').datepicker();
}
function VerifyCode() {
	if ($('#txtCode').val() != "") {
		if ($('#hdnCurrentCode').val() != $('#txtCode').val()) {
			$.post('<?php echo $fullUrl; ?>admin/handlers/games/verify-code.php', { code: $('#txtCode').val()  }, function(output) {
				$('#code-validation').html(output).show();
				if (output == "<span class=\"red-text message\">Not Available!</span>") {
					$('#hdnCodeValidation').val('');
				}
				else {
					$('#hdnCodeValidation').val('true');
				}
			});
		}
		else {
			$('#hdnCodeValidation').val('true');
		}
	}
}
function ajaxSave() {
	$('#modal-loader').show();
	$.post('<?php echo $fullUrl; ?>admin/handlers/games/save.php', { 
		GameId: $('#hdnId').val(),
		Title: $('#txtTitle').val(),
		Description: $('#txtDescription').val(),
		ClosedDescription: $('#txtClosedDescription').val(),
		OpenDate: $('#txtOpenDate').val(),
		Code: $('#txtCode').val(),
		CloseDate: $('#txtCloseDate').val(),
		GameType: $('#gameType').val()
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
	$.post('<?php echo $fullUrl; ?>admin/handlers/games/load.php', { 
		Id: id
		}, function(output) {
			$('#edit-container').html(output).show();
			$('#modal-loader').hide();
			ReloadMethods();
	});
}
function ajaxDeleteItem(id) {
	$('#modal-loader').show();
	$.post('<?php echo $fullUrl; ?>admin/handlers/games/delete.php', { 
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
	$('#txtTitle').val('');
	$('#txtDescription').val('');
	$('#txtClosedDescription').val('');
	$('#txtOpenDate').val('');
	$('#txtCode').val('');
	$('#txtCloseDate').val('');
	$('#gameType').val('');
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
function CTFclick(){
	//$("#gameCTF").click(function(){
	$("#gameRvB").css('background-color', '#5cb85c');
	$("#gameCTF").css('background-color', 'darkred');
	$("#gameType").val("CTF");
	//});
}
function RvBclick(){
	//$("#gameRvB").click(function(){
	$("#gameCTF").css('background-color', '#5cb85c');
	$("#gameRvB").css('background-color', 'darkred');
	$("#gameType").val("RvB");
	//});
}
</script>