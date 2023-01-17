<?php
require_once("../_config/config.php");
require_once("../include/functions.php");

//Url params
$req_model_id=$_REQUEST['model_id'];
if($req_model_id>0) {

//Fetching data from model
require_once('../../models/mobile.php');

//Get data from models/mobile.php, get_single_model_data function
$model_data = get_single_model_data($req_model_id);
$meta_title = $model_data['meta_title'];
$meta_desc = $model_data['meta_desc'];
$meta_keywords = $model_data['meta_keywords'];

$model_price = $model_data['price'];

$storage_list = get_models_storage_data($req_model_id);
$condition_list = get_models_condition_data($req_model_id);
$network_list = get_models_networks_data($req_model_id);
$connectivity_list = get_models_connectivity_data($req_model_id);
$watchtype_list = get_models_watchtype_data($req_model_id);
$case_material_list = get_models_case_material_data($req_model_id);
$case_size_list = get_models_case_size_data($req_model_id);
$screen_size_list = get_models_screen_size_data($req_model_id);
$color_list = get_models_color_data($req_model_id);
$accessories_list = get_models_accessories_data($req_model_id);
$screen_resolution_list = get_models_screen_resolution_data($req_model_id);
$lyear_list = get_models_lyear_data($req_model_id);
$processor_list = get_models_processor_data($req_model_id);
$ram_list = get_models_ram_data($req_model_id);

$fields_cat_type = $model_data['fields_cat_type'];
$category_data = get_category_data($model_data['cat_id']);

$edit_item_id = $_REQUEST['item_id'];
$order_item_data = array();
if($edit_item_id>0) {
	$order_item_data = get_order_item($edit_item_id,'');
	$order_item_data = $order_item_data['data'];
	$order_id = $order_item_data['order_id'];
}
if($order_item_data['model_id']!=$req_model_id) {
	$order_item_data = array();
}

require_once("../../include/custom_js.php");

if(!empty($watchtype_list) && ($fields_cat_type == "tablet" || $fields_cat_type == "watch" || $fields_cat_type == "laptop")) { ?>
	<div class="control-group radio-inline">
		<label>Type: </label>
		<div class="controls">
		  <?php
		  foreach($watchtype_list as $gnrn_key=>$watchtype_data) { ?>
			<label class="radio custom-radio">
			  <input class="check_watchtype custom-control-input" type="radio" id="check_watchtype<?=$gnrn_key?>" name="check_watchtype" value="<?=$watchtype_data['id']?>" <?php if($order_item_data['watchtype']!="" && $order_item_data['watchtype']==$watchtype_data['watchtype_name']){echo 'checked="checked"';}elseif($order_item_data['watchtype']=="" && $gnrn_key==0){echo 'checked="checked"';}?> data-enable_network="<?= intval($watchtype_data['disabled_network']) ?>"> <?=$watchtype_data['watchtype_name']?>
			</label>
		  <?php
		  } ?>
		</div>
	</div>
<?php
}

if(!empty($network_list) && ($fields_cat_type == "mobile" || $fields_cat_type == "tablet" || $fields_cat_type == "watch" || $fields_cat_type == "laptop")) { ?>
	<div class="control-group radio-inline network_section_showhide">
		<label>Network: </label>
		<div class="controls">
		  <?php
		  foreach($network_list as $n_key=>$network_data) { ?>
			<label class="radio custom-radio">
				<input name="check_network" class="custom-input check_network" type="radio" id="<?=createSlug($network_data['network_name'])?>" value="<?=$network_data['id']?>" <?php if($order_item_data['network']==$network_data['network_name']){echo 'checked="checked"';}?> data-nw_name="<?= strtolower($network_data['network_name']) ?>"> <?=$network_data['network_name']?>
			</label>
		  <?php
		  } ?>
		</div>
	</div>	

	<div class="control-group radio-inline network_price_mode_section_showhide" style="display:none;">
		<label>Has it been unlocked by carrier?</label>
		<div class="controls">
			<label class="radio custom-radio">
				<input name="network_price_mode" class="custom-input network_price_mode" type="radio" id="network_price_unlock" value="unlock" <?php if($order_item_data['network_price_mode'] == "unlock"){echo 'checked="checked"';}?>> YES
			</label>
			<label class="radio custom-radio">
				<input name="network_price_mode" class="custom-input network_price_mode" type="radio" id="network_price_lock" value="lock" <?php if($order_item_data['network_price_mode'] == "lock"){echo 'checked="checked"';}?>> NO
			</label>
		</div>
	</div>
<?php 
}

if(!empty($storage_list) && ($fields_cat_type == "mobile" || $fields_cat_type == "tablet" || $fields_cat_type == "watch")) {
	$edit_storage_array = array();
	if($order_item_data['storage']!="") {
		$edit_storage_array = explode(",",$order_item_data['storage']);
		foreach($edit_storage_array as $storage_index => $storage_word) {
			$edit_storage_array[$storage_index] = trim($storage_word);
		}
	} ?>
	<div class="control-group radio-inline">
		<label>Capacity: </label>
		<div class="controls">
		<?php
		foreach($storage_list as $s_key => $storage_data) {
			$s_storage_size = $storage_data['storage_size'].$storage_data['storage_size_postfix']; ?>
			<label class="radio custom-radio">
			  <input class="check_capacity custom-control-input" type="radio" id="check_capacity<?=$s_storage_size?>" name="check_capacity" value="<?=$storage_data['id']?>" <?php if($order_item_data['storage']!="" && in_array(trim($storage_data['storage_size'].$storage_data['storage_size_postfix']),$edit_storage_array)){echo 'checked="checked"';}elseif($order_item_data['storage']!="" && $order_item_data['storage']==$s_storage_size){echo 'checked="checked"';}elseif($order_item_data['storage']=="" && $s_key==0){echo 'checked="checked"';}?>> <?=$s_storage_size?>
			</label>
		<?php
		} ?>
	  </div>
	</div>
<?php
}

if(!empty($case_material_list) && $fields_cat_type == "watch") { ?>
	<div class="control-group radio-inline">
		<label>Case Material: </label>
		<div class="controls">
		  <?php
		  foreach($case_material_list as $gnrn_key=>$case_material_data) { ?>
			<label class="radio custom-radio">
			  <input class="check_case_material custom-control-input" type="radio" id="check_case_material<?=$gnrn_key?>" name="check_case_material" value="<?=$case_material_data['id']?>" <?php if($order_item_data['case_material']!="" && $order_item_data['case_material']==$case_material_data['case_material_name']){echo 'checked="checked"';}elseif($order_item_data['case_material']=="" && $gnrn_key==0){echo 'checked="checked"';}?>> <?=$case_material_data['case_material_name']?>
			</label>
		  <?php
		  } ?>
		</div>
	</div>
<?php
}

if(!empty($case_size_list) && $fields_cat_type == "watch") { ?>
	<div class="control-group radio-inline">
		<label>Case Size: </label>
		<div class="controls">
	  <?php
	  foreach($case_size_list as $cs_key=>$case_size_data) { ?>
		<label class="radio custom-radio">
		  <input class="check_case_size custom-control-input" type="radio" id="check_case_size<?=$cs_key?>" name="check_case_size" value="<?=$case_size_data['id']?>" <?php if($order_item_data['case_size']!="" && $order_item_data['case_size']==$case_size_data['case_size']){echo 'checked="checked"';}elseif($order_item_data['case_size']=="" && $cs_key==0){echo 'checked="checked"';}?>> <?=$case_size_data['case_size']?>
		</label>
	  <?php
	  } ?>
	</div>
</div>
<?php
}


  
if(!empty($screen_size_list) && $fields_cat_type == "laptop") { ?>
	<div class="control-group radio-inline">
		<label>Select Screen Size: </label>
		<div class="controls">
		  <?php
		  foreach($screen_size_list as $cnc_key=>$screen_size_data) { ?>
			<label class="radio custom-radio">
			  <input class="check_screen_size custom-control-input" type="radio" id="check_screen_size<?=$cnc_key?>" name="check_screen_size" value="<?=$screen_size_data['id']?>" <?php if($order_item_data['screen_size']!="" && $order_item_data['screen_size']==$screen_size_data['screen_size_name']){echo 'checked="checked"';}elseif($order_item_data['screen_size']=="" && $cnc_key==0){echo 'checked="checked"';}?>> <?=$screen_size_data['screen_size_name']?>
			</label>
		  <?php
		  } ?>
		</div>
	</div>
<?php
}

if(!empty($screen_resolution_list) && $fields_cat_type == "laptop") { ?>
	<div class="control-group radio-inline">
		<label>Select Screen Resolution: </label>
		<div class="controls">
		  <?php
		  foreach($screen_resolution_list as $cnc_key=>$screen_resolution_data) { ?>
			<label class="radio custom-radio">
			  <input class="check_screen_resolution custom-control-input" type="radio" id="check_screen_resolution<?=$cnc_key?>" name="check_screen_resolution" value="<?=$screen_resolution_data['id']?>" <?php if($order_item_data['screen_resolution']!="" && $order_item_data['screen_resolution']==$screen_resolution_data['screen_resolution_name']){echo 'checked="checked"';}elseif($order_item_data['screen_resolution']=="" && $cnc_key==0){echo 'checked="checked"';}?>> <?=$screen_resolution_data['screen_resolution_name']?>
			</label>
		  <?php
		  } ?>
		</div>
	</div>
<?php
}

if(!empty($lyear_list) && $fields_cat_type == "laptop") { ?>
	<div class="control-group radio-inline">
		<label>Select Year: </label>
		<div class="controls">
		  <?php
		  foreach($lyear_list as $cnc_key=>$lyear_data) { ?>
			<label class="radio custom-radio">
			  <input class="check_lyear custom-control-input" type="radio" id="check_lyear<?=$cnc_key?>" name="check_lyear" value="<?=$lyear_data['id']?>" <?php if($order_item_data['lyear']!="" && $order_item_data['lyear']==$lyear_data['lyear_name']){echo 'checked="checked"';}elseif($order_item_data['lyear']=="" && $cnc_key==0){echo 'checked="checked"';}?>> <?=$lyear_data['lyear_name']?>
			</label>
		  <?php
		  } ?>
		</div>
	</div>
<?php
}

if(!empty($processor_list) && $fields_cat_type == "laptop") { ?>
	<div class="control-group radio-inline">
		<label>Select Processor: </label>
		<div class="controls">
		  <?php
		  foreach($processor_list as $cnc_key=>$processor_data) { ?>
			<label class="radio custom-radio">
			  <input class="check_processor custom-control-input" type="radio" id="check_processor<?=$cnc_key?>" name="check_processor" value="<?=$processor_data['id']?>" <?php if($order_item_data['processor']!="" && $order_item_data['processor']==$processor_data['processor_name']){echo 'checked="checked"';}elseif($order_item_data['processor']=="" && $cnc_key==0){echo 'checked="checked"';}?>> <?=$processor_data['processor_name']?>
			</label>
		  <?php
		  } ?>
		</div>
	</div>
<?php
}

if(!empty($storage_list) && $fields_cat_type == "laptop") { ?>
	<div class="control-group radio-inline">
		<label>Select HD capacity: </label>
		<div class="controls">
		<?php
		foreach($storage_list as $s_key => $storage_data) {
			$s_storage_size = $storage_data['storage_size'].$storage_data['storage_size_postfix']; ?>
			<label class="radio custom-radio">
			  <input class="check_capacity custom-control-input" type="radio" id="check_capacity<?=$s_storage_size?>" name="check_capacity" value="<?=$storage_data['id']?>" <?php if($order_item_data['storage']!="" && $order_item_data['storage']==$s_storage_size){echo 'checked="checked"';}elseif($order_item_data['storage']=="" && $s_key==0){echo 'checked="checked"';}?>> <?=$s_storage_size?>
			</label>
		<?php
		} ?>
	  </div>
	</div>
<?php
}

if(!empty($ram_list) && $fields_cat_type == "laptop") { ?>
	<div class="control-group radio-inline">
		<label>Select Ram (Memory): </label>
		<div class="controls">
		<?php
		foreach($ram_list as $s_key => $ram_data) {
			$s_ram_size = $ram_data['ram_size'].$ram_data['ram_size_postfix']; ?>
			<label class="radio custom-radio">
			  <input class="check_ram custom-control-input" type="radio" id="check_ram<?=$s_ram_size?>" name="check_ram" value="<?=$ram_data['id']?>" <?php if($order_item_data['ram']!="" && $order_item_data['ram']==$s_ram_size){echo 'checked="checked"';}elseif($order_item_data['ram']=="" && $s_key==0){echo 'checked="checked"';}?>> <?=$s_ram_size?>
			</label>
		<?php
		} ?>
	  </div>
	</div>
<?php
}

if(!empty($color_list) && ($fields_cat_type == "mobile" || $fields_cat_type == "tablet" || $fields_cat_type == "watch" || $fields_cat_type == "laptop")) { ?>
	<div class="control-group radio-inline">
		<label>Color: </label>
		<div class="controls">
		  <?php
		  foreach($color_list as $cnc_key=>$color_data) { ?>
			<label class="radio custom-radio">
			  <input class="check_color custom-control-input" type="radio" id="check_color<?=$cnc_key?>" name="check_color" value="<?=$color_data['id']?>" <?php if($order_item_data['color']!="" && $order_item_data['color']==$color_data['color_name']){echo 'checked="checked"';}elseif($order_item_data['color']=="" && $cnc_key==0){echo 'checked="checked"';}?>> <?=$color_data['color_name']?>
			</label>
		  <?php
		  } ?>
		</div>
	</div>
<?php
}

if(!empty($condition_list) && ($fields_cat_type == "mobile" || $fields_cat_type == "tablet" || $fields_cat_type == "watch" || $fields_cat_type == "laptop")) { ?>
	<div class="control-group radio-inline">
		<label>Condition: </label>
		<div class="controls">
		  <?php
		  $c=0;
		  foreach($condition_list as $key=>$condition_data) {
			$c=$c+1; ?>
			<label class="radio custom-radio">
			  <input class="check_condition custom-control-input" type="radio" id="check_condition<?=$key?>" data-key="<?=$key?>" data-is_disabled_network="<?=$condition_data['disabled_network']?>" name="check_condition" value="<?=$condition_data['id']?>" <?php if($order_item_data['condition']!="" && $order_item_data['condition']==$condition_data['condition_name']){echo 'checked="checked"';}elseif($order_item_data['condition']=="" && $c==1){echo 'checked="checked"';}?>> <?=$condition_data['condition_name']?>
			</label>
		  <?php
		  } ?>
		</div>
	</div>
<?php
}

if(!empty($accessories_list) && ($fields_cat_type == "mobile" || $fields_cat_type == "tablet" || $fields_cat_type == "watch" || $fields_cat_type == "laptop")) {
	$edit_accessories_array = array();
	if($order_item_data['accessories']!="") {
		$accessories = str_replace(": Yes","",$order_item_data['accessories']);
		$edit_accessories_array = explode(", ",$accessories);
	} ?>
	<div class="control-group radio-inline">
		<label>Accessories: </label>
		<div class="controls">
		  <?php
		  foreach($accessories_list as $cnc_key=>$accessories_data) { ?>
			<label class="radio custom-radio">
			  <input class="check_accessories custom-control-input" type="checkbox" id="check_accessories<?=$cnc_key?>" name="check_accessories[]" value="<?=$accessories_data['id']?>" <?php if($order_item_data['accessories']!="" && in_array($accessories_data['accessories_name'],$edit_accessories_array)){echo 'checked="checked"';}elseif($order_item_data['accessories']=="" && $cnc_key==0){echo 'checked="checked"';}?>> <?=$accessories_data['accessories_name']?>
			</label>
		  <?php
		  } ?>
		</div>
	</div>
<?php
} ?>

<div class="control-group radio-inline">
	<label>Qty: </label>
	<div class="controls">
	  <input type="number" class="input-small" min="1" max="10" id="quantity" name="quantity" value="<?=$order_item_data['quantity']?>">
	</div>
</div>

<div class="control-group">				
	<b style="font-size:16px;">Device Info: </b>
	<div class="device_name"></div>
	<div class="show_final_amt" style="font-weight:bold;font-size:24px;margin-top:10px;"><?=amount_fomat($total)?></div>
</div>

<?php /*?><input type="hidden" id="quantity" name="quantity" value="<?=$order_item_data['quantity']?>"><?php */?>
<input type="hidden" name="device_id" id="device_id" value="<?=$model_data['device_id']?>"/>
<input type="hidden" name="payment_amt" id="payment_amt" value="<?=$total?>"/>
<input type="hidden" name="req_model_id" id="req_model_id" value="<?=$req_model_id?>"/>
<input type="hidden" name="order_id" id="order_id" value="<?=$order_id?>"/>
<input type="hidden" name="fields_cat_type" id="fields_cat_type" value="<?=$fields_cat_type?>"/>

<?php
if($edit_item_id>0) {
	echo '<input type="hidden" name="edit_item_id" id="edit_item_id" value="'.$edit_item_id.'"/>';
} ?>

<script type="text/javascript">
function check_edit_order_form(a) {

}

function network_cal(type) {
	var capacity_id = '';
	var condition_id = '';
	var network_id = '';
	var network_price_mode = '';
	var watchtype_id = '';
	var case_material_id = '';
	var case_size_id = '';
	var connectivity_id = '';
	var color_id = '';
	var accessories_ids = [];
	var screen_size_id = '';
	var screen_resolution_id = '';
	var lyear_id = '';
	var processor_id = '';
	var ram_id = '';

	jQuery(document).ready(function($) {
		if($("input[name='check_condition']").is(':checked')) {
			var condition_id = $("input[name='check_condition']:checked").val();
		}

		if($("input[name='check_network']").is(':checked')) {
			var network_id = $("input[name='check_network']:checked").val();
			var network_price_mode = $("input[name='network_price_mode']:checked").val();

			var network_name = $("input[name='check_network']:checked").attr("data-nw_name");
			if (network_name.match(/\unlock/) || network_name == "") {
				$(".network_price_mode_section_showhide").hide();
			} else {
				$(".network_price_mode_section_showhide").show();
			}
		} else {
			$(".network_price_mode_section_showhide").hide();
		}
		
		if($("input[name='check_case_material']").is(':checked')) {
			var case_material_id = $("input[name='check_case_material']:checked").val();
		}
		
		if($("input[name='check_watchtype']").is(':checked')) {
			var watchtype_id = $("input[name='check_watchtype']:checked").val();

			var enable_network = $("input[name='check_watchtype']:checked").attr("data-enable_network");
			if(enable_network == '0') {
				$(".network_section_showhide").hide();
				//$(".network_price_mode_section_showhide").hide();
			} else {
				$(".network_section_showhide").show();
				//$(".network_price_mode_section_showhide").show();
			}
		}
		
		if($("input[name='check_case_size']").is(':checked')) {
			var case_size_id = $("input[name='check_case_size']:checked").val();
		}

		if($("input[name='check_color']").is(':checked')) {
			var color_id = $("input[name='check_color']:checked").val();
		}

		$('.check_accessories').each(function(index) {
			if(this.checked == true) {
				accessories_ids[index] = this.value;
			}
		});

		if($("input[name='check_capacity']").is(':checked')) {
			var capacity_id = $("input[name='check_capacity']:checked").val();
		}
		
		if($("input[name='check_screen_size']").is(':checked')) {
			var screen_size_id = $("input[name='check_screen_size']:checked").val();
		}
		
		if($("input[name='check_screen_resolution']").is(':checked')) {
			var screen_resolution_id = $("input[name='check_screen_resolution']:checked").val();
		}
		
		if($("input[name='check_lyear']").is(':checked')) {
			var lyear_id = $("input[name='check_lyear']:checked").val();
		}
		
		if($("input[name='check_processor']").is(':checked')) {
			var processor_id = $("input[name='check_processor']:checked").val();
		}
		
		if($("input[name='check_ram']").is(':checked')) {
			var ram_id = $("input[name='check_ram']:checked").val();
		}
		
		var quantity = $("#quantity").val();
		post_data = {model_id:'<?=$req_model_id?>', fields_cat_type:'<?=$fields_cat_type?>', storage_id:capacity_id, condition_id:condition_id, network_id:network_id, watchtype_id:watchtype_id, case_material_id:case_material_id, case_size_id:case_size_id, connectivity_id:connectivity_id, color_id:color_id, accessories_ids:accessories_ids, screen_size_id:screen_size_id, screen_resolution_id:screen_resolution_id, lyear_id:lyear_id, processor_id:processor_id, ram_id:ram_id, network_price_mode:network_price_mode, step_type:type, quantity:quantity, 'is_admin':'1'}

		$(".show_final_amt").html('<span class="loading orange">Loading...</span>');
		$.ajax({
			type: "POST",
			url:"<?=SITE_URL?>ajax/get_model_price.php?token=<?=get_unique_id_on_load()?>",
			data:post_data,
			success:function(data) {
				if(data!="") {
					var resp_data = JSON.parse(data);
					$("#payment_amt").val(resp_data.payment_amt);
					$(".show_final_amt").html(resp_data.show_final_amt);
					$(".device_name").html(resp_data.device_name);
				}
			}
		});
	});
}

jQuery(document).ready(function($) {
	$(".check_capacity").change(function() {
		network_cal('capacity');
	});

	$(".check_condition").change(function() {
		network_cal('condition');
	});
	
	$(".check_network").change(function() {
		network_cal('network');
	});

	$(".network_price_mode").change(function() {
		network_cal('nwk_price_mode');
	});
	
	$(".check_color").change(function() {
		network_cal('color');
	});

	$(".check_accessories").change(function() {
		network_cal('accessories');
	});
	
	$(".check_watchtype").change(function() {
		network_cal('watchtype');
	});
	
	$(".check_case_material").change(function() {
		network_cal('case_material');
	});

	$(".check_case_size").change(function() {
		network_cal('case_size');
	});

	$(".check_connectivity").change(function() {
		network_cal('connectivity');
	});
	
	$(".check_screen_size").change(function() {
		network_cal('screen_size');
	});
	
	$(".check_screen_resolution").change(function() {
		network_cal('screen_resolution');
	});
	
	$(".check_lyear").change(function() {
		network_cal('lyear');
	});
	
	$(".check_processor").change(function() {
		network_cal('processor');
	});
	
	$(".check_ram").change(function() {
		network_cal('ram');
	});

	$("#quantity").on('blur keyup change paste',function() {
		network_cal('quantity');
	});
});

<?php
//Trigger by onload page
echo 'network_cal(0);'; ?>
</script>

<!-- Custom checkbox and radio -->
<script src="js/plugins/prettyCheckable/prettyCheckable.js"></script>
<script>
$(document).ready(function() {
	$('.custom-checkbox input, .custom-radio input').prettyCheckable();
});
</script>

<?php
} ?>