<?php
//Url params
$req_model_id=$url_third_param;
$req_storage=$url_four_param;

//Fetching data from model
require_once('models/mobile.php');

//Get data from models/mobile.php, get_single_model_data function
$model_data = get_single_model_data($req_model_id);

$meta_title = $model_data['meta_title'];
$meta_desc = $model_data['meta_desc'];
$meta_keywords = $model_data['meta_keywords'];

$model_price = $model_data['price'];
$f_model_price = $model_price;
$unlock_price = $model_data['unlock_price'];

$storage_list = get_models_storage_data($req_model_id);
$condition_list = get_models_condition_data($req_model_id);
$network_list = get_models_networks_data($req_model_id);
$connectivity_list = get_models_connectivity_data($req_model_id);
$watchtype_list = get_models_watchtype_data($req_model_id);
$case_material_list = get_models_case_material_data($req_model_id);
$case_size_list = get_models_case_size_data($req_model_id);
$color_list = get_models_color_data($req_model_id);
$accessories_list = get_models_accessories_data($req_model_id);

$dependencies_list = get_models_dependencies($req_model_id);

//$miscellaneous_list = get_models_miscellaneous_data($req_model_id);
$screen_size_list = get_models_screen_size_data($req_model_id);
$screen_resolution_list = get_models_screen_resolution_data($req_model_id);
$lyear_list = get_models_lyear_data($req_model_id);
$processor_list = get_models_processor_data($req_model_id);
$ram_list = get_models_ram_data($req_model_id);

$fields_cat_type = $model_data['fields_cat_type'];
$category_data = get_category_data($model_data['cat_id']);

$storage_title = $category_data['storage_title'];
$condition_title = $category_data['condition_title'];
$network_title = $category_data['network_title'];
$connectivity_title = $category_data['connectivity_title'];
$case_size_title = $category_data['case_size_title'];
$type_title = $category_data['type_title'];
$case_material_title = $category_data['case_material_title'];
$color_title = $category_data['color_title'];
$accessories_title = $category_data['accessories_title'];
$screen_size_title = $category_data['screen_size_title'];
$screen_resolution_title = $category_data['screen_resolution_title'];
$lyear_title = $category_data['lyear_title'];
$processor_title = $category_data['processor_title'];
$ram_title = $category_data['ram_title'];

//Header section
include("include/header.php");

$edit_item_id = $_REQUEST['item_id'];
$order_item_data = array();
if($edit_item_id>0) {
	$order_item_data = get_order_item($edit_item_id,'');
	$order_item_data = $order_item_data['data'];
}

/*echo '<pre>';
print_r($storage_list);
exit;*/
?>

  <section id="breadcrumbs">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="block breadcrumbs mb-0 mt-0 clearfix">
            <ul>
              <li><a href="<?=SITE_URL.'device-type-or-brand'?>"><?php echo $LANG['Home']; ?></a></li>
              <li class="divider">/</li>
              <li><a href="<?=SITE_URL.$model_data['sef_url']?>"><?=$model_data['device_title']?></a></li>
              <li class="divider">/</li>
              <li><?=$model_data['title']?></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

