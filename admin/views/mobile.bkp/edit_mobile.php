<style type="text/css">
.condition-fields label {margin-bottom:2px !important;font-size:10px !important;}
.network-fields label {margin-bottom:2px !important;font-size:10px !important;}
.watchtype-fields label {margin-bottom:2px !important;font-size:10px !important;}
</style>

<script>
function check_form(a){
	if(a.device_id.value.trim()==""){
		alert('Please select device');
		a.device_id.focus();
		a.device_id.value='';
		return false;
	}
	if(a.cat_id.value.trim()==""){
		alert('Please select category');
		a.cat_id.focus();
		a.cat_id.value='';
		return false;
	}
	if(a.title.value.trim()==""){
		alert('Please enter title');
		a.title.focus();
		a.title.value='';
		return false;
	}
	/*if(a.price.value.trim()==""){
		alert('Please enter base price');
		a.price.focus();
		a.price.value='';
		return false;
	}*/
	/*if(a.tooltip_device.value.trim()==""){
		alert('Please enter tooltip of device');
		a.tooltip_device.focus();
		a.tooltip_device.value='';
		return false;
	}*/

	<?php
	if($mobile_data['model_img']=="") { ?>
	var str_image = a.model_img.value.trim();
	if(str_image == "") {
		alert('Please select image');
		return false;
	}
	<?php
	} ?>
	
	var storage_size = document.getElementsByName('storage_size[]');
	for(var i = 0; i < storage_size.length; i++) {
		if(storage_size[i].value.match(/:/g)) {
			alert("Do not allow : in storage size");
			storage_size[i].focus();
			return false;           
		}
	}
	
	var condition_name = document.getElementsByName('condition_name[]');
	for(var i = 0; i < condition_name.length; i++) {
		if(condition_name[i].value.match(/:/g)) {
			alert("Do not allow : in condition name");
			condition_name[i].focus();
			return false;           
		}
	}
	
	var network_name = document.getElementsByName('network_name[]');
	for(var i = 0; i < network_name.length; i++) {
		if(network_name[i].value.match(/:/g)) {
			alert("Do not allow : in network name");
			network_name[i].focus();
			return false;           
		}
	}

	var connectivity_name = document.getElementsByName('connectivity_name[]');
	for(var i = 0; i < connectivity_name.length; i++) {
		if(connectivity_name[i].value.match(/:/g)) {
			alert("Do not allow : in connectivity name");
			connectivity_name[i].focus();
			return false;           
		}
	}
	
	var watchtype_name = document.getElementsByName('watchtype_name[]');
	for(var i = 0; i < watchtype_name.length; i++) {
		if(watchtype_name[i].value.match(/:/g)) {
			alert("Do not allow : in watchtype name");
			watchtype_name[i].focus();
			return false;           
		}
	}
	
	var case_material_name = document.getElementsByName('case_material_name[]');
	for(var i = 0; i < case_material_name.length; i++) {
		if(case_material_name[i].value.match(/:/g)) {
			alert("Do not allow : in case material name");
			case_material_name[i].focus();
			return false;           
		}
	}
	
	var case_size_name = document.getElementsByName('case_size_name[]');
	for(var i = 0; i < case_size_name.length; i++) {
		if(case_size_name[i].value.match(/:/g)) {
			alert("Do not allow : in case size name");
			case_size_name[i].focus();
			return false;           
		}
	}
	
	var color_name = document.getElementsByName('color_name[]');
	for(var i = 0; i < color_name.length; i++) {
		if(color_name[i].value.match(/:/g)) {
			alert("Do not allow : in case size name");
			color_name[i].focus();
			return false;           
		}
	}
	
	var accessories_name = document.getElementsByName('accessories_name[]');
	for(var i = 0; i < accessories_name.length; i++) {
		if(accessories_name[i].value.match(/:/g)) {
			alert("Do not allow : in case size name");
			accessories_name[i].focus();
			return false;           
		}
	}	
}

function checkFile(fieldObj) {
	if(fieldObj.files.length == 0) {
		return false;
	}

    var id = fieldObj.id;
	var str  = fieldObj.value;
	var FileExt = str.substr(str.lastIndexOf('.')+1);
	var FileExt = FileExt.toLowerCase();
	var FileSize = fieldObj.files[0].size;
	var FileSizeMB = (FileSize/10485760).toFixed(2);

	if((FileExt != "gif" && FileExt != "png" && FileExt != "jpg" && FileExt != "jpeg")){
	    var error = "Please make sure your file is in png | jpg | jpeg | gif format.\n\n";
	    alert(error);
		document.getElementById(id).value = '';
	    return false;
	}
}

function get_random_number(type) {
	return type+Math.floor(Math.random() * 1000000000);
}

