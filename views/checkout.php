<?php
//Header section
include("include/header.php");

//Fetching data from model
require_once('models/mobile.php');

//Get order price based on orderID, path of this function (get_order_price) admin/include/functions.php
$sum_of_orders=get_order_price($order_id);

//$0 means device is worth nothing

if($sum_of_orders <= 0 || !$order_id || $basket_item_count_sum_data['basket_item_count']<=0) {
	setRedirect(SITE_URL.'revieworder');
	exit();
}

//Get order item list based on orderID, path of this function (get_order_item_list) admin/include/functions.php
$order_item_list = get_order_item_list($order_id);
$order_num_of_rows = count($order_item_list);

//Get order batch data, path of this function (get_order_data) admin/include/functions.php
$order_data = get_order_data($order_id);

$is_social_based_ac = false;
if($user_data['leadsource']=="social") {
	$is_social_based_ac = true;
}

$starbuck_location_list = get_starbuck_location_list();
?>

  <section id="content">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="block checkout-page clearfix">
            <div class="row">
              <div class="col-md-12">
                <div class="block head border-line mt-0 pt-0 clearfix">
                  <h1 class="h1 text-center"><?php echo $LANG['CHECKOUT']; ?></h1>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-8">
                <div class="block content p-0 clearfix">
                  <div class="accordion" id="checkout">
				    <?php
			  		if($user_id<=0) { ?>
                    <div class="card">
                      <div class="card-header" id="account">
                        <h2 class="mb-0">
                          <button class="btn btn-link" type="button" data-toggle="" data-target="#accountTab"
                            aria-expanded="true" aria-controls="accountTab">
                            1. <?php echo $LANG['ACCOUNT']; ?> <span class="checkout-step-data account_step_data"></span> <span class="collapseone_chkd"></span>
                          </button>
                        </h2>
                      </div>

                      <div id="accountTab" class="collapse show" aria-labelledby="account" data-parent="#checkout">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="checkout-block clearfix">
                                <h3><?php echo $LANG['COUNTINUE AS GUEST']; ?></h3>
                                <form id="create_account_form">
                                  <div class="form-group">
                                    <label for="signup_email"><?php echo $LANG['EMAIL']; ?></label>
                                    <input type="email" class="form-control" name="email" id="signup_email" placeholder="" value="<?=$user_data['email']?>" autocomplete="off" required>
									<small class="help-block email_exist_msg" style="display:none;"></small>
                                  </div>
                                  <button type="submit" class="btn btn-primary" id="register"><?php echo $LANG['COUNTINUE AS GUEST']; ?></button>
                                </form>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="checkout-block clearfix">
                                <h3><?php echo $LANG['CUSTOMER LOGIN']; ?></h3>
								<form action="<?=SITE_URL?>controllers/user/login.php" method="post" class="clearfix" id="login_form">
                                  <div class="form-group">
                                    <label for="username"><?php echo $LANG['EMAIL']; ?></label>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="" autocomplete="off">
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
                                  <a href="<?=SITE_URL?>signup" class="btn btn-primary btn-create-account float-right"><?php echo $LANG['CREATE AN ACCOUNT']; ?></a>
                                </form>
                                <a href="<?=SITE_URL?>lost_password" class="link-forgot-pass"><?php echo $LANG['FORGOT YOUR PASSWORD?']; ?></a>
                    
								<?php
								if($social_login=='1') { ?>
								  <div class="third_party_login clearfix">
                                    <h3><?php echo $LANG['login with']; ?></h3>
                                    <div class="third_parties clearfix">
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
											$('#facebook').oauthpopup({
												path: 'social/social.php?facebook',
												width:1000,
												height:1000,
											});
										});
										</script>
									
										<?php
										if($social_login_option=="g_f") { ?>
										  <a id="facebook" href="javascript:void(0);"><i class="fab fa-facebook-square"></i> FACEBOOK</a>
										  <a class="google" href="javascript:void(0);"><i class="fab fa-google-plus-square"></i>Google</a>
										<?php
										} elseif($social_login_option=="g") { ?>
										  <a class="google" href="javascript:void(0);"><i class="fab fa-google-plus-square"></i>Google</a>
										<?php
										} elseif($social_login_option=="f") { ?>
										  <a id="facebook" href="javascript:void(0);"><i class="fab fa-facebook-square"></i> FACEBOOK</a>
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
                      </div>
                    </div>
					<?php
					} ?>

				<form <?php if ($_SESSION['user_id'] > 0) { ?>class="logged-in" <?php } ?> action="<?=SITE_URL?>controllers/checkout.php" method="post" id="signup_form" enctype="multipart/form-data">
                    <div class="card">
                      <div class="card-header" id="paymentOption">
                        <h2 class="mb-0">
                          <button class="btn btn-link collapsed" type="button" data-toggle="" data-target="#payment" aria-expanded="false" aria-controls="payment">
                            <?=($user_id>0?1:2)?>. <?php echo $LANG['PAYMENT OPTIONS']; ?> <span class="checkout-step-data payment_step_data"></span> <span class="collapsetwo_chkd"></span>
                          </button>
                        </h2>
                      </div>
                      <div id="payment" class="collapse <?=($user_id>0?'show':'')?>" aria-labelledby="paymentOption" data-parent="#checkout">
                        <div class="card-body">
                          <div class="checkout-block clearfix payment_info_tab">
                            <h3><?php echo $LANG['HOW WOULD YOU LIKE TO BE PAID?']; ?> </h3>
                            <div class="payment-select clearfix">
							  <?php
						  	  if(!empty($choosed_payment_option['check']) && $choosed_payment_option['check']=="check") { ?>
                              <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="payment_method_check" name="payment_method" class="custom-control-input" <?php if($default_payment_option=="check"){echo 'checked="checked"';}?> value="check">
                                <label class="custom-control-label" for="payment_method_check"><?php echo $LANG['Check']; ?></label>
                              </div>
							  <?php
							  }
							  if(!empty($choosed_payment_option['paypal']) && $choosed_payment_option['paypal']=="paypal") { ?>
                              <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="payment_method_paypal" name="payment_method" class="custom-control-input" <?php if($default_payment_option=="paypal"){echo 'checked="checked"';}?> value="paypal">
                                <label class="custom-control-label" for="payment_method_paypal">PayPal</label>
                              </div>
							  <?php
							  }
							  if(!empty($choosed_payment_option['zelle']) && $choosed_payment_option['zelle']=="zelle") { ?>
                              <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="payment_method_zelle" name="payment_method" class="custom-control-input" <?php if($default_payment_option=="zelle"){echo 'checked="checked"';}?> value="zelle">
                                <label class="custom-control-label" for="payment_method_zelle">Zelle</label>
                              </div>
							  <?php
							  }
							  if($choosed_payment_option['cash']=="cash") { ?>
                              <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="payment_method_cash" name="payment_method" class="custom-control-input" <?php if($default_payment_option=="cash"){echo 'checked="checked"';}?> value="cash">
                                <label class="custom-control-label double-line" for="payment_method_cash"><?php echo $LANG['Cash']; ?><span><?php echo $LANG['Meet in Person']; ?></span></label>
                              </div>
							  <?php
							  } ?>
                            </div>
                            <div id="paypal-form" class="payment-form clearfix">
                                <legend><?php echo $LANG["We'll credit your PayPal Email Address once your item(s) have been verified by our staff. Please note that PayPal charges a fee ($0.3 + 2.9%) to receive funds using their service."]; ?></legend>
                                <div class="form-group">
								  <input type="text" placeholder="PayPal Email Address" id="paypal_address"  name="paypal_address" class="form-control" autocomplete="off">
								  <small id="paypal_address_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
                                </div>
                            </div>
                            <div id="cash-form" class="payment-form clearfix">
                                <legend><?php echo $LANG['The sale will be made in affiliated establishments']; ?></legend>
                                <div class="form-group">
                                  <input type="email" class="form-control" id="cash_name" name="cash_name" placeholder="Name">
								  <small id="cash_name_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
                                </div>
                                <div class="form-group">
                                  <input type="tel" class="form-control" id="cash_phone" name="cash_phone" placeholder="Mobile Phone number">
								  <input type="hidden" name="f_cash_phone" id="f_cash_phone" />
								  <small id="cash_phone_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
                                </div>
                                <div class="form-group">
                                  <select class="custom-select" name="cash_location" id="cash_location">
                                    <option value="" selected><?php echo 'Selecciona una ubicación'; ?></option>
									<?php
									if(!empty($starbuck_location_list)) {
										foreach($starbuck_location_list as $starbuck_location_data) { ?>
                                    		<option value="<?=$starbuck_location_data['id']?>"><?=$starbuck_location_data['name']?></option>
										<?php
										}
									} ?>
                                  </select>
								  <small id="cash_location_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
								  <br /><a href="javascript:void(0);" data-toggle="modal" data-target="#locationModal"><?php echo $LANG['SEE LOCATIONS']; ?></a>
                                </div>
                            </div>
                            <div id="zelle-form" class="payment-form clearfix">
                                <legend><?php echo $LANG["We'll credit your Zelle® account once your device(s) has/have been received and verified."]; ?></legend>
                                <div class="form-group">
                                  <input type="email" class="form-control" id="zelle_email" name="zelle_email" placeholder="Zelle® Email Address">
								  <small id="zelle_email_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
                                </div>
                            </div>
                            <div id="check-form" class="payment-form clearfix">
                                <legend><?php echo $LANG["We'll mail you a check once your device(s) has/have been received and verified."];?></legend>
                            </div>
                          </div>
                          <button type="button" class="btn step2next btn-primary float-right mt-3 mb-3"><?php echo $LANG['NEXT']; ?></button>
                        </div>
                      </div>
                    </div>
					
                    <div class="card">
                      <div class="card-header" id="shippingOption">
                        <h2 class="mb-0">
                          <button class="btn btn-link collapsed" type="button" data-toggle=""
                            data-target="#shipping" aria-expanded="false" aria-controls="shipping">
                            <?=($user_id>0?2:3)?>. <?php echo $LANG['SHIPPING']; ?> <span class="collapsethree_chkd"></span>
                          </button>
                        </h2>
                      </div>
                      <div id="shipping" class="collapse" aria-labelledby="shippingOption" data-parent="#checkout">
                        <div class="card-body">
                          <div class="checkout-block mb-5 clearfix address_details_tab">
                              <h3><?php echo $LANG['YOUR ADDRESS']; ?></h3>
                              <div class="form-row">
                                <div class="form-group col-md-6">
                                  <label for="name"><?php echo $LANG['FIRST NAME AND LAST NAME']; ?></label>
                                  <input type="text" name="name" id="name" placeholder="" class="form-control" value="<?=$user_data['name']?>"/>
							  	  <small id="name_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
                                </div>
                                <div class="form-group col-md-6">
                                  <label for="cell_phone"><?php  echo $LANG['PHONE']; ?></label>
                                  <input type="tel" id="cell_phone" name="cell_phone" class="form-control" placeholder="">
							  	  <input type="hidden" name="phone" id="phone" />
							      <small id="cell_phone_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
                                </div>
                              </div>
                              <div class="form-row">
                                <div class="form-group col-md-6">
                                  <label for="address"><?php  echo $LANG['ADDRESS 1']; ?></label>
                                  <input type="text" name="address" id="address" placeholder="" class="form-control" value="<?=$user_data['address']?>" autocomplete="off"/>
							  	  <small id="address_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
                                </div>
                                <div class="form-group col-md-6">
                                  <label for="address2"><?php  echo $LANG['ADDRESS 2']; ?></label>
                                  <input type="text" name="address2" id="address2" placeholder="" class="form-control" value="<?=$user_data['address2']?>" autocomplete="off"/>
							      <small id="address2_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
                                </div>
                              </div>
                              <div class="form-row">
                                <div class="form-group col-md-6">
                                  <label for="city"><?php  echo $LANG['CITY']; ?></label>
                                  <input type="text" name="city" id="city" placeholder="" class="form-control" value="<?=$user_data['city']?>" autocomplete="off"/>
							      <small id="city_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
                                </div>
                                <div class="form-group col-md-6">
                                  <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="state"><?php  echo $LANG['STATE']; ?></label>
                                        <input type="text" name="state" id="state" placeholder="" class="form-control" value="<?=$user_data['state']?>" autocomplete="off"/>
							 			<small id="state_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="postcode"><?php  echo $LANG['ZIP CODE']; ?></label>
                                        <input type="text" name="postcode" id="postcode" placeholder="" class="form-control" value="<?=$user_data['postcode']?>" autocomplete="off"/>
							  			<small id="postcode_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
                                    </div>
                                  </div>
                                </div>
                              </div>
                          </div>
                          <div class="checkout-block get-paid-faster mb-5 clearfix">
                            <h3><?php  echo $LANG['GET PAID FASTER']; ?><span><?php  echo $LANG['OPTIONAL']; ?></span></h3>
                            <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" id="express_service" name="express_service" value="1">
                              <label class="custom-control-label" for="express_service"><?php  echo $LANG['Express Service']; ?> (<strong><?=amount_fomat($sum_of_orders*2.5/100)?></strong>)</label>
                            </div>
                            <h4><strong><?php  echo $LANG['Guaranteed 24 Hours Processing']; ?></strong></h4>
                            <p><small><?php  echo $LANG['This amount will be deduced deducted form the final offer amount.']; ?></small></p>
                          </div>
                          <div class="checkout-block shpping-insureance clearfix">
                            <h3><?php  echo $LANG['SHIPPING INSURANCE']; ?></h3>
                            <p><?php echo $LANG["All packages are insured up to $50 for free. If you'd like, you can purchase additional shipping insurance to cover the full value of your offer for just"]; ?> <strong><?=amount_fomat($sum_of_orders*1.5/100)?>.</strong><br />
							<small><?php echo $LANG['This amount will be deducted from the final offer amount.']; ?></small></p>
							<div class="wrap-border clearfix">
                              <div class="custom-control custom-radio">
                                <input type="radio" id="shipping_insurance" name="shipping_insurance" class="custom-control-input" value="1">
                                <label class="custom-control-label" for="shipping_insurance"><?php echo $LANG['Yes, Add Insurance']; ?></label>
                              </div>
                              <div class="custom-control custom-radio">
                                <input type="radio" id="shipping_insurance_no" name="shipping_insurance" class="custom-control-input" value="0">
                                <label class="custom-control-label" for="shipping_insurance_no"><?php echo $LANG['No, Thanks'];?></label>
                              </div>
                            </div>
							<small id="shipping_insurance_msg" class="help-block m_validations_showhide" style="display:none;"></small>
                            <!--<div class="wrap-border clearfix">
                              <div class="custom-control custom-checkbox">
                                <input type="checkbox" id="shipping_insurance" name="shipping_insurance" class="custom-control-input" value="1">
                                <label class="custom-control-label" for="shipping_insurance">Yes, Add Insurance</label>
                              </div>
                            </div>-->
                          </div>
                          <button type="button" class="btn btn-primary float-right mt-3 mb-3 step3next"><?php echo $LANG['NEXT']; ?></button>
                        </div>
                      </div>
                    </div>
					
                    <div class="card">
                      <div class="card-header" id="termsOptionSelect">
                        <h2 class="mb-0">
                          <button class="btn btn-link collapsed" type="button" data-toggle=""
                            data-target="#termsOption" aria-expanded="false" aria-controls="termsOption">
                            <?=($user_id>0?3:4)?>. <?php echo $LANG['ADDITIONAL OPTIONS & TERMS']; ?>
                          </button>
                        </h2>
                      </div>
                      <div id="termsOption" class="collapse" aria-labelledby="termsOptionSelect"
                        data-parent="#checkout">
                        <div class="card-body">
                          
                          <div class="checkout-block terms_condition clearfix">
                            <h3><?php echo $LANG['TERMS & CONDITION']; ?></h3>
                            <p><?php echo $LANG['Please carefully read our']; ?> <a href="#"><?php echo $LANG['terms and conditions']; ?></a> <?php echo $LANG['before placing your offer.']; ?></p>
                            <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="terms_and_conditions" id="terms_and_conditions" value="1">
                              <label class="custom-control-label" for="terms_and_conditions"><?php echo $LANG['I accept the terms and conditions']; ?></label>
							  <small id="terms_and_conditions_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
							  
                            </div>
                            <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="occasional_special_offers" id="occasional_special_offers" value="1">
                              <label class="custom-control-label" for="occasional_special_offers"><?php echo $LANG['Send me occasional special offers']; ?></label>
                            </div>
                            <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="important_sms_notifications" id="important_sms_notifications" value="1">
                              <label class="custom-control-label" for="important_sms_notifications"><?php echo $LANG['Send me important SMS notifications to']; ?> <span id="sms_notif_phone"><a href="tel:"></a></span></label>
                            </div>
                          </div>
                          <button type="button" class="btn btn-primary float-right mt-3 mb-3 get_paid"><?php echo $LANG['CHECKOUT']; ?></button>
                        </div>
                      </div>
                    </div>
					
					  <input type="hidden" name="submit_form" id="submit_form" />
					  <input type="hidden" name="num_of_item" id="num_of_item" value="<?=count($order_item_ids);?>"/>
					  <input type="hidden" name="promocode_id" id="promocode_id" value=""/>
					  <input type="hidden" name="promocode_value" id="promocode_value" value=""/>
					  <input type="hidden" name="user_id" id="user_id" value=""/>
					  <input type="hidden" name="user_type" id="user_type" value=""/>
					</form>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="block content cart-page cart-summary-page clearfix">
                  <div class="h2 clearfix">
                    <div class="float-left">
                      <?php echo $LANG['SUMMARY']; ?>
                    </div>
                    <div class="float-right">
                      <a href="<?=SITE_URL?>revieworder" class="btn btn-link btn-edit"><?php  echo $LANG['EDIT']; ?></a>
                    </div>
                  </div>
                  <table class="table">
				    <?php
					if($order_num_of_rows>0) {
						$num_of_quantity = array();
						foreach($order_item_list as $order_item_list_data) {
						  //path of this function (get_order_item) admin/include/functions.php
						  $order_item_data = get_order_item($order_item_list_data['id'],'list');
						  
						  $model_data = get_single_model_data($order_item_list_data['model_id']);
						  $mdl_details_url = SITE_URL.$model_data['sef_url'].'/'.createSlug($model_data['title']).'/'.$model_data['id'].($order_item_list_data['storage']?'/'.intval($order_item_list_data['storage']):''); ?>
						  <tr>
						  <td class="details">
							<div class="row">
							  <div style="padding-left: 0px; padding-right: 0px;" class="col-md-3 col-3 col-lg-2 col-xl-2">
								<?php
								if($order_item_list_data['model_img']) {
									echo '<img src="'.SITE_URL.'images/mobile/'.$order_item_list_data['model_img'].'"/>';
								} ?>
							  </div>
							  <div class="col-md-9 col-9 col-lg-10 col-xl-10">
								<h3><?=$order_item_list_data['model_title']?></h3>
								<h4 class="price"> <?=amount_fomat($order_item_list_data['price'])?></h4>
							  </div>
							</div>
						  </td>
						  </tr>
						<?php
					    $num_of_quantity[] = $order_item_list_data['quantity'];
						}
					} ?>
                  </table>
                  <div class="border-divider mb-3"></div>
                  <div class="summary-details clearfix">
					<div class="row sell_order_total_showhide" style="display:none;">
                      <div class="col-md-6 col-6">
                        <h4><?php echo $LANG['Sell Order Total']; ?></h4>
                      </div>
                      <div class="col-md-6 col-6">
                        <span><?=amount_fomat($sum_of_orders)?></span>
                      </div>
                    </div>
					<div class="row">
                      <div class="col-md-6 col-6">
                        <h4><?php echo $LANG['PRIORITY SHIPPING']; ?></h4>
                      </div>
                      <div class="col-md-6 col-6">
                        <span><?php echo $LANG['FREE']; ?></span>
                      </div>
                    </div>
					<div class="row express_service_showhide" style="display:none;">
                      <div class="col-md-6 col-6">
                        <h4><?php $LANG['Express Service ']; ?></h4>
                      </div>
                      <div class="col-md-6 col-6">
                        <span id="express_service_price_label"></span>
                      </div>
                    </div>
					<div class="row shipping_insurance_showhide" style="display:none;">
                      <div class="col-md-6 col-6">
                        <h4><?php echo $LANG['SHIPPING INSURANCE']; ?></h4>
                      </div>
                      <div class="col-md-6 col-6">
                        <span id="shipping_insurance_price_label"></span>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 col-6">
                        <h4><?php echo $LANG['TOTAL PAYMENT']; ?></h4>
                      </div>
                      <div class="col-md-6 col-6">
                        <span class="totla-price">
                          <?=amount_fomat($sum_of_orders)?>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

