<?php
//Url param
$order_id=$url_second_param;
$user_id=$_SESSION['user_id'];

//Header section
include("include/header.php");

//Get order batch data, path of this function (get_order_data) admin/include/functions.php
$order_data_before_saved = get_order_data($order_id);

//If direct access then it will redirect to home page
if($user_id<=0) {
	setRedirect(SITE_URL);
	exit();
}
elseif($user_id>0 && $user_id!=$order_data_before_saved['user_id']) {
	setRedirect(SITE_URL);
	exit();
}

//Get order price based on orderID, path of this function (get_order_price) admin/include/functions.php
$sum_of_orders=get_order_price($order_id);

if($order_data_before_saved['promocode_id']>0 && $order_data_before_saved['promocode_amt']>0) {
	$promocode_amt = $order_data_before_saved['promocode_amt'];
	$discount_amt_label = "Surcharge:";
	if($order_data_before_saved['discount_type']=="percentage")
		$discount_amt_label = "Surcharge (".$order_data_before_saved['discount']."% of Initial Quote):";

	$total_of_order = $sum_of_orders+$order_data_before_saved['promocode_amt'];
	$is_promocode_exist = true;
} else {
	$total_of_order = $sum_of_orders;
}

//Get order item list based on orderID, path of this function (get_order_item_list) admin/include/functions.php
$order_item_list = get_order_item_list($order_id);
$order_num_of_rows = count($order_item_list);

$is_offer_section_hide = true;
$readonly = 'readonly="readonly"';
$disabled = 'disabled="disabled"';
if($order_data_before_saved['status']=="processed" || $order_data_before_saved['status']=="problem") {
	$is_offer_section_hide = false;
	$readonly = '';
	$disabled = '';
}

//Get order messaging data list based on orderID, path of this function (get_order_messaging_data_list) admin/include/functions.php
$order_messaging_data_list = get_order_messaging_data_list($order_id);
$num_rows = count($order_messaging_data_list);
if($num_rows>0) { ?>
<section>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
			  <div class="block content-block clearfix">
				<div class="h3 nomargintop"><strong>Your Offer</strong></div>
				<form action="<?=SITE_URL?>controllers/order/order_offer.php" class="phone-sell-form" method="post" id="offer_form" role="form">
				  <div class="h4"><strong>Order ID:</strong> <?=$order_id?></div>
				  <div class="h4"><strong>Total Amount:</strong> <?=amount_fomat($total_of_order)?></div>
				  <div class="row">
					<div class="col-md-6">
					  <div class="form-group">
						<label for="input">Offer Note</label>
						<textarea class="form-control" name="note" id="note" placeholder="Note..." <?=$readonly?>></textarea>
					  </div>
					</div>
					<div class="col-md-6">
					  <div class="form-group">
						<label for="input">Offer Status</label>
						<select name="status" id="status" class="selectpicker" <?=$disabled?>>
						  <option value="">--select--</option>
						  <option value="offer_accepted" <?php if($order_data_before_saved['offer_status']=='offer_accepted'){echo 'selected="selected"';}?>>Offer Accept</option>
						  <option value="offer_rejected" <?php if($order_data_before_saved['offer_status']=='offer_rejected'){echo 'selected="selected"';}?>>Offer Rejected</option>
						</select>
					  </div>
					</div>
				  </div>
				  <div class="row">
					<div class="col-md-12">
					  <?php 
					  if($is_offer_section_hide==false) { ?>
						 <button class="btn" type="submit">Send</button>
						 <input type="hidden" name="submit_resp_offer" id="submit_resp_offer" />
						 <input type="hidden" name="order_id" id="order_id" value="<?=$order_id?>" />
					  <?php 
					  } ?>
					  <a href="<?=SITE_URL?>account<?=($post['p']>0?'?p='.$post['p']:'')?>"><button type="button" class="btn btn-back"><i class="fa fa-long-arrow-left" aria-hidden="true"></i>Back</button></a>
					</div>
				  </div>
				</form>
				<div class="h3"><strong>Order Item(s)</strong></div>
				<div class="sell-item-table clearfix">
				  <table class="table">
					<tr>
						<th>Name</th>
						<th>Qty</th>
						<th>Price</th>
					</tr>
					<?php
					if($order_num_of_rows>0) {
						foreach($order_item_list as $order_data) {
						  $order_item_data = get_order_item($order_data['id'],'general'); ?>
							<tr>
								<td class="divider" colspan="5"></td>
							</tr>
							<tr>
								<td><?=$order_data['device_title'].'-'.$order_item_data['device_type']?></td>
								<td><?=$order_data['quantity']?></td>
								<td><?=amount_fomat($order_data['price'])?></td>
							</tr>
						<?php
						} ?>
						<tr>
							<td class="divider" colspan="5"></td>
						</tr>
						<tr>
							<td colspan="2"><strong>Sell Order Total:</strong></td>
							<td><strong><?=($sum_of_orders>0?amount_fomat($sum_of_orders):'')?></strong></td>
						</tr>
						<?php
						if($promocode_amt>0) { ?>
							<tr>
								<td class="divider" colspan="5"></td>
							</tr>
							<tr>
								<td colspan="2"><strong><?=$discount_amt_label?></strong></td>
								<td><strong><?=amount_fomat($promocode_amt)?></strong></td>
							</tr>
							<tr>
								<td class="divider" colspan="5"></td>
							</tr>
							<tr>
								<td colspan="2"><strong>Total:</strong></td>
								<td><strong><?=amount_fomat($total_of_order)?></strong></td>
							</tr>
						<?php
						}
					} else {
						echo '<tr><td class="divider" colspan="5"></td></tr>';
						echo '<tr><td colspan="6" align="center">No Record Found.</td></tr>';
					} ?>
				  </table>
				</div>
				<div class="h3"><strong>Message History</strong></div>
				<div class="sell-item-table clearfix">
				  <table class="table">
					<?php
					$i=1;
					foreach($order_messaging_data_list as $msg_data) { ?>
					  <tr><td class="divider" colspan="5"></td></tr>
					  <tr>
						<td>
							<?=($msg_data['type']=="admin"?'<b>From: </b>Admin ('.format_date($msg_data['date']).' '.format_time($msg_data['date']).')':'<b>From: </b>You ('.format_date($msg_data['date']).' '.format_time($msg_data['date']).')')?>
							<?=($msg_data['note']?'<br /><b>Note: </b>'.$msg_data['note']:'')?><br />
							<b>Order Status: </b><?=ucwords(str_replace("_"," ",$msg_data['status']))?>
						</td>
					  </tr>
					<?php
					} ?>
				  </table>
				</div>
			
			  </div>
			</div>
		</div>
	  
		<script>
		(function( $ ) {
			$(function() {
				$('#offer_form').bootstrapValidator({
					fields: {
						note: {
							validators: {
								stringLength: {
									min: 1,
								},
								notEmpty: {
									message: 'Please enter note'
								}
							}
						}
					}
				}).on('success.form.bv', function(e) {
					$('#offer_form').data('bootstrapValidator').resetForm();
		
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
	</div>
</section>
<?php
} else {
	$msg='Offer not available for this order.';
	setRedirectWithMsg(SITE_URL.'account'.($post['p']>0?'?p='.$post['p']:''),$msg,'info');
	exit();
} ?>