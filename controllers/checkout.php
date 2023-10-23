<?php

require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");
require_once("../lang/spanish.php");

if (isset($post['submit_form'])) {
	if (empty($_POST)) {
		$msg = 'Direct access denied';
		setRedirectWithMsg(SITE_URL, $msg, 'danger');
		exit();
	}

	$user_id = $_SESSION['user_id'];
	$order_id = $_SESSION['order_id'];

	$order_data_before_saved = get_order_data($order_id);

	$order_item_ids = $_SESSION['order_item_ids'];
	if (empty($order_item_ids)) {
		$order_item_ids = array();
	}

	//Get order price based on orderID, path of this function (get_order_price) admin/include/functions.php
	$sum_of_orders = get_order_price($order_id);

	$num_of_item = $post['num_of_item'];
	if ($num_of_item != count($order_item_ids)) {
		setRedirect(SITE_URL . 'revieworder');
		exit();
	}

	$date = date('Y-m-d');
	$datetime = date('Y-m-d H:i:s');

	if ($post['user_id'] > 0) {
		$user_id = $post['user_id'];
	}

	$payment_method = $post['payment_method'];
	$name = real_escape_string($post['name']);
	$phone = preg_replace("/[^\d]/", "", real_escape_string($post['phone']));
	$address = real_escape_string($post['address']);
	$address2 = real_escape_string($post['address2']);
	$city = real_escape_string($post['city']);
	$state = real_escape_string($post['state']);
	$country = real_escape_string($post['country']);
	$postcode = real_escape_string($post['postcode']);
	$shipping_method = $post['shipping_method'];
	$occasional_special_offers = $post['occasional_special_offers'];
	$important_sms_notifications = $post['important_sms_notifications'];
	$customer_timezone_data = get_customer_timezone();
	$customer_timezone = $customer_timezone_data['timezone'];

	$cash_name = real_escape_string($post['cash_name']);
	$cash_phone = preg_replace("/[^\d]/", "", real_escape_string($post['f_cash_phone']));
	$cash_location = real_escape_string($post['cash_location']);
	if ($name == "" && $phone == "") {
		$name = $cash_name;
		$phone = $cash_phone;
	}
	$temp_arr = strtolower($name) . ";";
	$temp_arr = preg_split("/[\s*]/", $temp_arr);
	$hold = "";
	foreach ($temp_arr as $str) {
		$hold .= ucfirst($str) . " ";
	}
	$name = trim(preg_replace("/\;/", "", $hold));

	$express_service = $post['express_service'];
	$express_service_price = ($sum_of_orders * 2.5 / 100);
	$shipping_insurance = $post['shipping_insurance'];
	$shipping_insurance_per = 1.5;

	$f_express_service_price = 0;
	$f_shipping_insurance_price = 0;
	if ($express_service == '1') {
		$f_express_service_price = $express_service_price;
	}
	if ($shipping_insurance == '1') {
		$f_shipping_insurance_price = ($sum_of_orders * $shipping_insurance_per / 100);
	}

	if ($payment_method == "") {
		$msg = 'Please fill mandatory fields';
		setRedirectWithMsg(SITE_URL . 'checkout', $msg, 'error');
		exit();
	}

	if ($user_id <= 0 || $user_id == '') {
		$msg = 'You must signin first.';
		setRedirectWithMsg(SITE_URL . 'checkout', $msg, 'error');
		exit();
	} elseif ($user_id > 0) {
		mysqli_query($db, "UPDATE `users` SET `occasional_special_offers`='" . $occasional_special_offers . "', `important_sms_notifications`='" . $important_sms_notifications . "' WHERE id='" . $user_id . "'");
		if ($name && $phone) {
			mysqli_query($db, "UPDATE `users` SET `name`='" . $name . "',`phone`='" . $phone . "' WHERE id='" . $user_id . "'");
		}
		if ($address && $postcode) {
			mysqli_query($db, "UPDATE `users` SET `address`='" . $address . "',`address2`='" . $address2 . "',`city`='" . $city . "',`state`='" . $state . "',`postcode`='" . $postcode . "' WHERE id='" . $user_id . "'");
		}

		//Get user data based on userID
		$user_data = get_user_data($user_id);

		$temp_arr = strtolower($user_data['name']) . ";";
		$temp_arr = preg_split("/[\s*]/", $temp_arr);
		$hold = "";
		foreach ($temp_arr as $str) {
			$hold .= ucfirst($str) . " ";
		}
		$user_data['name'] = trim(preg_replace("/\;/", "", $hold));

		//START post shipment by easypost API
		if ($payment_method != "cash" && $shipping_api == "easypost" && $shipment_generated_by_cust == '1' && $shipping_api_key != "") {

			$msg = 'Se acaba de enviar unas instrucciones via email a su bandeja de entrada para completar el pago via email';
			setRedirectWithMsg(SITE_URL . 'order-comlete', $msg, 'success');
		} else {
			$shipment_id = '';
			$shipment_tracking_code = '';
			$shipment_label_url = '';
			$shipment_label_custom_name = '';
		} //END post shipment by easypost API

		$total = $sum_of_orders;

		$approved_date = ",approved_date='" . $datetime . "'";
		$expire_date = ",expire_date='" . date("Y-m-d H:i:s", strtotime($datetime . " +" . $order_expired_days . " day")) . "'";


		$order_status = "awaiting_shipment";
		if ($payment_method == "cash") {
			$order_status = "submitted";
		}

		$upt_order_query = mysqli_query($db, "UPDATE `orders` SET `payment_method`='" . $payment_method . "', paypal_address='" . real_escape_string($post['paypal_address']) . "', chk_name='" . real_escape_string($post['chk_name']) . "', chk_street_address='" . real_escape_string($post['chk_street_address']) . "', chk_street_address_2='" . real_escape_string($post['chk_street_address_2']) . "', chk_city='" . real_escape_string($post['chk_city']) . "', chk_state='" . real_escape_string($post['chk_state']) . "', chk_zip_code='" . real_escape_string($post['chk_zip_code']) . "', act_name='" . real_escape_string($post['act_name']) . "', act_number='" . real_escape_string($post['act_number']) . "', act_short_code='" . real_escape_string($post['act_short_code']) . "', `user_id`='" . $user_id . "', `status`='" . $order_status . "', `date`='" . $datetime . "', `sales_pack`='" . $shipping_method . "', shipping_api='" . $shipping_api . "', shipment_id='" . $shipment_id . "', shipment_tracking_code='" . $shipment_tracking_code . "', shipment_label_url='" . $shipment_label_url . "', shipment_label_custom_name='" . $shipment_label_custom_name . "', promocode_id='" . $promocode_id . "', promocode='" . $promo_code . "', promocode_amt='" . $discount_of_amt . "', discount_type='" . $promo_code_data['discount_type'] . "', discount='" . $discount . "', cash_name='" . $cash_name . "', cash_phone='" . $cash_phone . "', cash_location='" . $cash_location . "', zelle_email='" . real_escape_string($post['zelle_email']) . "', express_service='" . $express_service . "', express_service_price='" . $express_service_price . "', shipping_insurance='" . $shipping_insurance . "', shipping_insurance_per='" . $shipping_insurance_per . "'" . $approved_date . $expire_date . " WHERE order_id='" . $order_id . "'");
		if ($upt_order_query == '1') {
			//START append order items to block
			//Get order item list based on orderID, path of this function (get_order_item_list) admin/include/functions.php
			$order_item_list = get_order_item_list($order_id);

			foreach ($order_item_ids as $orderItemId) {
				//path of this function (get_order_item) admin/include/functions.php
				$order_item_data = get_order_item_1($orderItemId, 'email');

				$query = mysqli_query($db, "SELECT sef_url FROM `devices` WHERE title ='" . $order_item_data['device_title'] . "'");
				$arr = mysqli_fetch_assoc($query);
				$slug1 = $arr['sef_url'];
				$query = mysqli_query($db, "SELECT id FROM `mobile` WHERE title ='" . $order_item_data['model_title'] . "'");
				$arr = mysqli_fetch_assoc($query);
				$slug2 = $arr['id'];

				$order_list .= '<table width="100%" cellspacing="0" cellpadding="0" style="padding:10px 0px; margin-top: 20px;">
                                                    <tbody>
                                                        <tr>
                                                            <td style="font-family:\'Montserrat\',Helvetica,Roboto,Arial,sans-serif; width:100px" align="left" valign="top">' .
					'<a href="' . SITE_URL . $slug1 . '/' . createSlug($order_item_data['model_title']) . '/' . $slug2 . '" rel="noreferrer" target="_blank" >' . '<img src="' . SITE_URL . 'libraries/phpthumb.php?imglocation=' . SITE_URL . 'images/mobile/' . $order_item_data['model_img'] . '&h=64 &w=64" style="border-radius:6px;background:#ffffff;padding:5px;border:1px solid #ddd;margin-right:0.5rem" alt="' . $order_item_data['model_title'] . ' device image"></a>' .
					'</td>
                                                            <td valign="top" align="left" style = "font-family:\'Montserrat\',Helvetica,Roboto,Arial,sans-serif; font-size:15px;">
                                                                <strong>' . $order_item_data['device_title'] . ' - ' . $order_item_data['model_title'] . '</strong><br><br>'
					. $order_item_data['device_info'] .
					'</td>                                                                                                   
                                                        </tr>
                                					</tbody>
                                				</table>';


				$order_list .=
					'<table width="100%" cellspacing="0" cellpadding="0" style="margin-bottom: 20px; margin-top: 20px;">
                                                    <tbody>
                                                        <tr>
                                                            <td align="left" style="font-family:\'Montserrat\',Helvetica,Roboto,Arial,sans-serif; width:60%; padding-left:100px;" valign="bottom">
                                                                <table  cellspacing="0" cellpadding="0">
                                                                    <tbody>
                                                                       <tr>
                                                                            <td  Valign="middle" style="font-family:\'Montserrat\',Helvetica,Roboto,Arial,sans-serif; text-align:center; padding: 1em 1.5em; background:#e9e9e9; border: 1px solid #b2b4b6; border-radius: 5px; color:#555">' . $order_item_data['quantity'] . '
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                                                                                                                                    
                                                            </td>';
				if ($hide_device_order_valuation_price != '1') {
					$order_list .=
						'<td align="right" style="font-family:\'Montserrat\',Helvetica,Roboto,Arial,sans-serif; width:40%; padding:0;text-align:right" valign="middle">
                                                                                                                                                                               
                                                                <table  align="right" cellspacing="0" cellpadding="0" >
                                                                    <tbody>
                                                                        <tr>
                                                                            <td Valign="middle" style="font-family:\'Montserrat\',Helvetica,Roboto,Arial,sans-serif; text-align:right;"><strong>' . amount_fomat($order_item_data['price']) . '</strong>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>';
				}
				$order_list .= '</tr>
                                					</tbody>
                                				</table> 
                                                <hr style="display:block;width:100%;height:1px;background:#9b9b9b;border:none">';
			} //END append order items to block 



			$visitor_body .= '<table width="100%" cellspacing="0" cellpadding="0" style="font-size:16px; margin-top: 15px;">
					<tbody>
						<tr>
							<td align="left" style="width:100%;padding-top:5px;padding-bottom:0px;"> 
								<table width="100%" cellspacing="0" cellpadding="10" style="background:#8bb927;border:none; text-align:center;">
									<tbody>
										<tr>
											<td valign="middle" style="font-family:\'Montserrat\',Helvetica,Roboto,Arial,sans-serif; line-height:1; width:100%;">';
			if ($payment_method != "cash") {
				$visitor_body .=
					'<p style="text-decoration:none;color:#000000;font-size:16px;"><strong>SENDING YOUR DEVICE TO US</strong></p>';
			} else {
				$visitor_body .=
					'<p style="text-decoration:none;color:#000000;font-size:16px;"><strong>' . $LANG['GETTING CASH FOR YOUR DEVICE'] . '</strong></p>';
			}
			$visitor_body .=
				'</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr>
							<td align="left" style="width:100%;padding-top:0px;padding-bottom:5px;">
								<table width="100%" cellspacing="0" cellpadding="10" style="background:#000000;border:none;text-align:left;">
									<tbody>
										<tr>
											<td>
												<table width="100%" cellspacing="0" cellpadding="0" style="border:none" >
													<tbody>
														<tr>
															<td align ="center" valign="middle" style="font-family:\'Montserrat\',Helvetica,Roboto,Arial,sans-serif; width:100%; padding: 0px;">';
			if ($payment_method != "cash") {
				$visitor_body .=
					'<p style="text-decoration:none;color:#ffffff;font-size:16px; margin-bottom: 30px">PLEASE, FOLLOW THE STEPS BELOW TO SHIP YOUR DEVICE TO US</p>';
			} else {
				$visitor_body .=
					'<p style="text-decoration:none;color:#ffffff;font-size:16px; margin-bottom: 30px">' . $LANG['BEFORE OUR MEETING AT THE STARBUCKS OF YOUR CHOICE,'] . '</p>';
			}
			$visitor_body .=
				'</td>
														</tr>
														<tr>
															<td style="font-family:\'Montserrat\',Helvetica,Roboto,Arial,sans-serif; width:100%;" align="center" valign="middle">
																<img src="https://www.1guygadget.com/images/prepare_your_device.png" width="auto" height="90" style="padding:5px;" alt="' . $LANG['Prepare Your Device'] . '" class="CToWUd">
															</td>    

														</tr>
													</tbody>
												</table>        
											</td>
										</tr>
										<tr>
											<td style="padding-top: 0px;">
												<table width="100%" cellspacing="0" cellpadding="0" style="border:none">
													<tbody>
														<tr>
															<td align ="left" valign="middle" style="font-family:\'Montserrat\',Helvetica,Roboto,Arial,sans-serif; line-height:1; width:100%; padding: 0px; padding-left: 1.1em; margin-right: 0.5em; margin-left: 0.5em;">
																<p style="text-decoration:none;color:#8bb927;font-size:16px;"><strong>' . $LANG['PREPARE YOUR DEVICE'] . '</strong></p> 
															</td>
														</tr>
														<tr>
															<td style="font-family:\'Montserrat\',Helvetica,Roboto,Arial,sans-serif; width:100%; font-size:16px;" align="left" valign="middle">
															    <div>
    																<ul style ="list-style:square; color:#8bb927; padding: 0px; padding-left: 1.5em; margin-right: 0.5em; margin-left: 0.5em; line-height:1.4em;">
    																	<li style ="list-style:square outside; mso-special-format: bullet; color:#8bb927;"><p style="color:#ffffff;margin-top:0.5em;">' . $LANG['Remove or sign out from FIND MY IPHONE for Apple devices and remove ANDROID ACTIVATION LOCK for Android devices.'] . '</p></li>
    																	<li style ="list-style:square outside; mso-special-format: bullet; color:#8bb927;"><p style="color:#ffffff;margin-top:0.5em;">' . $LANG['Remove any password protection service.'] . '</p></li>
    																	<li style ="list-style:square outside; mso-special-format: bullet; color:#8bb927;"><p style="color:#ffffff;margin-top:0.5em;">' . $LANG['Reset device to "Factory Settings" if applicable.'] . '</p></li>
    																	<li style ="list-style:square outside; mso-special-format: bullet; color:#8bb927;"><p style="color:#ffffff;margin-top:0.5em;">' . $LANG["Fully Charge the device's battery."] . '</p></li>
    																</ul>
    															</div>
															</td>    

														</tr>
													</tbody>
												</table>        
											</td>
										</tr>
									</tbody>
								</table>';
			if ($payment_method != "cash") {
				$visitor_body .=
					'<table width="100%" cellspacing="0" cellpadding="10" style="background:#000000;border:none;text-align:left;">
										<tbody>
											<tr>
												<td>
													<table width="100%" cellspacing="0" cellpadding="0" style="border:none" >
														<tbody>
															
															<tr>
																<td style="font-family:\'Montserrat\',Helvetica,Roboto,Arial,sans-serif; width:100%;" align="center" valign="middle">
																	<img src="https://www.1guygadget.com/images/box.png" width="auto" height="110" style="padding:5px;" alt="Packaging your device for shipping" class="CToWUd">
																</td>    

															</tr>
														</tbody>
													</table>        
												</td>
											</tr>
											<tr>
												<td style="padding-top: 0px;">
													<table width="100%" cellspacing="0" cellpadding="0" style="border:none">
														<tbody>
															<tr>
																<td align ="left" valign="middle" style="font-family:\'Montserrat\',Helvetica,Roboto,Arial,sans-serif; line-height:1; width:100%; padding: 0px; padding-left: 1.1em; margin-right: 0.5em; margin-left: 0.5em;">
																	<p style="text-decoration:none;color:#8bb927;font-size:16px;"><strong>PACKAGE YOUR DEVICE PROPERLY</strong></p> 
																</td>
															</tr>
															<tr>
																<td style="font-family:\'Montserrat\',Helvetica,Roboto,Arial,sans-serif; width:100%; font-size:16px;" align="left" valign="middle">
																    <div>
    																	<ul style ="list-style:square; color:#8bb927; padding: 0px; padding-left: 1.5em; margin-right: 0.5em; margin-left: 0.5em; line-height:1.4em;">
    														
    																		<li style ="list-style:square outside; mso-special-format: bullet; color:#8bb927;"><p style="color:#ffffff;margin-top:0.5em;">Secure device properly inside its packaging to prevent damage while in transit. We recommend the use of bubble wraps and Styrofoam peanuts.</p></li>
    																		<li style ="list-style:square outside; mso-special-format: bullet; color:#8bb927;"><p style="color:#ffffff;margin-top:0.5em;">Seal the package with a durable shipping tape.</p></li>
    																		<li style ="list-style:square outside; mso-special-format: bullet; color:#8bb927;"><p style="color:#ffffff;margin-top:0.5em;">We are not accountable for any damages during shipping. This could force an offer review or lead to the cancellation of your offer.</p></li>
    																	</ul>
    																</div>
																</td>    

															</tr>
														</tbody>
													</table>        
												</td>
											</tr>
										</tbody>
									</table>
									<table width="100%" cellspacing="0" cellpadding="10" style="background:#000000;border:none;text-align:left;">
											<tbody>
												<tr>
													<td>
														<table width="100%" cellspacing="0" cellpadding="0" style="border:none;" >
															<tbody>
																
																<tr>
																	<td style="font-family:\'Montserrat\',Helvetica,Roboto,Arial,sans-serif; width:100%;" align="center" valign="middle">
																		<img src="https://www.1guygadget.com/images/printer.png" width="auto" height="110" style="padding:5px;" alt="Printing your shipping label" class="CToWUd">
																	</td>    

																</tr>
															</tbody>
														</table>        
													</td>
												</tr>
												<tr>
													<td style="padding-top: 0px;">
														<table width="100%" cellspacing="0" cellpadding="0" style="border:none">
															<tbody>
																<tr>
																	<td align ="left" valign="middle" style="font-family:\'Montserrat\',Helvetica,Roboto,Arial,sans-serif; line-height:1; width:100%; padding: 0px; padding-left: 1.1em; margin-right: 0.5em; margin-left: 0.5em;">
																		<p style="text-decoration:none;color:#8bb927;font-size:16px;"><strong>SHIPPING YOUR DEVICE</strong></p> 
																	</td>
																</tr>
																<tr>
																	<td style="font-family:\'Montserrat\',Helvetica,Roboto,Arial,sans-serif; width:100%; font-size:16px;" align="left" valign="middle">
																	    <div>
    																		<ul style ="list-style:square;color:#8bb927; padding: 0px; padding-left: 1.5em; margin-right: 0.5em; margin-left: 0.5em; line-height:1.4em;">
    															
    																			<li style ="list-style:square outside; mso-special-format: bullet; color:#8bb927;"><p style="color:#ffffff;margin-top:0.5em;">Print the prepaid shipping label below, and attach it securely with a tape to your package.</p></li>
    																			<li style ="list-style:square outside; mso-special-format: bullet; color:#8bb927;"><p style="color:#ffffff;margin-top:0.5em;">Leave us a message If you don\'t have a printer, and we will mail you a printed label. You can also use the printer at a local library.</p></li>
    																			<li style ="list-style:square outside; mso-special-format: bullet; color:#8bb927;"><p style="color:#ffffff;margin-top:0.5em;">Drop off the package at a USPS location closest you. Ensure that it is marked "Fragile" at the counter</p></li>
    																			<li style ="list-style:square outside; mso-special-format: bullet; color:#8bb927;"><p style="color:#ffffff;margin-top:0.5em;">Your offer is guaranteed to be locked for <strong style="color:#8bb927">21 days</strong>. Be sure to ship or deliver your device within this period to avoid cancellation of your offer.</p></li>
    																		</ul>
    																	</div>
																	</td>    

																</tr>
															</tbody>
														</table>        
													</td>
												</tr>
											</tbody>
										</table>
										<table width="100%" cellspacing="0" cellpadding="0" style="background:#000000;border:none;">
												<tbody>
													<tr>
														<td style="padding-top: 0px; padding-bottom: 20px;">
															<table align="center" width="40%" cellspacing="0" cellpadding="0" style="margin:auto; border:none; background-color:#ffffff;border-radius:12px;text-align:center;" >
																<tbody>
																	
																	<tr>
																		<td style="font-family:\'Montserrat\',Helvetica,Roboto,Arial,sans-serif; padding:10px;" valign="middle" align="center" >' .
					'<a href="' . $shipment_label_url . '" target="_blank" style="text-decoration:none; color:#000000;">
																				<img src="https://www.1guygadget.com/images/usps_logo.png" width="auto" height="35" style="padding-bottom:8px;" alt="USPS logo" class="CToWUd"><br>
																				<span>CLICK TO PRINT LABEL</span>
																			</a>
																		</td>    

																	</tr>
																</tbody>
															</table>        
														</td>
													</tr>

												</tbody>
											</table>
										</td>
									</tr>
								</tbody>
							</table>';
			}

			$visitor_body .= '<table width="100%" cellspacing="0" cellpadding="0" style="font-size:16px; margin-top: 15px;">
					<tbody>
						<tr>
							<td align="left" style="width:100%;padding-top:5px;padding-bottom:0px;"> 
								<table width="100%" cellspacing="0" cellpadding="10" style="background:#000000;border:none; text-align:center;">
									<tbody>
										<tr>
											<td valign="middle" style="font-family:\'Montserrat\',Helvetica,Roboto,Arial,sans-serif; line-height:1; width:100%;"> 
												<p style="text-decoration:none;color:#ffffff;font-size:16px;"><strong>' . $LANG['OFFER DETAILS'] . '</strong></p>
								
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						
						<tr>
							<td align="left" style="width:100%;padding-top:0px;padding-bottom:5px;">
								<table width="100%" cellspacing="0" cellpadding="10" style="background:#8bb927;border:none;text-align:left; padding-top: 10px;">
									<tbody>
										<tr>
											<td style = "font-family:\'Montserrat\',Helvetica,Roboto,Arial,sans-serif; color:#000000;  padding-left: 1.1em; padding-right: 1.1em;" >
												<strong>' . $LANG['Contact Information'] . '</strong><br>
												<hr align="left" bgcolor="#ffffff" style="width:150px; height:5px; color: #ffffff; background: #ffffff; border:none;">
											</td>
										</tr>
										<tr>
											<td style = "font-family:\'Montserrat\',Helvetica,Roboto,Arial,sans-serif; text-decoration: none; color:#000000; padding-top:0px;  padding-left: 1.1em; padding-right: 1.1em;">'
				. '<strong>' . $name . '</strong><br>';
			if ($address) {
				$visitor_body .= '<a href="#" link="#" style="text-decoration: none; color:#000000;">' . $address . '</a><br>';
			}

			if ($address2) {
				$visitor_body .= '<a href="#" link="#" style="text-decoration: none; color:#000000;">' . $address2 . '</a><br>';
			}
			if ($city && $state && $postcode) {
				$visitor_body .= '<a href="#" link="#" style="text-decoration: none; color:#000000;">' . $city . ', ' . $state . ' ' . $postcode . '</a><br>';
			}

			$visitor_body .=    '<a href="mailto:' . $user_data['email'] . '" target="_blank" style="text-decoration: none; color:#555252;">' . $user_data['email'] . '</a><br>'
				. $phone . '<br><br>
											</td>
										</tr>
										<tr>
											<td style = "font-family:\'Montserrat\',Helvetica,Roboto,Arial,sans-serif; color:#000000; padding-left: 1.1em; padding-right: 1.1em;" >
												
												<strong>' . $LANG['Additional Information'] . '</strong><br>
												<hr align="left" bgcolor="#ffffff" style="width:150px; height:5px; color: #ffffff; background: #ffffff; border:none;">
								
											</td>
						
										</tr>
										<tr>
											<td style = "font-family:\'Montserrat\',Helvetica,Roboto,Arial,sans-serif; color:#000000;   padding-top:0px; padding-left: 1.1em; padding-right: 1.1em;" >
												<strong>' . $LANG['Offer Date/Time'] . '</strong><br>' .
				format_date($order_data['date']) . ' ' . format_time($order_data['date']) . ' ' . $customer_timezone . '<br><br>' . '
												<strong>' . $LANG['Payment Preference'] . '</strong><br>' .
				$LANG[ucfirst($payment_method)] . '<br><br>';
			if ($order_data['cash_location_name']) {
				$visitor_body .= '<strong>LOCATION</strong><br>' .
					$order_data['cash_location_name'] . '<br><br>';
			}
			$visitor_body .= '
											</td>
										</tr>
										
									</tbody>
								</table>
								<table width="100%" cellspacing="0" cellpadding="10" style="background:#fff;border:1px solid #c0bfbf;text-align:left;">
										<tbody>
											
											<tr>
												<td style="padding-top: 0px;">
													<table width="100%" cellspacing="0" cellpadding="0" style="border:none">
														<tbody>
															<tr>
																<td align ="center" valign="middle" style="font-family:\'Montserrat\',Helvetica,Roboto,Arial,sans-serif; line-height:1; width:100%; padding-top: 20px; margin-right: 0.5em; margin-left: 0.5em;">
																	<p style="text-decoration:none !important;color:#000;font-size:20px;"><a href="#" style="text-decoration:none; color:#000;" title="Link: #"><strong>' . $LANG['Offer #'] . " " . $order_id . '</strong></a></p> 
																</td>
															</tr>
															<tr>
																<td align ="center" valign="middle" style="font-family:\'Montserrat\',Helvetica,Roboto,Arial,sans-serif; line-height:1; width:100%; padding-top: 5px; margin-right: 0.5em; margin-left: 0.5em;">';
			if ($payment_method != "cash") {
				$visitor_body .= '<p style="text-decoration:none;color:#979797;font-size:14px;">' . $LANG['You may cancel your trade-in offer up until your device is delivered to us.'] . '</p>';
			} else {
				$visitor_body .= '<p style="text-decoration:none;color:#979797;font-size:14px;">' . $LANG['You may cancel your trade-in offer up until we have paid you.'] . '</p>';
			}
			$visitor_body .= '</td>
															</tr>
														</tbody>
													</table>';
			//add order_list_here 
			$visitor_body .= $order_list .
				'</td>
											</tr>
										</tbody>
									</table>';
			if ($hide_device_order_valuation_price != '1') {
				$visitor_body .= '<table width="100%" cellspacing="0" cellpadding="10" style="background:#000000;border:none;text-align:left;">
											<tbody>

												<tr>
													<td style="padding-top: 25px;">
														<table width="100%" cellspacing="0" cellpadding="0" style="border:none">
															<tbody>
																<tr>
																	<td align ="left" valign="middle" style="font-family:\'Montserrat\',Helvetica,Roboto,Arial,sans-serif; line-height:1; width:100%; padding: 0px; padding-left: 1.1em; padding-right: 1.1em; margin-right: 0.5em; margin-left: 0.5em;">
																		<p style="text-decoration:none;color:#8bb927;font-size:18px;"><strong>' . $LANG['SUMMARY'] . '</strong></p> 
																	</td>
																</tr>
																
																<tr>
																	<td align ="left" colspan = "2" valign="middle" style="line-height:1; width:100%; padding: 0px; padding-left: 1.1em; padding-right: 1.1em; margin-right: 0.5em; margin-left: 0.5em;">
																			<hr style="display:block;width:100%;height:1px;background:#9b9b9b;border:none"> 
																	</td>
																</tr>
															</tbody>	
														</table>';

				$visitor_body .=
					'<table width="100%" cellspacing="0" cellpadding="0" style="border:none">
															<tbody>
											                    <tr>
																	<td align ="left" valign="middle" style="font-family:\'Montserrat\',Helvetica,Roboto,Arial,sans-serif; line-height:1; width:60%; padding-top: 10px; padding-bottom: 10px; padding-left: 1.1em; padding-right: 1.1em; margin-right: 0.5em; margin-left: 0.5em;">
																		<p style="text-decoration:none;color:#fff;font-size:15px;"><strong>' . $LANG['Order Total'] . '</strong></p> 
																	</td>
																	<td align ="right" valign="middle" style="font-family:\'Montserrat\',Helvetica,Roboto,Arial,sans-serif; line-height:1; width:40%; padding-top: 10px; padding-bottom: 10px; padding-left: 1.1em; padding-right: 1.1em; margin-right: 0.5em; margin-left: 0.5em;">
																		<p style="text-decoration:none;color:#8bb927;font-size:15px;">' . ($sum_of_orders > 0 ? amount_fomat($sum_of_orders) : '') . '</p> 
																	</td>
																</tr>
															</tbody>	
														</table>';

				if ($payment_method != "cash") {
					$visitor_body .=
						'<table width="100%" cellspacing="0" cellpadding="0" style="border:none">
															<tbody>
												                <tr>
																	<td align ="left" valign="middle" style="font-family:\'Montserrat\',Helvetica,Roboto,Arial,sans-serif; line-height:1; width:60%; padding-top: 10px; padding-bottom: 10px; padding-left: 1.1em; padding-right: 1.1em; margin-right: 0.5em; margin-left: 0.5em;">
																		<p style="text-decoration:none;color:#fff;font-size:15px;"><strong>PRIORITY SHIPPING</strong></p> 
																	</td>
																	<td align ="right" valign="middle" style="font-family:\'Montserrat\',Helvetica,Roboto,Arial,sans-serif; line-height:1; width:40%; padding-top: 10px; padding-bottom: 10px; padding-left: 1.1em; padding-right: 1.1em; margin-right: 0.5em; margin-left: 0.5em;">
																			<p style="text-decoration:none;color:#8bb927;font-size:15px;">FREE</p> 
																	</td>
																</tr>
															</tbody>	
														</table>';
				}

				if ($is_promocode_exist || $f_express_service_price > 0 || $f_shipping_insurance_price > 0) {
					if ($is_promocode_exist) {
						$visitor_body .=
							'<table width="100%" cellspacing="0" cellpadding="0" style="border:none">
															<tbody>
										                           <tr>
																	<td align ="left" valign="middle" style="font-family:\'Montserrat\',Helvetica,Roboto,Arial,sans-serif; line-height:1; width:60%; padding-top: 10px; padding-bottom: 10px; padding-left: 1.1em; padding-right: 1.1em; margin-right: 0.5em; margin-left: 0.5em;">
																		<p style="text-decoration:none;color:#fff;font-size:15px;"><strong>' . $discount_amt_label . '</strong></p> 
																	</td>
																	<td align ="right" valign="middle" style="font-family:\'Montserrat\',Helvetica,Roboto,Arial,sans-serif; line-height:1; width:40%; padding-top: 10px; padding-bottom: 10px; padding-left: 1.1em; padding-right: 1.1em; margin-right: 0.5em; margin-left: 0.5em;">
																			<p style="text-decoration:none;color:#8bb927;font-size:15px;">' . '- ' . $discount_amt_with_format . '</p> 
																	</td>
																</tr>
															</tbody>	
														</table>';
					}
					if ($f_express_service_price) {
						$visitor_body .=
							'<table width="100%" cellspacing="0" cellpadding="0" style="border:none">
															<tbody>
										                        <tr>
																	<td align ="left" valign="middle" style="font-family:\'Montserrat\',Helvetica,Roboto,Arial,sans-serif; line-height:1; width:60%; padding-top: 10px; padding-bottom: 10px; padding-left: 1.1em; padding-right: 1.1em; margin-right: 0.5em; margin-left: 0.5em;">
																		<p style="text-decoration:none;color:#fff;font-size:15px;"><strong>EXPRESS SERVICE</strong></p> 
																	</td>
																	<td align ="right" valign="middle" style="font-family:\'Montserrat\',Helvetica,Roboto,Arial,sans-serif; line-height:1; width:40%; padding-top: 10px; padding-bottom: 10px; padding-left: 1.1em; padding-right: 1.1em; margin-right: 0.5em; margin-left: 0.5em;">
																			<p style="text-decoration:none;color:#8bb927;font-size:15px;">' . '- ' . amount_fomat($f_express_service_price) . '</p> 
																	</td>
																</tr>
															</tbody>	
														</table>';
					}
					if ($f_shipping_insurance_price) {
						$visitor_body .=
							'<table width="100%" cellspacing="0" cellpadding="0" style="border:none">
															<tbody>
										                        <tr>
																	<td align ="left" valign="middle" style="font-family:\'Montserrat\',Helvetica,Roboto,Arial,sans-serif; line-height:1; width:60%; padding-top: 10px; padding-bottom: 10px; padding-left: 1.1em; padding-right: 1.1em; margin-right: 0.5em; margin-left: 0.5em;">
																		<p style="text-decoration:none;color:#fff;font-size:15px;"><strong>SHIPPING INSURANCE</strong></p> 
																	</td>
																	<td align ="right" valign="middle" style="font-family:\'Montserrat\',Helvetica,Roboto,Arial,sans-serif; line-height:1; width:40%; padding-top: 10px; padding-bottom: 10px; padding-left: 1.1em; padding-right: 1.1em; margin-right: 0.5em; margin-left: 0.5em;">
																			<p style="text-decoration:none;color:#8bb927;font-size:15px;">' . '- ' . amount_fomat($f_shipping_insurance_price) . '</p> 
																	</td>
																</tr>
															</tbody>	
														</table>';
					}
				}
				//$visitor_body .= '</tbody>
				//				</table>';
				$visitor_body .= '<table width="100%" cellspacing="0" cellpadding="0" style="border:none">
																<tbody>
																	<tr>
																		<td align ="left" valign="middle" style="font-family:\'Montserrat\',Helvetica,Roboto,Arial,sans-serif; line-height:1; width:60%; padding-top: 15px; padding-bottom: 15px; padding-left: 1.1em; padding-right: 1.1em; margin-right: 0.5em; margin-left: 0.5em;">
																			<p style="text-decoration:none;color:#8bb927;font-size:16px;"><strong>' . $LANG['TOTAL PAYMENT'] . '</strong></p> 
																		</td>
																		<td align ="right" valign="middle" style="font-family:\'Montserrat\',Helvetica,Roboto,Arial,sans-serif; line-height:1; width:40%; padding-top: 15px; padding-bottom: 15px; padding-left: 1.1em; padding-right: 1.1em; margin-right: 0.5em; margin-left: 0.5em;">
																				<p style="text-decoration:none;color:#fff;font-size:16px;"><strong>' . amount_fomat(($sum_of_orders - $discount_amt_with_format - $f_express_service_price - $f_shipping_insurance_price)) . '</strong></p> 
																		</td>
																	</tr>

																</tbody>
														</table>                
												</td>
											</tr>
										</tbody>
									</table>';
			}
			$visitor_body .= '</td>
						</tr>
					</tbody>
					</table>
					<br>';







			if ($payment_method != "cash" && $shipping_api == "easypost" && $shipment_generated_by_cust == '1' && $shipping_api_key != "") {
				$template_data = get_template_data('order_processing_status');

				$general_setting_data = get_general_setting_data();
				$admin_user_data = get_admin_user_data();
				$order_data = get_order_data($order_id);

				$sum_of_orders = get_order_price($order_id);
				if ($order_data['promocode_id'] > 0 && $order_data['promocode_amt'] > 0) {
					$total_of_order = $sum_of_orders + $order_data['promocode_amt'];
				} else {
					$total_of_order = $sum_of_orders;
				}
				$expire_date = date('Y-m-d', strtotime(' + 5 days'));

				$model_item_id = $order_item_ids[0];

				$model_item_data = get_order_item($model_item_id, '');

				$patterns = array(
					'{$logo}', '{$header_logo}', '{$footer_logo}',
					'{$admin_logo}',
					'{$admin_email}',
					'{$admin_username}',
					'{$admin_site_url}',
					'{$admin_panel_name}',
					'{$from_name}',
					'{$from_email}',
					'{$site_name}',
					'{$site_url}',
					'{$customer_fname}',
					'{$customer_lname}',
					'{$customer_fullname}',
					'{$customer_phone}',
					'{$customer_email}',
					'{$customer_address_line1}',
					'{$customer_address_line2}',
					'{$customer_city}',
					'{$customer_state}',
					'{$customer_country}',
					'{$customer_postcode}',
					'{$customer_company_name}',
					'{$order_id}',
					'{$order_payment_method}',
					'{$order_date}',
					'{$order_approved_date}',
					'{$order_expire_date}',
					'{$order_status}',
					'{$order_sales_pack}',
					'{$current_date_time}',
					'{$order_item_model}',
					'{$order_item_price}',
					'{$order_item_storage}',
					'{$order_item_condition}',
					'{$order_item_locks}',
					'{$order_total}'
				);

				$temp_arr = strtolower($order_data['name']) . ";";
				$temp_arr = preg_split("/[\s*]/", $temp_arr);
				$hold = "";
				foreach ($temp_arr as $str) {
					$hold .= ucfirst($str) . " ";
				}
				$temp_arr = trim(preg_replace("/\;/", "", $hold));


				$pre_header = strip_tags($template_data['content']);
				$pre_header = preg_replace('/\{\$(header_logo)\}/i', '', $pre_header);
				$pre_header = preg_replace('/\{\$(footer_logo)\}/i', '', $pre_header);
				$pre_header = preg_replace('/\{\$(customer_fullname)\}(\W)/i', $temp_arr . "$2" . ' ', $pre_header);

				$replacements_1 = array(
					$logo, $header_logo, $footer_logo,
					$admin_logo,
					$admin_user_data['email'],
					$admin_user_data['username'],
					ADMIN_URL,
					$general_setting_data['admin_panel_name'],
					$general_setting_data['from_name'],
					$general_setting_data['from_email'],
					$general_setting_data['site_name'],
					SITE_URL,
					$user_data['first_name'],
					$user_data['last_name'],
					$user_data['name'],
					$user_data['phone'],
					$user_data['email'],
					$user_data['address'],
					$user_data['address2'],
					$user_data['city'],
					$user_data['state'],
					$user_data['country'],
					$user_data['postcode'],
					$order_data['company_name'],
					$order_data['order_id'],
					$payment_method,
					$order_data['order_date'],
					$order_data['approved_date'],
					$expire_date,
					ucwords(str_replace("_", " ", $order_data['order_status'])),
					$order_data['sales_pack'],
					format_date(date('Y-m-d H:i')) . ' ' . format_time(date('Y-m-d H:i')),
					$model_item_data['data']['brand_title'] . ' - ' . $model_item_data['data']['model_title'],
					amount_fomat($model_item_data['data']['price']),
					$model_item_data['data']['storage'],
					$model_item_data['data']['condition'],
					$model_item_data['data']['network'],
					amount_fomat($total_of_order)
				);

				$replacements = array(
					$logo, $header_logo, $footer_logo,
					$admin_logo,
					$admin_user_data['email'],
					$admin_user_data['username'],
					ADMIN_URL,
					$general_setting_data['admin_panel_name'],
					$general_setting_data['from_name'],
					$general_setting_data['from_email'],
					$general_setting_data['site_name'],
					SITE_URL,
					$user_data['first_name'],
					$user_data['last_name'],
					$user_data['name'],
					$user_data['phone'],
					$user_data['email'],
					$user_data['address'],
					$user_data['address2'],
					$user_data['city'],
					$user_data['state'],
					$user_data['country'],
					$user_data['postcode'],
					$order_data['company_name'],
					$order_data['order_id'],
					$payment_method,
					$order_data['order_date'],
					$order_data['approved_date'],
					$expire_date,
					ucwords(str_replace("_", " ", $order_data['order_status'])),
					$order_data['sales_pack'],
					format_date(date('Y-m-d H:i')) . ' ' . format_time(date('Y-m-d H:i')),
					$model_item_data['data']['brand_title'] . ' - ' . $model_item_data['data']['model_title'],
					amount_fomat($model_item_data['data']['price']),
					$model_item_data['data']['storage'],
					$model_item_data['data']['condition'],
					$model_item_data['data']['network'],
					amount_fomat($total_of_order)
				);


				$email_subject = str_replace($patterns, $replacements, $template_data['subject']);
				$email_body_text = str_replace($patterns, $replacements, $template_data['content']);
			} else {

				$template_data = get_template_data('new_order_email_to_customer');
				$template_data_for_admin = get_template_data('new_order_email_to_admin');

				$order_data = get_order_data($order_id);

				//Get admin user data
				$admin_user_data = get_admin_user_data();

				$patterns = array(
					'{$logo}', '{$header_logo}', '{$footer_logo}',
					'{$admin_logo}',
					'{$admin_email}',
					'{$admin_username}',
					'{$admin_site_url}',
					'{$admin_panel_name}',
					'{$from_name}',
					'{$from_email}',
					'{$site_name}',
					'{$site_url}',
					'{$customer_fname}',
					'{$customer_lname}',
					'{$customer_fullname}',
					'{$customer_phone}',
					'{$customer_email}',
					'{$customer_address_line1}',
					'{$customer_address_line2}',
					'{$customer_city}',
					'{$customer_state}',
					'{$customer_country}',
					'{$customer_postcode}',
					'{$order_id}',
					'{$order_payment_method}',
					'{$order_date}',
					'{$order_approved_date}',
					'{$order_expire_date}',
					'{$order_status}',
					'{$order_sales_pack}',
					'{$current_date_time}',
					'{$order_item_list}'
				);

				$pre_header = strip_tags($template_data['content']);
				$pre_header = preg_replace('/\{\$(header_logo)\}/i', '', $pre_header);
				$pre_header = preg_replace('/\{\$(footer_logo)\}/i', '', $pre_header);
				$pre_header = preg_replace('/\{\$(customer_fullname)\}(\W)/i', $user_data['name'] . "$2" . ' ', $pre_header);

				$replacements_1 = array(
					$logo, $header_logo, $footer_logo,
					$admin_logo,
					$admin_user_data['email'],
					$admin_user_data['username'],
					ADMIN_URL,
					$general_setting_data['admin_panel_name'],
					$general_setting_data['from_name'],
					$general_setting_data['from_email'],
					$general_setting_data['site_name'],
					SITE_URL,
					$user_data['first_name'],
					$user_data['last_name'],
					$user_data['name'],
					$user_data['phone'],
					$user_data['email'],
					$user_data['address'],
					$user_data['address2'],
					$user_data['city'],
					$user_data['state'],
					$user_data['country'],
					$user_data['postcode'],
					$order_data['order_id'],
					$order_data['payment_method'],
					$order_data['order_date'],
					$order_data['approved_date'],
					$order_data['expire_date'],
					ucwords(str_replace("_", " ", $order_data['order_status'])),
					$order_data['sales_pack'],
					format_date($datetime) . ' ' . format_time($datetime),
					$visitor_body
				);


				$replacements = array(
					$logo,
					$header_logo,
					$footer_logo,
					$admin_logo,
					$admin_user_data['email'],
					$admin_user_data['username'],
					ADMIN_URL,
					$general_setting_data['admin_panel_name'],
					$general_setting_data['from_name'],
					$general_setting_data['from_email'],
					$general_setting_data['site_name'],
					SITE_URL,
					$user_data['first_name'],
					$user_data['last_name'],
					$user_data['name'],
					$user_data['phone'],
					$user_data['email'],
					$user_data['address'],
					$user_data['address2'],
					$user_data['city'],
					$user_data['state'],
					$user_data['country'],
					$user_data['postcode'],
					$order_data['order_id'],
					$order_data['payment_method'],
					$order_data['order_date'],
					$order_data['approved_date'],
					$order_data['expire_date'],
					ucwords(str_replace("_", " ", $order_data['order_status'])),
					$order_data['sales_pack'],
					format_date($datetime) . ' ' . format_time($datetime),
					$visitor_body
				);
			}




			//START for generate barcode
			$barcode_img_nm = "barcode_" . date("YmdHis") . ".png";
			$get_barcode_data = file_get_contents(SITE_URL . 'libraries/barcode.php?text=' . $order_id . '&codetype=code128&orientation=horizontal&size=30&print=false');
			file_put_contents('../images/barcode/' . $barcode_img_nm, $get_barcode_data);
			$barcode_img_path = '<img src="' . SITE_URL . 'images/barcode/' . $barcode_img_nm . '"/>';
			//END for generate barcode

			$html = <<<EOF
<!-- EXAMPLE OF CSS STYLE -->
<style>
table,td{
  margin:0;
  padding:0;
}
.small-text{
  font-size:12px;
  text-align:center;
}
.block{
  width:45%;
}
.block-border{
  border:1px dashed #ddd;
}
.divider{
  width:10%;
}
.hdivider{
  height:0px;
}
.title{
  font-size:20px;
  font-weight:bold;
}
</style>
EOF;

			$html .= '
<table cell-padding="0" cell-spacing="0" border="0;" width="100%" style="padding:15px 15px 15px 15px;font-size:12px;">
	<tbody>
	  <tr>
		<td colspan="2"><h2 style="font-size:18px;">' . $LANG['Invoice'] . ' ' . $company_name . '</h2></td>
		<td bgcolor="#000" style="padding:5px 5px 5px 5px; border:1px solid #8bb927;"><img width="210"  src="' . SITE_URL . 'images/' . $general_setting_data['logo'] . '"></td>
	  </tr>
	  <tr>
		<td>
			<dl>
				<dt>' . $user_data['name'] . '</dt>
				<dt>' . $user_data['address'] . '</dt>
				<dt>' . $user_data['city'] . ', ' . $user_data['state'] . ' ' . $user_data['postcode'] . '</dt>
			</dl>
		</td>
		<td>&nbsp;</td>
		<td>
			<dl>
				<dt>' . $barcode_img_path . '</dt>
				<dt><strong>' . $LANG['Offer Number'] . ': </strong>' . $order_id . '</dt>
				<dt><strong>' . $LANG['Date of offer'] . ': </strong> ' . format_date($order_data['order_date']) . '</dt>
				<dt><strong>' . $LANG['Payment Preference'] . ': </strong> ' . $LANG[ucfirst($order_data['payment_method'])] . '</dt>
			</dl>
		</td>
	  </tr>
	</tbody>
</table>
<table cell-padding="0" cell-spacing="0" border="0;" width="100%" style="padding:10px 10px 10px 10px;">';

			foreach ($order_item_ids as $orderItemId) {
				//path of this function (get_order_item) admin/include/functions.php
				$order_item_data = get_order_item_1($orderItemId, 'email');
				$order_list_pdf .= '<tr>
			<td bgcolor="#ddd" width="10%" style="padding:15px;">' . ($n = $n + 1) . '</td>
			<td bgcolor="#ddd" width="50%" style="padding:15px;">' . $order_item_data['device_type'] . '</td>
			<td bgcolor="#ddd" width="20%" style="padding:15px;text-align:center;">' . $order_item_data['quantity'] . '</td>';
				if ($hide_device_order_valuation_price != '1') {
					$order_list_pdf .= '<td bgcolor="#ddd" width="20%" style="padding:15px;text-align:right;">' . amount_fomat($order_item_data['price']) . '</td>';
				}
				$order_list_pdf .= '</tr>';
			} //END append order items to block

			$html .= '
		<tr>
			<td width="10%" bgcolor="#e0f2f7" style="padding:15px;"><strong>#</strong></td>
			<td width="50%" bgcolor="#e0f2f7" style="padding:15px;"><strong>' . $LANG['details'] . '</strong></td>
			<td width="20%" bgcolor="#e0f2f7" style="padding:15px;text-align:center;"><strong>' . $LANG['Quantity'] . '</strong></td>';
			if ($hide_device_order_valuation_price != '1') {
				$html .= '<td width="20%" bgcolor="#e0f2f7" style="padding:15px;text-align:right;"><strong>Subtotal</strong></td>';
			}
			$html .= '</tr>';
			$html .= '<tbody>' . $order_list_pdf;
			if ($hide_device_order_valuation_price != '1') {
				$html .= '<tr>
			<td>&nbsp;</td>
			<td colspan="2" style="text-align:right;"><strong>' . $LANG['Offer total'] . '</strong></td>
			<td style="text-align:right;">' . ($sum_of_orders > 0 ? amount_fomat($sum_of_orders) : '') . '</td>
		</tr>';
				if ($payment_method != "cash") {
					$html .= '<tr>
			<td>&nbsp;</td>
			<td colspan="2" style="text-align:right;"><strong>Priority Shipping:</strong></td>
			<td style="text-align:right;">$0.00</td>
		</tr>';
				}
				if ($is_promocode_exist) {
					$html .= '<tr>
				<td>&nbsp;</td>
				<td colspan="2" style="text-align:right;"><strong>' . $discount_amt_label . '</strong></td>
				<td style="text-align:right;">' . $discount_amt_with_format . '</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td colspan="2" style="text-align:right;"><strong>Total Payment:</strong></td>
				<td style="text-align:right;">' . amount_fomat($total) . '</td>
			</tr>';
				}

				if ($is_promocode_exist || $f_express_service_price > 0 || $f_shipping_insurance_price > 0) {
					if ($is_promocode_exist) {
						$html .= '<tr>
					<td>&nbsp;</td>
					<td colspan="2" style="text-align:right;"><strong>' . $discount_amt_label . '</strong></td>
					<td style="text-align:right;">' . $discount_amt_with_format . '</td>
				</tr>';
					}

					if ($f_express_service_price) {
						$html .= '<tr>
					<td>&nbsp;</td>
					<td colspan="2" style="text-align:right;"><strong>Express Service:</strong></td>
					<td style="text-align:right;">-' . amount_fomat($f_express_service_price) . '</td>
				</tr>';
					}

					if ($f_shipping_insurance_price) {
						$html .= '<tr>
					<td>&nbsp;</td>
					<td colspan="2" style="text-align:right;"><strong>Shipping Insurance:</strong></td>
					<td style="text-align:right;">-' . amount_fomat($f_shipping_insurance_price) . '</td>
				</tr>';
					}

					$html .= '<tr>
				<td>&nbsp;</td>
				<td colspan="2" style="text-align:right;"><strong>Total:</strong></td>
				<td style="text-align:right;">' . amount_fomat(($total - $f_express_service_price - $f_shipping_insurance_price)) . '</td>
			</tr>';
				}
			}
			$html .= '</tbody>';
			$html .= '</table>';

			$expiring_date = date('F, j Y', strtotime($datetime . ' +' . $order_expired_days . ' day'));
			$html .= '<table cell-padding="0" cell-spacing="0" border="0;" width="100%" style="padding:10px 10px 10px 10px;">';
			$html .= '<tbody>';
			$html .= '<tr>
			<td>
			 ' . $LANG['This offer is guaranteed to be valid until'] . ' <b>' . $expiring_date . '</b>.<br></td>
		</tr>';
			$html .= '</tbody>
</table>';

			//echo $html;
			//exit;

			require_once(CP_ROOT_PATH . '/libraries/tcpdf/config/tcpdf_config.php');
			require_once(CP_ROOT_PATH . '/libraries/tcpdf/tcpdf.php');

			// create new PDF document
			$pdf = new TCPDF();

			// set document information
			$pdf->SetCreator($general_setting_data['from_name']);
			$pdf->SetAuthor($general_setting_data['from_name']);
			$pdf->SetTitle($general_setting_data['from_name']);

			$pdf->SetPrintHeader(false);
			$pdf->SetPrintFooter(false);

			// add a page
			$pdf->AddPage();

			$pdf->writeHtml($html);

			ob_end_clean();

			$file_folder = 'pdf';
			$file_folder_path = CP_ROOT_PATH . '/' . $file_folder;
			if (!file_exists($file_folder_path))
				mkdir($file_folder_path, 0777);

			//$pdfName='order-'.date('Y-m-d-H-i-s').'.pdf';
			$pdfName = 'Offer-' . $order_id . '.pdf';
			$pdf->Output($file_folder_path . '/' . $pdfName, 'F');
			$filetype    = "application/pdf"; // type
			$pdfLocation = "$file_folder_path/$pdfName";

			$eol = PHP_EOL;
			$semi_rand     = md5(time());
			$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

			$from = FROM_EMAIL . $eol;

			$headers       = "From: $from" .
				"MIME-Version: 1.0$eol" .
				"Content-Type: multipart/mixed;charset=utf-8" .
				" boundary=\"$mime_boundary\"";

			$file = fopen($pdfLocation, 'rb');
			$data = fread($file, filesize($pdfLocation));
			fclose($file);
			$pdf = chunk_split(base64_encode($data));


			//START email send to customer

			if (!empty($template_data)) {

				$email_subject = str_replace($patterns, $replacements, $template_data['subject']);
				$email_body_text = str_replace($patterns, $replacements, $template_data['content']);

				if ($shipment_label_url != "") {
					//$shipment_basename_label_url = basename($shipment_label_url);
					$shipment_basename_label_url = $shipment_label_custom_name;
					$label_copy_to_our_srvr = copy($shipment_label_url, '../shipment_labels/' . $shipment_basename_label_url);

					$attachment_data['basename'] = array($shipment_basename_label_url, $pdfName);
					$attachment_data['folder'] = array('shipment_labels', 'pdf');

					$message = "--$mime_boundary$eol" .
						"Content-Type: text/html; charset=\"iso-8859-1\"$eol" .
						"Content-Transfer-Encoding: 7bit$eol$eol" .
						$email_body_text . $eol;

					$message .= "--$mime_boundary$eol" .
						"Content-Type: $filetype;$eol" .
						" name=\"$pdfName\"$eol" .
						"Content-Disposition: attachment;$eol" .
						" filename=\"$pdfName\"$eol" .
						"Content-Transfer-Encoding: base64$eol$eol" .
						$pdf . $eol .
						"--$mime_boundary--";

					mail($user_data['email'], $email_subject, $message, $headers);
				} else {
					$attachment_data['basename'] = array($pdfName);
					$attachment_data['folder'] = array('pdf');

					$message = "--$mime_boundary$eol" .
						"Content-Type: text/html; charset=\"iso-8859-1\"$eol" .
						"Content-Transfer-Encoding: 7bit$eol$eol" .
						$email_body_text . $eol;

					$message .= "--$mime_boundary$eol" .
						"Content-Type: $filetype;$eol" .
						" name=\"$pdfName\"$eol" .
						"Content-Disposition: attachment;$eol" .
						" filename=\"$pdfName\"$eol" .
						"Content-Transfer-Encoding: base64$eol$eol" .
						$pdf . $eol .
						"--$mime_boundary--";

					mail($user_data['email'], $email_subject, $message, $headers);
				}

				//START sms send to customer
				if ($template_data['sms_status'] == '1') {
					$from_number = '+' . $general_setting_data['twilio_long_code'];
					$to_number = '+' . $user_data['phone'];
					if ($from_number && $account_sid && $auth_token) {
						$sms_body_text = str_replace($patterns, $replacements, $template_data['sms_content']);
						try {
							$sms = $sms_api->account->messages->sendMessage($from_number, $to_number, $sms_body_text, $image, array('StatusCallback' => ''));
						} catch (Services_Twilio_RestException $e) {
							$sms_error_msg = $e->getMessage();
							error_log($sms_error_msg);
						}
					}
				} //END sms send to customer
			} //END email send to customer

			//START email send to admin
			if (!empty($template_data_for_admin)) {
				$email_subject_for_admin = str_replace($patterns, $replacements, $template_data_for_admin['subject']);
				$email_body_text_for_admin = str_replace($patterns, $replacements, $template_data_for_admin['content']);

				mail($admin_user_data['email'], $email_subject_for_admin, $email_body_text_for_admin, $headers);
			} //END email send to admin

			//If order confirmed then final data saved/updated of order & unset all session items
			unset($_SESSION['order_item_ids']);

			if ($_SESSION['tmp_order_id'] != "") {
				unset($_SESSION['tmp_order_id']);
			}

			//Change session order_id to tmp_order_id & unset order_id session, it will use on only place_order page.
			$_SESSION['tmp_order_id'] = $order_id;
			unset($_SESSION['order_id']);
			unset($_SESSION['payment_method']);

			if (empty($msg)) {
				$msg = "Your offer (#" . $order_id . ") request was completed successfully.";
			}
			setRedirectWithMsg(SITE_URL . 'order-comlete', $msg, 'success');
		} else {
			$msg = 'Sorry, something went wrong';
			setRedirectWithMsg(SITE_URL . 'revieworder', $msg, 'error');
		}
		exit();
	} else {
		setRedirect(SITE_URL . 'revieworder');
		exit();
	}
} else {
	$msg = 'Direct access denied';
	setRedirectWithMsg(SITE_URL, $msg, 'danger');
	exit();
}
