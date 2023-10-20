<?php
//Header Image
if($active_page_data['image'] != "") { ?>
	<section>
	  <div class="row">

		<?php
		if($active_page_data['image_text'] != "") { ?>
			<h2><?=$active_page_data['image_text']?></h2>
		<?php
		} ?>

		<img src="<?=SITE_URL.'images/pages/'.$active_page_data['image']?>" alt="<?=$active_page_data['title']?>" width="100%">
	  </div>
	</section>
<?php
} ?>

<section>
  <div class="container">
	<div class="row">
	  <div class="col-md-8">
		<div class="block content-block clearfix">
		  <div class="head head-account">
			<?php
		  	if($active_page_data['show_title'] == '1') { ?>
			<div class="h2"><strong><?=$active_page_data['title']?></strong></div>
			<?php
			} ?>
			<?=($active_page_data['content']?'<p>'.$active_page_data['content'].'</p>':'')?>
		  </div>
		  <form action="controllers/affiliates.php" class="phone-sell-form" method="post" id="affiliate_form">
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group">
				<input type="text" name="name" id="name" placeholder="Enter name" class="form-control" />
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group">
				<input type="tel" id="cell_phone" name="cell_phone" class="form-control" placeholder="">
				<input type="hidden" name="phone" id="phone" />
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group">
				<input type="text" name="email" id="email" placeholder="Enter email" class="form-control" />
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group">
				<input type="text" name="company" id="company" placeholder="Enter company name" class="form-control" />
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group">
				<input type="text" name="subject" id="subject" placeholder="Enter subject" class="form-control" />
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group">
				<input type="text" name="web_address" id="web_address" placeholder="Enter web address" class="form-control" />
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-12">
			  <div class="form-group">
				<textarea name="message" id="message" placeholder="Enter message" class="form-control"></textarea>
			  </div>
			</div>
		  </div>
		  <?php
		  if($affiliate_form_captcha == '1') { ?>
		  <div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<div id="g_form_gcaptcha"></div>
					<input type="hidden" id="g_captcha_token" name="g_captcha_token" value=""/>
				</div>
			</div>
		  </div>
		  <?php
		  } ?>
		  <div class="row">
			<div class="col-md-12">
			  <div class="form-group">
				<button type="submit" class="btn btn-submit">Submit</button>
				<input type="hidden" name="submit_form" id="submit_form" />
			  </div>
			</div>
		  </div>
		</form>
		</div>
	  </div>
	  <div class="col-md-4">
		<div class="right-sidebar clearfix">
		  <div class="h3">Benifits of Joining Affiliate </div>
		  <ul class="no-links">
			<li><i class="fa fa-angle-right" aria-hidden="true"></i><span>Attractive commission for each handset sold</span></li>
			<li><i class="fa fa-angle-right" aria-hidden="true"></i><span>Independent verification of transactions</span></li>
			<li><i class="fa fa-angle-right" aria-hidden="true"></i><span>Online reporting</span></li>
			<li><i class="fa fa-angle-right" aria-hidden="true"></i><span>Free use of banners adverts</span></li>
			<li><i class="fa fa-angle-right" aria-hidden="true"></i><span>Free and easy to join</span></li>
		  </ul>
		</div>
	  </div>
  </div>
  </div>
</section>

<script>
<?php
if($affiliate_form_captcha == '1') { ?>
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

(function( $ ) {
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
})(jQuery);

(function( $ ) {
	$(function() {
		$('#affiliate_form').bootstrapValidator({
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
				},
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
				},
				email: {
					validators: {
						notEmpty: {
							message: 'Please enter email address'
						},
						emailAddress: {
							message: 'Please enter valid email address'
						}
					}
				}
			}
		}).on('success.form.bv', function(e) {
            $('#affiliate_form').data('bootstrapValidator').resetForm();

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