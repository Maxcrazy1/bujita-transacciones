<div id="wrapper">
    <header id="header" class="container">
    	<?php include("include/admin_menu.php"); ?>
    </header>

	<section class="container" role="main">
		<div class="row">
            <article class="span12 data-block">
				<header><h2><?='Customer: Edit Profile'?></h2></header>
                <section>
					<?php include('confirm_message.php');?>
                    <div class="row-fluid">
                        <div class="span8">
                            <form action="controllers/user.php" role="form" class="form-horizontal form-groups-bordered" method="post" onSubmit="return check_form(this);" enctype="multipart/form-data">
                                <fieldset>
									<h4>Customer Details</h4>
									<div class="control-group">
                                        <label class="control-label" for="input">Company</label>
                                        <div class="controls">
											<input type="text" class="input-large" id="company_name" value="<?=$user_data['company_name']?>" name="company_name">
                                        </div>
                                    </div>
              						<div class="control-group">
                                        <label class="control-label" for="input">Name</label>
                                        <div class="controls">
											<input type="text" class="input-large" id="name" value="<?=$user_data['name']?>" name="name">
                                        </div>
                                    </div>
									<?php /*?><div class="control-group">
                                        <label class="control-label" for="input">Last Name</label>
                                        <div class="controls">
											<input type="text" class="input-large" id="last_name" value="<?=$user_data['last_name']?>" name="last_name">
                                        </div>
                                    </div><?php */?>
									<div class="control-group">
                                        <label class="control-label" for="input">Phone</label>
                                        <div class="controls">
											<input type="tel" id="cell_phone" name="cell_phone" class="input-large" placeholder="">
											<input type="hidden" name="phone" id="phone" />
											<span id="valid-msg" class="hide">✓ Valid</span>
											<span id="error-msg" class="hide">Invalid number</span>
                                        </div>
                                    </div>
									<div class="control-group">
                                        <label class="control-label" for="input">Email</label>
                                        <div class="controls">
											<input type="text" class="input-large" id="email" value="<?=$user_data['email']?>" name="email">
                                        </div>
                                    </div>
									<div class="control-group">
                                        <label class="control-label" for="input">Password</label>
                                        <div class="controls">
											<input type="password" class="input-large" id="password" name="password">
                                        </div>
                                    </div>
									
									<?php /*?><div class="control-group radio-inline">
										<label class="control-label" for="input">PhotoID Type</label>
										<div class="controls">
											<label class="radio custom-radio">
												<input type="radio" name="photoid_type" id="photoid_type1" value="send" checked="checked" onchange="chg_photoid_type('send');" <?=($user_data['photoid_type']=="send"?'checked="checked"':'')?>/> I will send photoID with my Device
											</label>
											<label class="radio custom-radio">
												<input type="radio" name="photoid_type" id="photoid_type2" value="upload" onchange="chg_photoid_type('upload');" <?=($user_data['photoid_type']=="upload"?'checked="checked"':'')?>/> Upload photoID
											</label>
										</div>
									</div>

									<div class="upload_photoid_section" <?=($user_data['photoid_type']=="upload"?'style="display:block;"':'style="display:none;"')?>>
										<div class="control-group">
											<label class="control-label">Upload photoID 1 *</label>
											<div class="controls">
												<input type="file" name="photoid[0]" id="photoid1" class="form-control" onChange="checkFile(this)"/>
											</div>
										</div>
										<div class="control-group" style="margin-top:5px;">
											<label class="control-label">Upload photoID 2 &nbsp;&nbsp;</label>
											<div class="controls">
												<input type="file" name="photoid[1]" id="photoid2" class="form-control" onChange="checkFile(this)"/>
											</div>
										</div>
										
										<?php
										$photoid_array = json_decode($user_data['photoid']);
										if(!empty($photoid_array)) {
											foreach($photoid_array as $photoid) {$n=$n+1; ?>
											<div class="control-group" <?php if($n == '2'){echo 'style="margin-top:5px;"';}?>>
												<label class="control-label" for="input">View PhotoID <?=$n?></label>
												<div class="controls">
													<img src="../images/users/<?=$photoid?>" width="100" />
												</div>
											</div>
											<?php
											} ?>
											<div class="control-group">
											<label class="control-label" for="input">&nbsp;</label>
												<div class="controls">
											<a class="btn btn-alt btn-danger" data-dismiss="fileupload" href="controllers/user.php?id=<?=$user_data['id']?>&r_img_id=<?=$user_data['id']?>" onclick="return confirm('Are you sure to delete this image?');">Remove</a>
											</div>
											</div>
										<?php
										} ?>
									</div><?php */?>

									<h4>Shipping Address</h4>
									<div class="control-group">
                                        <label class="control-label" for="input">Address Line</label>
                                        <div class="controls">
											<textarea type="text" class="input-large" id="address" name="address" rows="3"><?=$user_data['address']?></textarea>
                                        </div>
                                    </div>
									<div class="control-group">
                                        <label class="control-label" for="input">Address Line2</label>
                                        <div class="controls">
											<textarea type="text" class="input-large" id="address2" name="address2" rows="3"><?=$user_data['address2']?></textarea>
                                        </div>
                                    </div>
									<div class="control-group">
                                        <label class="control-label" for="input">City</label>
                                        <div class="controls">
											<input type="text" class="input-large" id="city" value="<?=$user_data['city']?>" name="city">
                                        </div>
                                    </div>
									<div class="control-group">
                                        <label class="control-label" for="input">State</label>
                                        <div class="controls">
											<input type="text" class="input-large" id="state" value="<?=$user_data['state']?>" name="state">
                                        </div>
                                    </div>
									<div class="control-group">
                                        <label class="control-label" for="input">Post Code</label>
                                        <div class="controls">
											<input type="text" class="input-large" id="postcode" value="<?=$user_data['postcode']?>" name="postcode">
                                        </div>
                                    </div>
									
									<div class="control-group">
										<div class="controls">
											<label class="checkbox custom-checkbox">
												<input id="occasional_special_offers" type="checkbox" value="1" name="occasional_special_offers" <?=($user_data['occasional_special_offers']=='1'?'checked="checked"':'')?>>
												Send me occasional special offers
											</label>
											<label class="checkbox custom-checkbox">
												<input id="important_sms_notifications" type="checkbox" value="1" name="important_sms_notifications" <?=($user_data['important_sms_notifications']=='1'?'checked="checked"':'')?>>
												Send me important SMS notifications
											</label>
										</div>
									</div>
									
									<div class="control-group radio-inline">
										<label class="control-label" for="input">Status</label>
										<div class="controls">
											<label class="radio-custom-inline custom-radio">
												<input type="radio" id="status" name="status" value="1" <?php if(!$id){echo 'checked="checked"';}?> <?=($user_data['status']==1?'checked="checked"':'')?>> Active
											</label>
											<label class="radio-custom-inline ml-10 custom-radio">
												<input type="radio" id="status" name="status" value="0" <?=($user_data['status']=='0'?'checked="checked"':'')?>> Inactive
											</label>
										</div>
									</div>
									
                                    <div class="form-actions">
                                        <button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($_REQUEST['id']?'Update':'Save')?></button>
										<a href="users.php" class="btn btn-alt btn-large btn-black">Back</a>
                                    </div>
                                </fieldset>
								<input type="hidden" name="id" value="<?=$user_data['id']?>" />
                            </form>
                        </div>
                    </div>
                </section>
            </article>
			
        </div>
    </section>
	<div id="push"></div>
