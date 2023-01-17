<?php
//Create slug for sef url
function createSlug($str)
{
    if($str !== mb_convert_encoding( mb_convert_encoding($str, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32') )
        $str = mb_convert_encoding($str, 'UTF-8', mb_detect_encoding($str));
    $str = htmlentities($str, ENT_NOQUOTES, 'UTF-8');
    $str = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\\1', $str);
    $str = html_entity_decode($str, ENT_NOQUOTES, 'UTF-8');
    $str = preg_replace(array('`[^a-z0-9]`i','`[-]+`'), '-', $str);
    $str = strtolower( trim($str, '-') );
    return $str;
}

//Parse sef url/path
function parse_path() {
  $path = array();
  if(isset($_SERVER['REQUEST_URI'])) {
    $request_path = explode('?', $_SERVER['REQUEST_URI']);

    $path['base'] = rtrim(dirname($_SERVER['SCRIPT_NAME']), '\/');
    $path['call_utf8'] = substr(urldecode($request_path[0]), strlen($path['base']) + 1);
    $path['call'] = utf8_decode($path['call_utf8']);
    if ($path['call'] == basename($_SERVER['PHP_SELF'])) {
      $path['call'] = '';
    }
    $path['call_parts'] = explode('/', $path['call']);

    $path['query_utf8'] = urldecode(@$request_path[1]);
    $path['query'] = utf8_decode(urldecode(@$request_path[1]));
    $vars = explode('&', $path['query']);
    foreach($vars as $var) {
      $t = explode('=', $var);
      $path['query_vars'][$t[0]] = @$t[1];
    }
  }
return $path;
}

function get_data_using_curl($url, $data = array()) {
	//  Initiate curl
	$ch = curl_init();
	// Will return the response, if false it print the response
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// Set the url
	curl_setopt($ch, CURLOPT_URL,$url);
	// Execute
	$result=curl_exec($ch);
	// Closing
	curl_close($ch);
	
	// Will dump a beauty json :3
	return json_decode($result, true);
}

//Get email template data based on template type
function get_template_data($template_type) {
	global $db;
	$query=mysqli_query($db,'SELECT * FROM mail_templates WHERE type="'.$template_type.'"');
	return mysqli_fetch_assoc($query);
}

function get_template_data_by_id($id) {
	global $db;
	$query=mysqli_query($db,"SELECT * FROM mail_templates WHERE id='".$id."'");
	return mysqli_fetch_assoc($query);
}

//Get general settings
function get_general_setting_data() {
	global $db;
	$gs_query=mysqli_query($db,'SELECT * FROM general_setting ORDER BY id DESC');
	return mysqli_fetch_assoc($gs_query);
}

//Get admin user data
function get_admin_user_data() {
	global $db;
	$query=mysqli_query($db,"SELECT * FROM admin WHERE type='super_admin' ORDER BY id DESC");
	return mysqli_fetch_assoc($query);
}

//Get user data based on userID
function get_user_data($user_id) {
	global $db;
	$u_query=mysqli_query($db,"SELECT u.* FROM users AS u WHERE u.id='".$user_id."'");
	return mysqli_fetch_assoc($u_query);
}

//Get order data based on orderID
function get_order_data($order_id, $email = "") {
	global $db;
	
	$mysql_q = "";
	if($email!="") {
		$mysql_q .= " OR u.email='".$email."'";
	}
	
	$u_query=mysqli_query($db,"SELECT u.*, o.*, o.date AS order_date, o.status AS order_status, sbl.name as cash_location_name FROM users AS u RIGHT JOIN orders AS o ON o.user_id=u.id LEFT JOIN starbuck_location AS sbl ON sbl.id=o.cash_location WHERE o.order_id='".$order_id."'".$mysql_q."");
	return mysqli_fetch_assoc($u_query);
}

//Get order price based on orderID
function get_order_price($order_id) {
	global $db;
	$query=mysqli_query($db,"SELECT SUM(price) AS sum_of_orders FROM order_items WHERE order_id='".$order_id."'");
	$data=mysqli_fetch_assoc($query);
	return $data['sum_of_orders'];
}

//Get order item list data based on orderID
function get_order_item_list($order_id) {
	global $db;
	$response_array = array();
	$query=mysqli_query($db,"SELECT oi.*, o.`payment_method`, o.`date`, o.`approved_date`, o.`expire_date`, o.`status`, o.`sales_pack`, o.`paypal_address`, o.`chk_name`, o.`chk_street_address`, o.`chk_street_address_2`, o.`chk_city`, o.`chk_state`, o.`chk_zip_code`, o.`act_name`, o.`act_number`, o.`act_short_code`, o.`note`, d.title AS device_title, m.title AS model_title, m.model_img, b.title AS brand_title, b.is_check_icloud, c.fields_type AS fields_cat_type FROM order_items AS oi LEFT JOIN orders AS o ON o.order_id=oi.order_id LEFT JOIN devices AS d ON d.id=oi.device_id LEFT JOIN mobile AS m ON m.id=oi.model_id LEFT JOIN brand AS b ON b.id=m.brand_id LEFT JOIN categories AS c ON c.id=m.cat_id WHERE oi.order_id='".$order_id."' ORDER BY oi.id DESC");
	/*AND o.status='partial'*/
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($order_item_data=mysqli_fetch_assoc($query)) {
			$response_array[] = $order_item_data;
		}
	}
	return $response_array;
}

//Get order item device type, condition based on item id
function get_order_item($item_id, $type) {
	global $db;
	$order_query=mysqli_query($db,"SELECT oi.*, o.`payment_method`, o.`date`, o.`approved_date`, o.`expire_date`, o.`status`, o.`sales_pack`, o.`paypal_address`, o.`chk_name`, o.`chk_street_address`, o.`chk_street_address_2`, o.`chk_city`, o.`chk_state`, o.`chk_zip_code`, o.`act_name`, o.`act_number`, o.`act_short_code`, o.`note`, d.title AS device_title, m.title AS model_title, b.title AS brand_title, c.fields_type AS fields_cat_type FROM order_items AS oi LEFT JOIN orders AS o ON o.order_id=oi.order_id LEFT JOIN devices AS d ON d.id=oi.device_id LEFT JOIN mobile AS m ON m.id=oi.model_id LEFT JOIN brand AS b ON b.id=m.brand_id LEFT JOIN categories AS c ON c.id=m.cat_id WHERE oi.id='".$item_id."'");
	$data = mysqli_fetch_assoc($order_query);

	$response_array = array();
	if($type == "general") {
		$response_array['device_type'] = $data['model_title'].($data['color']?' ('.$data['color'].','.$data['storage'].') ':' '.$data['storage']).' '.$data['network'].' ('.$data['condition'].')'.($data['accessories']?'<br><strong>Accessories:</strong> '.$data['accessories']:'').($data['miscellaneous']?'<br><strong>Miscellaneous:</strong> '.$data['miscellaneous']:'');
		$response_array['condition'] = ($data['condition']?'('.$data['condition'].')':'');
		
		$response_array['device_title'] = $data['device_title'].' - '.$data['model_title'];
		$response_array['device_info'] = '<small>'.($data['storage']?'<b> Storage:</b> '.$data['storage']:"").($data['condition']?'<b> Condition:</b> '.$data['condition']:"").($data['network']?'<b> Network:</b> '.$data['network']:"").($data['connectivity']?'<b> Connectivity:</b> '.$data['connectivity']:"").($data['watchtype']?'<b> Type:</b> '.$data['watchtype']:"").($data['case_material']?'<b> Case Material:</b> '.$data['case_material']:"").($data['case_size']?'<b> Case Size:</b> '.$data['case_size']:"").($data['color']?'<b> Color:</b> '.$data['color']:"").($data['accessories']?'<b> Accessories:</b> '.$data['accessories']:"").($data['screen_size']?'<b> Screen Size:</b> '.$data['screen_size']:"").($data['screen_resolution']?'<b> Screen Resolution:</b> '.$data['screen_resolution']:"").($data['lyear']?'<b> Year:</b> '.$data['lyear']:"").($data['processor']?'<b> Processor:</b> '.$data['processor']:"").($data['ram']?'<b> Ram (Memory):</b> '.$data['ram']:"").'</small>';
	} elseif($type == "list") {
		$response_array['device_type'] = $data['model_title'].($data['color']?' ('.$data['color'].','.$data['storage'].') ':' '.$data['storage']).($data['accessories']?'<br><strong>Accessories:</strong> '.$data['accessories']:'').($data['miscellaneous']?'<br><strong>Miscellaneous:</strong> '.$data['miscellaneous']:'');
		$response_array['condition'] = ($data['condition']?'('.$data['condition'].')':'');
		
		$response_array['device_title'] = $data['device_title'].' - '.$data['model_title'];
		$response_array['device_info'] = ($data['storage']?'<span> Storage:</span> '.$data['storage']:"").($data['condition']?'<span> Condition:</span> '.$data['condition']:"").($data['network']?'<span> Network:</span> '.$data['network']:"").($data['connectivity']?'<span> Connectivity:</span> '.$data['connectivity']:"").($data['watchtype']?'<span> Type:</span> '.$data['watchtype']:"").($data['case_material']?'<span> Case Material:</span> '.$data['case_material']:"").($data['case_size']?'<span> Case Size:</span> '.$data['case_size']:"").($data['color']?'<span> Color:</span> '.$data['color']:"").($data['accessories']?'<span> Accessories:</span> '.$data['accessories']:"").($data['screen_size']?'<span> Screen Size:</span> '.$data['screen_size']:"").($data['screen_resolution']?'<span> Screen Resolution:</span> '.$data['screen_resolution']:"").($data['lyear']?'<span> Year:</span> '.$data['lyear']:"").($data['processor']?'<span> Processor:</span> '.$data['processor']:"").($data['ram']?'<span> Ram (Memory):</span> '.$data['ram']:"");
	} elseif($type == "email") {
		$response_array['device_type'] = $data['model_title'].($data['color']?' ('.$data['color'].','.$data['storage'].') ':' '.$data['storage']).' '.$data['network'].' ('.$data['condition'].')'.($data['accessories']?'<br><strong>Accessories:</strong> '.$data['accessories']:'').($data['miscellaneous']?'<br><strong>Miscellaneous:</strong> '.$data['miscellaneous']:'');
		$response_array['condition'] = ($data['condition']?'('.$data['condition'].')':'');

		$response_array['device_title'] = $data['device_title'].' - '.$data['model_title'];
		$response_array['device_info'] = '<small>'.($data['storage']?'<b> Storage:</b> '.$data['storage']:"").($data['condition']?'<b> Condition:</b> '.$data['condition']:"").($data['network']?'<b> Network:</b> '.$data['network']:"").($data['connectivity']?'<b> Connectivity:</b> '.$data['connectivity']:"").($data['watchtype']?'<b> Type:</b> '.$data['watchtype']:"").($data['case_material']?'<b> Case Material:</b> '.$data['case_material']:"").($data['case_size']?'<b> Case Size:</b> '.$data['case_size']:"").($data['color']?'<b> Color:</b> '.$data['color']:"").($data['accessories']?'<b> Accessories:</b> '.$data['accessories']:"").($data['screen_size']?'<b> Screen Size:</b> '.$data['screen_size']:"").($data['screen_resolution']?'<b> Screen Resolution:</b> '.$data['screen_resolution']:"").($data['lyear']?'<b> Year:</b> '.$data['lyear']:"").($data['processor']?'<b> Processor:</b> '.$data['processor']:"").($data['ram']?'<b> Ram (Memory):</b> '.$data['ram']:"").'</small>';
		
	} elseif($type == "print") {
		$response_array['device_type'] = $data['model_title'].($data['color']?' ('.$data['color'].','.$data['storage'].') ':' '.$data['storage']).' '.$data['network'].' ('.$data['condition'].')'.($data['accessories']?'<br><strong>Accessories:</strong> '.$data['accessories']:'').($data['miscellaneous']?'<br><strong>Miscellaneous:</strong> '.$data['miscellaneous']:'');
		$response_array['condition'] = ($data['condition']?'('.$data['condition'].')':'');
		
		$response_array['device_title'] = $data['device_title'].' - '.$data['model_title'];
		$response_array['device_info'] = '<small>'.($data['storage']?'<b> Storage:</b> '.$data['storage']:"").($data['condition']?'<b> Condition:</b> '.$data['condition']:"").($data['network']?'<b> Network:</b> '.$data['network']:"").($data['connectivity']?'<b> Connectivity:</b> '.$data['connectivity']:"").($data['watchtype']?'<b> Type:</b> '.$data['watchtype']:"").($data['case_material']?'<b> Case Material:</b> '.$data['case_material']:"").($data['case_size']?'<b> Case Size:</b> '.$data['case_size']:"").($data['color']?'<b> Color:</b> '.$data['color']:"").($data['accessories']?'<b> Accessories:</b> '.$data['accessories']:"").($data['screen_size']?'<b> Screen Size:</b> '.$data['screen_size']:"").($data['screen_resolution']?'<b> Screen Resolution:</b> '.$data['screen_resolution']:"").($data['lyear']?'<b> Year:</b> '.$data['lyear']:"").($data['processor']?'<b> Processor:</b> '.$data['processor']:"").($data['ram']?'<b> Ram (Memory):</b> '.$data['ram']:"").'</small>';
	}
	$response_array['data'] = $data;
	return $response_array;
}

//Get order item device type, condition based on item id
function get_order_item_1($item_id, $type) {
	global $db;
	$order_query=mysqli_query($db,"SELECT oi.*, o.`payment_method`, o.`date`, o.`approved_date`, o.`expire_date`, o.`status`, o.`sales_pack`, o.`paypal_address`, o.`chk_name`, o.`chk_street_address`, o.`chk_street_address_2`, o.`chk_city`, o.`chk_state`, o.`chk_zip_code`, o.`act_name`, o.`act_number`, o.`act_short_code`, o.`note`, d.title AS device_title, m.title AS model_title, b.title AS brand_title, c.fields_type AS fields_cat_type FROM order_items AS oi LEFT JOIN orders AS o ON o.order_id=oi.order_id LEFT JOIN devices AS d ON d.id=oi.device_id LEFT JOIN mobile AS m ON m.id=oi.model_id LEFT JOIN brand AS b ON b.id=m.brand_id LEFT JOIN categories AS c ON c.id=m.cat_id WHERE oi.id='".$item_id."'");
	$data = mysqli_fetch_assoc($order_query);

	$response_array = array();
	if($type == "general") {
		$response_array['device_type'] = $data['model_title'].($data['color']?' ('.$data['color'].','.$data['storage'].') ':' '.$data['storage']).' '.$data['network'].' ('.$data['condition'].')'.($data['accessories']?'<br><strong>Accessories:</strong> '.$data['accessories']:'').($data['miscellaneous']?'<br><strong>Miscellaneous:</strong> '.$data['miscellaneous']:'');
		$response_array['condition'] = ($data['condition']?'('.$data['condition'].')':'');
		
		$response_array['device_title'] = $data['device_title'].' - '.$data['model_title'];
		$response_array['device_info'] = '<small>'.($data['storage']?'<b> Storage:</b> '.$data['storage']:"").($data['condition']?'<b> Condition:</b> '.$data['condition']:"").($data['network']?'<b> Network:</b> '.$data['network']:"").($data['connectivity']?'<b> Connectivity:</b> '.$data['connectivity']:"").($data['watchtype']?'<b> Type:</b> '.$data['watchtype']:"").($data['case_material']?'<b> Case Material:</b> '.$data['case_material']:"").($data['case_size']?'<b> Case Size:</b> '.$data['case_size']:"").($data['color']?'<b> Color:</b> '.$data['color']:"").($data['accessories']?'<b> Accessories:</b> '.$data['accessories']:"").($data['screen_size']?'<b> Screen Size:</b> '.$data['screen_size']:"").($data['screen_resolution']?'<b> Screen Resolution:</b> '.$data['screen_resolution']:"").($data['lyear']?'<b> Year:</b> '.$data['lyear']:"").($data['processor']?'<b> Processor:</b> '.$data['processor']:"").($data['ram']?'<b> Ram (Memory):</b> '.$data['ram']:"").'</small>';
	} elseif($type == "list") {
		$response_array['device_type'] = $data['model_title'].($data['color']?' ('.$data['color'].','.$data['storage'].') ':' '.$data['storage']).($data['accessories']?'<br><strong>Accessories:</strong> '.$data['accessories']:'').($data['miscellaneous']?'<br><strong>Miscellaneous:</strong> '.$data['miscellaneous']:'');
		$response_array['condition'] = ($data['condition']?'('.$data['condition'].')':'');
		
		$response_array['device_title'] = $data['device_title'].' - '.$data['model_title'];
		$response_array['device_info'] = ($data['storage']?'<span> Storage:</span> '.$data['storage']:"").($data['condition']?'<span> Condition:</span> '.$data['condition']:"").($data['network']?'<span> Network:</span> '.$data['network']:"").($data['connectivity']?'<span> Connectivity:</span> '.$data['connectivity']:"").($data['watchtype']?'<span> Type:</span> '.$data['watchtype']:"").($data['case_material']?'<span> Case Material:</span> '.$data['case_material']:"").($data['case_size']?'<span> Case Size:</span> '.$data['case_size']:"").($data['color']?'<span> Color:</span> '.$data['color']:"").($data['accessories']?'<span> Accessories:</span> '.$data['accessories']:"").($data['screen_size']?'<span> Screen Size:</span> '.$data['screen_size']:"").($data['screen_resolution']?'<span> Screen Resolution:</span> '.$data['screen_resolution']:"").($data['lyear']?'<span> Year:</span> '.$data['lyear']:"").($data['processor']?'<span> Processor:</span> '.$data['processor']:"").($data['ram']?'<span> Ram (Memory):</span> '.$data['ram']:"");
	} elseif($type == "email") {
		$response_array['device_type'] = $data['model_title'].($data['color']?' ('.$data['color'].','.$data['storage'].') ':' '.$data['storage']).' '.$data['network'].' ('.$data['condition'].')'.($data['accessories']?'<br><strong>Accessories:</strong> '.$data['accessories']:'').($data['miscellaneous']?'<br><strong>Miscellaneous:</strong> '.$data['miscellaneous']:'');
		$response_array['condition'] = ($data['condition']?'('.$data['condition'].')':'');

		$response_array['device_title'] = $data['device_title'].' - '.$data['model_title'];
		$temp_accessories = $data['accessories'].",;";
		$temp_accessories = str_replace(" Yes,", "", $temp_accessories);
		$temp_accessories = str_replace(":", ", ", $temp_accessories);
		$temp_accessories = strtoupper(str_replace(", ;", "", $temp_accessories));
		$response_array['device_info'] = '<span>'.($data['storage']?'<b> STORAGE:</b> '.strtoupper($data['storage']):"").($data['condition']?'<b> CONDITION:</b> '.strtoupper($data['condition']):"").($data['network']?'<b> NETWORK:</b> '.strtoupper($data['network']):"").($data['connectivity']?'<b> CONNECTIVITY:</b> '.strtoupper($data['connectivity']):"").($data['watchtype']?'<b> TYPE:</b> '.strtoupper($data['watchtype']):"").($data['case_material']?'<b> CASE MATERIAL:</b> '.strtoupper($data['case_material']):"").($data['case_size']?'<b> CASE SIZE:</b> '.strtoupper($data['case_size']):"").($data['color']?'<b> COLOR:</b> '.strtoupper($data['color']):"").($data['accessories']?'<b> ACCESSORIES:</b> '.$temp_accessories:"").($data['screen_size']?'<b> SCREEN SIZE:</b> '.strtoupper($data['screen_size']):"").($data['screen_resolution']?'<b> SCREEN RESOLUTION:</b> '.strtoupper($data['screen_resolution']):"").($data['lyear']?'<b> YEAR:</b> '.strtoupper($data['lyear']):"").($data['processor']?'<b> PROCESSOR:</b> '.strtoupper($data['processor']):"").($data['ram']?'<b> RAM (MEMORY):</b> '.strtoupper($data['ram']):"").'</span>';
		
	} elseif($type == "print") {
		$response_array['device_type'] = $data['model_title'].($data['color']?' ('.$data['color'].','.$data['storage'].') ':' '.$data['storage']).' '.$data['network'].' ('.$data['condition'].')'.($data['accessories']?'<br><strong>Accessories:</strong> '.$data['accessories']:'').($data['miscellaneous']?'<br><strong>Miscellaneous:</strong> '.$data['miscellaneous']:'');
		$response_array['condition'] = ($data['condition']?'('.$data['condition'].')':'');
		
		$response_array['device_title'] = $data['device_title'].' - '.$data['model_title'];
		$response_array['device_info'] = '<small>'.($data['storage']?'<b> Storage:</b> '.$data['storage']:"").($data['condition']?'<b> Condition:</b> '.$data['condition']:"").($data['network']?'<b> Network:</b> '.$data['network']:"").($data['connectivity']?'<b> Connectivity:</b> '.$data['connectivity']:"").($data['watchtype']?'<b> Type:</b> '.$data['watchtype']:"").($data['case_material']?'<b> Case Material:</b> '.$data['case_material']:"").($data['case_size']?'<b> Case Size:</b> '.$data['case_size']:"").($data['color']?'<b> Color:</b> '.$data['color']:"").($data['accessories']?'<b> Accessories:</b> '.$data['accessories']:"").($data['screen_size']?'<b> Screen Size:</b> '.$data['screen_size']:"").($data['screen_resolution']?'<b> Screen Resolution:</b> '.$data['screen_resolution']:"").($data['lyear']?'<b> Year:</b> '.$data['lyear']:"").($data['processor']?'<b> Processor:</b> '.$data['processor']:"").($data['ram']?'<b> Ram (Memory):</b> '.$data['ram']:"").'</small>';
	}
	$response_array['data'] = $data;
	return $response_array;
}

function save_inbox_mail_sms($data) {
	global $db;

	$template_id = $data['template_id'];
	$staff_id = $data['staff_id'];
	$user_id = $data['user_id'];
	$order_id = $data['order_id'];
	$from_email = $data['from_email'];
	$to_email = $data['to_email'];
	$subject = real_escape_string($data['subject']);
	$body = real_escape_string($data['body']);
	$sms_phone = $data['sms_phone'];
	$sms_content = $data['sms_content'];
	$date = $data['date'];
	$leadsource = $data['leadsource'];
	$form_type = $data['form_type'];

	if($body!="" && $from_email!="" && $to_email!="") {
		$query=mysqli_query($db,'INSERT INTO inbox_mail_sms(template_id, staff_id, user_id, order_id, from_email, to_email, subject, body, sms_phone, sms_content, date, visitor_ip, leadsource, form_type) values("'.$template_id.'","'.$staff_id.'","'.$user_id.'","'.$order_id.'","'.$from_email.'","'.$to_email.'","'.$subject.'","'.$body.'","'.$sms_phone.'","'.$sms_content.'","'.$date.'","'.USER_IP.'","'.$leadsource.'","'.$form_type.'")');
		$saved_storage_ids = mysqli_insert_id($db);
		return $saved_storage_ids;
	} else {
		return '';
	}
}
function send_email($to,$subject,$message,$from_name,$from_email, $attachment_data = array()) {
        $from = new SendGrid\Email($from_name, $from_email);
		$subject = $subject;
		$to = new SendGrid\Email($subject, $to);
		
		//Send message as text
		//$content = new SendGrid\Content("text/plain", "and easy to do anywhere, even with PHP");

		//Send message as html
		$content = new SendGrid\Content("text/html", $message);
		
		$mail = new SendGrid\Mail($from, $subject, $to, $content);
		
		$apiKey = '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';
		$sg = new \SendGrid($apiKey);

		$response = $sg->client->mail()->send()->post($mail);
	
		return '1';
//         $smtp_username = 'hola@tasaciones-labrujita.online';
//         $smtp_password = 'bt$jpNnI&=B';
// 		$mail = new PHPMailer();

// 		$mail->Timeout = 30;
// 		$mail->Host = 'smtp.tasaciones-labrujita.online';
// 		$mail->Port = 25;
// 		if($smtp_username && $smtp_password) {
// // 			$mail->IsSMTP(); 
//             $mail->Mailer = "mail";
// 			//$mail->SMTPDebug  = 2;
// 			$mail->SMTPAuth = true;
// 			$mail->Username = $smtp_username;
// 			$mail->Password = $smtp_password;
// // 			if($smtp_security=="ssl") {
// 				$mail->SMTPSecure = 'tls';
// // 			}
// 			//$mail->From = $smtp_username;
// 		}

// 		$mail->From = $from_email;
// 		$mail->FromName = $from_name;
// 		$mail->AddAddress($to);
// 		$mail->AddReplyTo($from_email, $from_name);
// 		//$mail->WordWrap = 50;
		
// 		if(!empty($attachment_data['basename'])) {
// 			foreach($attachment_data['basename'] as $f_key=>$basename) {
// 				$mail->AddAttachment(CP_ROOT_PATH.'/'.$attachment_data['folder'][$f_key].'/'.$basename, $basename);
// 			}
// 		}
		
// 		$mail->IsHTML(true);
// 		$mail->Subject = $subject;
// 		$mail->Body    = $message;
		
// 		if(!$mail->Send()) {
// 			error_log("SMTP Mailer Error:".$mail->ErrorInfo);
// 			return '0';
// 		} else {
// 			return '1';
// 		}
    
}

//Send email as SMTP or PHP mail based on admin email settings
// function send_email($to,$subject,$message,$from_name,$from_email, $attachment_data = array()) {
// 	global $db;
// 	$get_gsdata=mysqli_query($db,'SELECT * FROM general_setting ORDER BY id DESC');
// 	$general_setting_detail=mysqli_fetch_assoc($get_gsdata);
// 	$mailer_type = $general_setting_detail['mailer_type'];
// 	$smtp_host = $general_setting_detail['smtp_host'];
// 	$smtp_port = $general_setting_detail['smtp_port'];
// 	$smtp_security = $general_setting_detail['smtp_security'];
// 	$smtp_auth = $general_setting_detail['smtp_auth'];
// 	$smtp_username = $general_setting_detail['smtp_username'];
// 	$smtp_password = $general_setting_detail['smtp_password'];
// 	$email_api_key = $general_setting_detail['email_api_key'];
// 	//$email_api_username = $general_setting_detail['email_api_username'];
// 	//$email_api_password = $general_setting_detail['email_api_password'];
	
// 	if($mailer_type == "sendgrid" && $email_api_key) {
// 		$from = new SendGrid\Email($from_name, $from_email);
// 		$subject = $subject;
// 		$to = new SendGrid\Email($subject, $to);
		
// 		//Send message as text
// 		//$content = new SendGrid\Content("text/plain", "and easy to do anywhere, even with PHP");

// 		//Send message as html
// 		$content = new SendGrid\Content("text/html", $message);
		
// 		$mail = new SendGrid\Mail($from, $subject, $to, $content);
		
// 		$apiKey = $email_api_key;
// 		$sg = new \SendGrid($apiKey);

// 		$response = $sg->client->mail()->send()->post($mail);
	
// 		return '1';
// 	} elseif($mailer_type == "smtp" && $smtp_host && $smtp_port) {
// 		$mail = new PHPMailer();

// 		$mail->Timeout = 30;
// 		$mail->Host = $smtp_host;
// 		$mail->Port = ($smtp_port==""?"25":$smtp_port);
// 		if($smtp_username && $smtp_password) {
// 			$mail->IsSMTP(); 
// 			//$mail->SMTPDebug  = 2;
// 			$mail->SMTPAuth = true;
// 			$mail->Username = $smtp_username;
// 			$mail->Password = $smtp_password;
// 			if($smtp_security=="ssl") {
// 				$mail->SMTPSecure = 'tls';
// 			}
// 			//$mail->From = $smtp_username;
// 		}

// 		$mail->From = $from_email;
// 		$mail->FromName = $from_name;
// 		$mail->AddAddress($to);
// 		$mail->AddReplyTo($from_email, $from_name);
// 		//$mail->WordWrap = 50;
		
// 		if(!empty($attachment_data['basename'])) {
// 			foreach($attachment_data['basename'] as $f_key=>$basename) {
// 				$mail->AddAttachment(CP_ROOT_PATH.'/'.$attachment_data['folder'][$f_key].'/'.$basename, $basename);
// 			}
// 		}
		
// 		$mail->IsHTML(true);
// 		$mail->Subject = $subject;
// 		$mail->Body    = $message;
		
// 		if(!$mail->Send()) {
// 			error_log("SMTP Mailer Error:".$mail->ErrorInfo);
// 			return '0';
// 		} else {
// 			return '1';
// 		}
// 	} else {
// 		$mail = new PHPMailer();

// 		$mail->Timeout = 30;
// 		$mail->From = $from_email;
// 		$mail->FromName = $from_name;
// 		$mail->AddAddress($to);
// 		$mail->AddReplyTo($from_email, $from_name);
// 		//$mail->WordWrap = 50;

// 		if(!empty($attachment_data['basename'])) {
// 			foreach($attachment_data['basename'] as $f_key=>$basename) {
// 				$mail->AddAttachment(CP_ROOT_PATH.'/'.$attachment_data['folder'][$f_key].'/'.$basename, $basename);
// 			}
// 		}

// 		$mail->IsHTML(true);
// 		$mail->Subject = $subject;
// 		$mail->Body    = $message;

// 		if(!$mail->Send()) {
// 			error_log("SMTP Mailer Error:".$mail->ErrorInfo);
// 			return '0';
// 		} else {
// 			return '1';
// 		}

// 		/*if($attachment_data['basename']!="" && $attachment_data['folder']!="") {
// 			$filename = $attachment_data['basename'];
// 			$path = CP_ROOT_PATH.'/'.$attachment_data['folder'].'/';

// 			// array with filenames to be sent as attachment
// 			$file_path = $path.$filename;

// 			$headers = "From: $from_email";

// 			// boundary 
// 			$semi_rand = md5(time()); 
// 			$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 
			
// 			// headers for attachment
// 			$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";
			
// 			// multipart boundary 
// 			$message = "This is a multi-part message in MIME format.\n\n" . "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"iso-8859-1\"\n" . "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n"; 
// 			$message .= "--{$mime_boundary}\n";

// 			// Preparing attachement
// 			$file = fopen($file_path,"rb");
// 			$data = fread($file,filesize($file_path));
// 			fclose($file);
// 			$data = chunk_split(base64_encode($data));
// 			$message .= "Content-Type: {\"application/octet-stream\"};\n" . " name=\"$filename\"\n" . 
// 			"Content-Disposition: attachment;\n" . " filename=\"$filename\"\n" . 
// 			"Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
// 			$message .= "--{$mime_boundary}\n";
// 		} else {
// 			$headers  = 'MIME-Version: 1.0'."\r\n";
// 			$headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
// 			$headers .= "From:".$from_name." <".$from_email.">\r\n";
// 		}
		
// 		if(mail($to,$subject,$message,$headers)) {
// 			return '1';
// 		} else {
// 			return '0';
// 		}*/
// 	}
// }

//Get amount format, its prefix of amount or postfix of amount
function amount_fomat($amount) {
	global $db;
	$gs_query=mysqli_query($db,'SELECT * FROM general_setting ORDER BY id DESC');
	$general_setting_data=mysqli_fetch_assoc($gs_query);

	$currency = @explode(",",$general_setting_data['currency']);
	$is_space_between_currency_symbol = $general_setting_data['is_space_between_currency_symbol'];
	$thousand_separator = $general_setting_data['thousand_separator'];
	$decimal_separator = $general_setting_data['decimal_separator'];
	$decimal_number = $general_setting_data['decimal_number'];

	$symbol_space = "";
	if($is_space_between_currency_symbol == '1') {
		$symbol_space = " ";
	} else {
		$symbol_space = "";
	}

	if($general_setting_data['disp_currency']=="prefix") {
		//return $currency[1].number_format($amount, 2, '.', '');
		return $currency[1].$symbol_space.number_format($amount, $decimal_number, $decimal_separator, $thousand_separator);
	} elseif($general_setting_data['disp_currency']=="postfix") {
		//return number_format($amount, 2, '.', '').$currency[1];
		return number_format($amount, $decimal_number, $decimal_separator, $thousand_separator).$symbol_space.$currency[1];
	}
}

function amount_format_without_syml($amount) {
	global $db;
	$gs_query=mysqli_query($db,'SELECT thousand_separator, decimal_separator, decimal_number FROM general_setting ORDER BY id DESC');
	$general_setting_data=mysqli_fetch_assoc($gs_query);

	$thousand_separator = $general_setting_data['thousand_separator'];
	$decimal_separator = $general_setting_data['decimal_separator'];
	$decimal_number = $general_setting_data['decimal_number'];

	return number_format($amount, $decimal_number, $decimal_separator, $thousand_separator);
}

//Escape string of mysql query
function real_escape_string($data) {
	global $db;
	return mysqli_real_escape_string($db,trim($data));
}

//Set redirect without message
function setRedirect($url) {
	header("HTTP/1.1 301 Moved Permanently");
	header('Location:'.$url);
	return true;
}

//Set redirect with message, show message based on type (success, info, warning, danger)
function setRedirectWithMsg($url,$msg,$type) {
	header("HTTP/1.1 301 Moved Permanently");
	$_SESSION['msg'] = array('msg'=>$msg,'type'=>$type);
	header('Location:'.$url);
	return true;
}

//For show confirmations message
function getConfirmMessage() {
	//success, info, warning, danger
	$msg = @$_SESSION['msg'];
	$resp = array();
	if($msg['type']) {
		$resp_msg = '<div id="system-message" class="system-message text-center">';
			// $resp_msg .= '<div class="container-fluid text-center">';
				// $resp_msg .= '<div class="row">';
				$resp_msg .= '<div class="alert alert-'.$msg['type'].' alert-dismissable">';
					$resp_msg .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
					$resp_msg .= $msg['msg'];
				$resp_msg .= '</div>';
				// $resp_msg .= '</div>';
			// $resp_msg .= '</div>';
		$resp_msg .= '</div>';
	}
	$resp['msg'] = @$resp_msg;
	unset($_SESSION['msg']);
	return $resp;
}

//For get page list based on menu position type
function get_page_list($type) {
	global $db;
	$page_data_array = array();
	if(trim($type)) {
		$query=mysqli_query($db,"SELECT * FROM pages WHERE published='1' ORDER BY ordering ASC");
		while($page_data=mysqli_fetch_assoc($query)) {
			$exp_position=(array)json_decode($page_data['position']);
			if($type==$exp_position[$type]) {
				$page_data_array[] = $page_data;
			}
		}
	}
	return $page_data_array;
}

//For get menu list based on menu position
function get_menu_list($position) {
	global $db;
	$menu_data_array = array();

	$sql_params = "";
	if(trim($position)) {
		$sql_params .= "AND m.position='".$position."'";	
	}

	$query = mysqli_query($db,"SELECT m.*, p.title AS p_title, p.url AS p_url, p.is_custom_url AS p_is_custom_url FROM menus AS m LEFT JOIN pages AS p ON p.id=m.page_id WHERE m.status='1' AND parent='0' ".$sql_params." ORDER BY m.ordering ASC");
	while($page_data = mysqli_fetch_assoc($query)) {
		//START for submenu
		$page_data['submenu'] = array();
		$s_query = mysqli_query($db,"SELECT m.*, p.title AS p_title, p.url AS p_url, p.is_custom_url AS p_is_custom_url FROM menus AS m LEFT JOIN pages AS p ON p.id=m.page_id WHERE m.status='1' AND parent='".$page_data['id']."' ".$sql_params." ORDER BY m.ordering ASC");
		while($s_page_data = mysqli_fetch_assoc($s_query)) {
			//START for submenu of submenu
			$ss_page_data_array = array();
			$ss_query = mysqli_query($db,"SELECT m.*, p.title AS p_title, p.url AS p_url, p.is_custom_url AS p_is_custom_url FROM menus AS m LEFT JOIN pages AS p ON p.id=m.page_id WHERE m.status='1' AND parent='".$s_page_data['id']."' ".$sql_params." ORDER BY m.ordering ASC");
			$ss_page_num_rows = mysqli_num_rows($ss_query);
			if($ss_page_num_rows>0) {
				while($ss_page_data = mysqli_fetch_assoc($ss_query)) {
					$ss_page_data_array[] = $ss_page_data;
				}
			}
			$s_page_data['submenu'] = $ss_page_data_array;
			//END for submenu of submenu

			$page_data['submenu'][] = $s_page_data;
		} //END for submenu
		
		$menu_data_array[] = $page_data;
	}
	return $menu_data_array;
}

//For get inbuild page url
function get_inbuild_page_url($slug) {
	global $db;
	if(trim($slug)) {
		$query=mysqli_query($db,"SELECT * FROM pages WHERE slug='".trim($slug)."'");
		$page_data=mysqli_fetch_assoc($query);
		return $page_data['url'];
	}
}

function get_inbuild_page_data($slug) {
	global $db;
	if(trim($slug)) {
		$query=mysqli_query($db,"SELECT * FROM pages WHERE slug='".trim($slug)."'");
		return mysqli_fetch_assoc($query);
	}
}

//For get small content based on words limit of string
function limit_words($string, $word_limit) {
    $words = explode(" ",$string);
    return implode(" ",array_splice($words,0,$word_limit));
}

//Get basket item count & sum of order
function get_basket_item_count_sum($order_id) {
	global $db;
	$response = array();
	$order_basket_count = 0;
	$order_basket_query=mysqli_query($db,"SELECT SUM(quantity) as total_qty, SUM(price) AS sum_of_orders FROM order_items WHERE order_id='".$order_id."'");
	$order_basket_data = mysqli_fetch_assoc($order_basket_query);
	$order_basket_count = intval($order_basket_data['total_qty']);
	$sum_of_orders = $order_basket_data['sum_of_orders'];
	
	$order_item_q=mysqli_query($db,"SELECT oi.*, o.status, d.title AS device_title, d.sef_url, m.title AS model_title FROM order_items AS oi LEFT JOIN orders AS o ON o.order_id=oi.order_id LEFT JOIN devices AS d ON d.id=oi.device_id LEFT JOIN mobile AS m ON m.id=oi.model_id WHERE o.order_id='".$order_id."' AND o.status='partial' ORDER BY oi.id DESC");
	$order_num_of_rows = mysqli_num_rows($order_item_q);
	if($order_num_of_rows>0) {
		while($order_item_data=mysqli_fetch_assoc($order_item_q)) {
			$basket_item_data[] = $order_item_data;
		}
	}
	
	$u_query=mysqli_query($db,"SELECT u.*, o.*, o.date AS order_date, o.status AS order_status FROM users AS u RIGHT JOIN orders AS o ON o.user_id=u.id WHERE o.order_id='".$order_id."'");
	$partial_order_data = mysqli_fetch_assoc($u_query);
	
	$response['basket_item_count'] = $order_basket_count;
	$response['basket_item_sum'] = $sum_of_orders;
	$response['basket_item_data'] = $basket_item_data;
	$response['partial_order_data'] = $partial_order_data;
	return $response;
}

//Get popular device data, it will show only 3 popular device
function get_popular_device_data() {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM devices WHERE published=1 AND popular_device=1 ORDER BY ordering ASC LIMIT 12");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($device_data=mysqli_fetch_assoc($query)) {
			$response[] = $device_data;
		}
	}
	return $response;
}

