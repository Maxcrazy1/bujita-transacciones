<div id="wrapper">
    <header id="header" class="container">
    	<?php include("include/admin_menu.php"); ?>
    </header>
	
	<section class="container" role="main">
         <div class="row">
            <article class="span12 data-block">
                <header><h2>Contact List</h2></header>
                <section>
					<?php include('confirm_message.php');?>

					<?php
					if($prms_form_delete == '1') { ?>
					<div class="row-fluid">
						<div class="span4">
							<form action="controllers/contact.php" method="POST" style="margin-bottom:0px;">
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
									<!--<th>Phone</th>-->
									<th>Email</th>
									<!--<th>Order No</th>
									<th>Item Name</th>-->
									<th>Subject</th>
									<th>Message</th>
									<th>Form Type</th>
									<th>Date</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$num_rows = mysqli_num_rows($query);
								if($num_rows>0) {
									while($contact_data=mysqli_fetch_assoc($query)){ ?>
									<tr>
										<td><input type="checkbox" onclick="clickontoggle('<?=$contact_data['id']?>');" class="sub_chk" name="chk[]" value="<?=$contact_data['id']?>"></td>
										<td><?=$contact_data['name']?></td>
										<?php /*?><td><?=$contact_data['phone']?></td><?php */?>
										<td><?=$contact_data['email']?></td>
										<?php /*?><td><?=($contact_data['order_id']?'<a href="edit_order.php?order_id='.strtoupper($contact_data['order_id']).'">'.$contact_data['order_id'].'</a>':'No Data')?></td>
										<td><?=$contact_data['item_name']?></td><?php */?>
										<td><?=$contact_data['subject']?></td>
										<td><?=$contact_data['message']?></td>
										<td><?=ucfirst($contact_data['type'])?></td>
										<td><?=format_date($contact_data['date']).' '.format_time($contact_data['date'])?></td>
										<td>
											<?php
											if($prms_form_delete == '1') { ?>
											<a href="controllers/contact.php?d_id=<?=$contact_data['id']?>" class="btn btn-danger btn-alt" onclick="return confirm('Are you sure to delete this record?')"><i class="icon-trash"></i></a>
											<?php
											} ?>
										</td>
									</tr>
									<?php
									}
								} else { ?>
									<tr><td colspan="11">No Data Found</td></tr>
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