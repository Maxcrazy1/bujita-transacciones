<div id="wrapper">
    <header id="header" class="container">
    	<?php include("include/admin_menu.php"); ?>
    </header>
	
	<section class="container" role="main">
         <div class="row">
            <article class="span12 data-block">
                <header>
                	<h2>Review List</h2>
					<?php
					if($prms_form_add == '1') { ?>
                	<ul class="data-header-actions">
						<li><a href="add_edit_review.php">Add New</a></li>
					</ul>
					<?php
					} ?>
                </header>
                <section>
					<?php include('confirm_message.php');?>
					
					<div class="row-fluid">
						<div class="span5">
							<div class="alert alert-gray fade in">
							   <strong>You can use this shortcode [reviews] in pages for display reviews.</strong>
							</div>
						</div>
					</div>
					
					<?php
					if($prms_form_delete == '1') { ?>
					<div class="row-fluid">
						<div class="span4">
							<form action="controllers/review.php" method="POST" style="margin-bottom:0px;">
								<div class="control-group">
									<div class="controls">
										<input type="hidden" name="ids" id="ids" value="">
										<button class="btn btn-alt btn-danger bulk_remove" name="bulk_remove">Bulk Remove</button>
									</div>	
								</div>
							</form>
						</div>
				
						<div class="span8">
							&nbsp;
						</div>
					</div>
					<?php
					} ?>
					
					<div id="table_pagination_wrapper" class="dataTables_wrapper form-inline" role="grid">
						<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th width="10"><input type="checkbox" id="chk_all"></th>
									<th>Name</th>
									<th>Email</th>
									<?php /*?><th>Country</th><?php */?>
									<th>City</th>
									<th>State</th>
									<th>Zipcode</th>
									<th>Stars</th>
									<?php /*?><th>Title</th><?php */?>
									<?php /*?><th>Content</th><?php */?>
									<th>Date</th>
									<th>Status</th>
									<th width="200">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$num_rows = mysqli_num_rows($query);
								if($num_rows>0) {
									while($review_data=mysqli_fetch_assoc($query)){ ?>
									<tr>
										<td><input type="checkbox" onclick="clickontoggle('<?=$review_data['id']?>');" class="sub_chk" name="chk[]" value="<?=$review_data['id']?>"></td>
										<td><?=$review_data['name']?></td>
										<td><?=$review_data['email']?></td>
										<?php /*?><td><?=$review_data['country']?></td><?php */?>
										<td><?=$review_data['city']?></td>
										<td><?=$review_data['state']?></td>
										<td><?=$review_data['zip_code']?></td>
										<td><?=$review_data['stars']?></td>
										<?php /*?><td><?=$review_data['title']?></td><?php */?>
										<?php /*?><td><?=$review_data['content']?></td><?php */?>
										<td><?=format_date($review_data['date']).' '.format_time($review_data['date'])?></td>
										<td><?=($review_data['status']=='0'?"Inactive":"Active")?></td>
										<td>
											<?php
											if($prms_form_edit == '1') { ?>
											<a href="add_edit_review.php?id=<?=$review_data['id']?>" class="btn btn-alt btn-default"><i class="icon-pencil"></i></a>
											<?php
											}
											if($prms_form_delete == '1') { ?>
											<a href="controllers/review.php?d_id=<?=$review_data['id']?>" class="btn btn-danger btn-alt" onclick="return confirm('Are you sure to delete this record?')"><i class="icon-trash"></i></a>
											<?php
											}
											if($review_data['status']=='0') { ?>
												<a href="controllers/review.php?active_id=<?=$review_data['id']?>" class="btn btn-danger btn-alt">Unpublished</a>
											<?php
											} else { ?>
												<a href="controllers/review.php?inactive_id=<?=$review_data['id']?>" class="btn btn-success btn-alt">Published</a>
											<?php
											} ?>
										</td>
									</tr>
									<?php
									}
								} else { ?>
									<tr><td colspan="12">No Data Found</td></tr>
								<?php
								} ?>
							</tbody>
						</table>
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