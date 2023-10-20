<div id="wrapper">
    <header id="header" class="container">
    	<?php include("include/admin_menu.php"); ?>
    </header>
	
	<section class="container" role="main">
         <div class="row">
            <article class="span12 data-block">
                <header><h2>Email/SMS History</h2></header>
                <section>
					<?php include('confirm_message.php');?>
					
					<form method="post">
						<div class="control-group">
							<div class="controls">
								<input type="text" class="span3" placeholder="Search By Order ID, To Email, SMS Phone" name="filter_by" id="filter_by" value="<?=$post['filter_by']?>">
								<select name="order_id" id="order_id" class="span2">
									<option value=""> - Order ID - </option>
									<?php
									while($order_data = mysqli_fetch_assoc($order_query)) { ?>
										<option value="<?=$order_data['order_id']?>" <?php if($post['order_id']==$order_data['order_id']){echo 'selected="selected"';}?>><?=$order_data['order_id']?></option>
									<?php
									} ?>
								</select>
								<button class="btn btn-alt btn-primary searchbx" type="submit" name="search">Search</button>
								<?php
								if($post['filter_by']!="" || $post['order_id']!="") {
									echo '<a href="emailsms_history.php"><button class="btn btn-alt btn-primary" type="button">Clear</button></a>';
								} ?>
							</div>
						</div>
					</form>

					<div class="row-fluid">
						<div class="span4">
							<form action="controllers/emailsms_history.php" method="POST" style="margin-bottom:0px;">
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

					<div id="table_pagination_wrapper" class="dataTables_wrapper form-inline" role="grid">
						<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th width="10"><input type="checkbox" id="chk_all"></th>
									<th>Order ID</th>
									<th>From Email</th>
									<th>To Email</th>
									<th>Subject</th>
									<th>SMS Phone</th>
									<th>IP</th>
									<th>LeadSource</th>
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
										<td><?=($contact_data['order_id']?'<a href="edit_order.php?order_id='.strtoupper($contact_data['order_id']).'">'.$contact_data['order_id'].'</a>':'No Data')?></td>
										<td><?=$contact_data['from_email']?></td>
										<td><?=$contact_data['to_email']?></td>
										<td><?=$contact_data['subject']?></td>
										<td><?=$contact_data['sms_phone']?></td>
										<td><?=$contact_data['visitor_ip']?></td>
										<td><?=ucwords(str_replace("_"," ",$contact_data['form_type']))?></td>
										<td><?=format_date($contact_data['date']).' '.format_time($contact_data['date'])?></td>
										<td>
											<a href="view_emailsms_history.php?id=<?=$contact_data['id']?>" class="btn btn-success btn-alt"><i class="icon-eye-open"></i></a>
											<a href="controllers/emailsms_history.php?d_id=<?=$contact_data['id']?>" class="btn btn-danger btn-alt mt-5" onclick="return confirm('Are you sure to delete this record?')"><i class="icon-trash"></i></a>
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
		var order_id = document.getElementById("order_id").value;
		if(val=="" && order_id=="") {
			alert('Please enter/choose Order ID, To Email or SMS Phone');
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