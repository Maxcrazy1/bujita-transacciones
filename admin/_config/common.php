<?php
$admin_query=mysqli_query($db,"SELECT username, email FROM admin WHERE type='super_admin' ORDER BY id DESC");
$admin_detail=mysqli_fetch_assoc($admin_query);

$gs_query=mysqli_query($db,'SELECT * FROM general_setting ORDER BY id DESC');
$general_setting_data=mysqli_fetch_assoc($gs_query);

$custom_js_code = $general_setting_data['custom_js_code'];
$order_tracking_tag_code = $general_setting_data['order_tracking_tag'];
$company_name = $general_setting_data['company_name'];
$company_address = $general_setting_data['company_address'];
$company_city = $general_setting_data['company_city'];
$company_state = $general_setting_data['company_state'];
$company_country = $general_setting_data['company_country'];
$company_zipcode = $general_setting_data['company_zipcode'];
$company_phone = $general_setting_data['company_phone'];
$other_settings = (array)json_decode($general_setting_data['other_settings']);
$display_department_specific_from_email_only_in_order = $general_setting_data['display_department_specific_from_email_only_in_order'];
$header_service_hours_text = $general_setting_data['header_service_hours_text'];
define('TIMEZONE',$general_setting_data['timezone']);

$amount_sign = '&#163;';
$top_seller_limit = ($general_setting_data['top_seller_limit']>0?$general_setting_data['top_seller_limit']:0);
$top_seller_mode = ($general_setting_data['top_seller_mode']?$general_setting_data['top_seller_mode']:'');
$fb_page_url = trim($general_setting_data['fb_page_url']);

$social_login = trim($general_setting_data['social_login']);
$social_login_option = trim($general_setting_data['social_login_option']);
$google_client_id = trim($general_setting_data['google_client_id']);
$google_client_secret = trim($general_setting_data['google_client_secret']);
$fb_app_id = trim($general_setting_data['fb_app_id']);
$fb_app_secret = trim($general_setting_data['fb_app_secret']);

$sms_sending_status = trim($general_setting_data['sms_sending_status']);

$disp_currency = $general_setting_data['disp_currency'];
$currency = @explode(",",$general_setting_data['currency']);
$currency_symbol = $currency[1];
if($general_setting_data['disp_currency']=="prefix")
	$amount_sign_with_prefix = $currency_symbol;
elseif($general_setting_data['disp_currency']=="postfix")
	$amount_sign_with_postfix = $currency_symbol;

$is_space_between_currency_symbol = $general_setting_data['is_space_between_currency_symbol'];
$thousand_separator = $general_setting_data['thousand_separator'];
$decimal_separator = $general_setting_data['decimal_separator'];
$decimal_number = $general_setting_data['decimal_number'];

$choosed_payment_option = (array)json_decode($general_setting_data['payment_option']);
$default_payment_option = $general_setting_data['default_payment_option'];
$recommended_payment_option = $general_setting_data['recommended_payment_option'];
$order_prefix = $general_setting_data['order_prefix'];
$display_terms_array = (array)json_decode($general_setting_data['display_terms']);
$choosed_sales_pack_array = (array)json_decode($general_setting_data['sales_pack']);

$page_list_limit = ($general_setting_data['page_list_limit']>5?$general_setting_data['page_list_limit']:5);
$blog_recent_posts = trim($general_setting_data['blog_recent_posts']);
$blog_categories = trim($general_setting_data['blog_categories']);
$blog_rm_words_limit = trim($general_setting_data['blog_rm_words_limit']);

define('ADMIN_PANEL_NAME',$general_setting_data['admin_panel_name']);
define('SITE_NAME',$general_setting_data['site_name']);
define('FROM_EMAIL',$general_setting_data['from_email']);
define('FROM_NAME',$general_setting_data['from_name']);

$logo_url = SITE_URL.'images/'.$general_setting_data['logo'];

$site_phone = $general_setting_data['phone'];
$site_email = $general_setting_data['email'];
$website = $general_setting_data['website'];
$copyright = $general_setting_data['copyright'];
$copyright = str_replace('{$year}',date("Y"),$copyright);
$theme_color_type = "green";//$general_setting_data['theme_option'];

$logo = '<img src="'.$logo_url.'" width="200">';

