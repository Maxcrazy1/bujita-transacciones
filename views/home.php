  <?php
  //START for "How its work steps" & Slider
  if($general_setting_data['home_slider']) {
    echo $general_setting_data['home_slider'];
  } //END for "How its work steps" & Slider ?>

  <section id="device-type" class="pb-5">
    <div class="container">
	
      <div class="row">
        <div class="col-md-12">
          <div class="block head text-center clearfix">
            <div class="h1 border-line mt-4 mb-5"><?php echo $LANG['CHOOSE YOUR DEVICE TYPE']; ?></div>
            <form class="form-inline" action="<?=SITE_URL?>search" method="post">
              <div class="form-group">
                <input type="text" class="form-control srch_list_of_model" name="search" id="staticEmail2" placeholder="<?php echo $LANG['Search device here']; ?>">
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
				<a href="<?=$device_data['sef_url']?>">
					<?php
					if($device_data['device_img']) {
						$device_img_path = 'https://cashmovil.es/images/device/'.$device_data['device_img'];
						echo '<img loading="lazy" src="'.$device_img_path.'" alt="'.$device_data['title'].'">';
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

  <?php
  //Get data from admin/include/functions.php, get_brand_data function
  $brand_data_list = get_brand_data();
  $num_of_brand = count($brand_data_list);
  if($num_of_brand>0) { ?>
  <section id="brands" class="pt-5 pb-5">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="block text-center head border-line mb-0 clearfix">
            <div class="h1"><?php echo $LANG['SELECT YOUR BRAND']; ?></div>
          </div>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="block brands clearfix">
            <ul class="brand_block">
				<?php
				foreach($brand_data_list as $brand_data) {
					$class = "";
					if($brand_data['title'] == "Samsung") {
						$class = " balance samsung";
					} elseif($brand_data['title'] == "Sony") {
						$class = " balance";
					} elseif($brand_data['title'] == "Microsoft") {
						$class = " balance samsung";
					} elseif($brand_data['title'] == "Xiaomi") {
						$class = " balance2";
					}
					echo '<li class="brand_block-cell'.$class.'"><a href="'.SITE_URL.'brand/'.$brand_data['sef_url'].'"><img loading="lazy" src="https://cashmovil.es/images/brand/'.$brand_data['image'].'" alt="'.$brand_data['title'].'"></a></li>';
				} ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>
  <?php
  } //END for brand section ?>
  
  <?php
   //Get review list
  $review_list_data = get_review_list_data(1,5);
  if(!empty($review_list_data)) { ?>
  <section id="feedback">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="block head border-line black-line mb-0 pb-2 text-center">
            <div class="h1 mt-5"><?php echo $LANG['WHAT OUR CUSTOMERS SAY']; ?></div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="block feedback pt-5 pb-5 text-center">
            <div id="feebackSlider" class="carousel slide" data-ride="carousel">
              <div class="carousel-inner">
			    <?php
				foreach($review_list_data as $key => $review_data) { ?>
                <div class="carousel-item <?=($key == '0'?'active':'')?>">
                  <div class="image">
				  <?php
				  if($review_data['photo']) {
					echo '<img loading="lazy" src="https://cashmovil.es/images/review/'.$review_data['photo'].'" alt="'.$review_data['name'].'">';
				  } else {
					echo '<img loading="lazy" src="https://cashmovil.es/images/Avatar.png" alt="'.$review_data['name'].'">';
				  } ?>
				  </div>
                  <div class="h4"><?=$review_data['name']?></div>
                  <p><?=$review_data['content']?></p>
                  <a href="#">
				  	<?php
					if($review_data['stars'] == '0.5' || $review_data['stars'] == '1') {
						echo '<i class="fas fa-star"></i>';
					} elseif($review_data['stars'] == '1.5' || $review_data['stars'] == '2') {
						echo '<i class="fas fa-star"></i><i class="fas fa-star"></i>';
					} elseif($review_data['stars'] == '2.5' || $review_data['stars'] == '3') {
						echo '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>';
					} elseif($review_data['stars'] == '3.5' || $review_data['stars'] == '4') {
						echo '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>';
					} elseif($review_data['stars'] == '4.5' || $review_data['stars'] == '5') {
						echo '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>';
					} ?>
				  </a>
                </div>
				<?php
				} ?>
              </div>
              <a class="carousel-control-prev arrow-box" href="#feebackSlider" role="button" data-slide="prev">
                <i class="fas fa-chevron-left"></i>
                <span class="sr-only"><?php echo $LANG['Previous']; ?></span>
              </a>
              <a class="carousel-control-next arrow-box" href="#feebackSlider" role="button" data-slide="next">
                  <i class="fas fa-chevron-right"></i>
                <span class="sr-only"><?php echo $LANG['Next']; ?></span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <?php
  } ?>
  
  <section>
    <div class="container">
      <div class="row">
        <div class="col-md-8">
          <div class="block about-head pt-4 mt-5 mb-4 pb-4 clearfix">
            <div class="row">
              <div class="col-md-5">
                <h1 class="text-uppercase text-center rating-head border-line"><?php echo $LANG['RATINGS']; ?></h1>
                <p class="text-center"><a class="trust_pilot" href="https://www.trustpilot.com/"><img class="trust_pilot" loading="lazy" src="https://cashmovil.es/images/Trustpilot_logo.png" alt=""></a></p>
              </div>
              <div class="col-md-7">
			    <?php
				if($active_page_data['title'] && $active_page_data['show_title'] == '1') {
				  echo '<div class="h1 border-line">'.$active_page_data['title'].'</div>';
				}
				if($active_page_data['content']) {
				  echo $active_page_data['content'];
				} ?>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="block about-why pt-md-4 mt-md-5 mb-md-4 pb-md-4 clearfix">
            <div class="h1 border-line"><?php echo $LANG['WHY US']; ?></div>
            <ul>
              <li>
                <img loading="lazy" src="https://cashmovil.es/images/wepayfirst.png" alt="" class="pa-ws"><br>
                <div class="yel-line"></div>
                <p><?php echo $LANG['We Pay Fast']; ?></p>
              </li>
              <li>
                <img loading="lazy" src="https://cashmovil.es/images/bestoffer.png" alt="" class="pa-ws"><br>
                <div class="yel-line"></div>
                <p><?php echo $LANG['Best offer']; ?></p>
              </li>
              <li>
                <img loading="lazy" src="https://cashmovil.es/images/trust.png" alt="" class="pa-ws"><br>
                <div class="yel-line"></div>
                <p><?php echo $LANG['Guaranteed']; ?></p>
              </li>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="subscribe" class="md-pt-5 md-pb-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-11">
          <div class="block">
            <div class="row">
              <div class="col-md-5">
                <div class="block we-offer clearfix">
                  <h3><?php echo $LANG['WE OFFER']; ?></h3>
                  <h4><span><?php echo $LANG['CASH ']; ?></span> <?php echo $LANG['PURCHASES WHEN YOU MEET UP IN PERSON WITHIN AUSTIN, TX.']; ?></h4>
                </div>
                <!-- <div class="block head border-line black-line clearfix">
                  <div class="h4">GET LATEST NEWS</div>
                  <div class="h5">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget
                    dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur
                    ridiculus mus. Donec quam releifend tellus.</div>
                </div> -->
              </div>
              <div class="col-md-7">
                <div class="block coffee-offer clearfix">
                  <div class="row">
                    <!-- <div class="col-md-4">
                      <img loading="lazy" src="https://cashmovil.es/images/Coffee.png" alt="">
                    </div> -->
                    <div class="col-md-12 text-center">
                      <a href="#" class="btn btn-secondary" data-toggle="modal" data-target="#locationModal"><?php  echo 'VER UBICACIONES' ; ?></a>
                      <h3 class="text-uppercase"><span><?php echo 'Reunase con un nuestro agente en una de nuestras oficinas autorizadas'; ?> <?php /*echo $LANG['FREE'];*/ ?></span> <?php /*echo $LANG['COFFE OR TEA']; ?><br><?php echo $LANG['WHEN YOU MEET US AT']; ?><br><?php echo $LANG['SELECT']; ?> <br><?php echo $LANG['STARBUCKS COFFEE']; echo $LANG['SHOPS']; */ ?> </h3>
                    </div>
                  </div>
                </div>
                <!-- <div class="block subscribe-form clearfix">
                  <form>
                    <div class="form-group">
                      <input type="text" class="form-control" id="staticEmail2" placeholder="email@example.com">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Subscribe</button>
                  </form>
                </div> -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>