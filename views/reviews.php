<?php
//Get review list
$pagination = new Paginator($page_list_limit,'p');

$review_list_data = get_review_list_data(1,0,$page_list_limit);
$total_num_of_rev = count($review_list_data);

//Header Image
if($active_page_data['image'] != "") { ?>
	<section>
	  <div class="row">
		<?php
		if($active_page_data['image_text'] != "") {
			echo '<h2>'.$active_page_data['image_text'].'</h2>';
		} ?>
		<img src="<?=SITE_URL.'images/pages/'.$active_page_data['image']?>" alt="<?=$active_page_data['title']?>" width="100%">
	  </div>
	</section>
<?php
} ?>

<section>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="block head pb-0 mb-0 border-line text-center clearfix">
		  	<?php
	  	    if($active_page_data['show_title'] == '1') { ?>
            <h1 class="h1 border-line clearfix"><?=$active_page_data['title']?></h1>
			<?php
		    } ?>
			<?=($active_page_data['content']?'<p>'.$active_page_data['content'].'</p>':'')?>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="block content clearfix">
            <div class="row">
              <div class="col-md-7">
                <div class="review-list clearfix">
                  <h3><?php echo $LANG['Reviews']; ?></h3>
				  <?php
  				  if($total_num_of_rev > 0) {
				  	foreach($review_list_data as $key => $review_data) { ?>
					  <div class="reviews-block clearfix">
						<div class="review-star-block clearfix">
						  <p><span class="rating-star clearfix">
						  	<?php
							if($review_data['stars'] == '0.5' || $review_data['stars'] == '1') {
								echo '<a href="#"><i class="fas fa-star"></i></a>';
							} elseif($review_data['stars'] == '1.5' || $review_data['stars'] == '2') {
								echo '<a href="#"><i class="fas fa-star"></i></a><a href="#"><i class="fas fa-star"></i></a>';
							} elseif($review_data['stars'] == '2.5' || $review_data['stars'] == '3') {
								echo '<a href="#"><i class="fas fa-star"></i></a><a href="#"><i class="fas fa-star"></i></a><a href="#"><i class="fas fa-star"></i></a>';
							} elseif($review_data['stars'] == '3.5' || $review_data['stars'] == '4') {
								echo '<a href="#"><i class="fas fa-star"></i></a><a href="#"><i class="fas fa-star"></i></a><a href="#"><i class="fas fa-star"></i></a><a href="#"><i class="fas fa-star"></i></a>';
							} elseif($review_data['stars'] == '4.5' || $review_data['stars'] == '5') {
								echo '<a href="#"><i class="fas fa-star"></i></a><a href="#"><i class="fas fa-star"></i></a><a href="#"><i class="fas fa-star"></i></a><a href="#"><i class="fas fa-star"></i></a><a href="#"><i class="fas fa-star"></i></a>';
							} ?>
							</span>
							<?=$review_data['device_sold']?>
							<?php
							$review_website = $review_data['website'];
							if($review_website == "trustpilot") {
								echo '<img src="'.SITE_URL.'images/review_website/TrustPilot.png" width="100" alt="Trustpilot">';
							} elseif($review_website == "sitejabber") {
								echo '<img src="'.SITE_URL.'images/review_website/SiteJabber.png" width="100" alt="SiteJabber">';
							} elseif($review_website == "1guygadget") {
								echo '<img src="'.SITE_URL.'images/review_website/1GuyGadget.png" width="100" alt="1GuyGadget">';
							} elseif($review_website == "resellerratings") {
								echo '<img src="'.SITE_URL.'images/review_website/ResellerRatings.png" width="100" alt="ResellerRatings">';
							} elseif($review_website == "bbb") {
								echo '<img src="'.SITE_URL.'images/review_website/BBB.png" width="100" alt="BBB">';
							} ?>
						  </p>
						  <h4><strong><?=$review_data['name']?> (<?=$review_data['city']?>, <?=$review_data['state']?>)</strong> <?=date('F d, Y',strtotime($review_data['date']))?></h4>
						  <h5><?=$review_data['content']?></h5>
						</div>
					  </div>
                   <?php
				   }
				 } ?>
				  
				 <?php
				 echo $pagination->page_links(); ?>
                </div>
                
              </div>
              <div class="col-md-5">
                <div class="block contact-form review-form clearfix">
                  <h3><?php echo $LANG['Write a review']; ?></h3>
                  <form action="controllers/review_form.php" class="pb-5 mb-5" method="post" id="review_form" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="name"><?php echo $LANG['NAME']; ?></label>
                      <input type="text" name="name" id="name" class="form-control" />
                    </div>
                    <div class="form-group">
                      <label for="email"><?php echo $LANG['EMAIL']; ?></label>
                      <input type="email" name="email" id="email" class="form-control" />
                    </div>
					<div class="form-group">
                      <label for="phone"><?php echo $LANG['Phone']; ?></label>
                      <input type="tel" name="phone" id="phone" class="form-control" />
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-4">
                        <label for="city"><?php echo $LANG['City']; ?></label>
                        <input type="text" name="city" id="city" class="form-control" />
                      </div>
                      <div class="form-group col-md-4">
                        <label for="state"><?php echo $LANG['STATE']; ?></label>
                        <input type="text" name="state" id="state" class="form-control" />
                      </div>
                      <div class="form-group col-md-4">
                        <label for="zip_code"><?php echo $LANG['ZIP CODE']; ?></label>
                        <input type="text" class="form-control" name="zip_code" id="zip_code" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="device_sold"><?php echo $LANG['DEVICE SOLD']; ?></label>
                      <input type="text" class="form-control" name="device_sold" id="device_sold" />
                    </div>
                    <div class="form-group">
                      <label for="stars"><?php echo $LANG['RATING']; ?></label>
					  <select name="stars" id="stars" class="form-control">
						<option value=""> - <?php echo $LANG['Rating Star']; ?> - </option>
						<?php
						//for($si = 0.5; $si<= 5.0; $si=$si+0.5) {
						for($si = 1; $si<= 5.0; $si=$si+1) { ?>
							<option value="<?=$si?>"><?=$si?></option>
						<?php
						} ?>
					  </select>
                      <!--<div class="rating-star clearfix">
                        <a href="#"><i class="fas fa-star"></i></a>
                        <a href="#"><i class="fas fa-star"></i></a>
                        <a href="#"><i class="fas fa-star"></i></a>
                        <a href="#"><i class="fas fa-star"></i></a>
                        <a href="#"><i class="fas fa-star"></i></a>
                      </div>-->
                    </div>
                    <div class="form-group">
                      <label for="content"><?php echo $LANG['COMMENT']; ?></label>
                      <textarea class="form-control" id="content" name="content" rows="3"></textarea>
                    </div>
					
					 <?php
					  if($write_review_form_captcha == '1') { ?>
					  <div class="form-group">
						<div id="g_form_gcaptcha"></div>
						<input type="hidden" id="g_captcha_token" name="g_captcha_token" value=""/>
					  </div>
					  <?php
					  } ?>
		  
                    <div class="clearfix"></div>
                    <button type="submit" class="btn btn-primary float-right"><?php echo $LANG['SUBMIT']; ?></button>
					<input type="hidden" name="submit_form" id="submit_form" />
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>

