<?php
//Header section
include("include/header.php");

if(!$order_id || $basket_item_count_sum_data['basket_item_count']<=0) {
	setRedirect(SITE_URL.'revieworder');
	exit();
}

$is_social_based_ac = false;
if($user_data['leadsource']=="social") {
	$is_social_based_ac = true;
}
?>

<section id="item-steps">
	<div class="container">
    <?php
    $order_steps = 3;
    include("include/steps.php"); ?>
  </div>
</section>

<section>
<div class="container">
  
  <?php /*?><div class="row">
	<div class="col-md-12">
	  <div class="step-head head">
		<div class="h2"><strong>Checkout</strong></div>
	  </div>
	</div>
  </div><?php */?>
  
  <div class="row">
	<div class="col-md-7">
	  <form action="controllers/user/enterdetails.php" method="post" id="signup_form" class="signup_form">
      <div class="block">
        <div role="form" class="form-checkout first">
          <div class="form-box clearfix">
            <legend>New Customer</legend>
            <div class="form-row clearfix">
              <div class="form-group col-md-6">
                <!-- <label for="firstname">First Name</label> -->
                <input type="text" name="first_name" id="first_name" placeholder="First Name" class="form-control" value="<?=$user_data['first_name']?>" />
              </div>
              <div class="form-group col-md-6">
                <!-- <label for="lastname">Last Name</label> -->
                <input type="text" name="last_name" id="last_name" placeholder="Last Name" class="form-control" value="<?=$user_data['last_name']?>" />
              </div>

            </div>
            <div class="form-row clearfix">
              <div class="form-group col-md-6">
                <!-- <label for="email">Email Address</label> -->
                <input type="email" name="email" id="email" placeholder="Email Address" class="form-control sp_email_adr"
                  value="<?=$user_data['email']?>" autocomplete="off" />
                <small class="help-block email_exist_msg" style="display:none;"></small>
              </div>
              <div class="form-group col-md-6">
                <!-- <label for="phone">Phone Number</label> -->
                <input type="tel" id="cell_phone" name="cell_phone" class="form-control" placeholder="">
                <input type="hidden" name="phone" id="phone" />
              </div>
            </div>
            <div class="form-row clearfix">
              <div class="form-group col-md-6">
                <!-- <label for="username" class="control-label">Password</label> -->
                <div class="clearfix">
                  <input type="password" class="form-control" name="password" id="password" placeholder="Password"
                    autocomplete="off">
                </div>
              </div>
              <?php
              if($is_social_based_ac!=1 && $user_data['password']=="") { ?>
              <div class="form-group col-md-6">
                <!-- <label for="password" class="control-label">Confirm Password</label> -->
                <div class="clearfix">
                  <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password"
                    autocomplete="off">
                </div>
              </div>
              <?php
              } ?>
            </div>

          </div>

        </div>
	    </div>
	<!--</div>
	<div class="col-md-6">-->
    <div class="block">
      <div role="form" class="form-checkout first">
        <div class="form-box white clearfix">
          <legend>Shipping Details</legend>
          <div class="form-row clearfix">
            <div class="form-group col-md-12">
              <!-- <label for="address-line1">Address Line1</label> -->
              <input type="text" name="address" id="address" placeholder="Address Line1" class="form-control" value="<?=$user_data['address']?>"
                autocomplete="off" />
            </div>
          </div>
          <div class="form-row  clearfix">
            <div class="form-group col-md-12">
              <!-- <label for="address-line2">Address Line2</label> -->
              <input type="text" name="address2" id="address2" placeholder="Address Line2" class="form-control" value="<?=$user_data['address2']?>"
                autocomplete="off" />
            </div>
          </div>
          <div class="form-row clearfix">
            <div class="form-group col-md-4">
              <!-- <label for="city">City</label> -->
              <input type="text" name="city" id="city" placeholder="City" class="form-control" value="<?=$user_data['city']?>"
                autocomplete="off" />
            </div>
            <div class="form-group col-md-4">
              <!-- <label for="state">State</label> -->
              <input type="text" name="state" id="state" placeholder="State" class="form-control" value="<?=$user_data['state']?>"
                autocomplete="off" />
            </div>
            <div class="form-group col-md-4">
              <!-- <label for="postcode">Post Code</label> -->
              <input type="text" name="postcode" id="postcode" placeholder="Post Code" class="form-control" value="<?=$user_data['postcode']?>"
                autocomplete="off" />
            </div>
          </div>
          
            <?php
            if($general_setting_data['terms_status']=='1' && $display_terms_array['ac_creation']=="ac_creation") { ?>
            <div class="form-row clearfix">
            <div class="form-group col-md-12">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="terms_conditions" id="terms_conditions">
                <label class="custom-control-label" for="terms_conditions"><span class="black">Yes, I have read and accept the</span> <a href="javascript:void(0)" class="help-icon"
                    data-toggle="modal" data-target="#PricePromiseHelp">Terms of Website Use.</a></label>
              </div>
            </div>
            </div>
            <?php
              } else {
                echo '<input type="hidden" name="terms_conditions" id="terms_conditions" checked="checked"/>';
              } ?>
            <div class="form-row clearfix">
            <div class="form-group col-md-12">
            <button type="submit" class="btn btn-primary">Contine</button>
            <input type="hidden" name="submit_form" id="submit_form" />
          </div>
          </div>
        </div>
      </div>
    </div>
    <!-- <div class="block">
      <div role="form" class="form-checkout">
        
      </div>
    </div> -->
	  </form>
	</div>
    <div class="col-md-5">
      <form action="controllers/user/login.php" method="post" id="login_form" class="base-form login_form">
        <div class="block">
          <div role="form" class="form-checkout first">
            <div class="form-box clearfix">
              <legend>Existing Customer</legend>
              <div class="form-row clearfix">
                <div class="form-group col-md-12">
                  <!-- <label for="firstName">Email *</label> -->
                  <input type="text" class="form-control" id="username" name="username" placeholder="Enter email address" autocomplete="off">
                </div>
              </div>
              <div class="form-row clearfix">
                <div class="form-group col-md-12">
                  <!-- <label for="lastName">Password *</label> -->
                  <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" autocomplete="off">
                </div>
              </div>
              <div class="form-row clearfix">
                <div class="col-md-12">
                  <button type="submit" class="btn btn-primary contne_button">Login</button>
                  <input type="hidden" name="submit_form" id="submit_form" />
                  <a class="btn" href="lost_password">Forgotten your password?</a>
                </div>
                <!-- <div class="col-md-6">
                </div> -->
              </div>
            </div>
          </div>
        </div>
        <!-- <div class="block">
          <div role="form" class="form-checkout">
            
          </div>
        </div> -->
      </form>
    </div>
  </div>

  <div class="modal fade HelpPopup" id="PricePromiseHelp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i></button>
		<div class="modal-content">
		  <div class="modal-body">
			<div class="popUpInner">
			  <h2>Terms & Conditions</h2>
			  <?=$general_setting_data['terms']?>
			</div>
		  </div>
		</div>
	  </div>
  </div>

  <?php
  //START for social login
  if($social_login=='1' && $user_id<=0) { ?>
	<script type="text/javascript" src="social/js/oauthpopup.js"></script>
	<script type="text/javascript">
	jQuery(document).ready(function($){
		//For Google
		$('a.login').oauthpopup({
			path: 'social/social.php?google',
			width:800,
			height:800,
		});
		$('a.google_logout').googlelogout({
			redirect_url:'<?php echo $base_url; ?>social/logout.php?google'
		});

		//For Facebook
		$('#facebook').oauthpopup({
			path: 'social/social.php?facebook',
			width:800,
			height:800,
		});
	});
	</script>

	<div class="row">
		<div class="col-md-12">
			<div class="head head-divider clarfix">
				<div class="h2">or Sign in Using</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="block social">
			<ul>
				<?php
				if($social_login_option=="g_f") { ?>
					<li class="facebook"><a id="facebook" href="javascript:void(0);"><i class="fa fa-facebook"></i>Facebook</a></li>
					<li class="google"><a class="login" href="javascript:void(0);"><i class="fa fa-google-plus"></i>Google</a></li>
				<?php
				} elseif($social_login_option=="g") { ?>
					<li class="google"><a class="login" href="javascript:void(0);"><i class="fa fa-google-plus"></i>Google</a></li>
				<?php
				} elseif($social_login_option=="f") { ?>
					<li class="facebook"><a id="facebook" href="javascript:void(0);"><i class="fa fa-facebook"></i>Facebook</a></li>
				<?php
				} ?>
			</ul>
			</div>
		</div>
	</div>
  <?php
  } //END for social login ?>
