  <footer class="home">
    <div id="bottom">
      <div class="container">
        <div class="row">
          <div class="col-md-3 col-lg-3 col-xl-3">
            <div class="block customer-service head clearfix">
			  <?php
			  if($site_phone) { ?>
              	<div class="h3"><?php echo $LANG['PHONE']; ?></div>
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
              <div class="h3 border-line"><?php echo $LANG['EXTRAS']; ?></div>
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
              <div class="h3 border-line"><?php echo $LANG['CONNECT']; ?></div>
              <ul><?=$socials_link?></ul>
            </div>
		  <?php
		  } //END for socials link ?>
          </div>
          <div class="col-md-4 col-lg-3 col-xl-3">
            <div class="block content-text mb-0 clearfix">
              <img src="/images/logo.png" alt="">
              <form method="post" action="<?=SITE_URL?>controllers/newsletter.php" id="f_newsletter_form">
                <legend><?php echo $LANG['SUBSCRIBE']; ?></legend>
                <p><?php echo $LANG['Sign up to receive tips, news and offers']; ?><</p>
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
          <h5 class="modal-title" id="howToSellTitle"><i class="fas fa-info-circle"></i> <strong>CHECKS BEFORE SELLING YOUR DEVICE</strong></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <p><b>¿Tiene su dispositivo algún bloqueo de acceso de seguridad?</b></p>
          <p>Casi todos los dispositivos modernos vienen con algún tipo de bloqueo de acceso de seguridad. Los ordenadores  portátiles tienen cuentas de inicio de sesión de usuario, los dispositivos Android tienen bloqueos de activación de Google, los dispositivos Apple tienen bloqueos de iCloud, etc. Asegúrese de cerrar sesión en todas las cuentas y eliminar todos los bloqueos (si corresponde a su dispositivo) antes de enviarnos.</p>
          <p><strong>Ten en cuenta que:</strong>
            <ul style="list-style-type:disc; margin:20px;">
              <li>No compramos dispositivos que hayan sido reportados como perdidos o robados. Informaremos dichos dispositivos recibidos a las fuerzas del orden.</li>
              <li>No compramos dispositivos que no estén pagados o bajo contratos financieros que le prohíban vender su dispositivo.</li>
              <li>No compramos dispositivos con bloqueos de contraseña, activación y/o bloqueos de icloud.</li>
              <li>Usted será responsable del pago del envío de devolución si nos envía un dispositivo descrito.</li>
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
          <h5 class="modal-title" id="locationModalLabel"><strong>STARBUCKS COFFEE SHOPS</strong></h5>
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
	  <script src='https://cdnjs.cloudflare.com/ajax/libs/react/0.14.2/react.js'></script>
	<script src="https://demo10.macmetro.com/js/anim_button.js"></script>	
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