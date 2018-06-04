<div class="wrapper">
		<div class="logo">
	 	<h1>FORGOT PASSWORD</h1>
	 </div>
	 <span id="lblResponse"></span>
   <div class="lg-body" style="height:150px;">
     <div class="inner">
       <div id="lg-head">
         <p><span class="font-bold">JagWaRz</span>: Please enter your email.</p>
         <div class="separator"></div>
       </div>
       <div class="login">
<div id="lg-form">
   <fieldset>
      <ul>
         <li id="usr-field">
          <input class="input required email" id="txtEmail" name="name" type="text" size="26" minlength ="1" placeholder="Email..." />
          <span id="usr-field-icon"></span>
         </li>
         <li>
          <input class="submit button green default-button" type="button" value="RESET" onclick="ajaxSendPassword()" />
         </li>
      </ul>
   </fieldset>
  </div>
  <span id="lost-psw">
   <a href="<?php echo $fullUrl; ?>admin/index.php">Back to login</a>
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
        $('#lg-form').jvalidate({
	        backgroundColor: '#ffffff',
            errorBackgroundColor: '#FFEBE8',
            border: 'solid 1px #000',
            errorBorder: 'solid 1px #C00',
            summary: 'false',
            backgroundNone: false
        });
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
    function ajaxSendPassword() {
		$.post('<?php echo $fullUrl; ?>admin/handlers/reset-password.php', { email: $('#txtEmail').val()  }, function(output) {
			$('#lblResponse').html(output).show();
		});
	}
  </script>