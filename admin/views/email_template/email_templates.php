<script type="text/javascript">
function check_form(a){
	if(a.filter_by.value.trim()==""){
		alert('Please select type');
		a.filter_by.focus();
		return false;
	}
}
</script>

<div id="wrapper">
    <header id="header" class="container">
    	<?php include("include/admin_menu.php"); ?>
    </header>
	
	<section class="container" role="main">
         <div class="row">
            <article class="span12 data-block">
                <header>
					<h2>Email Templates</h2>
					<?php
					if($prms_emailtmpl_add == '1') { ?>
					<ul class="data-header-actions">
						<li><a href="edit_email_template.php">Add New</a></li>
					</ul>
					<?php
					} ?>
				</header>
                <section>
					<?php include('confirm_message.php');?>
					<form method="post" onSubmit="return check_form(this);">
					<div class="control-group">
						<div class="controls">
							<select name="filter_by" id="filter_by">
								<option value="">Select Type</option>
									<option value="to_admin" <?php if($post['filter_by']=="to_admin"){echo 'selected="selected"';}?>>To Admin</option>
									<option value="to_customer" <?php if($post['filter_by']=="to_customer"){echo 'selected="selected"';}?>>To Customer</option>
									<?php /*?><option value="order_problem_status" <?php if($post['filter_by']=="order_problem_status"){echo 'selected="selected"';}?>>Order Problem Status</option><?php */?>
									<?php
									ksort($order_status_list);
									foreach($order_status_list as $order_status_k=>$order_status_v) {
										$template_type_val = "order_".$order_status_k."_status";
										$template_type_label = "Order ".$order_status_v." Status"; ?>
										<option value="<?=$template_type_val?>" <?php if($template_type_val == $post['filter_by']){echo 'selected="selected"';}?>><?=$template_type_label?></option>
									<?php
									} ?>
							</select>
							<button class="btn btn-alt btn-primary" type="submit" name="search">Go</button>
							<?php
							if($post['filter_by']) {
								echo '<a href="email_templates.php"><button class="btn btn-alt btn-primary" type="button">Clear</button></a>';
							} ?>
						</div>
					</div>
					</form>
					
                    <table class="datatable table table-striped table-bordered table-hover" id="table_pagination">
                        <thead>
                            <tr>
							  <th>No.</th>
							  <th>Type</th>
							  <th>Subject</th>
							  <th>Actions</th>
							</tr>
                        </thead>
                        <tbody>
						<?php
						if($num_of_rows>0) {
							$n = 0;
							while($mail_template_data=mysqli_fetch_array($result)) {
								if($post['filter_by'] == "to_admin") {
									if(in_array($mail_template_data['type'],$to_admin_tmpl_array)) { ?>
										<tr>
											<td><?=$n=$n+1?></td>
											<td><?=$template_type_array[$mail_template_data['type']]?></td>
											<td><?=ucfirst($mail_template_data['subject'])?></td>
											<td>
											<?php
											if($prms_emailtmpl_edit == '1') { ?>
												<a href="edit_email_template.php?id=<?=$mail_template_data['id']?>" class="btn btn-alt btn-default"><i class="icon-pencil"></i></a>
											<?php
											}
											if($mail_template_data['status']==1) {
												echo '<a href="controllers/email_template.php?p_id='.$mail_template_data['id'].'&status=0"><button class="btn btn-alt btn-success" style="pointer-events:none;">Active</button></a>';
											} elseif($mail_template_data['status']==0) {
												echo '<a href="controllers/email_template.php?p_id='.$mail_template_data['id'].'&status=1"><button class="btn btn-alt btn-danger" style="pointer-events:none;">Inactive</button></a>';
											} ?></td>
										</tr>
									<?php 
									}
								} elseif($post['filter_by'] == "to_customer") { 	
									if(in_array($mail_template_data['type'],$to_customer_tmpl_array)) { ?>
										<tr>
											<td><?=$n=$n+1?></td>
											<td><?=$template_type_array[$mail_template_data['type']]?></td>
											<td><?=ucfirst($mail_template_data['subject'])?></td>
											<td>
											<?php
											if($prms_emailtmpl_edit == '1') { ?>
												<a href="edit_email_template.php?id=<?=$mail_template_data['id']?>" class="btn btn-alt btn-default"><i class="icon-pencil"></i></a>
											<?php
											}
											if($mail_template_data['status']==1) {
												echo '<a href="controllers/email_template.php?p_id='.$mail_template_data['id'].'&status=0"><button class="btn btn-alt btn-success" style="pointer-events:none;">Active</button></a>';
											} elseif($mail_template_data['status']==0) {
												echo '<a href="controllers/email_template.php?p_id='.$mail_template_data['id'].'&status=1"><button class="btn btn-alt btn-danger" style="pointer-events:none;">Inactive</button></a>';
											} ?>
											</td>
										</tr>	
									<?php 
									}
								} else { ?>
									<tr>
									  <td><?=$n=$n+1?></td>
									  <td>
									  <?php
									  if($mail_template_data['is_fixed'] == '0') {
									  	 echo ucwords(str_replace("_"," ",$mail_template_data['type']));
									  } else {
									  	 echo $template_type_array[$mail_template_data['type']];
									  } ?></td>
									  <td><?=ucfirst($mail_template_data['subject'])?></td>
									  <td>
									  <?php
									  if($prms_emailtmpl_edit == '1') { ?>
									 	 <a href="edit_email_template.php?id=<?=$mail_template_data['id']?>" class="btn btn-alt btn-default"><i class="icon-pencil"></i></a>
									  <?php
									  }
									  if($prms_emailtmpl_delete == '1') {
										  if($mail_template_data['is_fixed'] == '0') { ?>
											 <a href="controllers/email_template.php?d_id=<?=$mail_template_data['id']?>" class="btn btn-alt btn-danger" onclick="return confirm('Are you sure you want to delete this record?')"><i class="icon-trash"></i></a>
										  <?php
										  }
									  }
									    if($mail_template_data['status']==1) {
											echo '<a href="controllers/email_template.php?p_id='.$mail_template_data['id'].'&status=0"><button class="btn btn-alt btn-success" style="pointer-events:none;">Active</button></a>';
										} elseif($mail_template_data['status']==0) {
											echo '<a href="controllers/email_template.php?p_id='.$mail_template_data['id'].'&status=1"><button class="btn btn-alt btn-danger" style="pointer-events:none;">Inactive</button></a>';
										} ?>
									  </td>
									</tr>
								<?php
								}
							}
						} ?>
						</tbody>
                    </table>
                </section>
        	</article>
        </div>
    </section>
	<div id="push"></div>
</div>