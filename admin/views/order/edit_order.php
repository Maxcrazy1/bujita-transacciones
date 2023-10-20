<style type="text/css">
.prettycheckbox.disabled a {
	background-position: unset;
}
</style>

<?php
if($post['order_mode'] == "paid") {
	$back_url = ADMIN_URL.'paid_orders.php';
} elseif($post['order_mode'] == "awaiting") {
	$back_url = ADMIN_URL.'awaiting_orders.php';
} elseif($post['order_mode'] == "imei") {
	$back_url = ADMIN_URL.'search_by_imei_orders.php';
} else {
	$back_url = ADMIN_URL.'orders.php';
} ?>

<script>
function open_window(url) {
	apply = window.open(url,"Loading",'toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=800,height=800');
}
</script>
	
<div id="wrapper">
    <header id="header" class="container">
    	<?php include("include/admin_menu.php"); ?>
    </header>
	
	<section class="container" role="main">
		<div class="row">
            <article class="span12 data-block">
				<header>
					<h2>Invoice.Order #<?=$order_id?></h2>
					<ul class="data-header-actions">
						<!--<li><a class="btn btn-alt btn-success" href="javascript:open_window('<?=SITE_URL?>admin/views/print/print_delivery_note.php?order_id=<?=$order_id?>')">Delivery note</a></li>-->
						<?php
						if($order_data_before_saved['shipment_label_url']!="") {
						if($order_data_before_saved['shipment_label_custom_name']) {
							$shipment_label_url = SITE_URL.'shipment_labels/'.$order_data_before_saved['shipment_label_custom_name'];
						} else {
							$shipment_label_url = $order_data_before_saved['shipment_label_url'];
						} ?>
						<li><a href="<?=SITE_URL.'controllers/download.php?download_link='.$shipment_label_url?>" class="btn btn-alt btn-success">Address Label</a></li>
						<?php /*?><li><a href="<?=SITE_URL.'controllers/download.php?download_link='.$order_data_before_saved['shipment_label_url']?>" class="btn btn-alt btn-success">Address Label</a></li><?php */?>
						<?php
						} ?>
						<!--<li><a class="btn btn-alt btn-success" href="javascript:open_window('<?=SITE_URL?>admin/views/print/print_post_label.php?order_id=<?=$order_id?>')">Address Label</a></li>-->
						<li><a class="btn btn-alt btn-success" href="javascript:open_window('<?=SITE_URL?>admin/views/print/sales_confirmation.php?order_id=<?=$order_id?>')" target="_blank">sales Confirmation</a></li>
						<!--<li><a onclick="window.open(this.href,'win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=yes,location=yes'); return false;" href="print_order.php?order_id=<?=$order_id?>">Print</a></li>-->
					</ul>
				</header>
				<section>
					<?php include('confirm_message.php');?>
					<!-- Grid row -->
					<div class="row-fluid">
						<div class="span4">
							<div class="well">
								<h4 class="no-margin"><?=$order_data_before_saved['name']?></h4>
								<dl class="no-bottom-margin">
									<dt>Address:</dt>
									<dd><?=$order_data_before_saved['address']?></dd>
									<dd><?=$order_data_before_saved['city'].', '.$order_data_before_saved['state'].' '.$order_data_before_saved['postcode']?></dd>
									<dd><?=$order_data_before_saved['country']?></dd>
									<dt>Contact:</dt>
									<dd><a href="mailto:<?=$order_data_before_saved['email']?>"><?=$order_data_before_saved['email']?></a></dd>
									<!--<dt>Sales Pack Option:</dt>
									<dd><?=ucwords(str_replace("_"," ",$order_data_before_saved['sales_pack']))?></dd>-->

									<?php
									if($order_data_before_saved['sales_pack']=="pickup") { ?>
										<dt>Pickup Informations:</dt>
										<dd><strong>Date:</strong> <?=date("m-d-Y",strtotime($order_data_before_saved['pickup_date']))?></dd>
										<dd><strong>Time Slot:</strong> <?=str_replace("_"," ",$order_data_before_saved['pickup_time'])?></dd>
										<dd><strong>Address Line1:</strong> <?=$order_data_before_saved['pickup_address']?></dd>
										<dd><strong>Address Line2:</strong> <?=$order_data_before_saved['pickup_address2']?></dd>
										<dd><strong>City:</strong> <?=$order_data_before_saved['pickup_city']?></dd>
										<dd><strong>State:</strong> <?=$order_data_before_saved['pickup_state']?></dd>
										<dd><strong>Post Code:</strong> <?=$order_data_before_saved['pickup_postcode']?></dd>
									<?php
									} ?>
								</dl>
								
								<div style="overflow-y:auto; max-height:250px;">
									<?php
									if($order_data_before_saved['shipping_api']=="easypost" && $order_data_before_saved['shipment_id']!="") { ?>
										<h4 class="" style="margin-top:20px;">Shipping Info</h4>
										<dl class="no-bottom-margin">
											<dd><strong>Shipping API:</strong> 
											<?php 
											if($order_data_before_saved['shipping_api']=="easypost") {
												echo 'Easy Post';
											} ?>
											</dd>
											<dd><strong>Shipment ID:</strong> <?=$order_data_before_saved['shipment_id']?></dd>
											<dd><strong>Shipment Tracking Code:</strong> <?=$order_data_before_saved['shipment_tracking_code']?></dd>
											<dd><strong>Download Shipment Label:</strong> <a target="_blank" href="<?=$order_data_before_saved['shipment_label_url']?>">View</a></dd>
										</dl>
										
										<?php 
										if($order_data_before_saved['shipping_api']=="easypost") {
											if($order_data_before_saved['shipment_id']) { ?>
												<h4 style="margin-top:20px;">Tracking Details</h4>
												<dl class="no-bottom-margin">
													<?php
													try {
														require_once("../libraries/easypost-php-master/lib/easypost.php");
														\EasyPost\EasyPost::setApiKey($shipping_api_key);
	
														$shipment = \EasyPost\Shipment::retrieve($order_data_before_saved['shipment_id']);
														//print_r($shipment->tracker->tracking_details);
														//echo $shipment->insurance

														echo '<h5 style="margin-top:20px;">Current Status</h5>';
														echo '<dd><strong>Date:</strong> '.date('m-d-Y h:i A',strtotime($shipment->tracker->created_at)).'</dd>';
														echo '<dd><strong>Tracking Code:</strong> '.$shipment->tracker->tracking_code.'</dd>';
														echo '<dd><strong>Est. Delivery Date:</strong> '.date('m-d-Y h:i A',strtotime($shipment->tracker->est_delivery_date)).'</dd>';
														echo '<dd><strong>Status:</strong> '.$shipment->tracker->status.'</dd>';
														echo '<dd><strong>Public Url:</strong> <a target="_blank" href="'.$shipment->tracker->public_url.'">Click Here To See</a></dd>';
														
														echo '<h5 style="margin-top:20px;">History</h5>';
														foreach($shipment->tracker->tracking_details as $tracking_details) {
															echo '<dd><strong>'.date('m-d-Y h:i A',strtotime($tracking_details->datetime)).'</strong><br>'.$tracking_details->message.'</dd>';
															if($tracking_details->tracking_location->city && $tracking_details->tracking_location->state) {
																echo '<dd>'.$tracking_details->tracking_location->city.', '.$tracking_details->tracking_location->state.($tracking_details->tracking_location->country?', '.$tracking_details->tracking_location->country:'').', '.$tracking_details->tracking_location->zip.'</dd>';
															}
															echo '<br>';
														}
													} catch(Exception $e) {
														echo "Status: ".$e->getHttpStatus().":";
														echo $e->getMessage()."\n";
													} ?>
												</dl>
											<?php
											}
										}
										$shipment_alert_msg = "Are you sure you want to re-create shipment for this order? current shipment may be in proccess.";
									} else {
										echo '<h4 class="" style="margin-top:20px;">Shipment Was Not Created</h4>';
										$shipment_alert_msg = "Are you sure you want to create shipment for this order?";
									} ?>
								
									<dl class="no-bottom-margin">
										<form action="controllers/order/order.php" role="form" class="form-horizontal form-groups-bordered" method="post">
											<input type="hidden" name="create_shipment" id="create_shipment" value="yes" />
											<input type="hidden" name="order_id" id="order_id" value="<?=$order_id?>" />
											
											<button class="btn btn-alt btn-primary" type="submit" name="create_shipment" onclick="return confirm('<?=$shipment_alert_msg?>');">Create Shipment</button>
										</form>
									</dl>
								</div>
								
							</div>
						</div>

						<div class="span4">
							<div class="well">
								<h4 class="no-margin">Billing details</h4>
								<dl class="no-bottom-margin">
									<dd><strong>Total Amount: </strong><?=amount_fomat($total_of_order)?></dd>
									<dd><strong>Invoice.order ID: #</strong><?=$order_id?></dd>
									<dd><strong>Order Status: </strong><?=ucwords(str_replace("_"," ",$order_data_before_saved['status']))?></dd>
									<dd><strong>Order Date: </strong><?=format_date($order_data_before_saved['date']).' '.format_time($order_data_before_saved['date'])?></dd>
									<dd>
									<strong>Approved Date: </strong>
									<?php
									if($order_data_before_saved['approved_date']=="0000-00-00 00:00:00")
										echo 'xx-xx-xxxx';
									else 
										echo format_date($order_data_before_saved['approved_date']).' '.format_time($order_data_before_saved['approved_date']);
									?>
									<dd>
									<strong>Due Date: </strong>
									<?php
									if($order_data_before_saved['expire_date']=="0000-00-00 00:00:00")
										echo 'xx-xx-xxxx';
									else 
										echo format_date($order_data_before_saved['expire_date']).' '.format_time($order_data_before_saved['expire_date']);
									?>
									</dd>
								</dl>
							</div>
						</div>
						<div class="span4">
							<div class="well">
								<h4 class="no-margin">Payment Details</h4>
								<dl class="no-bottom-margin">
									<dd><strong>Payment Method: </strong><?=ucfirst($order_data_before_saved['payment_method'])?></dd>
									<?php
									if($order_data_before_saved['payment_method']=="paypal") { ?>
										<dd><strong>Paypal Address: </strong><?=$order_data_before_saved['paypal_address']?></dd>
									<?php
									} elseif($order_data_before_saved['payment_method']=="bank") { ?>
										<dd><strong>Bank Name: </strong><?=$order_data_before_saved['bank_name']?></dd>
										<dd><strong>Account Holder Name: </strong><?=$order_data_before_saved['act_name']?></dd>
										<dd><strong>Account Number: </strong><?=$order_data_before_saved['act_number']?></dd>
										<dd><strong>Short Code: </strong><?=$order_data_before_saved['act_short_code']?></dd>
									<?php
									} elseif($order_data_before_saved['payment_method']=="cheque") { ?>
										<dd><strong>Name: </strong><?=$order_data_before_saved['chk_name']?></dd>
										<dd><strong>Address: </strong><?=$order_data_before_saved['chk_street_address'].$order_data_before_saved['chk_street_address_2'].'<br>'.$order_data_before_saved['chk_city'].', '.$order_data_before_saved['chk_state'].' '.$order_data_before_saved['chk_zip_code']?></dd>
									<?php
									} elseif($order_data_before_saved['payment_method']=="bitcoin") { ?>
										<dd>Bitcoin Wallet Address: <?=$order_data_before_saved['bitcoin_number']?></dd>
									<?php
									} elseif($order_data_before_saved['payment_method']=="zelle") { ?>
										<dd>Zelle® Email Address: <?=$order_data_before_saved['zelle_email']?></dd>
									<?php
									} elseif($order_data_before_saved['payment_method']=="cash") { ?>
										<dd><strong>Name: </strong><?=$order_data_before_saved['cash_name']?></dd>
										<dd><strong>Phone: </strong><?=$order_data_before_saved['cash_phone']?></dd>
										<dd><strong>Location: </strong><?=$order_data_before_saved['cash_location_name']?></dd>
									<?php
									} ?>
								</dl>
							</div>
						</div>
					</div>
					<!-- /Grid row -->

					<form action="controllers/order/order.php" role="form" method="post">
					<table class="table table-striped table-bordered table-condensed table-hover no-margin">
						<thead>
							<tr>
								<th>Item ID</th>
								<th>Model</th>
								<th>Qty</th>
								<th>IMEI Number</th>
								<!--<th>Storage</th>
								<th>Condition</th>
								<th>Network</th>
								<th>Accessories</th>
								<th>Miscellaneous</th>-->
								<th>Price</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if($order_num_of_rows>0) {
								foreach($order_item_list as $order_item_list_data) {
								$fields_cat_type = $order_item_list_data['fields_cat_type'];
								//path of this function (get_order_item) admin/include/functions.php
								$order_item_data = get_order_item($order_item_list_data['id'],'general');
								$item_id = $order_item_list_data['id']; ?>
								<tr>
									<td><?=$order_item_list_data['id']?></td>
									<td><?=$order_item_data['device_title'].'<br>'.$order_item_data['device_info']?><br /><button type="button" class="btn btn-alt btn-small btn-primary" onClick="EditOrder(<?=$item_id?>);return false;">Edit</button>&nbsp;<button type="button" class="btn btn-alt btn-small btn-primary" onClick="PrintOrderItem(<?=$item_id?>);return false;">Print Label</button></td>
									<td width="50"><input type="number" min="1" class="input-xlarge" id="quantity[]" name="quantity[<?=$item_id?>]" value="<?=$order_item_list_data['quantity']?>" readonly=""></td>
									<td width="150">
										<input type="text" class="input-xlarge" id="imei_number[]" name="imei_number[<?=$item_id?>]" value="<?=$order_item_list_data['imei_number']?>">
										<?php
										if($order_item_list_data['imei_number']!="" && $order_item_list_data['is_check_icloud']=='1') { ?>
										<button type="button" class="btn btn-alt btn-small btn-primary" style="margin-top:10px;" onClick="iCloudOrderItem(<?=$item_id?>);return false;">iCloud?</button>&nbsp;<span style="display:none;" id="icloud_status_loading<?=$order_item_list_data['id']?>" class="loading green" title="Loading, please wait&hellip;">Loading&hellip;</span>&nbsp;<span id="icloud_status<?=$order_item_list_data['id']?>"></span>
										<?php
										} ?>
									</td>
									<?php /*?><td><input type="text" class="input-xlarge" id="storage[]" name="storage[<?=$item_id?>]" value="<?=$order_item_list_data['storage']?>"></td>
									<td><input type="text" class="input-xlarge" id="condition[]" name="condition[<?=$item_id?>]" value="<?=$order_item_list_data['condition']?>"></td>
									<td><input type="text" class="input-xlarge" id="network[]" name="network[<?=$item_id?>]" value="<?=$order_item_list_data['network']?>"></td>
									
									<td>
										<textarea class="form-control" name="accessories[<?=$item_id?>]" rows="2" placeholder="Accessories"><?=$order_item_list_data['accessories']?></textarea>
									</td>
									<td>
										<textarea class="form-control" name="miscellaneous[<?=$item_id?>]" rows="2" placeholder="Miscellaneous"><?=$order_item_list_data['miscellaneous']?></textarea>
									</td><?php */?>
									<td><input type="number" class="input-xlarge item_price" id="price[]" name="price[<?=$item_id?>]" value="<?=$order_item_list_data['price']?>"></td>
								</tr>
								<?php
								} ?>
								<tr>
									<td colspan="2"></td>
									<td colspan="2"><strong>Sell Order Total:</strong></td>
									<td><strong id="item_price_total"><?=($sum_of_orders>0?amount_fomat($sum_of_orders):'')?></strong></td>
								</tr>
								<?php
								if($promocode_amt>0 || $f_express_service_price>0 || $f_shipping_insurance_price>0) {
									if($promocode_amt>0) { ?>
									<tr>
										<td colspan="2"></td>
										<td colspan="2"><strong><?=$discount_amt_label?></strong></td>
										<td><strong><?=amount_fomat($promocode_amt)?></strong></td>
									</tr>
									<?php
									}
									if($f_express_service_price>0) { ?>
									<tr>
										<td colspan="2"></td>
										<td colspan="2"><strong>Express Service:</strong></td>
										<td><strong>-<?=amount_fomat($f_express_service_price)?></strong></td>
									</tr>
									<?php
									}
									if($f_shipping_insurance_price>0) { ?>
									<tr>
										<td colspan="2"></td>
										<td colspan="2"><strong>Shipping Insurance:</strong></td>
										<td><strong>-<?=amount_fomat($f_shipping_insurance_price)?></strong></td>
									</tr>
									<?php
									} ?>
									<tr>
										<td colspan="2"></td>
										<td colspan="2"><strong>Total:</strong></td>
										<td><strong id="price_f_total"><?=amount_fomat(($sum_of_orders - $f_express_service_price - $f_shipping_insurance_price))?></strong></td>
									</tr>
								<?php
								}
							} else {
								echo '<tr><td colspan="4" align="center">No Record Found.</td></tr>';
							} ?>
						</tbody>
					</table>

					<table style="float:right;">
						<tbody>
							<tr>
								<td align="right"><button class="btn btn-alt btn-medium btn-primary" type="submit" name="update_order">Update</button></td>
							</tr>
						</tbody>
					</table>
					<input type="hidden" name="order_id" id="order_id" value="<?=$post['order_id']?>" />
					<input type="hidden" name="order_mode" id="order_mode" value="<?=$post['order_mode']?>">
					</form>
				</section>
						
                <section>
                    <div class="row-fluid">
                        <div class="span12">
                            <form action="controllers/order/order.php" role="form" class="form-inline form-groups-bordered" method="post">
                                <fieldset>
									<div class="row-fluid">
										<div class="span3">
											<div class="control-group">
												<label class="control-label" for="input">Order Status: </label>
												<div class="controls">
												<select name="status" id="status" onchange="ChangeOrderStatus(this.value)">
													<?php
													ksort($order_status_list);
													foreach($order_status_list as $order_status_k=>$order_status_v) { ?>
														<option value="<?=$order_status_k?>" <?php if($order_data_before_saved['status']==$order_status_k){echo 'selected="selected"';}?>><?=$order_status_v?></option>
													<?php
													} ?>
												</select>
												</div>
											</div>
										</div>
										<div class="span3">
											<div class="control-group">
												<label class="control-label" for="input">Order Item: </label>
												<div class="controls">
												<select name="model_item_id" id="model_item_id">
													<?php
													if($order_num_of_rows>0) {
														foreach($order_item_list as $order_item_list_data) {
															$order_item_data = get_order_item($order_item_list_data['id'],'general');
															$item_id = $order_item_list_data['id']; ?>
															<option value="<?=$item_id?>"><?=$order_item_list_data['brand_title'].' - '.$order_item_list_data['model_title'].' ('.$order_item_list_data['id'].')'?></option>
														<?php
														}
													} ?>
												</select>
												</div>
											</div>
										</div>
										<div class="span3 showhide_email_template_list" style="display:none;">
											<div class="control-group" id="email_template_list"></div>
										</div>
										<div class="span3">
											<div class="control-group">
												<label class="control-label" for="input">From Email: </label>
												<div class="controls">
												<select name="o_from_email" id="o_from_email">
													<option value="<?=FROM_EMAIL?>"><?=FROM_EMAIL?></option>
													<?php
													while($staff_group_data=mysqli_fetch_assoc($sg_query)) {
														echo '<option value="'.$staff_group_data['email'].'">'.$staff_group_data['email'].'</option>';
													} ?>
												</select>
												</div>
											</div>
										</div>
									</div>
									
									<div class="row-fluid">
										<div class="control-group" style="margin-top:20px;">
											<label class="control-label" for="input">Email Content: </label>
											<div class="controls" id="email_template_content">
												<textarea class="input-xlarge wysihtml5" name="note" id="note" placeholder="note" rows="25"><?=$email_body_text?></textarea>
											</div>
										</div>
									</div>
									
                                    <div class="form-actions">
                                        <button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($order_id?'Update':'Save')?></button>
										<a href="<?=$back_url?>" class="btn btn-alt btn-large btn-black">Back</a>
                                    </div>
                                </fieldset>
								<input type="hidden" name="order_id" id="order_id" value="<?=$post['order_id']?>" />
								<input type="hidden" name="order_mode" id="order_mode" value="<?=$post['order_mode']?>">
                            </form>
                        </div>
                    </div>
                </section>
            </article>
        </div>
		
		<div class="row">
            <article class="span12 data-block">
				<header>
					<h2>Internal Note</h2>
				</header>	
                <section>
                    <div class="row-fluid">
						<div class="span1">&nbsp;</div>
						<div class="span10">
						  <form action="controllers/appointment.php" method="post" role="form" class="form-vertical form-groups-bordered comment_form">
							<fieldset>
								<?php /*?><h4>Internal Note</h4><?php */?>
								
								<div class="control-group">
									<?php /*?><label class="control-label" for="input">Comment * </label><?php */?>
									<div class="controls">
										<textarea class="input-xlarge" name="comment" id="comment" placeholder="Comment..." rows="3" required></textarea>
									</div>
								</div>

								<input type="hidden" name="staff_id" id="staff_id" value="<?=$admin_l_id?>" />
								<input type="hidden" name="order_id" id="order_id" value="<?=$post['order_id']?>" />
								<input type="hidden" name="order_mode" id="order_mode" value="<?=$post['order_mode']?>">
								<input type="hidden" name="c_status" id="c_status" value="<?=$order_data_before_saved['status']?>">
								
								<?php /*?><h4 style="margin-top:20px;">Comments History</h4><?php */?>
								<div class="chat-messages" style="overflow-y:auto; max-height:350px; margin-top:20px;">
									<table class="table" width="100%">
										<tbody class="apd-chat-message">
											<?php
											if($num_of_comment>0) {
												while($comment_list = mysqli_fetch_assoc($comment_query)) { ?>
													<tr>
														<td>
															<span><?=format_date($comment_list['date']).' '.format_time($comment_list['date'])?> <span class="label label-success"><?=ucwords(str_replace("_"," ",$comment_list['status']))?></span></span>
															<p><?=$comment_list['comment']?><br><small>Staff: <?=$comment_list['staff_username']?></small></p>
														</td>
													</tr>
												<?php
												}
											} else {
												echo '<small>History Not Available</small>';
											} ?>
										</tbody>
									</table>
								</div>
								
							</fieldset>
						  </form>
						</div>
						<div class="span1">&nbsp;</div>
                    </div>
                </section>
            </article>
        </div>
		
		<div class="row">
            <article class="span12 data-block">
				<header>
					<h2>Email/SMS History</h2>
				</header>	
                <section>
                    <div class="row-fluid">
                        <div class="span1">&nbsp;</div>
						<div class="span10">
							<div style="overflow-y:auto; max-height:350px;">
								<table class="table" width="100%">
									<tbody>
										<?php
										$inbox_mail_sms_num_rows = mysqli_num_rows($ims_query);
										if($inbox_mail_sms_num_rows>0) {
											while($inbox_mail_sms_data = mysqli_fetch_assoc($ims_query)) { ?>
												<tr>
													<td style="border-top:10px solid #ffffff;">
														<a href="controllers/order/order.php?resend_email_id=<?=$inbox_mail_sms_data['id']?>&order_mode=<?=$post['order_mode']?>" class="btn btn-alt btn-small btn-primary" onclick="return confirm('Are you sure you want to resend this email?');">Resend Email</a><br />
														
														<span><strong>Date: </strong><?=format_date($inbox_mail_sms_data['date']).' '.format_time($inbox_mail_sms_data['date'])?></span>
														<br />
														<strong>Email Subject: </strong><?=$inbox_mail_sms_data['subject']?>
														<br />
														<strong>Email Content: </strong><?=$inbox_mail_sms_data['body']?>
														<br />
														<br />
														<strong>SMS Content: </strong><?=$inbox_mail_sms_data['sms_content']?>
													</td>
												</tr>
											<?php
											}
										} else {
											echo '<tr><td>History Not Available</td></tr>';
										} ?>
									</tbody>
								</table>
							</div>
                        </div>
						<div class="span1">&nbsp;</div>
                    </div>
                </section>
            </article>
        </div>
		
		<div class="row">
            <article class="span12 data-block">
				<header>
					<h2>Payment</h2>
				</header>	
                <section>
                    <div class="row-fluid">
                        <div class="span9">
							<?php //$order_data_before_saved['paypal_address'] = 'bharat@indiaphpexpert.com';
							/*$order_data = get_order_data($order_id);
							if($order_data_before_saved['payment_method']=="paypal") {
								$exp_currency = @explode(",",$general_setting_data['currency']);
								$currency = $exp_currency[0]; ?>
								<form class="form-horizontal form-groups-bordered" action="payment/payments.php" method="post" id="paypal_form" target="_blank">
									<input type="hidden" name="cmd" value="_xclick" />
									<input type="hidden" name="currency_code" value="<?=$currency?>" />
									<input type="hidden" name="payer_email" value="" />
									<input type="hidden" name="business" value="<?=$order_data_before_saved['paypal_address']?>" />
									<input type="hidden" name="item_number" value="<?=$order_id?>" />
									<input type="hidden" name="no_shipping" value="1" />
									<input type="hidden" name="amount" value="<?=$total_of_order?>" />
									<input type="hidden" name="order_mode" id="order_mode" value="<?=$post['order_id']?>">
									<div class="form-actions">
										<button class="btn btn-alt btn-large btn-primary" type="submit" name="update">Pay Now</button>
									</div>
								</form>
							<?php
							}*/ ?>

							<form action="controllers/order/order.php" role="form" method="post" class="form-horizontal form-groups-bordered" onSubmit="return check_form(this);" enctype="multipart/form-data">
								<div class="control-group">
									<label class="control-label" for="input">Price Amount</label>
									<div class="controls">
										<input type="number" class="input-xlarge" id="payment_paid_amount" value="<?=($order_data['payment_paid_amount']>0?$order_data['payment_paid_amount']:$total_of_order)?>" name="payment_paid_amount" readonly="">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="input">Transaction/Reference ID</label>
									<div class="controls">
										<input type="text" class="input-xlarge" id="transaction_id" name="transaction_id" value="<?=$order_data['transaction_id']?>">
									</div>
								</div>
								<?php
								if($order_data_before_saved['payment_method']=="paypal") { ?>
									<div class="control-group">
										<label class="control-label" for="fileInput">Payment Receipt</label>
										<div class="controls">
											<div class="fileupload fileupload-new" data-provides="fileupload">
												<div class="input-append">
													<div class="uneditable-input">
														<i class="icon-file fileupload-exists"></i>
														<span class="fileupload-preview"></span>
													</div>
													<span class="btn btn-alt btn-file">
															<span class="fileupload-new">Select</span>
															<span class="fileupload-exists">Change</span>
															<input type="file" class="form-control" id="payment_receipt" name="payment_receipt" onChange="checkFile(this)">
													</span>
													<a href="javascript:void(0);" class="btn btn-alt btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a>
												</div>
											</div>
											<div class="clearfix">
												<div class="fileupload-multi">
												<?php 
												if($order_data['payment_receipt']!="") { ?>
													<div><img src="../images/payment/<?=$order_data['payment_receipt']?>" width="100" height="100" /> 
													<a class="btn btn-alt btn-danger" href="controllers/order/order.php?d_p_id=<?=$order_id?>&mode=payment_receipt&order_mode=<?=$post['order_mode']?>" onclick="return confirm('Are you sure to delete payment receipt?');">Delete</a></div>
												<?php 
												} ?>
												</div>
											</div>	 
										</div>
									</div>
								<?php
								} else if($order_data_before_saved['payment_method']=="bank") { ?>
									<div class="control-group">
										<label class="control-label" for="fileInput">Payment Receipt</label>
										<div class="controls">
											<div class="fileupload fileupload-new" data-provides="fileupload">
												<div class="input-append">
													<div class="uneditable-input">
														<i class="icon-file fileupload-exists"></i>
														<span class="fileupload-preview"></span>
													</div>
													<span class="btn btn-alt btn-file">
															<span class="fileupload-new">Select</span>
															<span class="fileupload-exists">Change</span>
															<input type="file" class="form-control" id="payment_receipt" name="payment_receipt" onChange="checkFile(this)">
													</span>
													<a href="javascript:void(0);" class="btn btn-alt btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a>
												</div>
											</div>
											<div class="clearfix">
												<div class="fileupload-multi">
												<?php 
												if($order_data['payment_receipt']!="") { ?>
													<div><img src="../images/payment/<?=$order_data['payment_receipt']?>" width="100" height="100" /> 
													<a class="btn btn-alt btn-danger" href="controllers/order/order.php?d_p_id=<?=$order_id?>&mode=payment_receipt&order_mode=<?=$post['order_mode']?>" onclick="return confirm('Are you sure to delete payment receipt?');">Delete</a></div>
												<?php 
												} ?>
												</div>
											</div>	 
										</div>
									</div>
								<?php
								} else if($order_data_before_saved['payment_method']=="cheque") { ?>
									<div class="control-group">
										<label class="control-label" for="fileInput">Payment Receipt</label>
										<div class="controls">
											<div class="fileupload fileupload-new" data-provides="fileupload">
												<div class="input-append">
													<div class="uneditable-input">
														<i class="icon-file fileupload-exists"></i>
														<span class="fileupload-preview"></span>
													</div>
													<span class="btn btn-alt btn-file">
															<span class="fileupload-new">Select</span>
															<span class="fileupload-exists">Change</span>
															<input type="file" class="form-control" id="payment_receipt" name="payment_receipt" onChange="checkFile(this)">
													</span>
													<a href="javascript:void(0);" class="btn btn-alt btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a>
												</div>
											</div>
											<div class="clearfix">
												<div class="fileupload-multi">
												<?php 
												if($order_data['payment_receipt']!="") { ?>
													<div><img src="../images/payment/<?=$order_data['payment_receipt']?>" width="100" height="100" /> 
													<a class="btn btn-alt btn-danger" href="controllers/order/order.php?d_p_id=<?=$order_id?>&mode=payment_receipt&order_mode=<?=$post['order_mode']?>" onclick="return confirm('Are you sure to delete payment receipt?');">Delete</a></div>
												<?php 
												} ?>
												</div>
											</div>	 
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="fileInput">Cheque Photo(optional)</label>
										<div class="controls">
											<div class="fileupload fileupload-new" data-provides="fileupload">
												<div class="input-append">
													<div class="uneditable-input">
														<i class="icon-file fileupload-exists"></i>
														<span class="fileupload-preview"></span>
													</div>
													<span class="btn btn-alt btn-file">
															<span class="fileupload-new">Select</span>
															<span class="fileupload-exists">Change</span>
															<input type="file" class="form-control" id="cheque_photo" name="cheque_photo" onChange="checkFile(this)">
													</span>
													<a href="javascript:void(0);" class="btn btn-alt btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a>
												</div>
											</div>
											<div class="clearfix">
												<div class="fileupload-multi">
												<?php 
												if($order_data['cheque_photo']!="") { ?>
													<div><img src="../images/payment/<?=$order_data['cheque_photo']?>" width="100" height="100" /> 
													<a class="btn btn-alt btn-danger" href="controllers/order/order.php?d_p_id=<?=$order_id?>&mode=cheque_photo&order_mode=<?=$post['order_mode']?>" onclick="return confirm('Are you sure to delete cheque photo?');">Delete</a></div>
												<?php 
												} ?>
												</div>
											</div>	 
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="input">Check Number</label>
										<div class="controls">
											<input type="text" class="input-xlarge" id="check_number" value="<?=$order_data['check_number']?>" name="check_number">
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="input">Bank Name</label>
										<div class="controls">
											<input type="text" class="input-xlarge" id="bank_name" value="<?=$order_data['bank_name']?>" name="bank_name">
										</div>
									</div>
								<?php
								} ?>
								
								<div class="control-group">
									<div class="controls">
										<label class="checkbox custom-checkbox">
											<input id="is_payment_sent" type="checkbox" value="1" name="is_payment_sent" <?php if($order_data['is_payment_sent']=='1'){echo 'checked="checked"';}?> <?php if($order_data_before_saved['status']!='completed'){echo 'disabled="disabled"';}?>>
											Mark Payment Sent
										</label>
									</div>
									<?php
									if($order_data['is_payment_sent']=='1') { ?>
									<div class="controls">
										<strong>Payment Date:</strong> <?=format_date($order_data['payment_sent_date']).' '.format_time($order_data['payment_sent_date'])?>
									</div>
									<?php
									} ?>
								</div>
								
								<div class="form-actions">
									<button class="btn btn-alt btn-large btn-primary" type="submit" name="save">Save</button>
									<a href="<?=$back_url?>" class="btn btn-alt btn-large btn-black">Back</a>
								</div>
								<input type="hidden" name="order_id" id="order_id" value="<?=$post['order_id']?>" />
								<input type="hidden" name="order_mode" id="order_mode" value="<?=$post['order_mode']?>">
							</form>
                        </div>
                    </div>
                </section>
            </article>
        </div>	
    </section>
	<div id="push"></div>
