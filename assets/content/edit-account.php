<?php 
$UserFactory = new UserFactory();
$u = $UserFactory->GetOne($_SESSION["UserId"]);
?>
<div class="row">
	<div class="col-md-12">
		<div class="bounding-box">
			<div class="bounding-box-inner">
				<form id="form-login" class="form-signin">
					<h1>MY ACCOUNT</h1>
					<input type="hidden" id="hdnUserId" value="<?php echo $u->UserId; ?>">
					<span class="form-label">First Name: *</span>
					<div class="form-group">
						<input type="text" id="txtFirstname" class="form-control required" placeholder="Enter First Name" value="<?php echo $u->Firstname; ?>" autofocus>
					</div>
					<span class="form-label">Last Name: *</span>
					<div class="form-group">
						<input type="text" id="txtLastname" class="form-control required" placeholder="Enter Last Name" value="<?php echo $u->Lastname; ?>" >
					</div>
					<span class="form-label">Username: *</span> <span id="username-validation"></span>
					<div class="form-group">
						<input type="hidden" id="hdnUsernameValidation" class="required" requiredby="txtUsername" value="<?php echo $u->Username; ?>">
						<input type="hidden" id="hdnUsernameCurrent" class="required" value="<?php echo $u->Username; ?>">
						<input type="text" id="txtUsername" class="form-control required" onblur="VerifyUsername();" value="<?php echo $u->Username; ?>" placeholder="Enter Username" >
					</div>
					<span class="form-label">Email: *</span> <span id="email-validation"></span>
					<div class="form-group">
						<input type="hidden" id="hdnEmailValidation" class="required" value="true" requiredby="txtEmail">
						<input type="hidden" id="hdnEmailCurrent" class="required" value="<?php echo $u->Email; ?>">
						<input type="text" id="txtEmail" class="form-control required" value="<?php echo $u->Email; ?>" onblur="VerifyEmail();" placeholder="Enter Email Address" >
					</div>
					<span class="form-label">Password: *</span> <span id="password-validation" style="display:inline-block;margin-bottom:2px;"></span>  <span id="password-match-validation"></span>
					<div class="form-group">
						<input type="hidden" id="hdnPasswordValid" class="" requiredby="txtPassword2">
						<input type="password" id="txtPassword" class="form-control" placeholder="Enter Password" >
					</div>
					<span class="form-label">Re-enter Password: *</span> <span id="password-validation2" style="display:inline-block;margin-bottom:2px;"></span>
					<div class="form-group">
						<input type="password" id="txtPassword2" class="form-control" onkeyup="checkPasswordMatch();" placeholder="Re-enter Password">
					</div>
					<button class="btn btn-lg btn-orange btn-block default-button" onclick="Save()" type="button">SAVE</button>
					<div id="lblResponse" style="margin-top:10px;"></div>
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
function Save() {
	$('#loader').show();
	$.post('handlers/users/UserSave.php', { UserId: $('#hdnUserId').val(), firstname: $('#txtFirstname').val(), username: $('#txtUsername').val(), usernameCurrent: $('#hdnUsernameCurrent').val(),
        lastname: $('#txtLastname').val(), emailaddress: $('#txtEmail').val(), emailaddressCurrent: $('#hdnEmailCurrent').val(), password: $('#txtPassword').val()  }, function(output) {
		$('#lblResponse').html(output).slideDown(500).delay(3000).slideUp(500);;
		$('#loader').hide();
	});
}
function VerifyEmail() {
	if ($('#txtEmail').val() != "" && ($('#hdnEmailCurrent').val() != $('#txtEmail').val())) {
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