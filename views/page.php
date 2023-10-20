<?php
//Fetching data from model
require_once('models/page.php');

if($active_page_data['image'] != "") { ?>
  <section id="banner">
    <?php
    if($active_page_data['image_text'] != "") {
        echo '<h2>'.$active_page_data['image_text'].'</h2>';
    } ?>
    <img src="<?=SITE_URL.'images/pages/'.$active_page_data['image']?>" alt="<?=$active_page_data['title']?>" width="100%">
  </section>
<?php
} ?>

<section class="<?=$active_page_data['css_page_class']?>">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="block head pb-0 mb-0 border-line text-center clearfix">
			<?php
			if($active_page_data['show_title'] == '1') { ?>
            	<h1 class="h1 border-line clearfix"><?=$active_page_data['title']?></h1>
			<?php
			} ?>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="block pb-5 mb-5 clearfix">
            <?=$active_page_data['content']?>
          </div>
        </div>
      </div>
    </div>
</section>  