jQuery(document).ready(function ($) {
	$("#storage_plus_icon").on( "click", function(e) {
		var uniqueId = Math.random();
		var uniqueId = uniqueId.toString().split('.');

		var append_data='<div id="'+uniqueId[1]+'" style="margin-top:5px;">';
			append_data+='<div class="controls"><input type="text" class="input-small" id="storage_size[]" name="storage_size[]" placeholder="Storage Sizes"> ';
			
			append_data+='<select class="span2" name="storage_size_postfix[]" id="storage_size_postfix[]" style="width:70px;">';
				append_data+='<option value="GB">GB</option>';
				append_data+='<option value="TB">TB</option>';
				append_data+='<option value="MB">MB</option>';
			append_data+='</select>';
			
			append_data+='<div class="input-prepend input-append"><?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?><input type="number" class="input-small" id="storage_price[]" name="storage_price[]" placeholder="Price"><?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?></div>';
			
			<?php
			if($top_seller_mode == "storage_specific") { ?>
			append_data+='<select class="span2" name="top_seller[]" id="top_seller[]" style="width:100px;">';
				append_data+='<option value=""> - Top Seller - </option>';
				append_data+='<option value="1">ON</option>';
				append_data+='<option value="0">OFF</option>';
			append_data+='</select>';
			<?php
			} ?>
											
			append_data+='&nbsp;<a href="javascript:void(0);" class="remove_storage_item" id="rm_'+uniqueId[1]+'"><i class="icon-remove-sign"></i></a>';
			append_data+='</div>';
		 append_data+='</div>';
		$('#add_storage_item').append(append_data);
		remove_storage_item();
	});

	$("#condition_plus_icon").on( "click", function(e) {
		var uniqueId = Math.random();
		var uniqueId = uniqueId.toString().split('.');

		var append_data='<div class="row" id="'+uniqueId[1]+'" style="margin-top:5px;">';
			append_data+='<div class="span1.5">';
				append_data+='<div class="control-group">';
					append_data+='<label class="control-label" for="input">Name</label>';
					append_data+='<div class="controls">';
						 append_data+='<input type="text" class="input-small" id="condition_name[]" name="condition_name[]" placeholder="Name">';
					append_data+='</div>';
				append_data+='</div>';
			append_data+='</div>';
			
			append_data+='<div class="span1.5">';
				append_data+='<div class="control-group">';
					append_data+='<label class="control-label" for="input">Price</label>';
					append_data+='<div class="controls">';
						 append_data+='<div class="input-prepend input-append"><?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?><input type="number" class="input-small" id="condition_price[]" name="condition_price[]" placeholder="Price"><?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?></div>';
					append_data+='</div>';
				append_data+='</div>';
			append_data+='</div>';
			
			append_data+='<div class="span5">';
				append_data+='<div class="control-group">';
					append_data+='<label class="control-label" for="input">Terms</label>';
					append_data+='<div class="controls">';
						 append_data+='<textarea class="form-control span5 wysihtml5" name="condition_terms[]" id="condition_terms[]" placeholder="Terms"></textarea>';
					append_data+='</div>';
				append_data+='</div>';
			append_data+='</div>';
			
			append_data+='<div class="span1">';
				append_data+='<div class="control-group">';
					append_data+='<label class="control-label" for="input"></label>';
					append_data+='<div class="controls">';
						append_data+='&nbsp;<a href="javascript:void(0);" class="remove_condition_item" id="rm_'+uniqueId[1]+'"><i class="icon-remove-sign"></i></a>';
					append_data+='</div>';
				append_data+='</div>';
			append_data+='</div>';
		append_data+='</div>';

		$('#add_condition_item').append(append_data);
		remove_condition_item();
	});

	$("#network_plus_icon").on( "click", function(e) {
		var uniqueId = Math.random();
		var uniqueId = uniqueId.toString().split('.');

		var append_data='<div class="row" id="'+uniqueId[1]+'">';
			append_data+='<div class="span1.5">';
				append_data+='<div class="control-group">';
					append_data+='<label class="control-label" for="input">Name</label>';
					append_data+='<div class="controls">';
						 append_data+='<input type="text" class="input-medium" id="network_name[]" name="network_name[]" placeholder="Name">';
					append_data+='</div>';
				append_data+='</div>';
			append_data+='</div>';
			
			append_data+='<div class="span1.5">';
				append_data+='<div class="control-group">';
					append_data+='<label class="control-label" for="input">Price</label>';
					append_data+='<div class="controls">';
						 append_data+='<div class="input-prepend input-append"><?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?><input type="number" class="input-small" id="network_price[]" name="network_price[]" style="width:50px;" placeholder="Price"><?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?></div>';
					append_data+='</div>';
				append_data+='</div>';
			append_data+='</div>';
			
			append_data+='<div class="span1.5">';
				append_data+='<div class="control-group">';
					append_data+='<label class="control-label" for="input">Unlock Price</label>';
					append_data+='<div class="controls">';
						 append_data+='<div class="input-prepend input-append"><?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?><input type="number" class="input-small" id="network_unlock_price[]" name="network_unlock_price[]" style="width:50px;" placeholder="Price"><?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?></div>';
					append_data+='</div>';
				append_data+='</div>';
			append_data+='</div>';
			
			append_data+='<div class="span1.5">';
				append_data+='<div class="control-group">';
					append_data+='<label class="control-label" for="input">Icon</label>';
					append_data+='<div class="controls">';
						 append_data+='<input type="file" name="network_icon[]" id="network_icon[]" style="width:95px;"/>';
						 append_data+='&nbsp;<a href="javascript:void(0);" class="remove_network_item" id="rm_'+uniqueId[1]+'"><i class="icon-remove-sign"></i></a>';
					append_data+='</div>';
				append_data+='</div>';
			append_data+='</div>';
			
		append_data+='</div>';

		$('#add_network_item').append(append_data);
		remove_network_item();
	});
	
	$("#connectivity_plus_icon").on( "click", function(e) {
		var uniqueId = Math.random();
		var uniqueId = uniqueId.toString().split('.');

		var append_data='<div id="'+uniqueId[1]+'" style="margin-top:5px;">';
			 append_data+='<div class="controls"><input type="text" class="input-large" id="connectivity_name[]" name="connectivity_name[]" placeholder="Name"> ';
			 
			 append_data+='<div class="input-prepend input-append"><?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?><input type="number" class="input-small" id="connectivity_price[]" name="connectivity_price[]" placeholder="Price"><?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?></div>';
			 
			 append_data+='&nbsp;<a href="javascript:void(0);" class="remove_connectivity_item" id="rm_'+uniqueId[1]+'"><i class="icon-remove-sign"></i></a>';
			 append_data+='</div>';
		 append_data+='</div>';
		$('#add_connectivity_item').append(append_data);
		remove_connectivity_item();
	});

	$("#case_size_plus_icon").on( "click", function(e) {
		var uniqueId = Math.random();
		var uniqueId = uniqueId.toString().split('.');

		var append_data='<div id="'+uniqueId[1]+'" style="margin-top:5px;">';
			 append_data+='<div class="controls"><input type="text" class="input-large" id="case_size[]" name="case_size[]" placeholder="Case Size"> ';
			 
			 append_data+='<div class="input-prepend input-append"><?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?><input type="number" class="input-small" id="case_size_price[]" name="case_size_price[]" placeholder="Price"><?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?></div>';
			 
			 append_data+='&nbsp;<a href="javascript:void(0);" class="remove_case_size_item" id="rm_'+uniqueId[1]+'"><i class="icon-remove-sign"></i></a>';
			 append_data+='</div>';
		 append_data+='</div>';
		$('#add_case_size_item').append(append_data);
		remove_case_size_item();
	});

	$("#watchtype_plus_icon").on( "click", function(e) {
		var uniqueId = Math.random();
		var uniqueId = uniqueId.toString().split('.');

		var append_data='<div class="row" id="'+uniqueId[1]+'" style="margin-top:5px;">';
			append_data+='<div class="span1.5">';
				append_data+='<div class="control-group">';
					append_data+='<label class="control-label" for="input">&nbsp;</label>';
					append_data+='<div class="controls">';
			 			append_data+='<input type="text" class="input-large" id="watchtype_name[]" name="watchtype_name[]" placeholder="Name">';
			 		append_data+='</div>';
				append_data+='</div>';
			append_data+='</div>';
			append_data+='<div class="span1.5">';
				append_data+='<div class="control-group">';
					append_data+='<label class="control-label" for="input">&nbsp;</label>';
					append_data+='<div class="controls">';
			 			append_data+='<div class="input-prepend input-append"><?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?><input type="number" class="input-small" id="watchtype_price[]" name="watchtype_price[]" placeholder="Price"><?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?></div>';
			 		append_data+='</div>';
				append_data+='</div>';
			append_data+='</div>';
			append_data+='<div class="span1.5">';
				append_data+='<div class="control-group">';
					append_data+='<label class="control-label" for="input">Network</label>';
					append_data+='<div class="controls">';
						append_data+='<select class="span2" name="disabled_network[]" id="disabled_network[]">';
							append_data+='<option value="1">Enabled</option>';
							append_data+='<option value="0">Disabled</option>';
						append_data+='</select>';
						append_data+='&nbsp;<a href="javascript:void(0);" class="remove_watchtype_item" id="rm_'+uniqueId[1]+'"><i class="icon-remove-sign"></i></a>';
					append_data+='</div>';
				append_data+='</div>';
			append_data+='</div>';
		 append_data+='</div>';
		$('#add_watchtype_item').append(append_data);
		remove_watchtype_item();
	});
	
	$("#case_material_plus_icon").on( "click", function(e) {
		var uniqueId = Math.random();
		var uniqueId = uniqueId.toString().split('.');

		var append_data='<div id="'+uniqueId[1]+'" style="margin-top:5px;">';
			 append_data+='<div class="controls"><input type="text" class="input-large" id="case_material_name[]" name="case_material_name[]" placeholder="Name"> ';
			 
			 append_data+='<div class="input-prepend input-append"><?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?><input type="number" class="input-small" id="case_material_price[]" name="case_material_price[]" placeholder="Price"><?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?></div>';
			 
			 append_data+='&nbsp;<a href="javascript:void(0);" class="remove_case_material_item" id="rm_'+uniqueId[1]+'"><i class="icon-remove-sign"></i></a>';
			 append_data+='</div>';
		 append_data+='</div>';
		$('#add_case_material_item').append(append_data);
		remove_case_material_item();
	});
	
	$("#color_plus_icon").on( "click", function(e) {
		var uniqueId = Math.random();
		var uniqueId = uniqueId.toString().split('.');
		var random_number = get_random_number('clr');

		var append_data='<div id="'+uniqueId[1]+'" style="margin-top:5px;">';
			 append_data+='<div class="controls"><input type="text" class="input-large" id="color_name[]" name="color_name['+random_number+']" placeholder="Name"> ';
			 append_data+='<input type="color" class="input-small" id="color_code[]" name="color_code['+random_number+']" placeholder="Color Code"> ';
			 append_data+='<div class="input-prepend input-append"><?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?><input type="number" class="input-small" id="color_price[]" name="color_price['+random_number+']" placeholder="Price"><?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?></div>';
			 append_data+='<select class="select2" name="color_storage_ids['+random_number+'][]" id="color_storage_ids['+random_number+'][]" multiple="multiple">';
			 <?php
			 if(!empty($storage_items_array)) {
				$svd_color_storage_ids = @explode(",",$color_item['storage_ids']);
				foreach($storage_items_array as $storage_item) {
					$storage_id = $storage_item['id']; ?>
					append_data+='<option value="<?=$storage_id?>"><?=html_entities($storage_item['storage_size'].$storage_item['storage_size_postfix'])?></option>';
				<?php
				}
			 } ?>
			 append_data+='</select>';

			 append_data+='&nbsp;<a href="javascript:void(0);" class="remove_color_item" id="rm_'+uniqueId[1]+'"><i class="icon-remove-sign"></i></a>';
			 append_data+='</div>';
		 append_data+='</div>';
		$('#add_color_item').append(append_data);
		remove_color_item();
		$(".select2").select2();
	});
	
	$("#accessories_plus_icon").on( "click", function(e) {
		var uniqueId = Math.random();
		var uniqueId = uniqueId.toString().split('.');

		var append_data='<div id="'+uniqueId[1]+'" style="margin-top:5px;">';
			 append_data+='<div class="controls"><input type="text" class="input-large" id="accessories_name[]" name="accessories_name[]" placeholder="Name"> ';
			 
			 append_data+='<div class="input-prepend input-append"><?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?><input type="number" class="input-small" id="accessories_price[]" name="accessories_price[]" placeholder="Price"><?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?></div>';
			 
			 append_data+='&nbsp;<a href="javascript:void(0);" class="remove_accessories_item" id="rm_'+uniqueId[1]+'"><i class="icon-remove-sign"></i></a>';
			 append_data+='</div>';
		 append_data+='</div>';
		$('#add_accessories_item').append(append_data);
		remove_accessories_item();
	});
	
	$("#screen_size_plus_icon").on( "click", function(e) {
		var uniqueId = Math.random();
		var uniqueId = uniqueId.toString().split('.');

		var append_data='<div id="'+uniqueId[1]+'" style="margin-top:5px;">';
			 append_data+='<div class="controls"><input type="text" class="input-large" id="screen_size_name[]" name="screen_size_name[]" placeholder="Screen Size"> ';
			 
			 append_data+='<div class="input-prepend input-append"><?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?><input type="number" class="input-small" id="screen_size_price[]" name="screen_size_price[]" placeholder="Price"><?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?></div>';
			 
			 append_data+='&nbsp;<a href="javascript:void(0);" class="remove_screen_size_item" id="rm_'+uniqueId[1]+'"><i class="icon-remove-sign"></i></a>';
			 append_data+='</div>';
		 append_data+='</div>';
		$('#add_screen_size_item').append(append_data);
		remove_screen_size_item();
	});
	
	$("#screen_resolution_plus_icon").on( "click", function(e) {
		var uniqueId = Math.random();
		var uniqueId = uniqueId.toString().split('.');

		var append_data='<div id="'+uniqueId[1]+'" style="margin-top:5px;">';
			 append_data+='<div class="controls"><input type="text" class="input-large" id="screen_resolution_name[]" name="screen_resolution_name[]" placeholder="Name"> ';
			 
			 append_data+='<div class="input-prepend input-append"><?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?><input type="number" class="input-small" id="screen_resolution_price[]" name="screen_resolution_price[]" placeholder="Price"><?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?></div>';
			 
			 append_data+='&nbsp;<a href="javascript:void(0);" class="remove_screen_resolution_item" id="rm_'+uniqueId[1]+'"><i class="icon-remove-sign"></i></a>';
			 append_data+='</div>';
		 append_data+='</div>';
		$('#add_screen_resolution_item').append(append_data);
		remove_screen_resolution_item();
	});
	
	$("#lyear_plus_icon").on( "click", function(e) {
		var uniqueId = Math.random();
		var uniqueId = uniqueId.toString().split('.');

		var append_data='<div id="'+uniqueId[1]+'" style="margin-top:5px;">';
			 append_data+='<div class="controls"><input type="text" class="input-large" id="lyear_name[]" name="lyear_name[]" placeholder="Year"> ';
			 
			 append_data+='<div class="input-prepend input-append"><?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?><input type="number" class="input-small" id="lyear_price[]" name="lyear_price[]" placeholder="Price"><?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?></div>';
			 
			 append_data+='&nbsp;<a href="javascript:void(0);" class="remove_lyear_item" id="rm_'+uniqueId[1]+'"><i class="icon-remove-sign"></i></a>';
			 append_data+='</div>';
		 append_data+='</div>';
		$('#add_lyear_item').append(append_data);
		remove_lyear_item();
	});
	
	$("#processor_plus_icon").on( "click", function(e) {
		var uniqueId = Math.random();
		var uniqueId = uniqueId.toString().split('.');

		var append_data='<div id="'+uniqueId[1]+'" style="margin-top:5px;">';
			 append_data+='<div class="controls"><input type="text" class="input-large" id="processor_name[]" name="processor_name[]" placeholder="Name"> ';
			 
			 append_data+='<div class="input-prepend input-append"><?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?><input type="number" class="input-small" id="processor_price[]" name="processor_price[]" placeholder="Price"><?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?></div>';
			 
			 append_data+='&nbsp;<a href="javascript:void(0);" class="remove_processor_item" id="rm_'+uniqueId[1]+'"><i class="icon-remove-sign"></i></a>';
			 append_data+='</div>';
		 append_data+='</div>';
		$('#add_processor_item').append(append_data);
		remove_processor_item();
	});
	
	$("#ram_plus_icon").on( "click", function(e) {
		var uniqueId = Math.random();
		var uniqueId = uniqueId.toString().split('.');

		var append_data='<div id="'+uniqueId[1]+'" style="margin-top:5px;">';
			 append_data+='<div class="controls"><input type="text" class="input-small" id="ram_size[]" name="ram_size[]" placeholder="Ram Size"> ';
			
			append_data+='<select class="span2" name="ram_size_postfix[]" id="ram_size_postfix[]" style="width:70px;">';
				append_data+='<option value="GB">GB</option>';
				append_data+='<option value="TB">TB</option>';
				append_data+='<option value="MB">MB</option>';
			append_data+='</select>';
			 
			 append_data+='<div class="input-prepend input-append"><?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?><input type="number" class="input-small" id="ram_price[]" name="ram_price[]" placeholder="Price"><?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?></div>';
			 
			 append_data+='&nbsp;<a href="javascript:void(0);" class="remove_ram_item" id="rm_'+uniqueId[1]+'"><i class="icon-remove-sign"></i></a>';
			 append_data+='</div>';
		 append_data+='</div>';
		$('#add_ram_item').append(append_data);
		remove_ram_item();
	});

	$("#mobile_depen_plus_icon").on( "click", function(e) {
			var uniqueId = Math.random();
			var uniqueId = uniqueId.toString().split('.');
			var random_number = get_random_number('clr');

			var append_data='<div id="depen'+uniqueId[1]+'" style="margin-top:5px;">';
				 append_data+='<div class="controls"><input type="hidden" name="depenkey['+random_number+']" value="'+random_number+'">';
			
				 append_data+='<select class="select2" name="accessories_ids['+random_number+'][]" id="accessories_ids['+random_number+'][]" multiple="multiple">';
				 <?php
				 if(!empty($accessories_items_array)) {
					$accessories_ids = @explode(",",$dependency_item['accessories']);
					foreach($accessories_items_array as $accessory_item) {
						$accessory_id = $accessory_item['id']; ?>
						append_data+='<option value="<?=$accessory_id?>"><?=html_entities($accessory_item['accessories_name'])?></option>';
					<?php
					}
				 } ?>
				 append_data+='</select>';

				 append_data+='<select class="select2" name="color_ids['+random_number+'][]" id="color_ids['+random_number+'][]" multiple="multiple">';
				 <?php
				 if(!empty($color_items_array)) {
					$color_ids = @explode(",",$dependency_item['color']);
					foreach($color_items_array as $color_item) {
						$color_id = $color_item['id']; ?>
						append_data+='<option value="<?=$color_id?>"><?=html_entities($color_item['color_name'])?></option>';
					<?php
					}
				 } ?>
				 append_data+='</select>';

				 append_data+='<select class="select2" name="conditions_ids['+random_number+'][]" id="conditions_ids['+random_number+'][]" multiple="multiple">';
				 <?php
				 if(!empty($condition_items_array)) {
					$conditions_ids = @explode(",",$dependency_item['conditions']);
					foreach($condition_items_array as $conditions_item) {
						$conditions_id = $conditions_item['id']; ?>
						append_data+='<option value="<?=$conditions_id?>"><?=html_entities($conditions_item['condition_name'])?></option>';
					<?php
					}
				 } ?>
				 append_data+='</select>';

				 append_data+='<select class="select2" name="networks_ids['+random_number+'][]" id="networks_ids['+random_number+'][]" multiple="multiple">';
				 <?php
				 if(!empty($network_items_array)) {
					$networks_ids = @explode(",",$dependency_item['networks']);
					foreach($network_items_array as $networks_item) {
						$networks_id = $networks_item['id']; ?>
						append_data+='<option value="<?=$networks_id?>"><?=html_entities($networks_item['network_name'])?></option>';
					<?php
					}
				 } ?>
				 append_data+='</select>';

				 append_data+='<select class="select2" name="storage_ids['+random_number+'][]" id="storage_ids['+random_number+'][]" multiple="multiple">';
				 <?php
				 if(!empty($storage_items_array)) {
					$storage_ids = @explode(",",$dependency_item['storage']);
					foreach($storage_items_array as $storage_item) {
						$storage_id = $storage_item['id']; ?>
						append_data+='<option value="<?=$storage_id?>"><?=html_entities($storage_item['storage_size'])?><?=html_entities($storage_item['storage_size_postfix'])?></option>';
					<?php
					}
				 } ?>
				 append_data+='</select>';


				

				 append_data+='&nbsp;<a href="javascript:void(0);" class="remove_depen_item" id="depenrm_'+uniqueId[1]+'"><i class="icon-remove-sign"></i></a>';
				 append_data+='</div>';
			 append_data+='</div>';
			$('#add_depen_item').append(append_data);
			remove_depen_item();
			$(".select2").select2();
	});


	$("#tablet_depen_plus_icon").on( "click", function(e) {
		var uniqueId = Math.random();
		var uniqueId = uniqueId.toString().split('.');
		var random_number = get_random_number('clr');

		var append_data='<div id="depen'+uniqueId[1]+'" style="margin-top:5px;">';
 				append_data+='<div class="controls"><input type="hidden" name="depenkey['+random_number+']" value="'+random_number+'">';
			
				append_data+='<select class="select2" name="watchtype_ids['+random_number+'][]" id="watchtype_ids['+random_number+'][]" multiple="multiple">';
				 <?php
				 if(!empty($watchtype_items_array)) {
					$watchtype_ids = @explode(",",$dependency_item['watchtype']);
					foreach($watchtype_items_array as $watchtype_item) {
						$watchtype_id = $watchtype_item['id']; ?>
						append_data+='<option value="<?=$watchtype_id?>"><?=html_entities($watchtype_item['watchtype_name'])?></option>';
					<?php
					}
				 } ?>
				 append_data+='</select>';

				 append_data+='<select class="select2" name="accessories_ids['+random_number+'][]" id="accessories_ids['+random_number+'][]" multiple="multiple">';
				 <?php
				 if(!empty($accessories_items_array)) {
					$accessories_ids = @explode(",",$dependency_item['accessories']);
					foreach($accessories_items_array as $accessory_item) {
						$accessory_id = $accessory_item['id']; ?>
						append_data+='<option value="<?=$accessory_id?>"><?=html_entities($accessory_item['accessories_name'])?></option>';
					<?php
					}
				 } ?>
				 append_data+='</select>';

				 append_data+='<select class="select2" name="color_ids['+random_number+'][]" id="color_ids['+random_number+'][]" multiple="multiple">';
				 <?php
				 if(!empty($color_items_array)) {
					$color_ids = @explode(",",$dependency_item['color']);
					foreach($color_items_array as $color_item) {
						$color_id = $color_item['id']; ?>
						append_data+='<option value="<?=$color_id?>"><?=html_entities($color_item['color_name'])?></option>';
					<?php
					}
				 } ?>
				 append_data+='</select>';

				 append_data+='<select class="select2" name="conditions_ids['+random_number+'][]" id="conditions_ids['+random_number+'][]" multiple="multiple">';
				 <?php
				 if(!empty($condition_items_array)) {
					$conditions_ids = @explode(",",$dependency_item['conditions']);
					foreach($condition_items_array as $conditions_item) {
						$conditions_id = $conditions_item['id']; ?>
						append_data+='<option value="<?=$conditions_id?>"><?=html_entities($conditions_item['condition_name'])?></option>';
					<?php
					}
				 } ?>
				 append_data+='</select>';

				 append_data+='<select class="select2" name="networks_ids['+random_number+'][]" id="networks_ids['+random_number+'][]" multiple="multiple">';
				 <?php
				 if(!empty($network_items_array)) {
					$networks_ids = @explode(",",$dependency_item['networks']);
					foreach($network_items_array as $networks_item) {
						$networks_id = $networks_item['id']; ?>
						append_data+='<option value="<?=$networks_id?>"><?=html_entities($networks_item['network_name'])?></option>';
					<?php
					}
				 } ?>
				 append_data+='</select>';

				 append_data+='<select class="select2" name="storage_ids['+random_number+'][]" id="storage_ids['+random_number+'][]" multiple="multiple">';
				 <?php
				 if(!empty($storage_items_array)) {
					$storage_ids = @explode(",",$dependency_item['storage']);
					foreach($storage_items_array as $storage_item) {
						$storage_id = $storage_item['id']; ?>
						append_data+='<option value="<?=$storage_id?>"><?=html_entities($storage_item['storage_size'])?><?=html_entities($storage_item['storage_size_postfix'])?></option>';
					<?php
					}
				 } ?>
				 append_data+='</select>';
			 append_data+='&nbsp;<a href="javascript:void(0);" class="remove_depen_item" id="depenrm_'+uniqueId[1]+'"><i class="icon-remove-sign"></i></a>';
			 append_data+='</div>';
		 append_data+='</div>';
		$('#add_depen_item').append(append_data);
		remove_depen_item();
		$(".select2").select2();
	});

	$("#watch_depen_plus_icon").on( "click", function(e) {
		var uniqueId = Math.random();
		var uniqueId = uniqueId.toString().split('.');
		var random_number = get_random_number('clr');

		var append_data='<div id="depen'+uniqueId[1]+'" style="margin-top:5px;">';
			 	append_data+='<div class="controls"><input type="hidden" name="depenkey['+random_number+']" value="'+random_number+'">';
			


				 append_data+='<select class="select2" name="case_material_ids['+random_number+'][]" id="case_material_ids['+random_number+'][]" multiple="multiple">';
				 <?php
				 if(!empty($case_material_items_array)) {
					$case_material_ids = @explode(",",$dependency_item['case_material']);
					foreach($case_material_items_array as $case_material_item) {
						$case_material_id = $case_material_item['id']; ?>
						append_data+='<option value="<?=$case_material_id?>"><?=html_entities($case_material_item['case_material_name'])?></option>';
					<?php
					}
				 } ?>
				 append_data+='</select>';

				 append_data+='<select class="select2" name="case_size_ids['+random_number+'][]" id="case_size_ids['+random_number+'][]" multiple="multiple">';
				 <?php
				 if(!empty($case_size_items_array)) {
					$case_size_ids = @explode(",",$dependency_item['case_size']);
					foreach($case_size_items_array as $case_size_item) {
						$case_size_id = $case_size_item['id']; ?>
						append_data+='<option value="<?=$case_size_id?>"><?=html_entities($case_size_item['case_size'])?></option>';
					<?php
					}
				 } ?>
				 append_data+='</select>';

				append_data+='<select class="select2" name="watchtype_ids['+random_number+'][]" id="watchtype_ids['+random_number+'][]" multiple="multiple">';
				 <?php
				 if(!empty($watchtype_items_array)) {
					$watchtype_ids = @explode(",",$dependency_item['watchtype']);
					foreach($watchtype_items_array as $watchtype_item) {
						$watchtype_id = $watchtype_item['id']; ?>
						append_data+='<option value="<?=$watchtype_id?>"><?=html_entities($watchtype_item['watchtype_name'])?></option>';
					<?php
					}
				 } ?>
				 append_data+='</select>';

				 append_data+='<select class="select2" name="accessories_ids['+random_number+'][]" id="accessories_ids['+random_number+'][]" multiple="multiple">';
				 <?php
				 if(!empty($accessories_items_array)) {
					$accessories_ids = @explode(",",$dependency_item['accessories']);
					foreach($accessories_items_array as $accessory_item) {
						$accessory_id = $accessory_item['id']; ?>
						append_data+='<option value="<?=$accessory_id?>"><?=html_entities($accessory_item['accessories_name'])?></option>';
					<?php
					}
				 } ?>
				 append_data+='</select>';

				 append_data+='<select class="select2" name="color_ids['+random_number+'][]" id="color_ids['+random_number+'][]" multiple="multiple">';
				 <?php
				 if(!empty($color_items_array)) {
					$color_ids = @explode(",",$dependency_item['color']);
					foreach($color_items_array as $color_item) {
						$color_id = $color_item['id']; ?>
						append_data+='<option value="<?=$color_id?>"><?=html_entities($color_item['color_name'])?></option>';
					<?php
					}
				 } ?>
				 append_data+='</select>';

				 append_data+='<select class="select2" name="conditions_ids['+random_number+'][]" id="conditions_ids['+random_number+'][]" multiple="multiple">';
				 <?php
				 if(!empty($condition_items_array)) {
					$conditions_ids = @explode(",",$dependency_item['conditions']);
					foreach($condition_items_array as $conditions_item) {
						$conditions_id = $conditions_item['id']; ?>
						append_data+='<option value="<?=$conditions_id?>"><?=html_entities($conditions_item['condition_name'])?></option>';
					<?php
					}
				 } ?>
				 append_data+='</select>';

				 append_data+='<select class="select2" name="networks_ids['+random_number+'][]" id="networks_ids['+random_number+'][]" multiple="multiple">';
				 <?php
				 if(!empty($network_items_array)) {
					$networks_ids = @explode(",",$dependency_item['networks']);
					foreach($network_items_array as $networks_item) {
						$networks_id = $networks_item['id']; ?>
						append_data+='<option value="<?=$networks_id?>"><?=html_entities($networks_item['network_name'])?></option>';
					<?php
					}
				 } ?>
				 append_data+='</select>';

				 append_data+='<select class="select2" name="storage_ids['+random_number+'][]" id="storage_ids['+random_number+'][]" multiple="multiple">';
				 <?php
				 if(!empty($storage_items_array)) {
					$storage_ids = @explode(",",$dependency_item['storage']);
					foreach($storage_items_array as $storage_item) {
						$storage_id = $storage_item['id']; ?>
						append_data+='<option value="<?=$storage_id?>"><?=html_entities($storage_item['storage_size'])?><?=html_entities($storage_item['storage_size_postfix'])?></option>';
					<?php
					}
				 } ?>
				 append_data+='</select>';
			 append_data+='&nbsp;<a href="javascript:void(0);" class="remove_depen_item" id="rm_'+uniqueId[1]+'"><i class="icon-remove-sign"></i></a>';
			 append_data+='</div>';
		 append_data+='</div>';
		$('#add_depen_item').append(append_data);
		remove_depen_item();
		$(".select2").select2();
	});

	$("#laptop_depen_plus_icon").on( "click", function(e) {
		var uniqueId = Math.random();
		var uniqueId = uniqueId.toString().split('.');
		var random_number = get_random_number('clr');

		var append_data='<div id="depen'+uniqueId[1]+'" style="margin-top:5px;">';
			 append_data+='<div class="controls"><input type="hidden" name="depenkey['+random_number+']" value="'+random_number+'">';

				append_data+='<select class="select2" name="watchtype_ids['+random_number+'][]" id="watchtype_ids['+random_number+'][]" multiple="multiple">';
				 <?php
				 if(!empty($watchtype_items_array)) {
					$watchtype_ids = @explode(",",$dependency_item['watchtype']);
					foreach($watchtype_items_array as $watchtype_item) {
						$watchtype_id = $watchtype_item['id']; ?>
						append_data+='<option value="<?=$watchtype_id?>"><?=html_entities($watchtype_item['watchtype_name'])?></option>';
					<?php
					}
				 } ?>
				 append_data+='</select>';

				  append_data+='<select class="select2" name="processor_ids['+random_number+'][]" id="processor_ids['+random_number+'][]" multiple="multiple">';
				 <?php
				 if(!empty($processor_items_array)) {
					$processor_ids = @explode(",",$dependency_item['processor']);
					foreach($processor_items_array as $processor_item) {
						$processor_id = $processor_item['id']; ?>
						append_data+='<option value="<?=$processor_id?>"><?=html_entities($processor_item['processor_name'])?></option>';
					<?php
					}
				 } ?>
				 append_data+='</select>';

				 append_data+='<select class="select2" name="ram_ids['+random_number+'][]" id="ram_ids['+random_number+'][]" multiple="multiple">';
				 <?php
				 if(!empty($ram_items_array)) {
					$ram_ids = @explode(",",$dependency_item['ram']);
					foreach($ram_items_array as $ram_item) {
						$ram_id = $ram_item['id']; ?>
						append_data+='<option value="<?=$ram_id?>"><?=html_entities($ram_item['ram_size'])?><?=html_entities($ram_item['ram_size_postfix'])?></option>';
					<?php
					}
				 } ?>
				 append_data+='</select>';

				 append_data+='<select class="select2" name="screen_resolution_ids['+random_number+'][]" id="screen_resolution_ids['+random_number+'][]" multiple="multiple">';
				 <?php
				 if(!empty($screen_resolution_items_array)) {
					$screen_resolution_ids = @explode(",",$dependency_item['screen_resolution']);
					foreach($screen_resolution_items_array as $screen_resolution_item) {
						$screen_resolution_id = $screen_resolution_item['id']; ?>
						append_data+='<option value="<?=$screen_resolution_id?>"><?=html_entities($screen_resolution_item['screen_resolution_name'])?></option>';
					<?php
					}
				 } ?>
				 append_data+='</select>';


				 append_data+='<select class="select2" name="screen_size_ids['+random_number+'][]" id="screen_size_ids['+random_number+'][]" multiple="multiple">';
				 <?php
				 if(!empty($screen_size_items_array)) {
					$screen_size_ids = @explode(",",$dependency_item['screen_size']);
					foreach($screen_size_items_array as $screen_size_item) {
						$screen_size_id = $screen_resolution_item['id']; ?>
						append_data+='<option value="<?=$screen_size_id?>"><?=html_entities($screen_size_item['screen_size_name'])?></option>';
					<?php
					}
				 } ?>
				 append_data+='</select>';

				 append_data+='<select class="select2" name="lyear_ids['+random_number+'][]" id="lyear_ids['+random_number+'][]" multiple="multiple">';
				 <?php
				 if(!empty($lyear_items_array)) {
					$lyear_ids = @explode(",",$dependency_item['lyear']);
					foreach($lyear_items_array as $lyear_item) {
						$lyear_id = $lyear_item['id']; ?>
						append_data+='<option value="<?=$lyear_id?>"><?=html_entities($lyear_item['lyear_name'])?></option>';
					<?php
					}
				 } ?>
				 append_data+='</select>';

				 append_data+='<select class="select2" name="accessories_ids['+random_number+'][]" id="accessories_ids['+random_number+'][]" multiple="multiple">';
				 <?php
				 if(!empty($accessories_items_array)) {
					$accessories_ids = @explode(",",$dependency_item['accessories']);
					foreach($accessories_items_array as $accessory_item) {
						$accessory_id = $accessory_item['id']; ?>
						append_data+='<option value="<?=$accessory_id?>"><?=html_entities($accessory_item['accessories_name'])?></option>';
					<?php
					}
				 } ?>
				 append_data+='</select>';

				 append_data+='<select class="select2" name="color_ids['+random_number+'][]" id="color_ids['+random_number+'][]" multiple="multiple">';
				 <?php
				 if(!empty($color_items_array)) {
					$color_ids = @explode(",",$dependency_item['color']);
					foreach($color_items_array as $color_item) {
						$color_id = $color_item['id']; ?>
						append_data+='<option value="<?=$color_id?>"><?=html_entities($color_item['color_name'])?></option>';
					<?php
					}
				 } ?>
				 append_data+='</select>';

				 append_data+='<select class="select2" name="conditions_ids['+random_number+'][]" id="conditions_ids['+random_number+'][]" multiple="multiple">';
				 <?php
				 if(!empty($condition_items_array)) {
					$conditions_ids = @explode(",",$dependency_item['conditions']);
					foreach($condition_items_array as $conditions_item) {
						$conditions_id = $conditions_item['id']; ?>
						append_data+='<option value="<?=$conditions_id?>"><?=html_entities($conditions_item['condition_name'])?></option>';
					<?php
					}
				 } ?>
				 append_data+='</select>';

				 append_data+='<select class="select2" name="networks_ids['+random_number+'][]" id="networks_ids['+random_number+'][]" multiple="multiple">';
				 <?php
				 if(!empty($network_items_array)) {
					$networks_ids = @explode(",",$dependency_item['networks']);
					foreach($network_items_array as $networks_item) {
						$networks_id = $networks_item['id']; ?>
						append_data+='<option value="<?=$networks_id?>"><?=html_entities($networks_item['network_name'])?></option>';
					<?php
					}
				 } ?>
				 append_data+='</select>';

				 append_data+='<select class="select2" name="storage_ids['+random_number+'][]" id="storage_ids['+random_number+'][]" multiple="multiple">';
				 <?php
				 if(!empty($storage_items_array)) {
					$storage_ids = @explode(",",$dependency_item['storage']);
					foreach($storage_items_array as $storage_item) {
						$storage_id = $storage_item['id']; ?>
						append_data+='<option value="<?=$storage_id?>"><?=html_entities($storage_item['storage_size'])?><?=html_entities($storage_item['storage_size_postfix'])?></option>';
					<?php
					}
				 } ?>
				 append_data+='</select>';
			 
			 append_data+='&nbsp;<a href="javascript:void(0);" class="remove_depen_item" id="depenrm_'+uniqueId[1]+'"><i class="icon-remove-sign"></i></a>';
			 append_data+='</div>';
		 append_data+='</div>';
		$('#add_depen_item').append(append_data);
		remove_depen_item();
		$(".select2").select2();
	});
	// ==========

	
});

