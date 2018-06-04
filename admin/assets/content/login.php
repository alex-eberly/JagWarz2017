<div class="wrapper">
		<div class="logo">
	 	<h1>LOGIN PAGE</h1>
	 </div>
	 <span id="lblResponse"></span>
   <div class="lg-body" style="height:200px;">
     <div class="inner">
       <div id="lg-head">
         <p><span class="font-bold">JagWaRz</span>: Please login to access the control panel.</p>
         <div class="separator"></div>
       </div>
       <div class="login">
<form id="lg-form" action="#">
   <fieldset>
      <ul>
         <li id="usr-field">
          <input class="input required" name="name" id="txtEmail" type="text" size="26" minlength ="1" placeholder="Email..." />
          <span id="usr-field-icon"></span>
         </li>
         <li id="psw-field">
          <input class="input required" name="pass" id="txtPassword" type="password" size="26" minlength="1" placeholder="Password..." />
          <span id="psw-field-icon"></span>
         </li>
         <li>
          <input class="submit button green default-button" type="button" value="LOGIN" onclick="authenticateUser();" />
         </li>
      </ul>
   </fieldset>
  </form>
  <span id="lost-psw">
   <a href="<?php echo $fullUrl; ?>admin/forgot-password.php">I forgot my password</a>
  </span>
  </div>
     </div>
    </div>
	</div>
	    <!---FadeIn Effect, Validation and Spinner-->
  <script>
    $(document).ready(function () {
       $('div.wrapper').hide();
        $('div.wrapper').fadeIn(1200);
        $('#lg-form').jvalidate();
        $('.submit').click(function() {
        var $this = $(this);
        $this.spinner({
	        img: '<?php echo $fullUrl; ?>admin/assets/img/spinner.gif'
        });
        setTimeout(function() {
                $this.spinner('remove');
        }, 1000);
       });
    });
    function authenticateUser() {
	    $.post('<?php echo $fullUrl; ?>admin/handlers/authenticate-user.php', { email: $('#txtEmail').val(), password: $('#txtPassword').val()  }, function(output) {
			$('#lblResponse').html(output).show();
		});
    }
  </script>