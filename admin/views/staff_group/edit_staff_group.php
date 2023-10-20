<div id="wrapper">
    <header id="header" class="container">
    	<?php include("include/admin_menu.php"); ?>
    </header>

	<section class="container" role="main">
		<div class="row">
            <article class="span12 data-block">
				<header><h2><?=($id?'Edit Staff Group':'Add Staff Group')?></h2></header>
                <section>
					<?php include('confirm_message.php');?>
                    <div class="row-fluid">
                        <div class="span9">
                            <form role="form" action="controllers/staff_group.php" class="form-inline no-margin" method="post">
                                <fieldset>
                                    <div class="control-group">
                                        <label class="control-label" for="input">Name</label>
                                        <div class="controls">
											<input type="text" class="input-large" id="name" value="<?=$staff_group_data['name']?>" name="name" required>
                                        </div>
                                    </div>
									<div class="control-group">
                                        <label class="control-label" for="input">Email</label>
                                        <div class="controls">
											<input type="email" class="input-large" id="email" value="<?=$staff_group_data['email']?>" name="email" required>
                                        </div>
                                    </div>
									
									<h4>Permissions</h4>
									<div class="control-group">
										<label class="control-label" for="published">Orders</label>
										<div class="controls">
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[order_view]" <?php if($permissions_array['order_view']=='1'){echo 'checked="checked"';}?>>
												View
											</label>
											<?php /*?><label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[order_add]" <?php if($permissions_array['order_add']=='1'){echo 'checked="checked"';}?>>
												Add
											</label><?php */?>
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[order_edit]" <?php if($permissions_array['order_edit']=='1'){echo 'checked="checked"';}?>>
												Edit
											</label>
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[order_delete]" <?php if($permissions_array['order_delete']=='1'){echo 'checked="checked"';}?>>
												Delete
											</label>
											<?php /*?><label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[order_invoice]" <?php if($permissions_array['order_invoice']=='1'){echo 'checked="checked"';}?>>
												Invoice
											</label><?php */?>
										</div>
									</div>
									
									<div class="control-group">
										<label class="control-label" for="published">Models</label>
										<div class="controls">
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[model_view]" <?php if($permissions_array['model_view']=='1'){echo 'checked="checked"';}?>>
												View
											</label>
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[model_add]" <?php if($permissions_array['model_add']=='1'){echo 'checked="checked"';}?>>
												Add
											</label>
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[model_edit]" <?php if($permissions_array['model_edit']=='1'){echo 'checked="checked"';}?>>
												Edit
											</label>
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[model_delete]" <?php if($permissions_array['model_delete']=='1'){echo 'checked="checked"';}?>>
												Delete
											</label>
										</div>
									</div>
									
									<div class="control-group">
										<label class="control-label" for="published">Devices</label>
										<div class="controls">
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[device_view]" <?php if($permissions_array['device_view']=='1'){echo 'checked="checked"';}?>>
												View
											</label>
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[device_add]" <?php if($permissions_array['device_add']=='1'){echo 'checked="checked"';}?>>
												Add
											</label>
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[device_edit]" <?php if($permissions_array['device_edit']=='1'){echo 'checked="checked"';}?>>
												Edit
											</label>
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[device_delete]" <?php if($permissions_array['device_delete']=='1'){echo 'checked="checked"';}?>>
												Delete
											</label>
										</div>
									</div>
									
									<div class="control-group">
										<label class="control-label" for="published">Brands</label>
										<div class="controls">
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[brand_view]" <?php if($permissions_array['brand_view']=='1'){echo 'checked="checked"';}?>>
												View
											</label>
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[brand_add]" <?php if($permissions_array['brand_add']=='1'){echo 'checked="checked"';}?>>
												Add
											</label>
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[brand_edit]" <?php if($permissions_array['brand_edit']=='1'){echo 'checked="checked"';}?>>
												Edit
											</label>
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[brand_delete]" <?php if($permissions_array['brand_delete']=='1'){echo 'checked="checked"';}?>>
												Delete
											</label>
										</div>
									</div>
									
									<div class="control-group">
										<label class="control-label" for="published">Category</label>
										<div class="controls">
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[category_view]" <?php if($permissions_array['category_view']=='1'){echo 'checked="checked"';}?>>
												View
											</label>
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[category_add]" <?php if($permissions_array['category_add']=='1'){echo 'checked="checked"';}?>>
												Add
											</label>
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[category_edit]" <?php if($permissions_array['category_edit']=='1'){echo 'checked="checked"';}?>>
												Edit
											</label>
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[category_delete]" <?php if($permissions_array['category_delete']=='1'){echo 'checked="checked"';}?>>
												Delete
											</label>
										</div>
									</div>
									
									<div class="control-group">
										<label class="control-label" for="published">Customers</label>
										<div class="controls">
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[customer_view]" <?php if($permissions_array['customer_view']=='1'){echo 'checked="checked"';}?>>
												View
											</label>
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[customer_add]" <?php if($permissions_array['customer_add']=='1'){echo 'checked="checked"';}?>>
												Add
											</label>
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[customer_edit]" <?php if($permissions_array['customer_edit']=='1'){echo 'checked="checked"';}?>>
												Edit
											</label>
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[customer_delete]" <?php if($permissions_array['customer_delete']=='1'){echo 'checked="checked"';}?>>
												Delete
											</label>
										</div>
									</div>
									
									<div class="control-group">
										<label class="control-label" for="published">Pages Management</label>
										<div class="controls">
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[page_view]" <?php if($permissions_array['page_view']=='1'){echo 'checked="checked"';}?>>
												View
											</label>
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[page_add]" <?php if($permissions_array['page_add']=='1'){echo 'checked="checked"';}?>>
												Add
											</label>
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[page_edit]" <?php if($permissions_array['page_edit']=='1'){echo 'checked="checked"';}?>>
												Edit
											</label>
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[page_delete]" <?php if($permissions_array['page_delete']=='1'){echo 'checked="checked"';}?>>
												Delete
											</label>
										</div>
									</div>
									
									<div class="control-group">
										<label class="control-label" for="published">Menu Management</label>
										<div class="controls">
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[menu_view]" <?php if($permissions_array['menu_view']=='1'){echo 'checked="checked"';}?>>
												View
											</label>
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[menu_add]" <?php if($permissions_array['menu_add']=='1'){echo 'checked="checked"';}?>>
												Add
											</label>
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[menu_edit]" <?php if($permissions_array['menu_edit']=='1'){echo 'checked="checked"';}?>>
												Edit
											</label>
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[menu_delete]" <?php if($permissions_array['menu_delete']=='1'){echo 'checked="checked"';}?>>
												Delete
											</label>
										</div>
									</div>
									
									<div class="control-group">
										<label class="control-label" for="published">Forms</label>
										<div class="controls">
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[form_view]" <?php if($permissions_array['form_view']=='1'){echo 'checked="checked"';}?>>
												View
											</label>
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[form_add]" <?php if($permissions_array['form_add']=='1'){echo 'checked="checked"';}?>>
												Add
											</label>
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[form_edit]" <?php if($permissions_array['form_edit']=='1'){echo 'checked="checked"';}?>>
												Edit
											</label>
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[form_delete]" <?php if($permissions_array['form_delete']=='1'){echo 'checked="checked"';}?>>
												Delete
											</label>
										</div>
									</div>
									
									<div class="control-group">
										<label class="control-label" for="published">Blog</label>
										<div class="controls">
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[blog_view]" <?php if($permissions_array['blog_view']=='1'){echo 'checked="checked"';}?>>
												View
											</label>
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[blog_add]" <?php if($permissions_array['blog_add']=='1'){echo 'checked="checked"';}?>>
												Add
											</label>
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[blog_edit]" <?php if($permissions_array['blog_edit']=='1'){echo 'checked="checked"';}?>>
												Edit
											</label>
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[blog_delete]" <?php if($permissions_array['blog_delete']=='1'){echo 'checked="checked"';}?>>
												Delete
											</label>
										</div>
									</div>
									
									<div class="control-group">
										<label class="control-label" for="published">Faqs</label>
										<div class="controls">
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[faq_view]" <?php if($permissions_array['faq_view']=='1'){echo 'checked="checked"';}?>>
												View
											</label>
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[faq_add]" <?php if($permissions_array['faq_add']=='1'){echo 'checked="checked"';}?>>
												Add
											</label>
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[faq_edit]" <?php if($permissions_array['faq_edit']=='1'){echo 'checked="checked"';}?>>
												Edit
											</label>
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[faq_delete]" <?php if($permissions_array['faq_delete']=='1'){echo 'checked="checked"';}?>>
												Delete
											</label>
										</div>
									</div>
									
									<div class="control-group">
										<label class="control-label" for="published">Promo Codes</label>
										<div class="controls">
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[promocode_view]" <?php if($permissions_array['promocode_view']=='1'){echo 'checked="checked"';}?>>
												View
											</label>
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[promocode_add]" <?php if($permissions_array['promocode_add']=='1'){echo 'checked="checked"';}?>>
												Add
											</label>
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[promocode_edit]" <?php if($permissions_array['promocode_edit']=='1'){echo 'checked="checked"';}?>>
												Edit
											</label>
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[promocode_delete]" <?php if($permissions_array['promocode_delete']=='1'){echo 'checked="checked"';}?>>
												Delete
											</label>
										</div>
									</div>
									
									<div class="control-group">
										<label class="control-label" for="published">Email Templates</label>
										<div class="controls">
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[emailtmpl_view]" <?php if($permissions_array['emailtmpl_view']=='1'){echo 'checked="checked"';}?>>
												View
											</label>
											<?php /*?><label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[emailtmpl_add]" <?php if($permissions_array['emailtmpl_add']=='1'){echo 'checked="checked"';}?>>
												Add
											</label><?php */?>
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[emailtmpl_edit]" <?php if($permissions_array['emailtmpl_edit']=='1'){echo 'checked="checked"';}?>>
												Edit
											</label>
											<?php /*?><label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[emailtmpl_delete]" <?php if($permissions_array['emailtmpl_delete']=='1'){echo 'checked="checked"';}?>>
												Delete
											</label><?php */?>
										</div>
									</div>
									
									<?php /*?><div class="control-group">
										<label class="control-label" for="published">Contractors</label>
										<div class="controls">
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[contractor_view]" <?php if($permissions_array['contractor_view']=='1'){echo 'checked="checked"';}?>>
												View
											</label>
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[contractor_add]" <?php if($permissions_array['contractor_add']=='1'){echo 'checked="checked"';}?>>
												Add
											</label>
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[contractor_edit]" <?php if($permissions_array['contractor_edit']=='1'){echo 'checked="checked"';}?>>
												Edit
											</label>
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[contractor_delete]" <?php if($permissions_array['contractor_delete']=='1'){echo 'checked="checked"';}?>>
												Delete
											</label>
										</div>
									</div>
									
									<div class="control-group">
										<label class="control-label" for="published">Invoices</label>
										<div class="controls">
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[invoice_view]" <?php if($permissions_array['invoice_view']=='1'){echo 'checked="checked"';}?>>
												View
											</label>
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[invoice_add]" <?php if($permissions_array['invoice_add']=='1'){echo 'checked="checked"';}?>>
												Add
											</label>
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[invoice_edit]" <?php if($permissions_array['invoice_edit']=='1'){echo 'checked="checked"';}?>>
												Edit
											</label>
											<label class="checkbox custom-checkbox">
												<input type="checkbox" value="1" name="permissions[invoice_delete]" <?php if($permissions_array['invoice_delete']=='1'){echo 'checked="checked"';}?>>
												Delete
											</label>
										</div>
									</div><?php */?>

									<div class="control-group radio-inline">
											<label class="control-label" for="status">Publish</label>
											<div class="controls">
												<label class="radio-custom-inline custom-radio">
													<input type="radio" id="status" name="status" value="1" <?php if(!$id){echo 'checked="checked"';}?> <?=($staff_group_data['status']==1?'checked="checked"':'')?>>
													Yes
												</label>
												<label class="radio-custom-inline ml-10 custom-radio">
													<input type="radio" id="status" name="status" value="0" <?=($staff_group_data['status']=='0'?'checked="checked"':'')?>>
													No
												</label>
											</div>
										</div>
										
                                    	<input type="hidden" name="id" value="<?=$staff_group_data['id']?>" />
									 
										<div class="form-actions">
											<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button>
											<a href="staff_group.php" class="btn btn-alt btn-large btn-black">Back</a>
										</div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </section>
            </article>
        </div>
    </section>
	<div id="push"></div>
</div>