<form action="<?=SITE_URL?>controllers/mobile.php" method="post" onSubmit="return check_form(this);">
  <section id="content">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="block content phone-content">
            <div class="row">
              <div class="col-md-4">
                <div class="block phone-block m-0 p-0 text-center">
                  <h3 class="h4"><?php echo $LANG['TELL US MORE ABOUT YOUR']; ?></h3>
                  <h3 class="h3"><?=$model_data['title']?></h3>
				  <?php
				  if($model_data['model_img']) {
					$md_img_path = SITE_URL.'libraries/phpthumb.php?imglocation='.SITE_URL.'images/mobile/'.$model_data['model_img'].'&h=509';
                    echo '<img src="'.$md_img_path.'" alt="'.$model_data['title'].'">';
            	  } ?>
                </div>
              </div>
			  <?php
			  if($fields_cat_type == "mobile") {
			  	require_once("mobile_detail/mobile.php");
			  } elseif($fields_cat_type == "tablet") {
			  	require_once("mobile_detail/tablet.php");
			  } elseif($fields_cat_type == "watch") {
			  	require_once("mobile_detail/watch.php");
			  } elseif($fields_cat_type == "laptop") {
			  	require_once("mobile_detail/laptop.php");
			  } ?>
			  
				<div class="modal fade" id="IsMyDeviceBlackListed" tabindex="-1" role="dialog" aria-labelledby="IsMyDeviceBlackListedTitle" aria-hidden="true">
					<div class="modal-dialog modal-lg" role="document">
					  <div class="modal-content">
						<div class="modal-header">
						  <h5 class="modal-title" id="IsMyDeviceBlackListedTitle"><strong><?php echo $LANG['IS MY DEVICE BLACKLISTED?']; ?></strong></h5>
						  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						  </button>
						</div>
						<div class="modal-body">
						  <?php echo $LANG['You can find out if your device has been blacklisted by checking the IMEI here for free']; ?>
						  <a href="https://swappa.com/esn" target="_blank">https://swappa.com/esn</a>
						</div>
					  </div>
					</div>
				</div>
				
				<div class="modal fade" id="IsMyDevicePaidOff" tabindex="-1" role="dialog" aria-labelledby="IsMyDevicePaidOffTitle" aria-hidden="true">
					<div class="modal-dialog modal-lg" role="document">
					  <div class="modal-content">
						<div class="modal-header">
						  <h5 class="modal-title" id="IsMyDevicePaidOffTitle"><strong><?php echo $LANG['IS MY DEVICE PAID OFF?']; ?></strong></h5>
						  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						  </button>
						</div>
						<div class="modal-body">
						  <?php echo $LANG['The easiest way to find out if your device is under any financial obligation is by contacting the network provider from which the device was bought. You can also find out if you have any outstanding bills that may cause your offer to fall through from them.']; ?>
						</div>
					  </div>
					</div>
				</div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
    <input type="hidden" class="form-control" name="quantity" id="quantity" value="<?=($order_item_data['quantity']>1?$order_item_data['quantity']:1)?>">
	<input type="hidden" name="device_id" id="device_id" value="<?=$model_data['device_id']?>"/>
	<input type="hidden" name="payment_amt" id="payment_amt" value="<?=$total?>"/>
	<input type="hidden" name="req_model_id" id="req_model_id" value="<?=$req_model_id?>"/>
	<input type="hidden" name="fields_cat_type" id="fields_cat_type" value="<?=$fields_cat_type?>"/>
	<?php
	if($edit_item_id>0) {
		echo '<input type="hidden" name="edit_item_id" id="edit_item_id" value="'.$edit_item_id.'"/>';
	} ?>
</form>

<?php
/*if($model_data['description']) { ?>
<section>
	<div class="container">
		<div class="row" style="margin-top:25px;margin-bottom:25px;">
			<div class="col-md-12">
				<div class="block clearfix">
					<div class="block-inner clearfix">
						<?=$model_data['description']?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php
}*/

if($model_data['cat_id']>0) {
	$faqs_groups_data_html = get_faqs_groups_with_html(array(),$model_data['cat_id']);
	if($faqs_groups_data_html['html']!="") { ?>
		<section id="faq" class="white-sec pt-3">
    		<div class="container">
				<?=$faqs_groups_data_html['html']?>
			</div>
		</section>
	<?php	
	}
} ?>
  

<script type="text/javascript">
function check_form() {
	if(document.getElementById("quantity").value<=0) {
		alert('Please enter quantity');
		return false;
	}
	var device_terms = document.getElementById("device_terms").checked;
	if(device_terms == false) {
		jQuery("#device_terms_error_msg").show().text('Please tick the box to agree with the above terms');
		return false;
	}
}
	
<?php
//Trigger by onload page
echo 'network_cal(0);'; ?>
</script>

