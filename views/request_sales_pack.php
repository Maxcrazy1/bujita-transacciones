<?php
//Url param
$order_id = $url_second_param;

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
				<div class="block clearfix">
					<h2><strong>Sell Order #<?=$order_id?></strong></h2>
					<h3>Thank you. Your order is already in the system.</h3>
					<p>Please contact a member of our friendly team to discuss your order on <strong><?=$general_setting_data['company_phone']?></strong>.</p>
				</div>
			</div>
		</div>
	</div>
<?php
} else {
	if($order_data['shipment_id']=="") {
		//START post shipment by easypost API
		if($shipping_api == "easypost" && $shipment_generated_by_cust == '1' && $shipping_api_key != "") {
			try {
				require_once("libraries/easypost-php-master/lib/easypost.php");
				\EasyPost\EasyPost::setApiKey($shipping_api_key);
		
				//create To address
				$to_address_params = array(
					"verify"  =>  array("delivery"),
					//'name' => $company_name,
					'company' => $company_name,
					'street1' => $company_address,
					'city' => $company_city,
					'state' => $company_state,
					'zip' => $company_zipcode,
					'country' => $company_country,
					'phone' => $company_phone,
					'email' => $site_email
				);
		
				//create From address
				$from_address_params = array(
					"verify"  =>  array("delivery"),
					'name' => $user_data['name'],
					'street1' => $user_data['address'],
					//'street2' => $user_data['address2'],
					'city' => $user_data['city'],
					'state' => $user_data['state'],
					'zip' => $user_data['postcode'],
					'country' => $company_country,
					'phone' => substr($user_data['phone'], -10),
					'email' => $user_data['email']
				);
		
				$to_address = \EasyPost\Address::create($to_address_params);
				$from_address = \EasyPost\Address::create($from_address_params);
		
				if($to_address->verifications->delivery->success == '1' && $from_address->verifications->delivery->success == '1') {
					$shipment = \EasyPost\Shipment::create(array(
					  "to_address" => $to_address,
					  "from_address" => $from_address,
					  "parcel" => array(
						"length" => $shipping_parcel_length,
						"width" => $shipping_parcel_width,
						"height" => $shipping_parcel_height,
						"weight" => $shipping_parcel_weight
					  )
					));
		
					/*echo '<pre>';
					print_r($shipment);
					echo '</pre>';
					exit;*/
		
					//$shipment->buy(array('rate' => array('id' => $shipment->rates[2]->id)));
					$shipment->buy(array(
					  'rate' => $shipment->lowest_rate()
					));
		
					$shipment->label(array(
					  'file_format' => 'PDF'
					));
		
					/*echo '<pre>';
					print_r($shipment);
					echo '</pre>';
					exit;*/
		
					$shipment_id = $shipment->id;
					$shipment_tracking_code = $shipment->tracker->tracking_code;
					$shipment_label_url = $shipment->postage_label->label_pdf_url;
				}
			} catch(Exception $e) {
				echo "Status: ".$e->getHttpStatus().":";
				echo $e->getMessage()."\n";
			}
		} //END post shipment by easypost API
	
		//If click on "Request free sales pack" form place_order page then it will save by default order status as "submitted"
		$req_ordr_params = array('order_id' => $order_id,
				'status' => 'submitted',
				'sales_pack' => 'free',
				'shipping_api' => $shipping_api,
				'shipment_id' => $shipment_id,
				'shipment_tracking_code' => $shipment_tracking_code,
				'shipment_label_url' => $shipment_label_url,
		);
	} else {
		//If click on "Request free sales pack" form place_order page then it will save by default order status as "submitted"
		$req_ordr_params = array('order_id' => $order_id,
				'status' => 'submitted',
				'sales_pack' => 'free'
		);

		$shipment_id = $order_data['shipment_id'];
		$shipment_tracking_code = $order_data['shipment_tracking_code'];
		$shipment_label_url = $order_data['shipment_label_url'];
	}

	$resp_save_default_status = save_default_status_when_place_order($req_ordr_params);
	if($resp_save_default_status=='1') { ?>
		<form method="post">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="block content-block clearfix">
						<h2>Your Sale is Complete!</h2>
						<h3>Your Sale Order Number is: <strong><?=$order_id?></strong></h3>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-9">
						<div class="block content-block clearfix">
							<h4>Thank you for selling your old Phone, Tablet to us!</h4>
							<p>You can review this sale or any previous sales in the <a href="<?=SITE_URL?>account">My Account</a> area.</p>
						</div>
					</div>
					<div class="col-md-3">
						<div class="block text-center mtop15 clearfix">
							<a class="btn btn-general btn-block" href="<?=SITE_URL?>account">Visit My Account</a>
							<a class="btn btn-general btn-block" target="_blank" href="<?=SITE_URL?>views/print/sales_confirmation.php?order_id=<?=$order_id?>" >Print This Order</a>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="block content-block clearfix">
						
							<?php
							//$shipment_label_url = "https://easypost-files.s3-us-west-2.amazonaws.com/files/postage_label/20180528/97c980c122d84bf89d5c85bd01ae6d71.pdf";
							$shipment_basename_label_url = basename($shipment_label_url);
							$label_copy_to_our_srvr = @copy($shipment_label_url,'shipment_labels/'.$shipment_basename_label_url);

							if($shipment_label_url && $label_copy_to_our_srvr == '1') {
								echo '<a class="btn btn-general" href="'.SITE_URL.'controllers/download.php?download_link='.$shipment_label_url.'">Download Shipment Label</a>';

								if($order_data['shipment_id']=="") {
									$shipment_label_email_to_customer = get_template_data('shipment_label_email_to_customer');
						
									//Get admin user data
									$admin_user_data = get_admin_user_data();
						
									$patterns = array(
										'{$logo}',
										'{$admin_logo}',
										'{$admin_email}',
										'{$admin_username}',
										'{$admin_site_url}',
										'{$admin_panel_name}',
										'{$from_name}',
										'{$from_email}',
										'{$site_name}',
										'{$site_url}',
										'{$customer_fullname}',
										'{$customer_email}',
										'{$country}',
										'{$state}',
										'{$city}');
						
									$replacements = array(
										$logo,
										$admin_logo,
										$admin_user_data['email'],
										$admin_user_data['username'],
										ADMIN_URL,
										$general_setting_data['admin_panel_name'],
										$general_setting_data['from_name'],
										$general_setting_data['from_email'],
										$general_setting_data['site_name'],
										SITE_URL,
										$user_data['name'],
										$user_data['email'],
										$user_data['country'],
										$user_data['state'],
										$user_data['city']);
						
									//START email send to customer
									if(!empty($shipment_label_email_to_customer)) {
										$email_subject = str_replace($patterns,$replacements,$shipment_label_email_to_customer['subject']);
										$email_body_text = str_replace($patterns,$replacements,$shipment_label_email_to_customer['content']);
										
										$attachment_data['basename'] = $shipment_basename_label_url;
										$attachment_data['folder'] = 'shipment_labels';
										send_email($user_data['email'], $email_subject, $email_body_text, FROM_NAME, FROM_EMAIL, $attachment_data);
									} //END email send to customer
								}
							} ?>

							<h4><strong>What Happens Now?</strong></h4>
						
							<div class="clearfix">
								<img src="<?=SITE_URL?>images/freepost-bag-red.png" alt="" class="pull-right" />
								<p class="topspacing">We'll post you a FREE sales pack within the next 24hrs which includes a Freepost bag, Posting Instructions and a Delivery Note.</p>
							</div>
						
							<div class="clearfix">
								<img src="<?=SITE_URL?>images/freepost-bag-purple.png" alt="" class="pull-right" />
								<p class="topspacing">Pack your item(s) into our freepost bag and post at your nearest post office within 14 days. You'll be given a post office receipt which enables you to track the freepost bag on royalmail.com.</p>
							</div>
						
							<div class="clearfix">
								<img src="<?=SITE_URL?>images/payment.png" alt="" class="pull-right" />
								<p class="topspacing">Once received, we'll process your sale and make payment on the same day of receipt. You smile - we smile :)</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
<?php }
} ?>