/*
$header_logo = '<html><head><meta name="viewport" content="width=device-width, initial-scale=1"><style>'
.'@import url("https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i&display=swap");.email-box{font-family:\'Montserrat\',sans-serif;font-size:1em;margin:0;padding:0;background-color:#f1f1f1;color:#000;width:100%}.email-container{width:80%;background:#1c1e23}.contact-table{padding:0em 1.5em}.social-table{padding:1.4em 2.5em}.phone{font-family:\'Montserrat\',sans-serif;font-size:1.5em;font-weight:600;color:#f1bb00;text-align:right;line-height:1.5}.phone-content{font-family:\'Montserrat\',sans-serif;font-size:1.4em;font-weight:400;color:white;text-align:left;line-height:1.5}.address{font-family:\'Montserrat\',sans-serif;font-size:1.5em;font-weight:600;color:#f1bb00;text-align:right;line-height:1.5}.address-content{font-family:\'Montserrat\',sans-serif;font-size:1.4em;font-weight:400;color:white;text-align:left;line-height:1.5}.logo{padding:1em 0 0.8em 2em;width:30%;text-align:left}.footer-content{font-family:\'Montserrat\',sans-serif;font-size:1em;font-weight:400;color:white;text-align:left}.email-content{padding:1.4em 2.5em;font-family:\'Montserrat\',sans-serif}.logo-img{width:85%}.social-img{width:50%;padding:0.5em 0 0.5em 3em}.contact-additional-info{padding:0.7em 0.4em 0.1em 0.4em;border-bottom:2px solid white}.contact-additional-info-box{padding:1em 0}.contact-additional-info-container{background:#f1bb00;padding:1em}.offer-summary-header{background:black;color:white;padding:0.6em;font-size:1.4em;font-family:\'Montserrat\',sans-serif}.contact-additional-info-1{padding:1em 0em 0.3em 0em;font-weight:bold;font-family:\'Montserrat\',sans-serif}.summary-content-container{vertical-align:baseline;padding:2em 1em;background:white}.offer-id{font-size:1.6em;font-family:\'Montserrat\',sans-serif;text-align:center}.offer-tip{text-align:center;color:gray}.summary-table-header{padding:2.5em 0.3em 0.2em 0.3em;border-bottom:2px solid #ccc;text-align:left}.summary-img{width:50px}.summary-device-name{font-weight:bold;color:#f1bb00;font-family:\'Montserrat\',sans-serif}.summary-device-attribute{font-weight:bold;color:gray;font-family:\'Montserrat\',sans-serif}.summary-device-quantity{text-align:center}.summary-total{-webkit-box-shadow:0 2px 4px rgba(0,0,0,0.2);-moz-box-shadow:0 2px 4px rgba(0,0,0,0.2);box-shadow:0 2px 4px rgba(0,0,0,0.2);padding:1em}.summary-total-header{text-align:left;border-bottom:2px solid #ccc;padding:0.3em 0.2em;font-family:\'Montserrat\',sans-serif}.summary-total-footer{text-align:left;border-top:2px solid #ccc;padding:0.3em 0.2em;color:gray;font-family:\'Montserrat\',sans-serif}.summary-total-field{padding:0.5em 0;color:gray}.summary-total-value{padding:0.5em 0;font-weight:bold;text-align:right;font-family:\'Montserrat\',sans-serif}.summary-device-edit-btn{background:gray;color:white;padding:0.2em 0.4em;text-decoration:none;border-radius:5px}.custom-table-2{background:black;color:white;width:100%}.table-2-header{background:#f1bb00;color:black;font-size:1.4em;padding:0.2em 0em;font-family:\'Montserrat\',sans-serif}.table-2-subheader{text-align:center;padding:1.2em 0em}.table-2-ulheader{text-align:left;color:#f1bb00;padding:1em 0em 0.5em 0em;font-size:1em;font-family:\'Montserrat\',sans-serif}.table-2-ul{list-style:square;color:#f1bb00;margin:0;padding:0;padding:0em 2em 0em 0em}.table-2-footer-img{padding-top:1em;padding-bottom:2em}.table-2-strong{background:#f1bb00;color:black;padding:0.05em 0.5em;border-radius:1em}.table-2-p{color:white;font-weight:100;margin:0.3em 0em;font-family:\'Montserrat\',sans-serif}.table2img{width:90%}.table-2-img{padding:3em;width:35%}.usps_logo{display:inline-block;background:white;border-radius:14px;padding:0.4em;margin:1em 0em 1em 0em}@media(max-width:1560px){.email-container{width:85%;background:#1c1e23}.contact-table{padding:1.4em 2.5em}.social-table{padding:1.4em 2.5em}.phone{font-family:\'Montserrat\',sans-serif;font-size:1.3em;font-weight:600;color:#f1bb00;text-align:right;line-height:1.5}.phone-content{font-family:\'Montserrat\',sans-serif;font-size:1.2em;font-weight:400;color:white;text-align:left;line-height:1.5}.address{font-family:\'Montserrat\',sans-serif;font-size:1.3em;font-weight:600;color:#f1bb00;text-align:right;line-height:1.5}.address-content{font-family:\'Montserrat\',sans-serif;font-size:1.2em;font-weight:400;color:white;text-align:left;line-height:1.5}.logo{padding:0.9em 0 0.7em 2em;width:30%;text-align:left}.footer-content{font-family:\'Montserrat\',sans-serif;font-size:1em;font-weight:400;color:white;text-align:left}.email-content{padding:1.4em 1.5em;font-family:\'Montserrat\',sans-serif}.logo-img{width:95%}.social-img{width:60%;padding:0.5em 0 0.5em 3em}.table-2-img{padding:1.5em;width:35%}.contact-additional-info-container{padding:1em}.summary-content-container{padding:1em 0.5em}.table-2-img{padding:0.5em;width:35%}.contact-additional-info-box{padding:1em 0}.contact-additional-info-container{padding:1em}.offer-summary-header{padding:0.6em;font-size:1em}.contact-additional-info-1{padding:0.5em 0em 0.1em 0em}.summary-content-container{padding:1em 0.5em}.offer-id{font-size:1em}.summary-table-header{padding:1em 0.3em 0.2em 0.3em}.summary-img{width:50px}.summary-device-name{font-size:1em}.summary-device-attribute{font-size:1em}.summary-total-header{font-size:1.2em;font-family:\'Montserrat\',sans-serif}.summary-total-footer{font-size:1.2em}.summary-total-field{font-size:1em}.summary-total-value{font-size:1em}.summary-device-edit-btn{font-size:1em}.table-2-header{font-size:1em;padding:0.2em 0em}.table-2-subheader{text-align:center;padding:1em 0em}.table-2-ulheader{text-align:left;color:#f1bb00;padding:1em 0em 0.5em 0em;font-size:1em}.table-2-ul{padding:0em 1em 0em 0em}.table-2-footer-img{padding-top:0.5em;padding-bottom:1em}.table-2-strong{padding:0.05em 0.5em;border-radius:1em}.table-2-p{font-weight:100;margin:0.3em 0em}.table-2-img{padding:2.5em;width:35%}.table2img{width:90%}.usps_logo{display:inline-block;background:white;border-radius:14px;padding:0.4em;margin:1em 0em 1em 0em}}@media(max-width:1224px){.email-box{font-family:\'Montserrat\',sans-serif;font-size:1em;margin:0;padding:0;background-color:#f1f1f1;color:#000;width:100%}.email-container{width:90%;background:#1c1e23}.contact-table{padding:1.4em 2.5em}.social-table{padding:1.4em 2.5em}.phone{font-family:\'Montserrat\',sans-serif;font-size:1.1em;font-weight:600;color:#f1bb00;text-align:right;line-height:1.5}.phone-content{font-family:\'Montserrat\',sans-serif;font-size:1em;font-weight:400;color:white;text-align:left;line-height:1.5}.address{font-family:\'Montserrat\',sans-serif;font-size:1.1em;font-weight:600;color:#f1bb00;text-align:right;line-height:1.5}.address-content{font-family:\'Montserrat\',sans-serif;font-size:1em;font-weight:400;color:white;text-align:left;line-height:1.5}.logo{padding:0.6em 0.5em 0.6em 1.5em;width:30%}.footer-content{font-family:\'Montserrat\',sans-serif;font-size:1em;font-weight:400;color:white;text-align:center}.email-content{padding:1em 1em;font-family:\'Montserrat\',sans-serif}.logo-img{width:100%}.social-img{width:43%;width:56%;padding:0.5em 0 0.5em 25px}.contact-additional-info-container{padding:1em}.summary-content-container{padding:1em 0.5em}.table-2-img{padding:0.5em;width:35%}.contact-additional-info-box{padding:1em 0}.contact-additional-info-container{padding:1em}.offer-summary-header{padding:0.6em;font-size:1em}.contact-additional-info-1{padding:0.5em 0em 0.1em 0em}.summary-content-container{padding:1em 0.5em}.offer-id{font-size:1em}.summary-table-header{padding:1em 0.3em 0.2em 0.3em}.summary-img{width:50px}.summary-device-name{font-size:1em}.summary-device-attribute{font-size:1em}.summary-total-header{font-size:1.2em;font-family:\'Montserrat\',sans-serif}.summary-total-footer{font-size:1.2em}.summary-total-field{font-size:1em}.summary-total-value{font-size:1em}.summary-device-edit-btn{font-size:1em}.table-2-header{font-size:1em;padding:0.2em 0em}.table-2-subheader{text-align:center;padding:1em 0em}.table-2-ulheader{text-align:left;color:#f1bb00;padding:1em 0em 0.5em 0em;font-size:1em}.table-2-ul{padding:0em 1em 0em 0em}.table-2-img{padding:1em;width:35%}.table-2-footer-img{padding-top:0.5em;padding-bottom:1em}.table-2-strong{padding:0.05em 0.5em;border-radius:1em}.table-2-p{font-weight:100;margin:0.3em 0em}.table2img{width:90%}.table-2-img{padding:2em;width:35%}.usps_logo{display:inline-block;background:white;border-radius:14px;padding:0.4em;margin:1em 0em 1em 0em}}@media(max-width:970px){.email-box{font-size:0.8em;width:100%}.email-container{width:95%;background:#1c1e23}.contact-table{padding:1.4em 2.5em}.social-table{padding:1.4em 2.5em}.phone{font-family:\'Montserrat\',sans-serif;font-size:1em;font-weight:600;color:#f1bb00;text-align:right;line-height:1.5}.phone-content{font-family:\'Montserrat\',sans-serif;font-size:0.9em;font-weight:400;color:white;text-align:left;line-height:1.5}.address{font-family:\'Montserrat\',sans-serif;font-size:1em;font-weight:600;color:#f1bb00;text-align:right;line-height:1.5}.address-content{font-family:\'Montserrat\',sans-serif;font-size:0.9em;font-weight:400;color:white;text-align:left;line-height:1.5}.logo{padding:0.3em 0 0.3em 1em;width:30%}.footer-content{font-family:\'Montserrat\',sans-serif;font-size:1em;font-weight:400;color:white;text-align:center}.email-content{padding:1em 1em;font-family:\'Montserrat\',sans-serif;max-width:650px;font-size:1em}.footer-content{padding:0.5em;font-family:\'Montserrat\',sans-serif;font-size:1em;font-weight:400;color:white;text-align:center}.contact-additional-info{padding:0.6em 0.3em 0.3em 0.3em;font-size:1em}.contact-additional-info-box{padding:0.5em 0.3em}.contact-additional-info-container{padding:0.4em}.offer-summary-header{padding:1em 0em;font-size:1em}.contact-additional-info-1{padding:0.5em 0em 0.25em 0em;font-size:1em}.contact-additional-detail{font-size:0.85em}.summary-content-container{padding:1.5em 1em}.offer-id{font-size:1em}.offer-tip{font-size:0.95em}.summary-table-header{padding:1em 0.3em 0.2em 0.3em;font-size:1em}.summary-img{width:45px}.summary-device-name{font-size:0.9em}.summary-device-attribute{font-size:0.8em}.summary-total-header{font-size:1.1em;font-family:\'Montserrat\',sans-serif}.summary-total-footer{font-size:1em}.summary-total-field{font-size:1em}.summary-total-value{font-size:1em}.summary-device-edit-btn{font-size:0.9em}.summary-device-quantity{font-size:0.9em}.summary-device-price{font-size:0.9em}.table-2-header{font-size:1.1em;padding:0.5em 0.1em}.table-2-subheader{text-align:center;padding:1em 0em;font-size:1em}.table-2-ulheader{text-align:left;color:#f1bb00;padding:0.5em 0em 0.3em 0em;font-size:1em}.table-2-ul{padding:0em 0.5em 0em 0em}.table-2-footer-img{padding-top:0.7em;padding-bottom:1.1em}.table-2-strong{padding:0.1em 0.3em;border-radius:1.1em}.table-2-p{font-weight:100;margin:0.5em 0em;font-size:1em}.table2img{width:85%}.table-2-img{padding:0.7em;width:35%}.usps_logo{display:inline-block;background:white;border-radius:14px;padding:0.4em;margin:0.3em 0em 1em 0em}}@media(max-width:854px){.email-container{width:100%;background:#1c1e23}.logo-img{width:75%}.social-img{width:55%;padding:0.2em 1em}.social-table{padding:0.6em}.contact-table{padding:0.4em 0.6em}.phone{font-size:1em;line-height:1.2}.phone-content{font-size:0.9em;line-height:1.2}.address{font-size:1em;line-height:1.2}.address-content{font-size:0.9em;line-height:1.2}.logo{padding:1em 0 1em 15px;width:35%}.email-content{padding:0.4em 0.25em;font-family:\'Montserrat\',sans-serif;max-width:650px;font-size:1em}.footer-content{padding:0.5em;font-family:\'Montserrat\',sans-serif;font-size:1em;font-weight:400;color:white;text-align:center}.contact-additional-info{padding:0.6em 0.3em 0.1em 0.3em;font-size:1em}.contact-additional-info-box{padding:0.5em 0.3em}.contact-additional-info-container{padding:0.4em}.offer-summary-header{padding:0.4em;font-size:1em}.contact-additional-info-1{padding:0.5em 0em 0.25em 0em;font-size:1em}.contact-additional-detail{font-size:0.85em}.summary-content-container{padding:1em 0.5em}.offer-id{font-size:1.1em}.offer-tip{font-size:0.95em}.summary-table-header{padding:1em 0.3em 0.2em 0.3em;font-size:0.9em}.summary-img{width:45px}.summary-device-name{font-size:0.9em}.summary-device-attribute{font-size:0.8em}.summary-total-header{font-size:1.1em;font-family:\'Montserrat\',sans-serif}.summary-total-footer{font-size:1em}.summary-total-field{font-size:1em}.summary-total-value{font-size:1em}.summary-device-edit-btn{font-size:0.9em}.summary-device-quantity{font-size:0.9em}.summary-device-price{font-size:0.9em}.table-2-header{font-size:1.1em;padding:0.5em 0.1em}.table-2-subheader{text-align:center;padding:0.8em 0em;font-size:1em}.table-2-ulheader{text-align:left;color:#f1bb00;padding:0.5em 0em 0.3em 0em;font-size:1em}.table-2-ul{padding:0em 0.5em 0em 0em}.table-2-footer-img{padding-top:0.7em;padding-bottom:1.1em}.table-2-strong{padding:0.1em 0.3em;border-radius:1em}.table-2-p{font-weight:100;margin:0.5em 0em;font-size:0.9em}.table2img{width:95%}.table-2-img{padding:0.7em;width:35%}.usps_logo{display:inline-block;background:white;border-radius:14px;padding:0.4em;margin:0.2em 0em 1em 0em}}@media(max-width:550px){.email-container{width:100%;background:#1c1e23}.logo-img{width:100%}.social-img{width:75%;padding:0.2em 1em}.social-table{padding:0.6em}.contact-table{padding:0.4em 0.6em}.phone{font-size:0.9em;line-height:1.2}.phone-content{font-size:0.8em;line-height:1.2}.address{font-size:0.9em;line-height:1.2}.address-content{font-size:0.8em;line-height:1.2}.logo{padding:1em 0 1em 15px;width:35%}.email-content{padding:0.4em 0.25em;font-family:\'Montserrat\',sans-serif;max-width:650px;font-size:0.9em}.footer-content{padding:0.5em;font-family:\'Montserrat\',sans-serif;font-size:0.95em;font-weight:400;color:white;text-align:center}.contact-additional-info{padding:0.2em 0.1em 0.1em 0.1em;font-size:1em}.contact-additional-info-box{padding:0.3em 0.2em}.contact-additional-info-container{padding:0.3em}.offer-summary-header{padding:0.3em;font-size:0.9em}.contact-additional-info-1{padding:0.4em 0em 0.2em 0em;font-size:1em}.contact-additional-detail{font-size:0.85em}.summary-content-container{padding:0.5em 0.3em}.offer-id{font-size:0.95em}.offer-tip{font-size:0.9em}.summary-table-header{padding:0.5em 0.3em 0.2em 0.3em;font-size:0.7em}.summary-img{width:40px}.summary-device-name{font-size:0.85em}.summary-device-attribute{font-size:0.75em}.summary-total-header{font-size:1.1em;font-family:\'Montserrat\',sans-serif}.summary-total-footer{font-size:1em}.summary-total-field{font-size:0.9em}.summary-total-value{font-size:0.9em}.summary-device-edit-btn{font-size:0.9em}.summary-device-quantity{font-size:0.8em}.summary-device-price{font-size:0.8em}.table-2-header{font-size:1.1em;padding:0.5em 0.1em}.table-2-subheader{text-align:center;padding:0.5em 0em;font-size:0.9em}.table-2-ulheader{text-align:left;color:#f1bb00;padding:0.3em 0em 0.2em 0em;font-size:0.9em}.table-2-ul{padding:0em 0.3em 0em 0em}.table-2-footer-img{padding-top:0.6em;padding-bottom:1.1em}.table-2-strong{padding:0.05em 0.3em;border-radius:1em}.table-2-p{font-weight:100;margin:0.3em 0em;font-size:0.9em}.table2img{width:90%}.table-2-img{padding:0.6em;width:33%}.usps_logo{display:inline-block;background:white;border-radius:14px;padding:0.4em;margin:0.1em 0em 1em 0em}}@media(max-width:466px){.email-container{width:100%;background:#1c1e23}.logo-img{width:95%}.social-img{width:65%;padding:0.1em 0 0 0.4em}.social-table{padding:0.4em}.contact-table{padding:0.2em 0.4em}.phone{font-size:0.8em;line-height:1.2}.phone-content{font-size:0.7em;line-height:1.2}.address{font-size:0.8em;line-height:1.2}.address-content{font-size:0.7em;line-height:1.2}.logo{padding:0.9em 0 0.9em 0.5em;width:35%}.email-content{padding:0.3em 0.2em;font-family:\'Montserrat\',sans-serif;max-width:650px;font-size:0.8em}.footer-content{padding:0.4em;font-family:\'Montserrat\',sans-serif;font-size:0.9em;font-weight:400;color:white;text-align:center}.contact-additional-info{padding:0.2em 0.1em 0.1em 0.1em;font-size:0.9em}.contact-additional-info-box{padding:0.25em 0}.contact-additional-info-container{padding:0.25em}.offer-summary-header{padding:0.25em;font-size:0.8em}.contact-additional-info-1{padding:0.3em 0em 0em 0em;font-size:0.9em}.contact-additional-detail{font-size:0.8em}.summary-content-container{padding:0.35em 0.25em}.offer-id{font-size:0.9em}.offer-tip{font-size:0.85em}.summary-table-header{padding:0.5em 0.3em 0.2em 0.3em;font-size:0.6em}.summary-img{width:30px}.summary-device-name{font-size:0.8em}.summary-device-attribute{font-size:0.8em}.summary-total-header{font-size:1em;font-family:\'Montserrat\',sans-serif}.summary-total-footer{font-size:0.9em}.summary-total-field{font-size:0.8em}.summary-total-value{font-size:0.8em}.summary-device-edit-btn{font-size:0.8em}.summary-device-quantity{font-size:0.7em}.summary-device-price{font-size:0.7em}.table-2-header{font-size:1em;padding:0.2em 0em}.table-2-subheader{text-align:center;padding:0.2em 0em;font-size:0.85em}.table-2-ulheader{text-align:left;color:#f1bb00;padding:0.2em 0em 0.1em 0em;font-size:0.85em}.table-2-ul{padding:0em 0.2em 0em 0em}.table-2-footer-img{padding-top:0.5em;padding-bottom:1em}.table-2-strong{padding:0.05em 0.3em;border-radius:1em}.table-2-p{font-weight:100;margin:0.3em 0em;font-size:0.8em}.table2img{width:85%}.table-2-img{padding:0.6em;width:30%}.usps_logo{display:inline-block;background:white;border-radius:14px;padding:0.4em;margin-bottom:1em}}@media(max-width:386px){.email-container{width:100%;background:#1c1e23}.logo-img{width:100%}.social-img{width:80%;padding:0.1em 0 0 0.4em}.social-table{padding:0.1em}.contact-table{padding:0.1em 0.1em}.phone{font-size:0.8em;line-height:1.2}.phone-content{font-size:0.7em;line-height:1.2}.address{font-size:0.8em;line-height:1.2}.address-content{font-size:0.7em;line-height:1.2}.logo{padding:0.1em 0 0.1em 0.3em;width:45%}.email-content{padding:0.3em 0.2em;font-family:\'Montserrat\',sans-serif;max-width:650px;font-size:0.7em}.footer-content{padding:0.4em;font-family:\'Montserrat\',sans-serif;font-size:0.8em;font-weight:400;color:white;text-align:center}.contact-additional-info{padding:0.2em 0.1em 0.1em 0.1em;font-size:0.8em}.contact-additional-info-box{padding:0.2em 0}.contact-additional-info-container{padding:0.2em}.offer-summary-header{padding:0.2em;font-size:0.7em}.contact-additional-info-1{padding:0.3em 0em 0em 0em;font-size:0.8em}.contact-additional-detail{font-size:0.7em}.summary-content-container{padding:0.3em 0.2em}.offer-id{font-size:0.9em}.offer-tip{font-size:0.8em}.summary-table-header{padding:0.5em 0.3em 0.2em 0.3em;font-size:0.5em}.summary-img{width:30px}.summary-device-name{font-size:0.7em}.summary-device-attribute{font-size:0.7em}.summary-total-header{font-size:1em;font-family:\'Montserrat\',sans-serif}.summary-total-footer{font-size:0.9em}.summary-total-field{font-size:0.8em}.summary-total-value{font-size:0.8em}.summary-device-edit-btn{font-size:0.8em}.summary-device-quantity{font-size:0.7em}.summary-device-price{font-size:0.7em}.table-2-header{font-size:1em;padding:0.2em 0em}.table-2-subheader{text-align:center;padding:0.2em 0em;font-size:0.8em}.table-2-ulheader{text-align:left;color:#f1bb00;padding:0.2em 0em 0.1em 0em;font-size:0.8em}.table-2-ul{padding:0em 0.2em 0em 0em}.table-2-footer-img{padding-top:0.5em;padding-bottom:1em}.table-2-strong{padding:0.05em 0.3em;border-radius:1em}.table-2-p{font-weight:100;margin:0.3em 0em;font-size:0.7em}.table2img{width:85%}.table-2-img{padding:0.5em;width:30%}.usps_logo{display:inline-block;background:white;border-radius:14px;padding:0.4em;margin-bottom:1em}}'

.'</style></head>';



$header_logo .= '<body style="font-family: \'Montserrat\', sans-serif;"><table cellpadding="0" cellspacing="0" border="0" class="email-box" ><tbody><tr><td align="center" style="padding:0"><table align="center" border="0" class="email-container" cellpadding="0" cellspacing="0">'	
	.'<thead style="background: #1c1e23;"><tr>'
		.'<th class="logo">'
			.'<img class="logo-img" src="'.SITE_URL.'images/logo.png">'
		.'</th>'
		.'<th>'
			.'<table border="0" align="right" class="contact-table">'
				.'<tr>'
					.'<th class="phone">PHONE</th>'
					.'<th class="phone-content">(904)-310-0080</th>'
				.'</tr>'
				.'<tr>'
					.'<th class="address">ADDRESS</th>'
					.'<th class="address-content">1629 N. LIBERTY ST. JACKSONVILLE, FL, 32206</th>'
				.'</tr>'
			.'</table>'
		.'</th>'
	.'</tr></thead>'
	.'<tbody style="font-family: \'Montserrat\', sans-serif;background-color: #f9f9f9;color: black;"><tr style="margin: 0;">'
		.'<td colspan="2" class="email-content" ><div>';
*/

