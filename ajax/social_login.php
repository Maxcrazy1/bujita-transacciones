<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");

$response = array();
$user_data = $_REQUEST;

//$_SESSION['facebook_data'] = array('name'=>$user_data['name'],'first_name'=>$user_data['first_name'],'middle_name'=>$user_data['middle_name'],'last_name'=>$user_data['last_name'],'email'=>$user_data['email'],'locale'=>$user_data['locale']);

$query="SELECT * FROM users WHERE username = '".$user_data['email']."'";
$res=mysqli_query($db,$query);
$checkUser=mysqli_num_rows($res);
if($checkUser > 0){
	$fetch_userdata=mysqli_fetch_assoc($res);
	$_SESSION['login_user'] = $fetch_userdata['username'];
	$_SESSION['user_id']=$fetch_userdata['id'];
	
	$response['msg'] = "User successfully loggedin";
	$response['status'] = true;
} else {
	$query=mysqli_query($db,"INSERT INTO `users`(`name`, `first_name`, `last_name`, `email`, `username`, `status`, `date`,leadsource) VALUES('".$user_data['name']."', '".$user_data['first_name']."','".$user_data['last_name']."','".$user_data['email']."','".$user_data['email']."','1','".date('Y-m-d H:i:s')."','social')");
	if($query=="1") {
		$query="SELECT * FROM users WHERE username = '".$user_data['email']."'";
		$res=mysqli_query($db,$query);
		$checkUser=mysqli_num_rows($res);
		$fetch_userdata=mysqli_fetch_assoc($res);

		$_SESSION['login_user'] = $fetch_userdata['username'];
		$_SESSION['user_id']=$fetch_userdata['id'];
		
		$response['msg'] = "User successfully created";
		$response['status'] = true;
	}
}
echo json_encode($response);
exit;
