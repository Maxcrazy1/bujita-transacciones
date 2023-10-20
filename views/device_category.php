<?php
$category_data = get_category_data($category_id);
$cat_id = $category_id;

$meta_title = $category_data['title'];
$meta_desc = '';
$meta_keywords = '';

$main_title = $category_data['title'];
$main_sub_title = '';
$description = $category_data['description'];
$main_img = '';
if($category_data['image']) {
	$main_img = '<img class="image" src="'.SITE_URL.'images/categories/'.$category_data['image'].'" alt="'.$main_title.'">';
}

//Header section
include("include/header.php");

//Fetching data from model
require_once('models/mobile.php'); ?>

  <section class="showcase">
    <div class="container">
      <div class="row">
        <div class="col-md-8">
          <div class="text">
            <div class="h1 tpl_color"><?=$main_title?></div>
            <div class="h2"><?=$main_sub_title?></div>
            <a href="<?=SITE_URL?>#request_quote" class="btn btn-default"><?php echo $LANG['Request a Quote']; ?></a>
          </div>
        </div>
        <div class="col-md-4">
        	<?=$main_img?>
        </div>
      </div>
    </div>
  </section>

  <section class="items-phone">
    <div class="container">
      <div class="row">
        <div class="head text-center">
          <div class="h3"><?php echo $LANG['Find ']; ?><strong><?php echo $LANG['your model']; ?></strong></div>
          <p><?php echo $LANG["Please select Gigabyte (GB) size of your model to see what it's worth..."]; ?></p>
        </div>
      </div>
      <div class="row">
	  	<?php
		//Get data from models/mobile.php, get_model_data_list function
		$model_data_list = get_model_data_list($device_id, $devices_id, $cat_id);
		$model_num_of_rows = count($model_data_list);
		if($model_num_of_rows>0) {
			foreach($model_data_list as $model_list) {
				$storage_list = get_models_storage_data($model_list['id']); ?>
				<div class="col-md-4">
				  <div class="item clearfix">
					<div class="container-fluid">
					  <div class="row">
						<div class="col-md-7">
						  <div class="h4"><strong><?=$model_list['device_title']?></strong></div>
						  <p><?=$model_list['title']?></p>
						  <div class="item-capacity">
							<ul>
							  <?php
							  $sl = 0;
							  foreach($storage_list as $storage) {
								 $sl = $sl+1;
								 echo '<a href="'.SITE_URL.$model_list['device_sef_url'].'/'.createSlug($model_list['title']).'/'.$model_list['id'].'/'.$storage['storage_size'].'"><li class="btn">'.$storage['storage_size'].$storage['storage_size_postfix'].'</li></a>';
							  } ?>
							</ul>
						  </div>
						</div>
						
						<?php
						if($model_list['model_img']) {
							$md_img_path = SITE_URL.'libraries/phpthumb.php?imglocation='.SITE_URL.'images/mobile/'.$model_list['model_img'].'&h=144'; ?>
							<div class="col-md-5">
							  <div class="item-image">
								<img src="<?=$md_img_path?>" alt="<?=$model_list['title']?>">
							  </div>
							</div>
						<?php
						} ?>
					  </div>
					</div>
				  </div>
				</div>
			<?php
			}

			//START missing product section & quote request email...
			if($general_setting_data['missing_product_section']=='1') { ?>
				<div class="col-md-4">
				  <div class="item item-missing clearfix" data-toggle="modal" data-target="#MissingProduct">
					<div class="container-fluid">
					  <div class="row">
						<div class="col-md-5">
						  <div class="item-image">
							<img src="<?=SITE_URL?>images/iphone.png" alt="iphone">
						  </div>
						  <div class="text-overlap"><strong><?php echo $LANG['I dont see my Device']; ?></strong></div>
						  <div class="missing-status"><strong><?php echo $LANG['Missing Product']; ?></strong></div>
						</div>
					  </div>
					</div>
				  </div>
				</div>

				<div class="editAddress-modal modal fade HelpPopup" id="MissingProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				  <div class="modal-dialog" role="document">
					<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i></button>
					<div class="modal-content">
						<div class="modal-body">
							<form method="post" action="<?=SITE_URL?>controllers/mobile.php" id="req_quote_form">
								<h2><?php echo $LANG['Can’t Find Your Item?']; ?></h2>
								<p><?php echo $LANG['If you want to find out how much your item is worth, please fill out the form below and we will reply to your email within 24 hours. Remember, the more information you include about the item(s) you are trying to sell, the easier it is for us to make you an offer. Please fill out a good contact number and email address in case we need to ask you a few more questions.']; ?></p>
								<div class="borderbox lightpink">
									<h3 class="highlightHeading"><?php echo $LANG['Quote Request']; ?></h3>
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
									<div class="form-group">
										<button type="submit" class="btn btn-general"><?php echo $LANG['Submit']; ?></button>
										<input type="hidden" name="missing_product" id="missing_product" />
									</div>
								</div>
							</form>
						</div>
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
			} 
		} //END missing product section & quote request email...
		else { ?>
			<div class="text-center">
			  <div class="h3"><?php echo $LANG['Model not available']; ?></div>
			</div>
		<?php
		} ?>
      </div>
      <div class="row"></div>
    </div>
  </section>
  
  <?php
  if($description) { ?>
	  <section class="content">
	    <div class="container">
	      	<?=$description?>
	    </div>
	  </section>
  <?php
  } ?>
