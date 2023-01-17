<?php
require_once("../../admin/_config/config.php");
require_once("../../admin/include/functions.php");

$user_id = $_SESSION['user_id'];
$order_id=$_SESSION['order_id'];

//If direct access then it will redirect to home page
if($user_id<=0) {
	setRedirect(SITE_URL);
	exit();
}

$order_item_ids = $_SESSION['order_item_ids'];
if(empty($order_item_ids))
	$order_item_ids = array();

//Get order price based on orderID, path of this function (get_order_price) admin/include/functions.php
$sum_of_orders = get_order_price($order_id);

//Get user data based on userID
$user_data = get_user_data($user_id);

if(isset($post['confirm_sale'])) {
	$num_of_item = $post['num_of_item'];
	if($num_of_item!=count($order_item_ids)) {
		setRedirect(SITE_URL.'revieworder');
		exit();
	}
	
	$date = date('Y-m-d');
	$datetime = date('Y-m-d H:i:s');
	
	if($user_id>0) {
		//START logic for promocode
		$amt = $sum_of_orders;
		$promocode_id = $post['promocode_id'];
		$promo_code = $post['promo_code'];
		if($promocode_id!='' && $promo_code!="" && $amt>0) {
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
					$total = ($amt+$discount);
					$discount_amt_with_format = amount_fomat($discount_of_amt);
					$discount_amt_label = "Surcharge: ";
				} elseif($promo_code_data['discount_type']=="percentage") {
					$discount_of_amt = (($amt*$discount) / 100);
					$total = ($amt+$discount_of_amt);
					$discount_amt_with_format = amount_fomat($discount_of_amt);
					$discount_amt_label = "Surcharge (".$discount."%): ";
				}
				$is_promocode_exist = true;
			} else {
				$msg = "This promo code has expired or not allowed.";
				setRedirectWithMsg(SITE_URL.'revieworder',$msg,'info');
				exit();
			}
		} //END logic for promocode
		
		$approved_date = ",approved_date='".$datetime."'";
		$expire_date = ",expire_date='".date("Y-m-d H:i:s",strtotime($datetime." +".$order_expired_days." day"))."'";

		$upt_order_query = mysqli_query($db,"UPDATE `orders` SET `user_id`='".$user_id."', `status`='awaiting_delivery', `date`='".$datetime."', promocode_id='".$promocode_id."', promocode='".$promo_code."', promocode_amt='".$discount_of_amt."', discount_type='".$promo_code_data['discount_type']."', discount='".$discount."'".$approved_date.$expire_date." WHERE order_id='".$order_id."'");
		if($upt_order_query == '1') {
			//START append order items to block
			//Get order item list based on orderID, path of this function (get_order_item_list) admin/include/functions.php
			$order_item_list = get_order_item_list($order_id);
			foreach($order_item_list as $order_item_list_data) {
				//path of this function (get_order_item) admin/include/functions.php
				$order_item_data = get_order_item($order_item_list_data['id'],'email');
				$order_list .= '<tr>
					<td bgcolor="#ddd" width="55%" style="padding:15px;">'.$order_item_data['device_title'].'<br>'.$order_item_data['device_info'].'</td>
					<td bgcolor="#ddd" width="15%" style="padding:15px;text-align:center;">'.$order_item_data['data']['imei_number'].'</td>
					<td bgcolor="#ddd" width="10%" style="padding:15px;text-align:center;">'.$order_item_list_data['quantity'].'</td>
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
						<td width="55%" bgcolor="#e0f2f7" style="padding:15px;"><strong>Handset/Device Type</strong></td>
						<td width="15%" bgcolor="#e0f2f7" style="padding:15px;text-align:center;"><strong>IMEI Number</strong></td>
						<td width="10%" bgcolor="#e0f2f7" style="padding:15px;text-align:center;"><strong>Quantity</strong></td>
						<td width="20%" bgcolor="#e0f2f7" style="padding:15px;text-align:right;"><strong>Price</strong></td>
					</tr>
					<tr>
						<td style="padding:0px;"></td>
					</tr>';
				$visitor_body .= '<tbody>'.$order_list;
					$visitor_body .= '<tr>
						<td></td>
						<td colspan="2" style="padding:5px;text-align:right;"><strong>Sell Order Total:</strong></td>
						<td style="padding:5px;text-align:right;">'.($sum_of_orders>0?amount_fomat($sum_of_orders):'').'</td>
					</tr>';
					if($is_promocode_exist) {
						$visitor_body .= '<tr>
							<td></td>
							<td colspan="2" style="padding:5px;text-align:right;"><strong>'.$discount_amt_label.'</strong></td>
							<td style="padding:5px;text-align:right;">'.$discount_amt_with_format.'</td>
						</tr>
						<tr>
							<td></td>
							<td colspan="2" style="padding:5px;text-align:right;"><strong>Total:</strong></td>
							<td style="padding:5px;text-align:right;">'.amount_fomat($total).'</td>
						</tr>';
					}
				$visitor_body .= '</tbody>';
			$visitor_body .= '</table>';

			$template_data = get_template_data('new_order_email_to_customer');
			$template_data_for_admin = get_template_data('new_order_email_to_admin');
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
				'{$order_sales_pack}',
				'{$current_date_time}',
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
				format_date($order_data['order_date']),
				format_date($order_data['approved_date']),
				format_date($order_data['expire_date']),
				ucwords(str_replace("_"," ",$order_data['order_status'])),
				$order_data['sales_pack'],
				format_date($datetime).' '.format_time($datetime),
				$visitor_body,
				amount_fomat($total));

//START for generate barcode
$barcode_img_nm = "barcode_".date("YmdHis").".png";
$get_barcode_data = file_get_contents(SITE_URL.'libraries/barcode.php?text='.$order_id.'&codetype=code128&orientation=horizontal&size=30&print=false');
file_put_contents('../../images/barcode/'.$barcode_img_nm, $get_barcode_data);
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
				<dt>'.$user_data['first_name'].' '.$user_data['last_name'].'</dt>
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
			<td bgcolor="#ddd" width="5%" style="padding:15px;">'.($n=$n+1).'</td>
			<td bgcolor="#ddd" width="47%" style="padding:15px;">'.$order_item_data['device_title'].'<br>'.$order_item_data['device_info'].'</td>
			<td bgcolor="#ddd" width="20%" style="padding:15px;text-align:center;">'.$order_item_list_data['imei_number'].'</td>
			<td bgcolor="#ddd" width="8%" style="padding:15px;text-align:center;">'.$order_item_list_data['quantity'].'</td>
			<td bgcolor="#ddd" width="20%" style="padding:15px;text-align:right;">'.amount_fomat($order_item_list_data['price']).'</td>
		</tr>';
	} //END append order items to block
	
	$html .= '
		<tr>
			<td width="5%" bgcolor="#e0f2f7" style="padding:15px;"><strong>Line</strong></td>
			<td width="47%" bgcolor="#e0f2f7" style="padding:15px;"><strong>Product Details</strong></td>
			<td width="20%" bgcolor="#e0f2f7" style="padding:15px;text-align:center;"><strong>IMEI Number</strong></td>
			<td width="8%" bgcolor="#e0f2f7" style="padding:15px;text-align:center;"><strong>Qty</strong></td>
			<td width="20%" bgcolor="#e0f2f7" style="padding:15px;text-align:right;"><strong>Price</strong></td>
		</tr>';
	$html .= '<tbody>'.$order_list_pdf;
		$html .= '<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan="2" style="text-align:right;"><strong>Sell Order Total:</strong></td>
			<td style="text-align:right;">'.($sum_of_orders>0?amount_fomat($sum_of_orders):'').'</td>
		</tr>';
		if($is_promocode_exist) {
			$html .= '<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan="2" style="text-align:right;"><strong>'.$discount_amt_label.'</strong></td>
				<td style="text-align:right;">'.$discount_amt_with_format.'</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan="2" style="text-align:right;"><strong>Total:</strong></td>
				<td style="text-align:right;">'.amount_fomat($total).'</td>
			</tr>';
		}
	$html .= '</tbody>';
 
	$html.='</tbody>
