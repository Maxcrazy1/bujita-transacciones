<?php
//Header section
include("include/header.php");

//If already loggedin and try to access lost password page, it will redirect to account
if($user_id>0) {
	setRedirect(SITE_URL.'account');
	exit();
} ?>

<section>
<div class="container">
  <div class="row">
	<div class="col-md-12">
	  <div class="block head pb-0 mb-0 border-line text-center clearfix">
		<h1 class="h1 border-line clearfix"><?php echo $LANG['Forgot your password?']; ?></h1>
	  </div>
	</div>
  </div>
  <div class="row justify-content-center">
	<div class="col-md-8">
	  <div class="block content bulk-sale-form text-center clearfix">
	  <p><?php echo $LANG['Enter the e-mail address associated with your Cash Movil account, then click SUBMIT. We will email you a link to a page where you can easily create a new password.']; ?></p>
	  <form action="controllers/user/lost_password.php" method="post" id="lost_psw_form" class="pb-5 mb-5 bv-form">
		<div class="form-group">
		  <label for="username"><?php echo $LANG['Email']; ?></label>
		  <input type="text" class="form-control" id="email" name="email" placeholder="" autocomplete="off">
		</div>
		<div class="clearfix"></div>
		<div class="form-group">
			<a class="btn btn-secondary float-left" href="<?=$login_link?>"><?php echo $LANG['RETURN TO LOGIN']; ?></a>
			<button type="submit" class="btn btn-primary float-right"><?php echo $LANG['SUBMIT']; ?></button>
			<input type="hidden" name="reset" id="reset" />
			<input type="hidden" name="user_id" id="user_id" value="<?=$user_id?>" />
		</div>
		</form>
	  </div>
	</div>
  </div>  
</div>
</section>


<script>
(function( $ ) {
	$(function() {
		$('#lost_psw_form').bootstrapValidator({
			fields: {
				email: {
					validators: {
						notEmpty: {
							message: '<?php echo $LANG['Please enter an email address']; ?>'
						},
						emailAddress: {
							message: '<?php echo $LANG['Please enter a valid email address']; ?>'
						}
					}
				}
			}
		}).on('success.form.bv', function(e) {
            //$('#success_message').slideDown({ opacity: "show" }, "slow") // Do something ...
                $('#lost_psw_form').data('bootstrapValidator').resetForm();

            // Prevent form submission
            e.preventDefault();

            // Get the form instance
            var $form = $(e.target);

            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');

            // Use Ajax to submit form data
            $.post($form.attr('action'), $form.serialize(), function(result) {
                console.log(result);
            }, 'json');
        });
	});
})(jQuery);
</script>