<script type="text/javascript">
function check_form(a){
	<?php
	if(!in_array($post['slug'],array("home"))) { ?>
	if(a.title.value.trim()=="") {
		alert('Please enter title');
		a.title.focus();
		return false;
	} else if(a.url.value.trim()=="") {
		alert('Please enter url');
		a.url.focus();
		return false;
	}
	<?php
	}
	if(!$post['slug']) { ?>
	if(a.description.value.trim()=="") {
		alert('Please enter description');
		a.description.focus();
		a.description.value='';
		return false;
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
				<header><h2><?=($id?'Edit Page':'Add Page')?></h2></header>
                <section>
					<?php include('confirm_message.php');?>
                    <div class="row-fluid">
                        <div class="span9">
                            <form role="form" action="controllers/page.php" class="form-horizontal form-groups-bordered" method="post" onSubmit="return check_form(this);" enctype="multipart/form-data">
                                <fieldset>
									<?php /*?><div class="control-group">
                                        <label class="control-label" for="input">Menu Position</label>
                                        <div class="controls">
											<select name="position[]" id="position[]" multiple="multiple[]">
												<option value="">Select</option>
												<option value="top_right" <?php if("top_right"==$exp_position['top_right']){echo 'selected="selected"';}?>>Top Right Menu</option>
												<option value="header" <?php if("header"==$exp_position['header']){echo 'selected="selected"';}?>>Header Menu</option>
												<option value="footer_column1" <?php if("footer_column1"==$exp_position['footer_column1']){echo 'selected="selected"';}?>>Footer Menu Column1</option>
												<option value="footer_column2" <?php if("footer_column2"==$exp_position['footer_column2']){echo 'selected="selected"';}?>>Footer Menu Column2</option>
												<option value="footer_column3" <?php if("footer_column3"==$exp_position['footer_column3']){echo 'selected="selected"';}?>>Footer Menu Column3</option>
												<option value="copyright_menu" <?php if("copyright_menu"==$exp_position['copyright_menu']){echo 'selected="selected"';}?>>Copyright Menu</option>
											</select>
                                        </div>
                                    </div><?php */?>
									
									<?php
									if(!in_array($post['slug'],array("home"))) { ?>
									<div class="control-group">
										<label class="control-label" for="input">Select Category</label>
										<div class="controls">
											<select name="cat_id" id="cat_id">
												<option value=""> -Select- </option>
												<?php
												//Fetch device list
												$categories_data=mysqli_query($db,'SELECT * FROM categories WHERE published=1');
												while($categories_list=mysqli_fetch_assoc($categories_data)) { ?>
													<option value="<?=$categories_list['id']?>" <?php if($categories_list['id']==$page_data['cat_id']){echo 'selected="selected"';}?>><?=$categories_list['title']?></option>
												<?php
												} ?>
											</select>
										</div>
									</div>

									<div class="control-group">
										<label class="control-label" for="input">Select Device</label>
										<div class="controls">
											<select name="device_id[]" id="device_id[]" onchange="changedevice(this.value);" multiple>
												<option value=""> -Select- </option>
												<?php
												$arr_device_id = explode(",",$page_data['device_id']);
												while($devices_list=mysqli_fetch_assoc($devices_data)) { ?>
													<option value="<?=$devices_list['id']?>" <?php if(in_array($devices_list['id'],$arr_device_id)){echo 'selected="selected"';}?>><?=$devices_list['title']?></option>
												<?php
												} ?>
											</select>
										</div>
									</div>
									<?php
									} ?>
									
									<?php /*?><div class="control-group">
                                        <label class="control-label" for="input">Menu Name</label>
                                        <div class="controls">
											<input type="text" class="input-large" id="menu_name" value="<?=($menu_name?$menu_name:$inbuild_page_data['name'])?>" name="menu_name">
                                        </div>
                                    </div>
									
									<div class="control-group radio-inline">
										<label class="control-label" for="menu_align">Menu Align</label>
										<div class="controls">
											<label class="radio custom-radio">
												<input type="radio" id="menu_align" name="menu_align" value="left" <?php if($page_data['menu_align']==''){echo 'checked="checked"';}?> <?=($page_data['menu_align']=='left'?'checked="checked"':'')?>>
												Left
											</label>
											<label class="radio custom-radio">
												<input type="radio" id="menu_align" name="menu_align" value="right" <?=($page_data['menu_align']=='right'?'checked="checked"':'')?>>
												Right
											</label>
										</div>
									</div><?php */?>
									
                                    <div class="control-group">
                                        <label class="control-label" for="input">Title</label>
                                        <div class="controls">
											<input type="text" class="input-large" id="title" value="<?=($title?$title:$inbuild_page_data['title'])?>" name="title">
                                        </div>
                                        <div class="controls">
											<label class="radio-custom-inline custom-radio">
												<input type="checkbox" class="input-large" id="show_title" value="1" name="show_title" <?=($page_data['show_title']=='1'?'checked="checked"':'')?>> <span>Show Title</span>
											</label>
										</div>
                                    </div>
									
									<?php
									if(!in_array($post['slug'],array("home"))) { ?>
									<div class="control-group">
                                        <label class="control-label" for="input">Url</label>
                                        <div class="controls">
											<input type="text" class="input-large" id="url" value="<?=$finl_url?>" name="url">
                                        </div>
                                        <div class="controls">
											<label class="radio-custom-inline custom-radio">
												<input type="checkbox" class="input-large" id="is_custom_url" value="1" name="is_custom_url" <?=($page_data['is_custom_url']=='1'?'checked="checked"':'')?>> <span>Custom Url</span>
											</label>
											<label class="radio-custom-inline ml-10 custom-radio">
												<input type="checkbox" class="input-large" id="is_open_new_window" value="1" name="is_open_new_window" <?=($page_data['is_open_new_window']=='1'?'checked="checked"':'')?>> <span>Is Open New Window</span>
											</label>
										</div>
                                    </div>
									<?php
									} ?>
									
									<?php /*?><div class="control-group">
                                        <label class="control-label" for="input">Custom CSS Class</label>
                                        <div class="controls">
											<input type="text" class="input-large" id="css_menu_class" value="<?=$page_data['css_menu_class']?>" name="css_menu_class">
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="input">Custom CSS Fa Icon</label>
                                        <div class="controls">
											<input type="text" class="input-large" id="css_menu_fa_icon" value="<?=$page_data['css_menu_fa_icon']?>" name="css_menu_fa_icon">
                                        </div>
                                    </div><?php */?>
									
									<div class="control-group">
                                        <label class="control-label" for="input">CSS Class</label>
                                        <div class="controls">
											<input type="text" class="input-large" id="css_page_class" value="<?=$page_data['css_page_class']?>" name="css_page_class">
                                        </div>
                                    </div>
									
									<div class="control-group">
                                        <label class="control-label" for="input">Module Position</label>
                                        <div class="controls">
											<select name="module_position" id="module_position">
												<option value="" <?php if(""==$page_data['module_position']){echo 'selected="selected"';}?>>None</option>
												<option value="left" <?php if("left"==$page_data['module_position']){echo 'selected="selected"';}?>>Left</option>
												<option value="right" <?php if("right"==$page_data['module_position']){echo 'selected="selected"';}?>>Right</option>
											</select>
                                        </div>
                                    </div>
									
									<div class="control-group">
                                        <label class="control-label" for="input">Meta Title</label>
                                        <div class="controls">
											<input type="text" class="input-large" id="meta_title" value="<?=$page_data['meta_title']?>" name="meta_title">
                                        </div>
                                    </div>
									
									<div class="control-group">
                                        <label class="control-label" for="input">Meta Description</label>
                                        <div class="controls">
											<textarea class="form-control" name="meta_desc" rows="4"><?=$page_data['meta_desc']?></textarea>
                                        </div>
                                    </div>
									
									<div class="control-group">
                                        <label class="control-label" for="input">Meta Keywords</label>
                                        <div class="controls">
											<textarea class="form-control" name="meta_keywords" rows="3"><?=$page_data['meta_keywords']?></textarea>
                                        </div>
                                    </div>
									
									<?php
									//,'contact'
									$slug_desc_not_show_array = array('blog','terms-and-conditions');
									if(!in_array($post['slug'],$slug_desc_not_show_array)) { ?>
									<div class="control-group">
                                        <label class="control-label" for="fileInput">Header Image</label>
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
											if($page_data['image']!="") { ?>
												<div class="fileupload fileupload-new" data-provides="fileupload">
													<div class="fileupload-new thumbnail"><img src="../images/pages/<?=$page_data['image']?>" width="200"></div>
													<div class="fileupload-preview fileupload-exists fileupload-large flexible thumbnail"></div>
													<div>
														<a class="btn btn-alt btn-danger" data-dismiss="fileupload" href="controllers/page.php?id=<?=$_REQUEST['id']?>&r_img_id=<?=$page_data['id']?>" onclick="return confirm('Are you sure to delete this image?');">Remove</a>
													</div>
												</div>
												<input type="hidden" id="old_image" name="old_image" value="<?=$page_data['image']?>">
											<?php 
											} ?>	 
										</div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="input">Header Image Text</label>
                                        <div class="controls">
											<input type="text" class="input-large" id="image_text" value="<?=$page_data['image_text']?>" name="image_text">
                                        </div>
                                    </div>

									<div class="control-group">
                                        <label class="control-label" for="input">Description</label>
                                        <div class="controls">
											<textarea class="form-control wysihtml5" name="description" rows="8"><?=$page_data['content']?></textarea>
                                        </div>
                                    </div>
									<?php
									} ?>
									
									<?php /*?><div class="control-group">
										<label class="control-label" for="input">Order (Must be numeric)</label>
										<div class="controls">
											<input id="ordering" type="number" name="ordering" value="<?=$page_data['ordering']?>">
										</div>
									</div><?php */?>
										
									<div class="control-group radio-inline">
										<label class="control-label" for="published">Publish</label>
										<div class="controls">
											<label class="radio-custom-inline custom-radio">
												<input type="radio" id="published" name="published" value="1" <?php if(!$id){echo 'checked="checked"';}?> <?=($page_data['published']==1?'checked="checked"':'')?>>
												Yes
											</label>
											<label class="radio-custom-inline ml-10 custom-radio">
												<input type="radio" id="published" name="published" value="0" <?=($page_data['published']=='0'?'checked="checked"':'')?>>
												No
											</label>
										</div>
									</div>
									
                                    <input type="hidden" name="id" value="<?=$page_data['id']?>" />
									<input type="hidden" name="slug" value="<?=$post['slug']?>" />
                                    <div class="form-actions">
                                        <button class="btn btn-alt btn-large btn-primary" type="submit" name="add_edit"><?=($id?'Update':'Save')?></button>
										<a href="page.php" class="btn btn-alt btn-large btn-black">Back</a>
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