<?php
require_once("../../admin/_config/config.php");
require_once("../../admin/include/functions.php");

$user_id=$_SESSION['user_id'];
$order_id=$_REQUEST['order_id'];

//Get order batch data, path of this function (get_order_data) admin/include/functions.php
$order_detail = get_order_data($order_id);
if($order_detail['shipment_label_custom_name']) {
	$shipment_label_url = SITE_URL.'shipment_labels/'.$order_detail['shipment_label_custom_name'];
} else {
	$shipment_label_url = $order_detail['shipment_label_url'];
}

//If direct access then it will redirect to home page
if($user_id<=0) {
	setRedirect(SITE_URL);
	exit();
}
?>

<!doctype html>
<html>
<head>
	<title></title>

	<link rel="stylesheet" type="text/css" title="stylesheet" href="<?=SITE_URL?>css/style.css">
	<link rel="stylesheet" type="text/css" title="stylesheet" href="<?=SITE_URL?>css/print.css" media="print,screen">
	<script src="<?=SITE_URL?>js/jquery.min.js" type="text/javascript"></script>

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
<body>
	<div style="text-align:right;width:100%;margin-top:25px;padding-right:25px;" class="hide_button">
		<input name="checkout" type="button" value="PRINT" id="checkoutButton" class="btn btn-primary pull-right" onClick="javascript:printit()" />
	</div>
	<div style="text-align:center; width:100%;">
		<?php /*?><div class="spinner" style="text-align: center; margin-bottom: 15px;"></div><?php */?>
		<img id="shipment_image" src="<?=$shipment_label_url?>" style="max-width:500px; margin:0 auto;" />
	</div>
	<div style="width:100%;padding:10px;">
		<br /><br /><hr style="border:1px dashed black;" /><b>Shipping us your device is very simple using the following procedure:</b><br /><ul><li>Place your Apple product and all the included contents in a box or thick envelope using proper care (Bubble wrap etc).</li><li>Please print this email and enclose it in the package.</li><li>You will receive a shipping label from UPS (via email), please print and attach to your box or envelope.</li><li> Drop it off at any UPS shipping center or schedule a same day pickup</li></ul><p>Thanks for using <?=$company_name?> Services <br />Phone: <?=$company_phone?></p>
	</div>
</body>
</html>

<script type="text/javascript">
//window.onbeforeunload = function() {
	//jQuery(".spinner").html('<img src="<?=SITE_URL?>images/spining_icon.gif" width="50">');
	//jQuery('.spinner').show();
//} 
/*jQuery(window).load(function($) {
	$(".spinner").html('');
	$('.spinner').hide();
});*/

/*setInterval(function() {

}, 3000);*/

function printit(){
	jQuery('.hide_button').hide();
	if(window.print) {
		window.print();
	}

	if(window.close) {
		jQuery('.hide_button').show();
	}

	/*window.addEventListener("afterprint", myFunction);
	function myFunction() {
		location.reload(true);
	}*/
}

window.addEventListener("afterprint", myFunction);
function myFunction() {
	window.close();
	//location.reload(true);
}

//printit();
</script>