//Emmanuel's $header_logo

$header_logo = '<html><head><meta name="viewport" content="width=device-width, initial-scale=1"><style>'
.'@import url("https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i&display=swap"); 
/*--- Preheader declaration in style block in addition to inline for Outlook */
.preheader { color: transparent; display: none !important; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0; }'.
'</style></head>';

$header_logo .= '<body><div class="preheader" style="color: transparent; display: none !important; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;">my_preheader</div><table cellspacing="0" cellpadding="0" style="font-family:\'Montserrat\',Helvetica,Roboto,Arial,sans-serif;font-size:1em;margin:0;padding:0;background-color:#f1f1f1;color:#000;width:100%">
<tbody>
	<tr>
		<td align="center" style="padding:0">
			<table cellspacing="0" cellpadding="0" style="border:1px solid #ddd;max-width:650px;width:100%">
				<tbody>
					<tr>
						<td style="text-align:left;background:#fff">
							<table cellspacing="0" cellpadding="0" style="padding-top:0px;padding-bottom:0px;width:100%">
								<tbody>
									<tr>
										<td>
											<table cellspacing="0" cellpadding="0" style="font-family:\'Montserrat\',Helvetica,Roboto,Arial,sans-serif; max-width:650px;width:100%;padding-top:0px;background:#ffffff;margin-bottom:0px!important;margin:0 auto;">
												<tbody>
													<tr style="background:#000000;">
														<td align="left" style="font-family:\'Montserrat\',Helvetica,Roboto,Arial,sans-serif; width:25%;padding-top:10px;padding-bottom:10px;padding-left:20px;padding-right:0px">
															<a style="border:none;"href="https://www.1guygadget.com" target="_blank">'.
															   '<img src="'.SITE_URL.'images/logo.png" width="auto" height="50" alt="1GuyGadget Logo" class="CToWUd">
															</a>
														</td>
														<td align="right" style="font-family:\'Montserrat\',Helvetica,Roboto,Arial,sans-serif; width:65%;padding-top:10px;padding-bottom:10px;padding-left:0px;padding-right:20px;font-size:17px;color:#f1bb00">
														<strong>PHONE</strong><br><a style="color:#fff;text-decoration:none" href="tel:+1-904-310-0080" target="_blank">'.$company_phone.'</a>
														</td>
													</tr>
												</tbody>
											</table>                                            
										</td>
									</tr>
									<tr>
										<td style="padding-top:15px;padding-left:20px;padding-right:20px">
											<table cellspacing="0" cellpadding="0" style="padding-top:0px;background:#ffffff;margin-top:0px!important;margin:20px auto">
												<tbody>
													<tr>
														<td>
															<table width="100%" style="padding-top:0px;padding-bottom:0px;font-size:18px">
																<tbody>
																	<tr>
																		<td>
																			<table width="100%" cellspacing="0" cellpadding="0">
																				<tbody>
																					<tr>
																						<td style="font-family:\'Montserrat\',Helvetica,Roboto,Arial,sans-serif; "><div>';

		
