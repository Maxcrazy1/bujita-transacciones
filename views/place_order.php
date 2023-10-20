<?php
//Header section
include("include/header.php");

//Get order id
$order_id = $_SESSION['tmp_order_id'];

//If direct access then it will redirect to home page
if($user_id<=0 || $order_id=="") {
	setRedirect(SITE_URL);
	exit();
}

$order_data = get_order_data($order_id);

//$posting_instructions_link = SITE_URL.get_inbuild_page_url('posting-instructions');
//$packaging_instructions_link = SITE_URL.get_inbuild_page_url('packaging-instructions');
$posting_instructions_page_data = get_single_page_data_by_slug('posting-instructions');
$posting_instructions_page_title = $posting_instructions_page_data['title'];
$posting_instructions_page_content = $posting_instructions_page_data['content'];
$packaging_instructions_page_data = get_single_page_data_by_slug('packaging-instructions');
$packaging_instructions_page_title = $packaging_instructions_page_data['title'];
$packaging_instructions_page_content = $packaging_instructions_page_data['content'];
?>

<section>
  <div class="container">
    <div class="row">
      <div class="col-md-12">&nbsp;
        <?php
		//Order steps
        //$order_steps = 5;
        //include("include/steps.php"); ?>
      </div>
    </div>
	
    <form method="post">
      <div class="block head text-center clearfix">
        <div class="h1"><strong>Sales Pack Options</strong></div>
        <div class="h3">Your Sell Order (<code><?=$order_id?></code>) is almost complete.</div>
        <h4 class="pb-3">Please select your preferred Sales Pack option:</h4>
      <div>

      <div class="row">
        <?php 
		if($choosed_sales_pack_array['free']=="free") {
		
		if($order_data['shipment_id']=="") {
		//if(1) {
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
					
					$parcel_param_array = array(
					  "length" => $shipping_parcel_length,
					  "width" => $shipping_parcel_width,
					  "height" => $shipping_parcel_height,
					  "weight" => $shipping_parcel_weight
					);
					
					if($shipping_predefined_package!="") {
						$parcel_param_array['predefined_package'] = $shipping_predefined_package;
					}
					
					$parcel_info = \EasyPost\Parcel::create($parcel_param_array);
			
					if($to_address->verifications->delivery->success == '1' && $from_address->verifications->delivery->success == '1') {
						$shipment = \EasyPost\Shipment::create(array(
						  "to_address" => $to_address,
						  "from_address" => $from_address,
						  "parcel" => $parcel_info,
						  "carrier_accounts" => array($carrier_account_id),
						  "options" => array(
						  	  "label_size" => '4x6',
							  //"label_size" => '8.5x11',
							  //"print_custom_1" => "Instructions, Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.",
							  //"print_custom_2" => "test 2",
							  //"print_custom_3" => "test 3",
						  )
						));
						
						/*echo '<pre>';
						print_r($shipment);
						echo '</pre>';*/
						
						//$shipment->buy(array('rate' => array('id' => $shipment->rates[2]->id)));
						$shipment->buy(array(
						  'rate' => $shipment->lowest_rate(),
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
						$shipment_label_url = $shipment->postage_label->label_url;
					}
				} catch(\EasyPost\Error $e) {
					$shipment_error = "Error: ".$e->getHttpStatus().":".$e->getMessage();
					error_log("Error: ".$e->getHttpStatus().":".$e->getMessage());
				}
			} //END post shipment by easypost API
		
			//If click on "Request free sales pack" form place_order page then it will save by default order status as "submitted"
			$req_ordr_params = array('order_id' => $order_id,
					'status' => 'awaiting_delivery',
					//'sales_pack' => 'free',
					'shipping_api' => $shipping_api,
					'shipment_id' => $shipment_id,
					'shipment_tracking_code' => $shipment_tracking_code,
					'shipment_label_url' => $shipment_label_url,
				);
			$resp_save_default_status = save_default_status_when_place_order($req_ordr_params);
		} else {
			$shipment_id = $order_data['shipment_id'];
			$shipment_tracking_code = $order_data['shipment_tracking_code'];
			$shipment_label_url = $order_data['shipment_label_url'];
		} ?>

        <div class="col-md-6">
          <div class="block content-block stock-optionbox clearfix">
            <div class="option-count clarfix"><span><strong>1</strong></span></div>
            <div class="clearfix">
              <div class="h3"><strong>Request Free Sales Pack</strong></div>
              <span class="tpl_color">
                <i class="fa fa-envelope-open stock-optionbox-icon" aria-hidden="true"></i>
              </span>
              <p>We like things to happen fast at Fone Sell. Select this option and we'll post you a free Sales Pack via 1st class post within 24hrs.</p>
              <ul class="list">
                <li><a class="tpl_color" href="#" data-toggle="modal" data-target="#viewSales">View Sales Pack <i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
                <li><a class="tpl_color" href="#" data-toggle="modal" data-target="#viewPosting">View Posting Options <i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
                <li><a class="tpl_color" href="#" data-toggle="modal" data-target="#viewPacking">View Packing Instructions <i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
				<?php /*?><li><a class="tpl_color" href="<?=$posting_instructions_link?>" target="_blank">View Posting Options <i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
                <li><a class="tpl_color" href="<?=$packaging_instructions_link?>" target="_blank">View Packing Instructions <i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li><?php */?>
              </ul>
              <!-- <div class="h3">How does it work?</div>
              <p>Once you have received the pack, simply package your phone(s) into a box and place into our freepost bag with the delivery note. Then post at your nearest post office. Once received, we will process your order and make payment on the same day!*</p> -->
              <div class="text-center"><a href="<?=SITE_URL?>request_sales_pack/<?=$order_id?>" class="btn btn-primary">Request Free Sales Pack</a></div>
			  
				<?php
				//$shipment_label_url = "https://easypost-files.s3-us-west-2.amazonaws.com/files/postage_label/20181003/8798d90cb95d4d7c8abc9d4d55ee256c.png";
				$shipment_basename_label_url = basename($shipment_label_url);
				$label_copy_to_our_srvr = @copy($shipment_label_url,'shipment_labels/'.$shipment_basename_label_url);
	
				if($shipment_label_url && $label_copy_to_our_srvr == '1') {
					$saved_shipment_label_url = SITE_URL.'shipment_labels/'.$shipment_basename_label_url;
					//echo '<a class="btn btn-general" href="'.$shipment_label_url.'" onclick="window.open(this.href,\'win2\',\'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=800,height=800,directories=no,location=no\'); return false;">Print Shipment Label</a>';
					
					//echo '<img src="'.$shipment_label_url.'" style="display:none;" class="print" />';
					//echo '<a class="btn btn-general" href="javascript:void(0)" onclick="printLabel();">Print Shipment Label</a>';
					echo '<a class="btn btn-primary" target="_blank" href="'.SITE_URL.'views/print/print_label.php?order_id='.$order_id.'">Print Shipment Label</a>';

					echo '<a class="btn btn-primary" href="'.SITE_URL.'controllers/download.php?download_link='.$shipment_label_url.'">Download Shipment Label</a>';
					
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
							'{$city}',
							'{$order_id}');
			
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
							$user_data['city'],
							$order_id);
			
						//START email send to customer
						if(!empty($shipment_label_email_to_customer)) {
							$email_subject = str_replace($patterns,$replacements,$shipment_label_email_to_customer['subject']);
							$email_body_text = str_replace($patterns,$replacements,$shipment_label_email_to_customer['content']);

							$attachment_data['basename'] = array($shipment_basename_label_url);
							$attachment_data['folder'] = array('shipment_labels');
							send_email($user_data['email'], $email_subject, $email_body_text, FROM_NAME, FROM_EMAIL, $attachment_data);
						} //END email send to customer
					}
				} else {
					echo $shipment_error;
				} ?>
            </div>

			<?php /*?><script type="text/javascript">
				function printLabel() {
					var img = $('.print').attr('src');
					var label = window.open();
					var instructions = '<br /><br /><hr style="border: 1px dashed black;" /><b>Shipping us your device is very simple using the following procedure:</b><br /><ul><li>Place your Apple product and all the included contents in a box or thick envelope using proper care (Bubble wrap etc).</li><li>Please print this email and enclose it in the package.</li><li>You will receive a shipping label from UPS (via email), please print and attach to your box or envelope.</li><li> Drop it off at any UPS shipping center or schedule a same day pickup</li></ul><p>Thanks for using Wer.Org Buyback Services <br />Phone: 904.310.0080</p>' ;
					var content = '<div style="text-align: center;width:100%;">'
								 +'<img src="'+ $('.print').attr('src') +'" style="max-width: 300px; border: 2px solid #000;margin:0 auto;" />'
								 +'</div><div>'+instructions+' </div>';
					label.document.write(content);
					label.focus(); // Required for IE
					label.print();
					label.close();
					$('.print').attr('src', img);
					$('.print').css({'max-width': '300px', 'border': '2px solid #000'});
				}
			</script><?php */?>

            <div class="modal fade HelpPopup" id="viewSales" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Your Fone Sell Sales Pack</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="popUpInner">
                      <!-- <h3>Your Fone Sell Sales Pack</h3> -->
                      <div class="viewSales">
                        <p>Once you have completed your online sales order, we will post you a Sales Pack within 24hrs.</p>
                        <h5><strong>The Sales Pack includes:</strong></h5>
                        <ul class="list">
                          <li>Sale Confirmation</li>
                          <li>Delivery Note</li>
                          <li>Freepost Bag</li>
                          <li>Posting Instructions</li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal fade HelpPopup" id="viewPosting" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog modal-lg" role="document">
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title"><?=$posting_instructions_page_title?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="popUpInner">
                      <?=$posting_instructions_page_content?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
			<div class="modal fade HelpPopup" id="viewPacking" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog modal-lg" role="document">
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title"><?=$packaging_instructions_page_title?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="popUpInner">
                      <?=$packaging_instructions_page_content?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
			
          </div>
        </div>
        <?php
  		}
		
  		if($choosed_sales_pack_array['own']=="own") { ?>
        <div class="col-md-6">
          <div class="block content-block stock-optionbox clearfix">
            <div class="option-count clarfix"><span><strong>2</strong></span></div>
            <div>
              <div class="h3"><strong>Print Your Own Sales Pack</strong></div>
              <span class="tpl_color">
                <i class="fa fa-print stock-optionbox-icon" aria-hidden="true"></i>
              </span>
              <p>If you have a printer connected to your PC and want things to happen even faster, you can opt to print your own Sales Pack and post your phone(s) immediately.</p>
              <ul class="list">
                <li><a href="#" class="tpl_color" data-toggle="modal" data-target="#viewSales2">View Sample Sales Pack <i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
                <li><a href="#" class="tpl_color" data-toggle="modal" data-target="#viewPosting2">View Posting Options <i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
                <li><a href="#" class="tpl_color" data-toggle="modal" data-target="#viewPacking2">View Packing Instructions <i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
				<?php /*?><li><a class="tpl_color" href="<?=$posting_instructions_link?>" target="_blank">View Posting Options <i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
                <li><a class="tpl_color" href="<?=$packaging_instructions_link?>" target="_blank">View Packing Instructions <i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li><?php */?>
              </ul>
              <!-- <div class="h3">How does it work?</div>
              <p>You will be able to print your own pack as soon as you have selected this option. We'll also email you a link in case you would like to print the pack later. Once printed, simply package your phone(s) into a box and place into a padded envelope or postal bag with the delivery note. Then affix label to parcel and post at your nearest post office. Once received, we will process your order and make payment on the same day!*</p> -->
              <div class="text-center"><a href="<?=SITE_URL?>print_sales_pack/<?=$order_id?>" class="btn btn-primary">Print Your Own Sales Pack</a></div>
            </div>
			
            <div class="modal fade HelpPopup" id="viewSales2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Print Your Own Sales Pack (Sample Only)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="popUpInner">
                      <!-- <h3>Print Your Own Sales Pack (Sample Only)</h3> -->
                      <div class="viewSales2">
                        <p>Once you have completed your online sale order, you will be able to print the Sales Pack.</p>
                        <h5><strong>The items you will need to print are:</strong></h5>
                        <ul class="list">
                          <li>Delivery Note</li>
                          <li>Freepost Label</li>
                          <li>Posting Instructions</li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal fade HelpPopup" id="viewPosting2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog modal-lg" role="document">
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title"><?=$posting_instructions_page_title?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="popUpInner">
                      <?=$posting_instructions_page_content?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
			<div class="modal fade HelpPopup" id="viewPacking2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog modal-lg" role="document">
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title"><?=$packaging_instructions_page_title?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="popUpInner">
                      <?=$packaging_instructions_page_content?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
          </div>
        </div>
        <?php
  		} ?>
      </div>
  </form>
</div>
</section>
