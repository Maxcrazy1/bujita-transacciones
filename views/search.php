<?php
//Header section
include("include/header.php");

$search_by = $post['search'];

//Fetching data from model
require_once('models/search/search.php');

//Get model data list from models/search/search.php, function get_model_data_list
$model_data_list = get_model_data_list($search_by);
if(count($model_data_list)>0 && $search_by) {
?>
  <section id="tell_us_phone">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="block text-center tell-us-phone clearfix">
            <h1 class="h1 border-line"><?php echo $LANG['Search Results']; ?></h1>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="block brands pt-0 mt-0 clearfix">
			<ul class="box-styled clearfix">
			<?php
			foreach($model_data_list as $model_list) { ?>
			  <li>
				<a href="<?=SITE_URL.$model_list['sef_url'].'/'.createSlug($model_list['title']).'/'.$model_list['id']?>">
					<?php
					if($model_list['model_img']) {
						$md_img_path = SITE_URL.'libraries/phpthumb.php?imglocation='.SITE_URL.'images/mobile/'.$model_list['model_img'].'&h=150';
						echo '<img src="'.$md_img_path.'" alt="'.$model_list['title'].'">';
					} ?>
				  <h6 class="h6"><?=$model_list['title']?></h6>
				  <!--<p class="price">CASH IN UP TO $00</p>-->
				</a>
			  </li>
			<?php
			}
			
			//START missing product section & quote request email...
			if($general_setting_data['missing_product_section']=='1') { ?>
			<li>
				<a href="javascript:void(0);" data-toggle="modal" data-target="#MissingProduct">
				  <img src="<?=SITE_URL.'libraries/phpthumb.php?imglocation='.SITE_URL.'images/iphone.png&h=150'?>" alt="Missing Product">
				  <h6 class="h6">I dont see my Device</h6>
				  <p class="price">Missing Product</p>
				</a>
			</li>
				
			<div class="editAddress-modal modal fade" id="MissingProduct" tabindex="-1" role="dialog" aria-labelledby="locationModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
				  <div class="modal-content">
					<div class="modal-header">
					  <h5 class="modal-title" id="locationModalLabel">Quote Request</h5>
					  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					  </button>
					</div>
					<form method="post" action="<?=SITE_URL?>controllers/mobile.php" id="req_quote_form">
						<div class="modal-body">
							<h2>Can’t Find Your Item?</h2>
							<p>If you want to find out how much your item is worth, please fill out the form below and we will reply to your email within 24 hours. Remember, the more information you include about the item(s) you are trying to sell, the easier it is for us to make you an offer. Please fill out a good contact number and email address in case we need to ask you a few more questions.</p>
							<div class="form-group">
								<input type="text" name="name" id="name" placeholder="Enter name" class="form-control" />
							</div>
							<div class="form-group">
								<input type="tel" id="cell_phone" name="cell_phone" class="form-control" placeholder="">
								<input type="hidden" name="phone" id="phone" />
							</div>
							<div class="form-group">
								<input type="text" name="email" id="email" placeholder="Enter email" class="form-control" />
							</div>
							<div class="form-group">
								<input type="text" name="item_name" id="item_name" placeholder="Enter name of your item" class="form-control" />
							</div>
							<div class="form-group">
								<textarea name="message" id="message" placeholder="Enter message" class="form-control"></textarea>
							</div>
							<?php
							if($missing_product_form_captcha == '1') { ?>
								<div class="form-group">
									<div id="g_form_gcaptcha"></div>
									<input type="hidden" id="g_captcha_token" name="g_captcha_token" value=""/>
								</div>
							<?php
							} ?>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary">Submit</button>
							<input type="hidden" name="missing_product" id="missing_product" />
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
					</form>
				  </div>
				</div>
			</div>

			<script>
			<?php
			if($missing_product_form_captcha == '1') { ?>
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
					  utilsScript: "<?=SITE_URL?>js/intlTelInput-utils.js" //just for formatting/placeholders etc
					});
	
					// on keyup / change flag: reset
					telInput.on("keyup change", reset);
				});
			})(jQuery);
	
			(function( $ ) {
				$(function() {
					$('#req_quote_form').bootstrapValidator({
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
							},
							item_name: {
								validators: {
									notEmpty: {
										message: 'Please enter item name'
									}
								}
							},
							message: {
								validators: {
									notEmpty: {
										message: 'Please enter your message'
									}
								}
							}
						}
					}).on('success.form.bv', function(e) {
						$('#req_quote_form').data('bootstrapValidator').resetForm();
	
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
			<?php
			} //END missing product section & quote request email... ?>
			</ul>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php
} else { ?>
 <section id="content">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-7">
          <div class="block content mt-5 clearfix">
            <div class="block cart-page clearfix">
              <h1 class="text-center"><?php echo $LANG['Search Results']; ?></h1>
              <div class="block head cart-saerch-page mt-0 pt-0 text-center clearfix">
                <div class="h2 mb-4">No matching handsets/devices found.</div>
                <form class="form-inline" action="<?=SITE_URL?>search" method="post">
                  <div class="form-group">
                    <input type="text" class="form-control srch_list_of_model" name="search" id="staticEmail2" placeholder="Search your device here by device name" required>
                  </div>
                  <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                </form>
                <div class="h2 text-center pt-3 pb-3"><?php echo $LANG['OR']; ?></div>
                <a href="<?=SITE_URL?>device-type-or-brand" class="btn btn-primary btn-lg pl-5 pr-5"><?php echo $LANG['CHOOSE YOUR DEVICE TYPE OR BRAND']; ?></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php
} ?>
