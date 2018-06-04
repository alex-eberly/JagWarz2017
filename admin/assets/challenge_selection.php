<div class="content container_12">
	<div id="edit-container"></div> <!-- /edit-container -->
	<div class="box grid_12" id="box">
		<div class="box-head" style="text-align:center;"><h2>Challenge Library</h2></div>
		<div class="box-content no-pad">
			<table class="display" id="datatable">
				<thead>
					<tr>
						<!--<th>Select</th>-->
						<th>Title</th>
						<th>Point Value</th>
						<th>Open</th>
						<th>Complete</th>
						<th>Tags</th>						
						<!--<th class="nosort" style="width:120px;text-align:center;"><a class="tablelink opsrc add-item" href="javascript:void(0);" onclick="ajaxLoadRecord(0);"></a></th>-->
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
	
			
		"sDom": 'T<"clear">lfrtip',
		"oTableTools": {
			"sRowSelect": "multi",
			//"sRowSelector": 'td:first-child',
			//"bPaginate": false,
			//"iDisplayLength": 50,
			//"paging":         false,
			"aButtons": ["select_all", "select_none",
				{
                    "sExtends": "select",
                    "sButtonText": "Add Challenges to Game",
					"fnClick": function ( nButton, oConfig, oFlash ) {
						var oTT = TableTools.fnGetInstance('datatable');
						var aData = oTT.fnGetSelectedData();
						alert(aData);
						//for(row in aData){
							//ajaxSave(aData[row][0]);
							ajaxSave(aData);
						//}
						
						//fnSelectedData
						// Get table object
						//var myTable = document.getElementById('datatable').tBodies[0];

						// first loop for each row	
						//for (var r=0, n = myTable.rows.length; r < n; r++) {
						//for(row in myTable){
                       // this loop is getting each colomn/cells
						//for (var c = 0, m = myTable.rows[r].cells.length; c < m; c++) {
              
						//if(myTable.rows[r].cells[0].value){
						// get student names
						//var StudentName = myTable.rows[r].cells[0].innerHTML;
						//}
						
						//alert();
						//alert(test.ToString());
						//alert( $.toJSON(test) );
					
						// get student marks in each text boxes
						//var marks = myTable.rows[r].cells[c].childNodes[0].value;
						//alert(marks); 
			   
            
						
					}
						//ajaxSave(gamechallenges);
						//alert( table.rows('.selected').data().length +' row(s) selected' );
                   	
				}/*,
				{
                "sExtends":    "copy",
                "bSelectedOnly": "true",
				}*/
			]
			
		},
		"bJQueryUI": true,
		"sAjaxSource": "<?php echo $fullUrl; ?>admin/handlers/dataTables/Challenge_Selection.DataTables.Ajax.gen.php",
		"sServerMethod": "GET",
		"bServerSide": true,
		"bStateSave": false,
		"bProcessing": true,
		"bAutoWidth": false,
		"bLengthChange": true,
	    "aoColumnDefs": [
			{ "bSortable": false, "aTargets": ["nosort"] }
		],
		"rowCallback": function( row, data ) {
			if ( $.inArray(data.DT_RowId, selected) !== -1 ) {
				$(row).addClass('selected');
			}
		},
		"fnServerParams": function ( aoData ) {
	      	aoData.push( { "name": 'GameId', "value": <?php echo $_GET["gameid"]; ?> } );
	    },
		"aoColumns": [
			//{ "mdata": null, sDefaultContent: "", orderable: false },
			{ "mData": "1", sDefaultContent: "" }, //title
			{ "mData": "4", sDefaultContent: "",
		      "sClass": "CenteredColumn" }, //Point Value
		    { "mData": function ( source, type, val ) { //open
		        if (type === 'set') {
		        	// Split timestamp into [ Y, M, D, h, m, s ]
		        	if (source[6] == 1) {
			        	source[6] = "Yes";
		        	}
		        	else {
			        	source[6] = "No";
		        	}
					return;
		        }
		        else if (type === 'display') {
		          	return source[6];
		        }
		        else if (type === 'filter') {
		          	return source[6];
		        }
		        // 'sort', 'type' and undefined all just use the integer
		        return source[6];
		      },
		      "sClass": "CenteredColumn"},
		    { "mData": function ( source, type, val ) { //completed
		        if (type === 'set') {
		        	// Split timestamp into [ Y, M, D, h, m, s ]
		        	if (source[5] == 1) {
			        	source[5] = "Yes";
		        	}
		        	else {
			        	source[5] = "No";
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
			{ "mData": "7", sDefaultContent: "" }, //tags
			/*{ "mData": function ( source, type, val ) {
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
		      "sClass": "CenteredColumn" }*/
		]
		
		
		
		/*tableElement.$('tr').click( function () {
			var data = tableElement.fnGetData( this );
		});*/
		
		/*$('#datatable tbody').on( 'click', 'tr', function () {
			$(this).toggleClass('selected');
		} );*/


		
	});
	
	/*tableElement.$('td').click( function () {
		var sData = tableElement.fnGetData( this );
		alert( 'The cell clicked on had the value of '+sData );
	} );*/
	
	/*function myFunction(test) {
    var index;
    var text = "<ul>";
    for (index = 0; index < test.length; index++) {
        text += "<li>" + test[index] + "</li>";
    }
    text += "</ul>";
    document.getElementById("demo").innerHTML = text;
	}*/
	
	
	//var oTT = TableTools.fnGetInstance('tableElement');
	//var gamechallenges = tableElement.fnGetSelectedData();
	//alert(gamechallenges.join('\n')); 
	
	
	/*var oTT = TableTools.fnGetInstance( 'tableElement' );
    
    if ( oTT.fnIsSelected( $('#tableElement tbody tr:eq(0)')[0] ) ) {
        alert( 'First row is selected' );
    } else {
        alert( 'First row is not selected' );
    }*/


	
	ReloadMethods();
});
function ReloadMethods() {
	$('#edit-container').jvalidate();
	$('#txtTitle').focus();
	$(".numeric").numeric();
	$(".integer").numeric(false, function() { alert("Integers only"); this.value = ""; this.focus(); });
	$(".positive").numeric({ negative: false }, function() { alert("No negative values"); this.value = ""; this.focus(); });
	$(".positive-integer").numeric({ decimal: false, negative: false }, function() { alert("Positive integers only"); this.value = ""; this.focus(); });
	var required = false;
	addedFiles = 0;
    if ($('.file').hasClass('required')) {
        required = true;
    }
    $('.file').fineUploader({
        request: {
            endpoint: '<?php echo $fullUrl; ?>admin/handlers/file-uploader.php'
        },
        failedUploadTextDisplay: {
            mode: 'custom',
            maxChars: 1000
        },
        validation: {
            allowedExtensions: [<?php echo $jsAllowedExtensions; ?>],
            sizeLimit: 10240000 // 50 kB = 50 * 1024 bytes
        },
        text: {
	        uploadButton: 'SELECT FILE(S)'
	    }
    }).on("complete", function (id, fileName, responseJSON, json) {
        if (json.success) {
            addedFiles++;
            if (addedFiles >= fileLimit) {
                $(this).find('.qq-upload-button').hide();
                $(this).find('.qq-upload-drop-area').hide();
            }
            var txtFilename = 'Filename';
            if (addedFiles > 0) {
                txtFilename = txtFilename + addedFiles;
            }
            $('.file').append('<input type="text" name="' + txtFilename + '" id="' + txtFilename + '" value="' + json.fileName + '" class="uploaded-file" style="display:none;" />');
            $('.default-button').show();
        }
    });
}
function ajaxSave(gamechallenges) {
	$('#modal-loader').show();
	//alert('Made it to ajaxSave');
	//alert(gamechallenges);
	
	<?php
$GameId = "";
if (isset($_GET["gameid"]))
{
	$GameId = $_GET["gameid"];
}

$GameChallengeFactory = new GameChallengeFactory();
$GameChallengeArray = $GameChallengeFactory->GetAllByGame(" where GameId = " . escapeString($GameId));

?>
	
	//var GameChallengeArray = GameChallengeFactory->GetAllByGame(" where GameId = " . escapeString(<?php echo $_GET["gameid"]; ?>));
	//var GameChallengeArray = <?php echo json_encode($GameChallengeArray) ?>;
	//alert(GameChallengeArray);
	//alert( $(this).data("GameChallengeArray").toString() )
	//alert(GameChallengeArray[1]['RowPosition']);
	//var positions = []
	//for(row in GameChallengeArray){
	
	//positions.push(GameChallengeArray[row]['RowPosition']);
		//ajaxSave(aData[row][0]);
	//var maxRowPosition = Math.max.apply(Math,GameChallengeArray.map(function(o){return o.y;}));
	//}
	//alert(positions);
	
	//var maxRowPosition = Math.max.apply(Math, positions);
  
	//alert(maxRowPosition);
	
	//alert(gamechallenges);
	
	for(row in gamechallenges){
		//ajaxSave(aData[row][0]);

		//alert("Made it to loop");
	
	
	
	var postdata = {};
	postdata['ChallengeId'] = gamechallenges[row][0];
	postdata['GameId'] = <?php echo $_GET["gameid"]; ?>;
	postdata['RowPosition'] = '';
	//postdata['RowPosition'] = maxRowPosition + 1;
	/*postdata['Description'] = $('#txtDescription').val();
	postdata['CorrectAnswer'] = $('#txtCorrectAnswer').val();
	postdata['PointValue'] = $('#txtPointValue').val();
	postdata['Tags'] = $('#txtTags').val();
	postdata['IsComplete'] = IsComplete;
	postdata['IsOpen'] = IsOpen;
	if (addedFiles > 0) {
		postdata['FileNumber'] = addedFiles;
	}*/
	//get the files added
	/*for (var i=1;i<=addedFiles;i++)
	{
		postdata['Filename'+i] = $('#Filename'+i).val();
	}*/
	//alert("New max position is " . postdata['RowPosition']);
	$.post('<?php echo $fullUrl; ?>admin/handlers/gamechallenges/save.php', postdata, function(output) {
		$('#lblSaveResponse').html(output).show();
		$('#modal-loader').hide();
		//CancelEdit();
		//ajaxLoadRecords();
	});
	
	
	//maxRowPosition = maxRowPosition + 1;
	//alert("End of loop");
	}
	CancelEdit();
	ajaxLoadRecords();
	
}
function ajaxLoadRecords() {
	$table = $('#datatable').dataTable();
	$table.fnDraw();
}
function ajaxLoadRecord(id) {
	$('#modal-loader').show();
	$.post('<?php echo $fullUrl; ?>admin/handlers/challenges/load.php', { 
		Id: id
		}, function(output) {
			$('#edit-container').html(output).show();
			$('#modal-loader').hide();
			ReloadMethods();
	});
}