//Get device data list
function get_device_data_list() {
	global $db;
	$response = array();
	//$query=mysqli_query($db,"SELECT d.*, b.title AS brand_title FROM devices AS d LEFT JOIN brand AS b ON b.id=d.brand_id WHERE d.published=1 ORDER BY d.ordering ASC");
	$query=mysqli_query($db,"SELECT d.* FROM devices AS d WHERE d.published=1 ORDER BY d.ordering ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($device_data=mysqli_fetch_assoc($query)) {
			$response[] = $device_data;
		}
	}
	return $response;
}

//Get top seller data list
function get_top_seller_data_list($top_seller_limit,$mode = "model_specific") {
	global $db;
	$response = array();
	if($mode == "model_specific") {
		$query=mysqli_query($db,"SELECT m.*, m.title AS model_title, d.title AS device_title, d.sef_url, d.device_img, b.title AS brand_title FROM mobile AS m LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE m.published=1 AND m.top_seller='1' ORDER BY m.ordering ASC LIMIT ".$top_seller_limit."");
	} else {
		$query=mysqli_query($db,"SELECT ms.storage_size, ms.storage_size_postfix, ms.plus_minus AS storage_plus_minus, ms.fixed_percentage AS storage_fixed_percentage, ms.storage_price, m.*, m.title AS model_title, d.title AS device_title, d.sef_url, d.device_img, b.title AS brand_title FROM models_storage AS ms LEFT JOIN mobile AS m ON m.id=ms.model_id LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE m.published=1 AND ms.top_seller='1' ORDER BY m.ordering ASC LIMIT ".$top_seller_limit."");
	}
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($device_data=mysqli_fetch_assoc($query)) {
			$response[] = $device_data;
		}
	}
	return $response;
}

