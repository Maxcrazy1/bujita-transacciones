<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");

if(isset($post['submit_form'])) {
	if(empty($_POST)) {
		$msg='Direct access denied';
		setRedirectWithMsg(SITE_URL,$msg,'danger');
		exit();
	}

	$user_id = $_SESSION['user_id'];
	$order_id = $_SESSION['order_id'];
	
	$order_item_ids = $_SESSION['order_item_ids'];
	if(empty($order_item_ids)) {
		$order_item_ids = array();
	}

	//Get order price based on orderID, path of this function (get_order_price) admin/include/functions.php
	$sum_of_orders = get_order_price($order_id);

	$num_of_item = $post['num_of_item'];
	if($num_of_item!=count($order_item_ids)) {
		setRedirect(SITE_URL.'revieworder');
		exit();
	}
	
	$date = date('Y-m-d');
	$datetime = date('Y-m-d H:i:s');

	if($post['user_id']>0) {
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

	$cash_name = real_escape_string($post['cash_name']);
	$cash_phone = preg_replace("/[^\d]/", "", real_escape_string($post['f_cash_phone']));
	$cash_location = real_escape_string($post['cash_location']);
	if($name=="" && $phone=="") {
		$name = $cash_name;
		$phone = $cash_phone;
	}

	$express_service = $post['express_service'];
	$express_service_price = 15;
	$shipping_insurance = $post['shipping_insurance'];
	$shipping_insurance_per = 1.5;
	
	$f_express_service_price = 0;
	$f_shipping_insurance_price = 0;
	if($express_service == '1') {
		$f_express_service_price = $express_service_price;
	}
	if($shipping_insurance == '1') {
		$f_shipping_insurance_price = ($sum_of_orders*$shipping_insurance_per/100);
	}
	
	if($payment_method=="") {
		$msg='Please fill mandatory fields';
		setRedirectWithMsg(SITE_URL.'checkout',$msg,'error');
		exit();
	}

	if($user_id<=0 || $user_id=='') {
		$msg='You must signin first.';
		setRedirectWithMsg(SITE_URL.'checkout',$msg,'error');
		exit();
	} elseif($user_id>0) {
		mysqli_query($db,"UPDATE `users` SET `occasional_special_offers`='".$occasional_special_offers."', `important_sms_notifications`='".$important_sms_notifications."' WHERE id='".$user_id."'");
		if($name && $phone) {
			mysqli_query($db,"UPDATE `users` SET `name`='".$name."',`phone`='".$phone."' WHERE id='".$user_id."'");
		}
		if($address && $postcode) {
			mysqli_query($db,"UPDATE `users` SET `address`='".$address."',`address2`='".$address2."',`city`='".$city."',`state`='".$state."',`postcode`='".$postcode."' WHERE id='".$user_id."'");
		}

		//Get user data based on userID
		$user_data = get_user_data($user_id);

		//START post shipment by easypost API
		if($payment_method != "cash" && $shipping_api == "easypost" && $shipment_generated_by_cust == '1' && $shipping_api_key != "") {
			try {
				require_once("../libraries/easypost-php-master/lib/easypost.php");
				\EasyPost\EasyPost::setApiKey($shipping_api_key);

				//create To address
				$to_address_params = array(
					//"verify"  =>  array("delivery"),
					//'name' => $company_name,
					'company' => $company_name,
					'street1' => $company_address,
					'city' => $company_city,
					'state' => $company_state,
					'zip' => $company_zipcode,
					'country' => $company_country,
					'phone' => $company_phone,
					'email' => $site_email
				);
		
				//create From address
				$from_address_params = array(
					//"verify"  =>  array("delivery"),
					'name' => $user_data['name'],
					'street1' => $user_data['address'],
					//'street2' => $user_data['address2'],
					'city' => $user_data['city'],
					'state' => $user_data['state'],
					'zip' => $user_data['postcode'],
					'country' => $company_country,
					'phone' => substr($user_data['phone'], -10),
					'email' => $user_data['email']
				);
		
				$to_address = \EasyPost\Address::create($to_address_params);
				$from_address = \EasyPost\Address::create($from_address_params);
				
				$parcel_param_array = array(
				  "length" => $shipping_parcel_length,
				  "width" => $shipping_parcel_width,
				  "height" => $shipping_parcel_height,
				  "weight" => $shipping_parcel_weight
				);
				
				if($shipping_predefined_package!="") {
					$parcel_param_array['predefined_package'] = $shipping_predefined_package;
				}
				
				$parcel_info = \EasyPost\Parcel::create($parcel_param_array);
				
			
				
				if($to_address->verifications->delivery->success == '1' && $from_address->verifications->delivery->success == '1') {
					$shipment = \EasyPost\Shipment::create(array(
					  "to_address" => $to_address,
					  "from_address" => $from_address,
					  "parcel" => $parcel_info,
					  "carrier_accounts" => array($carrier_account_id),
					  "options" => array(
						  "label_size" => '4x6',
						  //"label_size" => '8.5x11',
						  //"print_custom_1" => "Instructions, Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.",
						  //"print_custom_2" => "test 2",
						  //"print_custom_3" => "test 3",
					  )
					));

					$shipment_rate_id = '';
					if(!empty($shipment->rates)) {
						foreach($shipment->rates as $rate_data) {
							if($rate_data->service == "Priority") {
								$shipment_rate_id = $rate_data->id;
							}
						}
					}
					if($shipment_rate_id!="") {
						$shipment->buy(array('rate' => array('id' => $shipment_rate_id)));
					} else {
						$shipment->buy(array(
						  'rate' => $shipment->lowest_rate(),
						));
					}
		
					//$shipment->buy(array(
					  //'rate' => $shipment->lowest_rate(),
					//));

					if($shipping_insurance == '1' && $f_shipping_insurance_price > 0) {
						$shipment->insure(array('amount' => $f_shipping_insurance_price));
					}

					$shipment->label(array(
					  'file_format' => 'PDF'
					));
					
					/*echo '<pre>';
					print_r($shipment);
					exit;*/
					
					$shipment_id = $shipment->id;
					$shipment_tracking_code = $shipment->tracker->tracking_code;
					//$shipment_label_url = $shipment->postage_label->label_url;
					$shipment_label_url = $shipment->postage_label->label_pdf_url;

					$shipment_label_ext = pathinfo($shipment_label_url,PATHINFO_EXTENSION);
					$shipment_label_custom_name = "Shipping-Label-".$order_id.".".$shipment_label_ext;
				} else {
					$msg='Unable to create shipment, one or more parameters were invalid.';
					setRedirectWithMsg(SITE_URL.'checkout',$msg,'error');
					exit();
				}
			} catch(\EasyPost\Error $e) {
				$shipment_error = "Error: ".$e->getHttpStatus().":".$e->getMessage();
				error_log("Error: ".$e->getHttpStatus().":".$e->getMessage());

				$msg='Unable to create shipment, one or more parameters were invalid.';
				setRedirectWithMsg(SITE_URL.'checkout',$msg,'error');
				exit();
			}
		} else {
			$shipment_id = '';
			$shipment_tracking_code = '';
			$shipment_label_url = '';
			$shipment_label_custom_name = '';
		} //END post shipment by easypost API

		//START logic for promocode
		/*$promocode_id = $post['promocode_id'];
		$promo_code = $post['promocode_value'];
		if($promocode_id!='' && $promo_code!="" && $sum_of_orders>0) {
			$query=mysqli_query($db,"SELECT * FROM `promocode` WHERE LOWER(promocode)='".strtolower($promo_code)."' AND ((never_expire='1' AND from_date <= '".$date."') OR (never_expire!='1' AND from_date <= '".$date."' AND to_date>='".$date."'))");
			$promo_code_data = mysqli_fetch_assoc($query);

			$is_allow_code_from_same_cust = true;
			if($promo_code_data['multiple_act_by_same_cust']=='1' && $promo_code_data['multi_act_by_same_cust_qty']>0) {
				$query=mysqli_query($db,"SELECT COUNT(*) AS multiple_act_by_same_cust FROM `orders` WHERE promocode_id='".$promo_code_data['id']."' AND user_id='".$user_id."'");
				$act_by_same_cust_data = mysqli_fetch_assoc($query);
				if($act_by_same_cust_data['multiple_act_by_same_cust']>$promo_code_data['multi_act_by_same_cust_qty']) {
					$is_allow_code_from_same_cust = false;
				}
			}

			$is_allow_code_from_cust = true;
			if($promo_code_data['act_by_cust']>0) {
				$query=mysqli_query($db,"SELECT COUNT(*) AS act_by_cust FROM `orders` WHERE promocode_id='".$promo_code_data['id']."'");
				$act_by_cust_data = mysqli_fetch_assoc($query);
				if($act_by_cust_data['act_by_cust']>$promo_code_data['act_by_cust']) {
					$is_allow_code_from_cust = false;
				}
			}

			$is_promocode_exist = false;
			if(!empty($promo_code_data) && $is_allow_code_from_same_cust && $is_allow_code_from_cust) {
				$discount = $promo_code_data['discount'];
				if($promo_code_data['discount_type']=="flat") {
					$discount_of_amt = $discount;
					$total = ($sum_of_orders+$discount);
					$discount_amt_with_format = amount_fomat($discount_of_amt);
					$discount_amt_label = "Surcharge: ";
				} elseif($promo_code_data['discount_type']=="percentage") {
					$discount_of_amt = (($sum_of_orders*$discount) / 100);
					$total = ($sum_of_orders+$discount_of_amt);
					$discount_amt_with_format = amount_fomat($discount_of_amt);
					$discount_amt_label = "Surcharge (".$discount."%): ";
				}
				$is_promocode_exist = true;
			} else {
				$msg = "This promo code has expired or not allowed.";
				setRedirectWithMsg(SITE_URL.'revieworder',$msg,'info');
				exit();
			}
		}*/ //END logic for promocode
		$total = $sum_of_orders;
		
		$approved_date = ",approved_date='".$datetime."'";
		$expire_date = ",expire_date='".date("Y-m-d H:i:s",strtotime($datetime." +".$order_expired_days." day"))."'";

		/*$order_status = "awaiting_shipment";
		if($hide_device_order_valuation_price=='1') {
			$order_status = "submitted";
		}*/
		$order_status = "submitted";

		$upt_order_query = mysqli_query($db,"UPDATE `orders` SET `payment_method`='".$payment_method."', paypal_address='".real_escape_string($post['paypal_address'])."', chk_name='".real_escape_string($post['chk_name'])."', chk_street_address='".real_escape_string($post['chk_street_address'])."', chk_street_address_2='".real_escape_string($post['chk_street_address_2'])."', chk_city='".real_escape_string($post['chk_city'])."', chk_state='".real_escape_string($post['chk_state'])."', chk_zip_code='".real_escape_string($post['chk_zip_code'])."', act_name='".real_escape_string($post['act_name'])."', act_number='".real_escape_string($post['act_number'])."', act_short_code='".real_escape_string($post['act_short_code'])."', `user_id`='".$user_id."', `status`='".$order_status."', `date`='".$datetime."', `sales_pack`='".$shipping_method."', shipping_api='".$shipping_api."', shipment_id='".$shipment_id."', shipment_tracking_code='".$shipment_tracking_code."', shipment_label_url='".$shipment_label_url."', shipment_label_custom_name='".$shipment_label_custom_name."', promocode_id='".$promocode_id."', promocode='".$promo_code."', promocode_amt='".$discount_of_amt."', discount_type='".$promo_code_data['discount_type']."', discount='".$discount."', cash_name='".$cash_name."', cash_phone='".$cash_phone."', cash_location='".$cash_location."', zelle_email='".real_escape_string($post['zelle_email'])."', express_service='".$express_service."', express_service_price='".$express_service_price."', shipping_insurance='".$shipping_insurance."', shipping_insurance_per='".$shipping_insurance_per."'".$approved_date.$expire_date." WHERE order_id='".$order_id."'");
		if($upt_order_query == '1') {
			//START append order items to block
			//Get order item list based on orderID, path of this function (get_order_item_list) admin/include/functions.php
			$order_item_list = get_order_item_list($order_id);
			foreach($order_item_list as $order_item_list_data) {
				//path of this function (get_order_item) admin/include/functions.php
				$order_item_data = get_order_item($order_item_list_data['id'],'email');
				// $order_list .= '<tr>
				// 	<td bgcolor="#ddd" width="60%" style="padding:15px;">'.$order_item_list_data['device_title'].' - '.$order_item_data['device_type'].'</td>
				// 	<td bgcolor="#ddd" width="20%" style="padding:15px;text-align:center;">'.$order_item_list_data['quantity'].'</td>';
				// 	if($hide_device_order_valuation_price!='1') {
				// 	$order_list .= '<td bgcolor="#ddd" width="20%" style="padding:15px;text-align:right;">'.amount_fomat($order_item_list_data['price']).'</td>';
				// 	}
				// $order_list .= '</tr>
				// <tr>
				// 	<td style="padding:1px;"></td>
				// </tr>';

				$order_list .= '<tr><td><table><tbody><tr><td>'
														.'<img class="summary-img" src="'.SITE_URL.'libraries/phpthumb.php?imglocation='.SITE_URL.'images/mobile/'.$order_item_list_data['model_img'].'&h=509">'
													.'</td><td><table><tbody>'
																.'<tr>'
																	.'<td class="summary-device-name">'.$order_item_list_data['model_title'].'</td>'										
																.'</tr><tr>'
																	.'<td class="summary-device-attribute">'.$order_item_data['device_type'].'</td>'
																.'</tr><tr>'
																	.'<td><a class="summary-device-edit-btn" href="">EDIT</a></td>'
																.'</tr></tbody></table></td></tr></tbody></table></td>'
									.'<td class="summary-device-quantity">'.$order_item_list_data['quantity'].'</td>';

									if($hide_device_order_valuation_price!='1') {
										$order_list .= '<td>$430.00</td>';
									}
									
								$order_list .= '</tr>';

			} //END append order items to block

$visitor_body .= '<table border="0" cellpadding="0" cellspacing="0"><thead><tr>'
.'<th class="offer-summary-header" colspan="2">HERE\'S YOUR OFFER SUMMARY</th></tr>'
.'</thead><tbody><tr>'			
			.'<td class="contact-additional-info-container">'
				.'<table border="0" cellpadding="0" cellspacing="0" class="contact-additional-info-box">'
					.'<thead><tr><th class="contact-additional-info">CONTACT INFORMATION</th>	</tr></thead><tbody><tr><td class="contact-additional-info-1">John Doe</td></tr><tr>'
					.'<td>5220 Fairmount Dr.</td>'
					.'</tr><tr><td>Arlington,</td></tr><tr><td>Tx, 76017</td></tr><tr><td>(781)-542-3342</td></tr>'
						.'<tr><td>Johndoe@gmail.com</td></tr></tbody></table>'
				.'<table border="0" cellpadding="0" cellspacing="0" class="contact-additional-info-box">'
					.'<thead><tr><th class="contact-additional-info">ADITIONAL INFORMATION</th>'	
						.'</tr></thead><tbody><tr><td class="contact-additional-info-1">Offer Date/Time</td></tr><tr><td>12/31/2019 / 3:00PM CST</td></tr>'
						.'<tr><td class="contact-additional-info-1">PAYOUT PREFERENCE</td></tr><tr><td>PayPal</td></tr></tbody></table>'
			.'</td><td class="summary-content-container">'				
				.'<table  border="0" cellpadding="0" cellspacing="0">'
					.'<thead><tr><th class="offer-id">OFFER #'.$order_id.'</th></tr><tr>'
							.'<th class="offer-tip">You may cancel your trade-in offer up until your device is deliveried to us.</th>'
						.'</tr></thead><tbody><tr><td>'
								.'<table border="0" cellpadding="0" cellspacing="0">'
									.'<thead><tr><th class="summary-table-header">DETAILS</th>'

											.'<th class="summary-table-header">QUANTITY</th>';

											if($hide_device_order_valuation_price!='1'){
												$visitor_body .= '<th class="summary-table-header">VALUE</th>';
											}
											
									$visitor_body .= '</tr></thead><tbody>'
										.$order_list					
										.'</tbody></table></td></tr><tr>'
							.'<td style="    border-top: 2px solid #f1bb00;padding-top: 2em;">'
									.'<table class="summary-total" align="right" border="0" cellpadding="0" cellspacing="0"><thead><tr><th class="summary-total-header" colspan="2">SUMMARY</th></tr></thead><tbody>';

if($hide_device_order_valuation_price!='1') {
		$visitor_body .= '<tr><td class="summary-total-field">Sell Order total</td>'
												.'<td class="summary-total-value">'.($sum_of_orders>0?amount_fomat($sum_of_orders):'').'</td></tr><tr>';		
			$visitor_body .= '<tr><td class="summary-total-field">PREPAID SHIPPING</td>'
			.'<td class="summary-total-value">FREE</td></tr>';

			if($is_promocode_exist || $f_express_service_price>0 || $f_shipping_insurance_price>0) {
					if($is_promocode_exist) {
						$visitor_body .= '<tr><td class="summary-total-field">'.$discount_amt_label.'</td>'
							.'<td class="summary-total-value">'.$discount_amt_with_format.'</td></tr>';
						}
						
						if($f_express_service_price) {
							$visitor_body .= '<tr><td class="summary-total-field">EXPRESS SERVICE</td>'
							.'<td class="summary-total-value">'.amount_fomat($f_express_service_price).'</td></tr>';

						}
						
						if($f_shipping_insurance_price) {

							$visitor_body .= '<tr><td class="summary-total-field">SHIPPING INSURANCE</td>'
							.'<td class="summary-total-value">'.amount_fomat($f_shipping_insurance_price).'</td></tr>';


						}

						$visitor_body .= '</tbody><tfoot><tr><td class="summary-total-footer">TOTAL PAYTOU</td>'
							.'<td class="summary-total-value" style="border-top:2px solid #ccc">'.amount_fomat(($total - $f_express_service_price - $f_shipping_insurance_price)).'</td></tr></tfoot>';
				
				$visitor_body	.='</table></td></tr></tbody></table></td></tr></tbody></table>';

			}else{

				$visitor_body	.='</tbody></table></td></tr></tbody></table></td></tr></tbody></table>';	
			}

			
}else{
	$visitor_body	.='</tbody></table></td></tr></tbody></table></td></tr></tbody></table>';
}







											
			// $visitor_body .= '<table width="650" cellpadding="0" cellspacing="0">';
			// 	$visitor_body .= '
			// 		<tr><td style="padding:10px;"></td></tr>
			// 		<tr>
			// 			<td width="60%" bgcolor="#e0f2f7" style="padding:15px;"><strong>Handset/Device Type</strong></td>
			// 			<td width="20%" bgcolor="#e0f2f7" style="padding:15px;text-align:center;"><strong>Quantity</strong></td>';
			// 			if($hide_device_order_valuation_price!='1') {
			// 			$visitor_body .= '<td width="20%" bgcolor="#e0f2f7" style="padding:15px;text-align:right;"><strong>Subtotal</strong></td>';
			// 			}
			// 	$visitor_body .= '
			// 		</tr>
			// 		<tr><td style="padding:0px;"></td></tr>';
			// 	$visitor_body .= '<tbody>'.$order_list;
				// if($hide_device_order_valuation_price!='1') {
				// 	$visitor_body .= '<tr>
				// 		<td></td>
				// 		<td style="padding:5px;text-align:right;"><strong>Sell Order Total:</strong></td>
				// 		<td style="padding:5px;text-align:right;">'.($sum_of_orders>0?amount_fomat($sum_of_orders):'').'</td>
				// 	</tr>';
				// 	if($is_promocode_exist || $f_express_service_price>0 || $f_shipping_insurance_price>0) {
				// 		if($is_promocode_exist) {
				// 			$visitor_body .= '<tr>
				// 				<td></td>
				// 				<td style="padding:5px;text-align:right;"><strong>'.$discount_amt_label.'</strong></td>
				// 				<td style="padding:5px;text-align:right;">'.$discount_amt_with_format.'</td>
				// 			</tr>';
				// 		}
						
				// 		if($f_express_service_price) {
				// 			$visitor_body .= '<tr>
				// 				<td></td>
				// 				<td style="padding:5px;text-align:right;"><strong>Express Service</strong></td>
				// 				<td style="padding:5px;text-align:right;">-'.amount_fomat($f_express_service_price).'</td>
				// 			</tr>';
				// 		}
						
				// 		if($f_shipping_insurance_price) {
				// 			$visitor_body .= '<tr>
				// 				<td></td>
				// 				<td style="padding:5px;text-align:right;"><strong>Shipping Insurance</strong></td>
				// 				<td style="padding:5px;text-align:right;">-'.amount_fomat($f_shipping_insurance_price).'</td>
				// 			</tr>';
				// 		}
						
				// 		$visitor_body .= '<tr>
				// 			<td></td>
				// 			<td style="padding:5px;text-align:right;"><strong>Total:</strong></td>
				// 			<td style="padding:5px;text-align:right;">'.amount_fomat(($total - $f_express_service_price - $f_shipping_insurance_price)).'</td>
				// 		</tr>';
				// 	}
				// }
			// 	$visitor_body .= '</tbody>';
			// $visitor_body .= '</table>';

			$template_data = get_template_data('new_order_email_to_customer');
			$template_data_for_admin = get_template_data('new_order_email_to_admin');
			$order_data = get_order_data($order_id);

			//Get admin user data
			$admin_user_data = get_admin_user_data();

			$patterns = array(
				'{$logo}','{$header_logo}','{$footer_logo}',
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
				'{$order_item_list}');

			$replacements = array(
				$logo,$header_logo,$footer_logo,
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
				ucwords(str_replace("_"," ",$order_data['order_status'])),
				$order_data['sales_pack'],
				format_date($datetime).' '.format_time($datetime),
				$visitor_body);

//START for generate barcode
$barcode_img_nm = "barcode_".date("YmdHis").".png";
$get_barcode_data = file_get_contents(SITE_URL.'libraries/barcode.php?text='.$order_id.'&codetype=code128&orientation=horizontal&size=30&print=false');
file_put_contents('../images/barcode/'.$barcode_img_nm, $get_barcode_data);
$barcode_img_path = '<img src="'.SITE_URL.'images/barcode/'.$barcode_img_nm.'"/>';
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

$html.='
<table cell-padding="0" cell-spacing="0" border="0;" width="100%" style="padding:15px 15px 15px 15px;font-size:12px;">
	<tbody>
	  <tr>
		<td colspan="2"><h2 style="font-size:18px;">'.$company_name.' Packing Slip</h2></td>
		<td><img width="210" src="'.SITE_URL.'images/'.$general_setting_data['logo'].'"></td>
	  </tr>
	  <tr>
		<td>
			<dl>
				<dt>'.$user_data['name'].'</dt>
				<dt>'.$user_data['address'].'</dt>
				<dt>'.$user_data['city'].', '.$user_data['state'].' '.$user_data['postcode'].'</dt>
			</dl>
		</td>
		<td>&nbsp;</td>
		<td>
			<dl>
				<dt>'.$barcode_img_path.'</dt>
				<dt><strong>Order Number:</strong> #'.$order_id.'</dt>
				<dt><strong>Date Of Offer:</strong> '.format_date($order_data['order_date']).'</dt>
				<dt><strong>Payment Method:</strong> '.$order_data['payment_method'].'</dt>
			</dl>
		</td>
	  </tr>
	</tbody>
</table>
<table cell-padding="0" cell-spacing="0" border="0;" width="100%" style="padding:10px 10px 10px 10px;">';

	foreach($order_item_list as $order_item_list_data) {
		//path of this function (get_order_item) admin/include/functions.php
		$order_item_data = get_order_item($order_item_list_data['id'],'email');
		$order_list_pdf .= '<tr>
			<td bgcolor="#ddd" width="10%" style="padding:15px;">'.($n=$n+1).'</td>
			<td bgcolor="#ddd" width="50%" style="padding:15px;">'.$order_item_list_data['brand_title'].' - '.$order_item_data['device_type'].'</td>
			<td bgcolor="#ddd" width="20%" style="padding:15px;text-align:center;">'.$order_item_list_data['quantity'].'</td>';
			if($hide_device_order_valuation_price!='1') {
			$order_list_pdf .= '<td bgcolor="#ddd" width="20%" style="padding:15px;text-align:right;">'.amount_fomat($order_item_list_data['price']).'</td>';
			}
		$order_list_pdf .= '</tr>';
	} //END append order items to block
	
	$html .= '
		<tr>
			<td width="10%" bgcolor="#e0f2f7" style="padding:15px;"><strong>Line</strong></td>
			<td width="50%" bgcolor="#e0f2f7" style="padding:15px;"><strong>Product Details</strong></td>
			<td width="20%" bgcolor="#e0f2f7" style="padding:15px;text-align:center;"><strong>Quantity</strong></td>';
			if($hide_device_order_valuation_price!='1') {
			$html .= '<td width="20%" bgcolor="#e0f2f7" style="padding:15px;text-align:right;"><strong>Subtotal</strong></td>';
			}
		$html .= '</tr>';
	$html .= '<tbody>'.$order_list_pdf;
		if($hide_device_order_valuation_price!='1') {
		$html .= '<tr>
			<td>&nbsp;</td>
			<td colspan="2" style="text-align:right;"><strong>Sell Order Total:</strong></td>
			<td style="text-align:right;">'.($sum_of_orders>0?amount_fomat($sum_of_orders):'').'</td>
		</tr>';
		if($is_promocode_exist) {
			$html .= '<tr>
				<td>&nbsp;</td>
				<td colspan="2" style="text-align:right;"><strong>'.$discount_amt_label.'</strong></td>
				<td style="text-align:right;">'.$discount_amt_with_format.'</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td colspan="2" style="text-align:right;"><strong>Total:</strong></td>
				<td style="text-align:right;">'.amount_fomat($total).'</td>
			</tr>';
		}
		
		if($is_promocode_exist || $f_express_service_price>0 || $f_shipping_insurance_price>0) {
			if($is_promocode_exist) {
				$html .= '<tr>
					<td>&nbsp;</td>
					<td colspan="2" style="text-align:right;"><strong>'.$discount_amt_label.'</strong></td>
					<td style="text-align:right;">'.$discount_amt_with_format.'</td>
				</tr>';
			}
			
			if($f_express_service_price) {
				$html .= '<tr>
					<td>&nbsp;</td>
					<td colspan="2" style="text-align:right;"><strong>Express Service:</strong></td>
					<td style="text-align:right;">-'.amount_fomat($f_express_service_price).'</td>
				</tr>';
			}
			
			if($f_shipping_insurance_price) {
				$html .= '<tr>
					<td>&nbsp;</td>
					<td colspan="2" style="text-align:right;"><strong>Shipping Insurance:</strong></td>
					<td style="text-align:right;">-'.amount_fomat($f_shipping_insurance_price).'</td>
				</tr>';
			}
			
			$html .= '<tr>
				<td>&nbsp;</td>
				<td colspan="2" style="text-align:right;"><strong>Total:</strong></td>
				<td style="text-align:right;">'.amount_fomat(($total - $f_express_service_price - $f_shipping_insurance_price)).'</td>
			</tr>';
		}
					
		}
	$html .= '</tbody>';
	$html .= '</table>';

$html.='<table cell-padding="0" cell-spacing="0" border="0;" width="100%" style="padding:10px 10px 10px 10px;">';
	$html.='<tbody>';
		$html .= '<tr>
			<td>Please include in your satchel<br>
			&nbsp;&nbsp;&nbsp;1. Device(s) Selected<br>
			&nbsp;&nbsp;&nbsp;2. Copy of packing list<br>
			&nbsp;&nbsp;&nbsp;3. Copy of Photo I.D (if not uploaded)<br><br>
			Please Reset Lock codes, or supply your user Lock code:……………………<br>
			Please send your device(s) within '.$order_expired_days.' days<br></td>
		</tr>';
	$html.='</tbody>
</table>';

//echo $html;
//exit;

require_once(CP_ROOT_PATH.'/libraries/tcpdf/config/tcpdf_config.php');
require_once(CP_ROOT_PATH.'/libraries/tcpdf/tcpdf.php');

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

$file_folder='pdf';
$file_folder_path = CP_ROOT_PATH.'/'.$file_folder;
if(!file_exists($file_folder_path))
	mkdir($file_folder_path, 0777);

//$pdf_name='order-'.date('Y-m-d-H-i-s').'.pdf';
$pdf_name='order-'.$order_id.'.pdf';
$pdf->Output($file_folder_path.'/'.$pdf_name, 'F');
//echo SITE_URL.$file_folder.'/'.$pdf_name;
//exit;

			//START email send to customer
			if(!empty($template_data)) {
				$email_subject = str_replace($patterns,$replacements,$template_data['subject']);
				$email_body_text = str_replace($patterns,$replacements,$template_data['content']);

				if($shipment_label_url!="") {
					//$shipment_basename_label_url = basename($shipment_label_url);
					$shipment_basename_label_url = $shipment_label_custom_name;
					$label_copy_to_our_srvr = copy($shipment_label_url,'../shipment_labels/'.$shipment_basename_label_url);

					$attachment_data['basename'] = array($shipment_basename_label_url,$pdf_name);
					$attachment_data['folder'] = array('shipment_labels','pdf');
					send_email($user_data['email'], $email_subject, $email_body_text, FROM_NAME, FROM_EMAIL, $attachment_data);
				} else {
					$attachment_data['basename'] = array($pdf_name);
					$attachment_data['folder'] = array('pdf');
					send_email($user_data['email'], $email_subject, $email_body_text, FROM_NAME, FROM_EMAIL, $attachment_data);
				}

				//START sms send to customer
				if($template_data['sms_status']=='1') {
					$from_number = '+'.$general_setting_data['twilio_long_code'];
					$to_number = '+'.$user_data['phone'];
					if($from_number && $account_sid && $auth_token) {
						$sms_body_text = str_replace($patterns,$replacements,$template_data['sms_content']);
						try {
							$sms = $sms_api->account->messages->sendMessage($from_number, $to_number, $sms_body_text, $image, array('StatusCallback'=>''));
						} catch(Services_Twilio_RestException $e) {
							$sms_error_msg = $e->getMessage();
							error_log($sms_error_msg);
						}
					}
				} //END sms send to customer
			} //END email send to customer

			//START email send to admin
			if(!empty($template_data_for_admin)) {
				$email_subject_for_admin = str_replace($patterns,$replacements,$template_data_for_admin['subject']);
				$email_body_text_for_admin = str_replace($patterns,$replacements,$template_data_for_admin['content']);
				send_email($admin_user_data['email'], $email_subject_for_admin, $email_body_text_for_admin, $user_data['name'], $user_data['email']);
			} //END email send to admin

			//If order confirmed then final data saved/updated of order & unset all session items
			unset($_SESSION['order_item_ids']);

			if($_SESSION['tmp_order_id']!="") {
				unset($_SESSION['tmp_order_id']);
			}
			
			//Change session order_id to tmp_order_id & unset order_id session, it will use on only place_order page.
			$_SESSION['tmp_order_id'] = $order_id;
			unset($_SESSION['order_id']);
			unset($_SESSION['payment_method']);

			$msg = "Your sell order (#".$order_id.") is almost complete.";
			setRedirectWithMsg(SITE_URL.'order-comlete',$msg,'success');
		} else {
			$msg='Sorry, something went wrong';
			setRedirectWithMsg(SITE_URL.'revieworder',$msg,'error');
		}
		exit();
	} else {
		setRedirect(SITE_URL.'revieworder');
		exit();
	}
} else {
	$msg='Direct access denied';
	setRedirectWithMsg(SITE_URL,$msg,'danger');
	exit();
} ?>