</div>

<script src="../js/intlTelInput.js"></script>
<script>
var telInput = $("#cell_phone"),errorMsg = $("#error-msg"),validMsg = $("#valid-msg");
telInput.intlTelInput({
  initialCountry: "auto",
  geoIpLookup: function(callback) {
	$.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
	  var countryCode = (resp && resp.country) ? resp.country : "";
	  callback(countryCode);
	});
  },
  utilsScript: "../js/intlTelInput-utils.js" //just for formatting/placeholders etc
});

var reset = function() {
  telInput.removeClass("error");
  errorMsg.addClass("hide");
  validMsg.addClass("hide");
};

// on blur: validate
telInput.blur(function() {
  reset();
  if ($.trim(telInput.val())) {
	if(telInput.intlTelInput("isValidNumber")) {
	  validMsg.removeClass("hide");
	} else {
	  telInput.addClass("error");
	  errorMsg.removeClass("hide");
	}
  }
});

// on keyup / change flag: reset
telInput.on("keyup change", reset);

$("#cell_phone").intlTelInput("setNumber", "<?=($user_data['phone']?'+'.$user_data['phone']:'')?>");

function check_form(a){
	if(a.name.value.trim()==""){
		alert('Please enter name');
		a.name.focus();
		a.name.value='';
		return false;
	}
	/*if(a.last_name.value.trim()==""){
		alert('Please enter last name');
		a.last_name.focus();
		a.last_name.value='';
		return false;
	}*/
	
	var telInput = $("#cell_phone");
	$("#phone").val(telInput.intlTelInput("getNumber"));
	if(a.phone.value.trim()=="") {
		alert('Please enter phone number');
		return false;
	}
	if(!telInput.intlTelInput("isValidNumber")) {
		alert('Please enter valid phone number');
		return false;
	}
	
	if(a.phone.value.trim()==""){
		alert('Please enter phone');
		a.phone.focus();
		a.phone.value='';
		return false;
	}
	if(a.email.value.trim()==""){
		alert('Please enter email');
		a.email.focus();
		a.email.value='';
		return false;
	}
	if(a.address.value.trim()==""){
		alert('Please enter address line');
		a.address.focus();
		a.address.value='';
		return false;
	}
	if(a.city.value.trim()==""){
		alert('Please enter city');
		a.city.focus();
		a.city.value='';
		return false;
	}
	if(a.state.value.trim()==""){
		alert('Please enter state');
		a.state.focus();
		a.state.value='';
		return false;
	}
	if(a.postcode.value.trim()==""){
		alert('Please enter post code');
		a.postcode.focus();
		a.postcode.value='';
		return false;
	}
	if(a.phone.value.trim()==""){
		alert('Please enter description');
		a.phone.focus();
		a.phone.value='';
		return false;
	}
	if(a.phone.value.trim()==""){
		alert('Please enter description');
		a.phone.focus();
		a.phone.value='';
		return false;
	}
}

function chg_photoid_type(type) {
	if(type=="send") {
		$(".upload_photoid_section").hide();
	} else if(type=="upload") {
		$(".upload_photoid_section").show();
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

	if((FileExt != "png" && FileExt != "jpg" && FileExt != "jpeg")){
	    var error = "Please make sure your file is in png | jpg | jpeg format.\n\n";
	    alert(error);
		document.getElementById(id).value = '';
	    return false;
	}
}
</script>