//START for footer social
$socials_link = '';
$fb_link = trim($general_setting_data['fb_link']);
$twitter_link = trim($general_setting_data['twitter_link']);
$linkedin_link = trim($general_setting_data['linkedin_link']);
$youtube_link = trim($general_setting_data['youtube_link']);
$msg_link = trim($general_setting_data['msg_link']);
$instagram_link = trim($general_setting_data['instagram_link']);


//Emmanuel's $footer_logo
$footer_logo =                                                                                     			 '</div></td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table cellspacing="0" cellpadding="0" style="max-width:650px;width:100%">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <table cellspacing="0" cellpadding="0" style="max-width:650px;width:100%;padding-top:0px;font-size:15px;text-align:center;margin-top:20px!important;margin-bottom:20px!important;margin:20px auto">
                                                    <tbody>
                                                        <tr>
                                                            <td style="font-family:\'Montserrat\',Helvetica,Roboto,Arial,sans-serif; padding:10px;color:#333">
                                                                <p>
                                                                    <a href= "#" style="text-decoration:none; color:#333">
                                                                      '.$company_name.' | '.
                                                                        $company_address.' | '.
                                                                        $company_city.', '.$company_state.' | '.
                                                                        $company_zipcode.'
                                                                    </a>
                                                                </p>
                                                                <p><i>If we served you right, refer someone to us!</i></p>
                                                                <a href="'.$fb_link.'" style="text-decoration:none" rel="noreferrer" target="_blank"><img src="'.SITE_URL.'images/fb1gg.png" alt="Facebook Page" width="32" height="32"></a> &nbsp;
                                                                <a href="'.$twitter_link.'" style="text-decoration:none" rel="noreferrer" target="_blank"><img src="'.SITE_URL.'images/twitter1gg.png" alt="Twitter Page" width="32" height="32"></a> &nbsp;
                                                                <a href="'.$instagram_link.'" style="text-decoration:none" rel="noreferrer" target="_blank"><img src="'.SITE_URL.'images/insta1gg.png" alt="Instagram Page" width="32" height="32"></a> &nbsp;
                                                                
                                                            </td>
                                                        </tr>
                                                        <tr align="center">
                                                            <td style="font-family:\'Montserrat\',Helvetica,Roboto,Arial,sans-serif; padding-top:15px;padding-bottom:10px"><a style="text-decoration:none;font-size:15px;color:#333" href="'.SITE_URL.'" target="_blank">&#169; 2018'.'&#45;'.date("Y").'<span>'.' '.$company_name.'</span>.com</a></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </body>
        </html>';

