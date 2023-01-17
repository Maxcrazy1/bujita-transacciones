<?php 
require_once("../../_config/config.php");
require_once("../../include/functions.php");

$order_id = $post['order_id'];
$order_data_before_saved = get_order_data($order_id);

if($order_data_before_saved['promocode_id']>0 && $order_data_before_saved['promocode_amt']>0) {
	$promocode_amt = $order_data_before_saved['promocode_amt'];
	$discount_amt_label = "Surcharge:";
	if($order_data_before_saved['discount_type']=="percentage")
		$discount_amt_label = "Surcharge (".$order_data_before_saved['discount']."% of Initial Quote):";

	$is_promocode_exist = true;
}

if(isset($post['update'])) {
	$note=real_escape_string($post['note']);
	$changed_price_of_order_item = $post['price'];
	$status=$post['status'];
	$content=$post['content'];

	mysqli_query($db,"INSERT INTO `order_messaging`(`order_id`, `note`, status, type, `date`) VALUES('".$order_id."','".$note."', '".$order_data_before_saved['status']."','admin','".date('Y-m-d H:i:s')."')");
	$last_msg_id = mysqli_insert_id($db);

	if(!empty($changed_price_of_order_item)) {
		foreach($changed_price_of_order_item as $key=>$value) {
			mysqli_query($db,'UPDATE order_items SET price="'.$value.'" WHERE id="'.$key.'"');
			mysqli_query($db,"INSERT INTO `order_items_history`(`order_item_id`, `msg_id`, `price`, `date`) VALUES('".$key."','".$last_msg_id."','".$post['price'][$key]."','".date('Y-m-d H:i:s')."')");
		}
	}

	$order_sum_query=mysqli_query($db,"SELECT SUM(price) AS sum_of_orders FROM order_items WHERE order_id='".$order_id."'");
	$orders_sum=mysqli_fetch_assoc($order_sum_query);
	$sell_order_total = ($orders_sum['sum_of_orders']>0?$orders_sum['sum_of_orders']:'');
	
	//START append order items to block
	$order_query=mysqli_query($db,"SELECT oi.*, o.`payment_method`, o.`date`, o.`approved_date`, o.`expire_date`, o.`status`, o.`sales_pack`, o.`paypal_address`, o.`chk_name`, o.`chk_street_address`, o.`chk_street_address_2`, o.`chk_city`, o.`chk_state`, o.`chk_zip_code`, o.`act_name`, o.`act_number`, o.`act_short_code`, o.`note`, d.title AS device_title, m.title AS model_title FROM order_items AS oi LEFT JOIN orders AS o ON o.order_id=oi.order_id LEFT JOIN devices AS d ON d.id=oi.device_id LEFT JOIN mobile AS m ON m.id=oi.model_id WHERE o.order_id='".$order_id."' ORDER BY oi.id DESC");
	while($order_data=mysqli_fetch_assoc($order_query)) {
		$order_item_data = get_order_item($order_data['id'],'email');
		$order_list .= '<tr>
			<td bgcolor="#ddd" width="60%" style="padding:15px;">'.$order_item_data['device_title'].'<br>'.$order_item_data['device_info'].'</td>
			<td bgcolor="#ddd" width="20%" style="padding:15px;text-align:center;">'.$order_data['quantity'].'</td>
			<td bgcolor="#ddd" width="20%" style="padding:15px;text-align:right;"><b style="text-decoration: line-through;">'.amount_fomat($post['old_price'][$order_data['id']]).'</b>&nbsp;&nbsp;<b>'.amount_fomat($order_data['price']).'</b></td>
		</tr>
		<tr>
			<td style="padding:1px;"></td>
		</tr>';
	}
	
	$visitor_body .= '<table width="650" cellpadding="0" cellspacing="0">';
		$visitor_body .= '
			<tr>
				<td style="padding:10px;"></td>
			</tr>
			<tr>
				<td width="60%" bgcolor="#e0f2f7" style="padding:15px;"><strong>Handset/Device Type</strong></td>
				<td width="20%" bgcolor="#e0f2f7" style="padding:15px;text-align:center;"><strong>Quantity</strong></td>
				<td width="20%" bgcolor="#e0f2f7" style="padding:15px;text-align:right;"><strong>Price</strong></td>
			</tr>
			<tr>
				<td style="padding:0px;"></td>
			</tr>';
		$visitor_body .= '<tbody>'.$order_list;
			$visitor_body .= '<tr>
				<td></td>
				<td style="padding:5px;text-align:right;"><strong>Sell Order Total:</strong></td>
				<td style="padding:5px;text-align:right;">'.amount_fomat($sell_order_total).'</td>
			</tr>';
			if($is_promocode_exist) {
				$total = ($sell_order_total+$promocode_amt);
				$visitor_body .= '<tr>
					<td></td>
					<td style="padding:5px;text-align:right;"><strong>'.$discount_amt_label.'</strong></td>
					<td style="padding:5px;text-align:right;">'.amount_fomat($promocode_amt).'</td>
				</tr>
				<tr>
					<td></td>
					<td style="padding:5px;text-align:right;"><strong>Total:</strong></td>
					<td style="padding:5px;text-align:right;">'.amount_fomat($total).'</td>
				</tr>';
			}
		$visitor_body .= '</tbody>';
	$visitor_body .= '</table>';
	//END append order items to block

	$template_data = get_template_data('admin_reply_from_offer');
	$template_data_rejected = get_template_data('admin_reply_from_offer_as_rejected');
	$general_setting_data = get_general_setting_data();
	$admin_user_data = get_admin_user_data();
	$order_data = get_order_data($order_id);

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
		'{$customer_company_name}',
		'{$order_id}',
		'{$order_payment_method}',
		'{$order_date}',
		'{$order_approved_date}',
		'{$order_expire_date}',
		'{$order_status}',
		'{$order_sales_pack}',
		'{$current_date_time}',
		'{$order_note}',
		'{$order_item_list}',
		'{$offer_accept_link}',
		'{$offer_reject_link}',
		'{$order_total}');

	$offer_accept_link = '<a href="'.SITE_URL.'offer-status/'.$order_id.'/offer_accepted">ACCEPT OFFER</a>';
	$offer_reject_link = '<a href="'.SITE_URL.'offer-status/'.$order_id.'/offer_rejected">REJECT OFFER</a>';
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
		$order_data['first_name'],
		$order_data['last_name'],
		$order_data['name'],
		$order_data['phone'],
		$order_data['email'],
		$order_data['address'],
		$order_data['address2'],
		$order_data['city'],
		$order_data['state'],
		$order_data['country'],
		$order_data['postcode'],
		$order_data['company_name'],
		$order_data['order_id'],
		$order_data['payment_method'],
		$order_data['order_date'],
		$order_data['approved_date'],
		$order_data['expire_date'],
		ucwords(str_replace("_"," ",$order_data['order_status'])),
		$order_data['sales_pack'],
		format_date(date('Y-m-d H:i')).' '.format_time(date('Y-m-d H:i')),
		$post['note'],
		$visitor_body,
		$offer_accept_link,
		$offer_reject_link,
		amount_fomat($total));
	
	if(!empty($template_data)) {
		$email_subject = str_replace($patterns,$replacements,$template_data['subject']);
		$email_body_text = str_replace($patterns,$replacements,$content);	
		send_email($order_data['email'], $email_subject, $email_body_text, FROM_NAME, FROM_EMAIL);
		
		//START sms send to customer
		if($template_data['sms_status']=='1' && $sms_sending_status=='1') {
			$from_number = '+'.$general_setting_data['twilio_long_code'];
			$to_number = '+'.$order_data['phone'];
			if($from_number && $account_sid && $auth_token) {
				$sms_body_text = str_replace($patterns,$replacements,$template_data['sms_content']);
				try {
					$sms = $sms_api->account->messages->sendMessage($from_number, $to_number, $sms_body_text, $image, array('StatusCallback'=>''));
				} catch(Services_Twilio_RestException $e) {
					echo $sms_error_msg = $e->getMessage();
					error_log($sms_error_msg);
				}
			}
		} //END sms send to customer
	}

	$msg="Successfully Offer send to Customer";
	$_SESSION['success_msg']=$msg;
	setRedirect(ADMIN_URL.'order_offer.php?order_id='.$post['order_id']);
} else {
	setRedirect(ADMIN_URL.'orders.php');
}
exit();
?>
