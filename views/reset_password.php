<?php
//Header section
include("include/header.php");

//Fetching data from model
require_once('models/user/reset_password.php'); ?>

<section>
<div class="container">
  <div class="row">
	<div class="col-md-12">
	  <div class="block head pb-0 mb-0 border-line text-center clearfix">
		<h1 class="h1 border-line clearfix">Restablecer su Contraseña</h1>
	  </div>
	</div>
  </div>
  <div class="row justify-content-center">
	<div class="col-md-8">
	  <div class="block content bulk-sale-form text-center clearfix">
	  <form action="controllers/user/reset_password.php" method="post" id="reset_psw_form" role="form">
		<div class="form-group">
		  <label for="username">Nueva Contraseña</label>
			<input type="password" class="form-control" id="new_password" name="new_password" placeholder="" autocomplete="off">
		</div>
		<div class="form-group">
		  <label for="username">Confirmar Contraseña</label>
			<input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="" autocomplete="off">
		</div>
		<div class="form-group">
		  <div class="clearfix">
			<a class="btn btn-secondary float-left" href="<?=$login_link?>">VOLVER A INICIAR SESIÓN</a>
			<button type="submit" class="btn btn-primary float-right">ENTREGAR</button>
			<input type="hidden" name="reset" id="reset" />
			<input type="hidden" name="t" id="t" value="<?=$post['t']?>" />
		  </div>
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
		$('#reset_psw_form').bootstrapValidator({
			fields: {
				new_password: {
					validators: {
						notEmpty: {
							message: 'Please enter new password.'
						},
						identical: {
							field: 'confirm_password',
							message: 'New password and confirm password not matched.'
						}
					}
				},
				confirm_password: {
					validators: {
						notEmpty: {
							message: 'Please enter confirm password.'
						},
						identical: {
							field: 'new_password',
							message: 'New password and confirm password not matched.'
						}
					}
				}
			}
		}).on('success.form.bv', function(e) {
            //$('#success_message').slideDown({ opacity: "show" }, "slow") // Do something ...
                $('#reset_psw_form').data('bootstrapValidator').resetForm();

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
