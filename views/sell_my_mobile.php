<?php
if($active_page_data['image'] != "") { ?>
	<section>
		<div class="row">
			<?php
			if($active_page_data['image_text'] != "") {
				echo '<h2>'.$active_page_data['image_text'].'</h2>';
			} ?>
			<img src="<?='https://tasaciones-labrujita.online/images/pages/'.$active_page_data['image']?>" alt="<?=$active_page_data['title']?>" width="100%">
		</div>
	</section>
<?php
} ?>

  <section id="device-type" class="pb-5">
    <div class="container">
	
      <div class="row">
        <div class="col-md-12">
          <div class="block head text-center clearfix">
            <div class="h1 border-line mt-4 mb-5"><?php echo $LANG['CHOOSE YOUR DEVICE TYPE']; ?></div>
            <form class="form-inline" action="<?=SITE_URL?>search" method="post">
              <div class="form-group">
                <input type="text" class="form-control srch_list_of_model" name="search" id="staticEmail2" placeholder="Search for your device here by device name">
              </div>
              <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
            </form>
          </div>
        </div>
      </div>
	  
	  <?php
	  //Get data from admin/include/functions.php, get_popular_device_data function
	  $popular_device_data = get_popular_device_data();
	  $num_of_pop_device = count($popular_device_data);
	  if($num_of_pop_device>0) { ?>
	  <div class="row">
		<div class="col-md-12">
		  <div class="block device-blocks clearfix">
			<ul>
			<?php
			foreach($popular_device_data as $device_data) { ?>
			  <li>
				<a href="<?=SITE_URL.$device_data['sef_url']?>">
					<?php
					if($device_data['device_img']) {
						$device_img_path = 'https://tasaciones-labrujita.online/images/device/'.$device_data['device_img'];
						echo '<img src="'.$device_img_path.'" alt="'.$device_data['title'].'">';
					} ?>
				  <h5><?=$device_data['title']?></h5>
				</a>
			  </li>
			<?php
			} ?>
			</ul>
		  </div>
		</div>
	  </div>
	  <?php
	  } ?>
    </div>
  </section>