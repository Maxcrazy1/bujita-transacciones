<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");

if(isset($post['submit_form'])) {
	if(empty($_POST)) {
		$msg='Direct access denied';
		setRedirectWithMsg(SITE_URL,$msg,'danger');
		exit();
	}

	$name=real_escape_string($post['name']);
	$email=real_escape_string($post['email']);
	$country=real_escape_string($post['country']);
	$state=real_escape_string($post['state']);
	$city=real_escape_string($post['city']);
	$zip_code=real_escape_string($post['zip_code']);
	$company_name=real_escape_string($post['company_name']);
	$content=real_escape_string($post['content']);
	$imp_devices="";//implode(", ",$post['devices']);
	$phone=real_escape_string($post['phone']);

	if($bulk_order_form_captcha == '1') {
		$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$captcha_secret."&response=".$post['g-recaptcha-response']);
		$response = json_decode($response, true);
		if($response["success"] !== true) {
			$msg = "Invalid captcha";
			setRedirectWithMsg($return_url,$msg,'warning');
			exit();
		}
	}

	if($name && $email && $phone && $content) {
		$query=mysqli_query($db,"INSERT INTO bulk_order_form(name, email, country, state, city, zip_code, devices, company_name, content, date, phone) VALUES('".$name."','".$email."','".$country."','".$state."','".$city."','".$zip_code."','".$imp_devices."','".$company_name."','".$content."','".date('Y-m-d H:i:s')."','".$phone."')");
		$last_insert_id = mysqli_insert_id($db);
		if($query=="1") {
			$template_data = get_template_data('bulk_order_form_alert');
			$template_data_to_customer = get_template_data('bulk_order_thank_you_email_to_customer');

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
				'{$customer_email}',
				'{$customer_phone}',
				'{$country}',
				'{$state}',
				'{$city}',
				'{$zip_code}',
				'{$company_name}',
				'{$devices}',
				'{$form_message}');
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
				$post['email'],
				$post['phone'],
				$post['country'],
				$post['state'],
				$post['city'],
				$post['zip_code'],
				$post['company_name'],
				$imp_devices,
				$post['content']);

			if(!empty($template_data)) {
				$email_subject = str_replace($patterns,$replacements,$template_data['subject']);
				$email_body_text = str_replace($patterns,$replacements,$template_data['content']);
				send_email($admin_user_data['email'], $email_subject, $email_body_text, $post['name'], $post['email']);
			}

			//START email send to customer
			if(!empty($template_data_to_customer)) {
				$email_subject = str_replace($patterns,$replacements,$template_data_to_customer['subject']);
				$email_body_text = str_replace($patterns,$replacements,$template_data_to_customer['content']);
				send_email($post['email'], $email_subject, $email_body_text, FROM_NAME, FROM_EMAIL);
				
				//START Save data in inbox_mail_sms table
				$inbox_mail_sms_data = array("template_id" => $template_data_to_customer['id'],
						"staff_id" => '',
						"user_id" => '',
						"order_id" => '',
						"from_email" => FROM_EMAIL,
						"to_email" => $post['email'],
						"subject" => $email_subject,
						"body" => $email_body_text,
						"sms_phone" => '',
						"sms_content" => '',
						"date" => date("Y-m-d H:i:s"),
						"leadsource" => 'website',
						"form_type" => 'bulk_order_form');
				
				save_inbox_mail_sms($inbox_mail_sms_data);
				//END Save data in inbox_mail_sms table
			} //END email send to customer

			$msg="Thank you contacting us for bulk order. We'll contact you shortly.";
			setRedirectWithMsg($return_url,$msg,'success');
		} else {
			$msg='Sorry, something went wrong';
			setRedirectWithMsg($return_url,$msg,'danger');
		}	
	} else {
		$msg='Please fill in all required fields.';
		setRedirectWithMsg($return_url,$msg,'warning');
	}
	exit();
} else {
	$msg='Direct access denied';
	setRedirectWithMsg(SITE_URL,$msg,'danger');
	exit();
} ?>