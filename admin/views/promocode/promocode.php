<div id="wrapper">
    <header id="header" class="container">
    	<?php include("include/admin_menu.php"); ?>
    </header>
	
	<section class="container" role="main">
         <div class="row">
            <article class="span12 data-block">
                <header>
					<h2>Promo Codes</h2>
					<ul class="data-header-actions">
						<li><a href="add_promocode.php">Add New</a></li>
					</ul>
				</header>
                <section>
					<?php include('confirm_message.php');?>
                    <table class="datatable table table-striped table-bordered table-hover" id="table_pagination">
                        <thead>
                            <tr>
							  <th>ID</th>
							  <th>Promo Code</th>
							  <th>From Date</th>
							  <th>Expire Date</th>
							  <th>Discount</th>
							  <th>Active</th>
							  <th>Action</th>
							</tr>
                        </thead>
                        <tbody>
						<?php
						$num_of_rows = mysqli_num_rows($result);
						if($num_of_rows>0) {
							while($promocode_data=mysqli_fetch_array($result)) { ?>
								<tr>
								  <td><?=$promocode_data['id']?></td>
								  <td><?=$promocode_data['promocode']?></td>
								  <td><?=date("m/d/Y",strtotime($promocode_data['from_date']))?></td>
								  <td><?=date("m/d/Y",strtotime($promocode_data['to_date']))?></td>
								  <td><?=($promocode_data['discount_type']=="percentage"?$promocode_data['discount'].'%':amount_fomat($promocode_data['discount']))?></td>
								  <td><?=$promocode_data['status']=='1'?'Yes':'No'?></td>
								  <td>
								  <a href="edit_promocode.php?id=<?=$promocode_data['id']?>" class="btn btn-alt btn-default"><i class="icon-pencil"></i></a>
								  <a href="controllers/promocode.php?r_id=<?=$promocode_data['id']?>" class="btn btn-danger btn-alt" onclick="return confirm('Are you sure to delete this record?')"><i class="icon-trash"></i></a>
								  </td>
								</tr>
							<?php
							}
						} ?>
                    </table>
                </section>
        	</article>
        </div>
    </section>
	<div id="push"></div>
</div>