<div id="wrapper">
    <header id="header" class="container">
    	<?php include("include/admin_menu.php"); ?>
    </header>
	
	<section class="container" role="main">
         <div class="row">
            <article class="span12 data-block">
                <header>
					<h2>Categories</h2>
					<?php
					if($prms_blog_add == '1') { ?>
					<ul class="data-header-actions">
						<li><a href="add-category.php">Add New</a></li>
					</ul>
					<?php
					} ?>
				</header>
                <section>
					<?php include('confirm_message.php');?>
                    <table class="datatable table table-striped table-bordered table-hover" id="table_pagination">
                        <thead>
                            <tr>
								<th width="30">#</th>
								<th>Title</th>
                                <th width="100">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
							$n = 0;
							$num_rows = mysqli_num_rows($query);
							if($num_rows>0) {
								while($page_data=mysqli_fetch_assoc($query)) { ?>
								<tr>
									<td width="30"><?=$n=$n+1?></td>
									<td><?=$page_data['catTitle']?></td>
									<td>
										<?php
										if($prms_blog_edit == '1') { ?>
										<a href="add-category.php?id=<?=$page_data['catID']?>" class="btn btn-alt btn-default"><i class="icon-pencil"></i></a>
										<?php
										}
										if($prms_blog_delete == '1') { ?>
										<a href="controllers/blog.php?d_c_id=<?=$page_data['catID']?>" class="btn btn-danger btn-alt" onclick="return confirm('Are you sure to delete this category?')"><i class="icon-trash"></i></a>
										<?php
										} ?>
									</td>
								</tr>
								<?php
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