</div>

<div class="modal primary fade" id="import_modal" style="width:625px;">
	<div class="modal-dialog">
		<div class="modal-content">

			<!-- Modal header -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title">Edit Model</h3>
			</div>
			<!-- /Modal header -->

			<form action="controllers/order/order.php" method="POST" class="form-inline no-margin" onSubmit="return check_edit_order_form(this);" enctype="multipart/form-data">
				<!-- Modal body -->
				<div class="modal-body model_form_data">
					<fieldset>
						<div class="control-group">
							<label class="control-label" for="input">Select Model</label>
							<div class="controls">
								
							</div>
						</div>
					</fieldset>
				</div>
				<!-- /Modal body -->
				
				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="submit" name="sell_this_device" id="sell_this_device" class="btn btn-alt btn-large btn-primary">Update</button>
					<button type="button" class="btn btn-alt btn-large btn-black" data-dismiss="modal">Close</button>
				</div>
				<!-- /Modal footer -->
				
				<input type="hidden" name="order_mode" id="order_mode" value="<?=$post['order_mode']?>">
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
function check_form(a) {
	<?php
	if($order_data_before_saved['status']!='completed') { ?>
		alert('Your order status is not completed so you can not mark payment sent.');
		return false;
	<?php
	} ?>

	if(a.is_payment_sent.checked==false) {
		alert('Mark Payment Sent Checkbox Must Be Checked');
		return false;
	}
}

