<div id="wrapper">
    <header id="header" class="container">
    	<?php include("include/admin_menu.php"); ?>
    </header>

	<section class="container" role="main">
		<div class="row">
            <article class="span12 data-block">
				<header><h2><?=($id?'Edit Location':'Add Location')?></h2></header>
                <section>
					<?php include('confirm_message.php');?>
                    <div class="row-fluid">
                        <div class="span9">
                            <form role="form" action="controllers/starbuck_location.php" class="form-horizontal form-groups-bordered" method="post">
                                <fieldset>
                                    <div class="control-group">
                                        <label class="control-label" for="input">Name</label>
                                        <div class="controls">
											<input type="text" class="input-xlarge" id="name" value="<?=$starbuck_location_data['name']?>" name="name" required>
                                        </div>
                                    </div>
									
									<div class="control-group">
                                        <label class="control-label" for="input">Address</label>
                                        <div class="controls">
											<textarea class="input-xlarge" name="address" rows="3" required><?=$starbuck_location_data['address']?></textarea>
                                        </div>
                                    </div>
									
									<div class="control-group">
                                        <label class="control-label" for="input">Google Map Link</label>
                                        <div class="controls">
											<input type="url" class="input-xlarge" id="map_link" value="<?=$starbuck_location_data['map_link']?>" name="map_link">
                                        </div>
                                    </div>
									
									<div class="control-group radio-inline">
											<label class="control-label" for="status">Publish</label>
											<div class="controls">
												<label class="radio-custom-inline custom-radio">
													<input type="radio" id="status" name="status" value="1" <?php if(!$id){echo 'checked="checked"';}?> <?=($starbuck_location_data['status']==1?'checked="checked"':'')?>>
													Yes
												</label>
												<label class="radio-custom-inline ml-10 custom-radio">
													<input type="radio" id="status" name="status" value="0" <?=($starbuck_location_data['status']=='0'?'checked="checked"':'')?>>
													No
												</label>
											</div>
										</div>
										
                                    	<input type="hidden" name="id" value="<?=$starbuck_location_data['id']?>" />
									 
										<div class="form-actions">
											<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button>
											<a href="starbuck_locations.php" class="btn btn-alt btn-large btn-black">Back</a>
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