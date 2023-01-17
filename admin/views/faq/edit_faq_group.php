<div id="wrapper">
    <header id="header" class="container">
    	<?php include("include/admin_menu.php"); ?>
    </header>

	<section class="container" role="main">
		<div class="row">
            <article class="span12 data-block">
				<header><h2><?=($id?'Edit Faq Group':'Add Faq Group')?></h2></header>
                <section>
					<?php include('confirm_message.php');?>
                    <div class="row-fluid">
                        <div class="span9">
                            <form role="form" action="controllers/faq_group.php" class="form-horizontal form-groups-bordered" method="post">
                                <fieldset>
                                    <div class="control-group">
                                        <label class="control-label" for="input">Name</label>
                                        <div class="controls">
											<input type="text" class="input-large" id="title" value="<?=$faq_data['title']?>" name="title" required>
                                        </div>
                                    </div>
									
									<div class="control-group">
										<label class="control-label" for="input">Category</label>
										<div class="controls">
											<select name="cat_id" id="cat_id">
												<option value=""> - Select - </option>
												<?php
												while($categories_list=mysqli_fetch_assoc($categories_data)) { ?>
													<option value="<?=$categories_list['id']?>" <?php if($categories_list['id']==$faq_data['cat_id']){echo 'selected="selected"';}?>><?=$categories_list['title']?></option>
												<?php
												} ?>
											</select>
										</div>
									</div>
									
									<div class="control-group radio-inline">
											<label class="control-label" for="status">Publish</label>
											<div class="controls">
												<label class="radio-custom-inline custom-radio">
													<input type="radio" id="status" name="status" value="1" <?php if(!$id){echo 'checked="checked"';}?> <?=($faq_data['status']==1?'checked="checked"':'')?>>
													Yes
												</label>
												<label class="radio-custom-inline ml-10 custom-radio">
													<input type="radio" id="status" name="status" value="0" <?=($faq_data['status']=='0'?'checked="checked"':'')?>>
													No
												</label>
											</div>
										</div>
										
                                    	<input type="hidden" name="id" value="<?=$faq_data['id']?>" />
									 
										<div class="form-actions">
											<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button>
											<a href="faqs_groups.php" class="btn btn-alt btn-large btn-black">Back</a>
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