<?php
require_once("../../admin/_config/config.php");
require_once("../../admin/include/functions.php");

$order_id = $post['order_id'];
$mode = $post['mode'];
if(isset($order_id) && $mode=="del") {
	$user_id = $_SESSION['user_id'];
	//If direct access then it will redirect to home page
	if($user_id<=0) {
		$msg='Direct access denied';
		setRedirectWithMsg(SITE_URL,$msg,'danger');
		exit();
	}

	$query = mysqli_query($db,"UPDATE orders SET status='cancelled', cancelled_by='customer' WHERE user_id='".$user_id."' AND order_id='".$order_id."'");
	if($query == '1') {
		$msg='You have successfully cancelled your order.';
		setRedirectWithMsg($return_url,$msg,'success');
	} else {
		$msg='Sorry, something went wrong';
		setRedirectWithMsg($return_url,$msg,'error');
	}
} elseif(isset($order_id) && $mode=="del2") {
	$tmp_order_id = $_SESSION['tmp_order_id'];
	$query = mysqli_query($db,"UPDATE orders SET status='cancelled', cancelled_by='customer' WHERE order_id='".$tmp_order_id."' AND order_id='".$order_id."'");
	if($query == '1') {
		unset($_SESSION['tmp_order_id']);

		$msg='You have successfully cancelled your order.';
		setRedirectWithMsg(SITE_URL,$msg,'error');
	} else {
		$msg='Sorry, something went wrong';
		setRedirectWithMsg($return_url,$msg,'error');
	}
} else {
	$msg='Direct access denied';
	setRedirectWithMsg(SITE_URL,$msg,'danger');
}
exit(); ?>