<script>
<?php
if($write_review_form_captcha == '1') { ?>
var CaptchaCallback = function() {
	if(jQuery('#g_form_gcaptcha').length) {
		grecaptcha.render('g_form_gcaptcha', {
			'sitekey' : '<?=$captcha_key?>',
			'callback' : onSubmitForm,
		});
	}
};

var onSubmitForm = function(response) {
	if(response.length == 0) {
		jQuery("#g_captcha_token").val('');
	} else {
		//$(".sbmt_button").removeAttr("disabled");
		jQuery("#g_captcha_token").val('yes');
	}
};
<?php
} ?>

(function( $ ) {
	$(function() {
		$('#review_form').bootstrapValidator({
			fields: {
				name: {
					validators: {
						stringLength: {
							min: 1,
						},
						notEmpty: {
							message: 'Please enter your name'
						}
					}
				},
				email: {
					validators: {
						notEmpty: {
							message: 'Please enter your email address'
						},
						emailAddress: {
							message: 'Please enter your valid email address'
						}
					}
				},
				phone: {
					validators: {
						stringLength: {
							min: 1,
						},
						notEmpty: {
							message: 'Please enter your phone'
						}
					}
				},
				city: {
					validators: {
						stringLength: {
							min: 1,
						},
						notEmpty: {
							message: 'Please enter your city'
						}
					}
				},
				state: {
					validators: {
						stringLength: {
							min: 1,
						},
						notEmpty: {
							message: 'Please enter your state'
						}
					}
				},
				zip_code: {
					validators: {
						stringLength: {
							min: 1,
						},
						notEmpty: {
							message: 'Please enter your zip code'
						}
					}
				},
				stars: {
					validators: {
						notEmpty: {
							message: 'Please select rating star'
						}
					}
				},
				device_sold: {
					validators: {
						notEmpty: {
							message: 'Please enter your device sold'
						}
					}
				},
				content: {
					validators: {
						notEmpty: {
							message: 'Please enter your content'
						}
					}
				}
			}
		}).on('success.form.bv', function(e) {
            $('#review_form').data('bootstrapValidator').resetForm();

            // Prevent form submission
            e.preventDefault();

            // Get the form instance
            var $form = $(e.target);

            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');

            // Use Ajax to submit form data
            $.post($form.attr('action'), $form.serialize(), function(result) {
                console.log(result);
            }, 'json');
        });
	});
})(jQuery);
</script>