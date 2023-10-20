<div id="print_order_data" style="width:36mm;height:89mm;writing-mode:tb-rl; font-family:Arial, Helvetica, sans-serif;font-size:18px;padding-right:10px;">
<b>Invoice.Order ID:</b> #<?=$order_id?><br />
<b>Model Info:</b> <?=$order_item_data['data']['brand_title'].' - '.$order_item_data['data']['model_title']?>
<?php
if($order_item_data['data']['storage']) {
	echo '<br /><b>Storage Capacity:</b> '.$order_item_data['data']['storage'];
}
if($order_item_data['data']['condition']) {
	echo '<br /><b>Condition:</b> '.$order_item_data['data']['condition'];
}
if($order_item_data['data']['network']) {
	echo '<br /><b>Network:</b> '.$order_item_data['data']['network'];
}
if($order_item_data['data']['connectivity']) {
	echo '<br /><b>Connectivity:</b> '.$order_item_data['data']['connectivity'];
}
if($order_item_data['data']['watchtype']) {
	echo '<br /><b>Type:</b> '.$order_item_data['data']['watchtype'];
}
if($order_item_data['data']['case_material']) {
	echo '<br /><b>Case Material:</b> '.$order_item_data['data']['case_material'];
}
if($order_item_data['data']['case_size']) {
	echo '<br /><b>Case Size:</b> '.$order_item_data['data']['case_size'];
}
if($order_item_data['data']['imei_number']) {
	echo '<br /><b>IMEI:</b> '.$order_item_data['data']['imei_number'];
} ?>
</div>