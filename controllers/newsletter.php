<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");

if(isset($post['newsletter'])) {
	if(empty($_POST)) {
		$msg='Direct access denied';
		setRedirectWithMsg(SITE_URL,$msg,'danger');
		exit();
	}

	$f_newsletter_email=real_escape_string($post['f_newsletter_email']);
	if($f_newsletter_email!="") {
		$email=$f_newsletter_email;
	} else {
		$email=real_escape_string($post['email']);
	}
	$first_name=real_escape_string($post['first_name']);
	$last_name=real_escape_string($post['last_name']);
	if($f_newsletter_email!="" || ($f_newsletter_email=="" && $first_name && $last_name && $email)) {
		$chk_query=mysqli_query($db,"SELECT * FROM newsletters WHERE email='".$email."'");
		$exist_data=mysqli_fetch_assoc($chk_query);
		if(!empty($exist_data)) {
			$msg='This email already subscribed with us.';
			setRedirectWithMsg($return_url,$msg,'warning');
			exit();
		}

		$query=mysqli_query($db,"INSERT INTO newsletters(first_name, last_name, email, date) VALUES('".$first_name."','".$last_name."','".$email."','".date('Y-m-d H:i:s')."')");
		$last_insert_id = mysqli_insert_id($db);
		if($query=="1") {
			$template_data = get_template_data('newsletter_form_alert');
			$template_data_to_customer = get_template_data('newsletter_thank_you_email_to_customer');

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
				'{$customer_fname}',
				'{$customer_lname}',
				'{$customer_phone}',
				'{$customer_email}');

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
				$post['first_name'].' '.$post['last_name'],
				$post['first_name'],
				$post['last_name'],
				'',
				$post['email']);

			if(!empty($template_data)) {
				$email_subject = str_replace($patterns,$replacements,$template_data['subject']);
				$email_body_text = str_replace($patterns,$replacements,$template_data['content']);
				send_email($admin_user_data['email'], $email_subject, $email_body_text, $post['first_name'], $post['email']);
			}
			
			//Email send to User
			if(!empty($template_data_to_customer)) {
				$email_subject = str_replace($patterns,$replacements,$template_data_to_customer['subject']);
				$email_body_text = str_replace($patterns,$replacements,$template_data_to_customer['content']);
				send_email($post['email'], $email_subject, $email_body_text, FROM_NAME, FROM_EMAIL);
			}

			$msg="Thank you for submitted.";
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