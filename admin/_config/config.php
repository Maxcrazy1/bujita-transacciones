<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
date_default_timezone_set("UTC");

$folder_name = "";
$folder_name = ($folder_name?"/".$folder_name:"");
define('CP_ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].$folder_name);
define('SITE_URL','https://'.$_SERVER['HTTP_HOST'].$folder_name.'/');
define('ADMIN_URL',SITE_URL.'admin/');

require(CP_ROOT_PATH."/admin/_config/connect_db.php");
require(CP_ROOT_PATH."/admin/_config/common.php");

$post = $_REQUEST;
$return_url = $_SERVER['HTTP_REFERER'];

if(!empty($_SERVER['HTTP_CLIENT_IP']))
	$user_ip = $_SERVER['HTTP_CLIENT_IP'];
else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
	$user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
else
	$user_ip = $_SERVER['REMOTE_ADDR'];

define('USER_IP',$user_ip);
?>