/*
$footer_logo = '</div></td>'
	.'</tr></tbody>'
	.'<tfoot style="background: #1c1e23;"><tr>'
		.'<td>'
				.'<table class="social-img" border="0" cellpadding="0" cellspacing="0">'
					.'<tr>'
						.'<td><a href="https://www.facebook.com"><img width="100%"  src="'.SITE_URL.'images/icons-facebook.png"></a></td>'
						.'<td><a href="https://www.twitter.com"><img width="100%" src="'.SITE_URL.'images/icons-twitter.png"></i></td>'						
						.'<td><a href="https://www.instagram.com"><img width="100%" src="'.SITE_URL.'images/icons-instagram.png"></a></td>'
					.'</tr>'
				.'</table>'
		.'</td>'
		.'<td class="footer-content" ><p style="display: inline-block;text-align: center;">If we served you right, refer someone to us! <br> &copy 2019 1GuyGadget.com</p>'
		.'</td>'
		.'</tr></tfoot>'
.'</table></td></tr></tbody></table></body></html>';		
*/

$admin_logo = '<img src="'.SITE_URL.'images/'.$general_setting_data['admin_logo'].'" width="200">';
		
//START for footer social
$socials_link = '';
$fb_link = trim($general_setting_data['fb_link']);
$twitter_link = trim($general_setting_data['twitter_link']);
$linkedin_link = trim($general_setting_data['linkedin_link']);
$youtube_link = trim($general_setting_data['youtube_link']);
$msg_link = trim($general_setting_data['msg_link']);
$instagram_link = trim($general_setting_data['instagram_link']);
if($twitter_link) {
	$socials_link .= '<li><a href="'.$twitter_link.'" class="support-fa"><i class="fab fa-twitter"></i>TWITTER</a></li>';
}
if($instagram_link) {
	$socials_link .= '<li><a href="'.$instagram_link.'" class="support-fa"><i class="fab fa-instagram"></i>INSTAGRAM</a></li>';
}
if($fb_link) {
	$socials_link .= '<li><a href="'.$fb_link.'" class="support-fa"><i class="fab fa-facebook-square"></i>FACEBOOK</a></li>';
}
if($linkedin_link) {
	$socials_link .= '<li><a href="'.$linkedin_link.'" class="support-fa"><i class="fa fa-linkedin"></i>LINKEDIN</a></li>';
}
if($youtube_link) {
	$socials_link .= '<li><a href="'.$youtube_link.'" class="support-fa"><i class="fa fa-youtube-square"></i>YOUTUBE</a></li>';
}
if($msg_link) {
	$socials_link .= '<li><a href="'.$msg_link.'" class="support-fa"><i class="fa fa-envelope-square"></i></a></li>';
} //END for footer social

