<div id="wrapper">
    <header id="header" class="container">
    	<?php include("include/admin_menu.php"); ?>
    </header>
	
	<section class="container" role="main">
         <div class="row">
            <article class="span12 data-block">
                <header>
					<h2>Mobile Models</h2>
					<?php
					if($prms_model_add == '1') { ?>
					<ul class="data-header-actions">
						<li><a href="edit_mobile.php">Add New</a></li>
					</ul>
					<?php
					} ?>
				</header>
                <section>
                	<?php require_once('confirm_message.php');?>
					
					<form method="post">
						<div class="control-group">
							<div class="controls">
								<input type="text" class="span3" placeholder="Search By Title" name="filter_by" id="filter_by" value="<?=$post['filter_by']?>" style="width:190px;">
								<select name="cat_id" id="cat_id" class="span3" style="width:190px;">
									<option value=""> - Select Category - </option>
									<?php
									while($categories_list=mysqli_fetch_assoc($categories_data)) { ?>
										<option value="<?=$categories_list['id']?>" <?php if($categories_list['id']==$post['cat_id']){echo 'selected="selected"';}?>><?=$categories_list['title']?></option>
									<?php
									} ?>
								</select>
								
								<select name="brand_id" id="brand_id" class="span3" style="width:190px;">
									<option value=""> - Select Brand - </option>
									<?php
									while($brands_list=mysqli_fetch_assoc($brands_data)) { ?>
										<option value="<?=$brands_list['id']?>" <?php if($brands_list['id']==$post['brand_id']){echo 'selected="selected"';}?>><?=$brands_list['title']?></option>
									<?php
									} ?>
								</select>
											
								<select name="device_id" id="device_id" class="span3" style="width:190px;">
									<option value=""> - Select Device - </option>
									<?php
									while($devices_list=mysqli_fetch_assoc($devices_data)) { ?>
										<option value="<?=$devices_list['id']?>" <?php if($devices_list['id']==$post['device_id']){echo 'selected="selected"';}?>><?=$devices_list['title']?></option>
									<?php
									} ?>
								</select>

								<button class="btn btn-alt btn-primary searchbx" type="submit" name="search">Search</button>
								<?php
								if($post['filter_by'] || $post['cat_id'] || $post['brand_id'] || $post['device_id']) {
									echo '<a href="mobile.php"><button class="btn btn-alt btn-primary" type="button">Clear</button></a>';
								} ?>
							</div>
						</div>
					</form>

					<div class="row-fluid">
						<div class="span4">
							<form action="controllers/mobile.php" method="POST" style="margin-bottom:0px;">
								<div class="control-group">
									<div class="controls">
										<input type="hidden" name="ids" class="ids" id="ids" value="">
										<input type="hidden" name="filter_by" id="filter_by" value="<?=$post['filter_by']?>">
										<input type="hidden" name="cat_id" id="cat_id" value="<?=$post['cat_id']?>">
										<input type="hidden" name="brand_id" id="brand_id" value="<?=$post['brand_id']?>">
										<input type="hidden" name="device_id" id="device_id" value="<?=$post['device_id']?>">
										
										<?php
										if($prms_model_delete == '1') { ?>
										<button class="btn btn-alt btn-danger bulk_remove" name="bulk_remove">Bulk Remove</button>
										<?php
										} ?>
										<button class="btn btn-alt btn-danger import" name="import" onClick="ImportModal();return false;">IMPORT</button>
										<?php
										if($post['cat_id']) { ?>
										<button class="btn btn-alt btn-danger export" name="export">EXPORT</button>
										<?php
										} ?>
									</div>	
								</div>
							</form>
						</div>
				
						<div class="span8">
							<?php //echo $pages->page_limit_dropdown(); ?>
						</div>
					</div>
					
                	<?php /*?><div id="table_pagination_wrapper" class="dataTables_wrapper form-inline" role="grid"><?php */?>
                	<form action="controllers/mobile.php" method="post">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                            	<th width="10"><input type="checkbox" id="chk_all"></th>
                                <th width="110">Icon</th>
								<th>Preview</th>
                                <th>Title</th>
								<th>Device</th>
								<th>Brand</th>
								<!--<th width="60">Price</th>-->
								<th width="30">Order <input type="submit" name="sbt_order" value="Save" class="btn btn-alt"></th>
                                <th width="200">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
							$num_rows = mysqli_num_rows($query);
							if($num_rows>0) {
								while($model_data=mysqli_fetch_assoc($query)) { ?>
								<tr>
									<td><input type="checkbox" onclick="clickontoggle('<?=$model_data['id']?>');" class="sub_chk" name="chk[]" value="<?=$model_data['id']?>"></td>
									<td>
									<?php
									if($model_data['model_img'])
										echo '<img src="../images/mobile/'.$model_data['model_img'].'" loading="lazy" width="100" height="100" />';
									?>
									</td>
									<td><a target="_blank" href="<?=SITE_URL.$model_data['sef_url'].'/'.createSlug($model_data['title']).'/'.$model_data['id']?>">Preview</a></td>
									<td><?=$model_data['title']?></td>
									<td><?=$model_data['device_title']?></td>
									<td><?=$model_data['brand_title']?></td>
									<!--<td><?=amount_fomat($model_data['price'])?></td>-->
									<td>
										<input type="text" class="input-small" id="ordering<?=$model_data['id']?>" value="<?=$model_data['ordering']?>" name="ordering[<?=$model_data['id']?>]">
									</td>
									<td>
										<?php
										if($prms_model_edit == '1') { ?>
										<a href="edit_mobile.php?id=<?=$model_data['id']?>" class="btn btn-alt btn-default"><i class="icon-pencil"></i></a>
										<?php
										}
										if($prms_model_delete == '1') { ?>
										<a href="controllers/mobile.php?d_id=<?=$model_data['id']?>" class="btn btn-danger btn-alt" onclick="return confirm('are you sure to delete this record?')"> <i class="icon-trash"></i></a>
										<?php
										}
										if($model_data['published']==1) {
											echo '<a href="controllers/mobile.php?p_id='.$model_data['id'].'&published=0"><button class="btn btn-alt btn-success" style="pointer-events: none;">Published</button></a>';
										} elseif($model_data['published']==0) {
											echo '<a href="controllers/mobile.php?p_id='.$model_data['id'].'&published=1"><button class="btn btn-alt btn-danger" style="pointer-events: none;">Unpublished</button></a>';
										}
										?>
									</td>
								</tr>
								<?php
								}
							} ?>
                        </tbody>
                    </table>
                    </form>
                	<?php
					echo $pages->page_links(); ?>
                </section>
        	</article>
        </div>
    </section>
	<div id="push"></div>