</table>';

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
				
				$attachment_data['basename'] = array($pdf_name);
				$attachment_data['folder'] = array('pdf');
				send_email($user_data['email'], $email_subject, $email_body_text, FROM_NAME, FROM_EMAIL, $attachment_data);

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
				
				//START Save data in inbox_mail_sms table
				$inbox_mail_sms_data = array("template_id" => $template_data['id'],
						"staff_id" => '',
						"user_id" => $user_id,
						"order_id" => $order_id,
						"from_email" => FROM_EMAIL,
						"to_email" => $user_data['email'],
						"subject" => $email_subject,
						"body" => $email_body_text,
						"sms_phone" => $to_number,
						"sms_content" => $sms_body_text,
						"date" => $datetime,
						"leadsource" => 'website',
						"form_type" => 'confirm_order');
				
				save_inbox_mail_sms($inbox_mail_sms_data);
				//END Save data in inbox_mail_sms table

			} //END email send to customer

			//START email send to admin
			if(!empty($template_data_for_admin)) {
				$email_subject_for_admin = str_replace($patterns,$replacements,$template_data_for_admin['subject']);
				$email_body_text_for_admin = str_replace($patterns,$replacements,$template_data_for_admin['content']);
				send_email($admin_user_data['email'], $email_subject_for_admin, $email_body_text_for_admin, $user_data['name'], $user_data['email']);
			} //END email send to admin

			//If order confirmed then final data saved/updated of order & unset all session items
			unset($_SESSION['order_item_ids']);
			
			//Change session order_id to tmp_order_id & unset order_id session, it will use on only place_order page.
			$_SESSION['tmp_order_id'] = $order_id;
			unset($_SESSION['order_id']);
			unset($_SESSION['payment_method']);

			$msg = "Your sell order (#".$order_id.") is almost complete.";
			setRedirectWithMsg(SITE_URL.'place-order/'.$order_id,$msg,'success');
		} else {
			$msg='Sorry, something went wrong';
			setRedirectWithMsg(SITE_URL.'revieworder',$msg,'error');
		}
		exit();
	} else {
		setRedirect(SITE_URL.'revieworder');
		exit();
	}
} elseif(isset($post['adr_change'])) {
	$upt_user_query = mysqli_query($db,"UPDATE `users` SET `address`='".real_escape_string($post['address'])."',`address2`='".real_escape_string($post['address2'])."',`city`='".real_escape_string($post['city'])."',`state`='".real_escape_string($post['state'])."',country='".real_escape_string($post['country'])."',`postcode`='".real_escape_string($post['postcode'])."' WHERE id='".$user_id."'");
	if($upt_user_query == '1') {
		$msg = "Shipping address has been successfully updated";
		setRedirectWithMsg(SITE_URL.'revieworder?action=confirm',$msg,'success');
		exit();
	}
} else {
	$msg='Direct access denied';
	setRedirectWithMsg(SITE_URL,$msg,'danger');
	exit();
} ?>