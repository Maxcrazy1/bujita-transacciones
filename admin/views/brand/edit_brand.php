<script type="text/javascript">
function check_form(a) {
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
				<header><h2><?=($id?'Edit Brand':'Add Brand')?></h2></header>
                <section>
					<?php include('confirm_message.php');?>
                    <div class="row-fluid">
                        <div class="span9">
                            <form role="form" action="controllers/brand.php" class="form-horizontal form-groups-bordered" method="post" onSubmit="return check_form(this);" enctype="multipart/form-data">
                                <fieldset>
                                    <div class="control-group">
                                        <label class="control-label" for="input">Title</label>
                                        <div class="controls">
											<input type="text" class="input-large" id="first_name" value="<?=html_entities($brand_data['title'])?>" name="title">
                                        </div>
                                    </div>
									
									<div class="control-group">
                                        <label class="control-label" for="sef_url">Sef Url</label>
                                        <div class="controls">
											<input type="text" class="input-large" id="sef_url" value="<?=$brand_data['sef_url']?>" name="sef_url">
                                        </div>
                                    </div>
									
									<div class="control-group">
										<label class="control-label" for="meta_title">Meta Title</label>
										<div class="controls">
											<input type="text" class="form-large" id="meta_title" value="<?=$brand_data['meta_title']?>" name="meta_title">
										</div>
									</div>
									
									<div class="control-group">
										<label class="control-label" for="meta_desc">Meta Description</label>
										<div class="controls">
											<textarea class="form-large" name="meta_desc" rows="3"><?=$brand_data['meta_desc']?></textarea>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="meta_keywords">Meta Keywords</label>
										<div class="controls">
											<textarea class="form-large" name="meta_keywords" rows="3"><?=$brand_data['meta_keywords']?></textarea>
										</div>
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
													<div class="fileupload-new thumbnail"><img src="../images/brand/<?=$brand_data['image']?>" width="200"></div>
													<div class="fileupload-preview fileupload-exists fileupload-large flexible thumbnail"></div>
													<div>
														<a class="btn btn-alt btn-danger" data-dismiss="fileupload" href="controllers/brand.php?id=<?=$_REQUEST['id']?>&r_img_id=<?=$brand_data['id']?>" onclick="return confirm('Are you sure to delete this icon?');">Remove</a>
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
									
									<div class="control-group">
										<div class="controls">
											<label class="checkbox custom-checkbox">
												<input id="is_check_icloud" type="checkbox" value="1" name="is_check_icloud" <?php if($brand_data['is_check_icloud']=='1'){echo 'checked="checked"';}?>>
												Check iCloud ON/OFF Status
											</label>
										</div>
									</div>
									
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
										
                                    	<input type="hidden" name="id" value="<?=$brand_data['id']?>" />
									 
										<div class="form-actions">
											<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button>
											<a href="brand.php" class="btn btn-alt btn-large btn-black">Back</a>
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