function remove_storage_item() {
	$(".remove_storage_item").on("click", function(e) {
		var uniqueId = $(this).attr('id').toString().split('_');
		$('#'+uniqueId[1]).remove();
	});
}

function remove_condition_item() {
	$(".remove_condition_item").on( "click", function(e) {
		var uniqueId = $(this).attr('id').toString().split('_');
		$('#'+uniqueId[1]).remove();
	});
}

function remove_network_item() {
	$(".remove_network_item").on( "click", function(e) {
		var uniqueId = $(this).attr('id').toString().split('_');
		$('#'+uniqueId[1]).remove();
	});
}

function remove_connectivity_item() {
	$(".remove_connectivity_item").on("click", function(e) {
		var uniqueId = $(this).attr('id').toString().split('_');
		$('#'+uniqueId[1]).remove();
	});
}

function remove_watchtype_item() {
	$(".remove_watchtype_item").on("click", function(e) {
		var uniqueId = $(this).attr('id').toString().split('_');
		$('#'+uniqueId[1]).remove();
	});
}

function remove_case_material_item() {
	$(".remove_case_material_item").on("click", function(e) {
		var uniqueId = $(this).attr('id').toString().split('_');
		$('#'+uniqueId[1]).remove();
	});
}

function remove_case_size_item() {
	$(".remove_case_size_item").on("click", function(e) {
		var uniqueId = $(this).attr('id').toString().split('_');
		$('#'+uniqueId[1]).remove();
	});
}

function remove_color_item() {
	$(".remove_color_item").on("click", function(e) {
		var uniqueId = $(this).attr('id').toString().split('_');
		$('#'+uniqueId[1]).remove();
	});
}

function remove_accessories_item() {
	$(".remove_accessories_item").on("click", function(e) {
		var uniqueId = $(this).attr('id').toString().split('_');
		$('#'+uniqueId[1]).remove();
	});
}

function remove_screen_size_item() {
	$(".remove_screen_size_item").on("click", function(e) {
		var uniqueId = $(this).attr('id').toString().split('_');
		$('#'+uniqueId[1]).remove();
	});
}

function remove_screen_resolution_item() {
	$(".remove_screen_resolution_item").on("click", function(e) {
		var uniqueId = $(this).attr('id').toString().split('_');
		$('#'+uniqueId[1]).remove();
	});
}

function remove_lyear_item() {
	$(".remove_lyear_item").on("click", function(e) {
		var uniqueId = $(this).attr('id').toString().split('_');
		$('#'+uniqueId[1]).remove();
	});
}

function remove_processor_item() {
	$(".remove_processor_item").on("click", function(e) {
		var uniqueId = $(this).attr('id').toString().split('_');
		$('#'+uniqueId[1]).remove();
	});
}

function remove_ram_item() {
	$(".remove_ram_item").on("click", function(e) {
		var uniqueId = $(this).attr('id').toString().split('_');
		$('#'+uniqueId[1]).remove();
	});
}


function remove_depen_item() {
	$(".remove_depen_item").on("click", function(e) {
		//alert();
		var uniqueId = $(this).attr('id').toString().split('_');
		console.log(uniqueId)
		$('#depen'+uniqueId[1]).remove();
	});
}
</script>

