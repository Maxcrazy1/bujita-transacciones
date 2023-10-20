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

$header_logo = '<html><head><meta name="viewport" content="width=device-width, initial-scale=1"><style>'
.'@import url("https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i&display=swap"); 
/*--- Preheader declaration in style block in addition to inline for Outlook */
.preheader { color: transparent; display: none !important; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0; }'.
'</style></head>';

$header_logo .= '<body><div class="preheader" style="color: transparent; display: none !important; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;"></div><table cellspacing="0" cellpadding="0" style="font-family:\'Montserrat\',Helvetica,Roboto,Arial,sans-serif;font-size:1em;margin:0;padding:0;background-color:#f1f1f1;color:#000;width:100%">
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
															<a style="border:none;"href="'.SITE_URL.'" target="_blank">'.
															   '<img src="'.SITE_URL.'images/logo.png" width="auto" height="50" alt=" Logo" class="CToWUd">
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
		.'<td class="footer-content" ><p style="display: inline-block;text-align: center;">If we served you right, refer someone to us! <br> &copy 2019 .com</p>'
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

$review_website_list = array('trustpilot'=>'Trustpilot', 'sitejabber'=>'SiteJabber', ''=>'', 'resellerratings'=>'ResellerRatings', 'bbb'=>'BBB');

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