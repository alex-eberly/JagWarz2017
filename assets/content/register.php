<div class="row">
	<div class="col-md-12">
		<div class="bounding-box">
			<div class="bounding-box-inner">
				<form id="form-login" class="form-signin">
					<h1>REGISTER</h1>
					<span id="lblResponse"></span>
					<span class="form-label">First Name: *</span>
					<div class="form-group">
						<input type="text" id="txtFirstname" class="form-control required" placeholder="Enter First Name" autofocus>
					</div>
					<span class="form-label">Last Name: *</span>
					<div class="form-group">
						<input type="text" id="txtLastname" class="form-control required" placeholder="Enter Last Name" >
					</div>
					<span class="form-label">Username: *</span> <span id="username-validation"></span>
					<div class="form-group">
						<input type="hidden" id="hdnUsernameValidation" class="required" requiredby="txtUsername">
						<input type="text" id="txtUsername" class="form-control required" onblur="VerifyUsername();" placeholder="Enter Username" >
					</div>
					<span class="form-label">Email: *</span> <span id="email-validation"></span>
					<div class="form-group">
						<input type="hidden" id="hdnEmailValidation" class="required" requiredby="txtEmail">
						<input type="text" id="txtEmail" class="form-control required" onblur="VerifyEmail();" placeholder="Enter Email Address" >
					</div>
					<span class="form-label">Password: *</span> <span id="password-validation" style="display:inline-block;margin-bottom:2px;"></span>  <span id="password-match-validation"></span>
					<div class="form-group">
						<input type="hidden" id="hdnPasswordValid" class="required" requiredby="txtPassword2">
						<input type="password" id="txtPassword" class="form-control required" placeholder="Enter Password" >
					</div>
					<span class="form-label">Re-enter Password: *</span> <span id="password-validation2" style="display:inline-block;margin-bottom:2px;"></span>
					<div class="form-group">
						<input type="password" id="txtPassword2" class="form-control required" onkeyup="checkPasswordMatch();" placeholder="Re-enter Password">
					</div>
					<span class="form-label">Enter Game Code: *</span> <span id="game-code-validation"></span>
					<div class="form-group">
						<input type="hidden" id="hdnGameCodeValidation" class="required" requiredby="txtGameCode">
						<input type="text" id="txtGameCode" class="form-control required" onkeyup="VerifyGameCode();" placeholder="Enter Game Code">
					</div>
					<button class="btn btn-lg btn-orange btn-block default-button" onclick="Register()" type="button">REGISTER</button>
					<a class="btn btn-lg btn-orange btn-block" href="forgot-password.php">FORGOT PASSWORD?</a>
					<a class="btn btn-lg btn-orange btn-block" href="/">BACK TO LOGIN</a>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo $fullUrl; ?>assets/js/plugins/passstrength/jquery.passstrength.min.js"></script> 
<script type="text/javascript">
$(document).ready(function() {
	$('#form-login').jvalidate({
		errorBackgroundColor: '#FFEBE8',
        border: 'solid 2px #D4D4D4',
        errorBorder: 'solid 2px #C00'
	});
	$('#txtPassword').passStrengthify({element: $('#password-validation')});
	$('#txtPassword2').passStrengthify({element: $('#password-validation2')});
});
function checkPasswordMatch() {
    var password = $("#txtPassword").val();
    var confirmPassword = $("#txtPassword2").val();

    if (password != confirmPassword) {
        $("#password-match-validation").html("<span class=\"red-text message\">Passwords do not match!</span>");
        $('#hdnPasswordValid').val('');
    }
    else {
    	$("#password-match-validation").html("");
    	$('#hdnPasswordValid').val('true');
    }
}
function Register() {
	$('#loader').show();
	$.post('handlers/register-user.php', { username: $('#txtUsername').val(), firstname: $('#txtFirstname').val(), 
        lastname: $('#txtLastname').val(), emailaddress: $('#txtEmail').val(), password: $('#txtPassword').val(),
        gameCode: $('#txtGameCode').val()  }, function(output) {
		$('#lblResponse').html(output).show();
		$('#loader').hide();
	});
}
function VerifyUsername() {
	if ($('#txtUsername').val() != "") {
		$.post('handlers/verify-username.php', { username: $('#txtUsername').val()  }, function(output) {
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
function VerifyEmail() {
	if ($('#txtEmail').val() != "") {
		if (isValidEmailAddress($('#txtEmail').val())) {
			$.post('handlers/verify-email.php', { emailaddress: $('#txtEmail').val()  }, function(output) {
				$('#email-validation').html(output).show();
				if (output == "<span class=\"red-text message\">Not Available!</span>") {
					$('#hdnEmailValidation').val('');
				}
				else {
					$('#hdnEmailValidation').val('true');
				}
			});
		}
		else {
			$('#email-validation').html("<span class=\"red-text message\">Invalid!</span>").show();
		}
	}
}
function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
    return pattern.test(emailAddress);
};
function VerifyGameCode() {
	$.post('handlers/verify-game-code.php', { gameCode: $('#txtGameCode').val()  }, function(output) {
		$('#game-code-validation').html(output).show();
		if (output == "<span class=\"red-text message\">Invalid code!</span>") {
			$('#hdnGameCodeValidation').val('');
		}
		else {
			$('#hdnGameCodeValidation').val('true');
		}
	});
}
</script>