<script type="text/javascript">
function check_form(a){
	if(a.page_id.value=="" && a.url.value.trim()=="") {
		alert('Must be select page or enter url');
		a.page_id.focus();
		return false;
	}
	if(a.menu_name.value.trim()=="") {
		alert('Please enter menu name');
		a.menu_name.focus();
		a.menu_name.value='';
		return false;
	}
}

function SelectPage(page) {
	if(page!="") {
		$(".showhide_menu_url").hide();
	} else {
		$(".showhide_menu_url").show();
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
				<header><h2><?=($id?'Edit Menu':'Add Menu')?></h2></header>
                <section>
					<?php include('confirm_message.php');?>
                    <div class="row-fluid">
                        <div class="span9">
                            <form role="form" action="controllers/menu.php" class="form-horizontal form-groups-bordered" method="post" onSubmit="return check_form(this);">
                                <fieldset>
									<div class="control-group">
										<label class="control-label" for="input">Select Page</label>
										<div class="controls">
											<select name="page_id" id="page_id" onchange="SelectPage(this.value)">
												<option value=""> -Select- </option>
												<?php
												//Fetch page list
												$pages_data=mysqli_query($db,'SELECT * FROM pages WHERE published=1');
												while($pages_list=mysqli_fetch_assoc($pages_data)) { ?>
													<option value="<?=$pages_list['id']?>" <?php if($pages_list['id']==$menu_data['page_id']){echo 'selected="selected"';}?>><?=$pages_list['title']?></option>
												<?php
												} ?>
											</select>
										</div>
									</div>
									
									<div class="control-group">
                                        <label class="control-label" for="input">Url</label>
                                        <div class="controls showhide_menu_url" <?=($menu_data['page_id']>0?'style="display:none;"':'')?>>
											<input type="text" class="input-large" id="url" value="<?=$menu_data['url']?>" name="url">
                                        </div>
										<div class="controls showhide_menu_url" <?=($menu_data['page_id']>0?'style="display:none;"':'')?>>
											<label class="radio-custom-inline custom-radio">
											<input type="checkbox" class="input-large" id="is_custom_url" value="1" name="is_custom_url" <?=($menu_data['is_custom_url']=='1'?'checked="checked"':'')?>> <span>Custom Url</span></label>
										</div>
										<div class="controls">
											<label class="radio-custom-inline custom-radio">
											<input type="checkbox" class="input-large" id="is_open_new_window" value="1" name="is_open_new_window" <?=($menu_data['is_open_new_window']=='1'?'checked="checked"':'')?>> <span>Is Open New Window</span>
											</label>
										</div>
                                    </div>
									
									<div class="control-group">
                                        <label class="control-label" for="input">Name</label>
                                        <div class="controls">
											<input type="text" class="input-large" id="menu_name" value="<?=$menu_data['menu_name']?>" name="menu_name">
                                        </div>
                                    </div>

									<div class="control-group">
                                        <label class="control-label" for="input">Custom CSS Class</label>
                                        <div class="controls">
											<input type="text" class="input-large" id="css_menu_class" value="<?=$menu_data['css_menu_class']?>" name="css_menu_class">
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="input">Custom CSS Fa Icon</label>
                                        <div class="controls">
											<input type="text" class="input-large" id="css_menu_fa_icon" value="<?=$menu_data['css_menu_fa_icon']?>" name="css_menu_fa_icon">
                                        </div>
                                    </div>

									<div class="control-group">
										<label class="control-label" for="input">Parent Menu</label>
										<div class="controls">
											<select name="parent" id="parent">
												<option value=""> -Select- </option>

												<?php
												$main_menu_list = get_menu_list($menu_position);
												if(!empty($main_menu_list)) {
													//START for main menu
													foreach($main_menu_list as $main_menu_data) { ?>
														<option value="<?=$main_menu_data['id']?>" <?php if($main_menu_data['id']==$menu_data['parent']){echo 'selected="selected"';}?>><?=$main_menu_data['menu_name']?></option>
															<?php
															//START for submenu of main menu		
															if(count($main_menu_data['submenu'])>0) {
																$submenu_list = $main_menu_data['submenu'];
																  foreach($submenu_list as $submenu_data) { ?>
																	  <option value="<?=$submenu_data['id']?>" <?php if($submenu_data['id']==$menu_data['parent']){echo 'selected="selected"';}?>><?=str_repeat('&nbsp;', 5).' - '.$submenu_data['menu_name']?></option>
																		<?php
																		//START for submenu of submenu of main menu
																		if(count($submenu_data['submenu'])>0) {
																			$sub_sub_menu_list = $submenu_data['submenu'];
																			  foreach($sub_sub_menu_list as $sub_sub_menu_data) { ?>
																				  <option value="<?=$sub_sub_menu_data['id']?>" <?php if($sub_sub_menu_data['id']==$menu_data['parent']){echo 'selected="selected"';}?> disabled="disabled"><?=str_repeat('&nbsp;', 10).' - '.$sub_sub_menu_data['menu_name']?></option>
																			  <?php
																			  }
																		} //END for submenu of submenu of main menu
																  }
															} //END for submenu of main menu
													} //END for main menu
												} ?>

												<?php
												//Fetch page list
												/*$pmenus_data=mysqli_query($db,"SELECT * FROM menus WHERE status=1 AND position='".$menu_position."'");
												while($parent_menus_list=mysqli_fetch_assoc($pmenus_data)) { ?>
													<option value="<?=$parent_menus_list['id']?>" <?php if($parent_menus_list['id']==$menu_data['parent']){echo 'selected="selected"';}?>><?=$parent_menus_list['menu_name']?></option>
												<?php
												}*/ ?>
											</select>
											<br /><small>Allow maximum three level</small>
										</div>
									</div>
									
									<div class="control-group">
										<label class="control-label" for="input">Order (Must be numeric)</label>
										<div class="controls">
											<input id="ordering" type="number" name="ordering" value="<?=$menu_data['ordering']?>">
										</div>
									</div>
										
									<div class="control-group radio-inline">
										<label class="control-label" for="published">Status</label>
										<div class="controls">
											<label class="radio-custom-inline custom-radio">
												<input type="radio" id="status" name="status" value="1" <?php if(!$id){echo 'checked="checked"';}?> <?=($menu_data['status']==1?'checked="checked"':'')?>>
												Active
											</label>
											<label class="radio-custom-inline ml-10 custom-radio">
												<input type="radio" id="status" name="status" value="0" <?=($menu_data['status']=='0'?'checked="checked"':'')?>>
												Inactive
											</label>
										</div>
									</div>
									
                                    <input type="hidden" name="id" value="<?=$menu_data['id']?>" />
									<input type="hidden" name="position" value="<?=$menu_position?>" />
									
                                    <div class="form-actions">
                                        <button class="btn btn-alt btn-large btn-primary" type="submit" name="add_edit"><?=($id?'Update':'Save')?></button>
										<a href="menu.php?position=<?=$menu_position?>" class="btn btn-alt btn-large btn-black">Back</a>
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