function checkFile(fieldObj) {
	if(fieldObj.files.length == 0) {
		return false;
	}
	
	var id = fieldObj.id;
	var str  = fieldObj.value;
	var FileExt = str.substr(str.lastIndexOf('.')+1);
	var FileExt = FileExt.toLowerCase(); 
	var FileSize = fieldObj.files[0].size;
	var FileSizeMB = (FileSize/10485760).toFixed(2);

	if((FileExt != "gif" && FileExt != "png" && FileExt != "jpg" && FileExt != "jpeg")){
		var error = "Please make sure your file is in png | jpg | jpeg | gif format.\n\n";
		alert(error);
		document.getElementById(id).value = '';
		return false;
	}
}
	
function EditOrder(item_id) {
	if(item_id>0) {
		post_data = "item_id="+item_id;
		jQuery(document).ready(function($) {
			$.ajax({
				type: "POST",
				url:"ajax/get_model_data.php",
				data:post_data,
				success:function(data){
					if(data!="") {
						$('.model_form_data').html(data);
					}
				}
			});
			$('#import_modal').modal({backdrop: 'static',keyboard: false});
		});
	}
	
	jQuery(document).ready(function($) {
		$('#import_modal').modal({backdrop: 'static',keyboard: false});
	});
}

function iCloudOrderItem(item_id) {
	if(item_id>0) {
		$("#icloud_status_loading"+item_id).show();
		post_data = "item_id="+item_id;
		jQuery(document).ready(function($) {
			$.ajax({
				type: "POST",
				url:"ajax/check_icloud_data.php",
				data:post_data,
				success:function(data){
					if(data!="") {
						var form_data = JSON.parse(data);
						$("#icloud_status_loading"+item_id).hide();
						if(form_data.status == true && form_data.icloud_status!="error") {
							$("#icloud_status"+item_id).html('<strong>'+form_data.icloud_status+'</strong>');
						} else if(form_data.status == false && form_data.icloud_status=="error") {
							$("#icloud_status"+item_id).html(form_data.message);
						} else {
							//alert(form_data.message);
							return false;
						}
					}
				}
			});
		});
	}
}

