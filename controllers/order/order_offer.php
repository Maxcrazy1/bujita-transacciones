<?php
require_once("../../admin/_config/config.php");
require_once("../../admin/include/functions.php");
		
$user_id = $_SESSION['user_id'];
$order_id = $post['order_id'];

//Get order batch data, path of this function (get_order_data) admin/include/functions.php
$order_data_before_saved = get_order_data($order_id);

//Get order price based on orderID, path of this function (get_order_price) admin/include/functions.php
$sum_of_orders=get_order_price($order_id);

if($order_data_before_saved['promocode_id']>0 && $order_data_before_saved['promocode_amt']>0) {
	$promocode_amt = $order_data_before_saved['promocode_amt'];
	$discount_amt_label = "Surcharge:";
	if($order_data_before_saved['discount_type']=="percentage")
		$discount_amt_label = "Surcharge (".$order_data_before_saved['discount']."% of Initial Quote):";

	$is_promocode_exist = true;
}

if(isset($post['submit_resp_offer'])) {
	$datetime = date('Y-m-d H:i:s');
	$status = $post['status'];
	$note = real_escape_string($post['note']);
	if($note) {
		$q_updt_offer_st = mysqli_query($db,"UPDATE orders SET offer_status='".$status."' WHERE order_id='".$order_id."'");
		if($note) {
			mysqli_query($db,"INSERT INTO `order_messaging`(`order_id`, `note`, status, type, `date`) VALUES('".$order_id."','".$note."', '".$order_data_before_saved['status']."','customer','".date('Y-m-d H:i:s')."')");
		}
		
		if($q_updt_offer_st) {
			$sell_order_total = ($sum_of_orders>0?$sum_of_orders:'');
			
			//START append order items to block
			//Get order item list based on orderID, path of this function (get_order_item_list) admin/include/functions.php
			$order_item_list = get_order_item_list($order_id);
			foreach($order_item_list as $order_item_list_data) {
				//path of this function (get_order_item) admin/include/functions.php
				$order_item_data = get_order_item($order_item_list_data['id'],'email');
				
				$order_list .= '<tr>
					<td bgcolor="#ddd" width="60%" style="padding:15px;">'.$order_item_list_data['device_title'].' - '.$order_item_data['device_type'].'</td>
					<td bgcolor="#ddd" width="20%" style="padding:15px;text-align:center;">'.$order_item_list_data['quantity'].'</td>
					<td bgcolor="#ddd" width="20%" style="padding:15px;text-align:right;">'.amount_fomat($order_item_list_data['price']).'</td>
				</tr>
				<tr>
					<td style="padding:1px;"></td>
				</tr>';
			} //END append order items to block
			
			$visitor_body .= '<table width="650" cellpadding="0" cellspacing="0">';
				$visitor_body .= '
					<tr>
						<td style="padding:10px;"></td>
					</tr>
					<tr>
						<td width="60%" bgcolor="#e0f2f7" style="padding:15px;"><strong>Handset/Device Type</strong></td>
						<td width="20%" bgcolor="#e0f2f7" style="padding:15px;text-align:center;"><strong>Quantity</strong></td>
						<td width="20%" bgcolor="#e0f2f7" style="padding:15px;text-align:right;"><strong>Subtotal</strong></td>
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
	
			$template_data = get_template_data('customer_reply_from_offer');
			$order_data = get_order_data($order_id);
			
			//Get admin user data
			$admin_user_data = get_admin_user_data();
			
			$patterns = array(
				'{$logo}',
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
				'{$offer_status}',
				'{$order_sales_pack}',
				'{$current_date_time}',
				'{$order_note}',
				'{$order_item_list}',
				'{$order_total}');
	
			$replacements = array(
				$logo,
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
				$order_data['order_id'],
				$order_data['payment_method'],
				format_date($order_data['order_date']),
				format_date($order_data['approved_date']),
				format_date($order_data['expire_date']),
				ucwords(str_replace("_"," ",$order_data['order_status'])),
				ucwords(str_replace("_"," ",$status)),
				$order_data['sales_pack'],
				format_date($datetime).' '.format_time($datetime),
				$post['note'],
				$visitor_body,
				amount_fomat($total));
	
			if(!empty($template_data)) {
				$email_subject = str_replace($patterns,$replacements,$template_data['subject']);
				$email_body_text = str_replace($patterns,$replacements,$template_data['content']);
				send_email($admin_user_data['email'], $email_subject, $email_body_text, $user_data['name'], $user_data['email']);
			}
			$msg='You have successfully message send.';
			setRedirectWithMsg($return_url,$msg,'success');
		} else {
			$msg='Sorry, something went wrong';
			setRedirectWithMsg($return_url,$msg,'error');
		}
	} else {
		$msg='Please fill mandatory fields';
		setRedirectWithMsg($return_url,$msg,'warning');
	}
	exit();
} else {
	$msg='Direct access denied';
	setRedirectWithMsg(SITE_URL,$msg,'danger');
	exit();
} ?>