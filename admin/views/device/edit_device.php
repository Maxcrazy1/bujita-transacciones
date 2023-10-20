<script type="text/javascript">
function check_form(a){
	/*if(a.brand_id.value.trim()==""){
		alert('Please select device brand');
		a.brand_id.focus();
		return false;
	}*/
	
	if(a.title.value.trim()==""){
		alert('Please enter title');
		a.title.focus();
		a.title.value='';
		return false;
	}
	
	if(a.sef_url.value.trim()==""){
		alert('Please enter sef url');
		a.sef_url.focus();
		a.sef_url.value='';
		return false;
	}
	
	<?php
	if($device_data['device_img']=="") { ?>
	var str_image = a.device_img.value.trim();
	if(str_image == "") {
		alert('Please select image');
		return false;
	}
	<?php
	} ?>
	
	/*if(a.description.value.trim()==""){
		alert('Please enter description');
		a.description.focus();
		a.description.value='';
		return false;
	}*/
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
				<header><h2><?=($id?'Edit Device':'Add Device')?></h2></header>
                <section>
					<?php include('confirm_message.php');?>
                    <div class="row-fluid">
                        <div class="span9">
                            <form role="form" action="controllers/device.php" class="form-horizontal form-groups-bordered" method="post" onSubmit="return check_form(this);" enctype="multipart/form-data">
                                <fieldset>
									<?php /*?><div class="control-group">
                                        <label class="control-label" for="input">Select Device Brand</label>
                                        <div class="controls">
											<select name="brand_id" id="brand_id">
												<option value=""> - Select - </option>
												<?php
												while($brands_list=mysqli_fetch_assoc($brands_data)) { ?>
													<option value="<?=$brands_list['id']?>" <?php if($brands_list['id']==$device_data['brand_id']){echo 'selected="selected"';}?>><?=$brands_list['title']?></option>
												<?php
												} ?>
											</select>
                                        </div>
                                    </div><?php */?>
									
                                    <div class="control-group">
                                        <label class="control-label" for="input">Device Title</label>
                                        <div class="controls">
											<input type="text" class="input-large" id="title" value="<?=html_entities($device_data['title'])?>" name="title">
                                        </div>
                                    </div>
									
									<div class="control-group">
                                        <label class="control-label" for="input">Sef Url</label>
                                        <div class="controls">
											<input type="text" class="input-large" id="sef_url" value="<?=$device_data['sef_url']?>" name="sef_url">
                                        </div>
                                    </div>
									
									<div class="control-group">
                                        <label class="control-label" for="input">Meta Title</label>
                                        <div class="controls">
											<input type="text" class="input-large" id="meta_title" value="<?=$device_data['meta_title']?>" name="meta_title">
                                        </div>
                                    </div>
									
									<div class="control-group">
                                        <label class="control-label" for="input">Meta Description</label>
                                        <div class="controls">
											<textarea class="form-control" name="meta_desc" rows="4"><?=$device_data['meta_desc']?></textarea>
                                        </div>
                                    </div>
									
									<div class="control-group">
                                        <label class="control-label" for="input">Meta Keywords</label>
                                        <div class="controls">
											<textarea class="form-control" name="meta_keywords" rows="3"><?=$device_data['meta_keywords']?></textarea>
                                        </div>
                                    </div>
									
									<div class="control-group">
                                        <label class="control-label" for="fileInput">Device Picture</label>
                                        <div class="controls">
                                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                                <div class="input-append">
                                                    <div class="uneditable-input">
                                                        <i class="icon-file fileupload-exists"></i>
                                                        <span class="fileupload-preview"></span>
                                                    </div>
                                                    <span class="btn btn-alt btn-file">
                                                            <span class="fileupload-new">Select Picture</span>
                                                            <span class="fileupload-exists">Change</span>
                                                            <input type="file" class="form-control" id="device_img" name="device_img" onChange="checkFile(this);" accept="image/*">
                                                    </span>
                                                    <a href="javascript:void(0);" class="btn btn-alt btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                </div>
                                            </div>
											
											<?php 
											if($device_data['device_img']!="") { ?>
												<div class="fileupload fileupload-new" data-provides="fileupload">
													<div class="fileupload-new thumbnail"><img src="../images/device/<?=$device_data['device_img']?>" width="200"></div>
													<div class="fileupload-preview fileupload-exists fileupload-large flexible thumbnail"></div>
													<div>
														<a class="btn btn-alt btn-danger" data-dismiss="fileupload" href="controllers/device.php?id=<?=$id?>&r_img_id=<?=$device_data['id']?>" onclick="return confirm('Are you sure to delete this image?');">Remove</a>
													</div>
												</div>
												<input type="hidden" id="old_image" name="old_image" value="<?=$device_data['device_img']?>">
											<?php 
											} ?> 
										</div>
                                    </div>
									
									<div class="control-group">
                                        <label class="control-label" for="input">Tooltip of Condition</label>
                                        <div class="controls">
											<textarea class="form-control wysihtml5" name="tooltip_condition" rows="5"><?=$device_data['tooltip_condition']?></textarea>
                                        </div>
                                    </div>
									
									<div class="control-group">
                                        <label class="control-label" for="input">Tooltip of Network</label>
                                        <div class="controls">
											<textarea class="form-control wysihtml5" name="tooltip_network" rows="5"><?=$device_data['tooltip_network']?></textarea>
                                        </div>
                                    </div>
									
									<div class="control-group">
                                        <label class="control-label" for="input">Sub Title</label>
                                        <div class="controls">
											<textarea class="form-control wysihtml5" name="sub_title" rows="5"><?=$device_data['sub_title']?></textarea>
                                        </div>
                                    </div>

									<div class="control-group">
                                        <label class="control-label" for="input">Description</label>
                                        <div class="controls">
											<textarea class="form-control wysihtml5" name="description" rows="5"><?=$device_data['description']?></textarea>
                                        </div>
                                    </div>
									
									<div class="control-group">
										<div class="controls">
											<label class="checkbox custom-checkbox">
												<input id="popular_device" type="checkbox" value="1" name="popular_device" <?php if($device_data['popular_device']=='1'){echo 'checked="checked"';}?>>
												Check if device is popular, popular device appear in popular section.
											</label>
										</div>
									</div>
										
									<div class="control-group radio-inline">
										<label class="control-label" for="published">Publish</label>
										<div class="controls">
											<label class="radio-custom-inline custom-radio">
												<input type="radio" id="published" name="published" value="1" <?php if(!$id){echo 'checked="checked"';}?> <?=($device_data['published']==1?'checked="checked"':'')?>>
												Yes
											</label>
											<label class="radio-custom-inline ml-10 custom-radio">
												<input type="radio" id="published" name="published" value="0" <?=($device_data['published']=='0'?'checked="checked"':'')?>>
												No
											</label>
										</div>
									</div>
									
                                    <input type="hidden" name="id" value="<?=$device_data['id']?>" />
                                    <div class="form-actions">
                                        <button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button>
										<a href="device.php" class="btn btn-alt btn-large btn-black">Back</a>
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