</div>
</section>

<script>
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

		$("#cell_phone").intlTelInput("setNumber", "<?=($user_data['phone']?'+'.$user_data['phone']:'')?>");

		// on keyup / change flag: reset
		telInput.on("keyup change", reset);
	});
})(jQuery);

(function( $ ) {
	$(function() {

		$('.sp_email_adr').on('input',function(e) {
		  	var email = $(this).val();
		    post_data = "email="+email+"&token=<?=md5(uniqid());?>";
			$.ajax({
				type: "POST",
				url:"ajax/check_email_exist.php",
				data:post_data,
				success:function(data) {
					if(data!="") {
						var resp_data = JSON.parse(data);
						if(resp_data.exist==true) {
							$(".contne_button").attr("disabled", "disabled");
							$(".email_exist_msg").html(resp_data.msg);
							$(".email_exist_msg").show();
						} else {
							$(".email_exist_msg").html("");
							$(".email_exist_msg").hide();
						}
					}
				}
			});
		});

		$('#signup_form').on('input',function(e) {
			var email_exist_msg = $(".email_exist_msg").html();
			if(email_exist_msg.trim()!="") {
				$(".contne_button").attr("disabled", "disabled");
				return false;
			}
		});

		$('#signup_form').bootstrapValidator({
			fields: {
				first_name: {
					validators: {
						stringLength: {
							min: 1,
						},
						notEmpty: {
							message: 'Please enter your first name'
						}
					}
				},
				 last_name: {
					validators: {
						stringLength: {
							min: 1,
						},
						notEmpty: {
							message: 'Please enter your last name'
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
							message: 'Please enter an email address'
						},
						emailAddress: {
							message: 'Please enter a valid email address'
						}
					}
				},
				password: {
					validators: {
						notEmpty: {
							message: 'Please enter your password'
						}
					}
				},
				confirm_password: {
					validators: {
						notEmpty: {
							message: 'Please enter your confirm password'
						},
						identical: {
							field: 'password',
							message: 'Both password fields don\'t match'
						}
					}
				},
				address: {
					validators: {
						notEmpty: {
							message: 'Please enter your address'
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
							message: 'Please enter city'
						}
					}
				},
				state: {
					validators: {
						notEmpty: {
							message: 'Please enter state'
						}
					}
				},
				postcode: {
					validators: {
						notEmpty: {
							message: 'Please enter post code'
						}
					}
				},
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
				}
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


(function( $ ) {
	$(function() {
		$('#login_form').bootstrapValidator({
			fields: {
				username: {
					validators: {
						notEmpty: {
							message: 'Please enter an email address'
						},
						emailAddress: {
							message: 'Please enter a valid email address'
						}
					}
				},
				password: {
					validators: {
						notEmpty: {
							message: 'Please enter your password'
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
if($map_key!="") { ?>
var placeSearch, autocomplete;
var componentForm = {
	premise: 'short_name',
	street_number: 'short_name',
	route: 'long_name',
	locality: 'long_name',
	administrative_area_level_1: 'long_name',
	country: 'long_name',
	postal_code: 'short_name'
};

function initAutocomplete() {
	
	var input = document.getElementById('address');
	var options = {
	  types: ['geocode'],
	  //componentRestrictions: {country: 'au'}
	};
	
	autocomplete = new google.maps.places.Autocomplete(input, options);
	autocomplete.addListener('place_changed', fillInAddress);
}

function fillInAddress() {
	// Get the place details from the autocomplete object.
	var place = autocomplete.getPlace();
	console.log("place:",place);
	for(var component in componentForm) {
		document.getElementById("address").value = '';
		document.getElementById("address").disabled = false;
		document.getElementById("city").value = '';
		document.getElementById("city").disabled = false;
		document.getElementById("state").value = '';
		document.getElementById("state").disabled = false;
		document.getElementById("postcode").value = '';
		document.getElementById("postcode").disabled = false;
	}

	// Get each component of the address from the place details
	// and fill the corresponding field on the form.
	var address_line = '';
	for(var i = 0; i < place.address_components.length; i++) {
		var addressType = place.address_components[i].types[0];
		if(componentForm[addressType]) {
			var val = place.address_components[i][componentForm[addressType]];
			if(addressType == "premise" || addressType == "street_number" || addressType == "route") {
				address_line += val+" ";
				document.getElementById("address").value = address_line.trim();
			} else if(addressType == "locality") {
				document.getElementById("city").value = val;
			} else if(addressType == "administrative_area_level_1") {
				document.getElementById("state").value = val;
			} else if(addressType == "postal_code") {
				document.getElementById("postcode").value = val;
			} else {
				//document.getElementById(addressType).value = val;
			}
		}
	}
}

// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
	if(navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function(position) {
			var geolocation = {
				lat: position.coords.latitude,
				lng: position.coords.longitude
			};
			var circle = new google.maps.Circle({
				center: geolocation,
				radius: position.coords.accuracy
			});
			autocomplete.setBounds(circle.getBounds());
		});
	}
}
<?php
} ?>
</script>
<?php
if($map_key!="") { ?>
<script src="https://maps.googleapis.com/maps/api/js?key=<?=$map_key?>&libraries=places&callback=initAutocomplete" async defer></script>
<?php
} ?>
