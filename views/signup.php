<?php
//If already loggedin and try to access login page, it will redirect to account
if($user_id>0) {
	setRedirect(SITE_URL.'account');
	exit();
}

//Header Image
if($active_page_data['image'] != "") { ?>
	<section>
	  <div class="row">
		<?php
		if($active_page_data['image_text'] != "") {
			echo '<h2>'.$active_page_data['image_text'].'</h2>';
		} ?>
		<img src="<?=SITE_URL.'images/pages/'.$active_page_data['image']?>" alt="<?=$active_page_data['title']?>" width="100%">
	  </div>
	</section>
<?php
}

$user_prefill_email = $_SESSION['user_prefill_email'];
unset($_SESSION['user_prefill_email']); ?>

<?php
/*if($active_page_data['show_title'] == '1') { ?>
<div class="h2"><strong><?=$active_page_data['title']?></strong></div>
<?php
} ?>
<?=($active_page_data['content']?'<p>'.$active_page_data['content'].'</p>':'')*/?>

  <section>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="block block-signin-up clearfix">
            <nav>
              <div class="nav nav-tabs" id="signin-up-tab" role="tablist">
                <a class="nav-item nav-link" id="signin-tab" data-toggle="tab" href="#signin" role="tab" aria-controls="signin" aria-selected="true"><?php echo $LANG['I HAVE AN ACCOUNT']; ?></a>
                <a class="nav-item nav-link active" id="sign-up-tab" data-toggle="tab" href="#signup" role="tab" aria-controls="signup" aria-selected="false"><?php echo $LANG['CREATE A NEW ACCOUNT']; ?></a>
              </div>
            </nav>
            <div class="tab-content clearfix" id="signin-up-tabContent">
              <div class="tab-pane fade clearfix" id="signin" role="tabpanel" aria-labelledby="signin-tab">
                <div class="inner clearfix">
                  <div class="checkout-block clearfix">
                    <h3><?php echo $LANG['Customer Login']; ?></h3>
                    <div class="p-5">
                      <form class="clearfix" action="controllers/user/login.php" method="post" id="login_form">
                        <div class="form-group">
                          <label for="username"><?php echo $LANG['EMAIL']; ?></label>
                          <input type="text" class="form-control" id="username" name="username" placeholder="" autocomplete="off" value="<?=$user_prefill_email?>">
                        </div>
                        <div class="form-group">
                          <label for="password"><?php echo $LANG['PASSWORD']; ?></label>
                          <input type="password" class="form-control" id="password" name="password" placeholder="" autocomplete="off">
                        </div>
						<?php
					    if($login_form_captcha == '1') { ?>
						<div class="form-group">
							<div id="g_form_gcaptcha"></div>
							<input type="hidden" id="g_captcha_token" name="g_captcha_token" value=""/>
						</div>
					    <?php
					    } ?>
                        <div class="clearfix"></div>
                        <button type="submit" class="btn btn-primary btn-lg float-left"><?php echo $LANG['Login']; ?></button>
						<input type="hidden" name="submit_form" id="submit_form" />
                      </form>
                      <a href="lost_password" class="link-forgot-pass"><?php echo $LANG['Forgotten Your Password']; ?></a>
					  <?php
	  				  if($social_login=='1') { ?>
					    <script type="text/javascript" src="social/js/oauthpopup.js"></script>
						<script type="text/javascript">
						jQuery(document).ready(function($){
							//For Google
							$('a.google').oauthpopup({
								path: 'social/social.php?google',
								width:650,
								height:350,
							});
							$('a.google_logout').googlelogout({
								redirect_url:'<?php echo $base_url; ?>social/logout.php?google'
							});
				
							//For Facebook
							/*$('#facebook').oauthpopup({
								path: 'social/social.php?facebook',
								width:1000,
								height:1000,
							});*/
						});
						
						$(document).ready(function() {
						  $.ajaxSetup({ cache: true });
						  $.getScript('https://connect.facebook.net/en_US/sdk.js', function(){
							$("#facebookAuth").click(function() {
								FB.init({
								  appId: '<?=$fb_app_id?>',
								  version: 'v2.8'
								});
				
								FB.login(function(response) {
									if(response.authResponse) {
									 console.log('Welcome! Fetching your information.... ');
									 FB.api('/me?fields=id,name,first_name,middle_name,last_name,email,gender,locale', function(response) {
										 console.log('Response',response);							 	
										 $("#name").val(response.name);
										 $("#email").val(response.email);
										 
										 if(response.email!="") {
											 $.ajax({
												type: "POST",
												url:"ajax/social_login.php",
												data:response,
												success:function(data) {
													if(data!="") {
														var resp_data = JSON.parse(data);
														if(resp_data.msg!="" && resp_data.status == true) {
															location.reload(true);
														} else {
															alert("Something went wrong!!!");
														}
													} else {
														alert("Something went wrong!!!");
													}
												}
											});
										}		
				
									 });
									} else {
										console.log('User cancelled login or did not fully authorize.');
									}
								},{scope: 'email'});
							});
						  });
						});
						</script>
						
                      <div class="third_party_login clearfix">
                        <h3><?php echo $LANG['login with']; ?></h3>
                        <div class="third_parties clearfix">
						    <?php
							if($social_login_option=="g_f") { ?>
								<a id="facebookAuth" href="javascript:void(0);"><i class="fab fa-facebook-square"></i> FACEBOOK</a>
								<a class="google" href="javascript:void(0);"><i class="fa fa-google-plus"></i>GOOGLE</a>
							<?php
							} elseif($social_login_option=="g") { ?>
								<a class="google" href="javascript:void(0);"><i class="fa fa-google-plus"></i>GOOGLE</a>
							<?php
							} elseif($social_login_option=="f") { ?>
								<a id="facebookAuth" href="javascript:void(0);"><i class="fab fa-facebook-square"></i> FACEBOOK</a>
							<?php
							} ?>
                        </div>
                      </div>
					  <?php
	  				  } ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane show active fade" id="signup" role="tabpanel" aria-labelledby="sign-up-tab">
                <div class="inner clearfix">
                  <div class="checkout-block signup clearfix">
                    <h3><?php echo $LANG['New Account']; ?></h3>
                    <form class="clearfix" action="controllers/user/signup.php" method="post" id="signup_form">
                      <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo $LANG['FIRST NAME AND LAST NAME']; ?></label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo $LANG['EMAIL']; ?></label>
                        <input type="text" class="form-control" name="email" id="email" placeholder="" autocomplete="off">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1"><?php echo $LANG['PASSWORD']; ?></label>
                         <input type="password" class="form-control" name="password" id="password" placeholder="" autocomplete="off">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1"><?php echo $LANG['CONFIRM PASSWORD']; ?></label>
                        <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="" autocomplete="off">
                      </div>
                      <div class="clearfix"></div>
                      <p><?php echo $LANG['The information below will be used for shipping and payment only.']; ?></p>
                      <div class="clearfix"></div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Dirección 1</label>
                        <input type="text" name="address" id="address" placeholder="Dirección 1" class="form-control" autocomplete="off" />
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Dirección 2</label>
                        <input type="text" name="address2" id="address2" placeholder="Dirección 2" class="form-control" autocomplete="off" />
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-7">
                          <label for="exampleInputEmail1"><?php echo $LANG['CITY']; ?></label>
                          <input type="text" name="city" id="city" placeholder="Ciudad" class="form-control" autocomplete="off" />
                        </div>
                        <div class="form-group col-md-5">
                          <label for="exampleInputEmail1"><?php echo $LANG['STATE']; ?></label>
                          <input type="text" name="state" id="state" placeholder="Estado" class="form-control" autocomplete="off" />
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-5">
                          <label for="exampleInputEmail1"><?php echo $LANG['ZIP CODE']; ?></label>
                          <input type="text" name="postcode" id="postcode" placeholder="Código Postal" class="form-control" autocomplete="off" />
                        </div>
                        <div class="form-group col-md-7">
                          <label for="exampleInputEmail1"><?php echo $LANG['PHONE']; ?></label>
                          <input type="tel" id="cell_phone" name="cell_phone" class="form-control" placeholder="">
             			  <input type="hidden" name="phone" id="phone" />
                        </div>
                      </div>
					  
					  <?php
					  if($signup_form_captcha == '1') { ?>
					  <div class="form-row">
						<div class="form-group">
						  <div id="g_form_gcaptcha2"></div>
						  <input type="hidden" id="g_captcha_token2" name="g_captcha_token2" value=""/>
						</div>  
					  </div>
					  <?php
					  } ?>
					  
                      <div class="clearfix"></div>
                      <button type="submit" class="btn btn-primary btn-lg float-left"><?php echo $LANG['CREATE ACCOUNT']; ?></button>
					  <input type="hidden" name="submit_form" id="submit_form" />
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

