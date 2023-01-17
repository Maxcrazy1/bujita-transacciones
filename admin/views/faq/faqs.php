<div id="wrapper">
    <header id="header" class="container">
    	<?php require_once("include/admin_menu.php"); ?>
    </header>
	
	<section class="container" role="main">
         <div class="row">
            <article class="span12 data-block">
                <header>
					<h2>Faqs <?php /*?><a class="text-info" href="javascript:void(0);" onClick="showFaqInfo();return false;"><span class="elusive icon-info-sign"></span></a><?php */?></h2>
					<?php
					if($prms_faq_add == '1') { ?>
					<ul class="data-header-actions">
						<li><a href="edit_faq.php">Add New</a></li>
					</ul>
					<?php
					} ?>
				</header>
                <section>
                	<?php require_once('confirm_message.php');?>
					
					<div class="row-fluid">
						<div class="span5">
							<div class="alert alert-gray fade in">
							   <strong>You can use this shortcode [faqs] in pages for display faqs</strong>
							</div>
						</div>
					</div>
					
					<?php
					if($prms_faq_delete == '1') { ?>
					<div class="row-fluid">
						<div class="span4">
							<form action="controllers/faq.php" method="POST" style="margin-bottom:0px;">
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
					<?php
					} ?>
					
                	<div id="table_pagination_wrapper" class="dataTables_wrapper form-inline" role="grid">
                	<form action="controllers/faq.php" method="post">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                            	<th width="10"><input type="checkbox" id="chk_all"></th>
                                <th>Title</th>
								<th>Group</th>
                                <th width="150">Order <input type="submit" name="sbt_order" value="Save" class="btn btn-alt"></th>
                                <th width="200">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
							$num_rows = mysqli_num_rows($query);
							if($num_rows>0) {
								while($faq_data=mysqli_fetch_assoc($query)) { ?>
								<tr>
									<td><input type="checkbox" onclick="clickontoggle('<?=$faq_data['id']?>');" class="sub_chk" name="chk[]" value="<?=$faq_data['id']?>" <?php if($faq_data['type']=="fixed"){echo 'disabled="disabled"';}?>></td>
									<td><?=$faq_data['title']?></td>
									<td><?=$faq_data['group_title']?></td>
									<td>
										<input type="text" class="input-small" id="ordering<?=$faq_data['id']?>" value="<?=$faq_data['ordering']?>" name="ordering[<?=$faq_data['id']?>]">
									</td>
									<td>
										<?php
										if($prms_faq_edit == '1') { ?>
										<a href="edit_faq.php?id=<?=$faq_data['id']?>" class="btn btn-alt btn-default"><i class="icon-pencil"></i></a>
										<?php
										}
										if($prms_faq_delete == '1') { ?>
										<?php
										if($faq_data['type']!="fixed") { ?>
											<a href="controllers/faq.php?d_id=<?=$faq_data['id']?>" class="btn btn-danger btn-alt" onclick="return confirm('Are you sure to delete this record?')"><i class="icon-trash"></i></a>
										<?php
										}
										}
										if($faq_data['status']==1) {
											echo '<a href="controllers/faq.php?p_id='.$faq_data['id'].'&status=0"><button class="btn btn-alt btn-success" style="pointer-events: none;">Published</button></a>';
										} elseif($faq_data['status']==0) {
											echo '<a href="controllers/faq.php?p_id='.$faq_data['id'].'&status=1"><button class="btn btn-alt btn-danger" style="pointer-events: none;">Unpublished</button></a>';
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

<div class="modal primary fade" id="faqs_info">
	<div class="modal-dialog">
		<div class="modal-content">
	
			<!-- Modal header -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><strong>&times;</strong></button>
				<?php /*?><h3 class="modal-title">Info</h3><?php */?>
			</div>
			<!-- /Modal header -->

			<!-- Modal body -->
			<div class="modal-body">
				<div class="control-group">
					<label class="control-label" for="input">You can use this shortcode in pages for display faqs</label>
					<div class="controls">
						[faqs]
					</div>
				</div>
			</div>
			<!-- /Modal body -->

			<!-- Modal footer -->
			<?php /*?><div class="modal-footer">
				<button type="button" class="btn btn-alt btn-large btn-black" data-dismiss="modal">Close</button>
			</div><?php */?>
			<!-- /Modal footer -->
		</div>
	</div>
</div>

<script type="text/javascript">
function showFaqInfo() {
	$('#faqs_info').modal({backdrop: 'static',keyboard: false});
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