<?php
require_once("../_config/config.php");
require_once("../include/functions.php");

$response = array();

$item_id = $post['item_id'];
$date = date("Y-m-d H:i:s");

if($item_id == "") {
	exit;
} else {
	$query=mysqli_query($db,"SELECT * FROM order_items WHERE id='".$item_id."'");
	$order_items_data=mysqli_fetch_assoc($query);
	if($order_items_data['imei_number']!="") {
		$imei_serial_number = trim($order_items_data['imei_number']);
		if($imei_serial_number!="" && $imei_api_key!="") {
			$proimei_url = "https://proimei.info/en/prepaid/api/".$imei_api_key."/".$imei_serial_number."/fmip";
			$proimei_data = get_data_using_curl($proimei_url);
			$icloud_status = $proimei_data['iCloud Status'];
		}
		
		if($proimei_data['error']!="") {
			$response['message'] = "Error: ".$proimei_data['error'];
			$response['status'] = false;
			$response['icloud_status'] = "error";
		} else {
			$response['message'] = "You have successfully received";
			$response['status'] = true;
			$response['icloud_status'] = $icloud_status;
		}
	} else {
		$response['message'] = "Something went wrong!!!";
		$response['status'] = false;
	}
}

echo json_encode($response);
exit;
?>