<?php
include("_config/config.php");
include("include/functions.php");

//Set pagination limit
if($_REQUEST['pagination_limit']>0) {
	$pagination_limit = $_REQUEST['pagination_limit'];
	$page_list_limit = $pagination_limit;
	$_SESSION['pagination_limit'] = $pagination_limit;
	setRedirect(SITE_URL.ltrim($_SERVER['SCRIPT_NAME'],'/'));
	exit();
} elseif($_SESSION['pagination_limit']>0) {
	$page_list_limit = $_SESSION['pagination_limit'];
} else {
	$_SESSION['pagination_limit'] = $page_list_limit;
}

//Get library for pagination
include("libraries/pagination/class.paginator.php");
$pages = new Paginator($page_list_limit,'p');

//If session expired then it will redirect to login page
if(empty($_SESSION['is_admin']) || empty($_SESSION['admin_username'])) {
    setRedirect(ADMIN_URL);
	exit();
} else {
	$admin_l_id = $_SESSION['admin_id'];
	$admin_type = $_SESSION['admin_type'];
	
	$query=mysqli_query($db,"SELECT * FROM admin WHERE id = '".$admin_l_id."'");
	$loggedin_user_data = mysqli_fetch_assoc($query);
	$loggedin_user_name = $loggedin_user_data['name'];
	
	//START access level based on loggedin user
	/*if($admin_type=="admin") {
		$access_file_name_array = array('general_settings','staff','location');
		if(in_array($file_name,$access_file_name_array)) {
			header('Location: profile.php');
			exit;
		}
	}*/

	$emp_g_query=mysqli_query($db,"SELECT eg.* FROM staff_groups AS eg WHERE eg.id='".$loggedin_user_data['group_id']."'");
	$staff_groups_data=mysqli_fetch_assoc($emp_g_query);

	if($admin_type=="super_admin") {
		$staff_permissions_data = json_decode('{"order_view":"1","order_add":"1","order_edit":"1","order_delete":"1","model_view":"1","model_add":"1","model_edit":"1","model_delete":"1","device_view":"1","device_add":"1","device_edit":"1","device_delete":"1","brand_view":"1","brand_add":"1","brand_edit":"1","brand_delete":"1","category_view":"1","category_add":"1","category_edit":"1","category_delete":"1","customer_view":"1","customer_add":"1","customer_edit":"1","customer_delete":"1","page_view":"1","page_add":"1","page_edit":"1","page_delete":"1","menu_view":"1","menu_add":"1","menu_edit":"1","menu_delete":"1","form_view":"1","form_add":"1","form_edit":"1","form_delete":"1","blog_view":"1","blog_add":"1","blog_edit":"1","blog_delete":"1","faq_view":"1","faq_add":"1","faq_edit":"1","faq_delete":"1","promocode_view":"1","promocode_add":"1","promocode_edit":"1","promocode_delete":"1","emailtmpl_view":"1","emailtmpl_add":"1","emailtmpl_edit":"1","emailtmpl_delete":"1"}', true);
	} else {
		$access_file_name_array = array('general_settings','staff');
		if(in_array($file_name,$access_file_name_array)) {
			header('Location: profile.php');
			exit;
		}
		$staff_permissions_data = json_decode($staff_groups_data['permissions'], true);
	}

	$prms_order_view = $staff_permissions_data['order_view'];
	$prms_order_add = $staff_permissions_data['order_add'];
	$prms_order_edit = $staff_permissions_data['order_edit'];
	$prms_order_delete = $staff_permissions_data['order_delete'];
	$prms_order_invoice = $staff_permissions_data['order_invoice'];
	$prms_model_view = $staff_permissions_data['model_view'];
	$prms_model_add = $staff_permissions_data['model_add'];
	$prms_model_edit = $staff_permissions_data['model_edit'];
	$prms_model_delete = $staff_permissions_data['model_delete'];
	$prms_device_view = $staff_permissions_data['device_view'];
	$prms_device_add = $staff_permissions_data['device_add'];
	$prms_device_edit = $staff_permissions_data['device_edit'];
	$prms_device_delete = $staff_permissions_data['device_delete'];
	$prms_brand_view = $staff_permissions_data['brand_view'];
	$prms_brand_add = $staff_permissions_data['brand_add'];
	$prms_brand_edit = $staff_permissions_data['brand_edit'];
	$prms_brand_delete = $staff_permissions_data['brand_delete'];
	$prms_category_view = $staff_permissions_data['category_view'];
	$prms_category_add = $staff_permissions_data['category_add'];
	$prms_category_edit = $staff_permissions_data['category_edit'];
	$prms_category_delete = $staff_permissions_data['category_delete'];
	$prms_customer_view = $staff_permissions_data['customer_view'];
	$prms_customer_add = $staff_permissions_data['customer_add'];
	$prms_customer_edit = $staff_permissions_data['customer_edit'];
	$prms_customer_delete = $staff_permissions_data['customer_delete'];
	$prms_page_view = $staff_permissions_data['page_view'];
	$prms_page_add = $staff_permissions_data['page_add'];
	$prms_page_edit = $staff_permissions_data['page_edit'];
	$prms_page_delete = $staff_permissions_data['page_delete'];
	$prms_menu_view = $staff_permissions_data['menu_view'];
	$prms_menu_add = $staff_permissions_data['menu_add'];
	$prms_menu_edit = $staff_permissions_data['menu_edit'];
	$prms_menu_delete = $staff_permissions_data['menu_delete'];
	$prms_form_view = $staff_permissions_data['form_view'];
	$prms_form_add = $staff_permissions_data['form_add'];
	$prms_form_edit = $staff_permissions_data['form_edit'];
	$prms_form_delete = $staff_permissions_data['form_delete'];
	$prms_blog_view = $staff_permissions_data['blog_view'];
	$prms_blog_add = $staff_permissions_data['blog_add'];
	$prms_blog_edit = $staff_permissions_data['blog_edit'];
	$prms_blog_delete = $staff_permissions_data['blog_delete'];
	$prms_faq_view = $staff_permissions_data['faq_view'];
	$prms_faq_add = $staff_permissions_data['faq_add'];
	$prms_faq_edit = $staff_permissions_data['faq_edit'];
	$prms_faq_delete = $staff_permissions_data['faq_delete'];
	$prms_promocode_view = $staff_permissions_data['promocode_view'];
	$prms_promocode_add = $staff_permissions_data['promocode_add'];
	$prms_promocode_edit = $staff_permissions_data['promocode_edit'];
	$prms_promocode_delete = $staff_permissions_data['promocode_delete'];
	$prms_emailtmpl_view = $staff_permissions_data['emailtmpl_view'];
	$prms_emailtmpl_add = $staff_permissions_data['emailtmpl_add'];
	$prms_emailtmpl_edit = $staff_permissions_data['emailtmpl_edit'];
	$prms_emailtmpl_delete = $staff_permissions_data['emailtmpl_delete'];
	/*$prms_contractor_view = $staff_permissions_data['contractor_view'];
	$prms_contractor_add = $staff_permissions_data['contractor_add'];
	$prms_contractor_edit = $staff_permissions_data['contractor_edit'];
	$prms_contractor_delete = $staff_permissions_data['contractor_delete'];
	$prms_invoice_view = $staff_permissions_data['invoice_view'];
	$prms_invoice_add = $staff_permissions_data['invoice_add'];
	$prms_invoice_edit = $staff_permissions_data['invoice_edit'];
	$prms_invoice_delete = $staff_permissions_data['invoice_delete'];*/
	
	$access_file_name_array = array();
	if($prms_order_view!='1') {
		$access_file_name_array[] = 'appointments';
	}
	if($prms_category_view!='1') {
		$access_file_name_array[] = 'device_categories';
	}
	if($prms_brand_view!='1') {
		$access_file_name_array[] = 'brand';
	}
	if($prms_device_view!='1') {
		$access_file_name_array[] = 'device';
	}
	if($prms_model_view!='1') {
		$access_file_name_array[] = 'mobile';
		$access_file_name_array[] = 'groups';
	}
	if($prms_customer_view!='1') {
		$access_file_name_array[] = 'users';
	}
	if($prms_page_view!='1') {
		$access_file_name_array[] = 'page';
	}
	if($prms_menu_view!='1') {
		$access_file_name_array[] = 'menu';
	}
	if($prms_form_view!='1') {
		$access_file_name_array[] = 'contact';
		$access_file_name_array[] = 'review';
		$access_file_name_array[] = 'bulk_order';
		$access_file_name_array[] = 'affiliate';
		$access_file_name_array[] = 'newsletter';
	}
	if($prms_blog_view!='1') {
		$access_file_name_array[] = 'blog';
	}
	if($prms_faq_view!='1') {
		$access_file_name_array[] = 'faqs';
	}
	if($prms_promocode_view!='1') {
		$access_file_name_array[] = 'promocode';
	}
	if($prms_emailtmpl_view!='1') {
		$access_file_name_array[] = 'email_template';
	}
	/*if($prms_invoice_view!='1') {
		$access_file_name_array[] = 'invoice_list';
	}*/
	
	if($file_name!="" && in_array($file_name,$access_file_name_array)) {
		header('Location: profile.php');
		exit;
	} //END access level based on loggedin user
} ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="description" content="Admin Panel" />
<title><?=ucfirst(str_replace('_',' ',$file_name))?> | Admin Panel</title>

