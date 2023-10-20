<?php 
$file_name="paid_orders";

//Header section
require_once("include/header.php");

//Filter by
$filter_by = "";
//$browser_params = "?export=yes";

if($post['filter_by']) {
	//$browser_params .= "&filter_by=".$post['filter_by'];
	
	$filter_by .= " AND (o.order_id LIKE '%".$post['filter_by']."' OR o.id LIKE '%".$post['filter_by']."'  OR u.name LIKE '%".$post['filter_by']."' OR u.email LIKE '%".$post['filter_by']."' OR u.phone LIKE '%".$post['filter_by']."' OR u.username LIKE '%".$post['filter_by']."')";
}
if($post['user_id']>0) {
	$filter_by .= " AND (o.user_id LIKE '%".$post['user_id']."')";
}

if($post['status']) {
	//$browser_params .= "&status=".$post['status'];
	$filter_by .= " AND o.status='".$post['status']."'";
}

if($post['payment_method']) {
	$browser_params .= "&payment_method=".$post['payment_method'];
	$filter_by .= " AND o.payment_method='".$post['payment_method']."'";
}

if($post['is_payment_sent']!='') {
	//$browser_params .= "&is_payment_sent=".$post['is_payment_sent'];
	$filter_by .= " AND o.is_payment_sent='".$post['is_payment_sent']."'";
}

if($post['payment_paid_batch_id']!='') {
	//$browser_params .= "&payment_paid_batch_id=".$post['payment_paid_batch_id'];
	$filter_by .= " AND o.payment_paid_batch_id='".$post['payment_paid_batch_id']."'";
}

if($post['from_date'] != "" && $post['to_date'] != "") {
	//$browser_params .= "&from_date=".$post['from_date'];
	//$browser_params .= "&to_date=".$post['to_date'];
	
	$exp_from_date = explode("/",$post['from_date']);
	$from_date = $exp_from_date['2'].'-'.$exp_from_date['0'].'-'.$exp_from_date['1'];
	
	$exp_to_date = explode("/",$post['to_date']);
	$to_date = $exp_to_date['2'].'-'.$exp_to_date['0'].'-'.$exp_to_date['1'];
	
	$filter_by .= " AND (DATE_FORMAT(o.date,'%Y-%m-%d')>='".$from_date."' AND DATE_FORMAT(o.date,'%Y-%m-%d')<='".$to_date."')";
} elseif($post['from_date'] != "") {
	//$browser_params .= "&from_date=".$post['from_date'];

	$exp_from_date = explode("/",$post['from_date']);
	$from_date = $exp_from_date['2'].'-'.$exp_from_date['0'].'-'.$exp_from_date['1'];
	$filter_by .= " AND DATE_FORMAT(o.date,'%Y-%m-%d')='".$from_date."'";
} elseif($post['to_date'] != "") {
	//$browser_params .= "&to_date=".$post['to_date'];

	$exp_to_date = explode("/",$post['to_date']);
	$to_date = $exp_to_date['2'].'-'.$exp_to_date['0'].'-'.$exp_to_date['1'];
	$filter_by .= " AND DATE_FORMAT(o.date,'%Y-%m-%d')='".$to_date."'";
}

/*if(isset($_REQUEST['export'])) {
	setRedirect(ADMIN_URL.'download_order_export.php'.$browser_params);
	exit;
}*/

//Get num of orders for pagination
$order_p_query=mysqli_query($db,"SELECT COUNT(*) AS num_of_orders, o.*, u.first_name, u.last_name,u.name FROM orders AS o LEFT JOIN users AS u ON u.id=o.user_id WHERE o.status!='partial' AND o.is_payment_sent='1' ".$filter_by." ORDER BY o.date DESC");
$order_p_data = mysqli_fetch_assoc($order_p_query);
$pages->set_total($order_p_data['num_of_orders']);
			
//Fetch list of order
$order_query=mysqli_query($db,"SELECT o.*, u.first_name, u.last_name,u.name FROM orders AS o LEFT JOIN users AS u ON u.id=o.user_id WHERE o.status!='partial' AND o.is_payment_sent='1' AND o.is_trash='0' ".$filter_by." ORDER BY o.date DESC ".$pages->get_limit()."");

$order_paid_batch_q=mysqli_query($db,"SELECT o.*, u.first_name, u.last_name,u.name FROM orders AS o LEFT JOIN users AS u ON u.id=o.user_id WHERE o.status!='partial' AND o.is_payment_sent='1' AND o.is_trash='0' GROUP BY o.payment_paid_batch_id ORDER BY o.date DESC");

//Template file
require_once("views/order/paid_orders.php");

//Footer section
include("include/footer.php"); ?>