$shipping_api = trim($general_setting_data['shipping_api']);
$shipment_generated_by_cust = trim($general_setting_data['shipment_generated_by_cust']);
$shipping_api_key = trim($general_setting_data['shipping_api_key']);
$shipping_api_secret = trim($general_setting_data['shipping_api_secret']);
$default_carrier_account = trim($general_setting_data['default_carrier_account']);
$carrier_account_id = trim($general_setting_data['carrier_account_id']);

$shipping_predefined_package = "";
if($carrier_account_id!="") {
	if($default_carrier_account == "usps") {
		$shipping_predefined_package = "SmallFlatRateBox";  //SmallFlatRateBox, MediumFlatRateBox, LargeFlatRateBox ...
	} elseif($default_carrier_account == "ups") {
		$shipping_predefined_package = "SmallExpressBox";  //SmallExpressBox, MediumExpressBox, LargeExpressBox ...
	} elseif($default_carrier_account == "fedex") {
		$shipping_predefined_package = "FedExSmallBox";  //FedExSmallBox, FedExMediumBox, FedExLargeBox, FedExExtraLargeBox ...
	} elseif($default_carrier_account == "dhl") {
		$shipping_predefined_package = "JumboBox";  //JumboBox, JuniorJumboBox ...
	}
}

$shipping_parcel_length = trim($general_setting_data['shipping_parcel_length']);
$shipping_parcel_width = trim($general_setting_data['shipping_parcel_width']);
$shipping_parcel_height = trim($general_setting_data['shipping_parcel_height']);
$shipping_parcel_weight = trim($general_setting_data['shipping_parcel_weight']);

