<div id="wrapper">
    <header id="header" class="container">
    	<?php include("include/admin_menu.php"); ?>
    </header>
	
	<section class="container" role="main">
         <div class="row">
            <article class="span12 data-block">
                <header><h2>Bulk Order List</h2></header>
                <section>
					<?php include('confirm_message.php');?>

					<?php
					if($prms_form_delete == '1') { ?>
					<div class="row-fluid">
						<div class="span4">
							<form action="controllers/bulk_order.php" method="POST" style="margin-bottom:0px;">
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
									<th>Phone</th><?php /*?>
									<th>State</th>
									<th>City</th>
									<th>Zip Code</th><?php */?>
									<?php /*?><th>Product Details</th><?php */?>
									<th>Company Name</th>
									<th>Content</th>
									<th>Date</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$num_rows = mysqli_num_rows($query);
								if($num_rows>0) {
									while($review_data=mysqli_fetch_assoc($query)) {
									
									/*$product_details_list = json_decode($review_data['devices'],true);
									$imp_devices = '';
									if(!empty($product_details_list) && $review_data['devices']!="") {
										foreach($product_details_list as $product_details_data) {
											$imp_devices .= $product_details_data['model_name'].', '.$product_details_data['quality'].', '.$product_details_data['manufacturer'].' : ';
										}
										$imp_devices = rtrim($imp_devices,' : ');
									}*/ ?>
									<tr>
										<td><input type="checkbox" onclick="clickontoggle('<?=$review_data['id']?>');" class="sub_chk" name="chk[]" value="<?=$review_data['id']?>"></td>
										<td><?=$review_data['name']?></td>
										<td><?=$review_data['email']?></td>
										<td><?=$review_data['phone']?></td><?php /*?>
										<td><?=$review_data['state']?></td>
										<td><?=$review_data['city']?></td>
										<td><?=$review_data['zip_code']?></td><?php */?>
										<?php /*?><td><?=$imp_devices?></td><?php */?>
										<td><?=$review_data['company_name']?></td>
										<td><?=$review_data['content']?></td>
										<td><?=format_date($review_data['date']).' '.format_time($review_data['date'])?></td>
										<td>
											<?php
											if($prms_form_delete == '1') { ?>
											<a href="controllers/bulk_order.php?d_id=<?=$review_data['id']?>" class="btn btn-danger btn-alt" onclick="return confirm('Are you sure to delete this record?')"><i class="icon-trash"></i></a>
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