<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");

$data = file_get_contents("php://input");
if(!empty($data)) {
	$event_data = json_decode($data, true);
	$tracking_code = $event_data['result']['tracking_code'];
	$status = $event_data['result']['status'];

	$order_status = "";
	$approved_date = "";
	$expire_date = "";
	
	if($status == "pre_transit") {
		$order_status = "awaiting_shipment";

		$datetime = date('Y-m-d H:i:s');
		$approved_date = ", approved_date='".$datetime."'";
		$expire_date = ", expire_date='".date("Y-m-d H:i:s",strtotime($datetime." +".$order_expired_days." day"))."'";

	} elseif($status == "in_transit" || $status == "out_for_delivery") {
		$order_status = "shipped";
	} elseif($status == "delivered") {
		$order_status = "delivered";
	} elseif($status == "failure" || $status == "unknown") {
		$order_status = "shipment_problem";
	} elseif($status == "return_to_sender") {
		$order_status = "returned_to_sender";
	}

	//wh_log('tracking_code:'.$tracking_code);
	//wh_log('status:'.$status);
	//wh_log(print_r($event_data,true));
	
	/*function wh_log($msg) {
		$logfile = 'logs/easypost_'.date("Y-m-d-h-i-s").'.log';
		file_put_contents($logfile,date("Y-m-d H:i:s")." | ".$msg."\n",FILE_APPEND);
	}*/
	
	if($tracking_code!="" && $order_status!="") {
		mysqli_query($db,"UPDATE `orders` SET `status`='".$order_status."'".$approved_date.$expire_date." WHERE shipment_tracking_code='".$tracking_code."'");
	}
} else {
	die("Direct access denied");
}