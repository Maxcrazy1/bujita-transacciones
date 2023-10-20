<?php
require_once("../../admin/_config/config.php");
require_once("../../admin/include/functions.php");

$user_id = $_SESSION['user_id'];
if($user_id<=0) {
	setRedirect(SITE_URL);
	exit();
}

if(isset($post['submit_form'])) {
	if(empty($_POST)) {
		$msg='Direct access denied';
		setRedirectWithMsg(SITE_URL,$msg,'danger');
		exit();
	}
	
	if($post['password']==$post['password2']) {
		$query=mysqli_query($db,"UPDATE `users` SET `password`='".md5($post['password'])."' WHERE id='".$user_id."'");
		if($query=="1") {
			unset($_SESSION['login_user']);
			unset($_SESSION['user_id']);
			$msg = 'Password has been successfully changed';
			setRedirectWithMsg($return_url,$msg,'success');
			exit();
		}
	} else {
		$_SESSION['account_tab'] = "chg_psw";
		$msg = 'New password and confirm password not matched.';
		setRedirectWithMsg($return_url,$msg,'warning');
		exit();
	}
} else {
	$msg='Direct access denied';
	setRedirectWithMsg(SITE_URL,$msg,'danger');
	exit();
} ?>