<?php
$fields_cat_type = $mobile_data['fields_type']; ?>

<div id="wrapper">
    <header id="header" class="container">
    	<?php include("include/admin_menu.php"); ?>
    </header>

	<section class="container" role="main">
		<div class="row">
            <article class="span12 data-block">
				<header><h2><?=($id?'Edit Mobile Model':'Add Mobile Model')?></h2></header>
                <section class="tab-content">
					<?php include('confirm_message.php');?>
					<form role="form" action="controllers/mobile.php" class="form-inline no-margin" method="post" onSubmit="return check_form(this);" enctype="multipart/form-data">
					<div class="tab-pane active">
						<!-- Second level tabs -->
						<div class="tabbable tabs-left">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#tab1" data-toggle="tab">Basic</a></li>
								<li><a href="#tab8" data-toggle="tab">Metadata</a></li>
								<?php
								if($fields_cat_type == "mobile") { ?>
									<li><a href="#tab4" data-toggle="tab">Network</a></li>
									<li><a href="#tab2" data-toggle="tab">Storage</a></li>
									<li><a href="#tab11" data-toggle="tab">Color</a></li>
									<li><a href="#tab3" data-toggle="tab">Condition</a></li>
									<li><a href="#tab12" data-toggle="tab">Accessories</a></li>
								<?php
								}
								if($fields_cat_type == "tablet") { ?>
									<li><a href="#tab7" data-toggle="tab">Type</a></li>
									<li><a href="#tab4" data-toggle="tab">Network</a></li>
									<li><a href="#tab2" data-toggle="tab">Storage</a></li>
									<li><a href="#tab11" data-toggle="tab">Color</a></li>
									<li><a href="#tab3" data-toggle="tab">Condition</a></li>
									<li><a href="#tab12" data-toggle="tab">Accessories</a></li>
								<?php
								}
								if($fields_cat_type == "watch") { ?>
									<li><a href="#tab7" data-toggle="tab">Type</a></li>
									<li><a href="#tab4" data-toggle="tab">Network</a></li>
									<li><a href="#tab2" data-toggle="tab">Storage</a></li>
									<li><a href="#tab10" data-toggle="tab">Case Material</a></li>
									<li><a href="#tab6" data-toggle="tab">Case Size</a></li>
									<li><a href="#tab11" data-toggle="tab">Color</a></li>
									<li><a href="#tab3" data-toggle="tab">Condition</a></li>
									<li><a href="#tab12" data-toggle="tab">Accessories</a></li>
								<?php
								}
								if($fields_cat_type == "laptop") { ?>
									<li><a href="#tab7" data-toggle="tab">Type</a></li>
									<li><a href="#tab4" data-toggle="tab">Network</a></li>
									<li><a href="#tab13" data-toggle="tab">Screen Size</a></li>
									<li><a href="#tab14" data-toggle="tab">Screen Resolution</a></li>
									<li><a href="#tab15" data-toggle="tab">Year</a></li>
									<li><a href="#tab16" data-toggle="tab">Processor</a></li>
									<li><a href="#tab2" data-toggle="tab">Storage</a></li>
									<li><a href="#tab17" data-toggle="tab">Ram (Memory)</a></li>
									<li><a href="#tab11" data-toggle="tab">Color</a></li>
									<li><a href="#tab3" data-toggle="tab">Condition</a></li>
									<li><a href="#tab12" data-toggle="tab">Accessories</a></li>
								<?php
								} ?>
								<li><a href="#tab1000" data-toggle="tab">Dependencies</a></li>
								<?php /*?><li class="fields_tab fields_tab13" <?=($fields_cat_type=="laptop"?'style="display:block;"':'style="display:none;"')?>><a href="#tab13" data-toggle="tab">Screen Size</a></li>
								<li class="fields_tab fields_tab14" <?=($fields_cat_type=="laptop"?'style="display:block;"':'style="display:none;"')?>><a href="#tab14" data-toggle="tab">Screen Resolution</a></li>
								<li class="fields_tab fields_tab15" <?=($fields_cat_type=="laptop"?'style="display:block;"':'style="display:none;"')?>><a href="#tab15" data-toggle="tab">Year</a></li>
								<li class="fields_tab fields_tab16" <?=($fields_cat_type=="laptop"?'style="display:block;"':'style="display:none;"')?>><a href="#tab16" data-toggle="tab">Processor</a></li>
								
								<li class="fields_tab fields_tab1" <?=($fields_cat_type=="mobile"||$fields_cat_type=="tablet"||$fields_cat_type=="laptop"?'style="display:block;"':'style="display:none;"')?>><a href="#tab2" data-toggle="tab">Storage</a></li>
								
								<li class="fields_tab fields_tab17" <?=($fields_cat_type=="laptop"?'style="display:block;"':'style="display:none;"')?>><a href="#tab17" data-toggle="tab">Ram (Memory)</a></li>
								
								<li class="fields_tab fields_tab2" <?=($fields_cat_type=="mobile"||$fields_cat_type=="tablet"||$fields_cat_type=="watch"?'style="display:block;"':'style="display:none;"')?>><a href="#tab3" data-toggle="tab">Condition</a></li>
								<li class="fields_tab fields_tab3" <?=($fields_cat_type=="mobile"?'style="display:block;"':'style="display:none;"')?>><a href="#tab4" data-toggle="tab">Network</a></li>
								<li class="fields_tab fields_tab4" <?=($fields_cat_type=="tablet"?'style="display:block;"':'style="display:none;"')?>><a href="#tab5" data-toggle="tab">Connectivity</a></li>
								<li class="fields_tab fields_tab5" <?=($fields_cat_type=="watch"?'style="display:block;"':'style="display:none;"')?>><a href="#tab7" data-toggle="tab">Type</a></li>
								<li class="fields_tab fields_tab7" <?=($fields_cat_type=="watch"?'style="display:block;"':'style="display:none;"')?>><a href="#tab10" data-toggle="tab">Case Material</a></li>
								<li class="fields_tab fields_tab6" <?=($fields_cat_type=="watch"?'style="display:block;"':'style="display:none;"')?>><a href="#tab6" data-toggle="tab">Case Size</a></li>
								
								<li class="fields_tab fields_tab11" <?=($fields_cat_type=="mobile"?'style="display:block;"':'style="display:none;"')?>><a href="#tab11" data-toggle="tab">Colors</a></li>
								<li class="fields_tab fields_tab12" <?=($fields_cat_type=="mobile"?'style="display:block;"':'style="display:none;"')?>><a href="#tab12" data-toggle="tab">Accessories</a></li><?php */?>
							</ul>
							<div class="tab-content">
								<div class="tab-pane active" id="tab1">
								  <div class="row-fluid">
								  <div class="span7">
				
								    <!--<h3>Basic Fields</h3>-->
									<div class="control-group">
										<label class="control-label" for="input">Select Device</label>
										<div class="controls">
											<select name="device_id" id="device_id">
												<option value=""> - Select - </option>
												<?php
												while($devices_list=mysqli_fetch_assoc($devices_data)) { ?>
													<option value="<?=$devices_list['id']?>" <?php if($devices_list['id']==$mobile_data['device_id']){echo 'selected="selected"';}?>><?=$devices_list['title']?></option>
												<?php
												} ?>
											</select>
										</div>
									</div>

									<div class="control-group">
                                        <label class="control-label" for="input">Select Brand</label>
                                        <div class="controls">
											<select name="brand_id" id="brand_id">
												<option value=""> - Select - </option>
												<?php
												while($brands_list=mysqli_fetch_assoc($brands_data)) { ?>
													<option value="<?=$brands_list['id']?>" <?php if($brands_list['id']==$mobile_data['brand_id']){echo 'selected="selected"';}?>><?=$brands_list['title']?></option>
												<?php
												} ?>
											</select>
                                        </div>
                                    </div>
									
									<div class="control-group">
										<label class="control-label" for="input">Select Category</label>
										<div class="controls">
											<select <?php if(!$id){echo 'name="cat_id" id="cat_id" onchange="get_cat_custom_fields(this.value);"';}else{echo 'disabled="disabled"';}?>>
												<option value=""> - Select - </option>
												<?php
												while($categories_list=mysqli_fetch_assoc($categories_data)) { ?>
													<option value="<?=$categories_list['id']?>" <?php if($categories_list['id']==$mobile_data['cat_id']){echo 'selected="selected"';}?> data-fields-type="<?=$categories_list['fields_type']?>"><?=$categories_list['title']?></option>
												<?php
												} ?>
											</select>
											<?php
											if($id>0) {
												echo '<input type="hidden" name="cat_id" id="cat_id" value="'.$mobile_data['cat_id'].'" />';
											} ?>
										</div>
									</div>
									
									<div class="control-group">
										<label class="control-label" for="input">Title</label>
										<div class="controls">
											<input type="text" class="input-large" id="title" value="<?=html_entities($mobile_data['title'])?>" name="title">
										</div>
									</div>
									
									<div class="control-group">
										<label class="control-label" for="input">Base Price</label>
										<div class="controls">
											<div class="input-prepend input-append">
												<?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
												<input type="number" class="input-small" id="price" value="<?=($mobile_data['price']>0?$mobile_data['price']:'')?>" name="price">
												<?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
											</div>
										</div>
									</div>
											
									<div class="control-group">
										<label class="control-label" for="input">Description</label>
										<div class="controls">
											<textarea class="form-control wysihtml5" name="description" rows="5"><?=$mobile_data['description']?></textarea>
										</div>
									</div>

									<div class="control-group">
										<label class="control-label" for="input">Searchable Words (Comma Separated)</label>
										<div class="controls">
											<textarea class="form-control" name="searchable_words" rows="5" style="width:500px;"><?=$mobile_data['searchable_words']?></textarea>
										</div>
									</div>
									
									<div class="control-group radio-inline">
										<label class="control-label" for="input">Publish</label>
										<div class="controls">
											<label class="radio-custom-inline custom-radio">
												<input type="radio" id="published" name="published" value="1" <?php if(!$id){echo 'checked="checked"';}?> <?=($mobile_data['published']==1?'checked="checked"':'')?>> Yes
											</label>
											<label class="radio-custom-inline ml-10 custom-radio">
												<input type="radio" id="published" name="published" value="0" <?=($mobile_data['published']=='0'?'checked="checked"':'')?>> No
											</label>
										</div>
									</div>
									<div class="form-actions">
										<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button>
										<a href="mobile.php" class="btn btn-alt btn-large btn-black">Back</a>
									</div>
								</div>
                				<div class="span5">
								<?php
								if($top_seller_mode == "model_specific") { ?>
								<div class="control-group">
									<label class="control-label" for="optionsCheckbox">Top Seller</label>
									<div class="controls">
										<label class="checkbox custom-checkbox">
											<input type="checkbox" class="input-large" id="top_seller" value="1" name="top_seller" <?php if($mobile_data['top_seller']=='1'){echo 'checked="checked"';}?>>
										</label>
									</div>
								</div>
								<?php
								} ?>
                  				<div class="control-group">
										<label class="control-label" for="fileInput">Model Picture</label>
										<div class="controls">
											<div class="fileupload fileupload-new" data-provides="fileupload">
                                                <div class="input-append">
                                                    <div class="uneditable-input">
                                                        <i class="icon-file fileupload-exists"></i>
                                                        <span class="fileupload-preview"></span>
                                                    </div>
                                                    <span class="btn btn-alt btn-file">
                                                            <span class="fileupload-new">Select Image</span>
                                                            <span class="fileupload-exists">Change</span>
                                                            <input type="file" class="form-control" id="model_img" name="model_img" onChange="checkFile(this);" accept="image/*">
                                                    </span>
                                                    <a href="javascript:void(0);" class="btn btn-alt btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                </div>
                                            </div>

											<?php
											if($mobile_data['model_img']!="") { ?>
												<div class="fileupload fileupload-new" data-provides="fileupload">
													<div class="fileupload-new thumbnail"><img src="../images/mobile/<?=$mobile_data['model_img']?>" width="200"></div>
													<div class="fileupload-preview fileupload-exists fileupload-large flexible thumbnail"></div>
													<div>
														<a class="btn btn-alt btn-danger" data-dismiss="fileupload" href="controllers/mobile.php?id=<?=$_REQUEST['id']?>&r_img_id=<?=$mobile_data['id']?>" onclick="return confirm('Are you sure to delete this icon?');">Remove</a>
													</div>
												</div>
												<input type="hidden" id="old_image" name="old_image" value="<?=$mobile_data['model_img']?>">
											<?php
											} ?>

										</div>
									</div>
                </div>
              </div>

								</div>
								<div class="tab-pane" id="tab2">
									<!--<h3>Storage</h3>-->
									<h4><?=$mobile_data['storage_title']?></h4>
									<div class="control-group">
										<label class="control-label" for="input">Add Storage</label>
									</div>
									<div class="control-group" id="add_storage_item">
										<div class="form-controls">
										<?php
										if(!empty($storage_items_array)) {
											foreach($storage_items_array as $key=>$storage_item) {
												$storage_id = $storage_item['id']; ?>
												<div id="<?=$key?>" style="margin-top:5px;">
													<input type="text" class="input-small" id="storage_size[<?=$storage_id?>]" name="storage_size[<?=$storage_id?>]" value="<?=html_entities($storage_item['storage_size'])?>" placeholder="Storage Sizes">
													<select class="span2" name="storage_size_postfix[<?=$storage_id?>]" id="storage_size_postfix[<?=$storage_id?>]" style="width:70px;">
														<option value="GB" <?php if($storage_item['storage_size_postfix']=='GB'){echo 'selected="selected"';}?>>GB</option>
														<option value="TB" <?php if($storage_item['storage_size_postfix']=='TB'){echo 'selected="selected"';}?>>TB</option>
														<option value="MB" <?php if($storage_item['storage_size_postfix']=='MB'){echo 'selected="selected"';}?>>MB</option>
													</select>
													
													<div class="input-prepend input-append">
														<?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
														<input type="number" class="input-small" id="storage_price[<?=$storage_id?>]" name="storage_price[<?=$storage_id?>]" value="<?=$storage_item['storage_price']?>" placeholder="Price">
														<?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
													</div>
															
													<?php
													if($top_seller_mode == "storage_specific") { ?>
													<select class="span2" name="top_seller[<?=$storage_id?>]" id="top_seller[<?=$storage_id?>]" style="width:100px;">
														<option value=""> - Top Seller - </option>
														<option value="1" <?php if($storage_item['top_seller']=='1'){echo 'selected="selected"';}?>>ON</option>
														<option value="0" <?php if($storage_item['top_seller']=='0'){echo 'selected="selected"';}?>>OFF</option>
													</select>
													<?php
													} ?>
													
													<a href="javascript:void(0);" class="remove_storage_item" id="rm_<?=$key?>"><i class="icon-remove-sign"></i></a>
												</div>
												<script>remove_storage_item();</script>
											<?php
											}
										} ?>
										</div>
									</div>
									<div class="control-group">
										<div class="controls">
											 <a id="storage_plus_icon" class="btn btn-info btn-alt"><i class="icon-plus"></i> Add</a>
										</div>
									</div>
									<div class="form-actions">
										<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="mobile.php" class="btn btn-alt btn-large btn-black">Back</a>
									</div>
								</div>
								<div class="tab-pane" id="tab3">
									<!--<h3>Condition</h3>-->
									<h4><?=$mobile_data['condition_title']?></h4>
									<div class="control-group">
										<label class="control-label" for="input">Add Conditions</label>
									</div>
									<div class="control-group condition-fields" id="add_condition_item">
										<?php
										if(!empty($condition_items_array)) {
											foreach($condition_items_array as $c_key=>$condition_data) {
												$condition_id = $condition_data['id']; ?>

												<div class="row" id="cnd<?=$c_key?>" style="margin-top:5px;">
													<div class="span1.5">
														<div class="control-group">
															<label class="control-label" for="input">Name</label>
															<div class="controls">
																 <input type="text" class="input-small" id="condition_name[<?=$condition_id?>]" name="condition_name[<?=$condition_id?>]" value="<?=html_entities($condition_data['condition_name'])?>" placeholder="Name">
															</div>
														</div>
													</div>
													<div class="span1.5">
														<div class="control-group">
															<label class="control-label" for="input">Price</label>
															<div class="controls">
																<div class="input-prepend input-append">
																 <?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
																 <input type="number" class="input-small" id="condition_price[<?=$condition_id?>]" name="condition_price[<?=$condition_id?>]" value="<?=$condition_data['condition_price']?>" placeholder="Price">
																 <?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
																 </div>
															</div>
														</div>
													</div>
													<div class="span5">
														<div class="control-group">
															<label class="control-label" for="input">Terms</label>
															<div class="controls">
																 <textarea class="form-control span5 wysihtml5" name="condition_terms[<?=$condition_id?>]" id="condition_terms[<?=$condition_id?>]" placeholder="Terms"><?=$condition_data['condition_terms']?></textarea>
															</div>
														</div>
													</div>

													<div class="span1">
														<div class="control-group">
															<label class="control-label" for="input">&nbsp;</label>
															<div class="controls">
																<a href="javascript:void(0);" class="remove_condition_item" id="rm_cnd<?=$c_key?>"><i class="icon-remove-sign"></i></a>
															</div>
														</div>
													</div>
												</div>
												<script>remove_condition_item();</script>
											<?php
											}
										} ?>
									</div>
									<div class="control-group">
										<div class="controls">
											 <a id="condition_plus_icon" class="btn btn-info btn-alt"><i class="icon-plus"></i> Add</a>
										</div>
									</div>
									<div class="form-actions">
										<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button>
										<a href="mobile.php" class="btn btn-alt btn-large btn-black">Back</a>
									</div>
								</div>

								<div class="tab-pane" id="tab4">
									<!--<h3>Network</h3>-->
									<h4><?=$mobile_data['network_title']?></h4>
									<div class="control-group">
										<label class="control-label" for="input">Add Networks</label>
									</div>

									<div class="control-group network-fields" id="add_network_item">
										<?php
										if(!empty($network_items_array)) {
										foreach($network_items_array as $n_key=>$network_data) {
											$network_id = $network_data['id']; ?>
											<div class="row" id="nvk<?=$n_key?>">
												<div class="span1.5">
													<div class="control-group">
														<label class="control-label" for="input">Name</label>
														<div class="controls">
															 <input type="text" class="input-medium" id="network_name[<?=$network_id?>]" name="network_name[<?=$network_id?>]" value="<?=html_entities($network_data['network_name'])?>" placeholder="Name">
														</div>
													</div>
												</div>
												<div class="span1.5">
													<div class="control-group">
														<label class="control-label" for="input">Price</label>
														<div class="controls">
															<div class="input-prepend input-append">
															 <?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
															 <input type="number" class="input-small" id="network_price[<?=$network_id?>]" name="network_price[<?=$network_id?>]" value="<?=$network_data['network_price']?>" style="width:50px;" placeholder="Price">
															 <?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
															</div>
														</div>
													</div>
												</div>
												<div class="span1.5">
													<div class="control-group">
														<label class="control-label" for="input">Unlock Price</label>
														<div class="controls">
															<div class="input-prepend input-append">
															 <?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
															 <input type="number" class="input-small" id="network_unlock_price[<?=$network_id?>]" name="network_unlock_price[<?=$network_id?>]" value="<?=$network_data['network_unlock_price']?>" style="width:50px;" placeholder="Price">
															 <?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
															</div>
														</div>
													</div>
												</div>
												<div class="span1.5">
													<div class="control-group">
														<label class="control-label" for="input">Icon</label>
														<div class="controls">
															 <input type="file" name="network_icon[<?=$network_id?>]" id="network_icon[<?=$network_id?>]" style="width:95px;"/>
															 <input type="hidden" name="old_network_icon[<?=$network_id?>]" id="old_network_icon[<?=$network_id?>]" value="<?=$network_data['network_icon']?>"/>
															  <?php
															  if($network_data['network_icon']) { ?>
																  <img src="../images/network/<?=$network_data['network_icon']?>" width="25" height="25"/>
															  <?php
															  } ?>

															 <a href="javascript:void(0);" class="remove_network_item" id="rm_nvk<?=$n_key?>"><i class="icon-remove-sign"></i></a>
														</div>
													</div>
												</div>
											</div>
											<script>remove_network_item();</script>
										<?php
										}
										} ?>
									</div>
									<div class="control-group">
										<div class="controls">
											 <a id="network_plus_icon" class="btn btn-info btn-alt"><i class="icon-plus"></i> Add</a>
										</div>
									</div>
									<div class="form-actions">
										<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button>
										<a href="mobile.php" class="btn btn-alt btn-large btn-black">Back</a>
									</div>

								</div>

								<div class="tab-pane" id="tab5">
									<div class="row-fluid">
										<div class="span8">
											<!--<h3>Connectivity Fields</h3>-->
											<h4><?=$mobile_data['connectivity_title']?></h4>
											<div class="control-group">
												<label class="control-label" for="input">Add Connectivity</label>
											</div>
											<div class="control-group" id="add_connectivity_item">
												<div class="form-controls">
												<?php
												if(!empty($connectivity_items_array)) {
													foreach($connectivity_items_array as $key=>$connectivity_item) {
														$connectivity_id = $connectivity_item['id']; ?>
														<div id="clr<?=$key?>" style="margin-top:5px;">
															<input type="text" class="input-large" id="connectivity_name[<?=$connectivity_id?>]" name="connectivity_name[<?=$connectivity_id?>]" value="<?=$connectivity_item['connectivity_name']?>" placeholder="Name">
															<div class="input-prepend input-append">
																<?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
																<input type="number" class="input-small" id="connectivity_price[<?=$connectivity_id?>]" name="connectivity_price[<?=$connectivity_id?>]" value="<?=$connectivity_item['connectivity_price']?>" placeholder="Price">
																<?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
															</div>
															<a href="javascript:void(0);" class="remove_connectivity_item" id="rm_clr<?=$key?>"><i class="icon-remove-sign"></i></a>
														</div>
														<script>remove_connectivity_item();</script>
													<?php
													}
												} ?>
												</div>
											</div>
											<div class="control-group">
												<div class="controls">
													 <a id="connectivity_plus_icon" class="btn btn-info btn-alt"><i class="icon-plus"></i> Add</a>
												</div>
											</div>
											<div class="form-actions">
												<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="mobile.php" class="btn btn-alt btn-large btn-black">Back</a>
											</div>
										</div>
									</div>
								</div>
					
								<div class="tab-pane" id="tab6">
									<div class="row-fluid">
										<div class="span8">
											<!--<h3>Case Size Fields</h3>-->
											<h4><?=$mobile_data['case_size_title']?></h4>
											<div class="control-group">
												<label class="control-label" for="input">Add Case Size</label>
											</div>
											<div class="control-group" id="add_case_size_item">
												<div class="form-controls">
												<?php
												if(!empty($case_size_items_array)) {
													foreach($case_size_items_array as $key=>$case_size_item) {
														$case_size_id = $case_size_item['id']; ?>
														<div id="misc<?=$key?>" style="margin-top:5px;">
															<input type="text" class="input-large" id="case_size[<?=$case_size_id?>]" name="case_size[<?=$case_size_id?>]" value="<?=html_entities($case_size_item['case_size'])?>" placeholder="Case Size">
															<div class="input-prepend input-append">
																<?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
																<input type="number" class="input-small" id="case_size_price[<?=$case_size_id?>]" name="case_size_price[<?=$case_size_id?>]" value="<?=$case_size_item['case_size_price']?>" placeholder="Price">
																<?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
															</div>
															<a href="javascript:void(0);" class="remove_case_size_item" id="rm_misc<?=$key?>"><i class="icon-remove-sign"></i></a>
														</div>
														<script>remove_case_size_item();</script>
													<?php
													}
												} ?>
												</div>
											</div>
											<div class="control-group">
												<div class="controls">
													 <a id="case_size_plus_icon" class="btn btn-info btn-alt"><i class="icon-plus"></i> Add</a>
												</div>
											</div>
											<div class="form-actions">
												<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="mobile.php" class="btn btn-alt btn-large btn-black">Back</a>
											</div>
										</div>
									</div>
								</div>
					
								<div class="tab-pane" id="tab7">
									<h4><?=$mobile_data['type_title']?></h4>
									<div class="control-group">
										<label class="control-label" for="input">Add Type</label>
									</div>
									<div class="control-group watchtype-fields" id="add_watchtype_item">
										<div class="form-controls">
										<?php
										if(!empty($watchtype_items_array)) {
											foreach($watchtype_items_array as $key=>$watchtype_item) {
												$watchtype_id = $watchtype_item['id']; ?>
												<div class="row" id="watc<?=$key?>" style="margin-top:5px;">
													<div class="span1.5">
														<div class="control-group">
															<label class="control-label" for="input">&nbsp;</label>
															<div class="controls">
																<input type="text" class="input-large" id="watchtype_name[<?=$watchtype_id?>]" name="watchtype_name[<?=$watchtype_id?>]" value="<?=html_entities($watchtype_item['watchtype_name'])?>" placeholder="Name">
															</div>
														</div>
													</div>
													<div class="span1.5">
														<div class="control-group">
															<label class="control-label" for="input">&nbsp;</label>
															<div class="controls">
																<div class="input-prepend input-append">
																	<?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
																	<input type="number" class="input-small" id="watchtype_price[<?=$watchtype_id?>]" name="watchtype_price[<?=$watchtype_id?>]" value="<?=$watchtype_item['watchtype_price']?>" placeholder="Price">
																	<?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
																</div>
															</div>
														</div>
													</div>
													<div class="span1.5">
														<div class="control-group">
															<label class="control-label" for="input">Network</label>
															<div class="controls">
															
																<select class="span2" name="disabled_network[<?=$watchtype_id?>]" id="disabled_network[<?=$watchtype_id?>]">
																<option value="1" <?php if($watchtype_item['disabled_network']=='1'){echo 'selected="selected"';}?>>Enabled</option>
																<option value="0" <?php if($watchtype_item['disabled_network']=='0'){echo 'selected="selected"';}?>>Disabled</option>
																</select>
															
																<a href="javascript:void(0);" class="remove_watchtype_item" id="rm_watc<?=$key?>"><i class="icon-remove-sign"></i></a>
															</div>
														</div>
													</div>
												</div>
												<script>remove_watchtype_item();</script>
											<?php
											}
										} ?>
										</div>
									</div>
									<div class="control-group">
										<div class="controls">
											 <a id="watchtype_plus_icon" class="btn btn-info btn-alt"><i class="icon-plus"></i> Add</a>
										</div>
									</div>
									<div class="form-actions">
										<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="mobile.php" class="btn btn-alt btn-large btn-black">Back</a>
									</div>
								</div>
								
								<div class="tab-pane" id="tab10">
									<div class="row-fluid">
										<div class="span8">
											<!--<h3>Type Fields</h3>-->
											<h4><?=$mobile_data['case_material_title']?></h4>
											<div class="control-group">
												<label class="control-label" for="input">Add Case Material</label>
											</div>
											<div class="control-group" id="add_case_material_item">
												<div class="form-controls">
												<?php
												if(!empty($case_material_items_array)) {
													foreach($case_material_items_array as $key=>$case_material_item) {
														$case_material_id = $case_material_item['id']; ?>
														<div id="csmt<?=$key?>" style="margin-top:5px;">
															<input type="text" class="input-large" id="case_material_name[<?=$case_material_id?>]" name="case_material_name[<?=$case_material_id?>]" value="<?=html_entities($case_material_item['case_material_name'])?>" placeholder="Name">
															<div class="input-prepend input-append">
																<?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
																<input type="number" class="input-small" id="case_material_price[<?=$case_material_id?>]" name="case_material_price[<?=$case_material_id?>]" value="<?=$case_material_item['case_material_price']?>" placeholder="Price">
																<?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
															</div>
															<a href="javascript:void(0);" class="remove_case_material_item" id="rm_csmt<?=$key?>"><i class="icon-remove-sign"></i></a>
														</div>
														<script>remove_case_material_item();</script>
													<?php
													}
												} ?>
												</div>
											</div>
											<div class="control-group">
												<div class="controls">
													 <a id="case_material_plus_icon" class="btn btn-info btn-alt"><i class="icon-plus"></i> Add</a>
												</div>
											</div>
											<div class="form-actions">
												<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="mobile.php" class="btn btn-alt btn-large btn-black">Back</a>
											</div>
										</div>
									</div>
								</div>

								<div class="tab-pane" id="tab8">
									<h3>Metadata</h3>

									<div class="control-group">
                                        <label class="control-label" for="input">Meta Title</label>
                                        <div class="controls">
											<input type="text" class="input-large" id="meta_title" value="<?=$mobile_data['meta_title']?>" name="meta_title">
                                        </div>
                                    </div>

									<div class="control-group">
                                        <label class="control-label" for="input">Meta Description</label>
                                        <div class="controls">
											<textarea class="form-control" name="meta_desc" rows="4"><?=$mobile_data['meta_desc']?></textarea>
                                        </div>
                                    </div>

									<div class="control-group">
                                        <label class="control-label" for="input">Meta Keywords</label>
                                        <div class="controls">
											<textarea class="form-control" name="meta_keywords" rows="3"><?=$mobile_data['meta_keywords']?></textarea>
                                        </div>
                                    </div>

									<div class="form-actions">
										<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="mobile.php" class="btn btn-alt btn-large btn-black">Back</a>
									</div>
								</div>
								
								<div class="tab-pane" id="tab11">
									<div class="row-fluid">
										<div class="span10">
											<h4><?=$mobile_data['color_title']?></h4>
											<div class="control-group">
												<label class="control-label" for="input">Add Color</label>
											</div>
											<div class="control-group" id="add_color_item">
												<div class="form-controls">
												<?php
												if(!empty($color_items_array)) {
													foreach($color_items_array as $key=>$color_item) {
														$color_id = $color_item['id']; ?>
														<div id="clr<?=$key?>" style="margin-top:5px;">
															<input type="text" class="input-large" id="color_name[<?=$color_id?>]" name="color_name[<?=$color_id?>]" value="<?=html_entities($color_item['color_name'])?>" placeholder="Name">
															<input type="color" class="input-small" id="color_code[<?=$color_id?>]" name="color_code[<?=$color_id?>]" value="<?=html_entities($color_item['color_code'])?>" placeholder="Color Code">
															<div class="input-prepend input-append">
																<?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
																<input type="number" class="input-small" id="color_price[<?=$color_id?>]" name="color_price[<?=$color_id?>]" value="<?=$color_item['color_price']?>" placeholder="Price">
																<?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
															</div>
															
															<select class="select2" name="color_storage_ids[<?=$color_id?>][]" id="color_storage_ids[<?=$color_id?>][]" multiple="multiple">
															<?php
															if(!empty($storage_items_array)) {
																$svd_color_storage_ids = @explode(",",$color_item['storage_ids']);
																foreach($storage_items_array as $storage_item) {
																	$storage_id = $storage_item['id']; ?>
																	<option value="<?=$storage_id?>" <?php if(in_array($storage_id,$svd_color_storage_ids)){echo 'selected="selected"';}?>><?=html_entities($storage_item['storage_size'].$storage_item['storage_size_postfix'])?></option>		
																<?php
																}
															} ?>
															</select>
															
															<a href="javascript:void(0);" class="remove_color_item" id="rm_clr<?=$key?>"><i class="icon-remove-sign"></i></a>
														</div>
														<script>remove_color_item();</script>
													<?php
													}
												} ?>
												</div>
											</div>
											<div class="control-group">
												<div class="controls">
													 <a id="color_plus_icon" class="btn btn-info btn-alt"><i class="icon-plus"></i> Add</a>
												</div>
											</div>
											<div class="form-actions">
												<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="mobile.php" class="btn btn-alt btn-large btn-black">Back</a>
											</div>
										</div>
									</div>
								</div>
								
								<div class="tab-pane" id="tab12">
									<div class="row-fluid">
										<div class="span8">
											<h4><?=$mobile_data['accessories_title']?></h4>
											<div class="control-group">
												<label class="control-label" for="input">Add Accessories</label>
											</div>
											<div class="control-group" id="add_accessories_item">
												<div class="form-controls">
												<?php
												if(!empty($accessories_items_array)) {
													foreach($accessories_items_array as $key=>$accessories_item) {
														$accessories_id = $accessories_item['id']; ?>
														<div id="accssr<?=$key?>" style="margin-top:5px;">
															<input type="text" class="input-large" id="accessories_name[<?=$accessories_id?>]" name="accessories_name[<?=$accessories_id?>]" value="<?=html_entities($accessories_item['accessories_name'])?>" placeholder="Name">
															<div class="input-prepend input-append">
																<?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
																<input type="number" class="input-small" id="accessories_price[<?=$accessories_id?>]" name="accessories_price[<?=$accessories_id?>]" value="<?=$accessories_item['accessories_price']?>" placeholder="Price">

																<?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
															</div>
															<a href="javascript:void(0);" class="remove_accessories_item" id="rm_accssr<?=$key?>"><i class="icon-remove-sign"></i></a>
														</div>
														<script>remove_accessories_item();</script>
													<?php
													}
												} ?>
												</div>
											</div>
											<div class="control-group">
												<div class="controls">
													 <a id="accessories_plus_icon" class="btn btn-info btn-alt"><i class="icon-plus"></i> Add</a>
												</div>
											</div>
											<div class="form-actions">
												<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="mobile.php" class="btn btn-alt btn-large btn-black">Back</a>
											</div>
										</div>
									</div>
								</div>

								
								<div class="tab-pane" id="tab13">
									<div class="row-fluid">
										<div class="span8">
											<h4><?=$mobile_data['screen_size_title']?></h4>
											<div class="control-group">
												<label class="control-label" for="input">Add Screen Size</label>
											</div>
											<div class="control-group" id="add_screen_size_item">
												<div class="form-controls">
												<?php
												if(!empty($screen_size_items_array)) {
													foreach($screen_size_items_array as $key=>$screen_size_item) {
														$screen_size_id = $screen_size_item['id']; ?>
														<div id="scrsz<?=$key?>" style="margin-top:5px;">
															<input type="text" class="input-large" id="screen_size_name[<?=$screen_size_id?>]" name="screen_size_name[<?=$screen_size_id?>]" value="<?=html_entities($screen_size_item['screen_size_name'])?>" placeholder="Screen Size">
															<div class="input-prepend input-append">
																<?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
																<input type="number" class="input-small" id="screen_size_price[<?=$screen_size_id?>]" name="screen_size_price[<?=$screen_size_id?>]" value="<?=$screen_size_item['screen_size_price']?>" placeholder="Price">
																<?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
															</div>
															<a href="javascript:void(0);" class="remove_screen_size_item" id="rm_scrsz<?=$key?>"><i class="icon-remove-sign"></i></a>
														</div>
														<script>remove_screen_size_item();</script>
													<?php
													}
												} ?>
												</div>
											</div>
											<div class="control-group">
												<div class="controls">
													 <a id="screen_size_plus_icon" class="btn btn-info btn-alt"><i class="icon-plus"></i> Add</a>
												</div>
											</div>
											<div class="form-actions">
												<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="mobile.php" class="btn btn-alt btn-large btn-black">Back</a>
											</div>
										</div>
									</div>
								</div>								
								
								<div class="tab-pane" id="tab14">
									<div class="row-fluid">
										<div class="span8">
											<h4><?=$mobile_data['screen_resolution_title']?></h4>
											<div class="control-group">
												<label class="control-label" for="input">Add Screen Resolution</label>
											</div>
											<div class="control-group" id="add_screen_resolution_item">
												<div class="form-controls">
												<?php
												if(!empty($screen_resolution_items_array)) {
													foreach($screen_resolution_items_array as $key=>$screen_resolution_item) {
														$screen_resolution_id = $screen_resolution_item['id']; ?>
														<div id="scrrz<?=$key?>" style="margin-top:5px;">
															<input type="text" class="input-large" id="screen_resolution_name[<?=$screen_resolution_id?>]" name="screen_resolution_name[<?=$screen_resolution_id?>]" value="<?=html_entities($screen_resolution_item['screen_resolution_name'])?>" placeholder="Name">
															<div class="input-prepend input-append">
																<?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
																<input type="number" class="input-small" id="screen_resolution_price[<?=$screen_resolution_id?>]" name="screen_resolution_price[<?=$screen_resolution_id?>]" value="<?=$screen_resolution_item['screen_resolution_price']?>" placeholder="Price">
																<?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
															</div>
															<a href="javascript:void(0);" class="remove_screen_resolution_item" id="rm_scrrz<?=$key?>"><i class="icon-remove-sign"></i></a>
														</div>
														<script>remove_screen_resolution_item();</script>
													<?php
													}
												} ?>
												</div>
											</div>
											<div class="control-group">
												<div class="controls">
													 <a id="screen_resolution_plus_icon" class="btn btn-info btn-alt"><i class="icon-plus"></i> Add</a>
												</div>
											</div>
											<div class="form-actions">
												<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="mobile.php" class="btn btn-alt btn-large btn-black">Back</a>
											</div>
										</div>
									</div>
								</div>

								<div class="tab-pane" id="tab15">
									<div class="row-fluid">
										<div class="span8">
											<h4><?=$mobile_data['lyear_title']?></h4>
											<div class="control-group">
												<label class="control-label" for="input">Add Year</label>
											</div>
											<div class="control-group" id="add_lyear_item">
												<div class="form-controls">
												<?php
												if(!empty($lyear_items_array)) {
													foreach($lyear_items_array as $key=>$lyear_item) {
														$lyear_id = $lyear_item['id']; ?>
														<div id="lyr<?=$key?>" style="margin-top:5px;">
															<input type="text" class="input-large" id="lyear_name[<?=$lyear_id?>]" name="lyear_name[<?=$lyear_id?>]" value="<?=html_entities($lyear_item['lyear_name'])?>" placeholder="Year">
															<div class="input-prepend input-append">
																<?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
																<input type="number" class="input-small" id="lyear_price[<?=$lyear_id?>]" name="lyear_price[<?=$lyear_id?>]" value="<?=$lyear_item['lyear_price']?>" placeholder="Price">
																<?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
															</div>
															<a href="javascript:void(0);" class="remove_lyear_item" id="rm_lyr<?=$key?>"><i class="icon-remove-sign"></i></a>
														</div>
														<script>remove_lyear_item();</script>
													<?php
													}
												} ?>
												</div>
											</div>
											<div class="control-group">
												<div class="controls">
													 <a id="lyear_plus_icon" class="btn btn-info btn-alt"><i class="icon-plus"></i> Add</a>
												</div>
											</div>
											<div class="form-actions">
												<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="mobile.php" class="btn btn-alt btn-large btn-black">Back</a>
											</div>
										</div>
									</div>
								</div>
								
								<div class="tab-pane" id="tab16">
									<div class="row-fluid">
										<div class="span8">
											<h4><?=$mobile_data['processor_title']?></h4>
											<div class="control-group">
												<label class="control-label" for="input">Add Processor</label>
											</div>
											<div class="control-group" id="add_processor_item">
												<div class="form-controls">
												<?php
												if(!empty($processor_items_array)) {
													foreach($processor_items_array as $key=>$processor_item) {
														$processor_id = $processor_item['id']; ?>
														<div id="prcr<?=$key?>" style="margin-top:5px;">
															<input type="text" class="input-large" id="processor_name[<?=$processor_id?>]" name="processor_name[<?=$processor_id?>]" value="<?=html_entities($processor_item['processor_name'])?>" placeholder="Name">
															<div class="input-prepend input-append">
																<?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
																<input type="number" class="input-small" id="processor_price[<?=$processor_id?>]" name="processor_price[<?=$processor_id?>]" value="<?=$processor_item['processor_price']?>" placeholder="Price">
																<?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
															</div>
															<a href="javascript:void(0);" class="remove_processor_item" id="rm_prcr<?=$key?>"><i class="icon-remove-sign"></i></a>
														</div>
														<script>remove_processor_item();</script>
													<?php
													}
												} ?>
												</div>
											</div>
											<div class="control-group">
												<div class="controls">
													 <a id="processor_plus_icon" class="btn btn-info btn-alt"><i class="icon-plus"></i> Add</a>
												</div>
											</div>
											<div class="form-actions">
												<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="mobile.php" class="btn btn-alt btn-large btn-black">Back</a>
											</div>
										</div>
									</div>
								</div>

								<div class="tab-pane" id="tab17">
									<div class="row-fluid">
										<div class="span8">
											<h4><?=$mobile_data['ram_title']?></h4>
											<div class="control-group">
												<label class="control-label" for="input">Add Ram (Memory)</label>
											</div>
											<div class="control-group" id="add_ram_item">
												<div class="form-controls">
												<?php
												if(!empty($ram_items_array)) {
													foreach($ram_items_array as $key=>$ram_item) {
														$ram_id = $ram_item['id']; ?>
														<div id="ram<?=$key?>" style="margin-top:5px;">
															<input type="text" class="input-small" id="ram_size[<?=$ram_id?>]" name="ram_size[<?=$ram_id?>]" value="<?=html_entities($ram_item['ram_size'])?>" placeholder="Storage Sizes">
															<select class="span2" name="ram_size_postfix[<?=$ram_id?>]" id="ram_size_postfix[<?=$ram_id?>]" style="width:70px;">
																<option value="GB" <?php if($ram_item['ram_size_postfix']=='GB'){echo 'selected="selected"';}?>>GB</option>
																<option value="TB" <?php if($ram_item['ram_size_postfix']=='TB'){echo 'selected="selected"';}?>>TB</option>
																<option value="MB" <?php if($ram_item['ram_size_postfix']=='MB'){echo 'selected="selected"';}?>>MB</option>
															</select>
															<div class="input-prepend input-append">
																<?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
																<input type="number" class="input-small" id="ram_price[<?=$ram_id?>]" name="ram_price[<?=$ram_id?>]" value="<?=$ram_item['ram_price']?>" placeholder="Price">
																<?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
															</div>
															<a href="javascript:void(0);" class="remove_ram_item" id="rm_ram<?=$key?>"><i class="icon-remove-sign"></i></a>
														</div>
														<script>remove_ram_item();</script>
													<?php
													}
												} ?>
												</div>
											</div>
											<div class="control-group">
												<div class="controls">
													 <a id="ram_plus_icon" class="btn btn-info btn-alt"><i class="icon-plus"></i> Add</a>
												</div>
											</div>
											<div class="form-actions">
												<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="mobile.php" class="btn btn-alt btn-large btn-black">Back</a>
											</div>
										</div>
									</div>
								</div>
								
								<!-- dependencies edit section -->
								<!-- developed by maxkyu: date 2019.8.14 -->
								<style type="text/css">
									#tab1000 span.select2 {width: 100px !important}
									#tab1000 ul.dependency_header {list-style-type: none; margin: 0;padding: 0;overflow: hidden;}
									#tab1000 ul.dependency_header li {float: left;    width: 100px;text-align: center;}
								</style>
								<?php
								if($fields_cat_type == "mobile") { ?>
												
												<div class="tab-pane" id="tab1000">
													<div class="row-fluid">
														<div >
															<h4>Dependencies</h4>
															<div class="control-group">
																<label class="control-label" for="input">Add dependency</label>
															</div>
															<div class="control-group" id="add_depen_item">
																<div class="form-controls">
																	<div>
																		<ul class="dependency_header">
																			<li>Accessories</li>
																			<li>Color</li>
																			<li>Condition</li>
																			<li>Network</li>
																			<li>Storage</li>
																		</ul>
																	</div>
																	<input type="hidden" name="depen_form" value="mobile">
																	<?php
																	if(!empty($dependencies_array)) {
																		foreach($dependencies_array as $key=>$dependency_item) {
																			$dependency_id = $dependency_item['id']; ?>
																			<div id="depen<?=$key?>" style="margin-top:5px;">
																				<input type="hidden" name="depenkey[<?php echo $dependency_id?>]" value="<?php echo $dependency_id?>">
																				<!-- Accessories -->
																				<select class="select2" name="accessories_ids[<?=$dependency_id?>][]" id="accessories_ids[<?=$dependency_id?>][]" multiple="multiple">
																					<?php
																					if(!empty($accessories_items_array)) {
																						$accessories_ids = @explode(",",$dependency_item['accessories']);
																						foreach($accessories_items_array as $accessory_item) {
																							$accessory_id = $accessory_item['id']; ?>
																							<option value="<?=$accessory_id?>" <?php if(in_array($accessory_id,$accessories_ids)){echo 'selected="selected"';}?>><?=html_entities($accessory_item['accessories_name'])?></option>		
																						<?php
																						}
																					} ?>
																				</select>
																				<!-- Colors -->
																				<select class="select2" name="color_ids[<?=$dependency_id?>][]" id="color_ids[<?=$dependency_id?>][]" multiple="multiple">
																					<?php
																					if(!empty($color_items_array)) {
																						$color_ids = @explode(",",$dependency_item['color']);
																						foreach($color_items_array as $color_item) {
																							$color_id = $color_item['id']; ?>
																							<option value="<?=$color_id?>" <?php if(in_array($color_id,$color_ids)){echo 'selected="selected"';}?>><?=html_entities($color_item['color_name'])?></option>		
																						<?php
																						}
																					} ?>
																				</select>
																				<!-- Condition -->
																				<select class="select2" name="conditions_ids[<?=$dependency_id?>][]" id="conditions_ids[<?=$dependency_id?>][]" multiple="multiple">
																					<?php
																					if(!empty($condition_items_array)) {
																						$conditions_ids = @explode(",",$dependency_item['conditions']);
																						foreach($condition_items_array as $conditions_item) {
																							$conditions_id = $conditions_item['id']; ?>
																							<option value="<?=$conditions_id?>" <?php if(in_array($conditions_id,$conditions_ids)){echo 'selected="selected"';}?>><?=html_entities($conditions_item['condition_name'])?></option>		
																						<?php
																						}
																					} ?>
																				</select>	
																				<!-- Network -->	
																				<select class="select2" name="networks_ids[<?=$dependency_id?>][]" id="networks_ids[<?=$dependency_id?>][]" multiple="multiple">
																					<?php
																					if(!empty($network_items_array)) {
																						$networks_ids = @explode(",",$dependency_item['networks']);
																						foreach($network_items_array as $networks_item) {
																							$networks_id = $networks_item['id']; ?>
																							<option value="<?=$networks_id?>" <?php if(in_array($networks_id,$networks_ids)){echo 'selected="selected"';}?>><?=html_entities($networks_item['network_name'])?></option>		
																						<?php
																						}
																					} ?>
																				</select>
																			
																				<!-- Storage -->
																				<select class="select2" name="storage_ids[<?=$dependency_id?>][]" id="storage_ids[<?=$dependency_id?>][]" multiple="multiple">
																					<?php
																					if(!empty($storage_items_array)) {
																						$storage_ids = @explode(",",$dependency_item['storage']);
																						foreach($storage_items_array as $storage_item) {
																							$storage_id = $storage_item['id']; ?>
																							<option value="<?=$storage_id?>" <?php if(in_array($storage_id,$storage_ids)){echo 'selected="selected"';}?>><?=html_entities($storage_item['storage_size'])?><?=html_entities($storage_item['storage_size_postfix'])?></option>		
																						<?php
																						}
																					} ?>
																				</select>


																				<a href="javascript:void(0);" class="remove_depen_item" id="depenrm_<?=$key?>"><i class="icon-remove-sign"></i></a>
																			</div>
																			<script>remove_depen_item();</script>
																		<?php
																		}
																	} ?>

																</div>
															</div>
															<div class="control-group">
																<div class="controls">
																	 <a id="mobile_depen_plus_icon" class="btn btn-info btn-alt"><i class="icon-plus"></i> Add</a>
																</div>
															</div>
															<div class="form-actions">
																<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="mobile.php" class="btn btn-alt btn-large btn-black">Back</a>
															</div>
														</div>
													</div>
												</div>
								<?php
								}
								if($fields_cat_type == "tablet") { ?>
												<div class="tab-pane" id="tab1000">
													<div class="row-fluid">
														<div >
															<h4>Dependencies</h4>
															<div class="control-group">
																<label class="control-label" for="input">Add dependency</label>
															</div>
															<div class="control-group" id="add_depen_item">
																<div class="form-controls">
																	<div>
																		<ul class="dependency_header">
																			<li>WatchType</li>
																			<li>Accessories</li>
													
																			<li>Colors</li>
																			<li>Condition</li>
																			<li>Network</li>
																			<li>Storage</li>
																		</ul>
																	</div>
																	<input type="hidden" name="depen_form" value="tablet">
																	<?php
																	if(!empty($dependencies_array)) {
																		foreach($dependencies_array as $key=>$dependency_item) {
																			$dependency_id = $dependency_item['id']; ?>
																			<div id="depen<?=$key?>" style="margin-top:5px;">
																				<input type="hidden" name="depenkey[<?php echo $dependency_id?>]" value="<?php echo $dependency_id?>">
																				<!-- WatchType -->
																				<select class="select2" name="watchtype_ids[<?=$dependency_id?>][]" id="watchtype_ids[<?=$dependency_id?>][]" multiple="multiple">
																					<?php
																					if(!empty($watchtype_items_array)) {
																						$watchtype_ids = @explode(",",$dependency_item['watchtype']);
																						foreach($watchtype_items_array as $watchtype_item) {
																							$watchtype_id = $watchtype_item['id']; ?>
																							<option value="<?=$watchtype_id?>" <?php if(in_array($watchtype_id,$watchtype_ids)){echo 'selected="selected"';}?>><?=html_entities($watchtype_item['watchtype_name'])?></option>		
																						<?php
																						}
																					} ?>
																				</select>

																				<!-- Accessories -->
																				<select class="select2" name="accessories_ids[<?=$dependency_id?>][]" id="accessories_ids[<?=$dependency_id?>][]" multiple="multiple">
																					<?php
																					if(!empty($accessories_items_array)) {
																						$accessories_ids = @explode(",",$dependency_item['accessories']);
																						foreach($accessories_items_array as $accessory_item) {
																							$accessory_id = $accessory_item['id']; ?>
																							<option value="<?=$accessory_id?>" <?php if(in_array($accessory_id,$accessories_ids)){echo 'selected="selected"';}?>><?=html_entities($accessory_item['accessories_name'])?></option>		
																						<?php
																						}
																					} ?>
																				</select>
																				<!-- Colors -->
																				<select class="select2" name="color_ids[<?=$dependency_id?>][]" id="color_ids[<?=$dependency_id?>][]" multiple="multiple">
																					<?php
																					if(!empty($color_items_array)) {
																						$color_ids = @explode(",",$dependency_item['color']);
																						foreach($color_items_array as $color_item) {
																							$color_id = $color_item['id']; ?>
																							<option value="<?=$color_id?>" <?php if(in_array($color_id,$color_ids)){echo 'selected="selected"';}?>><?=html_entities($color_item['color_name'])?></option>		
																						<?php
																						}
																					} ?>
																				</select>
																				<!-- Condition -->
																				<select class="select2" name="conditions_ids[<?=$dependency_id?>][]" id="conditions_ids[<?=$dependency_id?>][]" multiple="multiple">
																					<?php
																					if(!empty($condition_items_array)) {
																						$conditions_ids = @explode(",",$dependency_item['conditions']);
																						foreach($condition_items_array as $conditions_item) {
																							$conditions_id = $conditions_item['id']; ?>
																							<option value="<?=$conditions_id?>" <?php if(in_array($conditions_id,$conditions_ids)){echo 'selected="selected"';}?>><?=html_entities($conditions_item['condition_name'])?></option>		
																						<?php
																						}
																					} ?>
																				</select>	
																				<!-- Network -->	
																				<select class="select2" name="networks_ids[<?=$dependency_id?>][]" id="networks_ids[<?=$dependency_id?>][]" multiple="multiple">
																					<?php
																					if(!empty($network_items_array)) {
																						$networks_ids = @explode(",",$dependency_item['networks']);
																						foreach($network_items_array as $networks_item) {
																							$networks_id = $networks_item['id']; ?>
																							<option value="<?=$networks_id?>" <?php if(in_array($networks_id,$networks_ids)){echo 'selected="selected"';}?>><?=html_entities($networks_item['network_name'])?></option>		
																						<?php
																						}
																					} ?>
																				</select>
																			
																				<!-- Storage -->
																				<select class="select2" name="storage_ids[<?=$dependency_id?>][]" id="storage_ids[<?=$dependency_id?>][]" multiple="multiple">
																					<?php
																					if(!empty($storage_items_array)) {
																						$storage_ids = @explode(",",$dependency_item['storage']);
																						foreach($storage_items_array as $storage_item) {
																							$storage_id = $storage_item['id']; ?>
																							<option value="<?=$storage_id?>" <?php if(in_array($storage_id,$storage_ids)){echo 'selected="selected"';}?>><?=html_entities($storage_item['storage_size'])?><?=html_entities($storage_item['storage_size_postfix'])?></option>		
																						<?php
																						}
																					} ?>
																				</select>


																				<a href="javascript:void(0);" class="remove_depen_item" id="depenrm_<?=$key?>"><i class="icon-remove-sign"></i></a>
																			</div>
																			<script>remove_depen_item();</script>
																		<?php
																		}
																	} ?>
																</div>
															</div>
															<div class="control-group">
																<div class="controls">
																	 <a id="tablet_depen_plus_icon" class="btn btn-info btn-alt"><i class="icon-plus"></i> Add</a>
																</div>
															</div>
															<div class="form-actions">
																<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="mobile.php" class="btn btn-alt btn-large btn-black">Back</a>
															</div>
														</div>
													</div>
												</div>
								<?php
								}
								if($fields_cat_type == "watch") { ?>
						
												<div class="tab-pane" id="tab1000">
													<div class="row-fluid">
														<div >
															<h4>Dependencies</h4>
															<div class="control-group">
																<label class="control-label" for="input">Add dependency</label>
															</div>
															<div class="control-group" id="add_depen_item">
																<div class="form-controls">
																	<ul class="dependency_header">
																			<li>Case Material</li>
																			<li>Case Size</li>
																			<li>WatchType</li>
																			<li>Accessories</li>
																			<li>Colors</li>
																			<li>Condition</li>
																			<li>Network</li>
																			<li>Storage</li>
																	</ul>
																	<input type="hidden" name="depen_form" value="watch">
																	<?php
																	if(!empty($dependencies_array)) {

																		foreach($dependencies_array as $key=>$dependency_item) {
																			$dependency_id = $dependency_item['id']; ?>
																			<div id="depen<?=$key?>" style="margin-top:5px;">
																				
																				<input type="hidden" name="depenkey[<?php echo $dependency_id?>]" value="<?php echo $dependency_id?>">
																				<!-- Case Material -->
																				<select class="select2" name="case_material[<?=$dependency_id?>][]" id="case_material_ids[<?=$dependency_id?>][]" multiple="multiple">
																					<?php
																					if(!empty($case_material_items_array)) {
																						$case_material_ids = @explode(",",$dependency_item['case_material']);
																						foreach($case_material_items_array as $case_material_item) {
																							$case_material_id = $case_material_item['id']; ?>
																							<option value="<?=$case_material_id?>" <?php if(in_array($case_material_id,$case_material_ids)){echo 'selected="selected"';}?>><?=html_entities($case_material_item['case_material_name'])?></option>		
																						<?php
																						}
																					} ?>
																				</select>
																				<!-- Case Size -->
																				<select class="select2" name="case_size_ids[<?=$dependency_id?>][]" id="case_size_ids[<?=$dependency_id?>][]" multiple="multiple">
																					<?php
																					if(!empty($case_size_items_array)) {
																						$case_size_ids = @explode(",",$dependency_item['case_size']);
																						foreach($case_size_items_array as $case_size_item) {
																							$case_size_id = $case_size_item['id']; ?>
																							<option value="<?=$case_size_id?>" <?php if(in_array($case_size_id,$case_size_ids)){echo 'selected="selected"';}?>><?=html_entities($case_size_item['case_size'])?></option>		
																						<?php
																						}
																					} ?>
																				</select>
																				<!-- WatchType -->
																				<select class="select2" name="watchtype_ids[<?=$dependency_id?>][]" id="watchtype_ids[<?=$dependency_id?>][]" multiple="multiple">
																					<?php
																					if(!empty($watchtype_items_array)) {
																						$watchtype_ids = @explode(",",$dependency_item['watchtype']);
																						foreach($watchtype_items_array as $watchtype_item) {
																							$watchtype_id = $watchtype_item['id']; ?>
																							<option value="<?=$watchtype_id?>" <?php if(in_array($watchtype_id,$watchtype_ids)){echo 'selected="selected"';}?>><?=html_entities($watchtype_item['watchtype_name'])?></option>		
																						<?php
																						}
																					} ?>
																				</select>

																				<!-- Accessories -->
																				<select class="select2" name="accessories_ids[<?=$dependency_id?>][]" id="accessories_ids[<?=$dependency_id?>][]" multiple="multiple">
																					<?php
																					if(!empty($accessories_items_array)) {
																						$accessories_ids = @explode(",",$dependency_item['accessories']);
																						foreach($accessories_items_array as $accessory_item) {
																							$accessory_id = $accessory_item['id']; ?>
																							<option value="<?=$accessory_id?>" <?php if(in_array($accessory_id,$accessories_ids)){echo 'selected="selected"';}?>><?=html_entities($accessory_item['accessories_name'])?></option>		
																						<?php
																						}
																					} ?>
																				</select>
																				<!-- Colors -->
																				<select class="select2" name="color_ids[<?=$dependency_id?>][]" id="color_ids[<?=$dependency_id?>][]" multiple="multiple">
																					<?php
																					if(!empty($color_items_array)) {
																						$color_ids = @explode(",",$dependency_item['color']);
																						foreach($color_items_array as $color_item) {
																							$color_id = $color_item['id']; ?>
																							<option value="<?=$color_id?>" <?php if(in_array($color_id,$color_ids)){echo 'selected="selected"';}?>><?=html_entities($color_item['color_name'])?></option>		
																						<?php
																						}
																					} ?>
																				</select>
																				<!-- Condition -->
																				<select class="select2" name="conditions_ids[<?=$dependency_id?>][]" id="conditions_ids[<?=$dependency_id?>][]" multiple="multiple">
																					<?php
																					if(!empty($condition_items_array)) {
																						$conditions_ids = @explode(",",$dependency_item['conditions']);
																						foreach($condition_items_array as $conditions_item) {
																							$conditions_id = $conditions_item['id']; ?>
																							<option value="<?=$conditions_id?>" <?php if(in_array($conditions_id,$conditions_ids)){echo 'selected="selected"';}?>><?=html_entities($conditions_item['condition_name'])?></option>		
																						<?php
																						}
																					} ?>
																				</select>	
																				<!-- Network -->	
																				<select class="select2" name="networks_ids[<?=$dependency_id?>][]" id="networks_ids[<?=$dependency_id?>][]" multiple="multiple">
																					<?php
																					if(!empty($network_items_array)) {
																						$networks_ids = @explode(",",$dependency_item['networks']);
																						foreach($network_items_array as $networks_item) {
																							$networks_id = $networks_item['id']; ?>
																							<option value="<?=$networks_id?>" <?php if(in_array($networks_id,$networks_ids)){echo 'selected="selected"';}?>><?=html_entities($networks_item['network_name'])?></option>		
																						<?php
																						}
																					} ?>
																				</select>
																			
																				<!-- Storage -->
																				<select class="select2" name="storage_ids[<?=$dependency_id?>][]" id="storage_ids[<?=$dependency_id?>][]" multiple="multiple">
																					<?php
																					if(!empty($storage_items_array)) {
																						$storage_ids = @explode(",",$dependency_item['storage']);
																						foreach($storage_items_array as $storage_item) {
																							$storage_id = $storage_item['id']; ?>
																							<option value="<?=$storage_id?>" <?php if(in_array($storage_id,$storage_ids)){echo 'selected="selected"';}?>><?=html_entities($storage_item['storage_size'])?><?=html_entities($storage_item['storage_size_postfix'])?></option>		
																						<?php
																						}
																					} ?>
																				</select>


																				<a href="javascript:void(0);" class="remove_depen_item" id="depenrm_<?=$key?>"><i class="icon-remove-sign"></i></a>
																			</div>
																			<script>remove_depen_item();</script>
																		<?php
																		}
																	} ?>
																</div>
															</div>
															<div class="control-group">
																<div class="controls">
																	 <a id="watch_depen_plus_icon" class="btn btn-info btn-alt"><i class="icon-plus"></i> Add</a>
																</div>
															</div>
															<div class="form-actions">
																<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="mobile.php" class="btn btn-alt btn-large btn-black">Back</a>
															</div>
														</div>
													</div>
												</div>
								<?php
								}
								if($fields_cat_type == "laptop") { ?>
										<div class="tab-pane" id="tab1000">
											<div class="row-fluid">
												<div >
													<h4>Dependencies</h4>
													<div class="control-group">
														<label class="control-label" for="input">Add dependency</label>
													</div>
													<div class="control-group" id="add_depen_item">
														<div class="form-controls">
															<ul class="dependency_header">
																<li>WatchType</li>
																<li>Processor</li>
																<li>RAM</li>
																<li>Screen Resolution</li>
																<li>Screen Size</li>
																<li>Year</li>
																<li>Accessories</li>
																<li>Colors</li>
																<li>Condition</li>
																<li>Network</li>
																<li>Storage</li>
															</ul>
															<input type="hidden" name="depen_form" value="laptop">
															<?php
															if(!empty($dependencies_array)) {
																foreach($dependencies_array as $key=>$dependency_item) {
																	$dependency_id = $dependency_item['id']; ?>
																	<div id="depen<?=$key?>" style="margin-top:5px;">
																		<input type="hidden" name="depenkey[<?php echo $dependency_id?>]" value="<?php echo $dependency_id?>">
																		<!-- WatchType -->
																		<select class="select2" name="watchtype_ids[<?=$dependency_id?>][]" id="watchtype_ids[<?=$dependency_id?>][]" multiple="multiple">
																			<?php
																			if(!empty($watchtype_items_array)) {
																				$watchtype_ids = @explode(",",$dependency_item['watchtype']);
																				foreach($watchtype_items_array as $watchtype_item) {
																					$watchtype_id = $watchtype_item['id']; ?>
																					<option value="<?=$watchtype_id?>" <?php if(in_array($watchtype_id,$watchtype_ids)){echo 'selected="selected"';}?>><?=html_entities($watchtype_item['watchtype_name'])?></option>		
																				<?php
																				}
																			} ?>
																		</select>
																		<!-- Processor -->
																		<select class="select2" name="processor_ids[<?=$dependency_id?>][]" id="processor_ids[<?=$dependency_id?>][]" multiple="multiple">
																			<?php
																			if(!empty($processor_items_array)) {
																				$processor_ids = @explode(",",$dependency_item['processor']);
																				foreach($processor_items_array as $processor_item) {
																					$processor_id = $processor_item['id']; ?>
																					<option value="<?=$processor_id?>" <?php if(in_array($processor_id,$processor_ids)){echo 'selected="selected"';}?>><?=html_entities($processor_item['processor_name'])?></option>		
																				<?php
																				}
																			} ?>
																		</select>
																		<!-- RAM -->
																		<select class="select2" name="ram_ids[<?=$dependency_id?>][]" id="ram_ids[<?=$dependency_id?>][]" multiple="multiple">
																			<?php
																			if(!empty($ram_items_array)) {
																				$ram_ids = @explode(",",$dependency_item['ram']);
																				foreach($ram_items_array as $ram_item) {
																					$ram_id = $ram_item['id']; ?>
																					<option value="<?=$ram_id?>" <?php if(in_array($ram_id,$ram_ids)){echo 'selected="ram_id"';}?>><?=html_entities($ram_item['ram_size'])?><?=html_entities($ram_item['ram_size_postfix'])?></option>		
																				<?php
																				}
																			} ?>
																		</select>
																		<!-- Screen Resolution -->
																		<select class="select2" name="screen_resolution_ids[<?=$dependency_id?>][]" id="screen_resolution_ids[<?=$dependency_id?>][]" multiple="multiple">
																			<?php
																			if(!empty($screen_resolution_items_array)) {
																				$screen_resolution_ids = @explode(",",$dependency_item['screen_resolution']);
																				foreach($screen_resolution_items_array as $screen_resolution_item) {
																					$screen_resolution_id = $screen_resolution_item['id']; ?>
																					<option value="<?=$screen_resolution_id?>" <?php if(in_array($screen_resolution_id,$screen_resolution_ids)){echo 'selected="selected"';}?>><?=html_entities($screen_resolution_item['screen_resolution_name'])?></option>		
																				<?php
																				}
																			} ?>
																		</select>
																		<!-- Screen Size -->
																		<select class="select2" name="screen_size_ids[<?=$dependency_id?>][]" id="screen_size_ids[<?=$dependency_id?>][]" multiple="multiple">
																			<?php
																			if(!empty($screen_size_items_array)) {
																				$screen_size_ids = @explode(",",$dependency_item['screen_size']);
																				foreach($screen_size_items_array as $screen_size_item) {
																					$screen_size_id = $screen_size_item['id']; ?>
																					<option value="<?=$screen_size_id?>" <?php if(in_array($screen_size_id,$screen_size_ids)){echo 'selected="selected"';}?>><?=html_entities($screen_size_item['screen_size_name'])?></option>		
																				<?php
																				}
																			} ?>
																		</select>
																	
																		<!-- Year -->
																		<select class="select2" name="lyear_ids[<?=$dependency_id?>][]" id="lyear_ids[<?=$dependency_id?>][]" multiple="multiple">
																			<?php
																			if(!empty($lyear_items_array)) {
																				$lyear_ids = @explode(",",$dependency_item['lyear']);
																				foreach($lyear_items_array as $lyear_item) {
																					$lyear_id = $lyear_item['id']; ?>
																					<option value="<?=$lyear_id?>" <?php if(in_array($lyear_id,$lyear_ids)){echo 'selected="selected"';}?>><?=html_entities($lyear_item['lyear_name'])?></option>		
																				<?php
																				}
																			} ?>
																		</select>

																		<!-- Accessories -->
																		<select class="select2" name="accessories_ids[<?=$dependency_id?>][]" id="accessories_ids[<?=$dependency_id?>][]" multiple="multiple">
																			<?php
																			if(!empty($accessories_items_array)) {
																				$accessories_ids = @explode(",",$dependency_item['accessories']);
																				foreach($accessories_items_array as $accessory_item) {
																					$accessory_id = $accessory_item['id']; ?>
																					<option value="<?=$accessory_id?>" <?php if(in_array($accessory_id,$accessories_ids)){echo 'selected="selected"';}?>><?=html_entities($accessory_item['accessories_name'])?></option>		
																				<?php
																				}
																			} ?>
																		</select>
																		<!-- Colors -->
																		<select class="select2" name="color_ids[<?=$dependency_id?>][]" id="color_ids[<?=$dependency_id?>][]" multiple="multiple">
																			<?php
																			if(!empty($color_items_array)) {
																				$color_ids = @explode(",",$dependency_item['color']);
																				foreach($color_items_array as $color_item) {
																					$color_id = $color_item['id']; ?>
																					<option value="<?=$color_id?>" <?php if(in_array($color_id,$color_ids)){echo 'selected="selected"';}?>><?=html_entities($color_item['color_name'])?></option>		
																				<?php
																				}
																			} ?>
																		</select>
																		<!-- Condition -->
																		<select class="select2" name="conditions_ids[<?=$dependency_id?>][]" id="conditions_ids[<?=$dependency_id?>][]" multiple="multiple">
																			<?php
																			if(!empty($condition_items_array)) {
																				$conditions_ids = @explode(",",$dependency_item['conditions']);
																				foreach($condition_items_array as $conditions_item) {
																					$conditions_id = $conditions_item['id']; ?>
																					<option value="<?=$conditions_id?>" <?php if(in_array($conditions_id,$conditions_ids)){echo 'selected="selected"';}?>><?=html_entities($conditions_item['condition_name'])?></option>		
																				<?php
																				}
																			} ?>
																		</select>	
																		<!-- Network -->	
																		<select class="select2" name="networks_ids[<?=$dependency_id?>][]" id="networks_ids[<?=$dependency_id?>][]" multiple="multiple">
																			<?php
																			if(!empty($network_items_array)) {
																				$networks_ids = @explode(",",$dependency_item['networks']);
																				foreach($network_items_array as $networks_item) {
																					$networks_id = $networks_item['id']; ?>
																					<option value="<?=$networks_id?>" <?php if(in_array($networks_id,$networks_ids)){echo 'selected="selected"';}?>><?=html_entities($networks_item['network_name'])?></option>		
																				<?php
																				}
																			} ?>
																		</select>
																	
																		<!-- Storage -->
																		<select class="select2" name="storage_ids[<?=$dependency_id?>][]" id="storage_ids[<?=$dependency_id?>][]" multiple="multiple">
																			<?php
																			if(!empty($storage_items_array)) {
																				$storage_ids = @explode(",",$dependency_item['storage']);
																				foreach($storage_items_array as $storage_item) {
																					$storage_id = $storage_item['id']; ?>
																					<option value="<?=$storage_id?>" <?php if(in_array($storage_id,$storage_ids)){echo 'selected="selected"';}?>><?=html_entities($storage_item['storage_size'])?><?=html_entities($storage_item['storage_size_postfix'])?></option>		
																				<?php
																				}
																			} ?>
																		</select>


																		<a href="javascript:void(0);" class="remove_depen_item"id="depenrm_<?=$key?>"><i class="icon-remove-sign"></i></a>
																	</div>
																	<script>remove_depen_item();</script>
																<?php
																}
															} ?>
														</div>
													</div>
													<div class="control-group">
														<div class="controls">
															 <a id="laptop_depen_plus_icon" class="btn btn-info btn-alt"><i class="icon-plus"></i> Add</a>
														</div>
													</div>
													<div class="form-actions">
														<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="mobile.php" class="btn btn-alt btn-large btn-black">Back</a>
													</div>
												</div>
											</div>
										</div>
								<?php
								} ?>
								<!-- dependencies-end -->
							</div>
						</div>
						<!-- Second level tabs -->
					</div>
					<input type="hidden" name="id" value="<?=$mobile_data['id']?>" />
					</form>
                </section>
            </article>
        </div>
    </section>
	<div id="push"></div>
