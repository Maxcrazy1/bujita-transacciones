<script src="js/jquery.copy.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  $("#copy-constant").click(function() {
  	var constant_name = $("#constant_name").val();
	if(constant_name == "") {
		alert("Please select constant.");
		return false;
	} else {
   		var res = $.copy(constant_name);
    	//$("#status").text(res);
	}
  });
});

function form_validation(a){
	/*if(a.subject.value.trim()=="") {
		alert('Please enter subject');
		a.subject.focus();
		a.subject.value='';
		return false;
	} else */if(a.content.value.trim()=="") {
		alert('Please enter email content');
		a.content.focus();
		a.content.value='';
		return false;
	}

	<?php
	if(in_array($template_data['type'],$sms_sec_show_in_tmpl_array)) { ?>
	if(document.getElementById("sms_status_on").checked == true) {
		if(a.sms_content.value.trim()=="") {
			alert('Please enter sms content');
			a.sms_content.focus();
			a.sms_content.value='';
			return false;
		}
	}
	<?php
	} ?>
}
</script>

<div id="wrapper">
    <header id="header" class="container">
    	<?php include("include/admin_menu.php"); ?>
    </header>

	<section class="container" role="main">
		<div class="row">
            <article class="span12 data-block">
				<header><h2>Edit Email template</h2></header>
                <section>
					<?php include('confirm_message.php');?>
                    <div class="row-fluid">
                        <div class="span9">
                            <form role="form" action="controllers/email_template.php" class="form-horizontal form-groups-bordered" method="post" onSubmit="return form_validation(this);">
                                <fieldset>
									<div class="control-group">
										<label class="control-label" for="input">Template type</label>
										<div class="controls">
										<?php
										if($template_data['id']!='' && $template_data['is_fixed'] == '1') { ?>
											<input type="text" class="input-xlarge" value="<?=$template_type_array[$template_data['type']]?>" readonly="" />
											<input type="hidden" name="is_fixed" value="1" />
										<?php 
										} else{ ?>
											<select class="select2" name="type" id="type" required>
												<option value="">Select Template Type</option>
												<?php
												ksort($order_status_list);
												foreach($order_status_list as $order_status_k=>$order_status_v) {
													$template_type_val = "order_".$order_status_k."_status";
													$template_type_label = "Order ".$order_status_v." Status"; ?>
													<option value="<?=$template_type_val?>" <?php if($template_data['type'] == $template_type_val){echo 'selected="selected"';}?>><?=$template_type_label?></option>
												<?php
												} ?>
											</select>
											<input type="hidden" name="is_fixed" value="0" />
										<?php 
										} ?>
										</div>
									</div>
		  
									<div class="control-group">
									  <label class="control-label" for="input">Subject</label>
									  <div class="controls">
									  <input type="text" class="input-xlarge" id="subject" value="<?=$template_data['subject']?>" name="subject" required></div>
									</div>
										
									<div class="control-group">
									  <label class="control-label" for="input">Copy</label>
									  <div class="controls">
									  <select class="form-control" name="constant_name" id="constant_name">
										 <option value="">Select Constant to Copy</option>
										 <?php 
										 foreach($constants_array as $constants_value) { ?>
										 	<option value="<?=$constants_value?>"><?=$constants_value?></option>
										 <?php 
										 } ?>
									  </select>
									  &nbsp;<input type="button" class="btn btn-alt btn-md btn-primary" id="copy-constant" style="cursor:pointer;" value="COPY">
									  </div>
									</div>
											
									<div class="control-group">
									  <label class="control-label" for="input">Email Content</label>
									  <div class="controls">
									  <textarea class="form-control wysihtml5" id="text_editor" name="content" rows="10"><?=$template_data['content']?></textarea>
									  </div>
									</div>
									
									<?php
									if(in_array($template_data['type'],$sms_sec_show_in_tmpl_array) || ($template_data['id']=='' || $template_data['is_fixed'] != '1')) { ?>
									<div class="control-group radio-inline">
										<label class="control-label" for="sms_status">SMS Section</label>
										<div class="controls">
											<label class="radio-custom-inline custom-radio">
												<input type="radio" id="sms_status_on" name="sms_status" value="1" <?=($template_data['sms_status']==1?'checked="checked"':'')?>>
												Active
											</label>
											<label class="radio-custom-inline ml-10 custom-radio">
												<input type="radio" id="sms_status_off" name="sms_status" value="0" <?=(intval($template_data['sms_status'])=='0'?'checked="checked"':'')?>>
												Inactive
											</label>
										</div>
									</div>
										
									<div class="control-group">
									  <label class="control-label" for="sms_content">SMS Content</label>
									  <div class="controls">
									  <textarea class="input-xxlarge" id="sms_content" name="sms_content" rows="5" cols="50"><?=$template_data['sms_content']?></textarea>
									  </div>
									</div>
									<?php
									} ?>
									
									<div class="control-group radio-inline">
										<label class="control-label" for="status">Publish</label>
										<div class="controls">
											<label class="radio-custom-inline custom-radio">
												<input type="radio" id="status" name="status" value="1" <?=($template_data['status']==1?'checked="checked"':'')?>>
												Yes
											</label>
											<label class="radio-custom-inline ml-10 custom-radio">
												<input type="radio" id="status" name="status" value="0" <?=($template_data['status']=='0'||$template_data['status']==''?'checked="checked"':'')?>>
												No
											</label>
										</div>
									</div>
										
									<div class="form-actions">
                                        <button class="btn btn-alt btn-large btn-primary" type="submit" name="update">Submit</button>
										<a href="email_templates.php" class="btn btn-alt btn-large btn-black">Back</a>
                                    </div>
								 </fieldset>
								 <input type="hidden" name="id" value="<?=$template_data['id']?>" />
                            </form>
                        </div>
                    </div>
                </section>
            </article>
        </div>
    </section>
	<div id="push"></div>
</div>