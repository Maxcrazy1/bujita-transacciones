<div id="wrapper">
    <header id="header" class="container">
    	<?php include("include/admin_menu.php"); ?>
    </header>
	
	<section class="container" role="main">
         <div class="row">
            <article class="span12 data-block">
                <header>
					<h2>Devices</h2>
					<?php
					if($prms_device_add == '1') { ?>
					<ul class="data-header-actions">
						<li><a href="edit_device.php">Add New</a></li>
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
								
								<?php /*?><select name="brand_id" id="brand_id" class="span3" style="width:190px;">
									<option value=""> - Select Brand - </option>
									<?php
									while($brands_list=mysqli_fetch_assoc($brands_data)) { ?>
										<option value="<?=$brands_list['id']?>" <?php if($brands_list['id']==$post['brand_id']){echo 'selected="selected"';}?>><?=$brands_list['title']?></option>
									<?php
									} ?>
								</select><?php */?>

								<button class="btn btn-alt btn-primary searchbx" type="submit" name="search">Search</button>
								<?php
								if($post['filter_by'] || $post['brand_id']) {
									echo '<a href="device.php"><button class="btn btn-alt btn-primary" type="button">Clear</button></a>';
								} ?>
							</div>
						</div>
					</form>
					
					<div class="row-fluid">
						<div class="span4">
							<?php
							if($prms_device_delete == '1') { ?>
							<form action="controllers/device.php" method="POST" style="margin-bottom:0px;">
								<div class="control-group">
									<div class="controls">
										<input type="hidden" name="ids" class="ids" id="ids" value="">
										<button class="btn btn-alt btn-danger bulk_remove" name="bulk_remove">Bulk Remove</button>
									</div>	
								</div>
							</form>
							<?php
							} ?>
						</div>
				
						<div class="span8">
							<?php //echo $pages->page_limit_dropdown(); ?>
						</div>
					</div>
					
                	<div id="table_pagination_wrapper" class="dataTables_wrapper form-inline" role="grid">
                	<form action="controllers/device.php" method="post">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                            	<th width="10"><input type="checkbox" id="chk_all"></th>
                                <th width="150">Icon</th>
                                <th>Title</th>
								<?php /*?><th>Brand</th><?php */?>
                                <th width="50">Order <input type="submit" name="sbt_order" value="Save" class="btn btn-alt"></th>
                                <th width="200">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
							$num_rows = mysqli_num_rows($query);
							if($num_rows>0) {
								while($device_data=mysqli_fetch_assoc($query)) { ?>
								<tr>
									<td><input type="checkbox" onclick="clickontoggle('<?=$device_data['id']?>');" class="sub_chk" name="chk[]" value="<?=$device_data['id']?>"></td>
									<td>
									<?php
									if($device_data['device_img'])
										echo '<img src="../images/device/'.$device_data['device_img'].'" width="100" height="100" />';
									?>
									</td>
									<td><?=$device_data['title']?></td>
									<?php /*?><td><?=$device_data['brand_title']?></td><?php */?>
									<td>
										<input type="text" class="input-small" id="ordering<?=$device_data['id']?>" value="<?=$device_data['ordering']?>" name="ordering[<?=$device_data['id']?>]">
									</td>
									<td>
										<?php
										if($prms_device_edit == '1') { ?>
										<a href="edit_device.php?id=<?=$device_data['id']?>" class="btn btn-alt btn-default"><i class="icon-pencil"></i></a>
										<?php
										}
										if($prms_device_delete == '1') { ?>
										<a href="controllers/device.php?d_id=<?=$device_data['id']?>" class="btn btn-danger btn-alt" onclick="return confirm('Are you sure to delete this record?')"> <i class="icon-trash"></i></a> 
										<?php
										}
										if($device_data['published']==1) {
											echo '<a href="controllers/device.php?p_id='.$device_data['id'].'&published=0"><button class="btn btn-alt btn-success" style="pointer-events: none;">Published</button></a>';
										} elseif($device_data['published']==0) {
											echo '<a href="controllers/device.php?p_id='.$device_data['id'].'&published=1"><button class="btn btn-alt btn-danger" style="pointer-events: none;">Unpublished</button></a>';
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
					</div>
                </section>
        	</article>
        </div>
    </section>
	<div id="push"></div>
</div>

<script type="text/javascript">
jQuery(document).ready(function($) {
	$('.searchbx').on('click', function(e) {
		var val = document.getElementById("filter_by").value;
		var brand_id = document.getElementById("brand_id").value;
		if(val.trim()=="" && brand_id=="") {
			alert('Please enter Title or Select value of brands');
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
