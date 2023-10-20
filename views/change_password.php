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
            <li><a href="profile">Profile</a></li>
            <li class="active"><a href="change-password">Change password</a></li>
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
            <li><a href="profile">Profile</a></li>
            <li class="active"><a href="change-password">Change password</a></li>
            <li><a href="controllers/logout.php">Logout</a></li>
          </ul>
        </div>
      </div> -->
      <div class="col-md-12">
        <div class="block content-block clearfix">
          <div class="head head-account">
            <div class="h3"><strong>Change Your Password</strong></div>
            <p>Enter your new password into the fields below.</p>
          </div>
          <form action="controllers/user/change_password.php" class="phone-sell-form" method="post" id="chg_psw_form">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <!-- <label>New Password:</label> -->
                  <input type="password" name="password" id="password" placeholder="New Password" required class="form-control" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <!-- <label>Confirm Password:</label> -->
                  <input type="password" name="password2" id="password2" placeholder="Confirm Password" required class="form-control " />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <button type="submit" class="btn btn-primary">Save your Password</button>
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
      $('#chg_psw_form').bootstrapValidator({
        fields: {
          password: {
            validators: {
              notEmpty: {
                message: 'Please enter your new password'
              },
              identical: {
                field: 'password2',
                message: 'Both password fields don\'t match'
              }
            }
          },
          password2: {
            validators: {
              notEmpty: {
                message: 'Please confirm your new password'
              },
              identical: {
                field: 'password',
                message: 'Both password fields don\'t match'
              }
            }
          }
        }
      }).on('success.form.bv', function (e) {
        $('#chg_psw_form').data('bootstrapValidator').resetForm();

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