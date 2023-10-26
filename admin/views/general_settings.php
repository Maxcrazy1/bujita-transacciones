<script type="text/javascript">
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

function chg_mailer_type(type) {
	if(type=="smtp") {
		$(".showhide_smtp_fields").show();
		$(".showhide_emailapi_fields").hide();
	} else if(type=="sendgrid") {
		$(".showhide_smtp_fields").hide();
		$(".showhide_emailapi_fields").show();
	} else {
		$(".showhide_smtp_fields").hide();
		$(".showhide_emailapi_fields").hide();
	}
}
</script>

<div id="wrapper">
    <header id="header" class="container">
    	<?php include("include/admin_menu.php"); ?>
    </header>

	<section class="container" role="main">
		<div class="row">
            <article class="span12 data-block">
				<header><h2>Settings</h2></header>
				<section class="tab-content">
					<?php include('confirm_message.php');?>
					<form action="controllers/general_settings.php" role="form" class="form-inline no-margin" method="post" enctype="multipart/form-data">
						<div class="tab-pane active">
							<!-- Second level tabs -->
							<div class="tabbable tabs-left">
								<ul class="nav nav-tabs">
									<li class="active"><a href="#tab1" data-toggle="tab">General Settings</a></li>
									<li><a href="#tab4" data-toggle="tab">Company Details</a></li>
									<li><a href="#tab2" data-toggle="tab">Email Settings</a></li>
									<li><a href="#tab3" data-toggle="tab">Socials Settings</a></li>
									<li><a href="#tab6" data-toggle="tab">SMS Settings</a></li>
									<li><a href="#tab5" data-toggle="tab">Blog Settings</a></li>
									<li><a href="#tab7" data-toggle="tab">Home Page</a></li>
									<li><a href="#tab8" data-toggle="tab">Shipping API</a></li>
									<li><a href="#tab9" data-toggle="tab">Sitemap (XML)</a></li>
									<?php /*?><li><a href="#tab10" data-toggle="tab">Free Postage Label</a></li><?php */?>
									<li><a href="#tab15" data-toggle="tab">Captcha Settings</a></li>
									<li><a href="#tab16" data-toggle="tab">Menu Type Settings</a></li>
									<?php /*?><li><a href="#tab10" data-toggle="tab">Language</a></li><?php */?>
									<li><a href="starbuck_locations.php">Starbuck Locations</a></li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane" id="tab8">
										<div class="span7">
											<h3>Shipping API Settings</h3>
											<div class="control-group">
												<label class="control-label" for="published">Shipping API</label>
												<div class="controls">
													<select class="form-control" name="shipping_api" id="shipping_api">
														<option value=""> -Select- </option>							
												   		<option value="royal_mail" <?php if($general_setting_data['shipping_api']=='royal_mail'){echo 'selected="selected"';}?>>Royal Mail</option>
														<option value="easypost" <?php if($general_setting_data['shipping_api']=='easypost'){echo 'selected="selected"';}?>>Easy Post</option>
												    </select>
													
												</div>
												<label class="checkbox custom-checkbox">
													<input id="shipment_generated_by_cust" type="checkbox" value="1" name="shipment_generated_by_cust" <?php if($general_setting_data['shipment_generated_by_cust']=='1'){echo 'checked="checked"';}?>>
														Allow Shipment Generated to Customer
												</label>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="input">Shipping API Key</label>
												<div class="controls">
													<input type="text" class="input-xlarge" id="shipping_api_key" value="<?=$general_setting_data['shipping_api_key']?>" name="shipping_api_key">
												</div>
											</div>
											
											<div class="control-group radio-inline">
												<label class="control-label" for="published">Default Carrier Account</label>
												<div class="controls">
													<label class="radio custom-radio">
														<input type="radio" id="default_carrier_account1" name="default_carrier_account" value="usps" <?=($general_setting_data['default_carrier_account']=="usps"||$general_setting_data['default_carrier_account']==""?'checked="checked"':'')?>>
														USPS
													</label>
													<label class="radio custom-radio">
														<input type="radio" id="default_carrier_account2" name="default_carrier_account" value="ups" <?=($general_setting_data['default_carrier_account']=="ups"?'checked="checked"':'')?>>
														UPS
													</label>
													<label class="radio custom-radio">
														<input type="radio" id="default_carrier_account3" name="default_carrier_account" value="fedex" <?=($general_setting_data['default_carrier_account']=="fedex"?'checked="checked"':'')?>>
														FedEx
													</label>
													<label class="radio custom-radio">
														<input type="radio" id="default_carrier_account4" name="default_carrier_account" value="dhl" <?=($general_setting_data['default_carrier_account']=="dhl"?'checked="checked"':'')?>>
														DHL
													</label>
													<label class="radio custom-radio">
														<input type="radio" id="default_carrier_account5" name="default_carrier_account" value="other" <?=($general_setting_data['default_carrier_account']=="other"?'checked="checked"':'')?>>
														Other
													</label>
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="input">Carrier Account ID</label>
												<div class="controls">
													<input type="text" class="input-xlarge" id="carrier_account_id" value="<?=$general_setting_data['carrier_account_id']?>" name="carrier_account_id">
												</div>
											</div>
											
											
											<div class="control-group">
												<label class="control-label" for="input">Shipping Parcel Length</label>
												<div class="controls">
													<input type="text" class="input-xlarge" id="shipping_parcel_length" value="<?=$general_setting_data['shipping_parcel_length']?>" name="shipping_parcel_length" placeholder="20.2">
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="input">Shipping Parcel Width</label>
												<div class="controls">
													<input type="text" class="input-xlarge" id="shipping_parcel_width" value="<?=$general_setting_data['shipping_parcel_width']?>" name="shipping_parcel_width" placeholder="10.9">
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="input">Shipping Parcel Height</label>
												<div class="controls">
													<input type="text" class="input-xlarge" id="shipping_parcel_height" value="<?=$general_setting_data['shipping_parcel_height']?>" name="shipping_parcel_height" placeholder="5">
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="input">Shipping Parcel Weight</label>
												<div class="controls">
													<input type="text" class="input-xlarge" id="shipping_parcel_weight" value="<?=$general_setting_data['shipping_parcel_weight']?>" name="shipping_parcel_weight" placeholder="65.9">
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="input">Webhook URL</label>
												<div class="controls">
													<input type="text" class="input-xlarge" value="<?=SITE_URL?>controllers/easypost_hook.php" readonly="">
												</div>
											</div>
											
											<div class="form-actions">
												<button class="btn btn-alt btn-large btn-primary" type="submit" name="general_setting"><?=($device_id?'Update':'Save')?></button>
											</div>
										</div>
									</div>
									<div class="tab-pane active" id="tab1">
										<div class="span7">
											<h3>General Settings</h3>
											<div class="control-group">
												<label class="control-label" for="input">Admin Panel Name</label>
												<div class="controls">
													<input type="text" class="input-xlarge" id="admin_panel_name" value="<?=$general_setting_data['admin_panel_name']?>" name="admin_panel_name">
												</div>
											</div>

											<div class="control-group">
												<label class="control-label" for="fileInput">Front Logo</label>
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
																	<input type="file" class="form-control" id="logo" name="logo" onChange="checkFile(this)">
															</span>
															<a href="javascript:void(0);" class="btn btn-alt btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a>
														</div>
													</div>
													
													<?php 
													if($general_setting_data['logo']!="") { ?>
														<div class="fileupload fileupload-new" data-provides="fileupload">
															<div class="fileupload-new thumbnail"><img src="../images/<?=$general_setting_data['logo'].'?uniqid='.uniqid();?>" width="200"></div>
															<div class="fileupload-preview fileupload-exists fileupload-large flexible thumbnail"></div>
															<div>
																<a class="btn btn-alt btn-danger" data-dismiss="fileupload" href="controllers/general_settings.php?r_logo_id=<?=$general_setting_data['id']?>" onclick="return confirm('Are you sure to delete logo?');">Remove</a>
															</div>
														</div>
													<?php 
													} ?>	 
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="input">Site Name</label>
												<div class="controls">
													<input type="text" class="input-xlarge" id="site_name" value="<?=$general_setting_data['site_name']?>" name="site_name">
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="input">Website</label>
												<div class="controls">
													<input type="text" class="input-xlarge" id="field-1" value="<?=$general_setting_data['website']?>" name="website">
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="input">Header/Footer Phone</label>
												<div class="controls">
													<input type="text" class="input-xlarge" id="phone" value="<?=$general_setting_data['phone']?>"  name="phone">
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="input">Header/Footer Email</label>
												<div class="controls">
													<input type="text" class="input-xlarge" id="email" value="<?=$general_setting_data['email']?>"  name="email">
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="input">Copyright</label>
												<div class="controls">
													<input type="text" class="input-xlarge" id="field-1" value="<?=$general_setting_data['copyright']?>" name="copyright">
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="input">Map Key</label>
												<div class="controls">
													<input type="text" class="input-xlarge" id="map_key" value="<?=$general_setting_data['map_key']?>" name="map_key">
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="input">News Blog Link</label>
												<div class="controls">
													<input type="text" class="input-xlarge" id="news_blog_link" value="<?=$general_setting_data['news_blog_link']?>" name="news_blog_link">
												</div>
												<div class="controls">
													<label class="radio custom-radio">
														<input type="radio" name="news_blog_link_open" value="same" <?=($general_setting_data['news_blog_link_open']=='same'||$general_setting_data['news_blog_link_open']==''?'checked="checked"':'')?>>
														Same Window
													</label>
													<label class="radio custom-radio">
														<input type="radio" name="news_blog_link_open" value="new" <?=($general_setting_data['news_blog_link_open']=='new'?'checked="checked"':'')?>>
														New Window
													</label>
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="timezone">Timezone</label>
												<div class="controls">
												<select id="timezone" name="timezone" class="form-control">
												<?php
												$timezone_list = time_zonelist();
												if(!empty($timezone_list)) {
													foreach($timezone_list as $timezone_data) {
														$selected="";
														if($general_setting_data['timezone']==$timezone_data['value']) {
															$selected='selected="selected"';
														} ?>
														<option value="<?=$timezone_data['value']?>" <?=$selected?> ><?=$timezone_data['display']?></option>
													<?php 
													} 
												}?>
												</select>
												</div>
												<small>Default TIME ZONE saved in Database is UTC.</small>
											</div>
									
											<div class="control-group">
												<label class="control-label" for="input">Time Format</label>
												<div class="controls">
													<select class="form-control" id="time_format" name="time_format">
														<option value="">Select Time Format</option>
														<option value="12_hour" <?php if($general_setting_data['time_format']=='12_hour'){echo 'selected="selected"';}?>>12 hour</option>
														<option value="24_hour" <?php if($general_setting_data['time_format']=='24_hour'){echo 'selected="selected"';}?>>24 hour</option>
													</select>
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="input">Date Format</label>
												<div class="controls">
												   <select class="form-control" id="date_format" name="date_format">
													  <option value="m/d/Y" <?php if($general_setting_data['date_format']=='m/d/Y'){echo 'selected="selected"';}?>>m/d/Y ex. <?=date("m/d/Y")?></option>
													  <option value="d-m-Y" <?php if($general_setting_data['date_format']=='d-m-Y'){echo 'selected="selected"';}?>>d-m-Y ex. <?=date("d-m-Y")?></option>
													  <option value="M/d/Y" <?php if($general_setting_data['date_format']=='M/d/Y'){echo 'selected="selected"';}?>>M/d/Y ex. <?=date("M/d/Y")?></option>
													  <option value="d-M-Y" <?php if($general_setting_data['date_format']=='d-M-Y'){echo 'selected="selected"';}?>>d-M-Y ex. <?=date("d-M-Y")?></option>
													  <option value="m/d/y" <?php if($general_setting_data['date_format']=='m/d/y'){echo 'selected="selected"';}?>>m/d/y ex. <?=date("m/d/y")?></option>
													  <option value="d-m-y" <?php if($general_setting_data['date_format']=='d-m-y'){echo 'selected="selected"';}?>>d-m-y ex. <?=date("d-m-y")?></option>
													  <option value="M/d/y" <?php if($general_setting_data['date_format']=='M/d/y'){echo 'selected="selected"';}?>>M/d/y ex. <?=date("M/d/y")?></option>
													  <option value="d-M-y" <?php if($general_setting_data['date_format']=='d-M-y'){echo 'selected="selected"';}?>>d-M-y ex. <?=date("d-M-y")?></option>
												   </select>
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="input">IMEI Api Key</label>
												<div class="controls">
													<input type="text" class="input-xlarge" id="imei_api_key" value="<?=$general_setting_data['imei_api_key']?>" name="imei_api_key">
												</div>
											</div>
											
											<div class="control-group radio-inline">
												<label class="control-label" for="published">Status of Terms & Conditions</label>
												<div class="controls">
													<label class="radio custom-radio">
														<input type="radio" id="terms_status" name="terms_status" value="1" <?=($general_setting_data['terms_status']=='1'||$general_setting_data['disp_currency']==''?'checked="checked"':'')?>>
														Enable
													</label>
													<label class="radio custom-radio">
														<input type="radio" id="terms_status" name="terms_status" value="0" <?=($general_setting_data['terms_status']=='0'?'checked="checked"':'')?>>
														Disable
													</label>
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="published">Display Terms & Conditions</label>
												<div class="controls">
													<label class="checkbox custom-checkbox">
														<input id="display_terms" type="checkbox" value="ac_creation" name="display_terms[ac_creation]" <?php if($display_terms['ac_creation']=="ac_creation"){echo 'checked="checked"';}?>>
														On Account Creation
													</label>
													<label class="checkbox custom-checkbox">
														<input id="display_terms" type="checkbox" value="confirm_sale" name="display_terms[confirm_sale]" <?php if($display_terms['confirm_sale']=="confirm_sale"){echo 'checked="checked"';}?>>
														On Confirm Sale	
													</label>
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="input">Terms & Conditions</label>
												<div class="controls">
													<textarea class="form-control wysihtml5" name="terms" rows="5"><?=$general_setting_data['terms']?></textarea>
												</div>
											</div>
											
											<div class="control-group radio-inline">
												<label class="control-label" for="show_model_storage">Show Model Storage</label>
												<div class="controls">
													<label class="radio custom-radio">
														<input type="radio" name="other_settings[show_model_storage]" value="models" <?=($other_settings['show_model_storage']=='models'||$other_settings['show_model_storage']==''?'checked="checked"':'')?>>
														Models
													</label>
													<label class="radio custom-radio">
														<input type="radio" name="other_settings[show_model_storage]" value="model_details" <?=($other_settings['show_model_storage']=='model_details'?'checked="checked"':'')?>>
														Model's Detail
													</label>
												</div>
											</div>
											
											<div class="control-group radio-inline">
												<label class="control-label" for="published">Show Missing Product Section</label>
												<div class="controls">
													<label class="radio custom-radio">
														<input type="radio" id="missing_product_section" name="missing_product_section" value="1" <?=($general_setting_data['missing_product_section']=='1'?'checked="checked"':'')?>>
														Yes
													</label>
													<label class="radio custom-radio">
														<input type="radio" id="missing_product_section" name="missing_product_section" value="0" <?=(intval($general_setting_data['missing_product_section'])=='0'?'checked="checked"':'')?>>
														No
													</label>
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="input">Top Seller Limit</label>
												<div class="controls">
													<input type="number" class="input-small" id="top_seller_limit" value="<?=$general_setting_data['top_seller_limit']?>" name="top_seller_limit">
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="input">Top Seller Mode</label>
												<div class="controls">
													<select class="form-control" id="top_seller_mode" name="top_seller_mode">
														<option value="model_specific" <?php if($general_setting_data['top_seller_mode']=='model_specific'){echo 'selected="selected"';}?>>Model Specific</option>
														<option value="storage_specific" <?php if($general_setting_data['top_seller_mode']=='storage_specific'){echo 'selected="selected"';}?>>Model's Storage Specific</option>
													</select>
												</div>
											</div>

											<div class="control-group">
												<label class="control-label" for="input">Order Prefix</label>
												<div class="controls">
													<input type="text" class="input-small" id="order_prefix" value="<?=$general_setting_data['order_prefix']?>" name="order_prefix" maxlength="5">
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="input">Order Expiring Days</label>
												<div class="controls">
													<input type="number" class="input-small" id="order_expiring_days" value="<?=$general_setting_data['order_expiring_days']?>" name="order_expiring_days" min="1" max="999">
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="input">Order Expired Days</label>
												<div class="controls">
													<input type="number" class="input-small" id="order_expired_days" value="<?=$general_setting_data['order_expired_days']?>" name="order_expired_days" min="1" max="999">
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="input">Page List Limit</label>
												<div class="controls">
													<select class="form-control" name="page_list_limit" id="page_list_limit">									
												   		<option value="5" <?php if($page_list_limit=='5'){echo 'selected="selected"';}?>>5</option>
														<option value="10" <?php if($page_list_limit=='10'){echo 'selected="selected"';}?>>10</option>
														<option value="15" <?php if($page_list_limit=='15'){echo 'selected="selected"';}?>>15</option>
														<option value="20" <?php if($page_list_limit=='20'){echo 'selected="selected"';}?>>20</option>
														<option value="25" <?php if($page_list_limit=='25'){echo 'selected="selected"';}?>>25</option>
														<option value="50" <?php if($page_list_limit=='50'){echo 'selected="selected"';}?>>50</option>
														<option value="100" <?php if($page_list_limit=='100'){echo 'selected="selected"';}?>>100</option>
														<option value="200" <?php if($page_list_limit=='200'){echo 'selected="selected"';}?>>200</option>
														<option value="500" <?php if($page_list_limit=='500'){echo 'selected="selected"';}?>>500</option>
												    </select>
												</div>
											</div>
											
											<div class="control-group radio-inline">
												<label class="control-label" for="published">Promocode Section</label>
												<div class="controls">
													<label class="radio custom-radio">
														<input type="radio" id="promocode_section_on" name="promocode_section" value="1" <?php if($general_setting_data['promocode_section']=='1'){echo 'checked="checked"';}?>>
														Yes
													</label>
													<label class="radio custom-radio">
														<input type="radio" id="promocode_section_off" name="promocode_section" value="0" <?php if($general_setting_data['promocode_section']=='0'){echo 'checked="checked"';}?>>
														No
													</label>
												</div>
											</div>

											<div class="control-group">
											   <label class="control-label" for="input">Currency</label>
											   <div class="controls">
												<select class="form-control" name="currency" id="currency">									  
												   <option value="AFN,؋" <?php if($currency[0]=='AFN'){echo 'selected="selected"';}?>>AFN(؋)</option>
												   <option value="ALL,Lek" <?php if($currency[0]=='ALL'){echo 'selected="selected"';}?>>ALL(Lek)</option>
												   <option value="USD,$" <?php if($currency[0]=='USD'){echo 'selected="selected"';}?>>USD($)</option>
												   <option value="EUR,€" <?php if($currency[0]=='EUR'){echo 'selected="selected"';}?>>EUR(€)</option>
												   <option value="AOA,Kz" <?php if($currency[0]=='AOA'){echo 'selected="selected"';}?>>AOA(Kz)</option>
												   <option value="XCD,$" <?php if($currency[0]=='XCD'){echo 'selected="selected"';}?>>XCD($)</option>
												   <option value="ARS,$" <?php if($currency[0]=='ARS'){echo 'selected="selected"';}?>>ARS($)</option>
												   <option value="AWG,ƒ" <?php if($currency[0]=='AWG'){echo 'selected="selected"';}?>>AWG(ƒ)</option>
												   <option value="AUD,$" <?php if($currency[0]=='AUD'){echo 'selected="selected"';}?>>AUD($)</option>
												   <option value="AZN,ман" <?php if($currency[0]=='AZN'){echo 'selected="selected"';}?>>AZN(ман)</option>
												   <option value="BSD,$" <?php if($currency[0]=='BSD'){echo 'selected="selected"';}?>>BSD($)</option>
												   <option value="BBD,$" <?php if($currency[0]=='BBD'){echo 'selected="selected"';}?>>BBD($)</option>
												   <option value="BYR,p." <?php if($currency[0]=='BYR'){echo 'selected="selected"';}?>>BYR(p.)</option>
												   <option value="BZD,BZ$" <?php if($currency[0]=='BZD'){echo 'selected="selected"';}?>>BZD(BZ$)</option>
												   <option value="BMD,$" <?php if($currency[0]=='BMD'){echo 'selected="selected"';}?>>BMD($)</option>
												   <option value="BOB,$b" <?php if($currency[0]=='BOB'){echo 'selected="selected"';}?>>BOB($b)</option>
												   <option value="BAM,KM" <?php if($currency[0]=='BAM'){echo 'selected="selected"';}?>>BAM(KM)</option>
												   <option value="BWP,P" <?php if($currency[0]=='BWP'){echo 'selected="selected"';}?>>BWP(P)</option>
												   <option value="NOK,kr" <?php if($currency[0]=='NOK'){echo 'selected="selected"';}?>>NOK(kr)</option>
												   <option value="BRL,R$" <?php if($currency[0]=='BRL'){echo 'selected="selected"';}?>>BRL(R$)</option>
												   <option value="BND,$" <?php if($currency[0]=='BND'){echo 'selected="selected"';}?>>BND($)</option>
												   <option value="BGN,лв" <?php if($currency[0]=='BGN'){echo 'selected="selected"';}?>>BGN(лв)</option>
												   <option value="KHR,៛" <?php if($currency[0]=='KHR'){echo 'selected="selected"';}?>>KHR(៛)</option>
												   <option value="XAF,FCF" <?php if($currency[0]=='XAF'){echo 'selected="selected"';}?>>XAF(FCF)</option>
												   <option value="CAD,$" <?php if($currency[0]=='CAD'){echo 'selected="selected"';}?>>CAD($)</option>
												   <option value="KYD,$" <?php if($currency[0]=='KYD'){echo 'selected="selected"';}?>>KYD($)</option>
												   <option value="CNY,¥" <?php if($currency[0]=='CNY'){echo 'selected="selected"';}?>>CNY(¥)</option>
												   <option value="COP,$" <?php if($currency[0]=='COP'){echo 'selected="selected"';}?>>COP($)</option>
												   <option value="NZD,$" <?php if($currency[0]=='NZD'){echo 'selected="selected"';}?>>NZD($)</option>
												   <option value="CRC,₡" <?php if($currency[0]=='CRC'){echo 'selected="selected"';}?>>CRC(₡)</option>
												   <option value="HRK,kn" <?php if($currency[0]=='HRK'){echo 'selected="selected"';}?>>HRK(kn)</option>
												   <option value="CUP,₱" <?php if($currency[0]=='CUP'){echo 'selected="selected"';}?>>CUP(₱)</option>
												   <option value="CZK,KĿ" <?php if($currency[0]=='CZK'){echo 'selected="selected"';}?>>CZK(KĿ)</option>
												   <option value="DKK,kr" <?php if($currency[0]=='DKK'){echo 'selected="selected"';}?>>DKK(kr)</option>
												   <option value="DOP,RD$" <?php if($currency[0]=='DOP'){echo 'selected="selected"';}?>>DOP(RD$)</option>
												   <option value="EGP,£" <?php if($currency[0]=='EGP'){echo 'selected="selected"';}?>>EGP(£)</option>
												   <option value="SVC,$" <?php if($currency[0]=='SVC'){echo 'selected="selected"';}?>>SVC($)</option>
												   <option value="ERN,Nfk" <?php if($currency[0]=='ERN'){echo 'selected="selected"';}?>>ERN(Nfk)</option>
												   <option value="EEK,kr" <?php if($currency[0]=='EEK'){echo 'selected="selected"';}?>>EEK(kr)</option>
												   <option value="FKP,£" <?php if($currency[0]=='FKP'){echo 'selected="selected"';}?>>FKP(£)</option>
												   <option value="FJD,$" <?php if($currency[0]=='FJD'){echo 'selected="selected"';}?>>FJD($)</option>
												   <option value="GMD,D" <?php if($currency[0]=='GMD'){echo 'selected="selected"';}?>>GMD(D)</option>
												   <option value="GHC,¢" <?php if($currency[0]=='GHC'){echo 'selected="selected"';}?>>GHC(¢)</option>
												   <option value="GIP,£" <?php if($currency[0]=='GIP'){echo 'selected="selected"';}?>>GIP(£)</option>
												   <option value="GTQ,Q" <?php if($currency[0]=='GTQ'){echo 'selected="selected"';}?>>GTQ(Q)</option>
												   <option value="GYD,$" <?php if($currency[0]=='GYD'){echo 'selected="selected"';}?>>GYD($)</option>
												   <option value="HTG,G" <?php if($currency[0]=='HTG'){echo 'selected="selected"';}?>>HTG(G)</option>
												   <option value="HNL,L" <?php if($currency[0]=='HNL'){echo 'selected="selected"';}?>>HNL(L)</option>
												   <option value="HKD,$" <?php if($currency[0]=='HKD'){echo 'selected="selected"';}?>>HKD($)</option>
												   <option value="HUF,Ft" <?php if($currency[0]=='HUF'){echo 'selected="selected"';}?>>HUF(Ft)</option>
												   <option value="ISK,kr" <?php if($currency[0]=='ISK'){echo 'selected="selected"';}?>>ISK(kr)</option>
												   <option value="INR,₹" <?php if($currency[0]=='INR'){echo 'selected="selected"';}?>>INR(₹)</option>
												   <option value="IDR,Rp" <?php if($currency[0]=='IDR'){echo 'selected="selected"';}?>>IDR(Rp)</option>
												   <option value="IRR,﷼" <?php if($currency[0]=='IRR'){echo 'selected="selected"';}?>>IRR(﷼)</option>
												   <option value="ILS,₪" <?php if($currency[0]=='ILS'){echo 'selected="selected"';}?>>ILS(₪)</option>
												   <option value="JMD,$" <?php if($currency[0]=='JMD'){echo 'selected="selected"';}?>>JMD($)</option>
												   <option value="JPY,¥" <?php if($currency[0]=='JPY'){echo 'selected="selected"';}?>>JPY(¥)</option>
												   <option value="KZT,лв" <?php if($currency[0]=='KZT'){echo 'selected="selected"';}?>>KZT(лв)</option>
												   <option value="KGS,лв" <?php if($currency[0]=='KGS'){echo 'selected="selected"';}?>>KGS(лв)</option>
												   <option value="LAK,₭" <?php if($currency[0]=='LAK'){echo 'selected="selected"';}?>>LAK(₭)</option>
												   <option value="LVL,Ls" <?php if($currency[0]=='LVL'){echo 'selected="selected"';}?>>LVL(Ls)</option>
												   <option value="LBP,£" <?php if($currency[0]=='LBP'){echo 'selected="selected"';}?>>LBP(£)</option>
												   <option value="LSL,L" <?php if($currency[0]=='LSL'){echo 'selected="selected"';}?>>LSL(L)</option>
												   <option value="LRD,$" <?php if($currency[0]=='LRD'){echo 'selected="selected"';}?>>LRD($)</option>
												   <option value="CHF,CHF" <?php if($currency[0]=='CHF'){echo 'selected="selected"';}?>>CHF(CHF)</option>
												   <option value="LTL,Lt" <?php if($currency[0]=='LTL'){echo 'selected="selected"';}?>>LTL(Lt)</option>
												   <option value="MOP,MOP" <?php if($currency[0]=='MOP'){echo 'selected="selected"';}?>>MOP(MOP)</option>
												   <option value="MKD,ден" <?php if($currency[0]=='MKD'){echo 'selected="selected"';}?>>MKD(ден)</option>
												   <option value="MWK,MK" <?php if($currency[0]=='MWK'){echo 'selected="selected"';}?>>MWK(MK)</option>
												   <option value="MYR,RM" <?php if($currency[0]=='MYR'){echo 'selected="selected"';}?>>MYR(RM)</option>
												   <option value="MVR,Rf" <?php if($currency[0]=='MVR'){echo 'selected="selected"';}?>>MVR(Rf)</option>
												   <option value="MRO,UM" <?php if($currency[0]=='MRO'){echo 'selected="selected"';}?>>MRO(UM)</option>
												   <option value="MUR,₨" <?php if($currency[0]=='MUR'){echo 'selected="selected"';}?>>MUR(₨)</option>
												   <option value="MXN,$" <?php if($currency[0]=='MXN'){echo 'selected="selected"';}?>>MXN($)</option>
												   <option value="MNT,₮" <?php if($currency[0]=='MNT'){echo 'selected="selected"';}?>>MNT(₮)</option>
												   <option value="MZN,MT" <?php if($currency[0]=='MZN'){echo 'selected="selected"';}?>>MZN(MT)</option>
												   <option value="MMK,K" <?php if($currency[0]=='MMK'){echo 'selected="selected"';}?>>MMK(K)</option>
												   <option value="NAD,$" <?php if($currency[0]=='NAD'){echo 'selected="selected"';}?>>NAD($)</option>
												   <option value="NPR,₨" <?php if($currency[0]=='NPR'){echo 'selected="selected"';}?>>NPR(₨)</option>
												   <option value="ANG,ƒ" <?php if($currency[0]=='ANG'){echo 'selected="selected"';}?>>ANG(ƒ)</option>
												   <option value="NIO,C$" <?php if($currency[0]=='NIO'){echo 'selected="selected"';}?>>NIO(C$)</option>
												   <option value="NGN,₦" <?php if($currency[0]=='NGN'){echo 'selected="selected"';}?>>NGN(₦)</option>
												   <option value="KPW,₩" <?php if($currency[0]=='KPW'){echo 'selected="selected"';}?>>KPW(₩)</option>
												   <option value="OMR,﷼" <?php if($currency[0]=='OMR'){echo 'selected="selected"';}?>>OMR(﷼)</option>
												   <option value="PKR,₨" <?php if($currency[0]=='PKR'){echo 'selected="selected"';}?>>PKR(₨)</option>
												   <option value="PAB,B/." <?php if($currency[0]=='PAB'){echo 'selected="selected"';}?>>PAB(B/.)</option>
												   <option value="PYG,Gs" <?php if($currency[0]=='PYG'){echo 'selected="selected"';}?>>PYG(Gs)</option>
												   <option value="PEN,S/." <?php if($currency[0]=='PEN'){echo 'selected="selected"';}?>>PEN(S/.)</option>
												   <option value="PHP,Php" <?php if($currency[0]=='PHP'){echo 'selected="selected"';}?>>PHP(Php)</option>
												   <option value="PLN,zł" <?php if($currency[0]=='PLN'){echo 'selected="selected"';}?>>PLN(zł)</option>
												   <option value="QAR,﷼" <?php if($currency[0]=='QAR'){echo 'selected="selected"';}?>>QAR(﷼)</option>
												   <option value="RON,lei" <?php if($currency[0]=='RON'){echo 'selected="selected"';}?>>RON(lei)</option>
												   <option value="RUB,руб" <?php if($currency[0]=='RUB'){echo 'selected="selected"';}?>>RUB(руб)</option>
												   <option value="SHP,£" <?php if($currency[0]=='SHP'){echo 'selected="selected"';}?>>SHP(£)</option>
												   <option value="WST,WS$" <?php if($currency[0]=='WST'){echo 'selected="selected"';}?>>WST(WS$)</option>
												   <option value="STD,Db" <?php if($currency[0]=='STD'){echo 'selected="selected"';}?>>STD(Db)</option>
												   <option value="SAR,﷼" <?php if($currency[0]=='SAR'){echo 'selected="selected"';}?>>SAR(﷼)</option>
												   <option value="RSD,Дин" <?php if($currency[0]=='RSD'){echo 'selected="selected"';}?>>RSD(Дин)</option>
												   <option value="SCR,₨" <?php if($currency[0]=='SCR'){echo 'selected="selected"';}?>>SCR(₨)</option>
												   <option value="SLL,Le" <?php if($currency[0]=='SLL'){echo 'selected="selected"';}?>>SLL(Le)</option>
												   <option value="SGD,$" <?php if($currency[0]=='SGD'){echo 'selected="selected"';}?>>SGD($)</option>
												   <option value="SKK,Sk" <?php if($currency[0]=='SKK'){echo 'selected="selected"';}?>>SKK(Sk)</option>
												   <option value="SBD,$" <?php if($currency[0]=='SBD'){echo 'selected="selected"';}?>>SBD($)</option>
												   <option value="SOS,S" <?php if($currency[0]=='SOS'){echo 'selected="selected"';}?>>SOS(S)</option>
												   <option value="ZAR,R" <?php if($currency[0]=='ZAR'){echo 'selected="selected"';}?>>ZAR(R)</option>
												   <option value="GBP,£" <?php if($currency[0]=='GBP'){echo 'selected="selected"';}?>>GBP(£)</option>
												   <option value="KRW,₩" <?php if($currency[0]=='KRW'){echo 'selected="selected"';}?>>KRW(₩)</option>
												   <option value="LKR,₨" <?php if($currency[0]=='LKR'){echo 'selected="selected"';}?>>LKR(₨)</option>
												   <option value="SRD,$" <?php if($currency[0]=='SRD'){echo 'selected="selected"';}?>>SRD($)</option>
												   <option value="SEK,kr" <?php if($currency[0]=='SEK'){echo 'selected="selected"';}?>>SEK(kr)</option>
												   <option value="SYP,£" <?php if($currency[0]=='SYP'){echo 'selected="selected"';}?>>SYP(£)</option>
												   <option value="TWD,NT$" <?php if($currency[0]=='TWD'){echo 'selected="selected"';}?>>TWD(NT$)</option>
												   <option value="THB,฿" <?php if($currency[0]=='THB'){echo 'selected="selected"';}?>>THB(฿)</option>
												   <option value="TOP,T$" <?php if($currency[0]=='TOP'){echo 'selected="selected"';}?>>TOP(T$)</option>
												   <option value="TTD,TT$" <?php if($currency[0]=='TTD'){echo 'selected="selected"';}?>>TTD(TT$)</option>
												   <option value="TRY,YTL" <?php if($currency[0]=='TRY'){echo 'selected="selected"';}?>>TRY(YTL)</option>
												   <option value="TMM,m" <?php if($currency[0]=='TMM'){echo 'selected="selected"';}?>>TMM(m)</option>
												   <option value="UAH,₴" <?php if($currency[0]=='UAH'){echo 'selected="selected"';}?>>UAH(₴)</option>
												   <option value="UYU,$U" <?php if($currency[0]=='UYU'){echo 'selected="selected"';}?>>UYU($U)</option>
												   <option value="UZS,лв" <?php if($currency[0]=='UZS'){echo 'selected="selected"';}?>>UZS(лв)</option>
												   <option value="VUV,Vt" <?php if($currency[0]=='VUV'){echo 'selected="selected"';}?>>VUV(Vt)</option>
												   <option value="VEF,Bs" <?php if($currency[0]=='VEF'){echo 'selected="selected"';}?>>VEF(Bs)</option>
												   <option value="VND,₫" <?php if($currency[0]=='VND'){echo 'selected="selected"';}?>>VND(₫)</option>
												   <option value="YER,﷼" <?php if($currency[0]=='YER'){echo 'selected="selected"';}?>>YER(﷼)</option>
												   <option value="ZMK,ZK" <?php if($currency[0]=='ZMK'){echo 'selected="selected"';}?>>ZMK(ZK)</option>
												   <option value="ZWD,Z$" <?php if($currency[0]=='ZWD'){echo 'selected="selected"';}?>>ZWD(Z$)</option>
												</select>
												</div>
											</div>
											
											<div class="control-group radio-inline">
												<label class="control-label" for="published">Display currency</label>
												<div class="controls">
													<label class="radio custom-radio">
														<input type="radio" id="disp_currency" name="disp_currency" value="prefix" <?=($general_setting_data['disp_currency']=="prefix"||$general_setting_data['disp_currency']==""?'checked="checked"':'')?>>
														Prefix
													</label>
													<label class="radio custom-radio">
														<input type="radio" id="disp_currency" name="disp_currency" value="postfix" <?=($general_setting_data['disp_currency']=="postfix"?'checked="checked"':'')?>>
														Postfix
													</label>
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="is_space_between_currency_symbol">&nbsp;</label>
												<div class="controls">
													<label class="checkbox custom-checkbox">
														<input id="is_space_between_currency_symbol" type="checkbox" value="1" name="is_space_between_currency_symbol" <?php if($general_setting_data['is_space_between_currency_symbol']=="1"){echo 'checked="checked"';}?>> Keep space between currency symbol and amount
													</label>
												</div>
											</div>
											
											
											<div class="control-group">
												<label class="control-label" for="thousand_separator">Thousand Separator</label>
												<div class="controls">
													<input type="text" class="input-xlarge" id="thousand_separator" value="<?=$general_setting_data['thousand_separator']?>" name="thousand_separator">
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" for="decimal_separator">Decimal Separator</label>
												<div class="controls">
													<input type="text" class="input-xlarge" id="decimal_separator" value="<?=$general_setting_data['decimal_separator']?>" name="decimal_separator">
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" for="decimal_number">Number of Decimals</label>
												<div class="controls">
													<input type="number" class="input-xlarge" id="decimal_number" value="<?=$general_setting_data['decimal_number']?>" name="decimal_number">
												</div>
											</div>
								
											<div class="control-group radio-inline">
												<label class="control-label" for="signup_activation_by_admin">Newsletter Section</label>
												<div class="controls">
													<label class="radio custom-radio">
														<input type="radio" name="other_settings[newslettter_section]" value="1" <?=($other_settings['newslettter_section']=='1'||$other_settings['newslettter_section']==''?'checked="checked"':'')?>>
														Show
													</label>
													<label class="radio custom-radio">
														<input type="radio" name="other_settings[newslettter_section]" value="0" <?=($other_settings['newslettter_section']=='0'?'checked="checked"':'')?>>
														Hide
													</label>
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="published">Payment Option</label>
												<div class="controls">
													<label class="checkbox custom-checkbox">
														<input id="payment_option_bank" type="checkbox" value="bank" name="payment_option[bank]" <?php if($payment_option['bank']=="bank"){echo 'checked="checked"';}?>>
														Bank
													</label>
													<label class="checkbox custom-checkbox">
														<input id="payment_option_paypal" type="checkbox" value="paypal" name="payment_option[paypal]" <?php if($payment_option['paypal']=="paypal"){echo 'checked="checked"';}?>>
														Paypal	
													</label>
													<!--<label class="checkbox custom-checkbox">
														<input id="payment_option_cheque" type="checkbox" value="cheque" name="payment_option[cheque]" <?php if($payment_option['cheque']=="cheque"){echo 'checked="checked"';}?>>
														Cheque
													</label>-->
													
													<label class="checkbox custom-checkbox">
														<input id="payment_option_check" type="checkbox" value="check" name="payment_option[check]" <?php if($payment_option['check']=="check"){echo 'checked="checked"';}?>>
														Cheque/Check
													</label>
													<label class="checkbox custom-checkbox">
														<input id="payment_option_zelle" type="checkbox" value="zelle" name="payment_option[zelle]" <?php if($payment_option['zelle']=="zelle"){echo 'checked="checked"';}?>>
														Zelle
													</label>
													<label class="checkbox custom-checkbox">
														<input id="payment_option_cash" type="checkbox" value="cash" name="payment_option[cash]" <?php if($payment_option['cash']=="cash"){echo 'checked="checked"';}?>>
														Cash
													</label>
													
												</div>
											</div>
											
											<div class="control-group radio-inline">
												<label class="control-label" for="published">Default Payment Option</label>
												<div class="controls">
													<label class="radio custom-radio">
														<input type="radio" id="default_payment_option_bank" name="default_payment_option" value="bank" <?=($general_setting_data['default_payment_option']=="bank"||$general_setting_data['default_payment_option']==""?'checked="checked"':'')?>>
														Bank
													</label>
													<label class="radio custom-radio">
														<input type="radio" id="default_payment_option_paypal" name="default_payment_option" value="paypal" <?=($general_setting_data['default_payment_option']=="paypal"?'checked="checked"':'')?>>
														Paypal
													</label>
													<!--<label class="radio custom-radio">
														<input type="radio" id="default_payment_option_cheque" name="default_payment_option" value="cheque" <?=($general_setting_data['default_payment_option']=="cheque"?'checked="checked"':'')?>>
														Cheque
													</label>-->
													
													<label class="radio custom-radio">
														<input type="radio" id="default_payment_option_check" name="default_payment_option" value="check" <?=($general_setting_data['default_payment_option']=="check"?'checked="checked"':'')?>>
														Cheque/Check
													</label>
													<label class="radio custom-radio">
														<input type="radio" id="default_payment_option_zelle" name="default_payment_option" value="zelle" <?=($general_setting_data['default_payment_option']=="zelle"?'checked="checked"':'')?>>
														Zelle
													</label>
													<label class="radio custom-radio">
														<input type="radio" id="default_payment_option_cash" name="default_payment_option" value="cash" <?=($general_setting_data['default_payment_option']=="cash"?'checked="checked"':'')?>>
														Cash
													</label>
													
												</div>
											</div>
											
											<div class="control-group radio-inline">
												<label class="control-label" for="published">Recommended Payment Option</label>
												<div class="controls">
													<label class="radio custom-radio">
														<input type="radio" id="recommended_payment_option_bank" name="recommended_payment_option" value="bank" <?=($general_setting_data['recommended_payment_option']=="bank"||$general_setting_data['recommended_payment_option']==""?'checked="checked"':'')?>>
														Bank
													</label>
													<label class="radio custom-radio">
														<input type="radio" id="recommended_payment_option_paypal" name="recommended_payment_option" value="paypal" <?=($general_setting_data['recommended_payment_option']=="paypal"?'checked="checked"':'')?>>
														Paypal
													</label>
													<!--<label class="radio custom-radio">
														<input type="radio" id="recommended_payment_option_cheque" name="recommended_payment_option" value="cheque" <?=($general_setting_data['recommended_payment_option']=="cheque"?'checked="checked"':'')?>>
														Cheque
													</label>-->
													
													<label class="radio custom-radio">
														<input type="radio" id="recommended_payment_option_check" name="recommended_payment_option" value="check" <?=($general_setting_data['recommended_payment_option']=="check"?'checked="checked"':'')?>>
														Cheque/Check
													</label>
													<label class="radio custom-radio">
														<input type="radio" id="recommended_payment_option_zelle" name="recommended_payment_option" value="zelle" <?=($general_setting_data['recommended_payment_option']=="zelle"?'checked="checked"':'')?>>
														Zelle
													</label>
													<label class="radio custom-radio">
														<input type="radio" id="recommended_payment_option_cash" name="recommended_payment_option" value="cash" <?=($general_setting_data['recommended_payment_option']=="cash"?'checked="checked"':'')?>>
														Cash
													</label>
													
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="published">Sales Pack</label>
												<div class="controls">
													<label class="checkbox custom-checkbox">
														<input id="sales_pack" type="checkbox" value="free" name="sales_pack[free]" <?php if($sales_pack['free']=='free'){echo 'checked="checked"';}?>>
														Send free sales pack
													</label>
													<label class="checkbox custom-checkbox">
														<input id="sales_pack" type="checkbox" value="own" name="sales_pack[own]" <?php if($sales_pack['own']=='own'){echo 'checked="checked"';}?>>
														Print your own no postage sales labels
													</label>
													<?php /*?><label class="checkbox custom-checkbox">
														<input id="sales_pack" type="checkbox" value="own_no_postage" name="sales_pack[own_no_postage]" <?php if($sales_pack['own_no_postage']=='own_no_postage'){echo 'checked="checked"';}?>>
														Print your own no postage sales labels
													</label><?php */?>
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="published">Shipping Option</label>
												<div class="controls">
													<label class="checkbox custom-checkbox">
														<input id="shipping_option" type="checkbox" value="own" name="shipping_option[own]" <?php if($shipping_option['own']=='own'){echo 'checked="checked"';}?>>
														Post Your Own
													</label>
													<label class="checkbox custom-checkbox">
														<input id="shipping_option" type="checkbox" value="free_pickup" name="shipping_option[free_pickup]" <?php if($shipping_option['free_pickup']=='free_pickup'){echo 'checked="checked"';}?>>
														Schedule a Free Pickup
													</label>
												</div>
											</div>
											
											<div class="control-group radio-inline">
												<label class="control-label" for="published">Verification</label>
												<div class="controls">
													<label class="radio custom-radio">
														<input type="radio" id="verification" name="verification" value="none" <?=($general_setting_data['verification']=="none"||$general_setting_data['verification']==""?'checked="checked"':'')?>>
														None
													</label>
													<label class="radio custom-radio">
														<input type="radio" id="verification" name="verification" value="email" <?=($general_setting_data['verification']=="email"?'checked="checked"':'')?>>
														Email
													</label>
													<label class="radio custom-radio">
														<input type="radio" id="verification" name="verification" value="sms" <?=($general_setting_data['verification']=="sms"?'checked="checked"':'')?>>
														SMS
													</label>
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="header_service_hours_text">Service Hours Text (Header)</label>
												<div class="controls">
													<textarea class="form-control input-xlarge" name="header_service_hours_text" rows="5"><?=$general_setting_data['header_service_hours_text']?></textarea>
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="input">JS code before &#60;&#47;head&#62;</label>
												<div class="controls">
													<textarea class="form-control input-xlarge" name="custom_js_code" rows="5"><?=$general_setting_data['custom_js_code']?></textarea>
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="input">Order Tracking Tag (JS code before &#60;&#47;head&#62;)</label>
												<div class="controls">
													<textarea class="form-control input-xlarge" name="order_tracking_tag" rows="5"><?=$general_setting_data['order_tracking_tag']?></textarea>
												</div>
											</div>

											<div class="form-actions">
												<button class="btn btn-alt btn-large btn-primary" type="submit" name="general_setting"><?=($device_id?'Update':'Save')?></button>
											</div>
										</div>
									</div>
									
									<div class="tab-pane" id="tab2">
										<div class="span7">
											<h3>Mail Settings</h3>
											<div class="control-group">
												<label class="control-label" for="input">From Name</label>
												<div class="controls">
													<input type="text" class="input-xlarge" id="field-1" value="<?=$general_setting_data['from_name']?>" name="from_name">
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" for="input">From Email</label>
												<div class="controls">
													<input type="text" class="input-xlarge" id="field-1" value="<?=$general_setting_data['from_email']?>" name="from_email">
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" for="published">&nbsp;</label>
												<label class="checkbox custom-checkbox">
													<input id="display_department_specific_from_email_only_in_order" type="checkbox" value="1" name="display_department_specific_from_email_only_in_order" <?php if($general_setting_data['display_department_specific_from_email_only_in_order']=='1'){echo 'checked="checked"';}?>>
														Display Department Specific From Email Only In Order
												</label>
											</div>
											<div class="control-group">
												<label class="control-label" for="input">Mailer</label>
												<div class="controls">
												<select class="form-control" name="mailer_type" id="mailer_type" onchange="chg_mailer_type(this.value);">									  
													<option value="mail" <?php if($general_setting_data['mailer_type']=='mail'||$general_setting_data['mailer_type']==''){echo 'selected="selected"';}?>>PHP Mail</option>
													<option value="smtp" <?php if($general_setting_data['mailer_type']=='smtp'){echo 'selected="selected"';}?>>SMTP</option>
													<option value="sendgrid" <?php if($general_setting_data['mailer_type']=='sendgrid'){echo 'selected="selected"';}?>>SendGrid</option>
												</select>
												</div>
											</div>
											
											<?php
											$is_smtp_mailter = 'style="display:none;"';
											$is_emailapi_mailter = 'style="display:none;"';
											if($general_setting_data['mailer_type']=='smtp') {
												$is_smtp_mailter = 'style="display:block;"';
											}
											if($general_setting_data['mailer_type']=='sendgrid') {
												$is_emailapi_mailter = 'style="display:block;"';
											} ?>
											<div class="control-group showhide_smtp_fields" <?=$is_smtp_mailter?>>
												<label class="control-label" for="input">SMTP Host</label>
												<div class="controls">
													<input type="text" class="input-xlarge" id="smtp_host" value="<?=$general_setting_data['smtp_host']?>" name="smtp_host">
												</div>
											</div>
											<div class="control-group showhide_smtp_fields" <?=$is_smtp_mailter?>>
												<label class="control-label" for="input">SMTP Port</label>
												<div class="controls">
													<input type="text" class="input-xlarge" id="smtp_port" value="<?=$general_setting_data['smtp_port']?>" name="smtp_port">
												</div>
											</div>
											<div class="control-group showhide_smtp_fields" <?=$is_smtp_mailter?>>
												<label class="control-label" for="input">SMTP Security</label>
												<div class="controls">
												<select class="form-control" name="smtp_security" id="smtp_security">									  
													<option value="none" <?php if($general_setting_data['smtp_security']=='none'){echo 'selected="selected"';}?>>None</option>
													<option value="ssl" <?php if($general_setting_data['smtp_security']=='ssl'){echo 'selected="selected"';}?>>SSL/TLS</option>
												</select>
												</div>
											</div>
											<div class="control-group showhide_smtp_fields" <?=$is_smtp_mailter?>>
												<label class="control-label" for="input">SMTP Username</label>
												<div class="controls">
													<input type="text" class="input-xlarge" id="smtp_username" value="<?=$general_setting_data['smtp_username']?>" name="smtp_username">
												</div>
											</div>
											<div class="control-group showhide_smtp_fields" <?=$is_smtp_mailter?>>
												<label class="control-label" for="input">SMTP Password</label>
												<div class="controls">
													<input type="text" class="input-xlarge" id="smtp_password" value="<?=$general_setting_data['smtp_password']?>" name="smtp_password">
												</div>
											</div>
											
											<div class="control-group showhide_emailapi_fields" <?=$is_emailapi_mailter?>>
												<label class="control-label" for="input">API Key</label>
												<div class="controls">
													<input type="text" class="input-xlarge" id="email_api_key" value="<?=$general_setting_data['email_api_key']?>" name="email_api_key">
												</div>
											</div>
											
											<?php /*?><div class="control-group showhide_emailapi_fields" <?=$is_emailapi_mailter?>>
												<label class="control-label" for="input">Username</label>
												<div class="controls">
													<input type="text" class="input-xlarge" id="email_api_username" value="<?=$general_setting_data['email_api_username']?>" name="email_api_username">
												</div>
											</div>
											<div class="control-group showhide_emailapi_fields" <?=$is_emailapi_mailter?>>
												<label class="control-label" for="input">Password</label>
												<div class="controls">
													<input type="text" class="input-xlarge" id="email_api_password" value="<?=$general_setting_data['email_api_password']?>" name="email_api_password">
												</div>
											</div><?php */?>

											<div class="form-actions">
												<button class="btn btn-alt btn-large btn-primary" type="submit" name="general_setting"><?=($device_id?'Update':'Save')?></button>
											</div>
										</div>
									</div>
									
									<div class="tab-pane" id="tab3">
										<div class="span7">
											<h3>Socials Link</h3>
											<?php /*?><div class="control-group">
												<label class="control-label" for="input">Facebook Page URL</label>
												<div class="controls">
													<input type="text" class="input-xlarge" id="fb_page_url" value="<?=$general_setting_data['fb_page_url']?>" name="fb_page_url">
												</div>
											</div><?php */?>
											
											<div class="control-group">
												<label class="control-label" for="input">Facebook Link</label>
												<div class="controls">
													<input type="text" class="input-xlarge" id="field-1" value="<?=$general_setting_data['fb_link']?>"  name="fb_link">
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="input">Twitter Link</label>
												<div class="controls">
													<input type="text" class="input-xlarge" id="twitter_link" value="<?=$general_setting_data['twitter_link']?>"  name="twitter_link">
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="input">LinkedIn Link</label>
												<div class="controls">
													<input type="text" class="input-xlarge" id="linkedin_link" value="<?=$general_setting_data['linkedin_link']?>"  name="linkedin_link">
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="input">YouTube Link</label>
												<div class="controls">
													<input type="text" class="input-xlarge" id="youtube_link" value="<?=$general_setting_data['youtube_link']?>"  name="youtube_link">
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="input">Msg Link</label>
												<div class="controls">
													<input type="text" class="input-xlarge" id="msg_link" value="<?=$general_setting_data['msg_link']?>"  name="msg_link">
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="instagram_link">Instagram Link</label>
												<div class="controls">
													<input type="text" class="input-xlarge" id="instagram_link" value="<?=$general_setting_data['instagram_link']?>"  name="instagram_link">
												</div>
											</div>
											
											<div class="form-actions">
												<button class="btn btn-alt btn-large btn-primary" type="submit" name="general_setting"><?=($device_id?'Update':'Save')?></button>
											</div>
											
											<h3>Social Login Settings</h3>
											<div class="control-group radio-inline">
												<label class="control-label" for="published">Social Login</label>
												<div class="controls">
													<label class="radio custom-radio">
														<input type="radio" id="show_social_login_on" name="social_login" value="1" <?php if($general_setting_data['social_login']=='1'){echo 'checked="checked"';}?>>
														Yes
													</label>
													<label class="radio custom-radio">
														<input type="radio" id="show_social_login_off" name="social_login" value="0" <?php if($general_setting_data['social_login']=='0'){echo 'checked="checked"';}?>>
														No
													</label>
												</div>
											</div>
											<div class="control-group radio-inline">
												<label class="control-label" for="published">Social Login Option</label>
												<div class="controls">
													<label class="radio custom-radio">
														<input type="radio" id="social_login_option" name="social_login_option" value="g_f" <?=($general_setting_data['social_login_option']=="g_f"||$general_setting_data['social_login_option']==""?'checked="checked"':'')?>>
														Google & Facebook
													</label>
													<label class="radio custom-radio">
														<input type="radio" id="social_login_option" name="social_login_option" value="g" <?=($general_setting_data['social_login_option']=="g"?'checked="checked"':'')?>>
														Google
													</label>
													<label class="radio custom-radio">
														<input type="radio" id="social_login_option" name="social_login_option" value="f" <?=($general_setting_data['social_login_option']=="f"?'checked="checked"':'')?>>
														Facebook
													</label>
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="input">Google Client ID</label>
												<div class="controls">
													<input type="text" class="input-xlarge" id="google_client_id" value="<?=$general_setting_data['google_client_id']?>" name="google_client_id">
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" for="input">Google Client Secret</label>
												<div class="controls">
													<input type="text" class="input-xlarge" id="google_client_secret" value="<?=$general_setting_data['google_client_secret']?>" name="google_client_secret">
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" for="input">Facebook App ID</label>
												<div class="controls">
													<input type="text" class="input-xlarge" id="fb_app_id" value="<?=$general_setting_data['fb_app_id']?>" name="fb_app_id">
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" for="input">Facebook App Secret</label>
												<div class="controls">
													<input type="text" class="input-xlarge" id="fb_app_secret" value="<?=$general_setting_data['fb_app_secret']?>" name="fb_app_secret">
												</div>
											</div>
											<div class="form-actions">
												<button class="btn btn-alt btn-large btn-primary" type="submit" name="general_setting"><?=($device_id?'Update':'Save')?></button>
											</div>
										</div>
									</div>
									
									<div class="tab-pane" id="tab4">
										<div class="span7">
											<h3>Company Details</h3>
											<div class="control-group">
												<label class="control-label" for="input">Company Name</label>
												<div class="controls">
													<input type="text" class="input-xlarge" id="company_name" value="<?=$general_setting_data['company_name']?>" name="company_name">
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="input">Address</label>
												<div class="controls">
													<input type="text" class="input-xlarge" id="company_address" value="<?=$general_setting_data['company_address']?>" name="company_address">
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="input">City</label>
												<div class="controls">
													<input type="text" class="input-xlarge" id="company_city" value="<?=$general_setting_data['company_city']?>" name="company_city">
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="input">State</label>
												<div class="controls">
													<input type="text" class="input-xlarge" id="company_state" value="<?=$general_setting_data['company_state']?>" name="company_state">
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="input">Country</label>
												<div class="controls">
													<input type="text" class="input-xlarge" id="company_country" value="<?=$general_setting_data['company_country']?>" name="company_country">
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="input">Zipcode</label>
												<div class="controls">
													<input type="text" class="input-xlarge" id="company_zipcode" value="<?=$general_setting_data['company_zipcode']?>" name="company_zipcode">
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="input">Phone</label>
												<div class="controls">
													<input type="text" class="input-xlarge" id="company_phone" value="<?=$general_setting_data['company_phone']?>" name="company_phone">
												</div>
											</div>
											<div class="form-actions">
												<button class="btn btn-alt btn-large btn-primary" type="submit" name="general_setting"><?=($device_id?'Update':'Save')?></button>
											</div>
										</div>
									</div>
									<div class="tab-pane" id="tab5">
										<div class="span7">
											<h3>Blog Settings</h3>
											
											<div class="control-group">
												<label class="control-label" for="input">Excerpt Length (number of words)</label>
												<div class="controls">
													<input type="number" class="input-small" id="blog_rm_words_limit" value="<?=$general_setting_data['blog_rm_words_limit']?>" name="blog_rm_words_limit">
												</div>

											</div>
											<div class="control-group radio-inline">
												<label class="control-label" for="published">Display Recent Post</label>
												<div class="controls">
													<label class="radio custom-radio">
														<input type="radio" id="blog_recent_posts" name="blog_recent_posts" value="1" <?=($general_setting_data['blog_recent_posts']=='1'||$general_setting_data['blog_recent_posts']==""?'checked="checked"':'')?>>
														Show
													</label>
													<label class="radio custom-radio">
														<input type="radio" id="blog_recent_posts" name="blog_recent_posts" value="0" <?=($general_setting_data['blog_recent_posts']=='0'?'checked="checked"':'')?>>
														Hide
													</label>
												</div>
											</div>
											<div class="control-group radio-inline">
												<label class="control-label" for="published">Display Categories</label>
												<div class="controls">
													<label class="radio custom-radio">
														<input type="radio" id="blog_categories" name="blog_categories" value="1" <?=($general_setting_data['blog_categories']=='1'||$general_setting_data['blog_categories']==""?'checked="checked"':'')?>>
														Show
													</label>
													<label class="radio custom-radio">
														<input type="radio" id="blog_categories" name="blog_categories" value="0" <?=($general_setting_data['blog_categories']=='0'?'checked="checked"':'')?>>
														Hide
													</label>
												</div>
											</div>
											<div class="form-actions">
												<button class="btn btn-alt btn-large btn-primary" type="submit" name="general_setting"><?=($device_id?'Update':'Save')?></button>
											</div>
										</div>
									</div>
									<div class="tab-pane" id="tab6">
										<div class="span7">
											<h3>SMS Settings</h3>
											
											<div class="control-group radio-inline">
												<label class="control-label" for="published">SMS Sending Status</label>
												<div class="controls">
													<label class="radio custom-radio">
														<input type="radio" id="sms_sending_status" name="sms_sending_status" value="1" <?=($general_setting_data['sms_sending_status']=='1'?'checked="checked"':'')?>>
														ON
													</label>
													<label class="radio custom-radio">
														<input type="radio" id="sms_sending_status" name="sms_sending_status" value="0" <?=(intval($general_setting_data['sms_sending_status'])=='0'?'checked="checked"':'')?>>
														OFF
													</label>
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="input">Twilio Account SID</label>
												<div class="controls">
													<input type="text" class="input-xlarge" id="twilio_ac_sid" value="<?=$general_setting_data['twilio_ac_sid']?>" name="twilio_ac_sid">
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="input">Twilio Account Auth Token</label>
												<div class="controls">
													<input type="text" class="input-xlarge" id="twilio_ac_token" value="<?=$general_setting_data['twilio_ac_token']?>" name="twilio_ac_token">
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="input">Twilio Long Code</label>
												<div class="controls">
													<input type="text" class="input-xlarge" id="twilio_long_code" value="<?=$general_setting_data['twilio_long_code']?>" name="twilio_long_code">
												</div>
											</div>
											<div class="form-actions">
												<button class="btn btn-alt btn-large btn-primary" type="submit" name="general_setting"><?=($device_id?'Update':'Save')?></button>
											</div>
										</div>
									</div>
									<div class="tab-pane" id="tab7">
										<div class="span7">
											<h3>Home Settings</h3>
											
											<div class="control-group">
												<label class="control-label" for="input">Process Works & Slider</label>
												<div class="controls">
													<textarea class="form-control wysihtml5" name="home_slider" rows="5"><?=$general_setting_data['home_slider']?></textarea>
												</div>
											</div>
											
											<div class="control-group">
												<hr />
											</div>
											<div class="control-group">
												<label class="control-label" for="published">&nbsp;</label>
												<label class="checkbox custom-checkbox">
													<input id="allow_offer_popup" type="checkbox" value="1" name="allow_offer_popup" <?php if($general_setting_data['allow_offer_popup']=='1'){echo 'checked="checked"';}?>>
														Allow Offer Popup
												</label>
											</div>
											<div class="control-group">
												<label class="control-label" for="input">Offer Popup Title</label>
												<div class="controls">
													<input type="text" class="input-xlarge" id="offer_popup_title" value="<?=$general_setting_data['offer_popup_title']?>" name="offer_popup_title">
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" for="input">Offer Popup Content</label>
												<div class="controls">
													<textarea class="form-control wysihtml5" name="offer_popup_content" rows="5"><?=$general_setting_data['offer_popup_content']?></textarea>
												</div>
											</div>
											
											<div class="form-actions">
												<button class="btn btn-alt btn-large btn-primary" type="submit" name="general_setting"><?=($device_id?'Update':'Save')?></button>
											</div>
										</div>
									</div>
									<?php /*?><div class="tab-pane active" id="tab10">
										<div class="span7">
											<h3>Upload Free Postage Label</h3>
											<div class="control-group">
												<label class="control-label" for="fileInput">Upload PDF File</label>
												<div class="controls">
													<?php
													$sitemap_url = "../pdf/free_postage_label.pdf"; ?>
													<div class="fileupload fileupload-new" data-provides="fileupload">
														<div class="input-append">
															<div class="uneditable-input">
																<i class="icon-file fileupload-exists"></i>
																<span class="fileupload-preview"></span>
															</div>
															<span class="btn btn-alt btn-file">
																	<span class="fileupload-new">Select File</span>
																	<span class="fileupload-exists">Change</span>
																	<input type="file" class="form-control" id="order_pdf_file" name="order_pdf_file" onChange="checkFilePdf(this)">
															</span>
															<a href="javascript:void(0);" class="btn btn-alt btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a>
														</div>
														<?php
													    if(file_exists($sitemap_url)) {
															echo '<br /><small>free_postage_label.pdf</small>';
														} ?>
													</div>
													
													<?php
													if(file_exists($sitemap_url)) { ?>
														<div class="fileupload fileupload-new" data-provides="fileupload">
															<div>
																<a class="btn btn-alt btn-success" href="../pdf/free_postage_label.pdf" target="_blank">Download</a>&nbsp;<a class="btn btn-alt btn-danger" data-dismiss="fileupload" href="controllers/general_settings.php?r_order_pdf=yes?>" onclick="return confirm('Are you sure to delete PDF file?');">Remove</a>
															</div>
														</div>
													<?php 
													} ?>	 
												</div>
											</div>
											<div class="form-actions">
												<button class="btn btn-alt btn-large btn-primary" type="submit" name="general_setting"><?=(file_exists($sitemap_url)?'Update':'Save')?></button>
											</div>
										</div>
									</div><?php */?>
									
									<div class="tab-pane" id="tab9">
										<div class="span7">
											<h3>Sitemap(XML) File for SEO</h3>
											<div class="control-group">
												<label class="control-label" for="fileInput">Upload Sitemap(XML) File</label>
												<div class="controls">
													<div class="fileupload fileupload-new" data-provides="fileupload">
														<div class="input-append">
															<div class="uneditable-input">
																<i class="icon-file fileupload-exists"></i>
																<span class="fileupload-preview"></span>
															</div>
															<span class="btn btn-alt btn-file">
																	<span class="fileupload-new">Select File</span>
																	<span class="fileupload-exists">Change</span>
																	<input type="file" class="form-control" id="xml_file" name="xml_file" onChange="checkFileXml(this)">
															</span>
															<a href="javascript:void(0);" class="btn btn-alt btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a>
														</div>
													</div>
													
													<?php 
													$sitemap_url = "../sitemap.xml";
													if(file_exists($sitemap_url)) { ?>
														<div class="fileupload fileupload-new" data-provides="fileupload">
															<div>
																<a class="btn btn-alt btn-danger" data-dismiss="fileupload" href="controllers/general_settings.php?r_sitemap=yes?>" onclick="return confirm('Are you sure to delete sitemap(XML) file?');">Remove</a>
															</div>
														</div>
													<?php 
													} ?>	 
												</div>
											</div>
											<div class="form-actions">
												<button class="btn btn-alt btn-large btn-primary" type="submit" name="general_setting"><?=(file_exists($sitemap_url)?'Update':'Save')?></button>
											</div>
										</div>
									</div>
									
									<div class="tab-pane" id="tab15">
										<div class="span7">
											<h3>Captcha Settings</h3>
											
											<div class="control-group">
												<label class="control-label" for="input">Captcha Key</label>
												<div class="controls">
													<input type="text" class="input-xlarge" name="captcha_settings[captcha_key]" value="<?=$captcha_settings['captcha_key']?>">
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="input">Captcha Secret</label>
												<div class="controls">
													<input type="text" class="input-xlarge" name="captcha_settings[captcha_secret]" value="<?=$captcha_settings['captcha_secret']?>">
												</div>
											</div>
												
											<div class="control-group">
												<label class="control-label" for="input">Captcha Form Settings</label>
												<div class="controls">
													<label class="checkbox custom-checkbox">
														<input type="checkbox" value="1" name="captcha_settings[contact_form]" <?php if($captcha_settings['contact_form']=="1"){echo 'checked="checked"';}?>>
														Contact Us Form &nbsp;&nbsp;&nbsp;
													</label>
													<label class="checkbox custom-checkbox">
														<input type="checkbox" value="1" name="captcha_settings[write_review_form]" <?php if($captcha_settings['write_review_form']=="1"){echo 'checked="checked"';}?>>
														Write A Review Form &nbsp;&nbsp;&nbsp;
													</label>
													<label class="checkbox custom-checkbox">
														<input type="checkbox" value="1" name="captcha_settings[bulk_order_form]" <?php if($captcha_settings['bulk_order_form']=="1"){echo 'checked="checked"';}?>>
														Bulk Order Form &nbsp;&nbsp;&nbsp;
													</label>
													<label class="checkbox custom-checkbox">
														<input type="checkbox" value="1" name="captcha_settings[affiliate_form]" <?php if($captcha_settings['affiliate_form']=="1"){echo 'checked="checked"';}?>>
														Affiliate Form &nbsp;&nbsp;&nbsp;
													</label>
													<?php /*?><label class="checkbox custom-checkbox">
														<input type="checkbox" value="1" name="captcha_settings[appt_form]" <?php if($captcha_settings['appt_form']=="1"){echo 'checked="checked"';}?>>
														Appt. Form &nbsp;&nbsp;&nbsp;
													</label><?php */?>
													<label class="checkbox custom-checkbox">
														<input type="checkbox" value="1" name="captcha_settings[login_form]" <?php if($captcha_settings['login_form']=="1"){echo 'checked="checked"';}?>>
														Login Form &nbsp;&nbsp;&nbsp;
													</label>
													<label class="checkbox custom-checkbox">
														<input type="checkbox" value="1" name="captcha_settings[signup_form]" <?php if($captcha_settings['signup_form']=="1"){echo 'checked="checked"';}?>>
														Signup Form &nbsp;&nbsp;&nbsp;
													</label>
													<?php /*?><label class="checkbox custom-checkbox">
														<input type="checkbox" value="1" name="captcha_settings[contractor_form]" <?php if($captcha_settings['contractor_form']=="1"){echo 'checked="checked"';}?>>
														Contractor Form &nbsp;&nbsp;&nbsp;
													</label>
													<?php */?>
													<label class="checkbox custom-checkbox">
														<input type="checkbox" value="1" name="captcha_settings[order_track_form]" <?php if($captcha_settings['order_track_form']=="1"){echo 'checked="checked"';}?>>
														Order Track Form &nbsp;&nbsp;&nbsp;
													</label>
													<label class="checkbox custom-checkbox">
														<input type="checkbox" value="1" name="captcha_settings[newsletter_form]" <?php if($captcha_settings['newsletter_form']=="1"){echo 'checked="checked"';}?>>
														Newsletter Form &nbsp;&nbsp;&nbsp;
													</label>
													<label class="checkbox custom-checkbox">
														<input type="checkbox" value="1" name="captcha_settings[missing_product_form]" <?php if($captcha_settings['missing_product_form']=="1"){echo 'checked="checked"';}?>>
														Missing Product Form &nbsp;&nbsp;&nbsp;
													</label>
													<label class="checkbox custom-checkbox">
														<input type="checkbox" value="1" name="captcha_settings[imei_number_based_search_form]" <?php if($captcha_settings['imei_number_based_search_form']=="1"){echo 'checked="checked"';}?>>
														IMEI Number Based Search Form &nbsp;&nbsp;&nbsp;
													</label>
												</div>
											</div>
											<div class="control-group">
												<div class="form-actions">
													<button class="btn btn-alt btn-large btn-primary" type="submit" name="general_setting">Update</button>
												</div>
											</div>
										</div>
									</div>
									
									<div class="tab-pane" id="tab16">
										<div class="span7">
											<h3>Menu Type Settings</h3>

											<div class="control-group">
												<label class="control-label" for="input">Top Right Menu</label>
												<div class="controls">
													<label class="radio custom-radio">
														<input type="radio" name="other_settings[top_right_menu]" value="1" <?=($other_settings['top_right_menu']=='1'||$other_settings['top_right_menu']==''?'checked="checked"':'')?>>
														Enable
													</label>
													<label class="radio custom-radio">
														<input type="radio" name="other_settings[top_right_menu]" value="0" <?=($other_settings['top_right_menu']=='0'?'checked="checked"':'')?>>
														Disable
													</label>
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" for="input">Header Menu</label>
												<div class="controls">
													<label class="radio custom-radio">
														<input type="radio" name="other_settings[header_menu]" value="1" <?=($other_settings['header_menu']=='1'||$other_settings['header_menu']==''?'checked="checked"':'')?>>
														Enable
													</label>
													<label class="radio custom-radio">
														<input type="radio" name="other_settings[header_menu]" value="0" <?=($other_settings['header_menu']=='0'?'checked="checked"':'')?>>
														Disable
													</label>
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" for="input">Footer Menu Column1</label>
												<div class="controls">
													<label class="radio custom-radio">
														<input type="radio" name="other_settings[footer_menu_column1]" value="1" <?=($other_settings['footer_menu_column1']=='1'||$other_settings['footer_menu_column1']==''?'checked="checked"':'')?>>
														Enable
													</label>
													<label class="radio custom-radio">
														<input type="radio" name="other_settings[footer_menu_column1]" value="0" <?=($other_settings['footer_menu_column1']=='0'?'checked="checked"':'')?>>
														Disable
													</label>
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" for="input">Footer Menu Column2</label>
												<div class="controls">
													<label class="radio custom-radio">
														<input type="radio" name="other_settings[footer_menu_column2]" value="1" <?=($other_settings['footer_menu_column2']=='1'||$other_settings['footer_menu_column2']==''?'checked="checked"':'')?>>
														Enable
													</label>
													<label class="radio custom-radio">
														<input type="radio" name="other_settings[footer_menu_column2]" value="0" <?=($other_settings['footer_menu_column2']=='0'?'checked="checked"':'')?>>
														Disable
													</label>
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" for="input">Footer Menu Column3</label>
												<div class="controls">
													<label class="radio custom-radio">
														<input type="radio" name="other_settings[footer_menu_column3]" value="1" <?=($other_settings['footer_menu_column3']=='1'||$other_settings['footer_menu_column3']==''?'checked="checked"':'')?>>
														Enable
													</label>
													<label class="radio custom-radio">
														<input type="radio" name="other_settings[footer_menu_column3]" value="0" <?=($other_settings['footer_menu_column3']=='0'?'checked="checked"':'')?>>
														Disable
													</label>
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" for="input">Copyright Menu</label>
												<div class="controls">
													<label class="radio custom-radio">
														<input type="radio" name="other_settings[copyright_menu]" value="1" <?=($other_settings['copyright_menu']=='1'||$other_settings['copyright_menu']==''?'checked="checked"':'')?>>
														Enable
													</label>
													<label class="radio custom-radio">
														<input type="radio" name="other_settings[copyright_menu]" value="0" <?=($other_settings['copyright_menu']=='0'?'checked="checked"':'')?>>
														Disable
													</label>
												</div>
											</div>

											<div class="control-group">
												<div class="form-actions">
													<button class="btn btn-alt btn-large btn-primary" type="submit" name="general_setting">Update</button>
												</div>
											</div>
										</div>
									</div>
									
								</div>
							</div>
						</div>
					</form>
                </section>
            </article>
        </div>
    </section>
	<div id="push"></div>
</div>