<?php
//Get data from model
include("models/blog/blog.php"); ?>

<section class="blog clearfix">
  <div class="container">
    <div class="row">
      <div class="col-md-9">
        <?php
		//Get blog details based on slug of blog
		get_blog_details($blog_url);
		?>
      </div>
      <?php
	  if($blog_recent_posts == '1' || $blog_categories == '1') { ?>
      <div class="col-md-3">
        <div class="right-sidebar clearfix">
          <?php
		  //Get recent posts
		  get_recent_posts($blog_recent_posts);
		  
		  //Get Catgories
		  get_blog_categories($blog_categories); 
		  ?>
        </div>
      </div>
	  <?php
	  } ?>
    </div>
  </div>
</section>