//Get popular device data, it will show only 3 popular device
function get_brand_data() {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM brand WHERE published=1 ORDER BY ordering ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($brand_data=mysqli_fetch_assoc($query)) {
			//$m_query = mysqli_query($db,"SELECT * FROM mobile WHERE published=1 AND brand_id='".$brand_data['id']."'");
			//$num_of_m_rows = mysqli_num_rows($m_query);
			//if($num_of_m_rows>0) {
				$response[] = $brand_data;
			//}
		}
	}
	return $response;
}

function get_single_brand_data($id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM brand WHERE published=1 AND id='".$id."'");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		$device_data=mysqli_fetch_assoc($query);
		$response = $device_data;
	}
	return $response;
}

//For all searchbox related autocomplete data
function autocomplete_data_search() {
	global $db;
	$response = array();
	$list_of_model = '';
	$top_search_query=mysqli_query($db,"SELECT m.*, d.title AS device_title, d.device_img, d.sef_url, b.title AS brand_title, b.ordering AS brand_ordering, b.id AS brand_id FROM mobile AS m LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE m.published=1 ORDER BY m.ordering ASC");
	while($top_search_data=mysqli_fetch_assoc($top_search_query)) {
	  //$ts_storage_list = json_decode($top_search_data['storage']);
	  //if(!empty($ts_storage_list)) {
		  //foreach($ts_storage_list as $ts_storage) {
			 $quote_mk_list[$top_search_data['brand_id']] = $top_search_data['brand_title'];
			 $quote_mk_list_with_srt[$top_search_data['brand_id']] = array('brand_title'=>$top_search_data['brand_title'],'brand_ordering'=>$top_search_data['brand_ordering'],'brand_id'=>$top_search_data['brand_id']);

			 /*$name = $top_search_data['brand_title'].' '.$top_search_data['title'].' '.$ts_storage->storage_size;
			 $url = SITE_URL.$top_search_data['sef_url'].'/'.createSlug($top_search_data['title']).'/'.$top_search_data['id'].'/'.$ts_storage->storage_size;
			 $list_of_model .= "{value:'".$name."', url:'".$url."'},";
			 
			 if(trim($top_search_data['searchable_words'])!="") {
				 foreach(explode(",",$top_search_data['searchable_words']) as $searchable_words) {
				 	$name1 = $top_search_data['brand_title'].' '.$top_search_data['title'].' '.$ts_storage->storage_size.' ('.$searchable_words.')';
					$list_of_model .= "{value:'".$name1."', url:'".$url."'},";
				 }
			 }*/
			 
		  //}
	  //}
	}
	$response['list_of_model'] = $list_of_model;
	$response['quote_mk_list'] = $quote_mk_list;
	$response['quote_mk_list_with_srt'] = $quote_mk_list_with_srt;
	return $response;
}

