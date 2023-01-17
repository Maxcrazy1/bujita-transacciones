<?php
//Header section
include("include/header.php");

// If direct access then it will redirect to home page
if($user_id<=0) {
	setRedirect(SITE_URL);
	exit();
}

$account_tab = $_SESSION['account_tab'];
if($account_tab) {
	unset($_SESSION['account_tab']);
} ?>

  <section>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-11">
          <div class="block block-account clearfix">
            <nav>
              <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link <?=($account_tab == "profile"?'active':'')?>" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"><?php echo $LANG['PROFILE']; ?></a>
                <a class="nav-item nav-link <?=($account_tab == ""?'active':'')?>" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false"><?php echo $LANG['MY TRADE-INS']; ?></a>
                <a class="nav-item nav-link <?=($account_tab == "chg_psw"?'active':'')?>" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false"><?php echo $LANG['CHANGE PASSWORD']; ?></a>
                <a class="nav-item nav-link nav-logout" href="controllers/logout.php"><?php echo $LANG['LOGOUT']; ?></a>
              </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
              <div class="tab-pane fade <?=($account_tab == "profile"?'show active':'')?>" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <p class="text-center"><?php echo $LANG['Please, ensure that your contact details are entered correctly. Click the “UPDATE” button after any change has been made.']; ?></p>
                <div class="inner clearfix">
				<form class="clearfix" action="controllers/user/profile.php" method="post" id="profile_form" enctype="multipart/form-data">
				
                  <div class="checkout-block mb-5 clearfix">
                    <h3><?php echo $LANG['PROFILE DETAILS']; ?></h3>
                    <div class="p-1 pb-5 pt-5">
                      <div class="clearfix">
                        <div class="form-group">
                          <label for="exampleInputEmail1"><?php echo $LANG['FIRST NAME AND LAST NAME']; ?></label>
                          <input type="text" name="name" id="name" placeholder="" value="<?=$user_data['name']?>" required class="form-control" autocomplete="off" />
                        </div>
                        <div class="form-group">
                          <label for="exampleInputPassword1"><?php echo $LANG['EMAIL']; ?></label>
                          <input type="email" name="email" id="email" placeholder="" value="<?=$user_data['email']?>" required class="form-control" autocomplete="off" />
                        </div>
                        <div class="clearfix"></div>
                      </div>
                    </div>
                  </div>
				  
                  <div class="checkout-block mb-5 clearfix">
                    <h3><?php echo $LANG['SHIPPING DETAILS']; ?></h3>
                    <div class="p-1 pb-5 pt-5">
                      <div class="clearfix">
                        <div class="form-group">
                          <label for="exampleInputEmail1"><?php echo $LANG['ADDRESS 1']; ?></label>
                          <input type="text" name="address" id="address" placeholder="" value="<?=$user_data['address']?>"
                    required class="form-control" autocomplete="off" />
                        </div>
                        <div class="form-group">
                          <label for="exampleInputEmail1"><?php echo $LANG['ADDRESS 2']; ?></label>
                          <input type="text" name="address2" id="address2" placeholder="" value="<?=$user_data['address2']?>"
                    class="form-control" autocomplete="off" />
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-7">
                            <label for="exampleInputEmail1"><?php echo $LANG['CITY']; ?></label>
                            <input type="text" name="city" id="city" placeholder="" value="<?=$user_data['city']?>" required
                    class="form-control" />
                          </div>
                          <div class="form-group col-md-5">
                            <label for="exampleInputEmail1"><?php echo $LANG['STATE']; ?></label>
                            <input type="text" name="state" id="state" placeholder="" value="<?=$user_data['state']?>"
                    required class="form-control" />
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-5">
                            <label for="exampleInputEmail1"><?php echo $LANG['ZIP CODE']; ?></label>
                            <input type="text" name="postcode" id="postcode" placeholder="" value="<?=$user_data['postcode']?>"
                    required class="form-control" autocomplete="off" />
                          </div>
                          <div class="form-group col-md-7">
                            <label for="exampleInputEmail1"><?php echo $LANG['PHONE']; ?></label>
                            <input type="tel" id="cell_phone" name="cell_phone" class="form-control">
                  			<input type="hidden" name="phone" id="phone" />
                          </div>
						  <div class="clearfix"></div>
                        </div>
						
                      </div>
                    </div>
                  </div>
				  
				  <div class="checkout-block clearfix">
                    <h3><?php echo $LANG['ADDITIONAL OPTIONS']; ?></h3>
                    <div class="p-1 pb-5 pt-5">
                      <div class="clearfix">
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="occasional_special_offers" id="occasional_special_offers" value="1" <?=($user_data['occasional_special_offers']=='1'?'checked="checked"':'')?>>
                              <label class="custom-control-label" for="occasional_special_offers"><?php echo $LANG['Send me occasional special offers']; ?></label>
                            </div>
                            <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="important_sms_notifications" id="important_sms_notifications" value="1" <?=($user_data['important_sms_notifications']=='1'?'checked="checked"':'')?>>
                              <label class="custom-control-label" for="important_sms_notifications"><?php echo $LANG['Send me important SMS notifications to']; ?> <a href="tel:<?=$user_data['phone']?>"><?=$user_data['phone']?></a></label>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
				  
                  <button type="submit" class="btn btn-update btn-primary btn-lg float-left mt-3"><?php echo $LANG['UPDATE']; ?></button>
				  <input type="hidden" name="submit_form" id="submit_form" />
				  </form>
                </div>
              </div>
              <div class="tab-pane trade-in-tab fade <?=($account_tab == ""?'show active':'')?>" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <div class="block p-5 clearfix">
                  <table class="table">
                    <tr>
                      <th><?php echo $LANG['ORDER']; ?></th>
                      <th><?php echo $LANG['DATE & TIME']; ?></th>
                      <th><?php echo $LANG['STATUS']; ?></th>
                      <th class="text-center"><?php echo $LANG['TRADE-IN VALUE']; ?></th>
                      <th class="text-center"><?php echo $LANG['PRINT']; ?></th>
                    </tr>
					<?php
					$pages = new Paginator($page_list_limit,'p');
					
					$order_query=mysqli_query($db,"SELECT COUNT(*) AS num_of_orders FROM orders WHERE user_id='".$user_id."' AND user_id>0");
					$order_data = mysqli_fetch_assoc($order_query);
					$pages->set_total($order_data['num_of_orders']);
					
					if($order_data['num_of_orders']>0) {
						$order_items_query=mysqli_query($db,"SELECT * FROM orders WHERE user_id='".$user_id."' AND user_id>0 ORDER BY date DESC ".$pages->get_limit()."");
						while($order_list=mysqli_fetch_assoc($order_items_query)) {
							$order_price = 0;
							$order_price = get_order_price($order_list['order_id']);
						
							$msg_query=mysqli_query($db,"SELECT * FROM order_messaging WHERE order_id='".$order_list['order_id']."' ORDER BY id DESC");
							$num_msg_rows = mysqli_num_rows($msg_query); ?>
							<tr>
							  <td>
								<?=$order_list['order_id']?>
								<?php
								if($order_list['status'] == "awaiting_delivery") { ?>
									<br />
									<a href="<?=SITE_URL?>controllers/order/order.php?order_id=<?=$order_list['order_id']?>&mode=del" class="btn btn-danger btn-sm text-uppercase" onclick="return confirm('Are you sure you want to cancel this order?');">Cancel Order</a>
								<?php
								} ?>
							  </td>
							  <td>
								<?=format_date($order_list['date']).'<br />'.format_time($order_list['date']).' '.$customer_timezone?>
							  </td>
							  <td>
								<?=ucwords(str_replace('_',' ',$order_list['status']))?>
							  </td>
							  <td class="text-center">
								<strong><?=amount_fomat($order_price)?></strong>
							  </td>
							  <td class="text-center btn-label">
								<?php
								if($order_list['shipment_label_url']!="") {
								if($order_list['shipment_label_custom_name']) {
									$shipment_label_url = SITE_URL.'shipment_labels/'.$order_list['shipment_label_custom_name'];
								} else {
									$shipment_label_url = $order_list['shipment_label_url'];
								} ?>
								<?php /*?><a href="<?=SITE_URL.'controllers/download.php?download_link='.$order_list['shipment_label_url']?>" class="btn btn-secondary mb-1  btn-sm text-uppercase">SHIPPING Label</a><?php */?>
								<a href="<?=SITE_URL.'controllers/download.php?download_link='.$shipment_label_url?>" class="btn btn-secondary mb-1 btn-sm text-uppercase">SHIPPING Label</a>
								<?php
								} ?>
								<a href="<?=SITE_URL?>views/print/sales_confirmation.php?order_id=<?=$order_list['order_id']?>" class="btn btn-primary btn-sm text-uppercase" target="_blank">Confirmation</a>
							  </td>
							</tr>
						<?php
						}
					} else { ?>
						<tr>
							<td colspan="5" align="center"><?php echo $LANG['No Data Found']; ?></td>
						</tr>
					<?php
					} ?>
                  </table>
				  
				  <?php
				  echo $pages->page_links(); ?>

                  <div class="offer-status clearfix">
                    <h3><?php echo $LANG['OFFER STATUS']; ?></h3>
                    <h4><?php echo $LANG['Your trade-in offer can have any of the following status:']; ?></h4>
                    <ul>
                      <li><?php echo $LANG['AWAITING SHIPMENT — Your prepaid shipping label is yet to be scanned at a USPS post office.']; ?></li>
                      <li><?php echo $LANG['SHIPPED — Your device(s) is/are on the way to our office.']; ?></li>
                      <li><?php echo $LANG['DELIVERED — Your device(s) has/have been received at our office and processing will begin shortly.']; ?></li>
					  <li><?php echo $LANG['RETURNED TO SENDER — Your shipment has been returned back to you.']; ?></li>
					  <li><?php echo $LANG['SHIPMENT PROBLEM — There has been a problem with your shipment. We will contact you.']; ?></li>
					  <li><?php echo $LANG['SUBMITTED — Your offer will be reviewed shortly.']; ?></li>
                      <li><?php echo $LANG['PROCESSING — Your device(s) is/are being inspected by a technician.']; ?></li>
					  <li><?php echo $LANG['COMPLETED — Your offer has been paid out.']; ?></li>
                      <li><?php echo $LANG['PROBLEM — Your offer requires immediate review. We will contact you soon.']; ?></li>
                      <li><?php echo $LANG['EXPIRED — Your device(s) was/were not received 21 days after an offer was made.']; ?></li>
                      <li><?php echo $LANG['CANCELLED — Your offer was cancelled.']; ?></li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade <?=($account_tab == "chg_psw"?'show active':'')?>" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                <p class="text-center"><?php echo $LANG['Type in your new password and then click the "UPDATE" button to save it.']; ?> </p>
                <div class="inner clearfix">
				  <form action="controllers/user/change_password.php" method="post" id="chg_psw_form">
                  <div class="checkout-block clearfix">
                    <h3><?php echo $LANG['CHANGE PASSWORD']; ?></h3>
                    <div class="p-1 pb-5 pt-5">
                      <div class="clearfix">
                        <div class="form-group">
                          <label for="exampleInputEmail1"><?php echo $LANG['NEW PASSWORD']; ?></label>
                          <input type="password" name="password" id="password" placeholder="" required class="form-control" />
                        </div>
                        <div class="form-group">
                          <label for="exampleInputPassword1"><?php echo $LANG['CONFIRM PASSWORD']; ?></label>
                          <input type="password" name="password2" id="password2" placeholder="" required class="form-control " />
                        </div>
                        <div class="clearfix"></div>
                      </div>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary btn-update btn-lg float-left mt-3"><?php echo $LANG['UPDATE']; ?></button>
				  <input type="hidden" name="submit_form" id="submit_form" />
				  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

