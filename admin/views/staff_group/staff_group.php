<div id="wrapper">
    <header id="header" class="container">
    	<?php require_once("include/admin_menu.php"); ?>
    </header>
	
	<section class="container" role="main">
         <div class="row">
            <article class="span12 data-block">
                <header>
					<h2>Staff Groups</h2>
					<ul class="data-header-actions">
						<li><a href="edit_staff_group.php">Add New</a></li>
					</ul>
				</header>
                <section>
                	<?php require_once('confirm_message.php');?>

					<div class="row-fluid">
						<div class="span4">
							<form action="controllers/staff_group.php" method="POST" style="margin-bottom:0px;">
								<div class="control-group">
									<div class="controls">
										<input type="hidden" name="ids" id="ids" value="">
										<button class="btn btn-alt btn-danger bulk_remove" name="bulk_remove">Bulk Remove</button>
									</div>	
								</div>
							</form>
						</div>
				
						<div class="span8">
							<?php //echo $pages->page_limit_dropdown(); ?>
						</div>
					</div>
					
                	<div id="table_pagination_wrapper" class="dataTables_wrapper form-inline" role="grid">
                	<form action="controllers/staff_group.php" method="post">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                            	<th width="10"><input type="checkbox" id="chk_all"></th>
                                <th>Name</th>
                                <th>Permissions</th>
                                <th width="200">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
							$num_rows = mysqli_num_rows($query);
							if($num_rows>0) {
								while($groups_list=mysqli_fetch_assoc($query)) {
								$nn = 0;
								$permissions_array = json_decode($groups_list['permissions'], true);
								$permissions = '';
								if(!empty($permissions_array)) {
									foreach($permissions_array as $permissions_k=>$permissions_v) {
										if($permissions_v == '1') {
											$permissions .= ucwords(str_replace("_"," ",$permissions_k)).", ";
										}
									}
								} ?>
								<tr>
									<td><input type="checkbox" onclick="clickontoggle('<?=$groups_list['id']?>');" class="sub_chk" name="chk[]" value="<?=$groups_list['id']?>" <?php if($groups_list['type']=="fixed"){echo 'disabled="disabled"';}?>></td>
									<td><?=$groups_list['name']?></td>
									<td><?=rtrim($permissions,', ')?></td>
									<td>
										<a href="edit_staff_group.php?id=<?=$groups_list['id']?>" class="btn btn-alt btn-default"><i class="icon-pencil"></i></a>
										<?php
										if($groups_list['type']!="fixed") { ?>
											<a href="controllers/staff_group.php?d_id=<?=$groups_list['id']?>" class="btn btn-danger btn-alt" onclick="return confirm('are you sure to delete this record?')"><i class="icon-trash"></i></a> 
										<?php
										}
										if($groups_list['status']==1) {
											echo '<a href="controllers/staff_group.php?p_id='.$groups_list['id'].'&status=0"><button class="btn btn-alt btn-success" style="pointer-events: none;">Published</button></a>';
										} elseif($groups_list['status']==0) {
											echo '<a href="controllers/staff_group.php?p_id='.$groups_list['id'].'&status=1"><button class="btn btn-alt btn-danger" style="pointer-events: none;">Unpublished</button></a>';
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
		if(val=="") {
			alert('Please enter Name, Email or Phone');
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