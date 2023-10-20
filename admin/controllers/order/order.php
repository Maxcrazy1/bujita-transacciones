<?php 
require_once("../../_config/config.php");
require_once("../../include/functions.php");

if(isset($post['create_shipment'])) {
	$order_id = $post['order_id'];
	if($order_id=="") {
		$msg='Sorry! something wrong!!';
		$_SESSION['error_msg']=$msg;
		setRedirect(ADMIN_URL.'edit_order.php?order_id='.$order_id);
		exit();
	}

	$order_data = get_order_data($order_id);
	
	//Get order price based on orderID, path of this function (get_order_price) admin/include/functions.php
	$sum_of_orders = get_order_price($order_id);

	$express_service = $order_data['express_service'];
	$express_service_price = $order_data['express_service_price'];
	$shipping_insurance = $order_data['shipping_insurance'];
	$shipping_insurance_per = $order_data['shipping_insurance_per'];

	$f_express_service_price = 0;
	$f_shipping_insurance_price = 0;
	if($express_service == '1') {
		$f_express_service_price = $express_service_price;
	}
	if($shipping_insurance == '1') {
		$f_shipping_insurance_price = ($sum_of_orders*$shipping_insurance_per/100);
	}

	//START post shipment by easypost API
	if($shipping_api == "easypost" && $shipping_api_key != "") {
		require_once("../../../libraries/easypost-php-master/lib/easypost.php");
		\EasyPost\EasyPost::setApiKey($shipping_api_key);

		// create address
		$to_address_params = array(
			"verify"  =>  array("delivery"),
			//'name' => $company_name,
			'company' => $company_name,
			'street1' => $company_address,
			'city' => $company_city,
			'state' => $company_state,
			'zip' => $company_zipcode,
			'country' => $company_country,
			'phone' => substr($company_phone, -10),
			'email' => $site_email
		);

		// create address
		$from_address_params = array(
			"verify"  =>  array("delivery"),
			'name' => $order_data['name'],
			'street1' => $order_data['address'],
			//'street2' => $order_data['address2'],
			'city' => $order_data['city'],
			'state' => $order_data['state'],
			'zip' => $order_data['postcode'],
			'country' => $company_country,
			'phone' => substr($order_data['phone'], -10),
			'email' => $order_data['email']
		);
	
		$to_address = \EasyPost\Address::create($to_address_params);
		$from_address = \EasyPost\Address::create($from_address_params);

		if($to_address->verifications->delivery->success != '1') {
			$msg='Company address invalid so first please enter currect address & try again';
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_order.php?order_id='.$order_id);
			exit();
		}
		
		if($from_address->verifications->delivery->success != '1') {
			$msg='Customer address invalid so first please enter currect address & try again';
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_order.php?order_id='.$order_id);
			exit();
		}
		
		try {
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
		
				$shipment_id = $shipment->id;
				$shipment_tracking_code = $shipment->tracker->tracking_code;
				$shipment_label_url = $shipment->postage_label->label_url;
			}
	
			$req_ordr_params = array('order_id' => $order_id,
					'shipping_api' => $shipping_api,
					'shipment_id' => $shipment_id,
					'shipment_tracking_code' => $shipment_tracking_code,
					'shipment_label_url' => $shipment_label_url,
				);
			$resp_save_default_status = save_shipment_response_data($req_ordr_params);
			
			$msg = "Shipment successfully created.";
			$_SESSION['success_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_order.php?order_id='.$order_id);
			exit();
		} catch(\EasyPost\Error $e) {
			$shipment_error = "Error: ".$e->getHttpStatus().":".$e->getMessage();
			error_log("Error: ".$e->getHttpStatus().":".$e->getMessage());

			$msg='Unable to create shipment, one or more parameters were invalid.';
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_order.php?order_id='.$order_id);
			exit();
		}
	} //END post shipment by easypost API
	else {
		$msg = "API disabled or something went wrong! so please contact with developer.";
		$_SESSION['success_msg']=$msg;
		setRedirect(ADMIN_URL.'edit_order.php?order_id='.$order_id);
		exit();
	}
} elseif(isset($post['d_id'])) {
	$query=mysqli_query($db,'DELETE FROM orders WHERE order_id="'.$post['d_id'].'"');
	if($query=="1"){
		mysqli_query($db,'DELETE FROM order_items WHERE order_id="'.$post['d_id'].'"');
		mysqli_query($db,'DELETE FROM order_messaging WHERE order_id="'.$post['d_id'].'"');
		$msg="Order successfully removed.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong Delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'archive_orders.php');
	exit();
} elseif(isset($post['bulk_remove'])) {
	$ids_array = $post['ids'];
	if(!empty($ids_array)) {
		$removed_idd = array();
		foreach(explode(",",$ids_array) as $id_k=>$id_v) {
			$removed_idd[] = $id_v;
			$query=mysqli_query($db,'DELETE FROM orders WHERE order_id="'.$id_v.'" ');
			if($query=='1') {
				mysqli_query($db,'DELETE FROM order_items WHERE order_id="'.$id_v.'"');
				mysqli_query($db,'DELETE FROM order_messaging WHERE order_id="'.$id_v.'"');
			}
		}
	}

	$msg = count($removed_idd)." Order(s) successfully removed.";
	if(count($removed_idd)=='1')
		$msg = "Order successfully removed.";

	$_SESSION['success_msg']=$msg;
	setRedirect(ADMIN_URL.'archive_orders.php');
	exit();
} elseif(isset($post['a_id'])) {
	$query=mysqli_query($db,"UPDATE orders SET is_trash='1' WHERE order_id='".$post['a_id']."'");
	if($query=="1"){
		$msg="Order successfully archived.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong Delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	
	if($post['order_mode'] == "unpaid") {
		setRedirect(ADMIN_URL.'orders.php');
	} elseif($post['order_mode'] == "awaiting") {
		setRedirect(ADMIN_URL.'awaiting_orders.php');
	} elseif($post['order_mode'] == "imei") {
		setRedirect(ADMIN_URL.'search_by_imei_orders.php');
	} else {
		setRedirect(ADMIN_URL.'paid_orders.php');
	}
	exit();
} elseif(isset($post['bulk_archive'])) {
	$ids_array = $post['ids'];
	if(!empty($ids_array)) {
		$removed_idd = array();
		foreach(explode(",",$ids_array) as $id_k=>$id_v) {
			$removed_idd[] = $id_v;
			$query=mysqli_query($db,"UPDATE orders SET is_trash='1' WHERE order_id='".$id_v."'");
			if($query=='1') {
			}
		}
	}

	$msg = count($removed_idd)." Order(s) successfully archived.";
	if(count($removed_idd)=='1')
		$msg = "Order successfully archived.";

	$_SESSION['success_msg']=$msg;
	if($post['order_mode'] == "unpaid") {
		setRedirect(ADMIN_URL.'orders.php');
	} elseif($post['order_mode'] == "awaiting") {
		setRedirect(ADMIN_URL.'awaiting_orders.php');
	} elseif($post['order_mode'] == "imei") {
		setRedirect(ADMIN_URL.'search_by_imei_orders.php');
	} else {
		setRedirect(ADMIN_URL.'paid_orders.php');
	}
	exit();
} elseif(isset($post['u_id'])) {
	$query=mysqli_query($db,"UPDATE orders SET is_trash='0' WHERE order_id='".$post['u_id']."'");
	if($query=="1"){
		$msg="Order successfully undone.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong Delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	
	setRedirect(ADMIN_URL.'archive_orders.php');
	exit();
} elseif(isset($post['bulk_undo'])) {
	$ids_array = $post['ids'];
	if(!empty($ids_array)) {
		$removed_idd = array();
		foreach(explode(",",$ids_array) as $id_k=>$id_v) {
			$removed_idd[] = $id_v;
			$query=mysqli_query($db,"UPDATE orders SET is_trash='0' WHERE order_id='".$id_v."'");
			if($query=='1') {
			}
		}
	}

	$msg = count($removed_idd)." Order(s) successfully undone.";
	if(count($removed_idd)=='1')
		$msg = "Order successfully undone.";

	$_SESSION['success_msg']=$msg;
	setRedirect(ADMIN_URL.'archive_orders.php');
	exit();
} elseif(isset($post['bulk_set_paid'])) {
	$ids_array = $post['ids'];
	if(!empty($ids_array)) {
		$payment_paid_batch_id = date("dHmi").rand(0000,9999);
		$removed_idd = array();
		$is_any_order_status_not_completed = "no";
		foreach(explode(",",$ids_array) as $id_k=>$id_v) {
			$removed_idd[] = $id_v;
			
			$mysql_payment_paid_batch_id = "";
			
			$order_data_before_saved = get_order_data($id_v);
			if($order_data_before_saved['is_payment_sent']!='1') {
				$mysql_payment_paid_batch_id = ", payment_paid_batch_id='".$payment_paid_batch_id."'";
			}
		
			if($order_data_before_saved['status'] != "completed") {
				$is_any_order_status_not_completed = "yes";
			}
			
			$query=mysqli_query($db,"UPDATE orders SET is_payment_sent='1', payment_sent_date='".date("Y-m-d H:i:s")."'".$mysql_payment_paid_batch_id." WHERE order_id='".$id_v."' AND status='completed'");
			if($query == '1' && $order_data_before_saved['is_payment_sent']!='1') {
				$template_data = get_template_data('order_payment_status_paid_alert_email_to_customer');
				$general_setting_data = get_general_setting_data();
				$admin_user_data = get_admin_user_data();
				
				$sum_of_orders=get_order_price($order_id);
				if($order_data_before_saved['promocode_id']>0 && $order_data_before_saved['promocode_amt']>0) {
					$total_of_order = $sum_of_orders+$order_data_before_saved['promocode_amt'];
				} else {
					$total_of_order = $sum_of_orders;
				}
			
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
					'{$order_total}');

//Emmanuel's changes			
			$temp_arr = strtolower($order_data_before_saved['name']).";";
            $temp_arr = preg_split("/[\s*]/", $temp_arr);
            $hold ="";
            foreach($temp_arr as $str){
               $hold.= ucfirst($str)." ";
            }
            $temp_arr = trim(preg_replace("/\;/", "", $hold));	
            
            
            $pre_header = strip_tags($template_data['content']);
            $pre_header = preg_replace('/\{\$(header_logo)\}/i', '' ,$pre_header);
            $pre_header = preg_replace('/\{\$(footer_logo)\}/i', '' ,$pre_header);
            $pre_header = preg_replace('/\{\$(customer_fullname)\}(\W)/i', $temp_arr."$2".' ' ,$pre_header);
            
				$replacements_1 = array(
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
					$order_data_before_saved['first_name'],
					$order_data_before_saved['last_name'],
					$order_data_before_saved['name'],
					$order_data_before_saved['phone'],
					$order_data_before_saved['email'],
					$order_data_before_saved['address'],
					$order_data_before_saved['address2'],
					$order_data_before_saved['city'],
					$order_data_before_saved['state'],
					$order_data_before_saved['country'],
					$order_data_before_saved['postcode'],
					$order_data_before_saved['company_name'],
					$order_data_before_saved['order_id'],
					$order_data_before_saved['payment_method'],
					$order_data_before_saved['order_date'],
					$order_data_before_saved['approved_date'],
					$order_data_before_saved['expire_date'],
					ucwords(str_replace("_"," ",$order_data_before_saved['order_status'])),
					$order_data_before_saved['sales_pack'],
					format_date(date('Y-m-d H:i')).' '.format_time(date('Y-m-d H:i'),
					amount_fomat($total_of_order))
				);
				
			$pre_header = str_replace($patterns,$replacements_1,$pre_header);
			$header_logo = str_replace('my_preheader', substr($pre_header,0), $header_logo);
			
		/*	$temp_arr = strtolower($order_data_before_saved['name']).";";
            $temp_arr = preg_split("/[\s*]/", $temp_arr);
            $hold ="";
            foreach($temp_arr as $str){
               $hold.= ucfirst($str)." ";
            }
            $temp_arr = trim(preg_replace("/\;/", "", $hold));				
			
			$header_logo = str_replace('my_preheader', substr(preg_replace('/\{\$\w+\_\w+\}/i',"", preg_replace('/\{\$(customer_fullname)\}(\W)/i', $temp_arr."$2".' ' ,$template_data['content'])),0,300), $header_logo);
		*/
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
					$order_data_before_saved['first_name'],
					$order_data_before_saved['last_name'],
					$order_data_before_saved['name'],
					$order_data_before_saved['phone'],
					$order_data_before_saved['email'],
					$order_data_before_saved['address'],
					$order_data_before_saved['address2'],
					$order_data_before_saved['city'],
					$order_data_before_saved['state'],
					$order_data_before_saved['country'],
					$order_data_before_saved['postcode'],
					$order_data_before_saved['company_name'],
					$order_data_before_saved['order_id'],
					$order_data_before_saved['payment_method'],
					$order_data_before_saved['order_date'],
					$order_data_before_saved['approved_date'],
					$order_data_before_saved['expire_date'],
					ucwords(str_replace("_"," ",$order_data_before_saved['order_status'])),
					$order_data_before_saved['sales_pack'],
					format_date(date('Y-m-d H:i')).' '.format_time(date('Y-m-d H:i'),
					amount_fomat($total_of_order))
				);
	
				if(!empty($template_data) && $order_data_before_saved['email']!="") {
					$email_subject = str_replace($patterns,$replacements,$template_data['subject']);
					$email_body_text = str_replace($patterns,$replacements,$template_data['content']);
					send_email($order_data_before_saved['email'], $email_subject, $email_body_text, FROM_NAME, FROM_EMAIL);
				}
			}
		}
	}
	
	if($is_any_order_status_not_completed == "yes") {
		$msg = "Some Order(s) status is not completed so first please mark as completed.";
		if(count($removed_idd)=='1')
			$msg = "Order status is not completed so first please mark as completed.";
	} else {
		$msg = count($removed_idd)." Order(s) payment status successfully paid.";
		if(count($removed_idd)=='1')
			$msg = "Order payment status successfully paid.";
	}
	
	$_SESSION['success_msg']=$msg;
	if($post['order_mode'] == "unpaid") {
		setRedirect(ADMIN_URL.'orders.php');
	} elseif($post['order_mode'] == "awaiting") {
		setRedirect(ADMIN_URL.'awaiting_orders.php');
	} elseif($post['order_mode'] == "imei") {
		setRedirect(ADMIN_URL.'search_by_imei_orders.php');
	} else {
		setRedirect(ADMIN_URL.'paid_orders.php');
	}
	exit();
} elseif(isset($post['update'])) {
	$order_id = $post['order_id'];
	$email_template_id = $post['email_template'];
	$order_data_before_saved = get_order_data($order_id);

	$note=real_escape_string($post['note']);
	$status=$post['status'];
	$o_from_email = $post['o_from_email'];

	if($status=="awaiting_shipment" && ($order_data_before_saved['status']!="awaiting_shipment" || $order_data_before_saved['approved_date']=="0000-00-00 00:00:00")) {
		$approved_date = ',approved_date="'.date("Y-m-d H:i:s").'"';
		$expire_date = ',expire_date="'.date("Y-m-d H:i:s",strtotime("+".$order_expired_days." day")).'"';
	}

	if($status=="offer_accepted")
		$offer_status=', offer_status="'.$status.'"';
	elseif($status=="offer_rejected")
		$offer_status=', offer_status="'.$status.'"';
	
	$o_query=mysqli_query($db,"SELECT * FROM orders WHERE order_id='".$order_id."'");
	$order_data=mysqli_fetch_assoc($o_query);
	if($status=="cancelled" && $order_data['status']!='cancelled') {
		$cancelled_by=', cancelled_by="admin"';
	}
	
	if($order_id) {
		$query=mysqli_query($db,'UPDATE orders SET status="'.$status.'", note="'.$note.'"'.$approved_date.$expire_date.$offer_status.$cancelled_by.' WHERE order_id="'.$order_id.'"');
		if($query=="1") {
			if($email_template_id>0) {
				$template_data = get_template_data_by_id($email_template_id);
			} else {
				$template_data = get_template_data('admin_reply_from_order');
			}

			$general_setting_data = get_general_setting_data();
			$admin_user_data = get_admin_user_data();
			$order_data = get_order_data($order_id);

			$sum_of_orders=get_order_price($order_id);
			if($order_data['promocode_id']>0 && $order_data['promocode_amt']>0) {
				$total_of_order = $sum_of_orders+$order_data['promocode_amt'];
			} else {
				$total_of_order = $sum_of_orders;
			}
			
			$model_item_id = $post['model_item_id'];
			$model_item_data = get_order_item($model_item_id,'');

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
				'{$order_item_model}',
				'{$order_item_price}',
				'{$order_item_storage}',
				'{$order_item_condition}',
				'{$order_item_locks}',
				'{$order_total}');
				
//Emmanuel's changes			
			$temp_arr = strtolower($order_data['name']).";";
            $temp_arr = preg_split("/[\s*]/", $temp_arr);
            $hold ="";
            foreach($temp_arr as $str){
               $hold.= ucfirst($str)." ";
            }
            $temp_arr = trim(preg_replace("/\;/", "", $hold));	
            
            
            $pre_header = strip_tags($template_data['content']);
            $pre_header = preg_replace('/\{\$(header_logo)\}/i', '' ,$pre_header);
            $pre_header = preg_replace('/\{\$(footer_logo)\}/i', '' ,$pre_header);
            $pre_header = preg_replace('/\{\$(customer_fullname)\}(\W)/i', $temp_arr."$2".' ' ,$pre_header);
            
            	$replacements_1 = array(
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
				$model_item_data['data']['brand_title'].' - '.$model_item_data['data']['model_title'],
				amount_fomat($model_item_data['data']['price']),
				$model_item_data['data']['storage'],
				$model_item_data['data']['condition'],
				$model_item_data['data']['network'],
				amount_fomat($total_of_order)
				);
				
			$pre_header = str_replace($patterns,$replacements_1,$pre_header);
			$header_logo = str_replace('my_preheader', substr($pre_header,0), $header_logo);
            //$header_logo = str_replace('my_preheader', substr(preg_replace('/\{\$\w+\_\w+\}/i',"", preg_replace('/\{\$(customer_fullname)\}(\W)/i', $temp_arr."$2".' ' ,$pre_header)),0), $header_logo);
		    
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
				$model_item_data['data']['brand_title'].' - '.$model_item_data['data']['model_title'],
				amount_fomat($model_item_data['data']['price']),
				$model_item_data['data']['storage'],
				$model_item_data['data']['condition'],
				$model_item_data['data']['network'],
				amount_fomat($total_of_order)
				);
				
			
            //$pre_header = strip_tags(str_replace($patterns,$replacements,$template_data['content']));
            
			
			//$header_logo = str_replace('my_preheader', substr(preg_replace('/\{\$\w+\_\w+\}/i',"", preg_replace('/\{\$(customer_fullname)\}(\W)/i', $temp_arr."$2".' ' ,$template_data['content'])),0), $header_logo);
			

			if(!empty($template_data)) {


				$email_subject = str_replace($patterns,$replacements,$template_data['subject']);
				$email_body_text = str_replace($patterns,$replacements,$post['note']);

				$cabeceras = "From: ".FROM_NAME." <".FROM_EMAIL.">" . "\r\n";
				$cabeceras .= "Reply-To:" .FROM_EMAIL."\r\n";
				$cabeceras .= "MIME-Version: 1.0" . "\r\n";
				$cabeceras .= "Content-Type: text/html; charset=UTF-8" . "\r\n";

				mail($order_data['email'],$email_subject,$email_body_text,$cabeceras);



				//START sms send to customer
				if($template_data['sms_status']=='1' && $sms_sending_status=='1') {
					$from_number = '+'.$general_setting_data['twilio_long_code'];
					$to_number = '+'.$order_data['phone'];
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
						"staff_id" => $_SESSION['admin_id'],
						"user_id" => $order_data['user_id'],
						"order_id" => $order_data['order_id'],
						"from_email" => FROM_EMAIL,
						"to_email" => $order_data['email'],
						"subject" => $email_subject,
						"body" => $email_body_text,
						"sms_phone" => $to_number,
						"sms_content" => $sms_body_text,
						"date" => date("Y-m-d H:i:s"),
						"leadsource" => 'website',
						"form_type" => 'change_order_status');
				
				save_inbox_mail_sms($inbox_mail_sms_data);
				//END Save data in inbox_mail_sms table
			}

			$msg="Order has been successfully updated.";
			$_SESSION['success_msg']=$msg;
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
		}
		setRedirect(ADMIN_URL.'edit_order.php?order_id='.$post['order_id'].'&order_mode='.$post['order_mode']);
		exit();
	}
} elseif(isset($post['update_order'])) {
	$order_id = $post['order_id'];
	$note=real_escape_string($post['note']);
	$status=$post['status'];


	$model_item_id = $post['model_item_id'];
	$model_item_data = get_order_item($model_item_id,'');
	/*echo '<pre>';
	print_r($post);
	exit;*/
	
	foreach($post['imei_number'] as $s_key => $imei_number) {
		$imei_number = real_escape_string($imei_number);
		//$storage=real_escape_string($post['storage'][$s_key]);
		//$condition=real_escape_string($post['condition'][$s_key]);
		//$network=real_escape_string($post['network'][$s_key]);
		//$accessories=real_escape_string($post['accessories'][$s_key]);
		//$miscellaneous=real_escape_string($post['miscellaneous'][$s_key]);
		$price = real_escape_string($post['price'][$s_key]);
		$quantity = $post['quantity'][$s_key];

		$item_query = mysqli_query($db, "SELECT * FROM order_items WHERE id='".$s_key."'");
		$item_data = mysqli_fetch_assoc($item_query);
		if($quantity>0 && $item_data['quantity']<$quantity) {
			$upt_quantity = ($quantity-$item_data['quantity']);
			$item_price = ($item_data['price']+($price * $upt_quantity));
		} elseif($quantity>0 && $item_data['quantity']>$quantity) {
			$upt_quantity = ($item_data['quantity']-$quantity);
			$item_price = ($item_data['price']-($price * $upt_quantity));
		} else {
			$item_price = $price;
		}

		//$query=mysqli_query($db,"UPDATE `order_items` SET `imei_number`='".$imei_number."', `storage`='".$storage."', `condition`='".$condition."', `network`='".$network."', `accessories`='".$accessories."', `miscellaneous`='".$miscellaneous."', `price`='".$price."' WHERE id='".$s_key."'");
		$query=mysqli_query($db,"UPDATE `order_items` SET `imei_number`='".$imei_number."', `price`='".$item_price."', quantity='".$quantity."' WHERE id='".$s_key."'");
	}	



	$query=mysqli_query($db,'UPDATE orders SET status="'.$status.'", note="'.$note.'"'.$approved_date.$expire_date.$offer_status.$cancelled_by.' WHERE order_id="'.$order_id.'"');

	$order_data = get_order_data($order_id);

	if($query=="1") {
		if($email_template_id>0) {
			$template_data = get_template_data_by_id($email_template_id);
		} else {
			$template_data = get_template_data('admin_reply_from_order');
		}
	}

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
		'{$order_total}');

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
		amount_fomat($total_of_order)
		);
	



	$email_subject = str_replace($patterns,$replacements,$template_data['subject']);
	$email_body_text = str_replace($patterns,$replacements,$template_data['content']);

	$cabeceras = "From: ".FROM_NAME." <".FROM_EMAIL.">" . "\r\n";
	$cabeceras .= "Reply-To:" .FROM_EMAIL."\r\n";
	$cabeceras .= "MIME-Version: 1.0" . "\r\n";
	$cabeceras .= "Content-Type: text/html; charset=UTF-8" . "\r\n";

	mail($order_data['email'],$email_subject,$email_body_text,$cabeceras);

	if($query == '1') {
		$msg="Order has been successfully updated.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong updation failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'edit_order.php?order_id='.$post['order_id'].'&order_mode='.$post['order_mode']);
	exit();
} elseif(isset($post['save'])) {
	$order_id = $post['order_id'];
	$order_data_before_saved = get_order_data($order_id);

	$payment_paid_amount=real_escape_string($post['payment_paid_amount']);
	$transaction_id=real_escape_string($post['transaction_id']);
	$check_number=real_escape_string($post['check_number']);
	$bank_name=real_escape_string($post['bank_name']);
	$is_payment_sent = $post['is_payment_sent'];
	if($is_payment_sent == '1' && $order_data_before_saved['is_payment_sent']!='1') {
		$payment_sent_date = date("Y-m-d H:i:s");
		$payment_paid_batch_id = date("dHmi").rand(0000,9999);
		$payment_sent_date = ', payment_sent_date="'.$payment_sent_date.'", payment_paid_batch_id="'.$payment_paid_batch_id.'"';
	}

	if($_FILES['payment_receipt']['name']) {
		$image_ext = pathinfo($_FILES['payment_receipt']['name'],PATHINFO_EXTENSION);
		if($image_ext=="png" || $image_ext=="jpg" || $image_ext=="jpeg" || $image_ext=="gif") {
			$image_tmp_name=$_FILES['payment_receipt']['tmp_name'];
			$payment_receipt='receipt_'.date('YmdHis').'.'.$image_ext;
			$img_payment_receipt=', payment_receipt="'.$payment_receipt.'"';
			move_uploaded_file($image_tmp_name,'../../../images/payment/'.$payment_receipt);
		} else {
			$msg="Image type must be png, jpg, jpeg, gif";
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_order.php?order_id='.$post['order_id']);
			exit();
		}
	}

	if($_FILES['cheque_photo']['name']) {
		$image2_ext = pathinfo($_FILES['cheque_photo']['name'],PATHINFO_EXTENSION);
		if($image2_ext=="png" || $image2_ext=="jpg" || $image2_ext=="jpeg" || $image2_ext=="gif") {
			$image2_tmp_name=$_FILES['cheque_photo']['tmp_name'];
			$cheque_photo='cheque_'.date('YmdHis').'.'.$image2_ext;
			$img_cheque_photo=', cheque_photo="'.$cheque_photo.'"';
			move_uploaded_file($image2_tmp_name,'../../../images/payment/'.$cheque_photo);
		} else {
			$msg="Image type must be png, jpg, jpeg, gif";
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_order.php?order_id='.$post['order_id']);
			exit();
		}
	}
	
	$query=mysqli_query($db,'UPDATE orders SET payment_paid_amount="'.$payment_paid_amount.'", transaction_id="'.$transaction_id.'", check_number="'.$check_number.'", bank_name="'.$bank_name.'", is_payment_sent="'.$is_payment_sent.'"'.$payment_sent_date.' '.$img_payment_receipt.$img_cheque_photo.' WHERE order_id="'.$order_id.'"');
	if($query=="1") {
		if($order_data_before_saved['is_payment_sent']!='1') {
			$template_data = get_template_data('order_payment_status_paid_alert_email_to_customer');
			$general_setting_data = get_general_setting_data();
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
				'{$customer_company_name}',
				'{$order_id}',
				'{$order_payment_method}',
				'{$order_date}',
				'{$order_approved_date}',
				'{$order_expire_date}',
				'{$order_status}',
				'{$order_sales_pack}',
				'{$current_date_time}');
				
			$temp_arr = strtolower($order_data_before_saved['name']).";";
            $temp_arr = preg_split("/[\s*]/", $temp_arr);
            $hold ="";
            foreach($temp_arr as $str){
               $hold.= ucfirst($str)." ";
            }
            $temp_arr = trim(preg_replace("/\;/", "", $hold));	
            
            
            $pre_header = strip_tags($template_data['content']);
            $pre_header = preg_replace('/\{\$(header_logo)\}/i', '' ,$pre_header);
            $pre_header = preg_replace('/\{\$(footer_logo)\}/i', '' ,$pre_header);
            $pre_header = preg_replace('/\{\$(customer_fullname)\}(\W)/i', $temp_arr."$2".' ' ,$pre_header);
            
			$replacements_1 = array(
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
				$order_data_before_saved['first_name'],
				$order_data_before_saved['last_name'],
				$order_data_before_saved['name'],
				$order_data_before_saved['phone'],
				$order_data_before_saved['email'],
				$order_data_before_saved['address'],
				$order_data_before_saved['address2'],
				$order_data_before_saved['city'],
				$order_data_before_saved['state'],
				$order_data_before_saved['country'],
				$order_data_before_saved['postcode'],
				$order_data_before_saved['company_name'],
				$order_data_before_saved['order_id'],
				$order_data_before_saved['payment_method'],
				$order_data_before_saved['order_date'],
				$order_data_before_saved['approved_date'],
				$order_data_before_saved['expire_date'],
				ucwords(str_replace("_"," ",$order_data_before_saved['order_status'])),
				$order_data_before_saved['sales_pack'],
				format_date(date('Y-m-d H:i')).' '.format_time(date('Y-m-d H:i'))
			);

				
			$pre_header = str_replace($patterns,$replacements_1,$pre_header);
			$header_logo = str_replace('my_preheader', substr($pre_header,0), $header_logo);
			
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
				$order_data_before_saved['first_name'],
				$order_data_before_saved['last_name'],
				$order_data_before_saved['name'],
				$order_data_before_saved['phone'],
				$order_data_before_saved['email'],
				$order_data_before_saved['address'],
				$order_data_before_saved['address2'],
				$order_data_before_saved['city'],
				$order_data_before_saved['state'],
				$order_data_before_saved['country'],
				$order_data_before_saved['postcode'],
				$order_data_before_saved['company_name'],
				$order_data_before_saved['order_id'],
				$order_data_before_saved['payment_method'],
				$order_data_before_saved['order_date'],
				$order_data_before_saved['approved_date'],
				$order_data_before_saved['expire_date'],
				ucwords(str_replace("_"," ",$order_data_before_saved['order_status'])),
				$order_data_before_saved['sales_pack'],
				format_date(date('Y-m-d H:i')).' '.format_time(date('Y-m-d H:i'))
			);

			if(!empty($template_data) && $order_data_before_saved['email']!="") {
				$email_subject = str_replace($patterns,$replacements,$template_data['subject']);
				$email_body_text = str_replace($patterns,$replacements,$template_data['content']);
				send_email($order_data_before_saved['email'], $email_subject, $email_body_text, FROM_NAME, FROM_EMAIL);
			}
		}
	}

	$msg="Order payment status paid has been successfully updated.";
	$_SESSION['success_msg']=$msg;

	setRedirect(ADMIN_URL.'edit_order.php?order_id='.$post['order_id'].'&order_mode='.$post['order_mode']);
	exit();
} elseif(isset($post['import_ref_ids'])) {
	if($_FILES['file_name']['name'] == "") {
		$msg="Please choose .csv, .xls or .xlsx file.";
		$_SESSION['success_msg']=$msg;
		setRedirect(ADMIN_URL.'mobile.php');
		exit();
	} else {
		$path = str_replace(' ','_',$_FILES['file_name']['name']);
		$ext = pathinfo($path,PATHINFO_EXTENSION);
		if($ext=="csv" || $ext=="xls" || $ext=="xlsx") {

			$filename=$_FILES['file_name']['tmp_name'];
			move_uploaded_file($filename,'../../uploaded_file/'.$path);

			$excel_file_path = '../../uploaded_file/'.$path;
			require('../../libraries/spreadsheet-reader-master/php-excel-reader/excel_reader2.php');
			require('../../libraries/spreadsheet-reader-master/SpreadsheetReader.php');
			$excel_file_data_list = new SpreadsheetReader($excel_file_path);
			foreach($excel_file_data_list as $ek=>$excel_file_data)
			{
			
				$batch_id = $excel_file_data[0];
				$order_id = $excel_file_data[1];
				$transaction_id = $excel_file_data[2];
				if(($ext=="xls" && $ek>1) || ($ext!="xls" && $ek>0)) {
					if($order_id!="") {
						$batch_id = $excel_file_data[0];
						$order_id = $excel_file_data[1];
						$transaction_id = $excel_file_data[2];
						$query = mysqli_query($db,"UPDATE orders SET transaction_id='".$transaction_id."' WHERE order_id='".$order_id."'");
					}
				}
			}

			if($query == '1') {
				unlink($excel_file_path);
				$msg="Data(s) successfully imported.";
				$_SESSION['success_msg']=$msg;
			} else {
				$msg='Sorry! something wrong imported failed.';
				$_SESSION['error_msg']=$msg;
			}
		} else {
			$msg="Allow only .csv, .xls or .xlsx file.";
			$_SESSION['error_msg']=$msg;
		}
	}
	setRedirect(ADMIN_URL.'paid_orders.php');
} elseif(isset($post['sell_this_device'])) {
	$order_id = $post['order_id'];
	$fields_cat_type = $post['fields_cat_type'];
	$quantity = $post['quantity'];
	$req_model_id = $post['req_model_id'];
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
		$connectivity_name = "";
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
		
		$miscellaneous = "";
		$miscellaneous_array = array();
		if(!empty($post['check_miscellaneous'])) {
		foreach($post['check_miscellaneous'] as $key=>$miscellaneous) {
			$exp_miscellaneous = explode("::",$miscellaneous);
			$miscellaneous_array[] = $exp_miscellaneous[0].':Yes';
		}
		$miscellaneous = implode(", ",$miscellaneous_array);
		}
		
		$quantity_price = $post['payment_amt'];
		$item_price = ($quantity_price * $quantity);
		//$item_price = $quantity_price;
		
		if($edit_item_id>0) {
			$query=mysqli_query($db,"UPDATE `order_items` SET `device_id`='".$post['device_id']."', `model_id`='".$req_model_id."', `storage`='".real_escape_string($capacity_name)."', `condition`='".real_escape_string($condition_name)."', `network`='".real_escape_string($network_name)."', `color`='".real_escape_string($color_name)."', `accessories`='".real_escape_string($accessories_name)."', `miscellaneous`='".real_escape_string($miscellaneous)."', `connectivity`='".real_escape_string($connectivity_name)."', `watchtype`='".real_escape_string($watchtype_name)."', `case_material`='".real_escape_string($case_material_name)."', `case_size`='".real_escape_string($case_size)."', `screen_size`='".real_escape_string($screen_size)."', `screen_resolution`='".real_escape_string($screen_resolution)."', `lyear`='".real_escape_string($lyear)."', `processor`='".real_escape_string($processor)."', `ram`='".real_escape_string($ram)."', `price`='".$item_price."', `quantity`='".$quantity."', `quantity_price`='".$quantity_price."', network_price_mode='".$network_price_mode."' WHERE id='".$edit_item_id."'");
		}
	}

	setRedirect(ADMIN_URL.'edit_order.php?order_id='.$order_id.'&order_mode='.$post['order_mode']);
	exit();
} elseif(isset($post['resend_email_id'])) {
	$resend_email_id = $post['resend_email_id'];
	if($resend_email_id>0) {
		$ims_query=mysqli_query($db,"SELECT * FROM inbox_mail_sms WHERE id='".$resend_email_id."'");
		$inbox_mail_sms_data=mysqli_fetch_assoc($ims_query);

		$order_id = $inbox_mail_sms_data['order_id'];
		$order_data = get_order_data($order_id);
		
		$pdf_name='order-'.$order_id.'.pdf';
		$to_email = $inbox_mail_sms_data['to_email'];
		$email_subject = $inbox_mail_sms_data['subject'];
		$email_body_text = $inbox_mail_sms_data['body'];
		
		if($to_email!="") {
			if($order_data['sales_pack']=="free_postage_label") {
				if($inbox_mail_sms_data['form_type'] == "confirm_order") {
					$attachment_data['basename'] = array("free_postage_label.pdf",$pdf_name);
					$attachment_data['folder'] = array('pdf','pdf');
				}
				send_email($to_email, $email_subject, $email_body_text, FROM_NAME, FROM_EMAIL, $attachment_data);
			} else {
				if($inbox_mail_sms_data['form_type'] == "confirm_order") {
					$attachment_data['basename'] = array($pdf_name);
					$attachment_data['folder'] = array('pdf');
				}
				send_email($to_email, $email_subject, $email_body_text, FROM_NAME, FROM_EMAIL, $attachment_data);
			}
			$msg='Resend email successfully send.';
			$_SESSION['success_msg']=$msg;
		} else {
			$msg='Sorry! something went wrong Please try again.';
			$_SESSION['error_msg']=$msg;
		}
		
		setRedirect(ADMIN_URL.'edit_order.php?order_id='.$order_id.'&order_mode='.$post['order_mode']);
		exit();
	} else {
		$msg='Sorry! something went wrong Please try again.';
		$_SESSION['error_msg']=$msg;
		setRedirect(ADMIN_URL.'orders.php');
		exit;
	}
} elseif($post['d_p_id']) {
	if($post['mode']=="payment_receipt") {
		mysqli_query($db,"UPDATE orders SET payment_receipt='' WHERE order_id='".$post['d_p_id']."'");
	} elseif($post['mode']=="cheque_photo") {
		mysqli_query($db,"UPDATE orders SET cheque_photo='' WHERE order_id='".$post['d_p_id']."'");
	}

	setRedirect(ADMIN_URL.'edit_order.php?order_id='.$post['d_p_id'].'&order_mode='.$post['order_mode']);
	exit();
} else {
	setRedirect(ADMIN_URL.'orders.php');
	exit;
}
?>