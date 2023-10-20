<div id="wrapper">
    <header id="header" class="container">
    	<?php include("include/admin_menu.php"); ?>
    </header>
	
	<section class="container" role="main">
         <div class="row">
            <article class="span12 data-block">
                <header><h2>Customer(s) List</h2></header>
                <section>
					<?php include('confirm_message.php');?>
					
					<form method="post">
						<div class="control-group">
							<div class="controls">
								<input type="text" class="span3" placeholder="Search By Name, Email, Phone" name="filter_by" id="filter_by" value="<?=$post['filter_by']?>">
								<button class="btn btn-alt btn-primary searchbx" type="submit" name="search">Go</button>
								<?php
								if($post['filter_by'])
									echo '<a href="users.php"><button class="btn btn-alt btn-primary" type="button">Clear</button></a>'; ?>
							</div>
						</div>
					</form>
					
					<?php
					if($prms_customer_delete == '1') { ?>
					<div class="row-fluid">
						<div class="span4">
							<?php
							if($prms_brand_delete == '1') { ?>
							<form action="controllers/user.php" method="POST" style="margin-bottom:0px;">
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
					<?php
					} ?>
					
					<div id="table_pagination_wrapper" class="dataTables_wrapper form-inline" role="grid">
						<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th width="10"><input type="checkbox" id="chk_all"></th>
									<th>Name</th>
									<th>Email</th>
									<th>Phone</th>
									<th>Total Trade-in</th>
									<th>User Type</th>
									<th>Date</th>
									<th width="160">Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$num_rows = mysqli_num_rows($user_query);
								if($num_rows>0) {
									while($customer_data=mysqli_fetch_assoc($user_query)) {
									$up_o_query=mysqli_query($db,"SELECT COUNT(*) AS num_of_orders FROM orders AS o WHERE o.status!='partial' AND user_id='".$customer_data['id']."' AND o.is_payment_sent='0' AND o.is_trash='0'");
									$unpaid_order_data = mysqli_fetch_assoc($up_o_query);
									
									$p_o_query=mysqli_query($db,"SELECT COUNT(*) AS num_of_orders FROM orders AS o WHERE o.status!='partial' AND user_id='".$customer_data['id']."' AND o.is_payment_sent='1' AND o.is_trash='0'");
									$paid_order_data = mysqli_fetch_assoc($p_o_query);
									
									$acv_o_query=mysqli_query($db,"SELECT COUNT(*) AS num_of_orders FROM orders AS o WHERE o.status!='partial' AND user_id='".$customer_data['id']."' AND o.is_trash='1'");
									$archive_order_data = mysqli_fetch_assoc($acv_o_query);
									?>
									<tr>
										<td><input type="checkbox" onclick="clickontoggle('<?=$customer_data['id']?>');" class="sub_chk" name="chk[]" value="<?=$customer_data['id']?>"></td>
										<td><?=$customer_data['name']?></td>
										<td><?=$customer_data['email']?></td>
										<td><?=$customer_data['phone']?></td>
										<td>
										<?=rtrim(($unpaid_order_data['num_of_orders']>0?'<a href="orders.php?user_id='.$customer_data['id'].'">Unpaid('.$unpaid_order_data['num_of_orders'].')</a>,&nbsp;&nbsp;':'').($paid_order_data['num_of_orders']>0?'<a href="paid_orders.php?user_id='.$customer_data['id'].'">Paid('.$paid_order_data['num_of_orders'].')</a>,&nbsp;&nbsp;':'').($archive_order_data['num_of_orders']>0?'<a href="archive_orders.php?user_id='.$customer_data['id'].'">Archive('.$archive_order_data['num_of_orders'].')</a>':''),',&nbsp;&nbsp;')?>
										</td>
										<td><?=($customer_data['user_type']=="guest"?"Guest":"Member")?></td>
										<td><?=format_date($customer_data['date'])?></td>
										<td>
											<?php
											if($prms_customer_edit == '1') { ?>
											<a href="edit_user.php?id=<?=$customer_data['id']?>" class="btn btn-alt btn-default"><i class="icon-pencil"></i></a>
											<?php
											}
											if($prms_customer_delete == '1') { ?>
											<a href="controllers/user.php?d_id=<?=$customer_data['id']?>" class="btn btn-danger btn-alt" onclick="return confirm('Are you sure to delete this record?')"><i class="icon-trash"></i></a>
											<?php
											}
											if($customer_data['status']==1) {
												echo '<a href="controllers/user.php?p_id='.$customer_data['id'].'&status=0"><button class="btn btn-alt btn-success" style="pointer-events: none;">Active</button></a>';
											} elseif($customer_data['status']==0) {
												echo '<a href="controllers/user.php?p_id='.$customer_data['id'].'&status=1"><button class="btn btn-alt btn-danger" style="pointer-events: none;">Inactive</button></a>';
											} ?>
										</td>
									</tr>
									<?php
									}
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
function check_form(a){
	if(a.filter_by.value.trim()==""){
		alert('Please enter Name, Email or Phone');
		a.filter_by.focus();
		return false;
	}
}

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