function ChangeOrderStatus(status) {
	if(status!="") {
		post_data = "status="+status;
		jQuery(document).ready(function($) {
			$.ajax({
				type: "POST",
				url:"ajax/get_email_template_list.php",
				data:post_data,
				success:function(data){
					if(data!="") {
						$('#email_template_list').html(data);
						$('.showhide_email_template_list').show();
					} else {
						$('#email_template_list').html('');
						$('.showhide_email_template_list').hide();
					}
				}
			});
		});
	}
}
ChangeOrderStatus('<?=$order_data_before_saved['status']?>');

function ChangeEmailTemplate(id) {
	if(id!="") {
		post_data = "id="+id+'&order_id=<?=$post['order_id']?>';
		jQuery(document).ready(function($) {
			$.ajax({
				type: "POST",
				url:"ajax/get_email_template_content.php",
				data:post_data,
				success:function(data){
					if(data!="") {
						$('#email_template_content').html(data);
					}
				}
			});
		});
	}
}

jQuery(document).ready(function ($) {
	$('.item_price').bind("keyup mouseup",function() {
		var promocode_amt = '<?=$promocode_amt?>';
		var item_price = 0.00;
		$('.item_price').each(function() {
			item_price += parseFloat(this.value);
		});
		
		$("#item_price_total").html('<?=$amount_sign_with_prefix?>'+item_price.toFixed(2)+'<?=$amount_sign_with_postfix?>');
		if(promocode_amt>0) {
			promocode_amt = parseFloat(promocode_amt);
			var price_f_total = (item_price+promocode_amt);
			$("#price_f_total").html('<?=$amount_sign_with_prefix?>'+price_f_total.toFixed(2)+'<?=$amount_sign_with_postfix?>');
		}
	});
});

