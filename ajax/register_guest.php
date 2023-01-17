<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");

$email = $_REQUEST['email'];
$password = $_REQUEST['password'];
$token = $_REQUEST['token'];
// && $password!=""
if($email!="" && $token!="") {
	$login_link = SITE_URL.get_inbuild_page_url('login');

	$response = array();
	$query=mysqli_query($db,"SELECT * FROM `users` WHERE email='".$email."' AND email!=''");
	$user_data = mysqli_fetch_assoc($query);

	if(!empty($user_data) && $user_data['email']!="") {
		$response['msg'] = 'Email address been already been registered.<br>Please click <a href="'.$login_link.'"><strong>here</strong></a> to login';
		//$response['exist'] = true;
		//$response['signup'] = false;
		$response['signup'] = true;
		$response['user_id'] = $user_data['id'];
		$response['exist'] = false;
	} else {
	//, `password`
	//,'".md5($password)."'
		$query=mysqli_query($db,"INSERT INTO `users`(`email`, `username`, `date`, `status`, user_type) VALUES('".real_escape_string($email)."','".real_escape_string($email)."','".date('Y-m-d H:i:s')."','1','guest')");
		if($query == '1') {
			$n_query=mysqli_query($db,"SELECT * FROM `users` WHERE email='".$email."' AND email!=''");
			$new_user_data = mysqli_fetch_assoc($n_query);

			//$_SESSION['login_user'] = $new_user_data['username'];
			//$_SESSION['user_id'] = $new_user_data['id'];

			$response['msg'] = "You have successfully signup. You can fill other steps & place your order.";
			$response['signup'] = true;
			$response['user_id'] = $new_user_data['id'];
		} else {
			$response['msg'] = "Something went wrong!";
			$response['signup'] = false;
		}
		$response['exist'] = false;
	}
	echo json_encode($response);
}
?>