<div class="modal fade" id="NoInsuranceWarning" tabindex="-1" role="dialog" aria-labelledby="NoInsuranceWarning" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel"><strong><?php echo $LANG['NO INSURANCE WAS SELECTED']; ?></strong></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<?php echo $LANG['We will not be accountable for your device(s) if lost or damaged during shipment.']; ?>
			</div>
			<div class="modal-footer">
				<button type="button" id="NoInsuranceConfirm" class="btn btn-primary"><?php echo $LANG['CONFIRM']; ?></button>
				<button type="button" id="NoInsuranceCancel" class="btn btn-secondary" data-dismiss="modal"><?php echo $LANG['CANCEL']; ?></button>
			</div>
		</div>
	</div>
</div>
		
<script>
(function( $ ) {
	$(function() {

		$('#signup_email').on('input',function(e) {
			return false;
		});

		$('#express_service, #shipping_insurance, #shipping_insurance_no').on('click',function(e) {
			var sum_of_orders = '<?=$sum_of_orders?>';
			var express_service_price = 0;
			var shipping_insurance_price = 0;
			
			if($("input[name='express_service']").is(':checked')) {
				var express_service_price = (sum_of_orders*2.5/100);
				var _express_service_price=formatMoney(express_service_price);
				var f_express_service_price=format_amount(_express_service_price);

				$(".express_service_showhide").show();
				$("#express_service_price_label").html('-'+f_express_service_price);
			} else {
				$(".express_service_showhide").hide();
			}
			
			if($("input[id='shipping_insurance']").is(':checked')) {
				var shipping_insurance_price = (sum_of_orders*1.5/100);
				var _shipping_insurance_price=formatMoney(shipping_insurance_price);
				var f_shipping_insurance_price=format_amount(_shipping_insurance_price);
	
				$(".shipping_insurance_showhide").show();
				$("#shipping_insurance_price_label").html('-'+f_shipping_insurance_price);
			} else {
				$(".shipping_insurance_showhide").hide();
			}
			
			if($("input[name='express_service']").is(':checked') || $("input[id='shipping_insurance']").is(':checked')) {
				$(".sell_order_total_showhide").show();
			} else {
				$(".sell_order_total_showhide").hide();
			}

			sum_of_orders = (Number(sum_of_orders) - Number(express_service_price) - Number(shipping_insurance_price));
			var _sum_of_orders=formatMoney(sum_of_orders);
			var f_sum_of_orders=format_amount(_sum_of_orders);
			$(".totla-price").html(f_sum_of_orders);
		});
		
		$('#NoInsuranceConfirm').on('click',function(e) {
			$('#NoInsuranceWarning').modal('hide');

			$("#termsOption").collapse('show');
			$(".collapsethree_chkd").html('<a id="edit_address_details" href="javascript:void(0);">Edit</a>');
		});
		
		$(".payment-form").on('blur keyup change paste', 'input, select, textarea', function(event) {
			check_payment_step();
		});
		$(".address_details_tab, .shpping-insureance").on('blur keyup change paste', 'input, select, textarea', function(event) {
			check_address_details();
		});

		$("#terms_and_conditions").on('click', function(event) {
			if(document.getElementById("terms_and_conditions").checked==true) {
				$("#terms_and_conditions_error_msg").hide();
			} else {
				$("#terms_and_conditions_error_msg").show().text('Please tick to accept our terms and conditions');
			}
		});

		function check_payment_step() {
			jQuery(".m_validations_showhide").hide();
			
			<?php
			if($choosed_payment_option['paypal']=="paypal") { ?>
			if(document.getElementById("payment_method_paypal").checked==true) {
				var paypal_address = document.getElementById('paypal_address').value.trim();
				if(paypal_address=="") {
					jQuery("#paypal_address_error_msg").show().text('Please enter your paypal email address');
					return false;
				}

				var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
				if(paypal_address!='' && !paypal_address.match(mailformat)) {
					jQuery("#paypal_address_error_msg").show().text('Please enter a valid email address');
					return false;
				}
			}
			<?php
			}
			if($choosed_payment_option['cash']=="cash") { ?>
			if(document.getElementById("payment_method_cash").checked==true) {
				if(document.getElementById("cash_name").value.trim()=="") {
					jQuery("#cash_name_error_msg").show().text('Please enter your first and last name');
					return false;
				}

				var telInput2 = jQuery("#cash_phone");
				var c_cash_phone = telInput2.intlTelInput("getNumber");
				jQuery("#f_cash_phone").val(c_cash_phone);
				jQuery("#sms_notif_phone").html('<a href="tel:'+c_cash_phone+'">'+c_cash_phone+'</a>');

				var cash_phone = document.getElementById("cash_phone").value.trim();
				if(cash_phone=="") {
					jQuery("#cash_phone_error_msg").show().text('Please enter a phone number');
					return false;
				} else if(!telInput2.intlTelInput("isValidNumber")) {
					jQuery("#cash_phone_error_msg").show().text('Please enter a valid phone number');
					return false;
				}

				if(document.getElementById("cash_location").value.trim()=="") {
					jQuery("#cash_location_error_msg").show().text('Please select a starbucks location');
					return false;
				}
			}
			<?php
			}
			if($choosed_payment_option['zelle']=="zelle") { ?>
			if(document.getElementById("payment_method_zelle").checked==true) {
				if(document.getElementById("zelle_email").value.trim()=="") {
					jQuery("#zelle_email_error_msg").show().text('Please enter your zelle email');
					return false;
				}
			}
			<?php
			} ?>
		}
		
		function check_payment_step2() {
			
			<?php
			if($choosed_payment_option['cheque']=="cheque") { ?>
			if(document.getElementById("payment_method_cheque").checked==true) {
				if(document.getElementById("chk_name").value.trim()=="" || document.getElementById("chk_street_address").value.trim()=="" || document.getElementById("chk_city").value.trim()=="" || document.getElementById("chk_state").value.trim()=="" || document.getElementById("chk_zip_code").value.trim()=="") {
					return false;
				}
			}
			<?php
			}
			if($choosed_payment_option['paypal']=="paypal") { ?>
			if(document.getElementById("payment_method_paypal").checked==true) {
				if(document.getElementById("paypal_address").value.trim()=="") {
					return false;
				}
			}
			<?php
			}
			if($choosed_payment_option['cash']=="cash") { ?>
			if(document.getElementById("payment_method_cash").checked==true) {
				if(document.getElementById("cash_phone").value.trim()=="" || document.getElementById("cash_name").value.trim()=="" || document.getElementById("cash_location").value.trim()=="") {
					return false;
				}
			}
			<?php
			}
			if($choosed_payment_option['zelle']=="zelle") { ?>
			if(document.getElementById("payment_method_zelle").checked==true) {
				if(document.getElementById("zelle_email").value.trim()=="") {
					return false;
				}
			}
			<?php
			} ?>
		}
		
		function check_address_details() {
			jQuery(".m_validations_showhide").hide();
			
			var name = document.getElementById("name").value.trim();
			var address = document.getElementById("address").value.trim();
			var city = document.getElementById("city").value.trim();
			var state = document.getElementById("state").value.trim();
			var postcode = document.getElementById("postcode").value.trim();

			if(name == "") {
				jQuery("#name_error_msg").show().text('Please enter your first and last name');
				return false;
			}

			var telInput = jQuery("#cell_phone");
			var c_cellphone = telInput.intlTelInput("getNumber");
			jQuery("#phone").val(c_cellphone);
			jQuery("#sms_notif_phone").html('<a href="tel:'+c_cellphone+'">'+c_cellphone+'</a>');

			var phone = document.getElementById("phone").value.trim();
			if(phone=="") {
				jQuery("#cell_phone_error_msg").show().text('Please enter a phone number');
				return false;
			} else if(!telInput.intlTelInput("isValidNumber")) {
				jQuery("#cell_phone_error_msg").show().text('Please enter a valid phone number');
				return false;
			} else if(address == "") {
				jQuery("#address_error_msg").show().text('Please enter your address');
				return false;
			} else if(city == "") {
				jQuery("#city_error_msg").show().text('Please enter city');
				return false;
			} else if(state == "") {
				jQuery("#state_error_msg").show().text('Please enter state');
				return false;
			} else if(postcode == "") {
				jQuery("#postcode_error_msg").show().text('Please enter post code');
				return false;
			}
			
			if(!$("input[id='shipping_insurance']").is(':checked') && !$("input[id='shipping_insurance_no']").is(':checked')) {
				jQuery("#shipping_insurance_msg").show().text('Please select a shipping insurance option');
				return false;
			}
			
		}
		
		$(".step2next").on("click", function() {
			var ok = check_payment_step();
			if(ok == false) {
				return false;
			}

			var payment_step_data = $("input[name='payment_method']:checked").val();
			$(".payment_step_data").html(' '+payment_step_data);
			
			if($("input[id='payment_method_cash']").is(':checked')) {
				$("#termsOption").collapse('show');
			} else {
				$("#shipping").collapse('show');
			}
			$(".collapsetwo_chkd").html('<a id="edit_payment_tab" href="javascript:void(0);">Edit</a>');
		});

		$(document).on("click", "#edit_payment_tab", function() {
			$("#payment").collapse('show');
			$(".collapsetwo_chkd").html('');
		});

		$(".step3next").on("click", function() {
			var ok = check_address_details();
			if(ok == false) {
				return false;
			} else if($("input[id='shipping_insurance_no']").is(':checked')) {
				$('#NoInsuranceWarning').modal('show');
				return false;
				
				/*var ok = confirm('We will not be accountable for your device(s) if lost or damaged during shipment.');
				if(ok == true) {
					return false;
				}*/
			}

			$("#termsOption").collapse('show');
			$(".collapsethree_chkd").html('<a id="edit_address_details" href="javascript:void(0);">Edit</a>');
		});
		$(document).on("click", "#edit_address_details", function() {
			$("#shipping").collapse('show');
			$(".collapsethree_chkd").html('');
		});
		
		
		$(document).on("click", "#edit_account_tab", function() {
			$("#accountTab").collapse('show');
			$(".collapseone_chkd").html('');
		});

		$(".get_paid").on("click", function() {
			<?php
			if($user_id<=0) { ?>
			var signup_email = $("#signup_email").val();
			if(signup_email == "") {
				$("#accountTab").collapse('show');
				alert("Please fill up the account fields or login first");
				return false;
			}
			<?php
			} ?>

			var ok = check_payment_step2();
			if(ok == false) {
				$("#payment").collapse('show');
				alert("Please fill up the payment fields");
				return false;
			}

			var ok = check_address_details();
			if(ok == false && !$("input[id='payment_method_cash']").is(':checked')) {
				$("#shipping").collapse('show');
				alert("Please fill up the address details fields");
				return false;
			}
			
			if(document.getElementById("terms_and_conditions").checked==false) {
				$("#terms_and_conditions_error_msg").show().text('Please tick to accept our terms and conditions');
				return false;
			}
			
			$("#signup_form").submit();
		});
		
		/*$("#promocode_removed").click(function() {
			$("#promo_code").val('');
			$("#showhide_promocode_row").hide();
			$("#promocode_id").val('');
			$("#promocode_value").val('');
			$("#total_amt").html('<?=amount_fomat($sum_of_orders)?>');
		});*/
		
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
		$("#cell_phone").intlTelInput("setNumber", "<?=($user_data['phone']?'+'.$user_data['phone']:'')?>");

		var telInput2 = $("#cash_phone");
		telInput2.intlTelInput({
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
		//telInput.on("keyup change", reset);
	});
})(jQuery);

/*function getPromoCode()
{
	var promo_code = document.getElementById('promo_code').value.trim();
	if(promo_code=="") {
		document.getElementById('promo_code').focus();
		return false;
	}

	post_data = "promo_code="+promo_code+"&amt=<?=$sum_of_orders?>&order_id=<?=$order_id?>&token=<?=get_unique_id_on_load()?>";
	jQuery(document).ready(function($){
		$.ajax({
			type: "POST",
			url:"../ajax/promocode_verify.php",
			data:post_data,
			success:function(data) {
				if(data!="") {
					var resp_data = JSON.parse(data);
					console.log(resp_data);
					if(resp_data.msg!="" && resp_data.mode == "user_not_registered_or_login") {
						$(".showhide_promocode_msg").show();
						$(".promocode_msg").html(resp_data.msg);
					} else if(resp_data.msg!="" && resp_data.mode == "expired") {
						<?php
					    if($hide_device_order_valuation_price!='1') { ?>
						$("#promo_code").val('');
						$("#showhide_promocode_row").hide();
						$("#promocode_id").val('');
						$("#promocode_value").val('');
						$("#total_amt").html('<?=amount_fomat($sum_of_orders)?>');
						<?php
						} ?>

						$(".showhide_promocode_msg").show();
						$(".promocode_msg").html(resp_data.msg);
					} else {
						$(".showhide_promocode_msg").hide();
						$(".promocode_msg").html('');
						<?php
						if($hide_device_order_valuation_price!='1') { ?>
						$("#showhide_promocode_row").show();
						if(resp_data.coupon_type=='percentage') {
							$("#promocode_amt_lbl").html("("+resp_data.percentage_amt+"%)");
							$("#promocode_amt").html(resp_data.discount_of_amt);
						} else {
							$("#promocode_amt").html(resp_data.discount_of_amt);
						}
						$("#promocode_id").val(resp_data.promocode_id);
						$("#promocode_value").val(resp_data.promocode_value);
						$("#total_amt").html(resp_data.total);
						<?php
						} ?>
					}
				} else {
					$('.promocode_msg').html('Something wrong so please try again...');
				}
			}
		});
	});
}*/

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
		jQuery("#g_captcha_token").val('yes');
	}
};
<?php
} ?>