function get_brand_single_data_by_sef_url($sef_url) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT b.* FROM brand AS b WHERE b.sef_url='".$sef_url."' AND b.published=1");
	$num_of_brand = mysqli_num_rows($query);
	$brand_single_data=mysqli_fetch_assoc($query);
	$response['num_of_brand'] = $num_of_brand;
	$response['brand_single_data'] = $brand_single_data;
	return $response;
}

//Check if mobile menu & get data of single device based on url
function get_device_single_data($sef_url) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT d.id AS device_id, d.meta_title AS d_meta_title, d.meta_desc AS d_meta_desc, d.meta_keywords AS d_meta_keywords, d.sef_url, d.title AS device_title, d.description, d.device_img, d.sub_title as device_sub_title FROM devices AS d WHERE d.sef_url='".$sef_url."' AND d.published=1");
	$num_of_device = mysqli_num_rows($query);
	$device_single_data=mysqli_fetch_assoc($query);
	$response['num_of_device'] = $num_of_device;
	$response['is_mobile_menu'] = $num_of_device;
	$response['device_single_data'] = $device_single_data;
	return $response;
}

//save default status of order when we place order with choose option (print, free)
function save_default_status_when_place_order($args) {
	global $db;
	
	$q_params_for_prnt_order = "";
	
	if($args['sales_pack']=="print") {
		$q_params_for_prnt_order .= ", approved_date='".$args['approved_date']."', expire_date='".$args['expire_date']."'";
	}
	
	if($args['shipping_api']!="" && $args['shipment_id']!="") {
		$q_params_for_prnt_order .= ", shipping_api='".$args['shipping_api']."', shipment_id='".$args['shipment_id']."', shipment_tracking_code='".$args['shipment_tracking_code']."', shipment_label_url='".$args['shipment_label_url']."'";
	}

	if($args['order_id'] && $args['status']) {
		$query = mysqli_query($db,"UPDATE `orders` SET `status`='".$args['status']."', `sales_pack`='".$args['sales_pack']."'".$q_params_for_prnt_order." WHERE order_id='".$args['order_id']."'");
	}
	return $query;
}

