<?php
//Url param
$order_id=$url_second_param;

//Header section
include("include/header.php");

//If direct access then it will redirect to home page
if($user_id<=0) {
	setRedirect(SITE_URL);
	exit();
}

//Get order data from admin/include/functions.php, function get_order_data
$order_data = get_order_data($order_id);

if($order_data['sales_pack']) { ?>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
			<div class="block content-block clearfix">
					<h2><strong>Sell Order #<?=$order_id?></strong></h2>
					<h3>Thank you. Your order is already in the system.</h3>
					<p>Please contact a member of our friendly team to discuss your order on <strong><?=$general_setting_data['company_phone']?></strong>.</p>
				</div>
			</div>
		</div>
	</div>
<?php
} else {
//if(1) {
	//If click on "Print your own sales pack" form place_order page then it will save by default order status as "awaiting_delivery" with approved & expire(+14 day) date
	$req_ordr_params = array('order_id' => $order_id,
			'status' => 'awaiting_delivery',
			'approved_date' => date("Y-m-d H:i:s"),
			'expire_date' => date("Y-m-d H:i:s",strtotime("+14 day")),
			'sales_pack' => 'print',
		);
	$resp_save_default_status = save_default_status_when_place_order($req_ordr_params);
	if($resp_save_default_status=='1') { ?>
		<script>
		function open_window(url) {
			apply = window.open(url,"Loading",'toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=550,height=450');
		}
		</script>

		<form method="post">
			<div class="container">
				  <div class="row">
						<div class="col-md-12">
							<div class="block content-block pb-0 mb-0 clearfix">
								<h2>Your Sale is Complete!</h2>
								<h3>Your Sale Order Number is: <strong><?=$order_id?></strong></h3>
							</div>
						</div>
				  </div>
				  <div class="row">
						<div class="col-md-9">
							<div class="block content-block mt-0 pb-0 mb-0 clearfix">
								<h4>Thank you for selling your Phone to us!</h4>
								
							</div>
						</div>
						<div class="col-md-3">
							<div class="block content-block mt-0 pb-0 mb-0 text-center clearfix">
							<a class="btn btn-general btn-block" href="<?=SITE_URL?>account"><i class="fa fa-user-circle" aria-hidden="true"></i> Visit My Account</a>
							<?php /*?><a class="btn btn-general btn-block" href="<?=SITE_URL?>views/print/printorder.php?order_id=<?=$order_id?>"><i class="fa fa-print" aria-hidden="true"></i> Print This Order</a><?php */?>
							</div>
						</div>
				  </div>
				  <div class="row">
						<div class="col-md-12">
							<div class="block content-block mt-0 clearfix">
							<h4><strong>What Happens Now?</strong></h4>
							<div class="happens-now">
								<div class="happen1">
									<p>Please click and print each of the following sheets:</p>
									<div class="block button-roll-happen cleafix">
										<a class="btn btn-general btn-sales" href="<?=SITE_URL?>views/print/print_delivery_note.php?order_id=<?=$order_id?>"><i class="fa fa-newspaper-o" aria-hidden="true"></i>Delivery note</a><a class="btn btn-general btn-sales" href="javascript:open_window('<?=SITE_URL?>views/print/print_post_label.php?order_id=<?=$order_id?>')"><i class="fa fa-address-card-o" aria-hidden="true"></i>Address Label</a><a class="btn btn-general btn-sales" href="<?=SITE_URL?>views/print/sales_confirmation.php?order_id=<?=$order_id?>" target="_blank"><i class="fa fa-newspaper-o" aria-hidden="true"></i>sales Confirmation</a>
										</p>
										<p>Print off our address label or write it down and send it to us. NB: Postage Required</p>
										<p>You can print these later if you wish by following the print instructions in the order confirmation email we have sent you.</p>
									</div>
									<div class="happen2">
										<p>Package item(s) and post at your nearest post office within 14 days. You'll be given a post office receipt which enables you to track your parcel on royalmail.com.</p>
										<p>BuyMyGadgets will honour the quoted price of the products for 14 days from time of order. After that period prices may be subject to change, whereby you will be notified by email.</p>
									</div>
									<div class="happen3">
										<p>Once received, we'll process your sale and make payment on the same day of receipt. You smile - we smile :)</p>
										<strong>IMPORTANT</strong>
										<p>The reference for this trade is: <?=$order_id?>. Please use this reference in all communications with us regarding this trade.</p>
									</div>
								</div>
							</div>
						</div>
				  </div>
				</div>
			
				<!-- <div class="container">
					<div class="borderbox">
						<div class="row">
							<div class="col-sm-9 col-xs-12">
								<div class="borderbox lightpink">
			
								</div>
							</div>
						</div>
					</div>
				</div> -->

			</div>
		</form>
<?php }
} ?>
