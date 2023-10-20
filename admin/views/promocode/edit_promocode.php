<script type="text/javascript">
function form_validation(a){
	if(a.name.value.trim()=="") {
		alert('Please enter promo name');
		a.name.focus();
		return false;
	}
	if(a.promocode.value.trim()=="") {
		alert('Please enter promo code');
		a.promocode.focus();
		return false;
	}
	if(a.promocode.value.match(/\s/g)) {
		alert('Not allowed any spaces in promo code.');
		a.promocode.focus();
		return false;
	}
	if(a.description.value.trim()=="") {
		alert('Please enter promocode description');
		a.description.focus();
		return false;
	} else if(a.from_date.value.trim()=="") {
		alert('Please enter from date');
		a.from_date.focus();
		return false;
	} else if(a.to_date.value.trim()=="" && document.getElementById("never_expire").checked == false) {
		alert('Please enter expire date');
		a.to_date.focus();
		return false;
	}
}

function change_disc_type(val) {
	if(val == "percentage") {
		jQuery(".discount_lbl").html('Discount (%) *');
	} else {
		jQuery(".discount_lbl").html('Discount (<?=$currency_symbol?>) *');
	}
}

function change_multi_act_by_same_cust() {
	if(document.getElementById("multiple_act_by_same_cust").checked == true) {
		jQuery(".showhide_cust_qty").show();
	} else {
		jQuery(".showhide_cust_qty").hide();
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
</script>

<div id="wrapper">
    <header id="header" class="container">
    	<?php include("include/admin_menu.php"); ?>
    </header>

	<section class="container" role="main">
		<div class="row">
            <article class="span12 data-block">
				<header><h2>Edit Promo Code</h2></header>
                <section>
					<?php include('confirm_message.php');?>
                    <div class="row-fluid">
                        <div class="span9">
                            <form role="form" action="controllers/promocode.php" class="form-horizontal form-groups-bordered" method="post" onSubmit="return form_validation(this);" enctype="multipart/form-data">
                                <fieldset>
								<div class="control-group">
								  <label class="control-label" for="input">Promo Name *</label>
								  <div class="controls">
								  <input type="text" class="form-control" id="name" name="name" maxlength="15" placeholder="Enter promo name" value="<?=$promocode_data['name']?>">
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label" for="input">Promo Code *</label>
								  <div class="controls">
								  <input type="text" class="form-control" id="promocode" name="promocode" maxlength="15" placeholder="Enter promocode" value="<?=$promocode_data['promocode']?>">
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label" for="input">Description *</label>
								  <div class="controls">
								  <textarea class="form-control wysihtml5" rows="3" id="description" name="description" placeholder="Enter description"><?=$promocode_data['description']?></textarea>
								  </div>
								</div>
								
								<div class="control-group">
									<label class="control-label" for="fileInput">Image</label>
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
										if($promocode_data['image']!="") { ?>
											<div class="fileupload fileupload-new" data-provides="fileupload">
												<div class="fileupload-new thumbnail"><img src="../images/promocodes/<?=$promocode_data['image']?>" width="200"></div>
												<div class="fileupload-preview fileupload-exists fileupload-large flexible thumbnail"></div>
												<div>
													<a class="btn btn-alt btn-danger" data-dismiss="fileupload" href="controllers/promocode.php?id=<?=$id?>&r_img_id=<?=$promocode_data['id']?>" onclick="return confirm('Are you sure to delete this image?');">Remove</a>
												</div>
											</div>
											<input type="hidden" id="old_image" name="old_image" value="<?=$promocode_data['image']?>">
										<?php 
										} ?>	 
									</div>
								</div>
									
								<div class="control-group">
								  <label class="control-label" for="input">From Date *</label>
								  <div class="controls">
									  <input type="text" class="form-control datepicker" id="from_date" name="from_date" placeholder="Enter from_date date (mm/dd/yyyy)" value="<?=($promocode_data['from_date']!='0000-00-00'?date('m/d/Y',strtotime($promocode_data['from_date'])):'')?>">
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label" for="input">Expire Date *</label>
								  <div class="controls">
									  <input type="text" class="form-control datepicker" id="to_date" name="to_date" placeholder="Enter To date (mm/dd/yyyy)" value="<?=($promocode_data['to_date']!='0000-00-00'?date('m/d/Y',strtotime($promocode_data['to_date'])):'')?>">
								  </div>
								
									<div class="controls">
										<label class="checkbox custom-checkbox">
											<input type="checkbox" value="1" id="never_expire" name="never_expire" <?php if($promocode_data['never_expire']=='1'){echo 'checked="checked"';}?>> Never expire
										</label>
									</div>
								</div>
								
								<?php /*?><div class="control-group">
									<label class="control-label" for="input">Discount Type</label>
									<div class="controls">
									<select name="discount_type" id="discount_type" onchange="change_disc_type(this.value)">
										<option value="flat" <?php if($promocode_data['discount_type']=='flat'){echo 'selected="selected"';}?>>Flat</option>	
										<option value="percentage" <?php if($promocode_data['discount_type']=='unconfirmed'){echo 'selected="selected"';}?>>Percentage</option>
									</select>
									</div>
								</div><?php */?>
								
								<div class="control-group radio-inline">
									<label class="control-label" for="discount_type">Discount Type</label>
									<div class="controls">
										<label class="radio-custom-inline custom-radio">
											<input type="radio" id="discount_type_on" name="discount_type" value="flat" onchange="change_disc_type(this.value)" <?php if($promocode_data['discount_type']=='flat'){echo 'checked="checked"';}?>>
											Flat
										</label>
										<label class="radio-custom-inline ml-10 custom-radio">
											<input type="radio" id="discount_type_off" name="discount_type" value="percentage" onchange="change_disc_type(this.value)" <?php if($promocode_data['discount_type']=='percentage'){echo 'checked="checked"';}?>>
											Percentage
										</label>
									</div>
								</div>
								
								<div class="control-group">
								  <label class="control-label discount_lbl" for="discount">Surcharge <?=($promocode_data['discount_type']=='flat'?'('.$currency_symbol.') ':'(%)')?> *</label>
								  <div class="controls">
								  <input type="text" class="form-control" id="discount" name="discount" placeholder="Enter discount" value="<?=$promocode_data['discount']?>">
								  </div>
								</div>
								<div class="control-group">
									<label class="control-label" for="multiple_act_by_same_cust">Allow multiple activation by same cutomer</label>
									<div class="controls">
										<label class="checkbox custom-checkbox" style="width:20px;">
											<input type="checkbox" value="1" id="multiple_act_by_same_cust" name="multiple_act_by_same_cust" <?php if($promocode_data['multiple_act_by_same_cust']=='1'){echo 'checked="checked"';}?> onchange="change_multi_act_by_same_cust()">
										</label>
										<input type="number" min="1" class="form-control showhide_cust_qty" id="multi_act_by_same_cust_qty" name="multi_act_by_same_cust_qty" value="<?=($promocode_data['multi_act_by_same_cust_qty']>0?$promocode_data['multi_act_by_same_cust_qty']:'')?>" placeholder="Enter Qty" <?php if($promocode_data['multiple_act_by_same_cust']=='1'){echo 'style="display:block;"';}else{echo 'style="display:none;"';}?>>
									</div>
								</div>
								
								<div class="control-group">
								  <label class="control-label" for="act_by_cust">How many times can this code be activated? </label>
								  <div class="controls">
								  <input type="number" min="1" class="form-control" id="act_by_cust" name="act_by_cust" value="<?=($promocode_data['act_by_cust']>0?$promocode_data['act_by_cust']:'')?>">
								  </div>
								</div>
								<div class="control-group radio-inline">
									<label class="control-label" for="published">Active</label>
									<div class="controls">
										<label class="radio-custom-inline custom-radio">
											<input type="radio" id="status" name="status" value="1" <?php if($promocode_data['status']=='1'){echo 'checked="checked"';}?>>
											Yes
										</label>
										<label class="radio-custom-inline ml-10 custom-radio">
											<input type="radio" id="status" name="status" value="0" <?php if($promocode_data['status']=='0'){echo 'checked="checked"';}?>>
											No
										</label>
									</div>
								</div>
								<div class="form-actions">
									<button class="btn btn-alt btn-large btn-primary" type="submit" name="edit">Submit</button>
									<a href="promocode.php" class="btn btn-alt btn-large btn-black">Back</a>
								</div>
							  </fieldset>
							  <input type="hidden" name="id" value="<?=$promocode_data['id']?>" />
                            </form>
                        </div>
                    </div>
                </section>
            </article>
        </div>
    </section>
	<div id="push"></div>
</div>