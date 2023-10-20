<div id="wrapper">
    <header id="header" class="container">
    	<?php include("include/admin_menu.php"); ?>
    </header>

	<section class="container" role="main">
         <div class="row">
            <article class="span12 data-block">
                <header><h2>Unpaid Orders</h2></header>
                <section>
					<?php include('confirm_message.php'); ?>

					<form method="post">
						<div class="control-group">
							<div class="controls">
								<input type="text" class="span3" placeholder="Search By Order ID, User Name" name="filter_by" id="filter_by" value="<?=$post['filter_by']?>">
								<input type="text" class="span2 datepicker" placeholder="From Date" name="from_date" id="from_date" value="<?=$post['from_date']?>">
								<input type="text" class="span2 datepicker" placeholder="To Date" name="to_date" id="to_date" value="<?=$post['to_date']?>">
								<select name="status" id="status" class="span2">
									<option value=""> - Status - </option>
									<?php /*?><option value="unconfirmed" <?php if($post['status']=='unconfirmed'){echo 'selected="selected"';}?>>Unconfirmed</option><?php */?>
									<?php
									ksort($order_status_list);
									foreach($order_status_list as $order_status_k=>$order_status_v) { ?>
										<option value="<?=$order_status_k?>" <?php if($post['status']==$order_status_k){echo 'selected="selected"';}?>><?=$order_status_v?></option>
									<?php
									} ?>
									
									<?php /*?><option value="submitted" <?php if($post['status']=='submitted'){echo 'selected="selected"';}?>>Submitted</option>
									<option value="expiring" <?php if($post['status']=='expiring'){echo 'selected="selected"';}?>>Expiring</option>
									<option value="received" <?php if($post['status']=='received'){echo 'selected="selected"';}?>>Received</option>
									<option value="problem" <?php if($post['status']=='problem'){echo 'selected="selected"';}?>>Problem</option>
									<option value="completed" <?php if($post['status']=='completed'){echo 'selected="selected"';}?>>Completed</option>
									<option value="returned" <?php if($post['status']=='returned'){echo 'selected="selected"';}?>>Returned</option>
									<option value="awaiting_delivery" <?php if($post['status']=='awaiting_delivery'){echo 'selected="selected"';}?>>Awaiting Delivery</option>
									<option value="expired" <?php if($post['status']=='expired'){echo 'selected="selected"';}?>>Expired</option>
									<option value="processed" <?php if($post['status']=='processed'){echo 'selected="selected"';}?>>Processed</option>
									<option value="rejected" <?php if($post['status']=='rejected'){echo 'selected="selected"';}?>>Rejected</option><?php */?>
									<?php /*?><option value="posted" <?php if($post['status']=='posted'){echo 'selected="selected"';}?>>Posted</option><?php */?>
								</select>
								
								<select name="payment_method" id="payment_method" class="span2">
									<option value=""> - Payment Method - </option>
									<?php
									ksort($payment_method_list);
									foreach($payment_method_list as $payment_method_k=>$payment_method_v) { ?>
										<option value="<?=$payment_method_k?>" <?php if($post['payment_method']==$payment_method_k){echo 'selected="selected"';}?>><?=$payment_method_v?></option>
									<?php
									} ?>
								</select>

								<?php /*?><select name="is_payment_sent" id="is_payment_sent" class="span2">
									<option value=""> - Payment Status - </option>
									<option value="1" <?php if($post['is_payment_sent']=='1'){echo 'selected="selected"';}?>>Paid</option>
									<option value="0" <?php if($post['is_payment_sent']=='0'){echo 'selected="selected"';}?>>Unpaid</option>
								</select><?php */?>

								<button class="btn btn-alt btn-primary searchbx" type="submit" name="search">Search</button>
								<?php /*?><button class="btn btn-alt btn-primary" type="submit" name="export">Export</button>
								<button class="btn btn-alt btn-primary print" type="button" name="print">Print</button><?php */?>
								<?php
								if($post['filter_by']!="" || $post['filter_by_location']!="" || $post['status']!="" || $post['contractor_type']!="" || $post['from_date']!="" || $post['to_date']!="" || $post['is_payment_sent']!="" || $post['payment_method']!="") {
									echo '<a href="orders.php"><button class="btn btn-alt btn-primary" type="button">Clear</button></a>';
								} ?>
							</div>
						</div>
					</form>

				    <div class="row-fluid">
						<div class="span6">
							<?php
							if($prms_order_delete == '1') { ?>
							<form action="controllers/order/order.php" method="POST" style="margin-bottom:0px;">
								<div class="control-group">
									<div class="controls">
										<input type="hidden" name="ids" id="ids" class="ids" value="">
										<input type="hidden" name="order_mode" id="order_mode" value="unpaid">
										<button class="btn btn-alt btn-danger bulk_archive" name="bulk_archive">Bulk Achive</button>
										<button class="btn btn-alt btn-success bulk_set_paid" name="bulk_set_paid">Bulk Paid</button>
									</div>	
								</div>
							</form>
							<?php
							} ?>
						</div>
						<div class="span6">
							<form method="get" action="download_order_export.php" class="filter_form" style="margin-bottom:0px;text-align:right;">
								<div class="control-group">
									<div class="controls">
										<input type="hidden" name="filter_by" id="filter_by" value="<?=$post['filter_by']?>">
										<input type="hidden" name="from_date" id="from_date" value="<?=$post['from_date']?>">
										<input type="hidden" name="to_date" id="to_date" value="<?=$post['to_date']?>">
										<input type="hidden" name="status" id="status" value="<?=$post['status']?>">
										<input type="hidden" name="is_payment_sent" id="is_payment_sent" value="<?=$post['is_payment_sent']?>">
										<?php /*?><input type="hidden" name="export" id="export" value="yes"><?php */?>
										<input type="hidden" name="ids" id="ids" class="ids" value="">
										<input type="hidden" name="order_mode" id="order_mode" value="unpaid">
										<button class="btn btn-alt btn-info" type="submit" name="export">Export (PDF)</button>
										<button class="btn btn-alt btn-info" type="submit" name="export_csv">Export (CSV)</button>
										<button class="btn btn-alt btn-info print" type="button" name="print">Print</button>
									</div>
								</div>
							</form>
						</div>
				    </div>

					<div id="table_pagination_wrapper" class="dataTables_wrapper form-inline" role="grid">
						<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th width="10"><input type="checkbox" id="chk_all"></th>
									<th>Order ID</th>
									<th>Customer</th>
									<th>Date</th>
									<th>Approved Date</th>
									<th>Price</th>
									<th>Payment Method</th>
									<?php /*?><th>Payment Status</th><?php */?>
									<th>Status</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$num_rows = mysqli_num_rows($order_query);
								if($num_rows>0) {
									while($order_data=mysqli_fetch_assoc($order_query)) { 
										$promocode_amt = 0;				
										$total_of_order = 0;
										
										//Get order price based on orderID, path of this function (get_order_price) admin/include/functions.php
										$sum_of_orders=get_order_price($order_data['order_id']);
										
										if($order_data['promocode_id']>0 && $order_data['promocode_amt']>0) {
											$promocode_amt = $order_data['promocode_amt'];
											$total_of_order = $sum_of_orders+$order_data['promocode_amt'];
										} else {
											$total_of_order = $sum_of_orders;
										} ?>
										<tr>
											<td><input type="checkbox" onclick="clickontoggle('<?=$order_data['order_id']?>');" class="sub_chk" name="chk[]" value="<?=$order_data['order_id']?>"></td>
											<td><a href="edit_order.php?order_id=<?=$order_data['order_id']?>"><?=$order_data['order_id']?></a></td>
											<td><a href="edit_user.php?id=<?=$order_data['user_id']?>"><?=$order_data['name']?></a></td>
											<td><?=format_date($order_data['date']).' '.format_time($order_data['date'])?></td>
											<td><?=($order_data['approved_date']!='0000-00-00 00:00:00'?format_date($order_data['approved_date']):'')?></td>
											<td><?=amount_fomat($total_of_order)?></td>
											<td><?=ucfirst($order_data['payment_method'])?></td>
											<?php /*?><td>
											<?php
											if($order_data['is_payment_sent'] == '1') {
												echo 'Paid';
											} else {
												echo 'Unpaid';
											} ?>
											</td><?php */?>
											<td><?=ucwords(str_replace('_',' ',$order_data['status']))?></td>
											<td>
												<?php /*?><a href="order_offer.php?order_id=<?=$order_data['order_id']?>&order_mode=unpaid" class="btn btn-alt btn-default">Offer</a>
<?php */?>												<?php
												if($prms_order_edit == '1') { ?>
												<a href="edit_order.php?order_id=<?=$order_data['order_id']?>&order_mode=unpaid" class="btn btn-alt btn-default"><i class="icon-pencil"></i></a>
												<?php
												}
												if($prms_order_delete == '1') { ?>
												<a href="controllers/order/order.php?a_id=<?=$order_data['order_id']?>&order_mode=unpaid" class="btn btn-danger btn-alt" onclick="return confirm('Are you sure you want to archive this record?');"><i class="icon-trash"></i></a>
												<?php
												} ?>
											</td>
										</tr>
									<?php
									}
								} else {
									echo '<tr><td colspan="10">No Data Found</td></tr>';
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
	$('.print').on('click', function(e) {
		var post_data = $('.filter_form').serialize();
		//console.log(post_data);
		open_window('<?=ADMIN_URL?>print_order_list.php?print=yes'+post_data);
		return false;
	});
	
	$('.searchbx').on('click', function(e) {
		var val = document.getElementById("filter_by").value;
		var from_date = document.getElementById("from_date").value;
		var to_date = document.getElementById("to_date").value;
		var status = document.getElementById("status").value;
		var is_payment_sent = document.getElementById("is_payment_sent").value;
		var payment_method = document.getElementById("payment_method").value;
		if(val=="" && from_date=="" && to_date=="" && status=="" && is_payment_sent=="" && payment_method=="") {
			return false;
		}
	});
	
	$('.bulk_archive').on('click', function(e) {
		var ids = document.getElementById("ids").value;
		if(ids=="") {
			alert('Please first make a selection from the list.');
			return false;
		} else {
			var Ok = confirm("Are you sure you want to archive this record(s)?");
			if(Ok == true) {
				return true;
			} else {
				return false;
			}
		}
	});
	
	$('.bulk_set_paid').on('click', function(e) {
		var ids = document.getElementById("ids").value;
		if(ids=="") {
			alert('Please first make a selection from the list.');
			return false;
		} else {
			var Ok = confirm("Are you sure you want to paid this record(s)?");
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
			$('.ids').val(values);
		} else {  
			$(".sub_chk").prop('checked',false);  
			var values = new Array();
			$.each($("input[name='chk[]']:checked"), function() {
				values.push($(this).val());
			});
			$('.ids').val(values); 
		}  
	});
	
	$('.sub_chk').on('click', function(e) {
		if($(this).is(':checked',true)) {
			var values = new Array();
			$.each($("input[name='chk[]']:checked"), function() {
			   values.push($(this).val());
			});
			$('.ids').val(values);
		} else {  
			var values = new Array();
			$.each($("input[name='chk[]']:checked"), function() {
			   values.push($(this).val());
			});
			$('.ids').val(values);  
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
			$('.ids').val(values);
		} else {  
			var values = new Array();
			$.each($("input[name='chk[]']:checked"), function() {
			   values.push($(this).val());
			});
			$('.ids').val(values);
		}
	});
}

function open_window(url) {
	window.open(url,"Loading",'toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=960,height=960');
}
</script>