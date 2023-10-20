<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");

$email = $_REQUEST['email'];
$token = $_REQUEST['token'];
if($email!="" && $token!="") {
	$login_link = SITE_URL.get_inbuild_page_url('login');
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM `users` WHERE email='".$email."' AND email!=''");
	$user_data = mysqli_fetch_assoc($query);

	if(!empty($user_data) && $user_data['email']!="") {
		$response['msg'] = 'Email address been already been registered.<br>Please click <a href="'.$login_link.'"><strong>here</strong></a> to login';
		$response['exist'] = true;
	} else {
		$response['msg'] = "";
		$response['exist'] = false;
	}
	echo json_encode($response);
}
?>