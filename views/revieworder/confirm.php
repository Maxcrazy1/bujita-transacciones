<div class="editAddress-modal modal fade HelpPopup" id="EditAddress" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
			  <h5 class="modal-title">Shipping Address (Edit)</h5>
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			  </button>
			</div>
			<div class="modal-body">
				<form action="controllers/revieworder/confirm.php" method="post" id="chg_address_form">
					<h2></h2>
					<div class="borderbox lightpink">
						<!--<h3 class="highlightHeading">Shipping Address (Edit)</h3>-->
						<div class="form-group">
							<input type="text" name="address" id="address" placeholder="Address Line1" class="form-control" value="<?=$user_data['address']?>" />
						</div>
						<div class="form-group">
							<input type="text" name="address2" id="address2" placeholder="Address Line2" class="form-control" value="<?=$user_data['address2']?>" />
						</div>
						<div class="form-group">
							<input type="text" name="city" id="city" placeholder="City" class="form-control botspacing" value="<?=$user_data['city']?>"  />
						</div>
						<div class="form-group">
							<input type="text" name="state" id="state" placeholder="State" class="form-control botspacing" value="<?=$user_data['state']?>"  />
						</div>
						<div class="form-group">
							<input type="text" name="postcode" id="postcode" placeholder="Post code" class="form-control" value="<?=$user_data['postcode']?>"  />
						</div>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary">Update</button>
						<input type="hidden" name="adr_change" id="adr_change" />
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<section>
<form action="controllers/revieworder/confirm.php" method="post" onSubmit="return confirm_sale_validation(this);">
	<div class="container">
	<?php
	//Order steps
	$order_steps = 4;
	include("include/steps.php"); ?>

	<div class="row">
	<div class="col-md-12">
	  <div class="block head mb-0 pb-0 clearfix">
		<div class="h2"><strong>Confirm Your Sale</strong></div>
		<p>You're almost there! Your sell order for <span id="num_of_devices">0</span> handsets/devices is ready to be placed.</p>
	  </div>
	</div>
	</div>
	<div class="row address-details clearfix">
	<div class="col-md-6">
	  <div class="block gray-block clearfix">
		<div class="text clearfix">
		  <div class="h4"><?=$user_data['name']?></div>
		  <p><?=($user_data['address']?$user_data['address'].',<br />':'').($user_data['address2']?$user_data['address2'].',<br />':'').($user_data['state']?$user_data['state'].', ':'').($user_data['city']?$user_data['city'].' ':'').$user_data['postcode']?>
		  <?php
		  if($user_data['phone']) {
			 echo '<br /><strong>Telephone:</strong> '.$user_data['phone'];
		  } ?></p>
		</div>
  		<a class="btn btn-primary" href="javascript:void(0)" type="btn" data-toggle="modal" data-target="#EditAddress"><?=$user_data['address']?'Change':'Add Addess'?></a>
	  </div>
	</div>
	<div class="col-md-6">
	  <div class="block gray-block clearfix">
	  	<div class="text clearfix">
			<div class="h4">Payment Details</div>
			<p><strong>Your Payment Method:</strong> <?=ucfirst($order_data['payment_method'])?></p>
			<p>
			<?php
			if($order_data['payment_method']=="cheque") { ?>
				<strong>Check Name:</strong> <span class="text-pink"><?=$order_data['chk_name']?></span><br />
				<?=$order_data['chk_street_address'].($order_data['chk_street_address_2']!=""?'<br />'.$order_data['chk_street_address_2']:"").'<br />'.$order_data['chk_city'].'<br>'.$order_data['chk_state'].'<br>'.$order_data['chk_zip_code']?>
			<?php
			} elseif($order_data['payment_method']=="bank") { ?>
				<strong>Account Bank Name:</strong> <span class="text-pink"><?=$order_data['bank_name']?></span><br />
				<strong>Account Name:</strong> <span class="text-pink"><?=$order_data['act_name']?></span><br />
				<strong>Account Number:</strong> <span class="text-pink"><?=$order_data['act_number']?></span><br />
				<strong>Short Code:</strong> <span class="text-pink"><?=$order_data['act_short_code']?></span>
			<?php
			} elseif($order_data['payment_method']=="paypal") { ?>
				<strong>Paypal Address:</strong> <span class="text-pink"><?=$order_data['paypal_address']?></span>
			<?php
			} ?>
			</p>
		</div>
		<a class="btn btn-primary" href="<?=SITE_URL?>revieworder" type="btn">Update Payment Info</a>
	  </div>
	</div>
	</div>
	<div class="row">
		<div class="col-md-12">
		  <div class="block p-0 sell-item-table clearfix">
			<table class="table table-bordered">
			  <tr>
				<th>Handset/Device Type</th>
				<!--<th class="quantity">Quantity</th>-->
				<th class="amount">Price</th>
			  </tr>
			  <?php
			  if($order_num_of_rows>0) {
				  $num_of_quantity = array();
				  foreach($order_item_list as $order_item_list_data) {
				  //path of this function (get_order_item) admin/include/functions.php
				  $order_item_data = get_order_item($order_item_list_data['id'],'list'); ?>
					  <tr>
						<td class="item">
							<?php
							if($order_item_list_data['model_img']) {
								echo '<img src="'.SITE_URL.'images/mobile/'.$order_item_list_data['model_img'].'"/>';
							} ?>
							<p class="item-info">
								<?php
								echo $order_item_data['device_title'];
								if($order_item_data['device_info']) {
									echo '<br /><span class="details">'.$order_item_data['device_info'].'</span>';
								}
								if($order_item_data['data']['imei_number']) {
									echo '<br /><span class="details"><span> IMEI:</span> '.$order_item_data['data']['imei_number'].'</span>';
								} ?>
							</p>
						</td>
						<td class="amount"><span class="mobile-label">Price:</span><p class="price"><strong><?=amount_fomat($order_item_list_data['price'])?></strong></p></td>
					  </tr>
				  <?php
				  $num_of_quantity[] = $order_item_list_data['quantity'];
				  }
			  } else {
				 setRedirect(SITE_URL);
				 exit();
				} ?>
					<tr>
					<td colspan="1" class="text-right">Sell Order Total:</td>
					<td class="price text-right"><strong><?=amount_fomat($sum_of_orders)?></strong></td>
				  
				</tr>

				<tr id="showhide_promocode_row" style="display:none;">
				 
					<td colspan="1"  class="text-right">Surcharge:</td>
					<td class="price text-right"><strong><span id="promocode_amt"></span>&nbsp;<a href="javascript:void(0);" id="promocode_removed">X</a></strong></td>
				  
				</tr>
				<tr id="showhide_total_row">
				  
					<td colspan="1" class="text-right">Total:</td>
					<td class="price text-right"><strong><span id="total_amt"><?=amount_fomat($sum_of_orders)?></span></strong></td>
				</tr>
			</table>
		  </div>
			<?php
			if($general_setting_data['promocode_section']=='1') { ?>
				<div class="block ml-0 coupon clearfix">
				  <div class="form-inline quantity-form">
					<div class="form-group">
					  <input type="text" class="form-control" name="promo_code" id="promo_code" placeholder="Coupon Code">
					</div>
					<button type="button" class="btn btn-primary" name="apl_promo_code" id="apl_promo_code" onclick="getPromoCode();">Apply</button>
				  </div>

					<div class="showhide_promocode_msg pt-1" style="display:none;">
						<div class="promocode_msg text-danger"></div>
					</div>
				</div>
				
				<input type="hidden" name="promocode_id" id="promocode_id" value=""/>
				<input type="hidden" name="promocode_value" id="promocode_value" value=""/>
			<?php
			} ?>
		 </div>
	</div>

	<?php
	if($general_setting_data['terms_status']=='1' && $display_terms_array['confirm_sale']=="confirm_sale") { ?>
		<div class="row">
			<div class="col-md-12">
				<div class="block ml-0 mt-0 pt-0">
				<div class="custom-control custom-checkbox">
						<input class="custom-control-input" type="checkbox" name="terms" id="terms" >
						<label class="custom-control-label" for="terms">By confirming your sale, you confirm that you have read and understood the <a href="javascript:void(0)" class="help-icon" data-toggle="modal" data-target="#PricePromiseHelp">Terms & Conditions of Supply</a>.</label>
					</div>
				</div>
			</div>
		</div>
	<?php
	} else {
		echo '<input type="hidden" name="terms" id="terms" checked="checked"/>';
	} ?>

	<input type="hidden" name="num_of_item" id="num_of_item" value="<?=count($order_item_ids);?>"/>

	<div class="row">
	  <div class="col-md-6">
		<div class="block ml-0 clearfix">
		  <a href="<?=SITE_URL?>revieworder"><button type="button" class="btn btn-primary float-left">Review your sale</button></a>
		</div>
	  </div>
	  <div class="col-md-6">
		<div class="block mr-0 clearfix">
		  <button type="submit" class="btn btn-primary float-right" name="confirm_sale" id="confirm_sale">Confirm Sale</button>
		</div>
	  </div>
	</div>

	<div class="modal fade" tabindex="-1" role="dialog" id="PricePromiseHelp">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Terms & Conditions</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<?=$general_setting_data['terms']?>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
				</div> 
			</div>
		</div>
	</div>

	</div>
	</div>