jQuery('#comment').on('blur keypress', function(e) {
	var keycode = (e.keyCode ? e.keyCode : e.which);
	if(keycode == '13' || e.type === 'blur'){
		var post_data = $('.comment_form').serialize();
		jQuery.ajax({
			type: "POST",
			url:"ajax/ajax_send_comment.php",
			data:post_data,
			success:function(data) {
				if(data!="") {
					var form_data = JSON.parse(data);
					if(form_data.status == true) {
						if(form_data.is_comment == "yes") {
							var message = '';
							message += '<tr>';
								message += '<td>';
									//message += '<img src="img/admin_avatar.png" width="15">';
									message += '<span>'+form_data.date;
									if(form_data.c_status!="") {
										message += ' <span class="label label-success">'+form_data.c_status+'</span>';
									}
									message += '</span>';
									message += '<p>'+form_data.comments+'<br><small>Staff: '+form_data.staff_username+'</small></p>';
								message += '</td>';
							message += '</tr>';
							$('.apd-chat-message').prepend(message);
							$('#comment').val('');
						}
					} else {
						//alert(form_data.message);
						return false;
					}
				}
			}
		});
	}
});

function PrintOrderItem(item_id) {
	if(item_id>0) {
		var url = "print_order_item.php?order_id=<?=$order_id?>&item_id="+item_id;
		window.open(url,"Loading",'toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=960,height=960');
	} else {
		alert("Something went wrong!!!");
	}
}
</script>