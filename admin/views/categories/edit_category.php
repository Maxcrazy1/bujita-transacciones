<style type="text/css">
.condition-fields label {margin-bottom:2px !important;font-size:10px !important;}
.network-fields label {margin-bottom:2px !important;font-size:10px !important;}
.watchtype-fields label {margin-bottom:2px !important;font-size:10px !important;}
</style>

<script type="text/javascript">
function check_form(a){
	if(a.title.value.trim()==""){
		alert('Please enter title');
		a.title.focus();
		a.title.value='';
		return false;
	}
	
	<?php
	if($brand_data['image']=="") { ?>
	var str_image = a.image.value.trim();
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

jQuery(document).ready(function ($) {
	$("#storage_plus_icon").on( "click", function(e) {
		var uniqueId = Math.random();
		var uniqueId = uniqueId.toString().split('.');

		var append_data='<div id="'+uniqueId[1]+'" style="margin-top:5px;">';
			append_data+='<div class="controls"><input type="text" class="input-small" id="storage_size[]" name="storage_size[]" placeholder="Storage Size"> ';
			
			append_data+='<select class="span2" name="storage_size_postfix[]" id="storage_size_postfix[]" style="width:70px;">';
				append_data+='<option value="GB">GB</option>';
				append_data+='<option value="TB">TB</option>';
				append_data+='<option value="MB">MB</option>';
			append_data+='</select>';
			
			//append_data+='<div class="input-prepend input-append"><?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?><input type="number" class="input-small" id="storage_price[]" name="storage_price[]" placeholder="Price"><?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?></div>';
			
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
			
			/*append_data+='<div class="span1.5">';
				append_data+='<div class="control-group">';
					append_data+='<label class="control-label" for="input">Price</label>';
					append_data+='<div class="controls">';
						 append_data+='<div class="input-prepend input-append"><?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?><input type="number" class="input-small" id="condition_price[]" name="condition_price[]" placeholder="Price"><?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?></div>';
					append_data+='</div>';
				append_data+='</div>';
			append_data+='</div>';*/
			
			append_data+='<div class="span5">';
				append_data+='<div class="control-group">';
					append_data+='<label class="control-label" for="input">Terms</label>';
					append_data+='<div class="controls">';
						 append_data+='<textarea class="form-control span5 wysihtml5" name="condition_terms[]" id="condition_terms[]" placeholder="Terms"></textarea>';
					append_data+='</div>';
				append_data+='</div>';
			append_data+='</div>';
			append_data+='<div class="span1.5">';
				append_data+='<div class="control-group">';
					append_data+='<label class="control-label" for="input">&nbsp;</label>';
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
			
			/*append_data+='<div class="span1.5">';
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
			append_data+='</div>';*/
			
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
			 
			 //append_data+='<div class="input-prepend input-append"><?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?><input type="number" class="input-small" id="connectivity_price[]" name="connectivity_price[]" placeholder="Price"><?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?></div>';
			 
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
			 
			 //append_data+='<div class="input-prepend input-append"><?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?><input type="number" class="input-small" id="case_size_price[]" name="case_size_price[]" placeholder="Price"><?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?></div>';
			 
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
			/*append_data+='<div class="span1.5">';
				append_data+='<div class="control-group">';
					append_data+='<label class="control-label" for="input">&nbsp;</label>';
					append_data+='<div class="controls">';
			 			append_data+='<div class="input-prepend input-append"><?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?><input type="number" class="input-small" id="watchtype_price[]" name="watchtype_price[]" placeholder="Price"><?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?></div>';
			 		append_data+='</div>';
				append_data+='</div>';
			append_data+='</div>';*/
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
			 
			 //append_data+='<div class="input-prepend input-append"><?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?><input type="number" class="input-small" id="case_material_price[]" name="case_material_price[]" placeholder="Price"><?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?></div>';
			 
			 append_data+='&nbsp;<a href="javascript:void(0);" class="remove_case_material_item" id="rm_'+uniqueId[1]+'"><i class="icon-remove-sign"></i></a>';
			 append_data+='</div>';
		 append_data+='</div>';
		$('#add_case_material_item').append(append_data);
		remove_case_material_item();
	});
	
	$("#color_plus_icon").on( "click", function(e) {
		var uniqueId = Math.random();
		var uniqueId = uniqueId.toString().split('.');

		var append_data='<div id="'+uniqueId[1]+'" style="margin-top:5px;">';
			 append_data+='<div class="controls"><input type="text" class="input-large" id="color_name[]" name="color_name[]" placeholder="Name"> ';
			 append_data+='<input type="color" class="input-small" id="color_code[]" name="color_code[]" placeholder="Color Code"> ';
			 //append_data+='<div class="input-prepend input-append"><?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?><input type="number" class="input-small" id="color_price[]" name="color_price[]" placeholder="Price"><?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?></div>';
			 
			 append_data+='&nbsp;<a href="javascript:void(0);" class="remove_color_item" id="rm_'+uniqueId[1]+'"><i class="icon-remove-sign"></i></a>';
			 append_data+='</div>';
		 append_data+='</div>';
		$('#add_color_item').append(append_data);
		remove_color_item();
	});
	
	$("#accessories_plus_icon").on( "click", function(e) {
		var uniqueId = Math.random();
		var uniqueId = uniqueId.toString().split('.');

		var append_data='<div id="'+uniqueId[1]+'" style="margin-top:5px;">';
			 append_data+='<div class="controls"><input type="text" class="input-large" id="accessories_name[]" name="accessories_name[]" placeholder="Name"> ';
			 
			 //append_data+='<div class="input-prepend input-append"><?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?><input type="number" class="input-small" id="accessories_price[]" name="accessories_price[]" placeholder="Price"><?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?></div>';
			 
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
			 
			 //append_data+='<div class="input-prepend input-append"><?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?><input type="number" class="input-small" id="screen_size_price[]" name="screen_size_price[]" placeholder="Price"><?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?></div>';
			 
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
			 
			 //append_data+='<div class="input-prepend input-append"><?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?><input type="number" class="input-small" id="screen_resolution_price[]" name="screen_resolution_price[]" placeholder="Price"><?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?></div>';
			 
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
			 
			 //append_data+='<div class="input-prepend input-append"><?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?><input type="number" class="input-small" id="lyear_price[]" name="lyear_price[]" placeholder="Price"><?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?></div>';
			 
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
			 
			 //append_data+='<div class="input-prepend input-append"><?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?><input type="number" class="input-small" id="processor_price[]" name="processor_price[]" placeholder="Price"><?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?></div>';
			 
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
			 
			 //append_data+='<div class="input-prepend input-append"><?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?><input type="number" class="input-small" id="ram_price[]" name="ram_price[]" placeholder="Price"><?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?></div>';
			 
			 append_data+='&nbsp;<a href="javascript:void(0);" class="remove_ram_item" id="rm_'+uniqueId[1]+'"><i class="icon-remove-sign"></i></a>';
			 append_data+='</div>';
		 append_data+='</div>';
		$('#add_ram_item').append(append_data);
		remove_ram_item();
	});
	
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
</script>

<div id="wrapper">
    <header id="header" class="container">
    	<?php include("include/admin_menu.php"); ?>
    </header>

	<section class="container" role="main">
		<div class="row">
            <article class="span12 data-block">
				<header><h2><?=($id?'Edit Category':'Add Category')?></h2></header>
                <section class="tab-content">
					<?php include('confirm_message.php');?>
					<form role="form" action="controllers/device_categories.php" class="form-inline no-margin" method="post" onSubmit="return check_form(this);" enctype="multipart/form-data">
					<div class="tab-pane active">
						<!-- Second level tabs -->
						<div class="tabbable tabs-left">
							<ul class="nav nav-tabs">
								<?php
								if($id>0) { ?>
								<li class="active"><a href="#tab1" data-toggle="tab">Basic</a></li>
								<?php
								}
								if($brand_data['fields_type'] == "mobile") { ?>
								<li><a href="#tab4" data-toggle="tab">Network</a></li>
								<li><a href="#tab2" data-toggle="tab">Storage</a></li>
								<!--<li><a href="#tab11" data-toggle="tab">Color</a></li>-->
								<li><a href="#tab3" data-toggle="tab">Condition</a></li>
								<!--<li><a href="#tab12" data-toggle="tab">Accessories</a></li>-->
								<?php
								}
								if($brand_data['fields_type'] == "tablet") { ?>
								<li><a href="#tab7" data-toggle="tab">Type</a></li>
								<!--<li><a href="#tab4" data-toggle="tab">Network</a></li>-->
								<li><a href="#tab2" data-toggle="tab">Storage</a></li>
								<!--<li><a href="#tab11" data-toggle="tab">Color</a></li>-->
								<li><a href="#tab3" data-toggle="tab">Condition</a></li>
								<!--<li><a href="#tab12" data-toggle="tab">Accessories</a></li>-->
								<?php /*?><li><a href="#tab5" data-toggle="tab">Connectivity</a></li><?php */?>
								<?php
								}
								if($brand_data['fields_type'] == "watch") { ?>
								<li><a href="#tab7" data-toggle="tab">Type</a></li>
								<!--<li><a href="#tab4" data-toggle="tab">Network</a></li>
								<li><a href="#tab2" data-toggle="tab">Storage</a></li>-->
								<li><a href="#tab8" data-toggle="tab">Case Material</a></li>
								<li><a href="#tab6" data-toggle="tab">Case Size</a></li>
								<!--<li><a href="#tab11" data-toggle="tab">Color</a></li>-->
								<li><a href="#tab3" data-toggle="tab">Condition</a></li>
								<!--<li><a href="#tab12" data-toggle="tab">Accessories</a></li>-->
								<?php
								}
								if($brand_data['fields_type'] == "laptop") { ?>
								<li><a href="#tab7" data-toggle="tab">Type</a></li>
								<!--<li><a href="#tab4" data-toggle="tab">Network</a></li>-->
								<li><a href="#tab13" data-toggle="tab">Screen Size</a></li>
								<!--<li><a href="#tab14" data-toggle="tab">Screen Resolution</a></li>
								<li><a href="#tab15" data-toggle="tab">Year</a></li>-->
								<li><a href="#tab16" data-toggle="tab">Processor</a></li>
								<li><a href="#tab2" data-toggle="tab">Storage</a></li>
								<li><a href="#tab17" data-toggle="tab">Ram (Memory)</a></li>
								<!--<li><a href="#tab11" data-toggle="tab">Color</a></li>-->
								<li><a href="#tab3" data-toggle="tab">Condition</a></li>
								<!--<li><a href="#tab12" data-toggle="tab">Accessories</a></li>-->
								<?php
								} ?>
							</ul>
							<div class="tab-content">
							
								<div class="tab-pane active" id="tab1">
									<div class="row-fluid">
										<div class="span8">
											<!--<h3>Basic Fields</h3>-->
											<div class="control-group">
												<label class="control-label" for="input">Title</label>
												<div class="controls">
													<input type="text" class="input-large" id="first_name" value="<?=html_entities($brand_data['title'])?>" name="title">
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="input">Type</label>
												<div class="controls">
													<select name="fields_type" id="fields_type">
														<option value=""> - Select - </option>
														<option value="mobile" <?php if($brand_data['fields_type'] == "mobile"){echo 'selected="selected"';}?>>Mobile</option>
														<option value="tablet" <?php if($brand_data['fields_type'] == "tablet"){echo 'selected="selected"';}?>>Tablet</option>
														<option value="watch" <?php if($brand_data['fields_type'] == "watch"){echo 'selected="selected"';}?>>Watch</option>
														<option value="laptop" <?php if($brand_data['fields_type'] == "laptop"){echo 'selected="selected"';}?>>Laptop</option>
													</select>
												</div>
												<small>Further configuration of fields display per Gadget category choosen.</small>
											</div>
									
											<div class="control-group">
												<label class="control-label" for="fileInput">Icon</label>
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
																	<input type="file" class="form-control" id="image" name="image" onChange="checkFile(this);" accept="image/*">
															</span>
															<a href="javascript:void(0);" class="btn btn-alt btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a>
														</div>
													</div>
													
													<?php 
													if($brand_data['image']!="") { ?>
														<div class="fileupload fileupload-new" data-provides="fileupload">
															<div class="fileupload-new thumbnail"><img src="../images/categories/<?=$brand_data['image']?>" width="200"></div>
															<div class="fileupload-preview fileupload-exists fileupload-large flexible thumbnail"></div>
															<div>
																<a class="btn btn-alt btn-danger" data-dismiss="fileupload" href="controllers/device_categories.php?id=<?=$_REQUEST['id']?>&r_img_id=<?=$brand_data['id']?>" onclick="return confirm('Are you sure to delete this icon?');">Remove</a>
															</div>
														</div>
														<input type="hidden" id="old_image" name="old_image" value="<?=$brand_data['image']?>">
													<?php 
													} ?>	 
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="input">Description</label>
												<div class="controls">
													<textarea class="form-control wysihtml5" name="description" rows="5"><?=$brand_data['description']?></textarea>
												</div>
											</div>
											
											<!--<div class="control-group">
												<label class="control-label" for="input">Device Tooltip</label>
												<div class="controls">
													<textarea class="form-control wysihtml5" name="tooltip_device" rows="5"><?=$brand_data['tooltip_device']?></textarea>
												</div>
											</div>-->
											
											<div class="control-group radio-inline">
												<label class="control-label" for="published">Publish</label>
												<div class="controls">
													<label class="radio-custom-inline custom-radio">
														<input type="radio" id="published" name="published" value="1" <?php if(!$brand_id){echo 'checked="checked"';}?> <?=($brand_data['published']==1?'checked="checked"':'')?>>
														Yes
													</label>
													<label class="radio-custom-inline ml-10 custom-radio">
														<input type="radio" id="published" name="published" value="0" <?=($brand_data['published']=='0'?'checked="checked"':'')?>>
														No
													</label>
												</div>
											</div>
												
											<div class="form-actions">
												<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="device_categories.php" class="btn btn-alt btn-large btn-black">Back</a>
											</div>
										</div>
									</div>
								</div>
								
								<div class="tab-pane" id="tab2">
									<div class="row-fluid">
										<div class="span8">
											<!--<h3>Storage Fields</h3>-->
											<div class="control-group">
												<label class="control-label" for="storage_title">Storage Title</label>
												<div class="controls">
													<input type="text" class="input-xlarge" name="storage_title" value="<?=$brand_data['storage_title']?>" />
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" for="input">Storage Tooltip</label>
												<div class="controls">
													<textarea class="form-control wysihtml5" name="tooltip_storage" rows="5"><?=$brand_data['tooltip_storage']?></textarea>
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" for="input">Add Storages</label>
											</div>
											<div class="control-group" id="add_storage_item">
												<div class="form-controls">
												<?php
												if(!empty($storage_items_array)) {
													foreach($storage_items_array as $key=>$storage_item) {
														$storage_id = $storage_item['id']; ?>
														<div id="<?=$key?>" style="margin-top:5px;">
															<input type="text" class="input-small" id="storage_size[<?=$storage_id?>]" name="storage_size[<?=$storage_id?>]" value="<?=html_entities($storage_item['storage_size'])?>" placeholder="Storage Size">
															<select class="span2" name="storage_size_postfix[<?=$storage_id?>]" id="storage_size_postfix[<?=$storage_id?>]" style="width:70px;">
																<option value="GB" <?php if($storage_item['storage_size_postfix']=='GB'){echo 'selected="selected"';}?>>GB</option>
																<option value="TB" <?php if($storage_item['storage_size_postfix']=='TB'){echo 'selected="selected"';}?>>TB</option>
																<option value="MB" <?php if($storage_item['storage_size_postfix']=='MB'){echo 'selected="selected"';}?>>MB</option>
															</select>
															
															<?php /*?><div class="input-prepend input-append">
																<?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
																<input type="number" class="input-small" id="storage_price[<?=$storage_id?>]" name="storage_price[<?=$storage_id?>]" value="<?=$storage_item['storage_price']?>" placeholder="Price">
																<?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
															</div><?php */?>
															
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
												<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="device_categories.php" class="btn btn-alt btn-large btn-black">Back</a>
											</div>
										</div>
									</div>
								</div>
					
								<div class="tab-pane" id="tab3">
									<!--<h3>Condition Fields</h3>-->
									<div class="control-group">
										<label class="control-label" for="condition_title">Condition Title</label>
										<div class="controls">
											<input type="text" class="input-xlarge" name="condition_title" value="<?=$brand_data['condition_title']?>" />
										</div>
									</div>
									<!--<div class="control-group">
										<label class="control-label" for="input">Condition Tooltip</label>
										<div class="controls">
											<textarea class="form-control wysihtml5" name="tooltip_condition" rows="5" style="width:620px;"><?=$brand_data['tooltip_condition']?></textarea>
										</div>
									</div>-->
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
													<?php /*?><div class="span1.5">
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
													</div><?php */?>
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
										<a href="device_categories.php" class="btn btn-alt btn-large btn-black">Back</a>
									</div>
								</div>
					
								<div class="tab-pane" id="tab4">
									<!--<h3>Network Fields</h3>-->
									<div class="control-group">
										<label class="control-label" for="network_title">Network Title</label>
										<div class="controls">
											<input type="text" class="input-xlarge" name="network_title" value="<?=$brand_data['network_title']?>" />
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="input">Network Tooltip</label>
										<div class="controls">
											<textarea class="form-control wysihtml5" name="tooltip_network" rows="5" style="width:620px;"><?=$brand_data['tooltip_network']?></textarea>
										</div>
									</div>
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
												<?php /*?><div class="span1.5">
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
												</div><?php */?>
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
										<a href="device_categories.php" class="btn btn-alt btn-large btn-black">Back</a>
									</div>
					
								</div>
					
								<div class="tab-pane" id="tab5">
									<div class="row-fluid">
										<div class="span8">
											<!--<h3>Connectivity Fields</h3>-->
											<div class="control-group">
												<label class="control-label" for="connectivity_title">Connectivity Title</label>
												<div class="controls">
													<input type="text" class="input-xlarge" name="connectivity_title" value="<?=$brand_data['connectivity_title']?>" />
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" for="input">Connectivity Tooltip</label>
												<div class="controls">
													<textarea class="form-control wysihtml5" name="tooltip_connectivity" rows="5"><?=$brand_data['tooltip_connectivity']?></textarea>
												</div>
											</div>
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
															<?php /*?><div class="input-prepend input-append">
																<?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
																<input type="number" class="input-small" id="connectivity_price[<?=$connectivity_id?>]" name="connectivity_price[<?=$connectivity_id?>]" value="<?=$connectivity_item['connectivity_price']?>" placeholder="Price">
																<?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
															</div><?php */?>
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
												<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="device_categories.php" class="btn btn-alt btn-large btn-black">Back</a>
											</div>
										</div>
									</div>
								</div>
					
								<div class="tab-pane" id="tab6">
									<div class="row-fluid">
										<div class="span8">
											<!--<h3>Case Size Fields</h3>-->
											<div class="control-group">
												<label class="control-label" for="case_size_title">Case Size Title</label>
												<div class="controls">
													<input type="text" class="input-xlarge" name="case_size_title" value="<?=$brand_data['case_size_title']?>" />
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" for="input">Case Size Tooltip</label>
												<div class="controls">
													<textarea class="form-control wysihtml5" name="tooltip_case_size" rows="5"><?=$brand_data['tooltip_case_size']?></textarea>
												</div>
											</div>
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
															<?php /*?><div class="input-prepend input-append">
																<?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
																<input type="number" class="input-small" id="case_size_price[<?=$case_size_id?>]" name="case_size_price[<?=$case_size_id?>]" value="<?=$case_size_item['case_size_price']?>" placeholder="Price">
																<?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
															</div><?php */?>
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
												<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="device_categories.php" class="btn btn-alt btn-large btn-black">Back</a>
											</div>
										</div>
									</div>
								</div>
					
								<div class="tab-pane" id="tab7">
									<!--<h3>Type Fields</h3>-->
									<div class="control-group">
										<label class="control-label" for="type_title">Type Title</label>
										<div class="controls">
											<input type="text" class="input-xlarge" name="type_title" value="<?=$brand_data['type_title']?>" />
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="input">Type Tooltip</label>
										<div class="controls">
											<textarea class="form-control wysihtml5" name="tooltip_watchtype" rows="5"><?=$brand_data['tooltip_watchtype']?></textarea>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="input">Add Type</label>
									</div>
									<div class="control-group watchtype-fields" id="add_watchtype_item">
										<div class="form-controls">
										<?php
										if(!empty($watchtype_items_array)) {
											foreach($watchtype_items_array as $key=>$watchtype_item) {
												$watchtype_id = $watchtype_item['id']; ?>
												<div class="row" id="wacl<?=$key?>" style="margin-top:5px;">
													<div class="span1.5">
														<div class="control-group">
															<label class="control-label" for="input">&nbsp;</label>
															<div class="controls">
																<input type="text" class="input-large" id="watchtype_name[<?=$watchtype_id?>]" name="watchtype_name[<?=$watchtype_id?>]" value="<?=html_entities($watchtype_item['watchtype_name'])?>" placeholder="Name">
															</div>
														</div>
													</div>
													<?php /*?><div class="span1.5">
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
													</div><?php */?>
													<div class="span1.5">
														<div class="control-group">
															<label class="control-label" for="input">Network</label>
															<div class="controls">
															
																<select class="span2" name="disabled_network[<?=$watchtype_id?>]" id="disabled_network[<?=$watchtype_id?>]">
																<option value="1" <?php if($watchtype_item['disabled_network']=='1'){echo 'selected="selected"';}?>>Enabled</option>
																<option value="0" <?php if($watchtype_item['disabled_network']=='0'){echo 'selected="selected"';}?>>Disabled</option>
																</select>
															
																<a href="javascript:void(0);" class="remove_watchtype_item" id="rm_wacl<?=$key?>"><i class="icon-remove-sign"></i></a>
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
										<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="device_categories.php" class="btn btn-alt btn-large btn-black">Back</a>
									</div>
										
								</div>
								
								<div class="tab-pane" id="tab8">
									<div class="row-fluid">
										<div class="span8">
											<!--<h3>Type Fields</h3>-->
											<div class="control-group">
												<label class="control-label" for="case_material_title">Case Material Title</label>
												<div class="controls">
													<input type="text" class="input-xlarge" name="case_material_title" value="<?=$brand_data['case_material_title']?>" />
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" for="input">Case Material Tooltip</label>
												<div class="controls">
													<textarea class="form-control wysihtml5" name="tooltip_case_material" rows="5"><?=$brand_data['tooltip_case_material']?></textarea>
												</div>
											</div>
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
															<?php /*?><div class="input-prepend input-append">
																<?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
																<input type="number" class="input-small" id="case_material_price[<?=$case_material_id?>]" name="case_material_price[<?=$case_material_id?>]" value="<?=$case_material_item['case_material_price']?>" placeholder="Price">
																<?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
															</div><?php */?>
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
												<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="device_categories.php" class="btn btn-alt btn-large btn-black">Back</a>
											</div>
										</div>
									</div>
								</div>
								
								
								<div class="tab-pane" id="tab11">
									<div class="row-fluid">
										<div class="span8">
											<!--<h3>Type Fields</h3>-->
											<div class="control-group">
												<label class="control-label" for="color_title">Color Title</label>
												<div class="controls">
													<input type="text" class="input-xlarge" name="color_title" value="<?=$brand_data['color_title']?>" />
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" for="input">Color Tooltip</label>
												<div class="controls">
													<textarea class="form-control wysihtml5" name="tooltip_color" rows="5"><?=$brand_data['tooltip_color']?></textarea>
												</div>
											</div>
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
															<?php /*?><div class="input-prepend input-append">
																<?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
																<input type="number" class="input-small" id="color_price[<?=$color_id?>]" name="color_price[<?=$color_id?>]" value="<?=$color_item['color_price']?>" placeholder="Price">
																<?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
															</div><?php */?>
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
												<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="device_categories.php" class="btn btn-alt btn-large btn-black">Back</a>
											</div>
										</div>
									</div>
								</div>
								
								<div class="tab-pane" id="tab12">
									<div class="row-fluid">
										<div class="span8">
											<!--<h3>Type Fields</h3>-->
											<div class="control-group">
												<label class="control-label" for="accessories_title">Accessories Title</label>
												<div class="controls">
													<input type="text" class="input-xlarge" name="accessories_title" value="<?=$brand_data['accessories_title']?>" />
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" for="input">Accessories Tooltip</label>
												<div class="controls">
													<textarea class="form-control wysihtml5" name="tooltip_accessories" rows="5"><?=$brand_data['tooltip_accessories']?></textarea>
												</div>
											</div>
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
															<?php /*?><div class="input-prepend input-append">
																<?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
																<input type="number" class="input-small" id="accessories_price[<?=$accessories_id?>]" name="accessories_price[<?=$accessories_id?>]" value="<?=$accessories_item['accessories_price']?>" placeholder="Price">
																<?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
															</div><?php */?>
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
												<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="device_categories.php" class="btn btn-alt btn-large btn-black">Back</a>
											</div>
										</div>
									</div>
								</div>
								
								<div class="tab-pane" id="tab13">
									<div class="row-fluid">
										<div class="span8">
											<div class="control-group">
												<label class="control-label" for="screen_size_title">Screen Size Title</label>
												<div class="controls">
													<input type="text" class="input-xlarge" name="screen_size_title" value="<?=$brand_data['screen_size_title']?>" />
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" for="input">Screen Size Tooltip</label>
												<div class="controls">
													<textarea class="form-control wysihtml5" name="tooltip_screen_size" rows="5"><?=$brand_data['tooltip_screen_size']?></textarea>
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" for="input">Add Screen Size</label>
											</div>
											<div class="control-group" id="add_screen_size_item">
												<div class="form-controls">
												<?php
												if(!empty($screen_size_items_array)) {
													foreach($screen_size_items_array as $key=>$screen_size_item) {
														$screen_size_id = $screen_size_item['id']; ?>
														<div id="scnsz<?=$key?>" style="margin-top:5px;">
															<input type="text" class="input-large" id="screen_size_name[<?=$screen_size_id?>]" name="screen_size_name[<?=$screen_size_id?>]" value="<?=html_entities($screen_size_item['screen_size_name'])?>" placeholder="Screen Size">
															<?php /*?><div class="input-prepend input-append">
																<?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
																<input type="number" class="input-small" id="screen_size_price[<?=$screen_size_id?>]" name="screen_size_price[<?=$screen_size_id?>]" value="<?=$screen_size_item['screen_size_price']?>" placeholder="Price">
																<?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
															</div><?php */?>
															<a href="javascript:void(0);" class="remove_screen_size_item" id="rm_scnsz<?=$key?>"><i class="icon-remove-sign"></i></a>
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
												<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="device_categories.php" class="btn btn-alt btn-large btn-black">Back</a>
											</div>
										</div>
									</div>
								</div>								
								
								<div class="tab-pane" id="tab14">
									<div class="row-fluid">
										<div class="span8">
											<div class="control-group">
												<label class="control-label" for="screen_resolution_title">Screen Resolution Title</label>
												<div class="controls">
													<input type="text" class="input-xlarge" name="screen_resolution_title" value="<?=$brand_data['screen_resolution_title']?>" />
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" for="input">Screen Resolution Tooltip</label>
												<div class="controls">
													<textarea class="form-control wysihtml5" name="tooltip_screen_resolution" rows="5"><?=$brand_data['tooltip_screen_resolution']?></textarea>
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" for="input">Add Screen Resolution</label>
											</div>
											<div class="control-group" id="add_screen_resolution_item">
												<div class="form-controls">
												<?php
												if(!empty($screen_resolution_items_array)) {
													foreach($screen_resolution_items_array as $key=>$screen_resolution_item) {
														$screen_resolution_id = $screen_resolution_item['id']; ?>
														<div id="scnrsl<?=$key?>" style="margin-top:5px;">
															<input type="text" class="input-large" id="screen_resolution_name[<?=$screen_resolution_id?>]" name="screen_resolution_name[<?=$screen_resolution_id?>]" value="<?=html_entities($screen_resolution_item['screen_resolution_name'])?>" placeholder="Name">
															<?php /*?><div class="input-prepend input-append">
																<?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
																<input type="number" class="input-small" id="screen_resolution_price[<?=$screen_resolution_id?>]" name="screen_resolution_price[<?=$screen_resolution_id?>]" value="<?=$screen_resolution_item['screen_resolution_price']?>" placeholder="Price">
																<?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
															</div><?php */?>
															<a href="javascript:void(0);" class="remove_screen_resolution_item" id="rm_scnrsl<?=$key?>"><i class="icon-remove-sign"></i></a>
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
												<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="device_categories.php" class="btn btn-alt btn-large btn-black">Back</a>
											</div>
										</div>
									</div>
								</div>

								<div class="tab-pane" id="tab15">
									<div class="row-fluid">
										<div class="span8">
											<div class="control-group">
												<label class="control-label" for="lyear_title">Year Title</label>
												<div class="controls">
													<input type="text" class="input-xlarge" name="lyear_title" value="<?=$brand_data['lyear_title']?>" />
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" for="input">Year Tooltip</label>
												<div class="controls">
													<textarea class="form-control wysihtml5" name="tooltip_lyear" rows="5"><?=$brand_data['tooltip_lyear']?></textarea>
												</div>
											</div>
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
															<?php /*?><div class="input-prepend input-append">
																<?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
																<input type="number" class="input-small" id="lyear_price[<?=$lyear_id?>]" name="lyear_price[<?=$lyear_id?>]" value="<?=$lyear_item['lyear_price']?>" placeholder="Price">
																<?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
															</div><?php */?>
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
												<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="device_categories.php" class="btn btn-alt btn-large btn-black">Back</a>
											</div>
										</div>
									</div>
								</div>
								
								<div class="tab-pane" id="tab16">
									<div class="row-fluid">
										<div class="span8">
											<div class="control-group">
												<label class="control-label" for="processor_title">Processor Title</label>
												<div class="controls">
													<input type="text" class="input-xlarge" name="processor_title" value="<?=$brand_data['processor_title']?>" />
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" for="input">Processor Tooltip</label>
												<div class="controls">
													<textarea class="form-control wysihtml5" name="tooltip_processor" rows="5"><?=$brand_data['tooltip_processor']?></textarea>
												</div>
											</div>
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
															<?php /*?><div class="input-prepend input-append">
																<?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
																<input type="number" class="input-small" id="processor_price[<?=$processor_id?>]" name="processor_price[<?=$processor_id?>]" value="<?=$processor_item['processor_price']?>" placeholder="Price">
																<?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
															</div><?php */?>
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
												<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="device_categories.php" class="btn btn-alt btn-large btn-black">Back</a>
											</div>
										</div>
									</div>
								</div>

								<div class="tab-pane" id="tab17">
									<div class="row-fluid">
										<div class="span8">
											<div class="control-group">
												<label class="control-label" for="ram_title">Ram (Memory) Title</label>
												<div class="controls">
													<input type="text" class="input-xlarge" name="ram_title" value="<?=$brand_data['ram_title']?>" />
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" for="input">Ram (Memory) Tooltip</label>
												<div class="controls">
													<textarea class="form-control wysihtml5" name="tooltip_ram" rows="5"><?=$brand_data['tooltip_ram']?></textarea>
												</div>
											</div>
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
															<?php /*?><div class="input-prepend input-append">
																<?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
																<input type="number" class="input-small" id="ram_price[<?=$ram_id?>]" name="ram_price[<?=$ram_id?>]" value="<?=$ram_item['ram_price']?>" placeholder="Price">
																<?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
															</div><?php */?>
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
												<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="device_categories.php" class="btn btn-alt btn-large btn-black">Back</a>
											</div>
										</div>
									</div>
								</div>
								
							</div>
						</div>
					</div>
					<input type="hidden" name="id" value="<?=$brand_data['id']?>" />
					</form>
                </section>
            </article>
        </div>
    </section>
	<div id="push"></div>
</div>