</div>

<div class="modal primary fade" id="export_modal">
	<div class="modal-dialog">
		<div class="modal-content">

			<!-- Modal header -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title">Model(s) Import</h3>
			</div>
			<!-- /Modal header -->

			<form action="controllers/mobile.php" method="POST" style="margin-bottom:0px;" enctype="multipart/form-data">
				<!-- Modal body -->
				<div class="modal-body">
					<fieldset>
						<div class="control-group">
							<label class="control-label" for="input">Select File</label>
							<div class="controls">
								<div class="fileupload fileupload-new" data-provides="fileupload">
									<div class="input-append">
										<div class="uneditable-input">
											<i class="icon-file fileupload-exists"></i>
											<span class="fileupload-preview"></span>
										</div>
										<span class="btn btn-alt btn-file">
											<span class="fileupload-new">Select File</span>
											<span class="fileupload-exists">Change</span>
											<input type="file" class="form-control" id="file_name" name="file_name">
										</span>
										<a href="javascript:void(0);" class="btn btn-alt btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a>
									</div>
									<!--<br />
									<a href="sample_files/models-sample-file.csv" class="btn btn-alt btn-success"><i class="fa fa-download"></i> Download Sample File</a>-->
									<br />
									<small>Models icon you need to upload in this folder by FTP/Cpanel (<?=CP_ROOT_PATH?>/images/mobile)</small>
								</div>
							</div>
						</div>
						
						<div class="control-group">
							<label class="control-label" for="input">Choose Type To Download Sample File</label>
							<div class="controls">
								<select name="cat_d_type" id="cat_d_type">
									<option value="mobile">Mobile</option>
									<option value="tablet">Tablet</option>
									<option value="watch">Watch</option>
									<option value="laptop">Laptop</option>
								</select>

								<a href="sample_files/models-mobile-sample-file.csv" class="btn btn-alt btn-success sample_file_d_link" style="margin-left:3px;"><span class="icon-download"></span> Download Sample File</a>
							</div>
						</div>
											
					</fieldset>
				</div>
				<!-- /Modal body -->
				
				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="submit" class="btn btn-alt btn-large btn-primary" name="import">IMPORT</button>
					<button type="button" class="btn btn-alt btn-large btn-black" data-dismiss="modal">Close</button>
				</div>
				<!-- /Modal footer -->
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
function ImportModal() {
	jQuery(document).ready(function($) {
		$('#export_modal').modal({backdrop: 'static',keyboard: false});
	});
}

