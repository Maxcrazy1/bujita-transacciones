<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");

if(isset($post['submit_form'])) {
	if(empty($_POST)) {
		$msg='Direct access denied';
		setRedirectWithMsg(SITE_URL,$msg,'danger');
		exit();
	}

	$email=real_escape_string($post['email']);
	$order_id=real_escape_string($post['order_id']);

	if($order_track_form_captcha == '1') {
		$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$captcha_secret."&response=".$post['g-recaptcha-response']);
		$response = json_decode($response, true);
		if($response["success"] !== true) {
			$_SESSION['error_message'] = "Invalid captcha";
			//setRedirectWithMsg($return_url,$msg,'warning');
			setRedirect($return_url);
			exit();
		}
	}
	
	if($email && $order_id) {
		if($order_id) {
			$user_data = get_order_data('',$email);
			$order_data = get_order_data($order_id);
			if(empty($user_data) || empty($order_data)) {
				$_SESSION['error_message'] = "Please enter correct email or order";

				setRedirect($return_url);
				//$msg='Please enter correct email or order';
				//setRedirectWithMsg($return_url,$msg,'warning');
				exit();
			}/* elseif(empty($user_data)) {
				$msg='Please enter correct email.';
				setRedirectWithMsg($return_url,$msg,'warning');
				exit();
			} elseif(empty($order_data)) {
				$msg='Please enter correct order.';
				setRedirectWithMsg($return_url,$msg,'warning');
				exit();
			}*/ else {
				$_SESSION['track_order_id'] = $order_id;
				//$msg="";
				//setRedirectWithMsg($return_url.'?order_id='.$order_id,$msg,'success');
				setRedirect($return_url);
			}
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