//function maxRow(id) {
	//$('#modal-loader').show();
	/*$.post('<?php echo $fullUrl; ?>admin/handlers/gamechallenges/load.php', { 
		Id: id
		}, function(output) {
			$('#edit-container').html(output).show();
			$('#modal-loader').hide();
			ReloadMethods();
	});*/
	
//}

function ajaxDeleteItem(id) {
	$('#modal-loader').show();
	$.post('<?php echo $fullUrl; ?>admin/handlers/challenges/delete.php', { 
		Id: id
		}, function(output) {
			$('#edit-container').html(output).show();
			$('#modal-loader').hide();
			ajaxLoadRecords();
	});
}
function DeleteFile(id, name, el) {
	$('#modal-loader').show();
	$.post('<?php echo $fullUrl; ?>admin/handlers/challenges/delete-file.php', { 
		Id: id,
		Filename: name
		}, function(output) {
			$('#modal-loader').hide();
			$(el).parent().remove()
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
	$('#txtPointValue').val('');
	$('#txtTags').val('');
	$('#txtCorrectAnswer').val('');
	$('#chbIsComplete').removeAttr('checked');
	$('#chbIsOpen').removeAttr('checked');
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
var fileCount = 0;
var addedFiles = 0;
var fileLimit = 10;
</script>