function save_shipment_response_data($args) {
	global $db;
	if($args['order_id']) {
		$query = mysqli_query($db,"UPDATE `orders` SET shipping_api='".$args['shipping_api']."', shipment_id='".$args['shipment_id']."', shipment_tracking_code='".$args['shipment_tracking_code']."', shipment_label_url='".$args['shipment_label_url']."' WHERE order_id='".$args['order_id']."'");
	}
	return $query;
}

//Get order messaging data list based on orderID
function get_order_messaging_data_list($order_id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM order_messaging WHERE order_id='".$order_id."' ORDER BY id DESC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($order_messaging_dt=mysqli_fetch_assoc($query)) {
			$response[] = $order_messaging_dt;
		}
	}
	return $response;
}

//Get active review list
function get_review_list_data($status = 1, $limit = 0, $page_list_limit = 0) {
	global $db;
	
	if($page_list_limit>0) {
		global $pagination;
		
		$review_query = mysqli_query($db,"SELECT COUNT(*) AS num_of_reviews FROM reviews WHERE status='".$status."'");
		$review_data = mysqli_fetch_assoc($review_query);
		$pagination->set_total($review_data['num_of_reviews']);

		$response = array();
		$query=mysqli_query($db,"SELECT * FROM reviews WHERE status='".$status."' ORDER BY id DESC ".$pagination->get_limit()."");
		$num_of_rows = mysqli_num_rows($query);
		if($num_of_rows>0) {
			while($review_data=mysqli_fetch_assoc($query)) {
				$response[] = $review_data;
			}
		}
	} else {
		$sql_limit = "";
		if($limit>0) {
			$sql_limit = "LIMIT ".$limit;
		}
	
		$response = array();
		$query=mysqli_query($db,"SELECT * FROM reviews WHERE status='".$status."' ORDER BY id DESC ".$sql_limit."");
		$num_of_rows = mysqli_num_rows($query);
		if($num_of_rows>0) {
			while($review_data=mysqli_fetch_assoc($query)) {
				$response[] = $review_data;
			}
		}
	}
	return $response;
}