<!-- jQuery TagsInput Styles -->
<link rel='stylesheet' type='text/css' href='<?=ADMIN_URL?>css/plugins/jquery.tagsinput.css'>

<!-- jQuery prettyCheckable Styles -->
<link rel='stylesheet' type='text/css' href='<?=ADMIN_URL?>css/plugins/prettyCheckable.css'>

<!-- jQuery jWYSIWYG Styles -->
<link rel='stylesheet' type='text/css' href='<?=ADMIN_URL?>css/plugins/jquery.jwysiwyg.css'>

<!-- Bootstrap wysihtml5 Styles -->
<link rel='stylesheet' type='text/css' href='<?=ADMIN_URL?>css/plugins/bootstrap-wysihtml5.css'>

<!-- Date range picker Styles -->
<link rel='stylesheet' type='text/css' href='<?=ADMIN_URL?>css/plugins/daterangepicker.css'>

<!-- Bootstrap Timepicker Styles -->
<link rel='stylesheet' type='text/css' href='<?=ADMIN_URL?>css/plugins/bootstrap-timepicker.css'>

<!-- Styles -->
<link rel='stylesheet' type='text/css' href='<?=ADMIN_URL?>css/sangoma-red.css'>

<link rel="stylesheet" href="<?=ADMIN_URL?>css/intlTelInput.css">

<link rel="stylesheet" href="<?=ADMIN_URL?>css/select2.min.css">

<link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet"> 

<!-- JS Libs -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/libs/jquery.js"><\/script>')</script>

<script src="<?=ADMIN_URL?>js/libs/modernizr.js"></script>
<script src="<?=ADMIN_URL?>js/libs/selectivizr.js"></script>

<script>
$(document).ready(function(){

	// Tooltips
	$('[title]').tooltip({
		placement: 'top',
		container: 'body'
	});

	// Tabs
	$('.demoTabs a').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
	})

});
</script>

<script src="<?=ADMIN_URL?>js/select2.min.js"></script>
</head>

<body>
