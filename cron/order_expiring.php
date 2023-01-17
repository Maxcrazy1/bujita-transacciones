<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");

$general_setting_data = get_general_setting_data();
$admin_user_data = get_admin_user_data();
$template_data = get_template_data('order_expiring');

echo '<pre>';
$future_date = date('Y-m-d',strtotime('+7 day'));
echo 'Date of order expiring:- '.$future_date;
$query = "SELECT o.*, u.*, u.id AS user_id FROM orders AS o LEFT JOIN users AS u ON u.id=o.user_id WHERE (o.status IN('awaiting_shipment') OR o.status IN('submitted')) AND DATE_FORMAT(o.expire_date,'%Y-%m-%d')='".$future_date."' ORDER BY o.id DESC";
$m_query=mysqli_query($db,$query);
$order_num_of_rows = mysqli_num_rows($m_query);
if($order_num_of_rows>0) {
	while($order_data=mysqli_fetch_assoc($m_query)) {
		$order_id = $order_data['order_id'];
		
		$temp_arr = strtolower($order_data['name']).";";
	    $temp_arr = preg_split("/[\s*]/", $temp_arr);
	    $hold ="";
	    foreach($temp_arr as $str){
	        $hold.= ucfirst($str)." ";
        }
	    $order_data['name'] = trim(preg_replace("/\;/", "", $hold));
		
		$order_items_list = '';
		$order_item_body = '';
		$patterns = array();
		$replacements = array();
		
		//Get order price based on orderID, path of this function (get_order_price) admin/include/functions.php
		$sum_of_orders=get_order_price($order_id);
		
		if($order_data['promocode_id']>0 && $order_data['promocode_amt']>0) {
			$promocode_amt = $order_data['promocode_amt'];
			$discount_amt_label = "Surcharge:";
			if($order_data['discount_type']=="percentage")
				$discount_amt_label = "Surcharge (".$order_data['discount']."% of Initial Quote):";
			 
			$total_of_order = $sum_of_orders;
			$is_promocode_exist = true;
		} else {
			$total_of_order = $sum_of_orders;
		}

		//START append order items to block
		//Get order item list based on orderID, path of this function (get_order_item_list) admin/include/functions.php
		$order_item_list = get_order_item_list($order_id);
		foreach($order_item_list as $order_item_list_data) {
			//path of this function (get_order_item) admin/include/functions.php
			$order_item_data = get_order_item($order_data['id'],'email');
			
			$order_items_list .= '<tr>
				<td bgcolor="#ddd" width="60%" style="padding:15px;">'.$order_item_list_data['device_title'].' - '.$order_item_data['device_type'].'</td>
				<td bgcolor="#ddd" width="20%" style="padding:15px;text-align:center;">'.$order_item_list_data['quantity'].'</td>
				<td bgcolor="#ddd" width="20%" style="padding:15px;text-align:right;">'.amount_fomat($order_item_list_data['price']).'</td>
			</tr>
			<tr>
				<td style="padding:1px;"></td>
			</tr>';
		}
		
		$order_item_body .= '<table width="650" cellpadding="0" cellspacing="0">';
			$order_item_body .= '
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
			$order_item_body .= '<tbody>'.$order_items_list;
				$order_item_body .= '<tr>
					<td></td>
					<td style="padding:5px;text-align:right;"><strong>Sell Order Total:</strong></td>
					<td style="padding:5px;text-align:right;">'.amount_fomat($total_of_order).'</td>
				</tr>';
				if($is_promocode_exist) {
					$total = ($total_of_order+$promocode_amt);
					$order_item_body .= '<tr>
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
			$order_item_body .= '</tbody>';
		$order_item_body .= '</table>';
		//END append order items to block

		$order_data = get_order_data($order_id);

		$patterns = array(
			'{$logo}', '{$header_logo}', '{$footer_logo}',
			'{$admin_logo}',
			'{$admin_email}',
			'{$admin_phone}',
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
			
			$pre_header = strip_tags($template_data['content']);
            $pre_header = preg_replace('/\{\$(header_logo)\}/i', '' ,$pre_header);
            $pre_header = preg_replace('/\{\$(footer_logo)\}/i', '' ,$pre_header);
            $pre_header = preg_replace('/\{\$(customer_fullname)\}(\W)/i', $order_data['name']."$2".' ' ,$pre_header);	
            
		$replacements_1 = array(
			$logo, $header_logo, $footer_logo,
			$admin_logo,
			$admin_user_data['email'],
			$general_setting_data['phone'],
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
			$order_data['order_date'],
			date('F, j Y',strtotime($order_data['approved_date'])),
			date('F, j Y',strtotime($order_data['expire_date'])),
			ucwords(str_replace("_"," ",$order_data['order_status'])),
			$order_data['sales_pack'],
			date('Y-m-d H:i'),
			$order_item_body);
            
			$pre_header = str_replace($patterns,$replacements_1,$pre_header);
			$header_logo = str_replace('my_preheader', substr($pre_header,0), $header_logo);
			
	    //$header_logo = str_replace('my_preheader', substr(preg_replace('/\{\$\w+\_\w+\}/i',"", preg_replace('/\{\$(customer_fullname)\}(\W)/i', $order_data['name']."$2".' ' ,$template_data['content'])),0,300), $header_logo);
	    
		$replacements = array(
			$logo, $header_logo, $footer_logo,
			$admin_logo,
			$admin_user_data['email'],
			$general_setting_data['phone'],
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
			$order_data['order_date'],
			date('F, j Y',strtotime($order_data['approved_date'])),
			date('F, j Y',strtotime($order_data['expire_date'])),
			ucwords(str_replace("_"," ",$order_data['order_status'])),
			$order_data['sales_pack'],
			date('Y-m-d H:i'),
			$order_item_body);

		//START email send to customer
		if(!empty($template_data)) {
			$email_subject = str_replace($patterns,$replacements,$template_data['subject']);
			$email_body_text = str_replace($patterns,$replacements,$template_data['content']);
			send_email($order_data['email'], $email_subject, $email_body_text, FROM_NAME, FROM_EMAIL);

			//START sms send to customer
			if($template_data['sms_status']=='1') {
				$from_number = '+'.$general_setting_data['twilio_long_code'];
				$to_number = '+'.$order_data['phone'];
				if($from_number && $account_sid && $auth_token) {
					$sms_body_text = str_replace($patterns,$replacements,$template_data['sms_content']);
					try {
						$sms = $sms_api->account->messages->sendMessage($from_number, $to_number, $sms_body_text, $image, array('StatusCallback'=>''));
					} catch(Services_Twilio_RestException $e) {
						echo 'Error: '.$sms_error_msg = $e->getMessage();
						error_log($sms_error_msg);
					}
				}
			} //END sms send to customer
		} //END email send to customer
	}
} else {
	echo '<br>Criteria not matched.';
}
exit;
?>