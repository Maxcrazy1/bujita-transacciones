<!DOCTYPE html>
<!-- saved from url=(0053) -->
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

  <!-- Required meta tags -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="keywords" content="<?= $meta_keywords ?>" />
  <meta name="description" content="<?= $meta_desc ?>" />
  <title><?= $meta_title ?></title>

  <!-- Bootstrap CSS -->
  <link type="text/css" rel="stylesheet" href="<?= SITE_URL ?>css/style.css">
  <link type="text/css" rel="stylesheet" href="<?= SITE_URL ?>css/custom.css">

  <link rel="stylesheet" type="text/css" title="stylesheet" href="<?= SITE_URL ?>css/intlTelInput.css">
  <link rel="stylesheet" type="text/css" title="stylesheet" href="<?= SITE_URL ?>css/bootstrapValidator.min.css">

  <script src="<?= SITE_URL ?>js/jquery.min.js" type="text/javascript"></script>
  <script src='https://www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit'></script>

  <?php
  //Start for custom JS code
  echo $custom_js_code;
  if ($url_first_param == "place-order" && $url_second_param != '' && $order_tracking_tag_code != "") {
    echo $order_tracking_tag_code;
  } //END for custom JS code 
  ?>
  <?php header('Referrer-Policy: origin');?>
  <?php
  require_once("include/custom_js.php"); ?>
</head>

