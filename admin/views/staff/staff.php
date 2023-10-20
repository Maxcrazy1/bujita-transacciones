<div id="wrapper">
    <header id="header" class="container">
    	<?php require_once("include/admin_menu.php"); ?>
    </header>
	
	<section class="container" role="main">
         <div class="row">
            <article class="span12 data-block">
                <header>
					<h2>Staff List</h2>
					<ul class="data-header-actions">
						<li><a href="edit_staff.php">Add New</a></li>
					</ul>
				</header>
                <section>
                	<form action="controllers/staff.php" method="post">
                    <?php require_once('confirm_message.php');?>
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="110">Username</th>
                                <th>Email</th>
								<th>Group</th>
                                <th width="200">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
							$num_rows = mysqli_num_rows($query);
							if($num_rows>0) {
								while($admin_data=mysqli_fetch_assoc($query)) { ?>
								<tr>
									<td><?=$admin_data['username']?></td>
									<td><?=$admin_data['email']?></td>
									<td><?=$admin_data['group_name']?></td>
									<td>
										<a href="edit_staff.php?id=<?=$admin_data['id']?>" class="btn btn-alt btn-default"><i class="icon-pencil"></i></a>
										<a href="controllers/staff.php?d_id=<?=$admin_data['id']?>" class="btn btn-danger btn-alt" onclick="return confirm('Are you sure to delete this record?')"><i class="icon-trash"></i></a> 
										<?php
										if($admin_data['status']==1) {
											echo '<a href="controllers/staff.php?p_id='.$admin_data['id'].'&status=0"><button class="btn btn-alt btn-success" style="pointer-events: none;">Active</button></a>';
										} elseif($admin_data['status']==0) {
											echo '<a href="controllers/staff.php?p_id='.$admin_data['id'].'&status=1"><button class="btn btn-alt btn-danger" style="pointer-events: none;">Inactive</button></a>';
										}
										?>
									</td>
								</tr>
								<?php
								}
							} else { ?>
								<tr><td align="center">No Data Found</td></tr>
							<?php
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