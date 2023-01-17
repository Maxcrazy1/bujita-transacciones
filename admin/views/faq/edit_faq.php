<div id="wrapper">
    <header id="header" class="container">
    	<?php include("include/admin_menu.php"); ?>
    </header>

	<section class="container" role="main">
		<div class="row">
            <article class="span12 data-block">
				<header><h2><?=($id?'Edit Faq':'Add Faq')?></h2></header>
                <section>
					<?php include('confirm_message.php');?>
                    <div class="row-fluid">
                        <div class="span9">
                            <form role="form" action="controllers/faq.php" class="form-horizontal form-groups-bordered" method="post">
                                <fieldset>
									<div class="control-group">
                                        <label class="control-label" for="input">Group</label>
                                        <div class="controls">
											<select name="group_id" id="group_id">
												<option value=""> -Select- </option>
												<?php
												while($faqs_groups_data=mysqli_fetch_assoc($faqs_groups_q)) { ?>
													<option value="<?=$faqs_groups_data['id']?>" <?php if($faqs_groups_data['id']==$faq_data['group_id']){echo 'selected="selected"';}?>><?=$faqs_groups_data['title']?></option>
												<?php
												} ?>
											</select>
                                        </div>
                                    </div>
									
                                    <div class="control-group">
                                        <label class="control-label" for="input">Question</label>
                                        <div class="controls">
											<input type="text" class="input-large" id="title" value="<?=$faq_data['title']?>" name="title" required>
                                        </div>
                                    </div>
									
									<div class="control-group">
                                        <label class="control-label" for="input">Answer</label>
                                        <div class="controls">
											<textarea class="form-control wysihtml5" name="description" rows="10" required><?=$faq_data['description']?></textarea>
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
											<a href="faqs.php" class="btn btn-alt btn-large btn-black">Back</a>
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