<body class="">

  <?php
  //START for confirm message
  $confirm_message = getConfirmMessage()['msg'];
  echo $confirm_message;
  //END for confirm message 
  ?>

  <?php
  if ($newslettter_section == '1' && ($url_first_param == "" || $url_first_param == "offers")) {
    echo '<button class="myNewsletter" type="button" data-toggle="modal" data-target="#NewsLetter"><i class="fa fa-caret-down"></i>Newsletter</button>';
  } ?>

  <header>
    <div id="top">
      <div class="container">
        <div class="row">
          <div class="col-6 col-sm-3 col-md-4 col-lg-3 col-xl-3 mobile-logo">
            <div class="block logo pr-0 pt-0 mr-0 pb-0 clearfix">
              <a href="<?= SITE_URL ?>"><img src="<?= $logo_url ?>" alt="1GuyGadget"></a>
            </div>
          </div>
          <div class="col-3 col-sm-6 col-md-4 col-lg-6 col-xl-6 mobile-nav">
            <div class="block main-menu clearfix">
              <nav class="navbar navbar-expand-lg">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                  <img src="<?= SITE_URL ?>images/nav-bar.png" alt="">
                </button>
                <?php
                //START for header main menu
                if ($is_act_header_menu == '1') {
                  $header_menu_list = get_menu_list('header');
                  if (!empty($header_menu_list)) { ?>
                    <div class="collapse navbar-collapse" id="navbarMain">
                      <ul>
                        <?php
                        foreach ($header_menu_list as $header_menu_data) {
                          $is_open_new_window = $header_menu_data['is_open_new_window'];
                          if ($header_menu_data['page_id'] > 0) {
                            $menu_url = $header_menu_data['p_url'];
                            $is_custom_url = $header_menu_data['p_is_custom_url'];
                          } else {
                            $menu_url = $header_menu_data['url'];
                            $is_custom_url = $header_menu_data['is_custom_url'];
                          }

                          $menu_url = ($is_custom_url > 0 ? $menu_url : SITE_URL . $menu_url);
                          $is_open_new_window = ($is_open_new_window > 0 ? 'target="_blank"' : '');

                          $menu_fa_icon = "";
                          if ($header_menu_data['css_menu_fa_icon']) {
                            $menu_fa_icon = '<span class="' . $header_menu_data['css_menu_fa_icon'] . '"></span>';
                          } ?>

                          <li class="<?= (count($header_menu_data['submenu']) > 0 ? 'dropdown' : '') ?>">
                            <?php
                            if (count($header_menu_data['submenu']) <= 0) { ?>
                              <a href="<?= $menu_url ?>" class="<?= ($header_menu_data['css_menu_class'] != '' ? $header_menu_data['css_menu_class'] : '') . ($header_menu_data['id'] == $active_page_data['menu_id'] || $header_menu_data['id'] == $active_page_data['parent_menu_id'] ? ' active' : '') ?>" <?= $is_open_new_window ?>><?= $menu_fa_icon . $header_menu_data['menu_name'] ?></a>
                            <?php
                            } elseif (count($header_menu_data['submenu']) > 0) {
                              $header_submenu_list = $header_menu_data['submenu']; ?>
                              <a href="<?= $menu_url ?>" class="<?= ($header_menu_data['css_menu_class'] != '' ? $header_menu_data['css_menu_class'] : '') . ($header_menu_data['id'] == $active_page_data['menu_id'] || $header_menu_data['id'] == $active_page_data['parent_menu_id'] ? ' active' : '') ?>" <?= $is_open_new_window ?> data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= $header_menu_data['menu_name'] ?> <i class="fas fa-chevron-down"></i></a>
                              <div class="clearfix"></div>
                              <ul class="dropdown-menu">
                                <?php
                                foreach ($header_submenu_list as $header_submenu_data) {
                                  $s_is_open_new_window = $header_submenu_data['is_open_new_window'];
                                  if ($header_submenu_data['page_id'] > 0) {
                                    $s_is_custom_url = $header_submenu_data['p_is_custom_url'];
                                    $s_menu_url = $header_submenu_data['p_url'];
                                  } else {
                                    $s_menu_url = $header_submenu_data['url'];
                                    $s_is_custom_url = $header_submenu_data['is_custom_url'];
                                  }
                                  $s_menu_url = ($s_is_custom_url > 0 ? $s_menu_url : SITE_URL . $s_menu_url);
                                  $s_is_open_new_window = ($s_is_open_new_window > 0 ? 'target="_blank"' : '');

                                  $submenu_fa_icon = "";
                                  if ($header_submenu_data['css_menu_fa_icon']) {
                                    $submenu_fa_icon = '<span class="' . $header_submenu_data['css_menu_fa_icon'] . '"></span>';
                                  } ?>
                                  <li><a href="<?= $s_menu_url ?>" class="<?= $header_submenu_data['css_menu_class'] . ($header_submenu_data['id'] == $active_page_data['menu_id'] ? ' active' : '') ?>" <?= $s_is_open_new_window ?>><?= $submenu_fa_icon . $header_submenu_data['menu_name'] ?></a></li>
                                <?php
                                } ?>
                              </ul>
                            <?php
                            } ?>
                          </li>
                        <?php
                        } ?>
                        <?php
                        if ($_SESSION['user_id'] > 0) { ?>
                          <li class="mobile-menu">
                            <a href="<?= SITE_URL ?>account" class="login">Dashboard</a>
                          </li>
                        <?php
                        } else { ?>
                          <li class="mobile-menu">
                            <a href="<?= $login_link ?>" class="login">Login</a>
                          </li>
                        <?php
                        } ?>
                      </ul>
                    </div>
                  <?php
                  }
                } ?>
              </nav>
            </div>
          </div>
          <div class="col-3 col-sm-3 col-md-4 col-lg-3 col-xl-3 mobile-site-menu">
            <div class="block site-menu clearfix">
              <ul>
                <li>
                  <a href="<?= SITE_URL ?>revieworder" class="cart"><img src="<?= SITE_URL ?>images/icons/cart.png" alt="cart">Cart<span><?= $basket_item_count_sum_data['basket_item_count'] ?></span></a>
                </li>
                <?php
                if ($_SESSION['user_id'] > 0) { ?>
                  <li>
                    <a href="<?= SITE_URL ?>account" class="login">Dashboard</a>
                  </li>
                <?php
                } else { ?>
                  <li>
                    <a href="<?= $login_link ?>" class="login">Login</a>
                  </li>
                <?php
                } ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php
    if ($active_page_data['slug'] == 'home') { ?>
      <div id="showcase">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="block">
                <div id="showcaseSlider" class="carousel slide" data-ride="carousel">
                  <div class="carousel-inner">
                    <div class="carousel-item slide-text carousel-phone text-center active">
                      <!-- <div class="carousel-bg"></div> -->
                      <!-- <div class="row"> -->
                      <!-- <div class="col-md-12 col-lg-7 col-xl-7 slide-text"> -->
                      <!-- <div class="col-md-12"> -->
                      <h1 class="h1">Sell your used and unused<br />electronics at ease</h1>
                      <h3 class="h3">WE BUY FOR <span class="percantage">5%</span> MORE THAN<br />ANY COMPETITOR<br /><span class="brand_text">GUARANTEED</span></h3>
                      <p><a class="btn btn-primary" href="<?=SITE_URL?>device-type-or-brand">GET QUOTE NOW!</a></p>
                      <p class="image-left"><img src="<?= SITE_URL ?>images/slider/iphone.png" alt=""></p>
                      <p class="image-right"><img src="<?= SITE_URL ?>images/slider/Samsong_phone.png" alt=""></p>
                      <!-- </div> -->
                      <!-- <div class="col-md-12 col-lg-5 col-xl-5 slide-images">
                                    <img src="images/samsung.png" alt="">
                                    <img src="images/iphone.png" alt="">
                                  </div> -->
                      <!-- </div> -->
                    </div>
                    <!-- carousel-laptop -->
                    <div class="carousel-item carousel-laptop slide-text text-center">
                      <!-- <div class="carousel-bg"></div> -->
                      <!-- <div class="row"> -->
                      <!-- <div class="col-md-12 slide-text text-center"> -->
                      <h1 class="h1">Sell your used and unused<br />electronics at ease</h1>
                      <h3 class="h3">WE BUY FOR <span class="percantage">5%</span> MORE THAN<br />ANY COMPETITOR<br /><span class="brand_text">GUARANTEED</span></h3>
                      <p><a class="btn btn-primary" href="<?=SITE_URL?>device-type-or-brand">GET QUOTE NOW!</a></p>
                      <p class="image-left"><img src="<?= SITE_URL ?>images/slider/surface-pro-6-press-1200x630-c-ar1.91 copy.png" alt=""></p>
                      <p class="image-right"><img src="<?= SITE_URL ?>images/slider/MacBook-Pro-Transparent-Background-PNG copy.png" alt=""></p>
                      <!-- </div> -->
                      <!-- <div class="col-md-12 col-lg-7 col-xl-7 slide-text"> -->
                      <!-- <div class="col-md-12 slide-text text-center">
                                    <h1 class="h1">The more well-known message</h1>
                                    <h3 class="h3">WE BUY YOUR GADGET FOR <span>5%</span><br>MORE THAN ANY COMPETITOR GUARANTEED</h3>
                                    <p><a class="btn btn-primary" href="#">GET QUOTE NOW!</a></p>
                                  </div> -->
                      <!-- <div class="col-md-12 col-lg-5 col-xl-5 slide-images">
                                    <img src="images/laptop.png" alt=""> -->
                      <!-- <img src="images/iphone.png" alt=""> -->
                      <!-- </div> -->
                      <!-- </div> -->
                    </div>
                    <!-- carousel-watch -->
                    <div class="carousel-item slide-text carousel-watch text-center">
                      <!-- <div class="carousel-bg"></div> -->
                      <!-- <div class="row">
                                  <div class="col-md-12 slide-text text-center"> -->
                      <h1 class="h1">Sell your used and unused<br />electronics at ease</h1>
                      <h3 class="h3">WE BUY FOR <span class="percantage">5%</span> MORE THAN<br />ANY COMPETITOR<br /><span class="brand_text">GUARANTEED</span></h3>
                      <p><a class="btn btn-primary" href="<?=SITE_URL?>device-type-or-brand">GET QUOTE NOW!</a></p>
                      <p class="image-left"><img src="<?= SITE_URL ?>images/slider/gear-s2-personalize_modern_side copy.png" alt=""></p>
                      <p class="image-right"><img src="<?= SITE_URL ?>images/slider/42-alu-silver-sport-white-nc-s3-1up copy.png" alt=""></p>
                      <!-- </div> -->
                      <!-- <div class="col-md-12 col-lg-7 col-xl-7 slide-text"> -->
                      <!-- <div class="col-md-12 slide-text text-center">
                                    <h1 class="h1">The more well-known message</h1>
                                    <h3 class="h3">WE BUY YOUR GADGET FOR <span>5%</span><br>MORE THAN ANY COMPETITOR GUARANTEED</h3>
                                    <p><a class="btn btn-primary" href="#">GET QUOTE NOW!</a></p>
                                  </div> -->
                      <!-- <div class="col-md-12 col-lg-5 col-xl-5 slide-images">
                                    <img src="images/ipad-watch.png" alt=""> -->
                      <!-- <img src="images/iphone.png" alt=""> -->
                      <!-- </div> -->
                      <!-- </div> -->
                    </div>
                  </div>
                  <a class="carousel-control-prev arrow-box" href="#showcaseSlider" role="button" data-slide="prev">
                    <i class="fas fa-chevron-left"></i>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="carousel-control-next arrow-box" href="#showcaseSlider" role="button" data-slide="next">
                    <i class="fas fa-chevron-right"></i>
                    <span class="sr-only">Next</span>
                  </a>
                  <ol class="carousel-indicators">
                    <li data-target="#showcaseSlider" data-slide-to="0" class="active"></li>
                    <li data-target="#showcaseSlider" data-slide-to="1" class=""></li>
                    <li data-target="#showcaseSlider" data-slide-to="2" class=""></li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div id="how-to-sell">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="block how-to-sell clearfix">
                <a data-toggle="modal" data-target="#howToSell" href="javascript:void(0)">
                  <h3 class="h3">How to Sell<span>Here are some important things to note <img src="<?= SITE_URL ?>images/how-to-sell.png" alt=""></span></h3>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php
    } ?>
  </header>

  <?php
  if ($newslettter_section == '1') { ?>
    <div class="editAddress-modal newsletter-modal modal fade HelpPopup" id="NewsLetter" tabindex="-1" role="dialog" aria-labelledby="NewsLetter">
      <div class="modal-dialog" role="document">
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i></button>
        <div class="modal-content">
          <div class="modal-body">
            <form method="post" action="<?= SITE_URL ?>controllers/newsletter.php" id="newsletter">
              <div class="row">
                <div class="col-md-6">
                  <img class="privy-element privy-image-element" src="<?= SITE_URL ?><?= SITE_URL ?>images/newsletter_main_img.webp" style="max-width:100%">
                </div>
                <div class="col-md-6 text-center">
                  <h2><strong>Be the first to know</strong></h2>
                  <h3 class="mt-0 mb-5">Exclusive offer</h3>
                  <div class="borderbox lightpink newsletter_fields">
                    <div class="form-group">
                      <input type="text" name="first_name" id="first_name" placeholder="First Name" class="form-control" value="<?= $user_first_name ?>" required />
                    </div>
                    <div class="form-group">
                      <input type="text" name="last_name" id="last_name" placeholder="Last Name" class="form-control" value="<?= $user_last_name ?>" required />
                    </div>
                    <div class="form-group">
                      <input type="email" name="email" id="email" placeholder="Email" class="form-control" value="<?= $user_email ?>" required />
                    </div>

                    <?php
                    if ($contact_form_captcha == '1') { ?>
                      <div class="form-group site-gcaptcha clearfix">
                        <div id="nl_g_form_gcaptcha" style="transform:scale(0.8);transform-origin:0;-webkit-transform:scale(0.8);transform:scale(0.8);-webkit-transform-origin:0 0;transform-origin:0 0;"></div>
                        <input type="hidden" id="nl_g_captcha_token" name="nl_g_captcha_token" value="" />
                      </div>
                    <?php
                    } ?>

                    <?php
                    if ($newsletter_form_captcha == '1') { ?>
                      <script>
                        var CaptchaCallback = function() {
                          if (jQuery('#nl_g_form_gcaptcha').length) {
                            grecaptcha.render('nl_g_form_gcaptcha', {
                              'sitekey': '<?= $captcha_key ?>',
                              'callback': onNlSubmitForm,
                            });
                          }
                        };

                        var onNlSubmitForm = function(response) {
                          if (response.length == 0) {
                            jQuery("#nl_g_captcha_token").val('');
                          } else {
                            jQuery("#nl_g_captcha_token").val('yes');
                          }
                        };
                      </script>
                    <?php
                    } ?>

                    <div class="form-group">
                      <button type="submit" class="btn btn-block btn-general">Submit</button>
                      <input type="hidden" name="newsletter" id="newsletter" />
                    </div>
                  </div>
                  <div class="borderbox lightpink resp_newsletter" style="display:none;">
                    <div class="form-group">
                      <button type="button" class="btn btn-general close_newsletter_popup" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 text-center">
                  <p><small>We use email marketing to send you product / services updates and promotional offers. You may
                      withdraw your consent or manage your preferences at any time by clicking the unsubscribe link at
                      the bottom of any of our marketing emails, or by emailing us at <?= $site_email ?>.
                      You can view our Privacy Policy here. </small></p>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  <?php
  } ?>