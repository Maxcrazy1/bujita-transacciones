  <footer class="home">
    <div id="bottom">
      <div class="container">
        <div class="row">
          <div class="col-md-3 col-lg-3 col-xl-3">
            <div class="block customer-service head clearfix">
			  <?php
			  if($site_phone) { ?>
              	<div class="h3">PHONE</div>
              	<a href="tel:<?=$site_phone?>" class="phn-number"><?=$site_phone?></a>
			  <?php
			  }
			  
		      if($is_act_footer_menu_column1 == '1') {
			    //START for footer column1 menu
				$footer1_menu_list = get_menu_list('footer_column1');
				foreach($footer1_menu_list as $footer1_menu_data) {
				  $is_open_new_window = $footer1_menu_data['is_open_new_window'];
				  if($footer1_menu_data['page_id']>0) {
					  $menu_url = $footer1_menu_data['p_url'];
					  $is_custom_url = $footer1_menu_data['p_is_custom_url'];
				  } else {
					  $menu_url = $footer1_menu_data['url'];
					  $is_custom_url = $footer1_menu_data['is_custom_url'];
				  }
				
				  $menu_url = ($is_custom_url>0?$menu_url:SITE_URL.$menu_url);
				  $is_open_new_window = ($is_open_new_window>0?'target="_blank"':'');
				  
				  $menu_fa_icon = "";
				  if($footer1_menu_data['css_menu_fa_icon']) {
					  $menu_fa_icon = '&nbsp;<i class="'.$footer1_menu_data['css_menu_fa_icon'].'"></i>';
				  } ?>
					<a href="<?=$menu_url?>" class="<?=$footer1_menu_data['css_menu_class'].($footer1_menu_data['id']==$active_page_data['menu_id'] || $footer1_menu_data['id']==$active_page_data['parent_menu_id']?' active':'')?>" <?=$is_open_new_window?>><?=$footer1_menu_data['menu_name'].$menu_fa_icon?></a>
					<?php		
					if(count($footer1_menu_data['submenu'])>0) {
						$footer1_submenu_list = $footer1_menu_data['submenu']; ?>
						<ul class="sub-menu">
							<?php
							foreach($footer1_submenu_list as $footer1_submenu_data) {
								$s_is_open_new_window = $footer1_submenu_data['is_open_new_window'];
								if($footer1_submenu_data['page_id']>0) {
									$s_is_custom_url = $footer1_submenu_data['p_is_custom_url'];
									$s_menu_url = $footer1_submenu_data['p_url'];
								} else {
									$s_menu_url = $footer1_submenu_data['url'];
									$s_is_custom_url = $footer1_submenu_data['is_custom_url'];
								}
								$s_menu_url = ($s_is_custom_url>0?$s_menu_url:SITE_URL.$s_menu_url);
								$s_is_open_new_window = ($s_is_open_new_window>0?'target="_blank"':'');

								$submenu_fa_icon = "";
								if($footer1_menu_data['css_menu_fa_icon']) {
									$submenu_fa_icon = '&nbsp;<i class="'.$footer1_menu_data['css_menu_fa_icon'].'"></i>';
								} ?>
								<li><a href="<?=$s_menu_url?>" class="<?=$footer1_submenu_data['css_menu_class'].($footer1_submenu_data['id']==$active_page_data['menu_id']?'class="active"':'')?>" <?=$s_is_open_new_window?>><?=$footer1_submenu_data['menu_name'].$submenu_fa_icon?></a></li>
							<?php
							} ?>
						</ul>
					<?php
					}
				} //END for footer column1 menu
			  } ?>
            </div>
          </div>
          <div class="col-md-2 col-lg-3 col-xl-3">
		    <?php
			if($is_act_footer_menu_column2 == '1') { ?>
            <div class="block customer-service">
              <div class="h3 border-line">EXTRAS</div>
              <ul>
			  	<?php
				//START for footer column2 menu
				$footer2_menu_list = get_menu_list('footer_column2');
				foreach($footer2_menu_list as $footer2_menu_data) {
				  $is_open_new_window = $footer2_menu_data['is_open_new_window'];
				  if($footer2_menu_data['page_id']>0) {
					  $menu_url = $footer2_menu_data['p_url'];
					  $is_custom_url = $footer2_menu_data['p_is_custom_url'];
				  } else {
					  $menu_url = $footer2_menu_data['url'];
					  $is_custom_url = $footer2_menu_data['is_custom_url'];
				  }
				
				  $menu_url = ($is_custom_url>0?$menu_url:SITE_URL.$menu_url);
				  $is_open_new_window = ($is_open_new_window>0?'target="_blank"':'');
				  
				  $menu_fa_icon = "";
				  if($footer2_menu_data['css_menu_fa_icon']) {
					  $menu_fa_icon = '&nbsp;<i class="'.$footer2_menu_data['css_menu_fa_icon'].'"></i>';
				  } ?>
				  <li>
					<a href="<?=$menu_url?>" class="<?=$footer2_menu_data['css_menu_class'].($footer2_menu_data['id']==$active_page_data['menu_id'] || $footer2_menu_data['id']==$active_page_data['parent_menu_id']?' active':'')?>" <?=$is_open_new_window?>><?=$footer2_menu_data['menu_name']?></a>
					<?php		
					if(count($footer2_menu_data['submenu'])>0) {
						$footer2_submenu_list = $footer2_menu_data['submenu']; ?>
						<ul class="sub-menu">
							<?php
							foreach($footer2_submenu_list as $footer2_submenu_data) {
								$s_is_open_new_window = $footer2_submenu_data['is_open_new_window'];
								if($footer2_submenu_data['page_id']>0) {
									$s_is_custom_url = $footer2_submenu_data['p_is_custom_url'];
									$s_menu_url = $footer2_submenu_data['p_url'];
								} else {
									$s_menu_url = $footer2_submenu_data['url'];
									$s_is_custom_url = $footer2_submenu_data['is_custom_url'];
								}
								$s_menu_url = ($s_is_custom_url>0?$s_menu_url:SITE_URL.$s_menu_url);
								$s_is_open_new_window = ($s_is_open_new_window>0?'target="_blank"':'');
								
								$submenu_fa_icon = "";
								if($footer2_menu_data['css_menu_fa_icon']) {
									$submenu_fa_icon = '&nbsp;<i class="'.$footer2_menu_data['css_menu_fa_icon'].'"></i>';
								} ?>
								<li><a href="<?=$s_menu_url?>" class="<?=$footer2_submenu_data['css_menu_class'].($footer2_submenu_data['id']==$active_page_data['menu_id']?'class="active"':'')?>" <?=$s_is_open_new_window?>><i class="fas fa-chevron-right"></i> <?=$footer2_submenu_data['menu_name'].$submenu_fa_icon?></a></li>
							<?php
							} ?>
						</ul>
					<?php
					} ?>
				  </li>
				<?php
				} //END for footer column2 menu ?>
              </ul>
            </div>
			<?php
			} ?>
          </div>
          <div class="col-md-3 col-lg-3 col-xl-3">
		  <?php
		  //START for socials link
		  if($socials_link) { ?>
            <div class="block customer-service">
              <div class="h3 border-line">CONNECT</div>
              <ul><?=$socials_link?></ul>
            </div>
		  <?php
		  } //END for socials link ?>
          </div>
          <div class="col-md-4 col-lg-3 col-xl-3">
            <div class="block content-text mb-0 clearfix">
              <img src="https://demo10.macmetro.com/images/footer-logo.png" alt="">
              <form method="post" action="<?=SITE_URL?>controllers/newsletter.php" id="f_newsletter_form">
                <legend>SUBSCRIBE</legend>
                <p>Sign up to receive tips, news and offers</p>
                <div class="form-wrap">
                  <div class="form-group">
                    <input type="email" class="form-control" name="f_newsletter_email" id="f_newsletter_email" placeholder="name@example.com" autocomplete="off">
					 <small id="f_newsletter_email_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
                  </div>
				  <input type="hidden" name="newsletter" />
                  <button type="button" class="btn btn-primary f_newsletter_btn"><i class="far fa-envelope"></i></button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
	<?php
	if($copyright) { ?>
    <div id="copyright">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="block copyright"><?=$copyright?></div>
          </div>
        </div>
      </div>
    </div>
    <?php
	} ?>
  </footer>
  
  <?php
  if($socials_link && $active_page_data['slug'] == 'home') { ?>
  <div id="siteSiderMenu">
    <ul>
	  <?=str_replace('class="support-fa"','',$socials_link)?>
    </ul>
  </div>
  <?php
  } ?>
	
  <!-- Modal -->
  <div class="modal fade" id="howToSell" tabindex="-1" role="dialog" aria-labelledby="howToSellTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="howToSellTitle"><i class="fas fa-info-circle"></i> Things to Check Before you Sell Your Device</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <p><b> Does your device have a bad ESN or IMEI?</b></p>
          <p>An ESN/IMEI is associated with any device capable of connecting to a carrier's network. A bad ESN/IMEI can be due to many factors including a device (such as a phone, tablet, watch, etc.) currently being active on an account, reported Lost or Stolen, or with an
            unpaid balance due on the orginal owner's account.</p>
          <p>You can check the ESN/IMEI status of your device at <a href="https://swappa.com/esn" target="_blank">https://swappa.com/esn</a></p>
          <p>If your device is currently under a finance plan with any network carrier, ensure that it is paid off before shipping it to us.
          </p> 
          <p>After paying off your device, unlock it from your carrier to get the best offer! There will be a deduction of
            $50-$150 (depending on the network) from your offer if your device is locked. Unlock your device to get the best offer!
           </p>
          <p>If you’re unsure of the finance status of your phone, call your carrier.</p>
          <p><b> Does your device have any security access locks?</b></p>
          <p>Almost every modern device comes with a security access lock. Laptops have user login accounts, Android devices have Google Activation locks, Apple devices have iCloud locks etc. Be sure to sign out from all accounts and remove all locks (if applicable to your device) before shipping to us.</p>
          <p>Be advised that:
            <ul style="list-style-type:disc; margin:20px;">
              <li>We <b>do not</b> buy devices that have been reported lost or stolen. We will report such devices received to law enforcement.</li>
              <li>We <b>do not</b> buy devices that are not paid off or under financial contracts.</li>
              <li>We <b>do not</b> buy devices with password locks, activation and/or icloud locks.</li>
              <li>You will be responsible for the return shipping payment if you send us a device described in (2) and (3) above.</li>
            </ul>
          </p>
          
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="locationModal" tabindex="-1" role="dialog" aria-labelledby="locationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="locationModalLabel">STARBUCKS COFFEE SHOPS</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <?php
		$starbuck_location_list = get_starbuck_location_list();
		if(!empty($starbuck_location_list)) {
			foreach($starbuck_location_list as $starbuck_location_data) { ?>
				<p class="text-center address"><?='<strong>'.$starbuck_location_data['name']. '</strong><br />'.$starbuck_location_data['address'].''?><br /><a class="btn btn-primary" href="<?=$starbuck_location_data['map_link']?>" target="_blank">GET DIRECTIONS</a></p>
			<?php
			}
		} ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
        </div>
      </div>
    </div>
  </div>

	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<?php /*?><script src="<?=SITE_URL?>js/jquery-3.3.1.slim.min.js"></script><?php */?>
	<script src="https://demo10.macmetro.com/js/popper.min.js"></script>
	<script src="https://demo10.macmetro.com/js/bootstrap_4.3.1.min.js"></script>
	<script src="https://demo10.macmetro.com/js/script.js"></script>
	<script src="https://demo10.macmetro.com/js/jquery.autocomplete.min.js"></script>
	<script src="https://demo10.macmetro.com/js/intlTelInput.js"></script>
	<script src="https://demo10.macmetro.com/js/bootstrapvalidator.min.js"></script>
	<script src="https://demo10.macmetro.com/js/jquery.matchHeight-min.js"></script>

	<script>
	(function($) {

		$("#f_newsletter_email").on('blur keyup change paste', function(event) {
			var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
			var f_newsletter_email = document.getElementById("f_newsletter_email").value;
			if(f_newsletter_email == "") {
				$("#f_newsletter_email_error_msg").show().text('Please enter email address');
				return false;
			} else if(f_newsletter_email!='' && !f_newsletter_email.match(mailformat)) {
				$("#f_newsletter_email_error_msg").show().text('Please enter email address');
				return false;
			} else {
				$("#f_newsletter_email_error_msg").hide();
			}
		});

		$(".f_newsletter_btn").on("click", function() {
			var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
			var f_newsletter_email = document.getElementById("f_newsletter_email").value;
			if(f_newsletter_email == "") {
				$("#f_newsletter_email_error_msg").show().text('Please enter email address');
				return false;
			} else if(f_newsletter_email!='' && !f_newsletter_email.match(mailformat)) {
				$("#f_newsletter_email_error_msg").show().text('Please enter email address');
				return false;
			} else {
				$("#f_newsletter_email_error_msg").hide();
			}
			
			$("#f_newsletter_form").submit();
		});

		$('.srch_list_of_model').autocomplete({
			serviceUrl: '/ajax/get_autocomplete_data.php',
			onSelect: function(suggestion) {
				window.location.href = suggestion.url;
			},
			onHint: function (hint) {
				console.log("onHint");
			},
			onInvalidateSelection: function() {
				console.log("onInvalidateSelection");
			},
			onSearchStart: function(params) {
				console.log("onSearchStart");
			},
			onHide: function(container) {
				console.log("onHide");
			},
			onSearchComplete: function (query, suggestions) {
				console.log("onSearchComplete",suggestions);
			},
			showNoSuggestionNotice: true,
			noSuggestionNotice: "We didn't find any matching devices...",
		});

		$('.block.brands ul.box-styled li a').matchHeight();
	})(jQuery);
	</script>
  
</body>
</html>