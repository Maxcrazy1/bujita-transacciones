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
					<h2>Pages</h2>
					<?php
					if($prms_page_add == '1') { ?>
					<ul class="data-header-actions">
						<li><a href="edit_page.php">Add New</a></li>
					</ul>
					<?php
					} ?>
				</header>
                <section>
                	<form action="controllers/page.php" method="post">
					<?php include('confirm_message.php');?>
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
								<th width="30">#</th>
                                <th>Title</th>
								<th>SEF Url</th>
                                <th>Meta Title</th>
								<th>Meta Desc</th>
								<th>Meta Keywords</th>
								<?php /*?><th>Menu Positions</th>
								<th>Order <input type="submit" name="sbt_order" value="Save" class="btn btn-alt"></th><?php */?>
                                <th width="200">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
							$n = 0;
							/*
							foreach($inbuild_page_array as $inbuild_page_data) {
								$saved_inbuild_page_data=saved_inbuild_page_data($inbuild_page_data['slug']);
								$menu_name = $saved_inbuild_page_data['menu_name'];
								$title = $saved_inbuild_page_data['title'];
								$url = $saved_inbuild_page_data['url'];
								$finl_url = ($url?$url:$inbuild_page_data['url']); ?>
								<tr>
									<td width="30"><?=$n=$n+1?></td>
									<td><?=($title?$title:$inbuild_page_data['title'])?></td>
									<td><a href="<?=SITE_URL.$finl_url?>" target="_blank"><?=$finl_url?></a></td>
									<td><?=$saved_inbuild_page_data['meta_title']?></td>
									<td><?=$saved_inbuild_page_data['meta_keywords']?></td>
									<td><?=$saved_inbuild_page_data['meta_desc']?></td>
									<td><?=$saved_inbuild_page_data['ordering']?></td>
									<td>
										<a href="edit_page.php?id=<?=intval($saved_inbuild_page_data['id'])?>&slug=<?=$inbuild_page_data['slug']?>" class="btn btn-alt btn-default"><i class="icon-pencil"></i></a>
										<?php
										if(!empty($saved_inbuild_page_data)) {
											if($saved_inbuild_page_data['published']==1) {
												echo '<a href="controllers/page.php?p_id='.$saved_inbuild_page_data['id'].'&published=0" class="'.($inbuild_page_data['slug']=='home'?' not-active':'').'"><button class="btn btn-alt btn-success">Published</button></a>';
											} elseif($saved_inbuild_page_data['published']==0) {
												echo '<a href="controllers/page.php?p_id='.$saved_inbuild_page_data['id'].'&published=1" class="'.($inbuild_page_data['slug']=='home'?' not-active':'').'"><button class="btn btn-alt btn-danger">Unpublished</button></a>';
											}
										}
										?>
									</td>
								</tr>
							<?php
							} */

							$num_rows = mysqli_num_rows($query);
							if($num_rows>0) {
								while($page_data=mysqli_fetch_assoc($query)) {
								$position_array = (array)json_decode($page_data['position']);
								$imp_position = ucwords(str_replace("_"," ",implode(", ",$position_array))); ?>
								<tr>
									<td width="30"><?=$n=$n+1?></td>
									<td><?=$page_data['title']?></td>
									<td><a href="<?=SITE_URL.$page_data['url']?>" target="_blank"><?=$page_data['url']?></a></td>
									<td><?=$page_data['meta_title']?></td>
									<td><?=$page_data['meta_keywords']?></td>
									<td><?=$page_data['meta_desc']?></td>
									<?php /*?><td><?=$imp_position?></td>
									<td><input type="text" class="input-small" id="ordering<?=$page_data['id']?>" value="<?=$page_data['ordering']?>" name="ordering[<?=$page_data['id']?>]"></td><?php */?>
									<td>
										<?php
										if($prms_page_edit == '1') { ?>
										<a href="edit_page.php?id=<?=$page_data['id']?>&slug=<?=$page_data['slug']?>" class="btn btn-alt btn-default"><i class="icon-pencil"></i></a>
										<?php
										}
										if($prms_page_delete == '1') {
										if(!in_array($page_data['slug'],$inbuild_page_slug)) { ?>
										<a href="controllers/page.php?d_id=<?=$page_data['id']?>" class="btn btn-danger btn-alt" onclick="return confirm('Are you sure to delete this record?')"><i class="icon-trash"></i></a> 
										<?php
										}
										}
										if($page_data['published']==1) {
											echo '<a href="controllers/page.php?p_id='.$page_data['id'].'&published=0" class="btn btn-alt btn-success '.($page_data['slug']=='home'?' not-active':'').'">Published</a>';
										} elseif($page_data['published']==0) {
											echo '<a href="controllers/page.php?p_id='.$page_data['id'].'&published=1" class="btn btn-alt btn-danger '.($page_data['slug']=='home'?' not-active':'').'">Unpublished</a>';
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
                </section>
        	</article>
        </div>
    </section>
	<div id="push"></div>
</div>