<?php
//Header section
include("include/header.php");

//Fetching data from model
require_once('models/mobile.php');

//Get order id
$order_id = $_SESSION['tmp_order_id'];

//Get order price based on orderID, path of this function (get_order_price) admin/include/functions.php
$sum_of_orders = get_order_price($order_id);

//Get order item list based on orderID, path of this function (get_order_item_list) admin/include/functions.php
$order_item_list = get_order_item_list($order_id);
$order_num_of_rows = count($order_item_list);

//Get order batch data, path of this function (get_order_data) admin/include/functions.php
$order_data = get_order_data($order_id);

//If direct access then it will redirect to home page
//if($user_id<=0 || $order_id=="") {
if ($order_id == "") {
	setRedirect(SITE_URL);
	exit();
}

$payment_method = $order_data['payment_method'];
$shipment_label_url = $order_data['shipment_label_url'];
?>

<section>
	<div class="container">

		<div class="row">
			<div class="col-md-12">
				<div class="block head pb-0 mb-0 border-line text-center clearfix">
					<h1 class="h1 border-line clearfix"><?php echo $LANG['Thank You!']; ?></h1>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="block text-center order-complete clearfix">
					<h2><?php echo $LANG['We really appreciate your business']; ?></h2>
					<h3><?php echo $LANG['Your offer number is ']; ?><?php echo $LANG['Your offer number is']; ?> <strong>#<?= $order_id ?></strong></h3>
					<h4><?php echo $LANG['A copy of the information on this page has been sent to']; ?> <strong><?= strtoupper($order_data['email']) ?></strong></h4>
				</div>
			</div>
		</div>

		<?php
		if ($payment_method != "cash") { ?>
			<div class="row">
				<div class="col-md-12">
					<div class="block black-box-head text-uppercase text-center pt-0 mt-0 pb-0 mb-0 clearfix">
						<h3><?php echo $LANG['Sending your device to us']; ?></h3>
					</div>
					<div class="block black-box-content mt-0 clearfix">
						<h4 class="text-center"><?php echo $LANG['PLEASE, FOLLOW THE STEPS BELOW TO SHIP YOUR DEVICE TO US.']; ?></h4>
						<div class="black-box-block clearfix">
							<div class="row">
								<div class="col-md-4 text-center">
									<img src="images/prepare_your_device.png" alt="">
								</div>
								<div class="col-md-8">
									<h3><?php echo $LANG['PREPARE YOUR DEVICE']; ?></h3>
									<ul>
										<li><?php echo $LANG['Remove or sign out from "Find my iPhone" for Apple devices and remove']; ?> <br><?php echo $LANG['Android Activation Lock for Android devices.']; ?><a href="#" data-toggle="modal" data-target="#RemoveiCloud"><?php echo $LANG["Not sure? Here's how to proceed"]; ?></a></li>
										<li><?php echo $LANG['Remove any password protection service.']; ?></li>
										<li><?php echo $LANG['Reset device to "Factory Settings" if applicable.']; ?> <a href="#" data-toggle="modal" data-target="#RemoveGoogleAccount"><?php echo $LANG["Not sure? Here's how to proceed"]; ?></a></li>
										<li><?php echo $LANG["Fully Charge the device's battery."]; ?></li>
									</ul>
								</div>
							</div>
						</div>
						<div class="black-box-block clearfix">
							<div class="row">
								<div class="col-md-4 text-center">
									<img src="images/box.png" alt="">
								</div>
								<div class="col-md-8">
									<h3><?php echo $LANG['PACKAGE YOUR DEVICE PROPERLY']; ?></h3>
									<ul>
										<li><?php echo $LANG['Secure device properly inside its packaging to prevent damage while in transit. We recommend the use of bubble wraps and Styrofoam peanuts.']; ?></li>
										<li><?php echo $LANG['Seal the package with a durable shipping tape.']; ?></li>
										<li><?php echo $LANG['We are not accountable for any damages during shipping. This could force an offer review or lead to the cancellation of your offer.']; ?></li>
									</ul>
								</div>
							</div>
						</div>
						<div class="black-box-block clearfix">
							<div class="row">
								<div class="col-md-4 text-center">
									<img class="printer" src="images/printer.png" alt="">
								</div>
								<div class="col-md-8">
									<h3><?php echo $LANG['SHIPPING YOUR DEVICE']; ?></h3>
									<ul>
										<li><?php echo $LANG['Print the prepaid shipping label below, and attach it securely with a tape to your package.']; ?></li>
										<li><?php echo $LANG['Leave us a message If you don’t have a printer, and we will mail you a printed label. You can also use the printer at a local library.']; ?></li>
										<li><?php echo $LANG['Drop off the package at the closest shipping center. Ensure that it is marked FRAGILE at the counter.']; ?>
											<!--<a href="#">USPS locations near me</a>-->
										</li>
										<li><?php echo $LANG['Your offer is guaranteed to be locked for 21 days. Be sure to ship or deliver your device within this period to avoid cancellation of your offer.']; ?></li>
									</ul>
								</div>
							</div>
						</div>
						<div class="shippping-block clearfix">
							<div class="row">
								<div class="col-md-8 offset-md-4">
									<?php /*?>views/print/print_label.php?order_id=300062<?php */ ?>
									<?php /*?> <a href="<?=($shipment_label_url?SITE_URL.'controllers/download.php?download_link='.$shipment_label_url:'#')?>" class="btn"><?php */ ?>
									
									<?php
									if($order_data['shipment_label_custom_name']) {
										$shipment_label_url = SITE_URL.'shipment_labels/'.$order_data['shipment_label_custom_name'];
									} else {
										$shipment_label_url = $order_data['shipment_label_url'];
									} ?>
									<a href="javascript:void(0);" onclick="open_window('<?=$shipment_label_url?>');" class="btn">

									<?php /*?><a href="javascript:void(0);" onclick="open_window('<?= SITE_URL ?>views/print/print_label.php?order_id=<?= $order_id ?>');" class="btn"><?php */?>
										<img class="" src="images/usps_logo.png" alt="USPS Logo"><br /><span><?php echo $LANG['Click to print label']; ?></span>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php
		} else { ?>
			<div class="row">
				<div class="col-md-12">
					<div class="block black-box-head text-uppercase text-center pt-0 mt-0 pb-0 mb-0 clearfix">
						<h3><?php echo $LANG['GETTING CASH FOR YOUR DEVICE']; ?></h3>
					</div>
					<div class="block black-box-content mt-0 clearfix">
						<h4 class="text-center"><?php echo 'Reunase con un nuestro agente en una de nuestras oficinas autorizadas'; ?></h4>
						<div class="black-box-block clearfix">
							<div class="row">
								<div class="col-md-4 text-center">
									<img src="images/prepare_your_device.png" alt="">
								</div>
								<div class="col-md-8">
									<h3><?php echo $LANG['PREPARE YOUR DEVICE']; ?></h3>
									<ul>
										<li><?php echo $LANG['Remove or sign out from FIND MY IPHONE for Apple devices and remove ANDROID ACTIVATION LOCK for Android devices.']; ?><a href="#" data-toggle="modal" data-target="#RemoveiCloud"><?php echo $LANG["Not sure? Here's how to proceed"]; ?></a></li>
										<li><?php echo $LANG['Remove any password protection service.']; ?></li>
										<li><?php echo $LANG['Reset device to "Factory Settings" if applicable.']; ?> <a href="#" data-toggle="modal" data-target="#RemoveGoogleAccount"><?php echo $LANG["Not sure? Here's how to proceed"]; ?></a></li>
										<li><?php echo $LANG['Fully Charge the device\'s battery.']; ?></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php
		}

		/*echo '<pre>';
	  print_r($order_data);
	  echo '</pre>';*/ ?>

		<div class="row">
			<div class="col-md-12">
				<div class="block yellow-box-head text-uppercase text-center pt-0 mt-0 pb-0 mb-0 clearfix">
					<h3><?php echo $LANG['offer details']; ?></h3>
				</div>
				<div class="block offer-box mt-0 pt-0 mb-0 pb-0 clearfix">
					<div class="row">
						<div class="col-md-3">
							<div class="inner p-3 clearfix">
								<h3><?php echo $LANG['Contact Information']; ?></h3>
								<p>
									<strong><?= $order_data['name'] ?></strong>
									<?php
									if ($order_data['address']) {
										echo '<br>' . $order_data['address'] . '<br>' . $order_data['city'] . ', ' . $order_data['state'] . ' ' . $order_data['postcode'];
									} ?>
								</p>
								<a  style="word-wrap:break-word;" href="emailto:<?= $order_data['email'] ?>"><?= $order_data['email'] ?></a><br />
								<a href="tel:<?= $order_data['phone'] ?>"><?= $order_data['phone'] ?></a>
								<?php /*?><p><strong><?=$company_name?></strong><br><?=$company_address?><br><?=$company_city.', '.$company_state.' '.$company_zipcode?></p>
                      <a href="emailto:<?=$site_email?>"><?=$site_email?></a><br />
                      <a href="tel:<?=$site_phone?>"><?=$site_phone?></a><?php */ ?>
								<h3 class="pt-5"><?php echo $LANG['Additional Information']; ?></h3>
								<h4><?php echo $LANG['offer Date/Time']; ?></h4>
								<p><?= format_date($order_data['date']) . ' ' . format_time($order_data['date']) . ' ' . $customer_timezone ?></p>
								<h4 class="pt-2"><?php echo $LANG['Payment Preference']; ?></h4>
								<p><?= ucwords($order_data['payment_method']) ?>
									<!--<a class="btn btn-secondary btn-sm" href="#">Edit</a>-->
								</p>
                                <?php if ($payment_method == "cash") {?> 
								    <h4 class="pt-2"><?php echo $LANG['LOCATION']; ?></h4>
								    <p><?= $order_data['cash_location_name'] ?> </p>
							    <?php
								  } ?>
							</div>
						</div>
						<div class="col-md-9">
							<h3 class="text-uppercase text-center offer-head pt-5"><?php echo $LANG['offer #']; ?><?= $order_id ?></h3>
							<?php
                            if ($payment_method != "cash") { ?>
							    <h6 class="text-center"><?php echo $LANG['You may cancel your trade-in offer up until your device is delivered to us.']; ?></h6>
							<?php
							} else { ?>
							    <h6 class="text-center"><?php echo $LANG['You may cancel your trade-in offer up until we have paid you.']; ?></h6>
							<?php
							} ?>
							
							<div class="block m-0 p-0 pb-5 cart-page clearfix">
								<table class="table">
									<tr>
										<th class="details"><?php echo $LANG['Details']; ?></th>
										<th class="quantity"><?php echo $LANG['Quantity']; ?></th>
										<th class="price"><?php echo $LANG['Value']; ?></th>
									</tr>
									<?php
									$tid = 1;
									foreach ($order_item_list as $order_item_list_data) {
										$model_data = get_single_model_data($order_item_list_data['model_id']);
										$mdl_details_url = SITE_URL . $model_data['sef_url'] . '/' . createSlug($model_data['title']) . '/' . $model_data['id'] . ($order_item_list_data['storage'] ? '/' . intval($order_item_list_data['storage']) : '');

										//path of this function (get_order_item) admin/include/functions.php
										$order_item_data = get_order_item($order_item_list_data['id'], 'list'); ?>
										<tr>
											<td class="details">
												<div class="row">
													<div style="padding-left: 0px; padding-right: 0px;" class="col-md-1 col-3">
														<?php
														if ($order_item_list_data['model_img']) {
															echo '<img src="' . SITE_URL . 'images/mobile/' . $order_item_list_data['model_img'] . '"/>';
														} ?>
													</div>
													<div class="col-md-11  col-9">
														<?php
														echo '<h3>' . $order_item_data['device_title'] . '</h3>';
														if ($order_item_data['device_info']) {
															echo '<h4>' . $order_item_data['device_info'] . '</h4>';
														}
														if ($order_item_data['data']['imei_number']) {
															echo '<h4><span> IMEI:</span> ' . $order_item_data['data']['imei_number'] . '</h4>';
														} ?>
														<!--<p><a href="<?= $mdl_details_url ?>?item_id=<?= $order_item_list_data['id'] ?>" class="btn btn-secondary btn-sm">Edit</a><a href="controllers/revieworder/review.php?rorder_id=<?= $order_item_list_data['id'] ?>" class="btn btn-sm btn-remove" onclick="return confirm('Are you sure you want to remove this item ?');">Remove</a></p>-->
													</div>
												</div>
											</td>
											<td class="quantity">
												<input type="text" class="form-control" id="qty-<?= $tid ?>" name="qty[<?= $order_item_list_data['id'] ?>]" value="<?= $order_item_list_data['quantity'] ?>" readonly="">
											</td>
											<td class="price">
												<?= amount_fomat($order_item_list_data['price']) ?>
											</td>
										</tr>
										<?php
										$tid++;
									} ?>
								</table>
								<div class="divider clearfix"></div>
								<div class="row">
									<div class="col-md-6">
										<div class="block head cart-saerch-page cart-order-page text-center clearfix">
											<div class="h1 border-line mt-4"><?php echo $LANG['Want to Sell More?']; ?></div>
											<form class="form-inline" action="<?= SITE_URL ?>search" method="post">
												<div class="form-group">
													<input type="text" class="form-control srch_list_of_model" name="search" id="staticEmail2" placeholder="<?php echo $LANG["Search device here"]; ?>">
												</div>
												<button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
											</form>
										</div>
									</div>
									<div class="col-md-6">
										<div class="block cart-summary clearfix">
											<h3><?php echo $LANG['Summary']; ?></h3>

											<?php
											$express_service = $order_data['express_service'];
											$express_service_price = $order_data['express_service_price'];
											$shipping_insurance = $order_data['shipping_insurance'];
											$shipping_insurance_per = $order_data['shipping_insurance_per'];

											$f_express_service_price = 0;
											$f_shipping_insurance_price = 0;
											if ($express_service == '1') {
												$f_express_service_price = $express_service_price;
											}
											if ($shipping_insurance == '1') {
												$f_shipping_insurance_price = ($sum_of_orders * $shipping_insurance_per / 100);
											}

											if ($f_express_service_price > 0 || $f_shipping_insurance_price > 0) { ?>
												<div class="row">
													<div class="col-7">
														<h4 class="pb-0"><?php echo $LANG['Offer Total']; ?></h4>
													</div>
													<div class="col-5">
														<span class="pb-0"><?= amount_fomat($sum_of_orders) ?></span>
													</div>
												</div>
											<?php
											} ?>
											<?php
                                            if ($payment_method != "cash") { ?>
    											<div class="row">
    												<div class="col-7">
    													<h4 class="pb-0"><?php echo $LANG['Priority Shipping']; ?></h4>
    												</div>
    												<div class="col-5">
    													<span class="pb-0"><?php echo $LANG['FREE']; ?></span>
    												</div>
    											</div>
    										<?php
                                            }?>
											<?php
											if ($f_express_service_price > 0 || $f_shipping_insurance_price > 0) {
												if ($f_express_service_price > 0) { ?>
													<div class="row">
														<div class="col-7">
															<h4 class="pb-0"><?php echo $LANG['Express Service']; ?></h4>
														</div>
														<div class="col-5">
															<span class="pb-0">-<?= amount_fomat($f_express_service_price) ?></span>
														</div>
													</div>
												<?php
												}

												if ($f_shipping_insurance_price > 0) { ?>
													<div class="row">
														<div class="col-7">
															<h4 class="pb-0"><?php echo $LANG['Shipping Insurance']; ?></h4>
														</div>
														<div class="col-5">
															<span class="pb-0">-<?= amount_fomat($f_shipping_insurance_price) ?></span>
														</div>
													</div>
												<?php
												}
											} ?>
											
											<?php
                                            if ($payment_method != "cash") { ?>
											    <div class="border-divider pb-3 clearfix"></div>
											<?php
                                            }?>
											<div class="row">
												<div class="col-6">
													<h4><?php echo $LANG['Total Payment']; ?></h4>
												</div>
												<div class="col-6">
													<span class="totla-price"><?= amount_fomat(($sum_of_orders - $f_express_service_price - $f_shipping_insurance_price)) ?></span>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12">
													<a class="btn btn-danger btn-lg btn-checkout float-right" href="<?= SITE_URL ?>controllers/order/order.php?order_id=<?= $order_id ?>&mode=del2" onclick="return confirm('Are you sure you want to cancel this order?');"><?php echo $LANG['CANCEL ORDER']; ?></a>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="block head cart-saerch-page mobile-only text-center clearfix">
											<div class="h1 border-line mt-4"><?php echo $LANG['Want to Sell More?']; ?></div>
											<form class="form-inline" action="<?= SITE_URL ?>search" method="post">
												<div class="form-group">
													<input type="text" class="form-control srch_list_of_model" name="search" id="staticEmail2" placeholder="<?php echo $LANG["Search device here"]; ?>">
												</div>
												<button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class=" pb-5 mb-5 clearfix"></div>
	</div>
