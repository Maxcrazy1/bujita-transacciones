<div id="wrapper">
    <header id="header" class="container">
    	<?php include("include/admin_menu.php"); ?>
    </header>
	
	<section class="container" role="main">
         <div class="row">
            <article class="span12 data-block">
                <header><h2>Affiliate List</h2></header>
                <section>
					<?php include('confirm_message.php');?>
					
					<?php
					if($prms_form_delete == '1') { ?>
					<div class="row-fluid">
						<div class="span4">
							<form action="controllers/affiliate.php" method="POST" style="margin-bottom:0px;">
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
									<th>Company</th>
									<th>Web Address</th>
									<th>Phone</th>
									<th>Email</th>
									<th>Subject</th>
									<th>Message</th>
									<th>Date/Time</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$num_rows = mysqli_num_rows($query);
								if($num_rows>0) {
									while($affiliate_data=mysqli_fetch_assoc($query)){ ?>
									<tr>
										<td><input type="checkbox" onclick="clickontoggle('<?=$affiliate_data['id']?>');" class="sub_chk" name="chk[]" value="<?=$affiliate_data['id']?>"></td>
										<td><?=$affiliate_data['name']?></td>
										<td><?=$affiliate_data['company']?></td>
										<td><?=$affiliate_data['web_address']?></td>
										<td><?=$affiliate_data['phone']?></td>
										<td><?=$affiliate_data['email']?></td>
										<td><?=$affiliate_data['subject']?></td>
										<td><?=$affiliate_data['message']?></td>
										<td><?=format_date($affiliate_data['date']).' '.format_time($affiliate_data['date'])?></td>
										<td>
											<?php
											if($prms_form_delete == '1') { ?>
											<a href="controllers/affiliate.php?d_id=<?=$affiliate_data['id']?>" class="btn btn-danger btn-alt" onclick="return confirm('Are you sure to delete this record?')"> <i class="icon-trash"></i></a>
											<?php
											} ?>
										</td>
									</tr>
									<?php
									}
								} else { ?>
									<tr><td colspan="10">No Data Found</td></tr>
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