</form>
</section>

<script>
function confirm_sale_validation() {
	if(document.getElementById("terms").checked==false) {
		alert('You must agree to terms & conditions to sign-up.');
		return false;
	}
}

function getPromoCode()
{
	var promo_code = document.getElementById('promo_code').value.trim();
	if(promo_code=="") {
		alert('Please enter coupon code');
		return false;
	}

	post_data = "promo_code="+promo_code+"&amt=<?=$sum_of_orders?>&user_id=<?=$user_id?>&order_id=<?=$order_id?>&token=<?=md5(uniqid());?>";
	jQuery(document).ready(function($){
		$.ajax({
			type: "POST",
			url:"../ajax/promocode_verify.php",
			data:post_data,
			success:function(data) {
				if(data!="") {
					var resp_data = JSON.parse(data);
					console.log(resp_data);
					if(resp_data.msg!="" && resp_data.mode == "expired") {
						$("#promo_code").val('');
						$("#showhide_promocode_row").hide();
						$("#promocode_id").val('');
						$("#promocode_value").val('');
						$("#total_amt").html('<?=amount_fomat($sum_of_orders)?>');

						$(".showhide_promocode_msg").show();
						$(".promocode_msg").html(resp_data.msg);
					} else {
						$(".showhide_promocode_msg").hide();
						$(".promocode_msg").html('');
						$("#showhide_promocode_row").show();
						if(resp_data.coupon_type=='percentage') {
							$("#promocode_amt").html("("+resp_data.percentage_amt+"%): "+resp_data.discount_of_amt);
						} else {
							$("#promocode_amt").html(resp_data.discount_of_amt);
						}
						$("#promocode_id").val(resp_data.promocode_id);
						$("#promocode_value").val(resp_data.promocode_value);
						$("#total_amt").html(resp_data.total);
					}
				} else {
					$('.promocode_msg').html('Something wrong so please try again...');
				}
			}
		});
	});
}

(function( $ ) {
	$(function() {
		$("#promocode_removed").click(function() {
			$("#promo_code").val('');
			$("#showhide_promocode_row").hide();
			$("#promocode_id").val('');
			$("#promocode_value").val('');
			$("#total_amt").html('<?=amount_fomat($sum_of_orders)?>');
		});

		$('#chg_address_form').bootstrapValidator({
			fields: {
				address: {
					validators: {
						notEmpty: {
							message: 'Please enter address.'
						}
					}
				}/*,
				address2: {
					validators: {
						notEmpty: {
							message: 'Please enter address2.'
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
				}
			}
		}).on('success.form.bv', function(e) {
			$('#chg_address_form').data('bootstrapValidator').resetForm();

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

		$('#chg_address_form').bootstrapValidator({
			fields: {
				address: {
					validators: {
						notEmpty: {
							message: 'Please enter address.'
						}
					}
				},
				address2: {
					validators: {
						notEmpty: {
							message: 'Please enter address2.'
						}
					}
				},
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
				}
			}
		}).on('success.form.bv', function(e) {
			$('#chg_address_form').data('bootstrapValidator').resetForm();

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
		
		$("#num_of_devices").html('<?=array_sum($num_of_quantity)?>');
	});
})(jQuery);
</script>