</section>

<div class="modal fade" id="RemoveiCloud" tabindex="-1" role="dialog" aria-labelledby="RemoveiCloudTitle" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="RemoveiCloudTitle"><strong><?php echo $LANG['REMOVING YOUR ACCOUNTS']; ?></strong></h5>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">×</span>
		  </button>
		</div>
		<div class="modal-body">
		  <p><?php echo $LANG['Please visit']; ?><a href="https://support.apple.com/en-gb/HT201351" target="_blank"> <?php echo $LANG['this link']; ?></a> <?php echo $LANG['for steps to remove your Apple ID/iCloud account']; ?></p>
		  <p><?php echo $LANG['Please visit']; ?> 
		  <a href="https://support.google.com/nexus/answer/7664951?hl=en-GB" target="_blank"><?php echo $LANG['this link']; ?></a> <?php echo $LANG['for steps to remove your Google account']; ?></p>
		</div>
	  </div>
	</div>
</div>

<div class="modal fade" id="RemoveGoogleAccount" tabindex="-1" role="dialog" aria-labelledby="RemoveGoogleAccountTitle" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="RemoveGoogleAccountTitle"><strong><?php echo $LANG['FACTORY RESET YOUR DEVICE']; ?></strong></h5>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">×</span>
		  </button>
		</div>
		<div class="modal-body">
		  <p><?php echo $LANG['Please visit']; ?> 
		  <a href="https://support.apple.com/en-gb/HT201351" target="_blank"><?php echo $LANG['this link']; ?></a> <?php echo $LANG['for steps to factory reset your iOS device']; ?></p>
		  <p><?php echo $LANG['Please visit']; ?> 
		  <a href="https://support.google.com/nexus/answer/6088915?hl=en" target="_blank"><?php echo $LANG['this link']; ?></a> <?php echo $LANG['for steps to factory reset your android device']; ?></p>
		  <p><?php echo $LANG['For laptops, simply remove all user accounts, passwords and any important data before send it to us. We will take care of the factory reset when we receive it.']; ?></p>
		</div>
	  </div>
	</div>
</div>

<script>
function open_window(url) {
	apply = window.open(url, "Loading", 'toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=800,height=800');
}
</script>