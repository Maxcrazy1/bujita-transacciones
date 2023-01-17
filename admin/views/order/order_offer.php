<script>
function change_status(val) {
	if(val == "pending" || val == "offer_accepted") {
		jQuery(".showhide_content").show();
		jQuery(".showhide_rejected_content").hide();
	} else {
		jQuery(".showhide_content").hide();
		jQuery(".showhide_rejected_content").show();
	}
}

function chg_offer_price() {
	jQuery(document).ready(function($) {
		var sell_order_total = 0;
		var promocode_amt = 0;
		var total_of_order = 0;
		$('input:text.oitem_price').each(function () {
    		sell_order_total += parseFloat(this.value);
   		});

		<?php
		$currency = @explode(",",$general_setting_data['currency']);
		if($order_data_before_saved['promocode_id']>0 && $order_data_before_saved['promocode_amt']>0) {
			echo 'promocode_amt = $("#promocode_amt").val();total_of_order = (parseFloat(sell_order_total) + parseFloat(promocode_amt));';
			if($general_setting_data['disp_currency']=="prefix") {
				echo '$("#sell_order_total").html("'.$currency[1].'"+sell_order_total);';
				echo '$("#total_of_order").html("'.$currency[1].'"+total_of_order);';
			} elseif($general_setting_data['disp_currency']=="postfix") {
				echo '$("#sell_order_total").html(sell_order_total+"'.$currency[1].'");';
				echo '$("#total_of_order").html(total_of_order+"'.$currency[1].'");';
			}
		} else {
			if($general_setting_data['disp_currency']=="prefix") {
				echo '$("#sell_order_total").html("'.$currency[1].'"+sell_order_total);';
			} elseif($general_setting_data['disp_currency']=="postfix") {
				echo '$("#sell_order_total").html(sell_order_total+"'.$currency[1].'");';
			}
		} ?>
	});
}
</script>
									