$shipping_parcel_length = ($shipping_parcel_length?'10':'');
$shipping_parcel_width = ($shipping_parcel_width?'5':'');
$shipping_parcel_height = ($shipping_parcel_height?'3':'');
$shipping_parcel_weight = ($shipping_parcel_weight?'7':'');

$news_blog_link = $general_setting_data['news_blog_link'];
$news_blog_link_open = $general_setting_data['news_blog_link_open'];

$map_key = $general_setting_data['map_key'];

$order_expiring_days = $general_setting_data['order_expiring_days'];
$order_expired_days = $general_setting_data['order_expired_days'];
$order_expiring_days = ($order_expiring_days>0?$order_expiring_days:7);
$order_expired_days = ($order_expired_days>0?$order_expired_days:14);

// Offer popup related
$offer_popup_delay_time_in_ms = 0;
$offer_popup_delay_time = 1;
if($offer_popup_delay_time > 0) {
	$offer_popup_delay_time_in_ms = ($offer_popup_delay_time * 1000);
}
$allow_offer_popup = $general_setting_data['allow_offer_popup'];
$offer_popup_title = $general_setting_data['offer_popup_title'];
$offer_popup_content = $general_setting_data['offer_popup_content'];
$imei_api_key = $general_setting_data['imei_api_key'];
$newslettter_section = $other_settings['newslettter_section'];