</div>

<script>
function get_cat_custom_fields(cat_id) {
	if(cat_id!="") {
		jQuery(document).ready(function($) {
			var fields_type = $("#cat_id").find(':selected').attr('data-fields-type');
			post_data = "cat_id="+cat_id+"&fields_cat_type="+fields_type;
			
			$(".fields_tab").hide();

			$.ajax({
				type: "POST",
				url:"ajax/get_cat_custom_fields.php?field_type=tabs",
				data:post_data,
				success:function(data){
					if(data!="") {
						$('.nav-tabs').html(data);
					}
				}
			});

			$.ajax({
				type: "POST",
				url:"ajax/get_cat_custom_fields.php?field_type=storage",
				data:post_data,
				success:function(data){
					if(data!="") {
						$('#add_storage_item').html(data);
						//$(".fields_tab1").show();
					} else {
						$('#add_storage_item').html('');
					}
				}
			});

			$.ajax({
				type: "POST",
				url:"ajax/get_cat_custom_fields.php?field_type=condition",
				data:post_data,
				success:function(data){
					if(data!="") {
						$('#add_condition_item').html(data);
						//$(".fields_tab2").show();
					} else {
						$('#add_condition_item').html('');
					}
				}
			});
			
			$.ajax({
				type: "POST",
				url:"ajax/get_cat_custom_fields.php?field_type=network",
				data:post_data,
				success:function(data){
					if(data!="") {
						$('#add_network_item').html(data);
						//$(".fields_tab3").show();
					} else {
						$('#add_network_item').html('');
					}
				}
			});
			
			$.ajax({
				type: "POST",
				url:"ajax/get_cat_custom_fields.php?field_type=connectivity",
				data:post_data,
				success:function(data){
					if(data!="") {
						$('#add_connectivity_item').html(data);
						//$(".fields_tab4").show();
					} else {
						$('#add_connectivity_item').html('');
					}
				}
			});
			
			$.ajax({
				type: "POST",
				url:"ajax/get_cat_custom_fields.php?field_type=watchtype",
				data:post_data,
				success:function(data){
					if(data!="") {
						$('#add_watchtype_item').html(data);
						//$(".fields_tab5").show();
					} else {
						$('#add_watchtype_item').html('');
					}
				}
			});
			
			$.ajax({
				type: "POST",
				url:"ajax/get_cat_custom_fields.php?field_type=case_material",
				data:post_data,
				success:function(data){
					if(data!="") {
						$('#add_case_material_item').html(data);
						//$(".fields_tab7").show();
					} else {
						$('#add_case_material_item').html('');
					}
				}
			});
			
			$.ajax({
				type: "POST",
				url:"ajax/get_cat_custom_fields.php?field_type=case_size",
				data:post_data,
				success:function(data){
					if(data!="") {
						$('#add_case_size_item').html(data);
						//$(".fields_tab6").show();
					} else {
						$('#add_case_size_item').html('');
					}
				}
			});
			
			$.ajax({
				type: "POST",
				url:"ajax/get_cat_custom_fields.php?field_type=color",
				data:post_data,
				success:function(data){
					if(data!="") {
						$('#add_color_item').html(data);
						//$(".fields_tab11").show();
					} else {
						$('#add_color_item').html('');
					}
				}
			});
			
			$.ajax({
				type: "POST",
				url:"ajax/get_cat_custom_fields.php?field_type=accessories",
				data:post_data,
				success:function(data){
					if(data!="") {
						$('#add_accessories_item').html(data);
						//$(".fields_tab12").show();
					} else {
						$('#add_accessories_item').html('');
					}
				}
			});
			
			$.ajax({
				type: "POST",
				url:"ajax/get_cat_custom_fields.php?field_type=screen_size",
				data:post_data,
				success:function(data){
					if(data!="") {
						$('#add_screen_size_item').html(data);
						//$(".fields_tab13").show();
					} else {
						$('#add_screen_size_item').html('');
					}
				}
			});
			
			$.ajax({
				type: "POST",
				url:"ajax/get_cat_custom_fields.php?field_type=screen_resolution",
				data:post_data,
				success:function(data){
					if(data!="") {
						$('#add_screen_resolution_item').html(data);
						//$(".fields_tab14").show();
					} else {
						$('#add_screen_resolution_item').html('');
					}
				}
			});
			
			$.ajax({
				type: "POST",
				url:"ajax/get_cat_custom_fields.php?field_type=lyear",
				data:post_data,
				success:function(data){
					if(data!="") {
						$('#add_lyear_item').html(data);
						//$(".fields_tab15").show();
					} else {
						$('#add_lyear_item').html('');
					}
				}
			});
			
			$.ajax({
				type: "POST",
				url:"ajax/get_cat_custom_fields.php?field_type=processor",
				data:post_data,
				success:function(data){
					if(data!="") {
						$('#add_processor_item').html(data);
						//$(".fields_tab16").show();
					} else {
						$('#add_processor_item').html('');
					}
				}
			});
			
			$.ajax({
				type: "POST",
				url:"ajax/get_cat_custom_fields.php?field_type=ram",
				data:post_data,
				success:function(data){
					if(data!="") {
						$('#add_ram_item').html(data);
						//$(".fields_tab17").show();
					} else {
						$('#add_ram_item').html('');
					}
				}
			});
			
		});
	}
}

$(".select2").select2();
</script>