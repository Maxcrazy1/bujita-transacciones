<?php
//Header section
include("include/header.php");

//If direct access then it will redirect to home page
if($user_id<=0) {
	setRedirect(SITE_URL);
	exit();
} ?>
<section id="secondary-navigation">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="block secondary-navigation clearfix">
          <ul>
            <li><a href="account">My Orders</a></li>
            <li class="active"><a href="profile">Profile</a></li>
            <li><a href="change-password">Change password</a></li>
            <li class="float-right"><a class="btn btn-danger" href="controllers/logout.php">Logout</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

<section>
  <div class="container">
    <div class="row">
      <!-- <div class="col-md-3">
        <div class="block left-navigation clearfix">
          <ul class="nav nav-pills nav-stacked">
            <li><a href="account">My Orders</a></li>
            <li class="active"><a href="profile">Profile</a></li>
            <li><a href="change-password">Change password</a></li>
            <li><a href="controllers/logout.php">Logout</a></li>
          </ul>
        </div>
      </div> -->
      <div class="col-md-12">
        <div class="block content-block clearfix">
          <div class="head head-account">
            <div class="h3"><strong>Edit Your Details</strong></div>
            <p>It is important to ensure that we have your correct address and contact details on the system. Your
              current details are displayed below. If necessary, make any changes and click the <b>'Update'</b> button.</p>
            <p>Required fields are marked with *.</p>
          </div>
          <form action="controllers/user/profile.php" class="phone-sell-form" method="post" id="profile_form" enctype="multipart/form-data">

            <?php
			if($user_data['image']) {
				$md_img_path = SITE_URL.'libraries/phpthumb.php?imglocation='.SITE_URL.'images/avatar/'.$user_data['image'].'&h=150'; ?>
            <div class="row">
              <div class="col-md-12">
                <div class="profile-image clearfix">
                  <div class="profile-image-inner clearfix">
                    <img src="<?=$md_img_path?>" alt="">
                    <br><a href="controllers/user/profile.php?remove_av_id=<?=$user_data['id']?>">Remove</a>
                  </div>
                </div>
              </div>
            </div>
            <?php
        	} ?>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                <!-- <div class="custom-file">
                  <input type="file" class="custom-file-input" id="customFile">
                  <label class="custom-file-label" for="customFile">Choose file</label>
                </div> -->
                  <div class="custom-file">
                    <!-- <button class="btn"><i class="fa fa-user-circle-o"></i>Upload Avatar</button> -->
                    <input type="file" name="image" id="image" class="custom-file-input" />
                    <label class="custom-file-label" for="customFile">Choose file</label>
                  </div>
                  <input type="hidden" name="old_image" id="old_image" value="<?=$user_data['image']?>" />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <!-- <label>First Name</label> -->
                  <input type="text" name="first_name" id="first_name" placeholder="First Name" value="<?=$user_data['first_name']?>"
                    required class="form-control" autocomplete="off" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <!-- <label>Last Name</label> -->
                  <input type="text" name="last_name" id="last_name" placeholder="Last Name" value="<?=$user_data['last_name']?>"
                    required class="form-control" autocomplete="off" />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <!-- <label>Email</label> -->
                  <input type="email" name="email" id="email" placeholder="Your email address" value="<?=$user_data['email']?>"
                    required class="form-control" autocomplete="off" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <!-- <label>Phone</label> -->
                  <input type="tel" id="cell_phone" name="cell_phone" class="form-control">
                  <input type="hidden" name="phone" id="phone" />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="h3 mt-4"><strong>Shipping Address</strong></div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <!-- <label>Address</label> -->
                  <input type="text" name="address" id="address" placeholder="Address Line1" value="<?=$user_data['address']?>"
                    required class="form-control" autocomplete="off" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <!-- <label>Address2</label> -->
                  <input type="text" name="address2" id="address2" placeholder="Address Line2" value="<?=$user_data['address2']?>"
                    class="form-control" autocomplete="off" />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <!-- <label>City</label> -->
                  <input type="text" name="city" id="city" placeholder="City" value="<?=$user_data['city']?>" required
                    class="form-control" />
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <!-- <label>State</label> -->
                  <input type="text" name="state" id="state" placeholder="State" value="<?=$user_data['state']?>"
                    required class="form-control" />
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <!-- <label>Postcode</label> -->
                  <input type="text" name="postcode" id="postcode" placeholder="Post code" value="<?=$user_data['postcode']?>"
                    required class="form-control" autocomplete="off" />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <button type="submit" class="btn btn-primary">Update</button>
                  <input type="hidden" name="submit_form" id="submit_form" />
                </div>
              </div>
            </div>
            <input type="hidden" name="id" id="id" value="<?=$user_data['id']?>" />
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  (function ($) {
    $(function () {
      var telInput = $("#cell_phone");
      telInput.intlTelInput({
        initialCountry: "auto",
        geoIpLookup: function (callback) {
          $.get('https://ipinfo.io', function () {}, "jsonp").always(function (resp) {
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

  (function ($) {
    $(function () {
      $('#profile_form').bootstrapValidator({
        fields: {
          first_name: {
            validators: {
              stringLength: {
                min: 1,
              },
              notEmpty: {
                message: 'Please enter first name'
              }
            }
          },
          last_name: {
            validators: {
              stringLength: {
                min: 1,
              },
              notEmpty: {
                message: 'Please enter last name'
              }
            }
          },
          cell_phone: {
            validators: {
              callback: {
                message: 'Please enter valid phone number',
                callback: function (value, validator, $field) {
                  var telInput = $("#cell_phone");
                  $("#phone").val(telInput.intlTelInput("getNumber"));
                  if (!telInput.intlTelInput("isValidNumber")) {
                    return false;
                  } else if (telInput.intlTelInput("isValidNumber")) {
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
          },
          password: {
            validators: {
              notEmpty: {
                message: 'Please enter password.'
              }
            }
          },
          address: {
            validators: {
              notEmpty: {
                message: 'Please enter address.'
              }
            }
          }
          /*,
          				address2: {
          					validators: {
          						notEmpty: {
          							message: 'Please enter address2.'
          						}
          					}
          				}*/
          ,
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
          },
          terms_conditions: {
            validators: {
              callback: {
                message: 'You must agree to terms & conditions to sign-up.',
                callback: function (value, validator, $field) {
                  var terms = document.getElementById("terms_conditions").checked;
                  if (terms == false) {
                    return false;
                  } else {
                    return true;
                  }
                }
              }
            }
          }
        }
      }).on('success.form.bv', function (e) {
        $('#profile_form').data('bootstrapValidator').resetForm();

        // Prevent form submission
        e.preventDefault();

        // Get the form instance
        var $form = $(e.target);

        // Get the BootstrapValidator instance
        var bv = $form.data('bootstrapValidator');

        // Use Ajax to submit form data
        $.post($form.attr('action'), $form.serialize(), function (result) {
          console.log(result);
        }, 'json');
      });
    });
  })(jQuery);
</script>