<!--<div class="row">
<div class="col-md-6">
  <div class="block ml-0 mr-0 pl-0 pr-0 clearfix">
	<p><strong>Submitted</strong> - You order has been submitted.</p>
	<p><strong>Expiring</strong> - Still awaiting your mobile(s) - 7 days.</p>
	<p><strong>Received</strong> - Mobile(s) received, not yet checked.</p>
	<p><strong>Problem</strong> - Problem with your order.</p>
	<p><strong>Completed</strong> - Order complete, payment sent.</p>
	<p><strong>Returned</strong> - Mobile(s) have been returned.</p>
	<p><strong>Awaiting Delivery</strong> - Sales Pack printed/posted, awaiting mobile(s).</p>
  </div>
</div>
<div class="col-md-6">
  <div class="block ml-0 mr-0 pl-0 pr-0 clearfix">
	<p><strong>Expired</strong> - We never received your mobile(s) - 14 days.</p>
	<p><strong>Processed</strong> - Mobile(s) received and checked, payment pending.<p>
		<p><strong>Rejected</strong> - Your order has been rejected.</p>
		<p><strong>Posted</strong> - Date mobile(s) posted recorded, awaiting mobile(s).</p>
		<p><strong>Offer Accepted</strong> Your offer has been accepted.</p>
		<p><strong>Offer Rejected</strong> - Your offer has been rejected.</p>
  </div>
</div>
</div>
-->
	  
<script>
function open_window(url) {
	apply = window.open(url,"Loading",'toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=550,height=450');
}

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
      //telInput.on("keyup change", reset);
    });
  })(jQuery);

  (function ($) {
    $(function () {
      $('#profile_form').bootstrapValidator({
        fields: {
          name: {
            validators: {
              stringLength: {
                min: 1,
              },
              notEmpty: {
                message: 'Please enter your first and last name'
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
                message: 'Please enter your password.'
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
  
  (function ($) {
    $(function () {
      $('#chg_psw_form').bootstrapValidator({
        fields: {
          password: {
            validators: {
              notEmpty: {
                message: 'Please enter new password'
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
                message: 'Please enter confirm password'
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
  
  
  	$(document).ready(function() {
                let data_session_URL = sessionStorage.getItem('redirect-uris');
                if(data_session_URL){
                    
                    window.location.replace(data_session_URL);
                }
  	});
</script>