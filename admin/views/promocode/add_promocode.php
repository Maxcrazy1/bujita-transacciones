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
				<header><h2>Add Promo Code</h2></header>
                <section>
					<?php include('confirm_message.php');?>
                    <div class="row-fluid">
                        <div class="span9">
                            <form role="form" action="controllers/promocode.php" class="form-horizontal form-groups-bordered" method="post" onSubmit="return form_validation(this);" enctype="multipart/form-data">
                                <fieldset>
								<div class="control-group">
								  <label class="control-label" for="input">Promo Name *</label>
								  <div class="controls">
								  <input type="text" class="form-control" id="name" name="name" maxlength="255" placeholder="Enter promo name">
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label" for="input">Promo Code *</label>
								  <div class="controls">
								  <input type="text" class="form-control" id="promocode" name="promocode" maxlength="15" placeholder="Enter promocode">
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label" for="input">Description *</label>
								  <div class="controls">
								  <textarea class="form-control wysihtml5" rows="3" id="description" name="description" placeholder="Enter description"></textarea>
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
									</div>
								</div>
								
								<div class="control-group">
								  <label class="control-label" for="input">From Date *</label>
								  <div class="controls">
									  <input type="text" class="form-control datepicker" id="from_date" name="from_date" placeholder="Enter from date (mm/dd/yyyy)">
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label" for="input">Expire Date *</label>
								  <div class="controls">
									  <input type="text" class="form-control datepicker" id="to_date" name="to_date" placeholder="Enter to date (mm/dd/yyyy)">
								  </div>
								
									<div class="controls">
										<label class="checkbox custom-checkbox">
											<input type="checkbox" value="1" id="never_expire" name="never_expire"> Never expire
										</label>
									</div>
								</div>
								
								<div class="control-group radio-inline">
									<label class="control-label" for="discount_type">Surcharge Type</label>
									<div class="controls">
										<label class="radio-custom-inline custom-radio">
											<input type="radio" id="discount_type_on" name="discount_type" value="flat" onchange="change_disc_type(this.value)">
											Flat
										</label>
										<label class="radio-custom-inline ml-10 custom-radio">
											<input type="radio" id="discount_type_off" name="discount_type" value="percentage" checked="checked" onchange="change_disc_type(this.value)">
											Percentage
										</label>
									</div>
								</div>
								
								<div class="control-group">
								 <label class="control-label discount_lbl" for="discount">Surcharge <?=($promocode_data['discount_type']=='flat'?'('.$currency_symbol.') ':'(%)')?> *</label>
								  <div class="controls">
								  <input type="text" class="form-control" id="discount" name="discount" placeholder="Enter discount">
								  </div>
								</div>
								
								<div class="control-group">
									<label class="control-label" for="published">Allow multiple activation by same cutomer</label>
									<div class="controls">
										<label class="checkbox custom-checkbox">
											<input type="checkbox" value="1" id="multiple_act_by_same_cust" name="multiple_act_by_same_cust" onchange="change_multi_act_by_same_cust()">
										</label>
										 <input type="number" min="1" class="form-control showhide_cust_qty" id="multi_act_by_same_cust_qty" name="multi_act_by_same_cust_qty" placeholder="Enter Qty" style="display:none;">
									</div>
								</div>
								
								<div class="control-group">
								  <label class="control-label" for="act_by_cust">How many times can this code be activated? </label>
								  <div class="controls">
								  <input type="number" min="1" class="form-control" id="act_by_cust" name="act_by_cust">
								  </div>
								</div>
								<div class="control-group radio-inline">
									<label class="control-label" for="published">Active</label>
									<div class="controls">
										<label class="radio-custom-inline custom-radio">
											<input type="radio" id="status" name="status" value="1">
											Yes
										</label>
										<label class="radio-custom-inline ml-10 custom-radio">
											<input type="radio" id="status" name="status" value="0" checked="checked">
											No
										</label>
									</div>
								</div>
								<div class="form-actions">
									<button class="btn btn-alt btn-large btn-primary" type="submit" name="add">Submit</button>
									<a href="promocode.php" class="btn btn-alt btn-large btn-black">Back</a>
								</div>
							  </fieldset>
                            </form>
                        </div>
                    </div>
                </section>
            </article>
        </div>
    </section>
	<div id="push"></div>
</div>