$is_act_top_right_menu = $other_settings['top_right_menu'];
$is_act_header_menu = $other_settings['header_menu'];
$is_act_footer_menu_column1 = $other_settings['footer_menu_column1'];
$is_act_footer_menu_column2 = $other_settings['footer_menu_column2'];
$is_act_footer_menu_column3 = $other_settings['footer_menu_column3'];
$is_act_copyright_menu = $other_settings['copyright_menu'];
$show_model_storage = $other_settings['show_model_storage'];

$captcha_settings = (array)json_decode($general_setting_data['captcha_settings']);
$contact_form_captcha = '0';
$write_review_form_captcha = '0';
$bulk_order_form_captcha = '0';
$affiliate_form_captcha = '0';
//$appt_form_captcha = '0';
$login_form_captcha = '0';
$signup_form_captcha = '0';
//$contractor_form_captcha = '0';
$order_track_form_captcha = '0';
$newsletter_form_captcha = '0';
$missing_product_form_captcha = '0';
$imei_number_based_search_form_captcha = '0';
$captcha_key = $captcha_settings['captcha_key'];
$captcha_secret = $captcha_settings['captcha_secret'];
if($captcha_key!="" && $captcha_secret!="") {
	$contact_form_captcha = $captcha_settings['contact_form'];
	$write_review_form_captcha = $captcha_settings['write_review_form'];
	$bulk_order_form_captcha = $captcha_settings['bulk_order_form'];
	$affiliate_form_captcha = $captcha_settings['affiliate_form'];
	//$appt_form_captcha = $captcha_settings['appt_form'];
	$login_form_captcha = $captcha_settings['login_form'];
	$signup_form_captcha = $captcha_settings['signup_form'];
	//$contractor_form_captcha = $captcha_settings['contractor_form'];
	$order_track_form_captcha = $captcha_settings['order_track_form'];
	$newsletter_form_captcha = $captcha_settings['newsletter_form'];
	$missing_product_form_captcha = $captcha_settings['missing_product_form'];
	$imei_number_based_search_form_captcha = $captcha_settings['imei_number_based_search_form'];
}

$review_website_list = array('trustpilot'=>'Trustpilot', 'sitejabber'=>'SiteJabber', '1guygadget'=>'1GuyGadget', 'resellerratings'=>'ResellerRatings', 'bbb'=>'BBB');

//Library of SMTP method based send email
require(CP_ROOT_PATH."/libraries/PHPMailer/class.phpmailer.php");
require(CP_ROOT_PATH."/libraries/twilio/Services/Twilio.php");
require(CP_ROOT_PATH."/libraries/sendgrid-php/vendor/autoload.php");

$account_sid = $general_setting_data['twilio_ac_sid'];
$auth_token = $general_setting_data['twilio_ac_token'];
$sms_api = new Services_Twilio($account_sid, $auth_token);

//$order_status_list = array("submitted"=>"Submitted","expiring"=>"Expiring","received"=>"Received","problem"=>"Problem","completed"=>"Completed","returned"=>"Returned","awaiting_delivery"=>"Awaiting Delivery","expired"=>"Expired","processed"=>"Processed","rejected"=>"Rejected","cancelled"=>"Cancelled");
$order_status_list = array("awaiting_shipment"=>"Awaiting Shipment","shipped"=>"Shipped","delivered"=>"Delivered","returned_to_sender"=>"Returned To Sender","shipment_problem"=>"Shipment Problem","submitted"=>"Submitted","processing"=>"Processing","completed"=>"Completed","problem"=>"Problem","expired"=>"Expired","cancelled"=>"Cancelled");
$payment_method_list = array("paypal"=>"Paypal","bank"=>"Bank","bitcoin"=>"Bitcoin");

$countries_list = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
?>