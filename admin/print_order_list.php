<?php
require_once("_config/config.php");
require_once("include/functions.php");

//Filter by
$filter_by = "";

$heading_title = "Orders List";
if($post['order_mode'] == "awaiting") {
	$heading_title = "Awaiting Orders List";
	$filter_by .= " AND o.is_payment_sent='0' AND o.is_trash='0' AND o.status='awaiting_delivery'";
} elseif($post['order_mode'] == "unpaid") {
	$heading_title = "Unpaid Orders List";
	$filter_by .= " AND o.is_payment_sent='0' AND o.is_trash='0'";
} elseif($post['order_mode'] == "paid") {
	$heading_title = "Paid Orders List";
	$filter_by .= " AND o.is_payment_sent='1' AND o.is_trash='0'";
} elseif($post['order_mode'] == "archive") {
	$heading_title = "Archive Orders List";
	$filter_by .= " AND o.is_trash='1'";
}

if($post['filter_by']) {
	$filter_by .= " AND (o.order_id LIKE '%".$post['filter_by']."' OR o.id LIKE '%".$post['filter_by']."'  OR u.name LIKE '%".$post['filter_by']."' OR u.email LIKE '%".$post['filter_by']."' OR u.phone LIKE '%".$post['filter_by']."' OR u.username LIKE '%".$post['filter_by']."')";
}
if($post['user_id']>0) {
	$filter_by .= " AND (o.user_id LIKE '%".$post['user_id']."')";
}

if($post['status']) {
	$filter_by .= " AND o.status='".$post['status']."'";
}

if($post['ids']) {
	$filter_by .= " AND o.order_id IN('".str_replace(",","','",$post['ids'])."')";
}

if($post['from_date'] != "" && $post['to_date'] != "") {
	$exp_from_date = explode("/",$post['from_date']);
	$from_date = $exp_from_date['2'].'-'.$exp_from_date['0'].'-'.$exp_from_date['1'];
	
	$exp_to_date = explode("/",$post['to_date']);
	$to_date = $exp_to_date['2'].'-'.$exp_to_date['0'].'-'.$exp_to_date['1'];
	
	$filter_by .= " AND (DATE_FORMAT(o.date,'%Y-%m-%d')>='".$from_date."' AND DATE_FORMAT(o.date,'%Y-%m-%d')<='".$to_date."')";
} elseif($post['from_date'] != "") {
	$exp_from_date = explode("/",$post['from_date']);
	$from_date = $exp_from_date['2'].'-'.$exp_from_date['0'].'-'.$exp_from_date['1'];
	$filter_by .= " AND DATE_FORMAT(o.date,'%Y-%m-%d')='".$from_date."'";
} elseif($post['to_date'] != "") {
	$exp_to_date = explode("/",$post['to_date']);
	$to_date = $exp_to_date['2'].'-'.$exp_to_date['0'].'-'.$exp_to_date['1'];
	$filter_by .= " AND DATE_FORMAT(o.date,'%Y-%m-%d')='".$to_date."'";
}
		
//Fetch list of order
$order_query=mysqli_query($db,"SELECT o.*, u.first_name, u.last_name FROM orders AS o LEFT JOIN users AS u ON u.id=o.user_id WHERE o.status!='partial' ".$filter_by." ORDER BY o.date DESC");
?>

<!doctype html>
<html>
<head>
	<title></title>
	<style type="text/css" media="print">
	@page {
		size: auto;
		margin: 0mm;
	}
	body {
		background-color:#FFFFFF; 
		margin: 20px;
	}
</style>
</head>
<body style="margin-left:200px;margin-right:200px;">
	<?php /*?><a class="btn btn-general" href="javascript:void(0);" onClick="printDiv('print_order_data');">Print</a><?php */?>
	<div id="print_order_data">
		<?php
		//Template file
		require_once("views/print_order_list.php"); ?>
	</div>
	
	<script language="javascript" type="text/javascript">
	function printDiv(divID) {
		var divElements = document.getElementById(divID).innerHTML;
		var oldPage = document.body.innerHTML;
	
		document.body.innerHTML = divElements;
	
		//Print Page
		window.print();
	
		//Restore orignal HTML
		document.body.innerHTML = oldPage;
		return true;
	}
	
	window.addEventListener("afterprint", myFunction);
	function myFunction() {
		//location.reload(true);
		window.close();
	}

	printDiv('print_order_data');
	</script>
</body>
</html>