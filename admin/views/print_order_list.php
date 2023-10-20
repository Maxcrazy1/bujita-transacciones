<?php
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

echo $html;
?>
