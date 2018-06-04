<div class="row">
	<div class="col-md-12">
		<div class="bounding-box">
			<div class="bounding-box-inner">
				<form id="form-login" class="form-signin">
					<h1>FORGOT PASSWORD</h1>
					<span id="lblResponse"></span>
					<div class="form-group">
						<input type="text" id="txtEmail" class="form-control required" placeholder="Enter Email or Username" autofocus>
					</div>
					<button class="btn btn-lg btn-orange btn-block default-button" onclick="ajaxSendPassword()" type="button">RESET PASSWORD</button>
					<a class="btn btn-lg btn-orange btn-block" href="register.php">REGISTER NOW</a>
					<a class="btn btn-lg btn-orange btn-block" href="/">BACK TO LOGIN</a>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('#form-login').jvalidate({
			errorBackgroundColor: '#FFEBE8',
	        border: 'solid 2px #D4D4D4',
	        errorBorder: 'solid 2px #C00'
		});
	});
	function ajaxSendPassword() {
		$.post('handlers/reset-password.php', { email: $('#txtEmail').val()  }, function(output) {
			$('#lblResponse').html(output).show();
		});
	}
</script>