function get_avg_reviews()
{
	global $db;
	$query=mysqli_query($db,"SELECT ROUND(AVG(stars),2) as avg_rating_point,COUNT(stars) AS total_reviews FROM reviews WHERE status = '1'");
	return mysqli_fetch_assoc($query);
}

function get_review_stars() {
	global $db;
	
	$query=mysqli_query($db,"SELECT ROUND(AVG(stars),2) as avg_rating_point,COUNT(stars) AS total_reviews FROM reviews WHERE status = '1'");
	$avg_reviews = mysqli_fetch_assoc($query);
	
	$review_stars = '';
	if($avg_reviews['avg_rating_point'] > 0) {
		$display_agg_stars = '';
		$agg_full_star = explode(".",$avg_reviews['avg_rating_point']);
		for($agg_img = 0; $agg_img < $agg_full_star['0']; $agg_img++) {
			$display_agg_stars .= '<i class="fas fa-star"></i>';
		}
		
		$black_star_count = explode(".",5-$agg_full_star['0']);
		$total_black_star_count = $black_star_count[0];
		
		$agg_half_star_val = $agg_full_star['1'];
		if($agg_half_star_val >= '25' && $agg_half_star_val <= '74') {
			$total_black_star_count = $total_black_star_count - 1;
			$display_agg_stars .= '<i class="fas fa-star-half-alt"></i>';
		} elseif($agg_half_star_val >= '75') {
			$total_black_star_count = $total_black_star_count - 1;
			$display_agg_stars .= '<i class="fas fa-star"></i>';
		}
		
		for($img = 0; $img < $total_black_star_count; $img++) {
			$display_agg_stars .= '<i class="far fa-star"></i>';
		}
		
		return $display_agg_stars;
	}
}

//Get active review list
function get_review_list_data_random($status = 1) {
	global $db;

	$review_id_array = array();
	$query1=mysqli_query($db,"SELECT * FROM reviews WHERE status='".$status."'");
	$num_of_rows1 = mysqli_num_rows($query1);
	if($num_of_rows1>0) {
		while($review_data1=mysqli_fetch_assoc($query1)) {
			$review_id_array[] = $review_data1['id'];
		}
	}
	
	$review_data=array();
	if(!empty($review_id_array)) {
		$rrk = array_rand($review_id_array);
		$random_review_id = $review_id_array[$rrk];
	
		$query=mysqli_query($db,"SELECT * FROM reviews WHERE id='".$random_review_id."'");
		$num_of_rows = mysqli_num_rows($query);
		$review_data=mysqli_fetch_assoc($query);
	}
	return $review_data;
}

//Get active category list
function get_category_data_list($status = 1) {
	global $db;

	$response = array();
	$query=mysqli_query($db,"SELECT * FROM categories WHERE published='".$status."' ORDER BY ordering ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($review_data=mysqli_fetch_assoc($query)) {
			$response[] = $review_data;
		}
	}
	return $response;
}

//Get active category data
function get_category_data($id) {
	global $db;

	$query=mysqli_query($db,"SELECT * FROM categories WHERE published='1' AND id='".$id."'");
	return mysqli_fetch_assoc($query);
}

function first_word_strong_or_span($str, $type='strong') {
	if($type=='strong') {
		return preg_replace("@^(.*?)([^ ]+)\W?$@","<strong>$1</strong>$2",$str);
	} else {
		return preg_replace("@^([^ ]+)(.*?)\W?$@","<span>$1</span>$2",$str);
	}
}

function timeZoneConvert($fromTime, $fromTimezone, $toTimezone, $format = 'Y-m-d H:i:s') {
	// create timeZone object , with fromtimeZone
	$from = new DateTimeZone($fromTimezone);
	// create timeZone object , with totimeZone
	$to = new DateTimeZone($toTimezone);
	// read give time into ,fromtimeZone
	$orgTime = new DateTime($fromTime, $from);
	// fromte input date to ISO 8601 date (added in PHP 5). the create new date time object
	$toTime = new DateTime($orgTime->format("c"));
	// set target time zone to $toTme ojbect.
	$toTime->setTimezone($to);
	// return reuslt.
	return $toTime->format($format);
}

function format_date($date) {
	$data=get_general_setting_data();
	$date_format=$data['date_format'];
	$date=timeZoneConvert($date, 'UTC', TIMEZONE,'Y-m-d H:i:s');
	return date($date_format,strtotime($date));
}

function format_time($date){
	$data=get_general_setting_data();
	$time_format=$data['time_format'];
	$_format="H:i";
	if($time_format=="12_hour"){
		$_format="g:i a";
	}
	$date=timeZoneConvert($date, 'UTC', TIMEZONE,'Y-m-d H:i:s');
	return date($_format,strtotime($date));
}

function get_customer_timezone() {
	$date_time_zone = new DateTimeZone(TIMEZONE);
	$date_time = new DateTime('now', $date_time_zone);
	$hours = floor($date_time_zone->getOffset($date_time) / 3600);
	$mins = floor(($date_time_zone->getOffset($date_time) - ($hours*3600)) / 60);
	$hours = 'GMT' . ($hours < 0 ? $hours : '+'.$hours);
	$mins = ($mins > 0 ? $mins : '0'.$mins);

	$dateTime = new DateTime(); 
	$dateTime->setTimeZone(new DateTimeZone(TIMEZONE)); 
	$short_timezone = $dateTime->format('T'); 

	$array = array();
	$array['timezone'] = '('.$hours.':'.$mins.')';
	$array['short_timezone'] = $short_timezone;
	return $array;
}
		
function get_unique_id_on_load() {
	return md5(uniqid());
}

function time_zonelist(){
    $return = array();
    $timezone_identifiers_list = timezone_identifiers_list();
    foreach($timezone_identifiers_list as $timezone_identifier){
        $date_time_zone = new DateTimeZone($timezone_identifier);
        $date_time = new DateTime('now', $date_time_zone);
        $hours = floor($date_time_zone->getOffset($date_time) / 3600);
        $mins = floor(($date_time_zone->getOffset($date_time) - ($hours*3600)) / 60);
        $hours = 'GMT' . ($hours < 0 ? $hours : '+'.$hours);
        $mins = ($mins > 0 ? $mins : '0'.$mins);
        $text = str_replace("_"," ",$timezone_identifier);
		
		//$dateTime = new DateTime(); 
		//$dateTime->setTimeZone(new DateTimeZone($timezone_identifier)); 
		//$short_timezone = $dateTime->format('T'); 

		$array=array();
		$array['display']=$text.' ('.$hours.':'.$mins.')';
		$array['value']=$timezone_identifier;
		//$array['short_timezone']=$short_timezone;
        $return[] =$array; 
    }
    return $return;
}

function get_date_format_list(){
    $return = array();

	$return[] = array('display'=>'m/d/Y ex. '.date('m/d/Y'),'value'=>'m/d/Y');
	$return[] = array('display'=>'d-m-Y ex. '.date('d-m-Y'),'value'=>'d-m-Y');
	$return[] = array('display'=>'M/d/Y ex. '.date('M/d/Y'),'value'=>'M/d/Y');
	$return[] = array('display'=>'d-M-Y ex. '.date('d-M-Y'),'value'=>'d-M-Y');

	$return[] = array('display'=>'m/d/y ex. '.date('m/d/y'),'value'=>'m/d/y');
	$return[] = array('display'=>'d-m-y ex. '.date('d-m-y'),'value'=>'d-m-y');
	$return[] = array('display'=>'M/d/y ex. '.date('M/d/y'),'value'=>'M/d/y');
	$return[] = array('display'=>'d-M-y ex. '.date('d-M-y'),'value'=>'d-M-y');

    return $return;
}

