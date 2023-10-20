<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");

if(isset($post['missing_product'])) {
	if(empty($_POST)) {
		$msg='Direct access denied';
		setRedirectWithMsg(SITE_URL,$msg,'danger');
		exit();
	}

	$name=real_escape_string($post['name']);
	$phone=preg_replace("/[^\d]/", "", real_escape_string($post['phone']));
	$email=real_escape_string($post['email']);
	$item_name=real_escape_string($post['item_name']);
	$subject='';
	$message=real_escape_string($post['message']);
	
	if($missing_product_form_captcha == '1') {
		$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$captcha_secret."&response=".$post['g-recaptcha-response']);
		$response = json_decode($response, true);
		if($response["success"] !== true) {
			$msg = "Invalid captcha";
			setRedirectWithMsg($return_url,$msg,'warning');
			exit();
		}
	}
	
	if($name && $phone && $email && $item_name) {
		$query=mysqli_query($db,"INSERT INTO contact(name, phone, email, item_name, subject, message, date, type) values('".$name."','".$phone."','".$email."','".$item_name."','".$subject."','".$message."','".date('Y-m-d H:i:s')."', 'quote')");
		$last_insert_id = mysqli_insert_id($db);
		if($query=="1") {
			$template_data = get_template_data('quote_request_form_alert');

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
				'{$customer_fullname}',
				'{$customer_phone}',
				'{$customer_email}',
				'{$current_date_time}',
				'{$form_subject}',
				'{$form_message}',
				'{$item_name}');
				
            $header_logo = str_replace('my_preheader', substr(preg_replace('/\{\$\w+\_\w+\}/i',"",$template_data['content']),0,74), $header_logo);
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
				$post['name'],
				$phone,
				$post['email'],
				format_date(date('Y-m-d H:i')).' '.format_time(date('Y-m-d H:i')),
				$post['subject'],
				$post['message'],
				$post['item_name']);

			if(!empty($template_data)) {
				$email_subject = str_replace($patterns,$replacements,$template_data['subject']);
				$email_body_text = str_replace($patterns,$replacements,$template_data['content']);
				send_email($admin_user_data['email'], $email_subject, $email_body_text, $post['name'], $post['email']);
			}

			$msg="Thank you for quote request. We'll contact you shortly.";
			setRedirectWithMsg($return_url,$msg,'success');
		} else {
			$msg='Sorry! something wrong updation failed.';
			setRedirectWithMsg($return_url,$msg,'danger');
		}
	} else {
		$msg='please fill in all required fields.';
		setRedirectWithMsg($return_url,$msg,'warning');
	}
	exit();
} elseif(isset($post['sell_this_device'])) {
	if(empty($_POST)) {
		$msg='Direct access denied';
		setRedirectWithMsg(SITE_URL,$msg,'danger');
		exit();
	}

	$fields_cat_type = $post['fields_cat_type'];
	$quantity = $post['quantity'];
	$req_model_id = $post['req_model_id'];
	$imei_number = $post['imei_number'];
	$edit_item_id = $post['edit_item_id'];
	if($quantity>0) {
		$storage_id = $post['check_capacity'];
		$condition_id = $post['check_condition'];
		$network_id = $post['check_network'];
		$color_id = $post['check_color'];
		$accessories_ids = $post['check_accessories'];
		$connectivity_id = $post['check_connectivity'];
		$case_size_id = $post['check_case_size'];
		$watchtype_id = $post['check_watchtype'];
		$case_material_id = $post['check_case_material'];
		$screen_size_id = $post['check_screen_size'];
		$screen_resolution_id = $post['check_screen_resolution'];
		$lyear_id = $post['check_lyear'];
		$processor_id = $post['check_processor'];
		$ram_id = $post['check_ram'];

		if($storage_id>0) {
			$storage_list = get_models_storage_data($req_model_id,array($storage_id));
		}
		if($condition_id>0) {
			$condition_list = get_models_condition_data($req_model_id,array($condition_id));
		}
		if($network_id>0) {
			$network_list = get_models_networks_data($req_model_id,array($network_id));
		}
		if(!empty($color_id)) {
			$color_list = get_models_color_data($req_model_id,array($color_id));
		}
		if(!empty($accessories_ids)) {
			$accessories_list = get_models_accessories_data($req_model_id,$accessories_ids);
		}
		/*if($connectivity_id>0) {
			$connectivity_list = get_models_connectivity_data($req_model_id,array($connectivity_id));
		}*/
		if($watchtype_id>0) {
			$watchtype_list = get_models_watchtype_data($req_model_id,array($watchtype_id));
		}
		if($case_material_id>0) {
			$case_material_list = get_models_case_material_data($req_model_id,array($case_material_id));
		}
		if($case_size_id>0) {
			$case_size_list = get_models_case_size_data($req_model_id,array($case_size_id));
		}
		if($screen_size_id>0) {
			$screen_size_list = get_models_screen_size_data($req_model_id,array($screen_size_id));
		}
		if($screen_resolution_id>0) {
			$screen_resolution_list = get_models_screen_resolution_data($req_model_id,array($screen_resolution_id));
		}
		if($lyear_id>0) {
			$lyear_list = get_models_lyear_data($req_model_id,array($lyear_id));
		}
		if($processor_id>0) {
			$processor_list = get_models_processor_data($req_model_id,array($processor_id));
		}
		if($ram_id>0) {
			$ram_list = get_models_ram_data($req_model_id,array($ram_id));
		}
		
		$network_mode = $watchtype_list[0]['disabled_network'];
		
		$capacity_name = $storage_list[0]['storage_size'].$storage_list[0]['storage_size_postfix'];
		$condition_name = $condition_list[0]['condition_name'];
		if($fields_cat_type == "mobile" || ($fields_cat_type != "mobile" && $network_mode == '1')) {
			$network_name = $network_list[0]['network_name'];
		}
		$color_name = $color_list[0]['color_name'];
		$connectivity_name = "";//$connectivity_list[0]['connectivity_name'];
		$watchtype_name = $watchtype_list[0]['watchtype_name'];
		$case_material_name = $case_material_list[0]['case_material_name'];
		$case_size = $case_size_list[0]['case_size'];
		$screen_size = $screen_size_list[0]['screen_size_name'];
		$screen_resolution = $screen_resolution_list[0]['screen_resolution_name'];
		$lyear = $lyear_list[0]['lyear_name'];
		$processor = $processor_list[0]['processor_name'];
		$ram = $ram_list[0]['ram_size'].$ram_list[0]['ram_size_postfix'];
		
		if(preg_match("/unlock/",strtolower($network_name)) || network_name=="") {
			$network_price_mode = "";
		} else {
			$network_price_mode = $post['network_price_mode'];
		}

		$accessories_array = array();
		foreach($accessories_list as $key=>$accessories_data) {
			if($accessories_data['accessories_name']) {
				$accessories_array[] = $accessories_data['accessories_name'].": Yes";
			}
		}
		$accessories_name = implode(", ",$accessories_array);

		$miscellaneous_array = array();
		foreach($post['check_miscellaneous'] as $key=>$miscellaneous) {
			$exp_miscellaneous = explode("::",$miscellaneous);
			$miscellaneous_array[] = $exp_miscellaneous[0].':Yes';
		}
		$miscellaneous = implode(", ",$miscellaneous_array);

		$order_id = $_SESSION['order_id'];
		if($order_id=="") {
			$random_order_id = '1';
			$o_q = mysqli_query($db,"SELECT * FROM `orders` ORDER BY id DESC");
			$last_order_data = mysqli_fetch_assoc($o_q);
			/*if(!empty($last_order_data)) {
				$last_svd_order_id = preg_replace('/\D/','',$last_order_data['order_id']);
				if($last_svd_order_id!="") {
					$random_order_id = ($last_svd_order_id+1);
				}
			}*/

			$random_order_id = $last_order_data['id'];
			$_SESSION['order_id'] = $order_prefix.$random_order_id;
			//$_SESSION['order_id'] = $order_prefix.date('s').rand(100000,999999);
			$order_id = $_SESSION['order_id'];
			mysqli_query($db,"INSERT INTO `orders`(`order_id`, `date`, `status`) VALUES('".$order_id."','".date('Y-m-d H:i:s')."','partial')");
		}

		$quantity_price = $post['payment_amt'];
		$item_price = ($quantity_price * $quantity);
		//$item_price = $quantity_price;

		$order_item_ids = $_SESSION['order_item_ids'];
		if(empty($order_item_ids))
			$order_item_ids = array();
		
		if($edit_item_id>0) {
			$query=mysqli_query($db,"UPDATE `order_items` SET `device_id`='".$post['device_id']."', `model_id`='".$req_model_id."', `order_id`='".$order_id."', `storage`='".real_escape_string($capacity_name)."', `condition`='".real_escape_string($condition_name)."', `network`='".real_escape_string($network_name)."', `color`='".real_escape_string($color_name)."', `accessories`='".real_escape_string($accessories_name)."', `miscellaneous`='".real_escape_string($miscellaneous)."', `connectivity`='".real_escape_string($connectivity_name)."', `watchtype`='".real_escape_string($watchtype_name)."', `case_material`='".real_escape_string($case_material_name)."', `case_size`='".real_escape_string($case_size)."', `screen_size`='".real_escape_string($screen_size)."', `screen_resolution`='".real_escape_string($screen_resolution)."', `lyear`='".real_escape_string($lyear)."', `processor`='".real_escape_string($processor)."', `ram`='".real_escape_string($ram)."', `price`='".$item_price."', `quantity`='".$quantity."', `quantity_price`='".$quantity_price."', imei_number='".$imei_number."', network_price_mode='".$network_price_mode."' WHERE id='".$edit_item_id."'");
			//$last_insert_id = $edit_item_id;
		} else {
			/*$is_updated_in_existing_item = false;
			if(!empty($order_item_ids)) {
				$req_item_nm_array = array('device_id'=>$post['device_id'],'model_id'=>$req_model_id,'storage'=>$capacity_name,'condition'=>$condition[0],'network'=>$network[0],'color'=>$color[0],'accessories'=>$accessories,'miscellaneous'=>$miscellaneous);
	
				$order_item_query=mysqli_query($db,"SELECT oi.* FROM order_items AS oi WHERE oi.id IN('".implode("','",$order_item_ids)."')");
				$order_item_num_of_rows = mysqli_num_rows($order_item_query);
				if($order_item_num_of_rows>0) {
					while($order_item_data=mysqli_fetch_assoc($order_item_query)) {
						$saved_item_nm_array = array('device_id'=>$order_item_data['device_id'],'model_id'=>$order_item_data['model_id'],'storage'=>$order_item_data['storage'],'condition'=>$order_item_data['condition'],'network'=>$order_item_data['network'],'color'=>$order_item_data['color'],'accessories'=>$order_item_data['accessories'],'miscellaneous'=>$order_item_data['miscellaneous']);
						if($req_item_nm_array == $saved_item_nm_array) {
							$is_updated_in_existing_item = true;
							$upt_svd_item_price = ($item_price+$order_item_data['price']);
							$upt_svd_item_qty = ($quantity+$order_item_data['quantity']);
							mysqli_query($db,"UPDATE `order_items` SET price='".$upt_svd_item_price."', quantity='".$upt_svd_item_qty."', quantity_price='".$quantity_price."' WHERE id='".$order_item_data['id']."'");
						}
					}
				}
			}
	
			if(!$is_updated_in_existing_item) {*/
			for($q=1; $q<=$quantity; $q++) {
				$quantity_val = 1;
				$query=mysqli_query($db,"INSERT INTO `order_items`(`device_id`, `model_id`, `order_id`, `storage`, `condition`, `network`, `color`, `accessories`, `miscellaneous`, `connectivity`, `watchtype`, `case_material`, `case_size`, `screen_size`, `screen_resolution`, `lyear`, `processor`, `ram`, `price`, `quantity`, `quantity_price`, imei_number, network_price_mode) VALUES('".$post['device_id']."','".$req_model_id."','".$order_id."','".real_escape_string($capacity_name)."','".real_escape_string($condition_name)."','".real_escape_string($network_name)."','".real_escape_string($color_name)."','".real_escape_string($accessories_name)."','".real_escape_string($miscellaneous)."','".real_escape_string($connectivity_name)."','".real_escape_string($watchtype_name)."','".real_escape_string($case_material_name)."','".real_escape_string($case_size)."', '".real_escape_string($screen_size)."', '".real_escape_string($screen_resolution)."', '".real_escape_string($lyear)."', '".real_escape_string($processor)."', '".real_escape_string($ram)."','".$item_price."','".$quantity_val."','".$quantity_price."','".$imei_number."','".$network_price_mode."')");
				$last_insert_id = mysqli_insert_id($db);
				if($query=="1") {
					array_push($order_item_ids,$last_insert_id);
					$_SESSION['order_item_ids']=$order_item_ids;
				}
			}
			//}
		}
	}

	setRedirect(SITE_URL.'revieworder');
	exit();
} else {
	$msg='Direct access denied';
	setRedirectWithMsg(SITE_URL,$msg,'danger');
	exit();
} ?>