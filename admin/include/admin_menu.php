<h1>
	<!-- Main page logo -->
	<a class="logo-text" href="<?=ADMIN_URL?>" title="<?=ADMIN_PANEL_NAME?>"><img style="height:60px;" src="<?= $logo_url ?>" alt=""></a>
</h1>

<div class="user-profile">
	<figure>
		<!-- User profile info -->
		<figcaption>
			<strong><a href="#" class="">Hello <?=($loggedin_user_name?$loggedin_user_name:'Admin')?></a></strong>
			<ul>
				<li <?php if($file_name=="profile"){echo 'class="active"';}?>><a href="profile.php">My Account</a> | </li>
				<?php
				if($admin_type == "super_admin") { ?>
					<li <?php if($file_name=="general_settings"){echo 'class="active"';}?>>
						<a href="general_settings.php" title="Settings">Settings</a> | 
					</li>
					<?php /*?><li <?php if($file_name=="staff"){echo 'class="active"';}?>><a href="staff.php">Staff User(s)</a> | </li><?php */?>
				<?php
				} ?>
				<li><a href="logout.php" title="Logout">Logout</a> | </li>
				<li><a target="_blank" href="<?=SITE_URL?>">FrontEnd</a></li>
				
			</ul>
		</figcaption>
		<!-- /User profile info -->

	</figure>
</div>

