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

if(isset($post['export'])) {
$html = <<<EOF
<!-- EXAMPLE OF CSS STYLE -->
<style>
table,td{
  margin:0;
  padding:0;
}
.small-text{
  font-size:10px;
  text-align:center;
}
.block{
  width:45%;
}
.block-border{
  border:1px dashed #ddd;
}
.divider{
  width:10%;
}
.hdivider{
  height:0px;
}
.title{
  font-size:20px;
  font-weight:bold;
}
</style>
EOF;

if($post['order_mode'] == "awaiting") {
	$html.='<h2>'.$heading_title.'</h2>
	<table cell-padding="0" cell-spacing="0" border="1" width="100%" style="padding:5px;">
		<thead>
		  <tr>
			<th><strong>Order ID</strong></th>
			<th><strong>Customer</strong></th>
			<th><strong>Date</strong></th>
			<th><strong>Approved Date</strong></th>
			<th><strong>Price</strong></th>
			<th><strong>Payment Method</strong></th>
			<th><strong>Status</strong></th>
		  </tr>
		</thead>
		<tbody>';
	
		$num_rows = mysqli_num_rows($order_query);
		if($num_rows>0) {
			while($order_data=mysqli_fetch_assoc($order_query)) {
				$promocode_amt = 0;				
				$total_of_order = 0;
				
				//Get order price based on orderID, path of this function (get_order_price) admin/include/functions.php
				$sum_of_orders=get_order_price($order_data['order_id']);
				
				if($order_data['promocode_id']>0 && $order_data['promocode_amt']>0) {
					$promocode_amt = $order_data['promocode_amt'];
					$total_of_order = $sum_of_orders+$order_data['promocode_amt'];
				} else {
					$total_of_order = $sum_of_orders;
				}
					
				$html.='<tr>
					<td>'.$order_data['order_id'].'</td>
					<td>'.$order_data['first_name'].' '.$order_data['last_name'].'</td>
					<td>'.format_date($order_data['date']).' '.format_time($order_data['date']).'</td>
					<td>'.($order_data['approved_date']!='0000-00-00 00:00:00'?format_date($order_data['approved_date']):'').'</td>
					<td>'.amount_fomat($total_of_order).'</td>
					<td>'.ucfirst($order_data['payment_method']).'</td>
					<td>'.ucwords(str_replace('_',' ',$order_data['status'])).'</td>
				</tr>';
			}
		}
		
		$html.='</tbody>
	</table>';
} elseif($post['order_mode'] == "unpaid") {
	$html.='<h2>'.$heading_title.'</h2>
	<table cell-padding="0" cell-spacing="0" border="1" width="100%" style="padding:5px;">
		<thead>
		  <tr>
			<th><strong>Order ID</strong></th>
			<th><strong>Customer</strong></th>
			<th><strong>Date</strong></th>
			<th><strong>Approved Date</strong></th>
			<th><strong>Price</strong></th>
			<th><strong>Payment Method</strong></th>
			<th><strong>Status</strong></th>
		  </tr>
		</thead>
		<tbody>';
	
		$num_rows = mysqli_num_rows($order_query);
		if($num_rows>0) {
			while($order_data=mysqli_fetch_assoc($order_query)) {
				$promocode_amt = 0;				
				$total_of_order = 0;
				
				//Get order price based on orderID, path of this function (get_order_price) admin/include/functions.php
				$sum_of_orders=get_order_price($order_data['order_id']);
				
				if($order_data['promocode_id']>0 && $order_data['promocode_amt']>0) {
					$promocode_amt = $order_data['promocode_amt'];
					$total_of_order = $sum_of_orders+$order_data['promocode_amt'];
				} else {
					$total_of_order = $sum_of_orders;
				}
					
				$html.='<tr>
					<td>'.$order_data['order_id'].'</td>
					<td>'.$order_data['first_name'].' '.$order_data['last_name'].'</td>
					<td>'.format_date($order_data['date']).' '.format_time($order_data['date']).'</td>
					<td>'.($order_data['approved_date']!='0000-00-00 00:00:00'?format_date($order_data['approved_date']):'').'</td>
					<td>'.amount_fomat($total_of_order).'</td>
					<td>'.ucfirst($order_data['payment_method']).'</td>
					<td>'.ucwords(str_replace('_',' ',$order_data['status'])).'</td>
				</tr>';
			}
		}
		
		$html.='</tbody>
	</table>';
} elseif($post['order_mode'] == "paid") {
	$html.='<h2>'.$heading_title.'</h2>
	<table cell-padding="0" cell-spacing="0" border="1" width="100%" style="padding:5px;">
		<thead>
		  <tr>
		  	<th><strong>Batch ID</strong></th>
			<th><strong>Order ID</strong></th>
			<th><strong>Customer</strong></th>
			<th><strong>Paid Date</strong></th>
			<th><strong>Price</strong></th>
			<th><strong>Payment Method</strong></th>
			<th><strong>Status</strong></th>
		  </tr>
		</thead>
		<tbody>';
	
		$num_rows = mysqli_num_rows($order_query);
		if($num_rows>0) {
			while($order_data=mysqli_fetch_assoc($order_query)) {
				$promocode_amt = 0;				
				$total_of_order = 0;
				
				//Get order price based on orderID, path of this function (get_order_price) admin/include/functions.php
				$sum_of_orders=get_order_price($order_data['order_id']);
				
				if($order_data['promocode_id']>0 && $order_data['promocode_amt']>0) {
					$promocode_amt = $order_data['promocode_amt'];
					$total_of_order = $sum_of_orders+$order_data['promocode_amt'];
				} else {
					$total_of_order = $sum_of_orders;
				}
					
				$html.='<tr>
					<td>'.$order_data['payment_paid_batch_id'].'</td>
					<td>'.$order_data['order_id'].'</td>
					<td>'.$order_data['first_name'].' '.$order_data['last_name'].'</td>
					<td>'.format_date($order_data['payment_sent_date']).' '.format_time($order_data['payment_sent_date']).'</td>
					<td>'.amount_fomat($total_of_order).'</td>
					<td>'.ucfirst($order_data['payment_method']).'</td>
					<td>'.ucwords(str_replace('_',' ',$order_data['status'])).'</td>
				</tr>';
			}
		}
		
		$html.='</tbody>
	</table>';
} elseif($post['order_mode'] == "archive") {
	$html.='<h2>'.$heading_title.'</h2>
	<table cell-padding="0" cell-spacing="0" border="1" width="100%" style="padding:5px;">
		<thead>
		  <tr>
		  	<th><strong>Batch ID</strong></th>
			<th><strong>Order ID</strong></th>
			<th><strong>Customer</strong></th>
			<th><strong>Paid Date</strong></th>
			<th><strong>Price</strong></th>
			<th><strong>Payment Method</strong></th>
			<th><strong>Payment Status</strong></th>
			<th><strong>Status</strong></th>
		  </tr>
		</thead>
		<tbody>';
	
		$num_rows = mysqli_num_rows($order_query);
		if($num_rows>0) {
			while($order_data=mysqli_fetch_assoc($order_query)) {
				$promocode_amt = 0;				
				$total_of_order = 0;
				
				//Get order price based on orderID, path of this function (get_order_price) admin/include/functions.php
				$sum_of_orders=get_order_price($order_data['order_id']);
				
				if($order_data['promocode_id']>0 && $order_data['promocode_amt']>0) {
					$promocode_amt = $order_data['promocode_amt'];
					$total_of_order = $sum_of_orders+$order_data['promocode_amt'];
				} else {
					$total_of_order = $sum_of_orders;
				}
				
				if($order_data['is_payment_sent'] == '1') {
					$payment_status = 'Paid';
				} else {
					$payment_status = 'Unpaid';
				}
					
				$html.='<tr>
					<td>'.$order_data['payment_paid_batch_id'].'</td>
					<td>'.$order_data['order_id'].'</td>
					<td>'.$order_data['first_name'].' '.$order_data['last_name'].'</td>
					<td>'.format_date($order_data['payment_sent_date']).' '.format_time($order_data['payment_sent_date']).'</td>
					<td>'.amount_fomat($total_of_order).'</td>
					<td>'.ucfirst($order_data['payment_method']).'</td>
					<td>'.$payment_status.'</td>
					<td>'.ucwords(str_replace('_',' ',$order_data['status'])).'</td>
				</tr>';
			}
		}
		
		$html.='</tbody>
	</table>';
}

//echo $html;
//exit;

require_once(CP_ROOT_PATH.'/libraries/tcpdf/config/tcpdf_config.php');
require_once(CP_ROOT_PATH.'/libraries/tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF();

// set document information
$pdf->SetCreator($general_setting_data['from_name']);
$pdf->SetAuthor($general_setting_data['from_name']);
$pdf->SetTitle($general_setting_data['from_name']);

$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);

// add a page
$pdf->AddPage();

$pdf->writeHtml($html);

ob_end_clean();

$pdf->Output('pdf/order-'.date('Y-m-d-H-i-s').'.pdf', 'D');
//$pdf->Output('pdf/order-'.date('Y-m-d-H-i-s').'.pdf', 'I');
}
elseif(isset($post['export_csv'])) {
	//echo 'Working Proccess Here...';
	
	$num_rows = mysqli_num_rows($order_query);
	if($num_rows>0) {
		
		$filename = 'order-'.date("Y-m-d-H-i-s").".csv";
		$fp = fopen('php://output', 'w');	
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename='.$filename);
		
		$header = array('Order ID', 'Customer','Date','Approved Date','Price','Payment Method','Status','Paypal Address','BSB','Account Number','Account Holder Name','BitCoin Number');
		fputcsv($fp, $header);
		
		//echo '<pre>';
		
		while($order_data=mysqli_fetch_assoc($order_query)) {
			$promocode_amt = 0;				
			$total_of_order = 0;
			//print_r($order_data);

			//Get order price based on orderID, path of this function (get_order_price) admin/include/functions.php
			$sum_of_orders=get_order_price($order_data['order_id']);
			
			if($order_data['promocode_id']>0 && $order_data['promocode_amt']>0) {
				$promocode_amt = $order_data['promocode_amt'];
				$total_of_order = $sum_of_orders+$order_data['promocode_amt'];
			} else {
				$total_of_order = $sum_of_orders;
			}
			
			$data_to_csv = array();
			$data_to_csv[] = $order_data['order_id'];
			$data_to_csv[] = $order_data['first_name'].' '.$order_data['last_name'];
			$data_to_csv[] = format_date($order_data['date']).' '.format_time($order_data['date']);
			$data_to_csv[] = ($order_data['approved_date']!='0000-00-00 00:00:00'?format_date($order_data['approved_date']):' ');
			$data_to_csv[] = amount_fomat($total_of_order);
			$data_to_csv[] = ucfirst($order_data['payment_method']);
			$data_to_csv[] = ucwords(str_replace('_',' ',$order_data['status']));
			$data_to_csv[] = $order_data['paypal_address'];
			$data_to_csv[] = $order_data['act_short_code'];
			$data_to_csv[] = $order_data['act_number'];
			$data_to_csv[] = $order_data['act_name'];
			$data_to_csv[] = $order_data['bitcoin_number'];
			fputcsv($fp, $data_to_csv);
		}
	}
}
elseif(isset($post['export_ref_id_csv'])) {
	$num_rows = mysqli_num_rows($order_query);
	if($num_rows>0) {
		$filename = 'order-'.date("Y-m-d-H-i-s").".csv";
		$fp = fopen('php://output', 'w');	
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename='.$filename);

		$header = array('Batch ID', 'Order ID', 'Payment Ref. ID');
		fputcsv($fp, $header);
		
		while($order_data=mysqli_fetch_assoc($order_query)) {
			$data_to_csv = array();
			$data_to_csv[] = $order_data['payment_paid_batch_id'];
			$data_to_csv[] = $order_data['order_id'];
			$data_to_csv[] = "";
			fputcsv($fp, $data_to_csv);
		}
	}
}
?>
