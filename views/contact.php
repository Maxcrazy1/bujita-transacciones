<?php
//Url encode for embed map
//$business_address = trim(urlencode($company_name.' '.$company_address.' '.$company_city.' '.$company_state.' '.$company_zipcode));

//Header Image
if($active_page_data['image'] != "") { ?>
	<section>
		<?php
		if($active_page_data['image_text'] != "") {
			echo '<h2>'.$active_page_data['image_text'].'</h2>';
		} ?>
		<img src="<?=SITE_URL.'images/pages/'.$active_page_data['image']?>" alt="<?=$active_page_data['title']?>" width="100%">
	</section>
<?php
}

//START for faqs/groups
$faqs_groups_data_html = get_faqs_groups_with_html();
if($faqs_groups_data_html['html']!="") {
	$active_page_data['content'] = str_replace("[faqs_groups]",$faqs_groups_data_html['html'],$active_page_data['content']);
} else {
	$active_page_data['content'] = str_replace("[faqs_groups]",'',$active_page_data['content']);
} //END for faqs/groups
?>

  <section>
    <div class="container">
	<?php
	//START for faqs/groups
	$faqs_groups_data_html = get_faqs_groups_with_html();
	echo $faqs_groups_data_html['html'];
	//END for faqs/groups ?>

      <div class="row">
        <div class="col-md-12">
          <div class="block head pb-0 mb-0 border-line text-center clearfix">
            <h1 class="h1 border-line clearfix">CONTACTENOS</h1>
            <p class="pt-3 pb-3">Puedes ponerte en contacto con nosotros a traves de la siguiente informacion si aun tienes dudas, y estaremos encantados de ayudarte.</p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="block address-block clearfix">
            <h3>DIRECCION</h3>
            <p><strong><?=$company_name?></strong><br /><?=$company_address?><br /><?=$company_city.', '.$company_state.' '.$company_zipcode?></p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="block address-block clearfix">
            <h3>EMAIL</h3>
            <p><a href="mailto:<?=$site_email?>"><?=$site_email?></a></p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="block address-block clearfix">
            <h3>TELEFONO</h3>
            <p><a href="tel:<?=$site_phone?>"><?=$site_phone?></a></p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="block contact-form clearfix">
            <form class="pb-5 mb-5" action="controllers/contact.php" method="post" id="contact_form">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="name">NOMBRE Y APELLIDOS</label>
                  <input type="text" name="name" id="name" placeholder="" class="form-control" />
                </div>
                <div class="form-group col-md-6">
                  <label for="email">EMAIL</label>
                  <input type="text" name="email" id="email" placeholder="" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label for="subject">SUJETO</label>
                <input type="text" name="subject" id="subject" placeholder="" class="form-control" />
              </div>
              <div class="form-group">
                <label for="message">MENSAJE</label>
                <textarea name="message" id="message" placeholder="" class="form-control" rows="3"></textarea>
              </div>
							<div class="form-row">
							<?php
							if($contact_form_captcha == '1') { ?>
							<div class="form-group col-md-6">
							<div id="g_form_gcaptcha"></div>
							<input type="hidden" id="g_captcha_token" name="g_captcha_token" value="" />
							</div>
							<?php
							} ?>
							<div class="form-group col-md-6">
								<button type="submit" class="btn btn-primary mt-md-5 float-right">ENVIAR MENSAJE</button>
							</div>
							</div>
			  
              <div class="clearfix"></div>
              
				<input type="hidden" name="submit_form" id="submit_form" />
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

<script>
<?php
if($contact_form_captcha == '1') { ?>
var CaptchaCallback = function() {
	if(jQuery('#g_form_gcaptcha').length) {
		grecaptcha.render('g_form_gcaptcha', {
			'sitekey' : '<?=$captcha_key?>',
			'callback' : onSubmitForm,
		});
	}
};

var onSubmitForm = function(response) {
	if(response.length == 0) {
		jQuery("#g_captcha_token").val('');
	} else {
		//$(".sbmt_button").removeAttr("disabled");
		jQuery("#g_captcha_token").val('yes');
	}
};
<?php
} ?>

/*(function( $ ) {
	$(function() {
		var telInput = $("#cell_phone");
		telInput.intlTelInput({
		  initialCountry: "auto",
		  geoIpLookup: function(callback) {
			$.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
			  var countryCode = (resp && resp.country) ? resp.country : "";
			  callback(countryCode);
			});
		  },
		  utilsScript: "js/intlTelInput-utils.js" //just for formatting/placeholders etc
		});

		// on keyup / change flag: reset
		telInput.on("keyup change", reset);
	});
})(jQuery);*/

(function( $ ) {
	$(function() {
		$('#contact_form').bootstrapValidator({
			fields: {
				name: {
					validators: {
						stringLength: {
							min: 1,
						},
						notEmpty: {
							message: 'Please enter name'
						}
					}
				}/*,
				cell_phone: {
					validators: {
						callback: {
							message: 'Please enter valid phone number',
							callback: function(value, validator, $field) {
								var telInput = $("#cell_phone");
								$("#phone").val(telInput.intlTelInput("getNumber"));
								if(!telInput.intlTelInput("isValidNumber")) {
									return false;
								} else if(telInput.intlTelInput("isValidNumber")) {
									return true;
								}
							}
						}
					}
				}*/,
				email: {
					validators: {
						notEmpty: {
							message: 'Por favor, introduzca la direccion de correo electronico'
						},
						emailAddress: {
							message: 'Por favor, introduzca una direccion de correo electronico valida'
						}
					}
				},
				subject: {
					validators: {
						notEmpty: {
							message: 'Por favor, introduzca su asunto'
						}
					}
				},
				message: {
					validators: {
						notEmpty: {
							message: 'Por favor, introduzca su mensaje'
						}
					}
				}
			}
		}).on('success.form.bv', function(e) {
            $('#contact_form').data('bootstrapValidator').resetForm();

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