<nav class="main-navigation">

	<!-- Responsive navbar button -->
	<div class="navbar">
		<a class="btn btn-alt btn-large btn-primary btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span class="icon-home"></span> Dashboard</a>
	</div>
	<!-- /Responsive navbar button -->

    <div class="nav-collapse collapse" role="navigation">
        <ul>
			<?php
			if($prms_category_view == '1') { ?>
        	<li <?php if($file_name=="device_categories"){echo 'class="active"';}?>><a href="device_categories.php">Categories</a></li>
			<?php
			}
			if($prms_brand_view == '1') { ?>
			<li <?php if($file_name=="brand"){echo 'class="active"';}?>><a href="brand.php">Brand</a></li>
			<?php
			}
			if($prms_device_view == '1') { ?>
			<li <?php if($file_name=="device"){echo 'class="active"';}?>><a href="device.php">Devices</a></li>
			<?php
			}
			if($prms_model_view == '1') { ?>
			<li <?php if($file_name=="mobile"){echo 'class="active"';}?>> <a href="mobile.php">Models</a></li>
			<?php
			}
			/*if($prms_order_view == '1') { ?>
			<li <?php if($file_name=="orders"){echo 'class="active"';}?>> <a href="orders.php">Orders</a></li>
			<?php
			}*/
			
			if($prms_order_view == '1') { ?>
  			<li class="dropdown <?php if($file_name=="awaiting_orders" || $file_name=="orders" || $file_name=="paid_orders" || $file_name=="archive_orders"){echo 'active';}?>">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Orders <b class="caret"></b></a>
			  <ul class="dropdown-menu">
				<li <?php if($file_name=="awaiting_orders"){echo 'class="active"';}?>><a href="awaiting_orders.php">Awaiting Orders</a></li>
				<li <?php if($file_name=="orders"){echo 'class="active"';}?>><a href="orders.php">Unpaid Orders</a></li>
				<li <?php if($file_name=="paid_orders"){echo 'class="active"';}?>><a href="paid_orders.php">Paid Orders</a></li>
				<li <?php if($file_name=="archive_orders"){echo 'class="active"';}?>><a href="archive_orders.php">Archive Orders</a></li>
			  </ul>
			</li>
			<?php
			}
			
			if($prms_customer_view == '1') { ?>
			<li <?php if($file_name=="users"){echo 'class="active"';}?>> <a href="users.php">Customers</a></li>
			<?php
			} ?>
			
			<?php
			if($prms_form_view == '1') { ?>	
			<li class="dropdown <?php if($file_name=="contact" || $file_name=="review" || $file_name=="bulk_order" || $file_name=="affiliate" || $file_name=="newsletter"){echo 'active';}?>">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Forms <b class="caret"></b></a>
			  <ul class="dropdown-menu">
				<li <?php if($file_name=="contact"){echo 'class="active"';}?>> <a href="contact.php">Contacts</a></li>
				<li <?php if($file_name=="review"){echo 'class="active"';}?>> <a href="review.php">Reviews</a></li>
				<li <?php if($file_name=="bulk_order"){echo 'class="active"';}?>> <a href="bulk_order.php">Bulk Orders</a></li>
				<?php /*?><li <?php if($file_name=="affiliate"){echo 'class="active"';}?>> <a href="affiliate.php">Affiliates</a></li><?php */?>
				<li <?php if($file_name=="newsletter"){echo 'class="active"';}?>> <a href="newsletter.php">Newsletters</a></li>
			  </ul>
			</li>
			<?php
			}
			if($prms_blog_view == '1') { ?>
  			<li class="dropdown <?php if($file_name=="blog" || $file_name=="categories"){echo 'active';}?>">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Blog <b class="caret"></b></a>
			  <ul class="dropdown-menu">
				<li <?php if($file_name=="blog"){echo 'class="active"';}?>><a href="blog.php">Blog</a></li>
				<li <?php if($file_name=="categories"){echo 'class="active"';}?>><a href="categories.php">Categories</a></li>
			  </ul>
			</li>
			<?php
			}
			if($prms_page_view == '1') { ?>		
			<li <?php if($file_name=="page"){echo 'class="active"';}?>> <a href="page.php">Pages</a></li>
			<?php
			}
			if($prms_menu_view == '1') { ?>
			<li <?php if($file_name=="menu"){echo 'class="active"';}?>> <a href="menu.php?position=header">Menus</a></li>
			<?php
			} ?>
			
			<?php
			if($admin_type == "super_admin") { ?>
			<li class="dropdown <?php if($file_name=="staff" || $file_name=="staff_group"){echo 'active';}?>">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Staffs <b class="caret"></b></a>
			  <ul class="dropdown-menu">
			  	<li <?php if($file_name=="staff"){echo 'class="active"';}?>> <a href="staff.php">Staffs</a></li>
			  	<li <?php if($file_name=="staff_group"){echo 'class="active"';}?>> <a href="staff_group.php">Staff Groups</a></li>
			  </ul>
			</li>
			<?php
			}
			if($prms_faq_view == '1') { ?>
			<li class="dropdown <?php if($file_name=="faqs_groups" || $file_name=="faqs"){echo 'active';}?>">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Faqs <b class="caret"></b></a>
			  <ul class="dropdown-menu">
			  	<li <?php if($file_name=="faqs_groups"){echo 'class="active"';}?>> <a href="faqs_groups.php">Faqs Groups</a></li>
			  	<li <?php if($file_name=="faqs"){echo 'class="active"';}?>> <a href="faqs.php">Faqs</a></li>
			  </ul>
			</li>
			<?php
			}
			
			if($prms_promocode_view == '1') { ?>
			<li <?php if($file_name=="promocode"){echo 'class="active"';}?>> <a href="promocode.php">Promo</a></li>
			<?php
			}
			
			if($prms_emailtmpl_view == '1') { ?>
			<li <?php if($file_name=="email_template"){echo 'class="active"';}?>> <a href="email_templates.php">Email Templates</a></li>
			<?php
			}
			
			if($prms_emailtmpl_view == '1') { ?>
			<li <?php if($file_name=="emailsms_history"){echo 'class="active"';}?>> <a href="emailsms_history.php">Email/SMS History</a></li>
			<?php
			}
				
			/*if($prms_promocode_view == '1' || $prms_emailtmpl_view == '1') { ?>
			<li class="dropdown <?php if($file_name=="promocode" || $file_name=="email_template"){echo 'active';}?>">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Others <b class="caret"></b></a>
			  <ul class="dropdown-menu">
			  	<?php
				if($prms_promocode_view == '1') { ?>
				<li <?php if($file_name=="promocode"){echo 'class="active"';}?>> <a href="promocode.php">Promo Codes</a></li>
				<?php
				}
				if($prms_emailtmpl_view == '1') { ?>
			    <li <?php if($file_name=="email_template"){echo 'class="active"';}?>> <a href="email_templates.php">Email Templates</a></li>
				<?php
				} ?>
			  </ul>
			</li>
			<?php
			}*/ ?>
		</ul>
    </div>
</nav>