<script src='https://www.google.com/recaptcha/api.js?onload=CaptchaCallback2&render=explicit'></script>

<script>
<?php
if($login_form_captcha == '1') { ?>
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
		$('#login_form').bootstrapValidator({
			fields: {
				username: {
					validators: {
						notEmpty: {
							message: 'Please enter email address'
						},
						emailAddress: {
							message: 'Please enter valid email address'
						}
					}
				},
				password: {
					validators: {
						notEmpty: {
							message: 'Please enter password.'
						}
					}
				}
			}
		}).on('success.form.bv', function(e) {
            $('#login_form').data('bootstrapValidator').resetForm();

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

<?php
if($signup_form_captcha == '1') { ?>
var CaptchaCallback2 = function() {
	if(jQuery('#g_form_gcaptcha2').length) {
		grecaptcha.render('g_form_gcaptcha2', {
			'sitekey' : '<?=$captcha_key?>',
			'callback' : onSubmitForm2,
		});
	}
};
	
var onSubmitForm2 = function(response) {
	if(response.length == 0) {
		jQuery("#g_captcha_token2").val('');
	} else {
		//$(".sbmt_button").removeAttr("disabled");
		jQuery("#g_captcha_token2").val('yes');
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
		$('#signup_form').bootstrapValidator({
			fields: {
				name: {
					validators: {
						stringLength: {
							min: 1,
						},
						notEmpty: {
							message: 'Please enter first name and last name'
						}
					}
				}/*,
				 last_name: {
					validators: {
						stringLength: {
							min: 1,
						},
						notEmpty: {
							message: 'Please enter last name'
						}
					}
				}*/,
				email: {
					validators: {
						notEmpty: {
							message: 'Please enter email address'
						},
						emailAddress: {
							message: 'Please enter valid email address'
						}
					}
				},
				cell_phone: {
					validators: {
						/*notEmpty: {
							message: 'Please enter phone number'
						},*/
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
				password: {
					validators: {
						notEmpty: {
							message: 'Please enter password.'
						},
						identical: {
							field: 'confirm_password',
							message: 'Password and confirm password not matched.'
						}
					}
				},
				confirm_password: {
					validators: {
						notEmpty: {
							message: 'Please enter confirm password.'
						},
						identical: {
							field: 'password',
							message: 'Password and confirm password not matched.'
						}
					}
				},
				address: {
					validators: {
						notEmpty: {
							message: 'Please enter address line 1.'
						}
					}
				}/*,
				address2: {
					validators: {
						notEmpty: {
							message: 'Please enter address line 2.'
						}
					}
				}*/,
				city: {
					validators: {
						notEmpty: {
							message: 'Please enter city.'
						}
					}
				},
				state: {
					validators: {
						notEmpty: {
							message: 'Please enter state.'
						}
					}
				},
				postcode: {
					validators: {
						notEmpty: {
							message: 'Please enter post code.'
						}
					}
				}/*,
				terms_conditions: {
					validators: {
						callback: {
							message: 'You must agree to terms & conditions to sign-up.',
							callback: function(value, validator, $field) {
								var terms = document.getElementById("terms_conditions").checked;
								if(terms==false) {
									return false;
								} else {
									return true;
								}
							}
						}
					}
				}*/
			}
		}).on('success.form.bv', function(e) {
            //$('#success_message').slideDown({ opacity: "show" }, "slow") // Do something ...
                $('#signup_form').data('bootstrapValidator').resetForm();

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