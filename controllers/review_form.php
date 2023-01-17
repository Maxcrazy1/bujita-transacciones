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
	$phone=real_escape_string($post['phone']);
	$city=real_escape_string($post['city']);
	$state=real_escape_string($post['state']);
	$zip_code=real_escape_string($post['zip_code']);
	$stars=real_escape_string($post['stars']);
	$device_sold=real_escape_string($post['device_sold']);
	$content=real_escape_string($post['content']);

	if($write_review_form_captcha == '1') {
		$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$captcha_secret."&response=".$post['g-recaptcha-response']);
		$response = json_decode($response, true);
		if($response["success"] !== true) {
			$msg = "Invalid captcha";
			setRedirectWithMsg($return_url,$msg,'warning');
			exit();
		}
	}

	if($name && $city && $state && $email && $phone && $stars && $zip_code && $content) {

		if($_FILES['image']['name']) {
			if(!file_exists('../images/review/'))
				mkdir('../images/review/',0777);

			$image_ext = pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
			if($image_ext=="png" || $image_ext=="jpg" || $image_ext=="jpeg" || $image_ext=="gif") {
				if($post['old_image']!="")
					unlink('../images/review/'.$post['old_image']);

				$image_tmp_name=$_FILES['image']['tmp_name'];
				$image_name=date('YmdHis').'.'.$image_ext;
				$imageupdate=', photo="'.$image_name.'"';
				move_uploaded_file($image_tmp_name,'../images/review/'.$image_name);
			} else {
				$msg="Image type must be png, jpg, jpeg, gif";
				setRedirectWithMsg($return_url,$msg,'danger');
				exit();
			}
		}

		$query=mysqli_query($db,"INSERT INTO reviews(name, email, phone, city, state, zip_code, stars, device_sold, content, date, photo) VALUES('".$name."','".$email."','".$phone."','".$city."','".$state."','".$zip_code."','".$stars."','".$device_sold."','".$content."','".date('Y-m-d H:i:s')."','".$image_name."')");
		$last_insert_id = mysqli_insert_id($db);
		if($query=="1") {
			$template_data = get_template_data('review_form_alert');
			$template_data_to_customer = get_template_data('review_thank_you_email_to_customer');

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
				'{$customer_fullname}',
				'{$customer_email}',
				'{$country}',
				'{$state}',
				'{$city}',
				'{$stars}',
				'{$form_title}',
				'{$form_message}',
				'{$device_sold}',
				'{$zip_code}',
				'{$customer_phone}');

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
				$post['name'],
				$post['email'],
				$post['country'],
				$post['state'],
				$post['city'],
				$post['stars'],
				$post['title'],
				$post['content'],
				$device_sold,
				$zip_code,
				$phone);

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
						"form_type" => 'review_form');
				
				save_inbox_mail_sms($inbox_mail_sms_data);
				//END Save data in inbox_mail_sms table
			} //END email send to customer

			$msg="Thank you for submitting a review of our business.";
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