jQuery(document).ready(function($) {
	$('.searchbx').on('click', function(e) {
		var val = document.getElementById("filter_by").value;
		var cat_id = document.getElementById("cat_id").value;
		var brand_id = document.getElementById("brand_id").value;
		var device_id = document.getElementById("device_id").value;
		if(val.trim()=="" && cat_id=="" && brand_id=="" && device_id=="") {
			alert('Please enter Title or Select value from dropdowns');
			return false;
		}
	});
	
	$('.bulk_remove').on('click', function(e) {
		var ids = document.getElementById("ids").value;
		if(ids=="") {
			alert('Please first make a selection from the list.');
			return false;
		} else {
			var Ok = confirm("Are you sure to delete this record(s)?");
			if(Ok == true) {
				return true;
			} else {
				return false;
			}
		}
	});
	
	$('#chk_all').on('click', function(e) {
		if($(this).is(':checked',true)) {
			$(".sub_chk").prop('checked', true);  
			var values = new Array();
			$.each($("input[name='chk[]']:checked"), function() {
				values.push($(this).val());
			});
			$('#ids').val(values);
		} else {  
			$(".sub_chk").prop('checked',false);  
			var values = new Array();
			$.each($("input[name='chk[]']:checked"), function() {
				values.push($(this).val());
			});
			$('#ids').val(values); 
		}  
	});
	
	$('.sub_chk').on('click', function(e) {
		if($(this).is(':checked',true)) {
			var values = new Array();
			$.each($("input[name='chk[]']:checked"), function() {
			   values.push($(this).val());
			});
			$('#ids').val(values);
		} else {  
			var values = new Array();
			$.each($("input[name='chk[]']:checked"), function() {
			   values.push($(this).val());
			});
			$('#ids').val(values);  
		}  
	});
	
	$("#cat_d_type").on('change', function(e) {
		var val = $(this).val();
		
		var sample_file_path;
		if(val == "mobile") {
			sample_file_path = "sample_files/models-mobile-sample-file.csv";
		}
		if(val == "tablet") {
			sample_file_path = "sample_files/models-tablet-sample-file.csv";
		}
		if(val == "watch") {
			sample_file_path = "sample_files/models-watch-sample-file.csv";
		}
		if(val == "laptop") {
			sample_file_path = "sample_files/models-laptop-sample-file.csv";
		}
		if(sample_file_path) {
			$(".sample_file_d_link").show();
			$(".sample_file_d_link").attr("href", sample_file_path);
		} else {
			$(".sample_file_d_link").hide();
			$(".sample_file_d_link").attr("href", "");
		}
	});
	
});

function clickontoggle(id) {
	jQuery(document).ready(function($){
		if($(this).is(':checked',true)) {
			var values = new Array();
			$.each($("input[name='chk[]']:checked"), function() {
			   values.push($(this).val());
			});
			$('#ids').val(values);
		} else {  
			var values = new Array();
			$.each($("input[name='chk[]']:checked"), function() {
			   values.push($(this).val());
			});
			$('#ids').val(values);  
		}
	});
}
</script>