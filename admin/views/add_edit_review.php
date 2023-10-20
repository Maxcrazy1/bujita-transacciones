<script type="text/javascript">
function check_form(a) {
	if(a.name.value.trim()==""){
		alert('Please enter name');
		a.name.focus();
		a.name.value='';
		return false;
	}

	if(a.email.value.trim()==""){
		alert('Please enter email');
		a.email.focus();
		a.email.value='';
		return false;
	}

	if(a.state.value.trim()==""){
		alert('Please enter state');
		a.state.focus();
		a.state.value='';
		return false;
	}

	if(a.city.value.trim()==""){
		alert('Please enter city');
		a.city.focus();
		a.city.value='';
		return false;
	}
	
	if(a.zip_code.value.trim()==""){
		alert('Please enter zip code');
		a.zip_code.focus();
		a.zip_code.value='';
		return false;
	}

	if(a.stars.value.trim()==""){
		alert('Please select rating');
		a.stars.focus();
		a.stars.value='';
		return false;
	}

	<?php /*?>if(a.title.value.trim()==""){
		alert('Please enter title');
		a.title.focus();
		a.title.value='';
		return false;
	}<?php */?>

	if(a.content.value.trim()==""){
		alert('Please enter content');
		a.content.focus();
		a.content.value='';
		return false;
	}

	if(a.date.value.trim()==""){
		alert('Please select date');
		a.date.focus();
		a.date.value='';
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
				<header><h2><?=($id?'Edit Review':'Add Review')?></h2></header>
                <section>
					<?php include('confirm_message.php');?>
                    <div class="row-fluid">
                        <div class="span9">
                            <form role="form" action="controllers/review.php" class="form-horizontal form-groups-bordered" method="post" onSubmit="return check_form(this);" enctype="multipart/form-data">
                                <fieldset>
                                    <div class="control-group">
                                        <label class="control-label" for="input">Name *</label>
                                        <div class="controls">
											<input type="text" class="input-large" name="name" id="name" value="<?=$review_data['name']?>">
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="input">Email *</label>
                                        <div class="controls">
											<input type="email" class="input-large" name="email" id="email" value="<?=$review_data['email']?>">
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="input">Country</label>
                                        <div class="controls">
											<select name="country" id="country" class="form-control">
												<option value=""> - Country - </option>
												<?php
												foreach($countries_list as $c_k => $c_v) { ?>
													<option value="<?=$c_v?>" <?php if($c_v==$review_data['country']){echo 'selected="selected"';}?>><?=$c_v?></option>
												<?php
												} ?>
											</select>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="input">State *</label>
                                        <div class="controls">
											<input type="text" class="input-large" name="state" id="state" value="<?=$review_data['state']?>">
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="input">City *</label>
                                        <div class="controls">
											<input type="text" class="input-large" name="city" id="city" value="<?=$review_data['city']?>">
                                        </div>
                                    </div>
									
									<div class="control-group">
                                        <label class="control-label" for="zip_code">Zip Code *</label>
                                        <div class="controls">
											<input type="text" class="input-large" name="zip_code" id="zip_code" value="<?=$review_data['zip_code']?>">
                                        </div>
                                    </div>
									
									<div class="control-group">
                                        <label class="control-label" for="zip_code">Device Sold</label>
                                        <div class="controls">
											<input type="text" class="input-large" name="device_sold" id="device_sold" value="<?=$review_data['device_sold']?>">
                                        </div>
                                    </div>
									
									<div class="control-group">
                                        <label class="control-label" for="website">Review Website</label>
                                        <div class="controls">
											<select name="website" id="website" class="form-control">
												<option value=""> - Website - </option>
												<?php
												foreach($review_website_list as $rw_k => $rw_v) { ?>
													<option value="<?=$rw_k?>" <?php if($rw_k==$review_data['website']){echo 'selected="selected"';}?>><?=$rw_v?></option>
												<?php
												} ?>
											</select>
                                        </div>
                                    </div>
									
                                    <div class="control-group">
                                        <label class="control-label" for="input">Star Rating *</label>
                                        <div class="controls">
											<select name="stars" id="stars" class="form-control">
												<option value=""> - Rating Star - </option>
												<?php
												for($si = 0.5; $si<= 5.0; $si=$si+0.5) { ?>
													<option value="<?=$si?>" <?php if($si==$review_data['stars']){echo 'selected="selected"';}?>><?=$si?></option>
												<?php
												} ?>
											</select>
                                        </div>
                                    </div>
									
									<?php /*?><div class="control-group">
                                        <label class="control-label" for="input">Title *</label>
                                        <div class="controls">
											<input type="text" class="input-large" name="title" id="title" value="<?=$review_data['title']?>">
                                        </div>
                                    </div><?php */?>

									<div class="control-group">
                                        <label class="control-label" for="input">Comment *</label>
                                        <div class="controls">
											<textarea class="form-control <?php /*?>wysihtml5<?php */?>" name="content" rows="5" style="width:400px;"><?=$review_data['content']?></textarea>
                                        </div>
                                    </div>

                                    <div class="control-group">
									  <label class="control-label" for="input">Date *</label>
									  <div class="controls">
										  <input type="text" class="form-control datepicker" id="date" name="date" placeholder="Select date (mm/dd/yyyy)" value="<?=($review_data['date']!='' && $review_data['date']!='0000-00-00'?date('m/d/Y',strtotime($review_data['date'])):'')?>">
									  </div>
									</div>

                                    <?php /*?><div class="control-group">
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
											if($review_data['photo']!="") { ?>
												<div class="fileupload fileupload-new" data-provides="fileupload">
													<div class="fileupload-new thumbnail"><img src="../images/review/<?=$review_data['photo']?>" width="200"></div>
													<div class="fileupload-preview fileupload-exists fileupload-large flexible thumbnail"></div>
													<div>
														<a class="btn btn-alt btn-danger" data-dismiss="fileupload" href="controllers/review.php?id=<?=$_REQUEST['id']?>&r_img_id=<?=$review_data['id']?>" onclick="return confirm('Are you sure to delete this icon?');">Remove</a>
													</div>
												</div>
												<input type="hidden" id="old_image" name="old_image" value="<?=$review_data['photo']?>">
											<?php 
											} ?>	 
										</div>
                                    </div><?php */?>

									<div class="control-group radio-inline">
											<label class="control-label" for="status">Status</label>
											<div class="controls">
												<label class="radio-custom-inline custom-radio">
													<input type="radio" id="status" name="status" value="1" <?php if(!$brand_id){echo 'checked="checked"';}?> <?=($review_data['status']==1?'checked="checked"':'')?>>
													Published
												</label>
												<label class="radio-custom-inline ml-10 custom-radio">
													<input type="radio" id="status" name="status" value="0" <?=($review_data['status']=='0'?'checked="checked"':'')?>>
													Unpublished
												</label>
											</div>
										</div>
										
                                    	<input type="hidden" name="id" value="<?=$review_data['id']?>" />
									 
										<div class="form-actions">
											<button class="btn btn-alt btn-large btn-primary" type="submit" name="add_update"><?=($id?'Update':'Save')?></button>
											<a href="review.php" class="btn btn-alt btn-large btn-black">Back</a>
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