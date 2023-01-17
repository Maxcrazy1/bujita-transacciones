<?php
require_once("../_config/config.php");
require_once("../include/functions.php");

$field_type = $_REQUEST['field_type'];
$cat_id = $_REQUEST['cat_id'];
$fields_cat_type = $_REQUEST['fields_cat_type'];

if($cat_id>0) {
	$storage_items_array = get_category_storage_data($cat_id);
	$condition_items_array = get_category_condition_data($cat_id);
	$network_items_array = get_category_networks_data($cat_id);
	$connectivity_items_array = get_category_connectivity_data($cat_id);
	$watchtype_items_array = get_category_watchtype_data($cat_id);
	$case_material_items_array = get_category_case_material_data($cat_id);
	$case_size_items_array = get_category_case_size_data($cat_id);
	$color_items_array = get_category_color_data($cat_id);
	$accessories_items_array = get_category_accessories_data($cat_id);
	$screen_size_items_array = get_category_screen_size_data($cat_id);
	$screen_resolution_items_array = get_category_screen_resolution_data($cat_id);
	$lyear_items_array = get_category_lyear_data($cat_id);
	$processor_items_array = get_category_processor_data($cat_id);
	$ram_items_array = get_category_ram_data($cat_id);

	if($field_type == "tabs") {
		if($fields_cat_type == "mobile") { ?>
			<li class="active"><a href="#tab1" data-toggle="tab">Basic</a></li>
			<li><a href="#tab8" data-toggle="tab">Metadata</a></li>
			<li><a href="#tab4" data-toggle="tab">Network</a></li>
			<li><a href="#tab2" data-toggle="tab">Storage</a></li>
			<!--<li><a href="#tab11" data-toggle="tab">Color</a></li>-->
			<li><a href="#tab3" data-toggle="tab">Condition</a></li>
			<!--<li><a href="#tab12" data-toggle="tab">Accessories</a></li>-->
		<?php
		}
		if($fields_cat_type == "tablet") { ?>
			<li class="active"><a href="#tab1" data-toggle="tab">Basic</a></li>
			<li><a href="#tab8" data-toggle="tab">Metadata</a></li>
			<li><a href="#tab7" data-toggle="tab">Type</a></li>
			<!--<li><a href="#tab4" data-toggle="tab">Network</a></li>-->
			<li><a href="#tab2" data-toggle="tab">Storage</a></li>
			<!--<li><a href="#tab11" data-toggle="tab">Color</a></li>-->
			<li><a href="#tab3" data-toggle="tab">Condition</a></li>
			<!--<li><a href="#tab12" data-toggle="tab">Accessories</a></li>-->
		<?php
		}
		if($fields_cat_type == "watch") { ?>
			<li class="active"><a href="#tab1" data-toggle="tab">Basic</a></li>
			<li><a href="#tab8" data-toggle="tab">Metadata</a></li>
			<li><a href="#tab7" data-toggle="tab">Type</a></li>
			<!--<li><a href="#tab4" data-toggle="tab">Network</a></li>
			<li><a href="#tab2" data-toggle="tab">Storage</a></li>-->
			<li><a href="#tab10" data-toggle="tab">Case Material</a></li>
			<li><a href="#tab6" data-toggle="tab">Case Size</a></li>
			<!--<li><a href="#tab11" data-toggle="tab">Color</a></li>-->
			<li><a href="#tab3" data-toggle="tab">Condition</a></li>
			<!--<li><a href="#tab12" data-toggle="tab">Accessories</a></li>-->
		<?php
		}
		if($fields_cat_type == "laptop") { ?>
			<li class="active"><a href="#tab1" data-toggle="tab">Basic</a></li>
			<li><a href="#tab8" data-toggle="tab">Metadata</a></li>
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
		}
	}
	
	if($field_type == "storage" && ($fields_cat_type=="mobile" || $fields_cat_type=="tablet" || $fields_cat_type=="watch" || $fields_cat_type=="laptop")) { ?>
		<div class="form-controls">
		<?php
		if(!empty($storage_items_array)) {
			foreach($storage_items_array as $key=>$storage_item) {
				$storage_id = $storage_item['id']; ?>
				<div id="<?=$key?>" style="margin-top:5px;">
					<input type="text" class="input-small" id="storage_size[]" name="storage_size[]" value="<?=html_entities($storage_item['storage_size'])?>" placeholder="Storage Sizes">
					<select class="span2" name="storage_size_postfix[]" id="storage_size_postfix[]" style="width:70px;">
						<option value="GB" <?php if($storage_item['storage_size_postfix']=='GB'){echo 'selected="selected"';}?>>GB</option>
						<option value="TB" <?php if($storage_item['storage_size_postfix']=='TB'){echo 'selected="selected"';}?>>TB</option>
						<option value="MB" <?php if($storage_item['storage_size_postfix']=='MB'){echo 'selected="selected"';}?>>MB</option>
					</select>
					
					<?php /*?><div class="input-prepend input-append">
						<?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
						<input type="number" class="input-small" id="storage_price[]" name="storage_price[]" value="<?=$storage_item['storage_price']?>" placeholder="Price">
						<?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
					</div><?php */?>
															
					<?php
					if($top_seller_mode == "storage_specific") { ?>
					<select class="span2" name="top_seller[]" id="top_seller[]" style="width:100px;">
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
	<?php
	}
	
	if($field_type == "condition" && ($fields_cat_type=="mobile" || $fields_cat_type=="tablet" || $fields_cat_type=="watch" || $fields_cat_type=="laptop")) {
		if(!empty($condition_items_array)) {
			foreach($condition_items_array as $c_key=>$condition_data) {
				$condition_id = $condition_data['id']; ?>
		
				<div class="row" id="cnd<?=$c_key?>" style="margin-top:5px;">
					<div class="span1.5">
						<div class="control-group">
							<label class="control-label" for="input">Name</label>
							<div class="controls">
								 <input type="text" class="input-small" id="condition_name[]" name="condition_name[]" value="<?=html_entities($condition_data['condition_name'])?>" placeholder="Name">
							</div>
						</div>
					</div>
					
					<?php /*?><div class="span1.5">
						<div class="control-group">
							<label class="control-label" for="input">Price</label>
							<div class="controls">
								<div class="input-prepend input-append">
								 <?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
								 <input type="number" class="input-small" id="condition_price[]" name="condition_price[]" value="<?=$condition_data['condition_price']?>" placeholder="Price">
								 <?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
								 </div>
							</div>
						</div>
					</div><?php */?>
													
					<div class="span5">
						<div class="control-group">
							<label class="control-label" for="input">Terms</label>
							<div class="controls">
								 <textarea class="form-control span5" name="condition_terms[]" id="condition_terms[]" placeholder="Terms"><?=$condition_data['condition_terms']?></textarea>
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
		}
	}
	
	if($field_type == "network" && ($fields_cat_type=="mobile" || $fields_cat_type=="tablet" || $fields_cat_type=="watch" || $fields_cat_type=="laptop")) {
		if(!empty($network_items_array)) {
			foreach($network_items_array as $n_key=>$network_data) {
				$network_id = $network_data['id']; ?>
				<div class="row" id="nvk<?=$n_key?>">
					<div class="span1.5">
						<div class="control-group">
							<label class="control-label" for="input">Name</label>
							<div class="controls">
								 <input type="text" class="input-medium" id="network_name[]" name="network_name[]" value="<?=html_entities($network_data['network_name'])?>" placeholder="Name">
							</div>
						</div>
					</div>
					
					<?php /*?><div class="span1.5">
						<div class="control-group">
							<label class="control-label" for="input">Price</label>
							<div class="controls">
								<div class="input-prepend input-append">
								 <?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
								 <input type="number" class="input-small" id="network_price[]" name="network_price[]" value="<?=$network_data['network_price']?>" style="width:50px;" placeholder="Price">
								 <?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
								</div>
							</div>
						</div>
					</div><?php */?>
					
					<?php /*?><div class="span1.5">
						<div class="control-group">
							<label class="control-label" for="input">Unlock Price</label>
							<div class="controls">
								<div class="input-prepend input-append">
								 <?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
								 <input type="number" class="input-small" id="network_unlock_price[]" name="network_unlock_price[]" value="<?=$network_data['network_unlock_price']?>" style="width:50px;" placeholder="Price">
								 <?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
								</div>
							</div>
						</div>
					</div><?php */?>
												
					<div class="span1.5">
						<div class="control-group">
							<label class="control-label" for="input">Icon</label>
							<div class="controls">
								 <input type="file" name="network_icon[]" id="network_icon[]" style="width:95px;"/>
								 <input type="hidden" name="old_network_icon[]" id="old_network_icon[]" value="<?=$network_data['network_icon']?>"/>
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
		}
	}

	/*if($field_type == "connectivity" && $fields_cat_type=="tablet") {
	?>
		<div class="form-controls">
		<?php
		if(!empty($connectivity_items_array)) {
			foreach($connectivity_items_array as $key=>$connectivity_item) {
				$connectivity_id = $connectivity_item['id']; ?>
				<div id="clr<?=$key?>" style="margin-top:5px;">
					<input type="text" class="input-large" id="connectivity_name[]" name="connectivity_name[]" value="<?=$connectivity_item['connectivity_name']?>" placeholder="Name">
					
					<div class="input-prepend input-append">
						<?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
						<input type="number" class="input-small" id="connectivity_price[]" name="connectivity_price[]" value="<?=$connectivity_item['connectivity_price']?>" placeholder="Price">
						<?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
					</div>
															
					<a href="javascript:void(0);" class="remove_connectivity_item" id="rm_clr<?=$key?>"><i class="icon-remove-sign"></i></a>
				</div>
				<script>remove_connectivity_item();</script>
			<?php
			}
		} ?>
		</div>
	<?php
	}*/

	if($field_type == "watchtype" && ($fields_cat_type=="mobile" || $fields_cat_type=="tablet" || $fields_cat_type=="watch" || $fields_cat_type=="laptop")) {
	?>
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
								<input type="text" class="input-large" id="watchtype_name[]" name="watchtype_name[]" value="<?=html_entities($watchtype_item['watchtype_name'])?>" placeholder="Name">
							</div>
						</div>
					</div>
					<?php /*?><div class="span1.5">
						<div class="control-group">
							<label class="control-label" for="input">&nbsp;</label>
							<div class="controls">
								<div class="input-prepend input-append">
									<?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
									<input type="number" class="input-small" id="watchtype_price[]" name="watchtype_price[]" value="<?=$watchtype_item['watchtype_price']?>" placeholder="Price">
									<?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
								</div>
							</div>
						</div>
					</div><?php */?>
					<div class="span1.5">
						<div class="control-group">
							<label class="control-label" for="input">Network</label>
							<div class="controls">
							
								<select class="span2" name="disabled_network[]" id="disabled_network[]">
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
	<?php
	}
	
	if($field_type == "case_material" && $fields_cat_type=="watch") {
	?>
		<div class="form-controls">
		<?php
		if(!empty($case_material_items_array)) {
			foreach($case_material_items_array as $key=>$case_material_item) {
				$case_material_id = $case_material_item['id']; ?>
				<div id="accssr<?=$key?>" style="margin-top:5px;">
					<input type="text" class="input-large" id="case_material_name[]" name="case_material_name[]" value="<?=html_entities($case_material_item['case_material_name'])?>" placeholder="Name">
					
					<?php /*?><div class="input-prepend input-append">
						<?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
						<input type="number" class="input-small" id="case_material_price[]" name="case_material_price[]" value="<?=$case_material_item['case_material_price']?>" placeholder="Price">
						<?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
					</div><?php */?>
					
					<a href="javascript:void(0);" class="remove_case_material_item" id="rm_accssr<?=$key?>"><i class="icon-remove-sign"></i></a>
				</div>
				<script>remove_case_material_item();</script>
			<?php
			}
		} ?>
		</div>
	<?php
	}

	if($field_type == "case_size" && $fields_cat_type=="watch") {
	?>
		<div class="form-controls">
		<?php
		if(!empty($case_size_items_array)) {
			foreach($case_size_items_array as $key=>$case_size_item) {
				$case_size_id = $case_size_item['id']; ?>
				<div id="misc<?=$key?>" style="margin-top:5px;">
					<input type="text" class="input-large" id="case_size[]" name="case_size[]" value="<?=html_entities($case_size_item['case_size'])?>" placeholder="Case Size">
					
					<?php /*?><div class="input-prepend input-append">
						<?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
						<input type="number" class="input-small" id="case_size_price[]" name="case_size_price[]" value="<?=$case_size_item['case_size_price']?>" placeholder="Price">
						<?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
					</div><?php */?>
					
					<a href="javascript:void(0);" class="remove_case_size_item" id="rm_misc<?=$key?>"><i class="icon-remove-sign"></i></a>
				</div>
				<script>remove_case_size_item();</script>
			<?php
			}
		} ?>
		</div>
	<?php
	}
	
	if($field_type == "color" && ($fields_cat_type=="mobile" || $fields_cat_type=="tablet" || $fields_cat_type=="watch" || $fields_cat_type=="laptop")) {
	?>
		<div class="form-controls">
		<?php
		if(!empty($color_items_array)) {
			foreach($color_items_array as $key=>$color_item) {
				$color_id = $color_item['id']; ?>
				<div id="accssr<?=$key?>" style="margin-top:5px;">
					<input type="text" class="input-large" id="color_name[]" name="color_name[]" value="<?=html_entities($color_item['color_name'])?>" placeholder="Name">
					<input type="color" class="input-small" id="color_code[]" name="color_code[]" value="<?=html_entities($color_item['color_code'])?>" placeholder="Color Code">
					<?php /*?><div class="input-prepend input-append">
						<?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
						<input type="number" class="input-small" id="color_price[]" name="color_price[]" value="<?=$color_item['color_price']?>" placeholder="Price">
						<?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
					</div><?php */?>
					
					<a href="javascript:void(0);" class="remove_color_item" id="rm_accssr<?=$key?>"><i class="icon-remove-sign"></i></a>
				</div>
				<script>remove_color_item();</script>
			<?php
			}
		} ?>
		</div>
	<?php
	}
	
	if($field_type == "accessories" && ($fields_cat_type=="mobile" || $fields_cat_type=="tablet" || $fields_cat_type=="watch" || $fields_cat_type=="laptop")) {
	?>
		<div class="form-controls">
		<?php
		if(!empty($accessories_items_array)) {
			foreach($accessories_items_array as $key=>$accessories_item) {
				$accessories_id = $accessories_item['id']; ?>
				<div id="accssr<?=$key?>" style="margin-top:5px;">
					<input type="text" class="input-large" id="accessories_name[]" name="accessories_name[]" value="<?=html_entities($accessories_item['accessories_name'])?>" placeholder="Name">
					
					<?php /*?><div class="input-prepend input-append">
						<?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
						<input type="number" class="input-small" id="accessories_price[]" name="accessories_price[]" value="<?=$accessories_item['accessories_price']?>" placeholder="Price">
						<?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
					</div><?php */?>
					
					<a href="javascript:void(0);" class="remove_accessories_item" id="rm_accssr<?=$key?>"><i class="icon-remove-sign"></i></a>
				</div>
				<script>remove_accessories_item();</script>
			<?php
			}
		} ?>
		</div>
	<?php
	}
	
	if($field_type == "screen_size" && $fields_cat_type=="laptop") {
	?>
		<div class="form-controls">
		<?php
		if(!empty($screen_size_items_array)) {
			foreach($screen_size_items_array as $key=>$screen_size_item) {
				$screen_size_id = $screen_size_item['id']; ?>
				<div id="accssr<?=$key?>" style="margin-top:5px;">
					<input type="text" class="input-large" id="screen_size_name[]" name="screen_size_name[]" value="<?=html_entities($screen_size_item['screen_size_name'])?>" placeholder="Name">
					
					<?php /*?><div class="input-prepend input-append">
						<?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
						<input type="number" class="input-small" id="screen_size_price[]" name="screen_size_price[]" value="<?=$screen_size_item['screen_size_price']?>" placeholder="Price">
						<?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
					</div><?php */?>
					
					<a href="javascript:void(0);" class="remove_screen_size_item" id="rm_accssr<?=$key?>"><i class="icon-remove-sign"></i></a>
				</div>
				<script>remove_screen_size_item();</script>
			<?php
			}
		} ?>
		</div>
	<?php
	}
	
	if($field_type == "screen_resolution" && $fields_cat_type=="laptop") {
	?>
		<div class="form-controls">
		<?php
		if(!empty($screen_resolution_items_array)) {
			foreach($screen_resolution_items_array as $key=>$screen_resolution_item) {
				$screen_resolution_id = $screen_resolution_item['id']; ?>
				<div id="accssr<?=$key?>" style="margin-top:5px;">
					<input type="text" class="input-large" id="screen_resolution_name[]" name="screen_resolution_name[]" value="<?=html_entities($screen_resolution_item['screen_resolution_name'])?>" placeholder="Name">
					
					<?php /*?><div class="input-prepend input-append">
						<?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
						<input type="number" class="input-small" id="screen_resolution_price[]" name="screen_resolution_price[]" value="<?=$screen_resolution_item['screen_resolution_price']?>" placeholder="Price">
						<?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
					</div><?php */?>
					
					<a href="javascript:void(0);" class="remove_screen_resolution_item" id="rm_accssr<?=$key?>"><i class="icon-remove-sign"></i></a>
				</div>
				<script>remove_screen_resolution_item();</script>
			<?php
			}
		} ?>
		</div>
	<?php
	}
	
	if($field_type == "lyear" && $fields_cat_type=="laptop") {
	?>
		<div class="form-controls">
		<?php
		if(!empty($lyear_items_array)) {
			foreach($lyear_items_array as $key=>$lyear_item) {
				$lyear_id = $lyear_item['id']; ?>
				<div id="accssr<?=$key?>" style="margin-top:5px;">
					<input type="text" class="input-large" id="lyear_name[]" name="lyear_name[]" value="<?=html_entities($lyear_item['lyear_name'])?>" placeholder="Name">
					
					<?php /*?><div class="input-prepend input-append">
						<?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
						<input type="number" class="input-small" id="lyear_price[]" name="lyear_price[]" value="<?=$lyear_item['lyear_price']?>" placeholder="Price">
						<?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
					</div><?php */?>
					
					<a href="javascript:void(0);" class="remove_lyear_item" id="rm_accssr<?=$key?>"><i class="icon-remove-sign"></i></a>
				</div>
				<script>remove_lyear_item();</script>
			<?php
			}
		} ?>
		</div>
	<?php
	}
	
	if($field_type == "processor" && $fields_cat_type=="laptop") {
	?>
		<div class="form-controls">
		<?php
		if(!empty($processor_items_array)) {
			foreach($processor_items_array as $key=>$processor_item) {
				$processor_id = $processor_item['id']; ?>
				<div id="accssr<?=$key?>" style="margin-top:5px;">
					<input type="text" class="input-large" id="processor_name[]" name="processor_name[]" value="<?=html_entities($processor_item['processor_name'])?>" placeholder="Name">
					
					<?php /*?><div class="input-prepend input-append">
						<?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
						<input type="number" class="input-small" id="processor_price[]" name="processor_price[]" value="<?=$processor_item['processor_price']?>" placeholder="Price">
						<?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
					</div><?php */?>
					
					<a href="javascript:void(0);" class="remove_processor_item" id="rm_accssr<?=$key?>"><i class="icon-remove-sign"></i></a>
				</div>
				<script>remove_processor_item();</script>
			<?php
			}
		} ?>
		</div>
	<?php
	}

	if($field_type == "ram" && $fields_cat_type=="laptop") {
	?>
		<div class="form-controls">
		<?php
		if(!empty($ram_items_array)) {
			foreach($ram_items_array as $key=>$ram_item) {
				$ram_id = $ram_item['id']; ?>
				<div id="accssr<?=$key?>" style="margin-top:5px;">
					<input type="text" class="input-small" id="ram_size[]" name="ram_size[]" value="<?=html_entities($ram_item['ram_size'])?>" placeholder="Ram Size">
					<select class="span2" name="ram_size_postfix[]" id="ram_size_postfix[]" style="width:70px;">
						<option value="GB" <?php if($ram_item['ram_size_postfix']=='GB'){echo 'selected="selected"';}?>>GB</option>
						<option value="TB" <?php if($ram_item['ram_size_postfix']=='TB'){echo 'selected="selected"';}?>>TB</option>
						<option value="MB" <?php if($ram_item['ram_size_postfix']=='MB'){echo 'selected="selected"';}?>>MB</option>
					</select>
					
					<?php /*?><div class="input-prepend input-append">
						<?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
						<input type="number" class="input-small" id="ram_price[]" name="ram_price[]" value="<?=$ram_item['ram_price']?>" placeholder="Price">
						<?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
					</div><?php */?>
					
					<a href="javascript:void(0);" class="remove_ram_item" id="rm_accssr<?=$key?>"><i class="icon-remove-sign"></i></a>
				</div>
				<script>remove_ram_item();</script>
			<?php
			}
		} ?>
		</div>
	<?php
	}
} ?>
