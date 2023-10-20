<style type="text/css">
.not-active {
   pointer-events: none;
   cursor: default;
   opacity:0.6;
}
</style>
			
<div id="wrapper">
    <header id="header" class="container">
    	<?php include("include/admin_menu.php"); ?>
    </header>
	
	<section class="container" role="main">
         <div class="row">
            <article class="span12 data-block">
                <header>
					<h2>Menus</h2>
					<?php
					if($prms_menu_add == '1') { ?>
					<ul class="data-header-actions">
						<li><a href="edit_menu.php?position=<?=$menu_position?>">Add New</a></li>
					</ul>
					<?php
					} ?>
				</header>
                <section>
				
					<form method="get">
						<div class="control-group">
							<div class="controls">
								<select name="position" id="position">
									<option value="top_right" <?php if("top_right"==$menu_position){echo 'selected="selected"';}?>>Top Right Menu</option>
									<option value="header" <?php if("header"==$menu_position){echo 'selected="selected"';}?>>Header Menu</option>
									<option value="mobile_main_menu" <?php if("mobile_main_menu"==$menu_position){echo 'selected="selected"';}?>>Mobile Main Menu</option>
									<option value="footer_column1" <?php if("footer_column1"==$menu_position){echo 'selected="selected"';}?>>Footer Menu Column1</option>
									<option value="footer_column2" <?php if("footer_column2"==$menu_position){echo 'selected="selected"';}?>>Footer Menu Column2</option>
									<option value="footer_column3" <?php if("footer_column3"==$menu_position){echo 'selected="selected"';}?>>Footer Menu Column3</option>
									<option value="copyright_menu" <?php if("copyright_menu"==$menu_position){echo 'selected="selected"';}?>>Copyright Menu</option>
								</select>
								<button class="btn btn-alt btn-primary" type="submit">Go</button>
							</div>
						</div>
					</form>
					
					<form action="controllers/menu.php" method="post">
					<?php include('confirm_message.php');?>
					
					<?php /*?><div class="row-fluid">
						<div class="span4">&nbsp;</div>
						<div class="span8">
							<?php echo $pages->page_limit_dropdown(); ?>
						</div>
					</div><?php */?>
					
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
								<th width="30">#</th>
                                <th>Page Name</th>
								<th>Menu Name</th>
                                <th>Parent Menu</th>
								<th>Order <input type="submit" name="sbt_order" value="Save" class="btn btn-alt"></th>
                                <th width="200">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
							$n = 0;
							$num_rows = mysqli_num_rows($query);
							if($num_rows>0) {
								while($menu_data=mysqli_fetch_assoc($query)) {
								$parent_menu_id = '';
								//$parent_menu_data = array();

								$parent_menu_id = $menu_data['parent'];
								/*if($parent_menu_id>0) {
									$parent_menu_data = get_parent_menu_data($parent_menu_id);
								}*/

								$sub_menu_nm_label = "";
								$main_menu_list = get_menu_list($menu_position);
								if(!empty($main_menu_list)) {
									//START for main menu
									foreach($main_menu_list as $main_menu_data) {
										if($main_menu_data['id'] == $parent_menu_id) {
											$sub_menu_nm_label .= $main_menu_data['menu_name'];
										}
										
										//START for submenu of main menu		
										if(count($main_menu_data['submenu'])>0) {
											$submenu_list = $main_menu_data['submenu'];
											  foreach($submenu_list as $submenu_data) {
												if($submenu_data['id'] == $parent_menu_id) {
													$sub_menu_nm_label .= $main_menu_data['menu_name'].' - '.$submenu_data['menu_name'];
												}
											  }
										} //END for submenu of main menu
									} //END for main menu
								} ?>
								<tr>
									<td width="30"><?=$n=$n+1?></td>
									<td><?=$menu_data['page_title']?></td>
									<td><?=$menu_data['menu_name']?></td>
									<td><?=$sub_menu_nm_label?><?php /*?><?=$parent_menu_data['menu_name']?><?php */?></td>
									<td><input type="text" class="input-small" id="ordering<?=$menu_data['id']?>" value="<?=$menu_data['ordering']?>" name="ordering[<?=$menu_data['id']?>]"></td>
									<td>
										<?php
										if($prms_menu_edit == '1') { ?>
										<a href="edit_menu.php?id=<?=$menu_data['id']?>&position=<?=$menu_position?>" class="btn btn-alt btn-default"><i class="icon-pencil"></i></a>
										<?php
										}
										if($prms_menu_delete == '1') { ?>
										<a href="controllers/menu.php?d_id=<?=$menu_data['id']?>&position=<?=$menu_position?>" class="btn btn-danger btn-alt" onclick="return confirm('Are you sure to delete this record?')"><i class="icon-trash"></i></a> 
										<?php
										}
										if($menu_data['status']==1) {
											echo '<a href="controllers/menu.php?p_id='.$menu_data['id'].'&published=0&position='.$menu_position.'" class="btn btn-alt btn-success">Active</a>';
										} elseif($menu_data['status']==0) {
											echo '<a href="controllers/menu.php?p_id='.$menu_data['id'].'&published=1&position='.$menu_position.'" class="btn btn-alt btn-danger">Inactive</a>';
										}
										?>
									</td>
								</tr>
								<?php
								}
							} ?>
                        </tbody>
                    </table>
					<input type="hidden" name="position" id="position" value="<?=$menu_position?>" />
					</form>
                	<?php
					$p_custom_path = '?position='.$menu_position.'&';
					echo $pages->page_links($p_custom_path); ?>
                </section>
        	</article>
        </div>
    </section>
	<div id="push"></div>
</div>