<?php
if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off"){
    $redirect = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location:'.$redirect);
    exit();
}

require_once("admin/_config/config.php");
require_once("admin/include/functions.php");
require_once("libraries/pagination/class.paginator.php");
require(CP_ROOT_PATH."/lang/spanish.php");

$customer_timezone_data = get_customer_timezone();
//$customer_timezone = $customer_timezone_data['short_timezone'];
$customer_timezone = $customer_timezone_data['timezone'];

//START inbuild page url/link
$sell_my_mobile_link = SITE_URL.get_inbuild_page_url('sell-my-mobile');
$contact_link = SITE_URL.get_inbuild_page_url('contact');
$signup_link = SITE_URL.get_inbuild_page_url('signup');
$login_link = SITE_URL.get_inbuild_page_url('login');
$reviews_link = SITE_URL.get_inbuild_page_url('reviews');
$review_form_link = SITE_URL.get_inbuild_page_url('review-form');
//END inbuild page url/link

$request_uri = $_SERVER['REQUEST_URI'];
$user_id = $_SESSION['user_id'];
$order_id=$_SESSION['order_id'];
$order_item_ids = $_SESSION['order_item_ids'];
if(empty($order_item_ids))
	$order_item_ids = array();

//Get admin user data
$admin_user_data = get_admin_user_data();

//Get user data based on userID
$user_data = get_user_data($user_id);
$user_full_name = $user_data['name'];
$user_first_name = $user_data['first_name'];
$user_last_name = $user_data['last_name'];
$user_email = $user_data['email'];
$user_phone = $user_data['phone'];

//Get basket items data, count & sum of order
$basket_item_count_sum_data = get_basket_item_count_sum($order_id);

//START get url params
$path_info = parse_path();
$url_first_param = $path_info['call_parts'][0];
$url_second_param=@$path_info['call_parts'][1];
$url_third_param=@$path_info['call_parts'][2];
$url_four_param=@$path_info['call_parts'][3];
$url_five_param=@$path_info['call_parts'][4];
//END get url params

//START for get custom/inbuild page menu list
$p_query=mysqli_query($db,"SELECT p.*, m.id AS menu_id, m.parent AS parent_menu_id, m.url AS menu_url, m.menu_name FROM pages AS p LEFT JOIN menus AS m ON m.page_id=p.id WHERE p.published='1' AND p.url='".$url_first_param."' ORDER BY p.id, m.id ASC");
if($url_first_param=="") {
	$p_query=mysqli_query($db,"SELECT p.*, m.id AS menu_id, m.parent AS parent_menu_id, m.url AS menu_url, m.menu_name FROM pages AS p LEFT JOIN menus AS m ON m.page_id=p.id WHERE p.published='1' AND p.slug='home' ORDER BY p.id, m.id ASC");
}

$active_page_data=mysqli_fetch_assoc($p_query);
if($active_page_data['menu_id']<=0) {
	$active_page_data['menu_name'] = $active_page_data['title'];
}

$is_custom_or_inbuild_page = mysqli_num_rows($p_query);
if($is_custom_or_inbuild_page>0) {
	$page_url = $active_page_data['url'];
	$meta_title = $active_page_data['meta_title'];
	$meta_desc = $active_page_data['meta_desc'];
	$meta_keywords = $active_page_data['meta_keywords'];
	
	include("include/header.php");
	
	$inbuild_page_array = array('home','affiliates','contact','reviews','sell-my-mobile','signup','login','terms-and-conditions','review-form','bulk-order-form','order-track','offers');
	if(in_array($active_page_data['slug'],$inbuild_page_array)) {
		include 'views/'.str_replace('-','_',$active_page_data['slug']).'.php';
	} elseif(trim($active_page_data['cat_id'])>0) {
		$cat_id = $active_page_data['cat_id'];
		include 'views/mobile.php';
	} elseif(trim($active_page_data['device_id'])!='') {
		$devices_id = $active_page_data['device_id'];
		include 'views/mobile.php';
	} elseif($active_page_data['slug']=="blog") {
		$blog_url = trim($url_second_param);
		if($blog_url) {
			include 'views/blog/blog_view.php';
		} else {
			include 'views/blog/blog.php';
		}
	} else {
		include 'views/page.php';
	}
} //END for get custom/inbuild page menu list
else
{
	$other_single_page_array = array('revieworder','enterdetails','lost_password','reset_password','profile','account','change-password','search','brand','request_sales_pack','order_offer','print_sales_pack','pickup_sales_pack','verify_step3','verify_account','checkout','order-comlete','device-type-or-brand');

	//START for mobile models, mobile model detail page
	$device_single_data_resp = get_device_single_data($url_first_param);
	$brand_single_data_resp = get_brand_single_data_by_sef_url($url_second_param);
	if($brand_single_data_resp['num_of_brand']>0 && $device_single_data_resp['num_of_device']>0 && $url_first_param!="brand" && $url_second_param!="") {
		include 'views/device_brand.php';
	} elseif($brand_single_data_resp['num_of_brand']>0 && $url_first_param=="brand" && $url_second_param!="" && $url_third_param=="") {
		include 'views/brand.php';
	} elseif($brand_single_data_resp['num_of_brand']>0 && $url_first_param=="brand" && $url_second_param!="" && $url_third_param!="") {
		include 'views/brand_device.php';
	} elseif($device_single_data_resp['num_of_device']>0 && $url_third_param=="") {
		include 'views/mobile.php';
	} elseif($device_single_data_resp['num_of_device']>0 && $url_third_param!="") {
		include 'views/mobile_detail.php';
	} //END for mobile models, mobile model detail page

	//START for other menu
	elseif(in_array($url_first_param,$other_single_page_array)) {
		include 'views/'.str_replace('-','_',$url_first_param).'.php';
	} elseif($url_first_param=="device_category" && $url_second_param!='') {
		$category_id = $url_second_param;
		include 'views/device_category.php';
	} elseif($url_first_param=="place-order" && $url_second_param!='') {
		$order_id = $url_second_param;
		include 'views/place_order.php';
	} elseif($url_first_param=="category") {
		include 'views/blog/cat_view.php';
	} elseif($url_first_param=="offer-status") {
		include 'controllers/offer_status.php';
	} else {
		setRedirect(SITE_URL,$msg);
		exit();
	} //END for other menu
}

include("include/footer.php"); ?>