<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/assets/classes/core.php'); ?>
<div id="custom-content" class="white-popup-block" style="max-width:600px; margin: 20px auto;">
	<div class="scan-container">
	    <h1>Scan Ticket</h1>
	    <div class="well">
		    <div id="div_ScanImage" class="divTableStyle">
		        <ul id="ulScaneImageHIDE" style="padding-left:0;">
		            <li style="padding-left: 0;">
		                <div class="styled-select">
			                <select size="1" id="source" class="form-control" style="position:relative;width: 600px;" onchange="source_onchange()">
			                    <option value="">-Select Source-</option>    
			                </select>
		                </div>
		            </li>
	                <li style="display:none;" id="pNoScanner">
	                    <a href="javascript: void(0)" class="ShowtblLoadImage" style="font-size: 11px; background-color:#f0f0f0; position:relative" id="aNoScanner"><b>What if I don't have a scanner/webcam connected?</b>
						</a>
	                </li>
	                <li id="divProductDetail"></li>
	                <li style="text-align:center;">
	                	<a class="btn btn-default btn-orange" id="btnScan" href="javascript:void(0);" onclick="acquireImage();">SCAN</a>
	                	<a class="btn btn-default btn-orange" id="btnUpload" style="margin-top:10px;" href="javascript:void(0);" onclick="btnUpload_onclick();">UPLOAD</a>
	                </li>
		        </ul>
		    </div>
	    </div>
	</div>
	<div class="scanner-output">
		<div id="dwtcontrolContainer" style="width:100%;"></div>
		<div id="DWTNonInstallContainerID" style="width:100%;"></div>
		<div id="DWTemessageContainer" style="width:100;"></div>
	</div>
	<div class="D-dailog" id="J_waiting">
	    <div id = "InstallBody"></div>
	</div>
	<script type="text/javascript" src="<?php echo $fullUrl; ?>assets/dwt/scripts/kissy-min.js"></script>
	<script type="text/javascript" src="<?php echo $fullUrl; ?>assets/dwt/scripts/dynamsoft.webtwain.initiate.js"></script>
	<script type="text/javascript" src="<?php echo $fullUrl; ?>assets/dwt/scripts/online_demo_operation.js"></script>
	<script type="text/javascript" src="<?php echo $fullUrl; ?>assets/dwt/scripts/online_demo_initpage.js"></script>
	<script type="text/javascript" src="<?php echo $fullUrl; ?>assets/js/site.js"></script>
	<script type="text/javascript" language="javascript">
	    // Assign the page onload fucntion.
	
	    S.ready(function() {
	        pageonload();
	    });
	
	</script>
	<style type="text/css">
		.scanner-output { display:block; }
		#btnScan { display:none; }
		#btnUpload { display:none; }
		#DWTemessageContainer { display:none; }
	</style>

</div>