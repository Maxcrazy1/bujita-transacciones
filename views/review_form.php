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
			<p><?=$active_page_data['content']?></p>
		  </div>
		  <form action="controllers/review_form.php" class="phone-sell-form" method="post" id="review_form" enctype="multipart/form-data">
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group">
				<input type="text" name="name" id="name" placeholder="Enter name" class="form-control" />
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group">
				<input type="text" name="email" id="email" placeholder="Enter email" class="form-control" />
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-4">
			  <div class="form-group">
			  	<select name="country" id="country" class="form-control">
					<option value=""> - Country - </option>
					<?php
					foreach($countries_list as $c_k => $c_v) { ?>
						<option value="<?=$c_v?>"><?=$c_v?></option>
					<?php
					} ?>
				</select>
			  </div>
			</div>
			<div class="col-md-4">
			  <div class="form-group">
				<input type="text" name="state" id="state" placeholder="Enter state" class="form-control" />
			  </div>
			</div>
			<div class="col-md-4">
			  <div class="form-group">
				<input type="text" name="city" id="city" placeholder="Enter city" class="form-control" />
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-12">
			  <div class="form-group">
				<div class="controls Reqwidth">
					<small class="help-block"><strong>How would you rate this business overall?</strong></small>
					<select name="rating" id="rating" class="form-control">
						<option value=""> - Rating Star - </option>
						<?php
						for($si = 0.5; $si<= 5.0; $si=$si+0.5) { ?>
							<option value="<?=$si?>" <?php if($si == '4.5'){echo 'selected="selected"';}?>><?=$si?></option>
						<?php
						} ?>
					</select>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group">
				<input type="text" name="title" id="title" placeholder="Enter title" class="form-control" />
			  </div>
			</div>			
			<div class="col-md-6">			  
			  <div class="form-group">
			  	<div class="upload-btn-wrapper">
  				  <button class="btn">Upload Avatar</button>				
				  <input type="file" name="image" id="image" class="form-control"/>
				</div>
			  </div>			
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-12">
			  <div class="form-group">
				<textarea name="content" id="content" placeholder="Enter content" class="form-control"></textarea>
			  </div>
			</div>
		  </div>
		  <?php
		  if($write_review_form_captcha == '1') { ?>
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
		  <div class="row last">
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
		<div class="right-sidebar clarfix">
		  <div class="h3">Contact Us</div>
		  <p>
		  <?php
		  if($company_name) {
			 echo '<strong>'.$company_name.'</strong>';
		  }
		  if($company_address) {
			 echo '<br />'.$company_address;
		  }
		  if($company_city) {
			 echo '<br />'.$company_city.' '.$company_state.' '.$company_zipcode;
		  }
		  if($company_country) {
			 echo '<br />'.$company_country;
		  } ?>
		  <ul class="contact">
			<?php
			if($site_phone) {
				echo '<li><i class="fa fa-envelope" aria-hidden="true"></i><a href="tel:'.$site_phone.'">Phone: '.$site_phone.'</a></li>';
			}
			if($site_email) {
				echo '<li><i class="fa fa-phone-square" aria-hidden="true"></i><a href="mailto:'.$site_email.'">Email: '.$site_email.'</a></li>';
			}
			if($website) {
				echo '<li><i class="fa fa-globe" aria-hidden="true"></i><a href="'.$website.'">'.$website.'</a></li>';
			} ?>
		  </ul>
		</div>
	  </div>
  </div>
  </div>
</section>
				
<script>
<?php
if($write_review_form_captcha == '1') { ?>
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
		$('#review_form').bootstrapValidator({
			fields: {
				name: {
					validators: {
						stringLength: {
							min: 1,
						},
						notEmpty: {
							message: 'Please enter your name'
						}
					}
				},
				email: {
					validators: {
						notEmpty: {
							message: 'Please enter your email address'
						},
						emailAddress: {
							message: 'Please enter your valid email address'
						}
					}
				},
				state: {
					validators: {
						stringLength: {
							min: 1,
						},
						notEmpty: {
							message: 'Please enter your state'
						}
					}
				},
				city: {
					validators: {
						stringLength: {
							min: 1,
						},
						notEmpty: {
							message: 'Please enter your city'
						}
					}
				},
				rating: {
					validators: {
						notEmpty: {
							message: 'Please select rating star'
						}
					}
				},
				title: {
					validators: {
						notEmpty: {
							message: 'Please enter your title'
						}
					}
				},
				content: {
					validators: {
						notEmpty: {
							message: 'Please enter your content'
						}
					}
				}
			}
		}).on('success.form.bv', function(e) {
            $('#review_form').data('bootstrapValidator').resetForm();

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