function html_entities($str) {
	return htmlentities($str);
}

function addslashes_to_html($str) {
	return addslashes($str);
}

function get_models_storage_data($model_id, $ids = array()) {
	global $db;
	$response = array();
	
	$mysql_q_params = "";
	if(count($ids)>0) {
		$mysql_q_params = " AND id IN('".implode("','",$ids)."')";
	}
	
	$query=mysqli_query($db,"SELECT * FROM models_storage WHERE model_id='".$model_id."'".$mysql_q_params." ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {

			$color_ids = array();
			$c_query = mysqli_query($db,"SELECT * FROM models_color WHERE model_id='".$model_id."' AND FIND_IN_SET('".$data['id']."',storage_ids) AND storage_ids!='' ORDER BY id ASC");
			$c_num_of_rows = mysqli_num_rows($c_query);
			if($c_num_of_rows>0) {
				while($c_data = mysqli_fetch_assoc($c_query)) {
					$color_ids[] = $c_data['id'];
				}
				$data['color_ids'] = implode(",",$color_ids);
			} else {
				$data['color_ids'] = "";
			}
			
			$response[] = $data;
		}
	}
	return $response;
}

function get_models_condition_data($model_id, $ids = array()) {
	global $db;
	$response = array();
	
	$mysql_q_params = "";
	if(count($ids)>0) {
		$mysql_q_params = " AND id IN('".implode("','",$ids)."')";
	}
	
	$query=mysqli_query($db,"SELECT * FROM models_condition WHERE model_id='".$model_id."'".$mysql_q_params." ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_models_networks_data($model_id, $ids = array()) {
	global $db;
	$response = array();
	
	$mysql_q_params = "";
	if(count($ids)>0) {
		$mysql_q_params = " AND id IN('".implode("','",$ids)."')";
	}
	
	$query=mysqli_query($db,"SELECT * FROM models_networks WHERE model_id='".$model_id."'".$mysql_q_params." ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_models_connectivity_data($model_id, $ids = array()) {
	global $db;
	$response = array();
	
	$mysql_q_params = "";
	if(count($ids)>0) {
		$mysql_q_params = " AND id IN('".implode("','",$ids)."')";
	}
	
	$query=mysqli_query($db,"SELECT * FROM models_connectivity WHERE model_id='".$model_id."'".$mysql_q_params." ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_models_watchtype_data($model_id, $ids = array()) {
	global $db;
	$response = array();
	
	$mysql_q_params = "";
	if(count($ids)>0) {
		$mysql_q_params = " AND id IN('".implode("','",$ids)."')";
	}
	
	$query=mysqli_query($db,"SELECT * FROM models_watchtype WHERE model_id='".$model_id."'".$mysql_q_params." ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_models_case_material_data($model_id, $ids = array()) {
	global $db;
	$response = array();
	
	$mysql_q_params = "";
	if(count($ids)>0) {
		$mysql_q_params = " AND id IN('".implode("','",$ids)."')";
	}
	
	$query=mysqli_query($db,"SELECT * FROM models_case_material WHERE model_id='".$model_id."'".$mysql_q_params." ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_models_case_size_data($model_id, $ids = array()) {
	global $db;
	$response = array();
	
	$mysql_q_params = "";
	if(count($ids)>0) {
		$mysql_q_params = " AND id IN('".implode("','",$ids)."')";
	}
	
	$query=mysqli_query($db,"SELECT * FROM models_case_size WHERE model_id='".$model_id."'".$mysql_q_params." ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_models_color_data($model_id, $ids = array()) {
	global $db;
	$response = array();
	
	$mysql_q_params = "";
	if(count($ids)>0) {
		$mysql_q_params = " AND id IN('".implode("','",$ids)."')";
	}
	
	$query=mysqli_query($db,"SELECT * FROM models_color WHERE model_id='".$model_id."'".$mysql_q_params." ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_models_accessories_data($model_id, $ids = array()) {
	global $db;
	$response = array();
	
	$mysql_q_params = "";
	if(count($ids)>0) {
		$mysql_q_params = " AND id IN('".implode("','",$ids)."')";
	}
	
	$query=mysqli_query($db,"SELECT * FROM models_accessories WHERE model_id='".$model_id."'".$mysql_q_params." ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_models_miscellaneous_data($model_id, $ids = array()) {
	global $db;
	$response = array();
	
	$mysql_q_params = "";
	if(count($ids)>0) {
		$mysql_q_params = " AND id IN('".implode("','",$ids)."')";
	}
	
	$query=mysqli_query($db,"SELECT * FROM models_miscellaneous WHERE model_id='".$model_id."'".$mysql_q_params." ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_models_screen_size_data($model_id, $ids = array()) {
	global $db;
	$response = array();
	
	$mysql_q_params = "";
	if(count($ids)>0) {
		$mysql_q_params = " AND id IN('".implode("','",$ids)."')";
	}
	
	$query=mysqli_query($db,"SELECT * FROM models_screen_size WHERE model_id='".$model_id."'".$mysql_q_params." ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_models_screen_resolution_data($model_id, $ids = array()) {
	global $db;
	$response = array();
	
	$mysql_q_params = "";
	if(count($ids)>0) {
		$mysql_q_params = " AND id IN('".implode("','",$ids)."')";
	}
	
	$query=mysqli_query($db,"SELECT * FROM models_screen_resolution WHERE model_id='".$model_id."'".$mysql_q_params." ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_models_lyear_data($model_id, $ids = array()) {
	global $db;
	$response = array();
	
	$mysql_q_params = "";
	if(count($ids)>0) {
		$mysql_q_params = " AND id IN('".implode("','",$ids)."')";
	}
	
	$query=mysqli_query($db,"SELECT * FROM models_lyear WHERE model_id='".$model_id."'".$mysql_q_params." ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_models_processor_data($model_id, $ids = array()) {
	global $db;
	$response = array();
	
	$mysql_q_params = "";
	if(count($ids)>0) {
		$mysql_q_params = " AND id IN('".implode("','",$ids)."')";
	}
	
	$query=mysqli_query($db,"SELECT * FROM models_processor WHERE model_id='".$model_id."'".$mysql_q_params." ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_models_ram_data($model_id, $ids = array()) {
	global $db;
	$response = array();
	
	$mysql_q_params = "";
	if(count($ids)>0) {
		$mysql_q_params = " AND id IN('".implode("','",$ids)."')";
	}
	
	$query=mysqli_query($db,"SELECT * FROM models_ram WHERE model_id='".$model_id."'".$mysql_q_params." ORDER BY id ASC");

	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

// dependencies for model wrote by maxkyu
function get_models_dependencies($model_id, $ids = array()) {
	global $db;
	$response = array();
	
	$mysql_q_params = "";
	if(count($ids)>0) {
		$mysql_q_params = " AND id IN('".implode("','",$ids)."')";
	}
	
	$query=mysqli_query($db,"SELECT * FROM mobiles_dependencies WHERE model_id='".$model_id."'".$mysql_q_params." ORDER BY id ASC");

	$response = [];
	
	if($query){

		$num_of_rows = mysqli_num_rows($query);	

		if($num_of_rows>0) {
			while($data=mysqli_fetch_assoc($query)) {
				$response[] = $data;
			}
		}
	}

	
	return $response;
}

function get_category_storage_data($cat_id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM category_storage WHERE cat_id='".$cat_id."' ORDER BY id ASC");
	
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_category_condition_data($cat_id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM category_condition WHERE cat_id='".$cat_id."' ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_category_networks_data($cat_id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM category_networks WHERE cat_id='".$cat_id."' ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}



function get_category_connectivity_data($cat_id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM category_connectivity WHERE cat_id='".$cat_id."' ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_category_watchtype_data($cat_id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM category_watchtype WHERE cat_id='".$cat_id."' ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_category_case_material_data($cat_id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM category_case_material WHERE cat_id='".$cat_id."' ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_category_case_size_data($cat_id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM category_case_size WHERE cat_id='".$cat_id."' ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_category_color_data($cat_id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM category_color WHERE cat_id='".$cat_id."' ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_category_accessories_data($cat_id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM category_accessories WHERE cat_id='".$cat_id."' ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_category_screen_size_data($cat_id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM category_screen_size WHERE cat_id='".$cat_id."' ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_category_screen_resolution_data($cat_id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM category_screen_resolution WHERE cat_id='".$cat_id."' ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_category_lyear_data($cat_id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM category_lyear WHERE cat_id='".$cat_id."' ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_category_processor_data($cat_id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM category_processor WHERE cat_id='".$cat_id."' ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_category_ram_data($cat_id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM category_ram WHERE cat_id='".$cat_id."' ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}


function get_promocode_list() {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM promocode WHERE status=1 ORDER BY to_date DESC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($promocode_data=mysqli_fetch_assoc($query)) {
			$response[] = $promocode_data;
		}
	}
	return $response;
}

function get_faqs_list() {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM faqs WHERE status=1 ORDER BY RAND() LIMIT 4");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($faqs_data=mysqli_fetch_assoc($query)) {
			$response[] = $faqs_data;
		}
	}
	return $response;
}

function get_faqs_with_html($active_page_data = array()) {
	global $db;
	$response = array();
	$html = '';
	$data = array();

	$query=mysqli_query($db,"SELECT * FROM faqs WHERE status='1' ORDER BY ordering ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		$n = 0;
		$html .= '<div class="faq_cont accordion">';
  			$html .= '<div id="accordion">';
			while($faq_data=mysqli_fetch_assoc($query)) {
				$data[] = $faq_data;
				$n = $n+1;
				$html .= '<div class="card">';
					$html .= '<div class="card-header">';
					  $html .= '<h2 class="mb-0">';
						$html .= '<button class="btn btn-link" data-toggle="collapse" data-parent="#accordion" data-target="#collapse-'.$n.'">';
							$html .= $faq_data['title'];
							$html .= '<i class="fa fa-plus"></i><i class="fa fa-minus"></i>';
						$html .= '</button>';
					  $html .= '</h2>';
					$html .= '</div>';
					$html .= '<div id="collapse-'.$n.'" class="collapse show">';
					  $html .= '<div class="card-body">';
						  $html .= $faq_data['description'];
					  $html .= '</div>';
					$html .= '</div>';
				$html .= '</div>';
			}
			$html .= '</div>';
  		$html .= '</div>';
		$response['data'] = $data;
		$response['html'] = $html;
	}
	return $response;
}

function get_faqs_groups_with_html($active_page_data = array(), $cat_id = 0) {
	global $db;
	$response = array();
	$html = '';
	$data = array();

	$g_sql_params = "";
	if($cat_id>0) {
		$g_sql_params .= " AND cat_id='".$cat_id."'";

		$html .= '<div class="row">';
			$html .= '<div class="col-md-12">';
			  $html .= '<div class="block head pb-0 mb-0 border-line text-center clearfix">';
				$html .= '<div class="h1">ALGUNAS PREGUNTAS QUE PUEDE TENER</div>';
			  $html .= '</div>';
			$html .= '</div>';
		$html .= '</div>';
		  
		$g_query=mysqli_query($db,"SELECT * FROM faqs_groups WHERE status='1'".$g_sql_params." ORDER BY ordering ASC");
		$num_of_g_rows = mysqli_num_rows($g_query);
		if($num_of_g_rows>0) {
			$html .= '<div class="row"><div class="col-md-12"><div class="block clearfix"><div class="accordion" id="faq">';
			$n = 0;
			while($faq_group_data=mysqli_fetch_assoc($g_query)) {
					$query=mysqli_query($db,"SELECT * FROM faqs WHERE status='1' AND group_id='".$faq_group_data['id']."' ORDER BY ordering ASC");
					$num_of_rows = mysqli_num_rows($query);
					if($num_of_rows>0) {
						while($faq_data=mysqli_fetch_assoc($query)) {
							$data[] = $faq_data;
							$n = $n+1;
						  
							$html .= '<div class="card">';
								$html .= '<div class="card-header" id="headingOne">';
								$html .= '<h2 class="mb-0">';
									//'.($n>1?'collapsed':'').'
									$html .= '<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse-g-'.$n.'" aria-expanded="true" aria-controls="collapseOne">';
									  $html .= $faq_data['title'];
									  $html .= '<i class="fas fa-plus-square"></i><i class="fas fa-minus-square"></i>';
									$html .= '</button>';
								  $html .= '</h2>';
								$html .= '</div>';
								
								//'.($n==1?'show':'').'
								$html .= '<div id="collapse-g-'.$n.'" class="collapse" aria-labelledby="headingOne" data-parent="#faq">';
								  $html .= '<div class="card-body">';
									  $html .= $faq_data['description'];
								  $html .= '</div>';
								$html .= '</div>';
							$html .= '</div>';
						}
					}
			}
			$html .= '</div></div></div></div>';
		}
	} else {
		$html .= '<div class="row">';
			$html .= '<div class="col-md-12">';
			  $html .= '<div class="block head pb-0 mb-0 border-line text-center clearfix">';
				$html .= '<h1 class="h1 border-line clearfix">PREGUNTAS MAS FRECUENTES</h1>';
			  $html .= '</div>';
			$html .= '</div>';
		$html .= '</div>';
		  
		$g_query=mysqli_query($db,"SELECT * FROM faqs_groups WHERE status='1'".$g_sql_params." ORDER BY ordering ASC");
		$num_of_g_rows = mysqli_num_rows($g_query);
		if($num_of_g_rows>0) {
			$html .= '<div class="row"><div class="col-md-12">';
			$n = 0;
			while($faq_group_data=mysqli_fetch_assoc($g_query)) {
			    if ($faq_group_data['cat_id'] == 0){
    				$html .= '<div class="block content accordion-block clearfix"><div class="h2 text-center">'.$faq_group_data['title'].'</div>';
    					$html .= '<div class="accordion" id="faq'.$faq_group_data['id'].'">';
    	
    					$query=mysqli_query($db,"SELECT * FROM faqs WHERE status='1' AND group_id='".$faq_group_data['id']."' ORDER BY ordering ASC");
    					$num_of_rows = mysqli_num_rows($query);
    					if($num_of_rows>0) {
    						while($faq_data=mysqli_fetch_assoc($query)) {
    							$data[] = $faq_data;
    							$n = $n+1;
    						  
    							$html .= '<div class="card">';
    								$html .= '<div class="card-header" id="headingOne">';
    								$html .= '<h2 class="mb-0">';
    									// '.($n>1?'collapsed':'').'
    									$html .= '<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse-g-'.$n.'" aria-expanded="true" aria-controls="collapseOne">';
    									  $html .= $faq_data['title'];
    									  $html .= '<i class="fas fa-plus-square"></i><i class="fas fa-minus-square"></i>';
    									$html .= '</button>';
    								  $html .= '</h2>';
    								$html .= '</div>';
    								
    								// '.($n==1?'show':'').'
    								$html .= '<div id="collapse-g-'.$n.'" class="collapse" aria-labelledby="headingOne" data-parent="#faq'.$faq_group_data['id'].'">';
    								  $html .= '<div class="card-body">';
    									  $html .= $faq_data['description'];
    								  $html .= '</div>';
    								$html .= '</div>';
    							$html .= '</div>';
    						}
    					}
    					
    					$html .= '</div>';
    				$html .= '</div>';
			    }
			}
	
			/*$query=mysqli_query($db,"SELECT * FROM faqs WHERE status='1' AND (group_id='' OR group_id='0') ORDER BY ordering ASC");
			$num_of_rows = mysqli_num_rows($query);
			if($num_of_rows>0) {
				$html .= '<div class="faq_cont-box accordion"><h3>Others</h3>';
					$html .= '<div id="accordion">';
	
					while($faq_data=mysqli_fetch_assoc($query)) {
						$data[] = $faq_data;
						$n = $n+1;
						$html .= '<div class="card">';
							$html .= '<div class="card-header">';
							  $html .= '<h2 class="mb-0">';
								$html .= '<button class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" data-target="#collapse-g-'.$n.'">';
									$html .= $faq_data['title'];
									$html .= '<i class="fa fa-plus"></i><i class="fa fa-minus"></i>';
								$html .= '</button>';
							  $html .= '</h2>';
							$html .= '</div>';
							$html .= '<div id="collapse-g-'.$n.'" class="collapse">';
							  $html .= '<div class="card-body">';
								  $html .= $faq_data['description'];
							  $html .= '</div>';
							$html .= '</div>';
						$html .= '</div>';
					}
					
					$html .= '</div>';
				$html .= '</div>';
			}*/
			$html .= '</div></div>';		
		}
	}
	$response['data'] = $data;
	$response['html'] = $html;
	return $response;
}

function get_single_page_data_by_slug($sef_url) {
	global $db;
	$p_query=mysqli_query($db,"SELECT p.*, m.id AS menu_id, m.parent AS parent_menu_id, m.url AS menu_url, m.menu_name FROM pages AS p LEFT JOIN menus AS m ON m.page_id=p.id WHERE p.published='1' AND p.slug='".$sef_url."'");
	return mysqli_fetch_assoc($p_query);
}

function get_starbuck_location_list() {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM starbuck_location WHERE status=1 ORDER BY ordering ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data = mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function check_sef_url_validation($sef_url, $id, $table_nm) {
	global $db;
	$response = array();

	$response['valid'] = true;

	$brand_sql_params = "";
	$device_sql_params = "";
	$page_sql_params = "";
	if($table_nm == "brand") {
		$brand_sql_params .= " AND id!='".$id."'";
	}
	if($table_nm == "devices") {
		$device_sql_params .= " AND id!='".$id."'";
	}
	if($table_nm == "pages") {
		$page_sql_params .= " AND id!='".$id."'";
	}

	$qry = mysqli_query($db,"SELECT * FROM brand WHERE sef_url='".$sef_url."' AND sef_url!=''".$brand_sql_params);
	$num_of_brand = mysqli_num_rows($qry);
	if($num_of_brand>0) {
		$response['valid'] = false;
	}
	
	$qry_d = mysqli_query($db,"SELECT * FROM devices WHERE sef_url='".$sef_url."' AND sef_url!=''".$device_sql_params);
	$num_of_device = mysqli_num_rows($qry_d);
	if($num_of_device>0) {
		$response['valid'] = false;
	}
	
	$qry_p = mysqli_query($db,"SELECT * FROM pages WHERE url='".$sef_url."' AND url!=''".$page_sql_params);
	$num_of_page = mysqli_num_rows($qry_p);
	if($num_of_page>0) {
		$response['valid'] = false;
	}
	
	return $response;
}
?>