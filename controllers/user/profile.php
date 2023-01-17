<?php
require_once("../../admin/_config/config.php");
require_once("../../admin/include/functions.php");

$user_id = $_SESSION['user_id'];
if($user_id<=0) {
	setRedirect(SITE_URL);
	exit();
}

if(isset($post['submit_form'])) {
	if(empty($_POST)) {
		$msg='Direct access denied';
		setRedirectWithMsg(SITE_URL,$msg,'danger');
		exit();
	}

	$first_name = real_escape_string($post['first_name']);
	$last_name = real_escape_string($post['last_name']);
	$email = real_escape_string($post['email']);
	$phone = preg_replace("/[^\d]/", "", $post['phone']);
	$name = real_escape_string($post['name']);//$first_name.' '.$last_name;
	if($name && $email && $phone) {
		$get_userdata=mysqli_query($db,'SELECT * FROM users WHERE email="'.$email.'" AND id!="'.$user_id.'"');
		$user_data=mysqli_fetch_assoc($get_userdata);
		if(!empty($user_data)) {
			$_SESSION['account_tab'] = "profile";
			$msg='This email address already used so please use different email address.';
			setRedirectWithMsg($return_url,$msg,'warning');
			exit();
		}

		if($_FILES['image']['name']) {
			if(!file_exists('../../images/avatar/'))
				mkdir('../../images/avatar/',0777);

			$image_ext = pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
			if($image_ext=="png" || $image_ext=="jpg" || $image_ext=="jpeg" || $image_ext=="gif") {
				if($post['old_image']!="")
					unlink('../../images/avatar/'.$post['old_image']);

				$image_tmp_name=$_FILES['image']['tmp_name'];
				$image_name=date('YmdHis').'.'.$image_ext;
				$imageupdate=", image='".$image_name."'";
				move_uploaded_file($image_tmp_name,'../../images/avatar/'.$image_name);
			} else {
				$_SESSION['account_tab'] = "profile";
				$msg = "Image type must be png, jpg, jpeg, gif";
				setRedirect($return_url,$msg,'danger');
				exit();
			}
		}

		$query=mysqli_query($db,"UPDATE `users` SET `name`='".$name."',`first_name`='".$first_name."',`last_name`='".$last_name."',`phone`='".$phone."',`email`='".$email."',`address`='".real_escape_string($post['address'])."',`address2`='".real_escape_string($post['address2'])."',`city`='".real_escape_string($post['city'])."',`state`='".real_escape_string($post['state'])."',`postcode`='".real_escape_string($post['postcode'])."',`username`='".$email."',`update_date`='".date('Y-m-d H:i:s')."',`occasional_special_offers`='".$post['occasional_special_offers']."',`important_sms_notifications`='".$post['important_sms_notifications']."'".$imageupdate." WHERE id='".$user_id."'");
		if($query=="1") {
			$_SESSION['account_tab'] = "profile";
			$msg = 'Customer profile has been successfully updated';
			setRedirectWithMsg($return_url,$msg,'success');
			exit();
		}
	}
} elseif($post['remove_av_id']) {
	$query=mysqli_query($db,'SELECT image FROM users WHERE id="'.$post['remove_av_id'].'"');
	$user_data=mysqli_fetch_assoc($query);

	$del_logo=mysqli_query($db,'UPDATE users SET image="" WHERE id='.$post['remove_av_id']);
	if($user_data['image']!="")
		unlink('../../images/avatar/'.$user_data['image']);
	
	$_SESSION['account_tab'] = "profile";
	$msg = 'Avatar has been successfully updated';
	setRedirectWithMsg($return_url,$msg,'success');
	exit();
} else {
	$msg='Direct access denied';
	setRedirectWithMsg(SITE_URL,$msg,'danger');
	exit();
} ?>