(function( $ ) {
	$(function() {
		$('#create_account_form').bootstrapValidator({
			fields: {
				email: {
					validators: {
						notEmpty: {
							message: 'Please enter an email address'
						},
						emailAddress: {
							message: 'Please enter a valid email address'
						}
					}
				}
			},
			submitHandler: function(validator, form, submitButton) {
				var email = $("#signup_email").val();
				var password = "";
				
				$(".account_step_data").html('');
				
				post_data = "email="+email+"&password="+password+"&token=<?=get_unique_id_on_load()?>";
				jQuery(document).ready(function($){
					$.ajax({
						type: "POST",
						url:"ajax/register_guest.php",
						data:post_data,
						success:function(data) {
							if(data!="") {
								var resp_data = JSON.parse(data);
								//console.log(resp_data,resp_data);
								if(resp_data.exist==true) {
									$(".email_exist_msg").html(resp_data.msg);
									$(".email_exist_msg").show();
								} else if(resp_data.signup==true) {
									$(".email_exist_msg").html("");
									$(".email_exist_msg").hide();
									$("#user_id").val(resp_data.user_id);
									$("#user_email").val('guest');
									$("#payment").collapse('show');
									$(".collapseone_chkd").html('<a id="edit_account_tab" href="javascript:void(0);">Edit</a>');
									$(".account_step_data").html(email);
								} else {
									alert("Something went wrong!");
									return false;
								}
							}
						}
					});
				});
			}
		});

		$('#login_form').bootstrapValidator({
			fields: {
				username: {
					validators: {
						notEmpty: {
							message: '<?php echo $LANG["Please enter an email address"]; ?>'
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
</script>