<div id="wrapper">
    <header id="header" class="container">
    	<?php include("include/admin_menu.php"); ?>
    </header>

	<section class="container" role="main">
		<div class="row">
            <article class="span12 gray data-block">
				<header>
					<h2>Create Offer (#<?=$order_id?>)</h2>
					<ul class="data-header-actions">
						<li><a href="edit_order.php?order_id=<?=$order_id?>" target="_blank">View Order</a></li>
					</ul>
				</header>
                <section>
					<?php include('confirm_message.php');?>
					<?php
					if($is_offer_section_hide) { ?>
					<div class="alert alert-info fade in">
						<button class="close" data-dismiss="alert">&times;</button >
						<strong>Offer is allowed only of order having status (Processed, Problem).</strong>
					</div>
					<?php
					} ?>
					
                    <div class="row-fluid">
						<div class="span9">
                            <form action="controllers/order/offer.php" role="form" class="form-horizontal form-groups-bordered" method="post" onSubmit="return check_form(this);" enctype="multipart/form-data">
                                <fieldset>
								<div class="control-group">
									<label class="control-label" for="order-status">Order Status: </label>
									<div class="controls"><?=ucwords(str_replace("_"," ",$order_data_before_saved['status']))?></div>
								</div>
								
								<?php
								if($order_data_before_saved['offer_status']) { ?>
								<div class="control-group">
									<label class="control-label" for="input">Offer Status</label>
									<div class="controls"><?=ucwords(str_replace("_"," ",$order_data_before_saved['offer_status']))?></div>
								</div>
								<?php
								} ?>
								
								<div class="control-group">
									<label class="control-label" for="input">Offer Note: </label>
									<div class="controls">
										<textarea class="input-xlarge" name="note" id="note" placeholder="Note..." rows="4" <?=$readonly?>><?=$order_data_before_saved['offer_note']?></textarea>
									</div>
								</div>							
							
								<div class="control-group">
									<label class="control-label" for="input">Order Items</label><div class="controls">
									<table class="table table-striped table-bordered table-condensed table-hover no-margin" width="400">
										<thead>
											<tr>
												<th width="20">#</th>
												<th width="40">Item ID</th>
												<th width="275">Name</th>
												<th width="25">Quantity</th>
												<th width="40">Price</th>
											</tr>
										</thead>
										<tbody>
											<?php 
											if($order_num_of_rows>0) {
												foreach($order_item_list as $order_item_list_data) {
													//path of this function (get_order_item) admin/include/functions.php
													$order_item_data = get_order_item($order_item_list_data['id'],'general'); ?>
													<tr>
														<td><?=$n=$n+1?></td>
														<td><?=$order_item_list_data['id']?></td>
														<td><?=$order_item_data['device_title'].'<br>'.$order_item_data['device_info']?></td>
														<td><?=$order_item_list_data['quantity']?></td>
														<td>
														<input type="text" name="price[<?=$order_item_list_data['id']?>]" id="price[<?=$order_item_list_data['id']?>]" value="<?=$order_item_list_data['price']?>" onkeyup="chg_offer_price();" class="oitem_price" <?=$readonly?> style="width:100px;"/>
														<input type="hidden" name="old_price[<?=$order_item_list_data['id']?>]" id="old_price[<?=$order_item_list_data['id']?>]" value="<?=$order_item_list_data['price']?>" />
														</td>
													</tr>
												<?php
												} ?>
												
												<tr>
													<td colspan="4"><strong>Sell Order Total:</strong></td>
													<td><strong><span id="sell_order_total"><?=($sum_of_orders>0?amount_fomat($sum_of_orders):'')?></span></strong></td>
												</tr>
												<?php
												if($promocode_amt>0) { ?>
													<tr>
														<td colspan="4"><strong><?=$discount_amt_label?></strong></td>
														<td><strong><?=amount_fomat($promocode_amt)?></strong></td>
													</tr>
													<input type="hidden" name="promocode_amt" id="promocode_amt" value="<?=$promocode_amt?>" />
													<tr>
														<td colspan="4"><strong>Total:</strong></td>
														<td><strong><span id="total_of_order"><?=amount_fomat($total_of_order)?></span></strong></td>
													</tr>
												<?php
												}
											} else {
												echo '<tr><td colspan="6" align="center">No Record Found.</td></tr>';
											} ?>
										</tbody>
									</table></div>
								</div>
								<?php
								if($is_offer_section_hide==false) { ?>
								<div class="control-group showhide_content">
									<label class="control-label" for="input">Email Content</label>
									<div class="controls">
										<textarea class="input-xlarge wysihtml5" name="content" id="content" rows="15"><?=$email_body_text?></textarea>
									</div>
								</div>
								
								<input type="hidden" name="user_id" id="user_id" value="<?=$order_data_before_saved['user_id']?>" />
								<input type="hidden" name="order_id" id="order_id" value="<?=$post['order_id']?>" />
								
								<div class="form-actions">
									<button class="btn btn-alt btn-large btn-primary" type="submit" name="update" onClick="return check_form();"><?=($order_id?'Update':'Save')?></button>
									<a href="orders.php" class="btn btn-alt btn-large btn-black">Back</a>
								</div>
								<?php
								}?>
                                </fieldset>
                            </form>
                       </div>
                    </div>
                </section>
            </article>
			
			<article class="span12 data-block">
				<header><h2>Offer History</h2></header>
                <section>
                    <div class="row-fluid">
                        <div class="span12">
                                <fieldset>
									<div class="control-group">
									<table class="table table-hover">
										<thead>
											<tr>
												<th>Info</th>
												<th>Qty</th>
												<th width="80">Price</th>
											</tr>
										</thead>
										<tbody>
											<?php 
											$num_rows = mysqli_num_rows($msg_query);
											if($num_rows>0) {
												$i=1;
												while($msg_data=mysqli_fetch_assoc($msg_query)) { ?>
													<tr bgcolor="#CCCCFF">
														<td colspan="5">
															<?=($msg_data['type']=="admin"?'<b>From: </b>You':'<b>From: </b>Customer')?>
															<?=($msg_data['note']?'<br /><b>Note: </b>'.$msg_data['note']:'')?><br />
															<b>Date/Time: </b><?=format_date($msg_data['date']).' '.format_time($msg_data['date'])?><br />
															<b>Order Status: </b><?=ucwords(str_replace("_"," ",$msg_data['status']))?>
														</td>
													</tr>												
													<?php
													$offer_price_array = array();
													//Fetch offer data based on message history id
													$offer_query=mysqli_query($db,"SELECT oih.price as offer_price, oih.date as history_date, oi.*, o.`payment_method`, o.`date`, o.`approved_date`, o.`expire_date`, o.`status`, o.`sales_pack`, o.`paypal_address`, o.`chk_name`, o.`chk_street_address`, o.`chk_street_address_2`, o.`chk_city`, o.`chk_state`, o.`chk_zip_code`, o.`act_name`, o.`act_number`, o.`act_short_code`, o.`note`, d.title AS device_title, m.title AS model_title FROM order_items_history AS oih LEFT JOIN order_items AS oi ON oih.order_item_id=oi.id LEFT JOIN orders AS o ON o.order_id=oi.order_id LEFT JOIN devices AS d ON d.id=oi.device_id LEFT JOIN mobile AS m ON m.id=oi.model_id WHERE oih.msg_id='".$msg_data['id']."' ORDER BY oih.id ASC");
													while($offer_data=mysqli_fetch_assoc($offer_query)) {
														$order_item_data = get_order_item($offer_data['id'],'general'); ?>
														<tr>
															<td><?=$order_item_data['device_title'].'<br>'.$order_item_data['device_info']?></td>
															<td><?=$offer_data['quantity']?></td>
															<td><?=amount_fomat($offer_data['offer_price'])?></td>
														</tr>
														<?php
														$offer_price_array[] = $offer_data['offer_price'];
													}
													
													$sell_order_total = (count($offer_price_array)>0?array_sum($offer_price_array):''); ?>
													<tr>
														<td colspan="2"><strong>Sell Order Total:</strong></td>
														<td><strong><?=amount_fomat($sell_order_total)?></strong></td>
													</tr>
													<?php
													if($promocode_amt>0) { 
													$total_of_order = ($sell_order_total + $promocode_amt);?>
														<tr>
															<td colspan="2"><strong><?=$discount_amt_label?></strong></td>
															<td><strong><?=amount_fomat($promocode_amt)?></strong></td>
														</tr>
														<input type="hidden" name="promocode_amt" id="promocode_amt" value="<?=$promocode_amt?>" />
														<tr>
															<td colspan="2"><strong>Total:</strong></td>
															<td><strong><span id="total_of_order"><?=amount_fomat($total_of_order)?></span></strong></td>
														</tr>
													<?php
													}
												}
											} else {
												echo '<tr><td colspan="7" align="center">No Record Found.</td></tr>';
											} ?>
										</tbody>
									</table>
									</div>
                                </fieldset>
                        </div>
                    </div>
                </section>
            </article>
			
        </div>
    </section>
	<div id="push"></div>
</div>