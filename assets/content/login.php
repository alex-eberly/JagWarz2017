<div class="row">
	<div class="col-md-12">
		<div class="bounding-box">
			<div class="bounding-box-inner">
				<form id="form-login" class="form-signin">
					<h1>LOGIN</h1>
					<span id="lblResponse"></span>
					<div class="form-group">
						<input type="text" id="txtUsername" class="form-control required" placeholder="Username" autofocus>
					</div>
					<div class="form-group">
						<input type="password" id="txtPassword" class="form-control required" placeholder="Password">
					</div>
					<button class="btn btn-lg btn-orange btn-block default-button" onclick="ajaxAuthenticate()" type="button">LOGIN</button>
					<a class="btn btn-lg btn-orange btn-block" href="forgot-password.php">FORGOT PASSWORD?</a>
					<a class="btn btn-lg btn-orange btn-block" href="register.php">REGISTER NOW</a>
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
function ajaxAuthenticate() {
	$.post('handlers/authenticate-user.php', { username: $('#txtUsername').val(), password: $('#txtPassword').val()  }, function(output) {
		$('#lblResponse').html(output).show();
	});
}
</script>