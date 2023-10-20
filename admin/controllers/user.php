<?php 
require_once("../_config/config.php");
require_once("../include/functions.php");

if(isset($post['d_id'])) {
	$query=mysqli_query($db,'DELETE FROM users WHERE id="'.$post['d_id'].'" ');
	if($query=="1"){
		$msg="User successfully removed.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong Delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'users.php');
} elseif(isset($post['bulk_remove'])) {
	$ids_array = $post['ids'];
	if(!empty($ids_array)) {
		$removed_idd = array();
		foreach(explode(",",$ids_array) as $id_k=>$id_v) {
			$removed_idd[] = $id_v;
			$query=mysqli_query($db,'DELETE FROM users WHERE id="'.$id_v.'"');
		}
	}

	if($query=='1') {
		$msg = count($removed_idd)." User(s) successfully removed.";
		if(count($removed_idd)=='1')
			$msg = "User successfully removed.";
	
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong updation failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'users.php');
	exit();
} elseif(isset($post['p_id'])) {
	$query=mysqli_query($db,'UPDATE users SET status="'.$post['status'].'" WHERE id="'.$post['p_id'].'"');
	if($query=="1"){
		if($post['published']==1)
			$msg="Successfully Published.";
		elseif($post['published']==0)
			$msg="Successfully Unpublished.";
			
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong Delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'users.php');
} elseif(isset($post['update'])) {

	$photoid_type = $post['photoid_type'];
	$photoid_array = array();
	if($photoid_type == "upload") {
		if(!empty(array_filter($_FILES['photoid']['name']))) {
			foreach($_FILES['photoid']['name'] as $key => $photoid_name) {
				if($_FILES['photoid']['name'][$key]) {
					if(!file_exists('../../images/users/'))
						mkdir('../../images/users/',0777);

					$image_ext = pathinfo($_FILES['photoid']['name'][$key],PATHINFO_EXTENSION);
					if($image_ext=="png" || $image_ext=="jpg" || $image_ext=="jpeg") {
						$image_tmp_name=$_FILES['photoid']['tmp_name'][$key];
						$image_name=date('YmdHis').'_'.$key.'.'.$image_ext;
						move_uploaded_file($image_tmp_name,'../../images/users/'.$image_name);
						$photoid_array[] = $image_name;
					} else {
						$msg = "Image type must be png, jpg, jpeg";
						$_SESSION['error_msg']=$msg;
						setRedirect(ADMIN_URL.'edit_user.php?id='.$post['id']);
						exit();
					}
				}
			}
			if(count($photoid_array)>0) {
				$photoid_json = json_encode($photoid_array);
				$updt_photoid = ",`photoid_type`='upload',`photoid`='".$photoid_json."'";
			}
		} else {
			/*$msg = "photoID 1 must be upload";
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_user.php?id='.$post['id']);
			exit();*/
		}
	} else {
		$updt_photoid = ",`photoid_type`='',`photoid`=''";
	}
	
	$email=real_escape_string($post['email']);
	$phone = preg_replace("/[^\d]/", "", $post['phone']);
	$password=real_escape_string($post['password']);
	$address=real_escape_string($post['address']);
	$address2=real_escape_string($post['address2']);
	$name=real_escape_string($post['name']);
	//$first_name=real_escape_string($post['first_name']);
	//$last_name=real_escape_string($post['last_name']);
	if($password)
			$password = ",`password`='".md5($password)."'";

	if($post['id']) {
		$get_userdata=mysqli_query($db,'SELECT * FROM users WHERE email="'.$post['email'].'" AND id!="'.$post['id'].'"');
		$get_userdata_row=mysqli_fetch_assoc($get_userdata);
		if(!empty($get_userdata_row)) {
			$msg='This email address already used so please use different email address.';
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_user.php?id='.$post['id']);
			exit();
		}
		
		$query=mysqli_query($db,"UPDATE `users` SET `name`='".$name."',`first_name`='".$first_name."',`last_name`='".$last_name."',`phone`='".$phone."',`email`='".$post['email']."',`address`='".$address."',`address2`='".$address2."',`city`='".$post['city']."',`state`='".$post['state']."',`postcode`='".$post['postcode']."',`company_name`='".$post['company_name']."',`username`='".$email."'".$password.",`update_date`='".date('Y-m-d H:i:s')."',`status`='".$post['status']."',`occasional_special_offers`='".$post['occasional_special_offers']."',`important_sms_notifications`='".$post['important_sms_notifications']."'".$updt_photoid." WHERE id='".$post['id']."'");
		if($query=="1") {
			$template_data = get_template_data('customer_profile_edit_from_admin');
			$general_setting_data = get_general_setting_data();
			$admin_user_data = get_admin_user_data();
			$customer_data = get_user_data($user_id);
			
			$patterns = array(
				'{$logo}',
				'{$admin_logo}',
				'{$admin_email}',
				'{$admin_username}',
				'{$admin_site_url}',
				'{$admin_panel_name}',
				'{$from_name}',
				'{$from_email}',
				'{$site_name}',
				'{$site_url}',
				'{$customer_fname}',
				'{$customer_lname}',
				'{$customer_fullname}',
				'{$customer_phone}',
				'{$customer_email}',
				'{$customer_password}',
				'{$customer_address_line1}',
				'{$customer_address_line2}',
				'{$customer_city}',
				'{$customer_state}',
				'{$customer_country}',
				'{$customer_postcode}',
				'{$customer_status}',
				'{$current_date_time}');

			$replacements = array(
				$logo,
				$admin_logo,
				$admin_user_data['email'],
				$admin_user_data['username'],
				ADMIN_URL,
				$general_setting_data['admin_panel_name'],
				$general_setting_data['from_name'],
				$general_setting_data['from_email'],
				$general_setting_data['site_name'],
				SITE_URL,
				$customer_data['first_name'],
				$customer_data['last_name'],
				$customer_data['name'],
				$customer_data['phone'],
				$customer_data['email'],
				($post['password']?$post['password']:'Not Updated'),
				$customer_data['address'],
				$customer_data['address2'],
				$customer_data['city'],
				$customer_data['state'],
				$customer_data['country'],
				$customer_data['postcode'],
				($post['status']=='1'?'Active':'Inactive'),
				format_date(date('Y-m-d H:i')).' '.format_time(date('Y-m-d H:i'))
				);
			
			if(!empty($template_data)) {
				$email_subject = str_replace($patterns,$replacements,$template_data['subject']);
				$email_body_text = str_replace($patterns,$replacements,$template_data['content']);
				send_email($customer_data['email'], $email_subject, $email_body_text, FROM_NAME, FROM_EMAIL);
				
				//START sms send to customer
				if($template_data['sms_status']=='1' && $sms_sending_status=='1') {
					$from_number = '+'.$general_setting_data['twilio_long_code'];
					$to_number = '+'.$customer_data['phone'];
					if($from_number && $account_sid && $auth_token) {
						$sms_body_text = str_replace($patterns,$replacements,$template_data['sms_content']);
						try {
							$sms = $sms_api->account->messages->sendMessage($from_number, $to_number, $sms_body_text, $image, array('StatusCallback'=>''));
						} catch(Services_Twilio_RestException $e) {
							echo $sms_error_msg = $e->getMessage();
							error_log($sms_error_msg);
						}
					}
				} //END sms send to customer
			}
			$msg="Customer profile has been successfully updated.";
			$_SESSION['success_msg']=$msg;
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
		}
		setRedirect(ADMIN_URL.'edit_user.php?id='.$post['id']);
	}
} elseif($post['r_img_id']) {
	$q=mysqli_query($db,'SELECT photoid FROM users WHERE id="'.$post['r_img_id'].'"');
	$user_data=mysqli_fetch_assoc($q);

	mysqli_query($db,'UPDATE users SET photoid="" WHERE id='.$post['r_img_id']);
	
	$photoid_array = json_decode($user_data['photoid']);
	if(!empty($photoid_array)) {
		foreach($photoid_array as $key=>$photoid) {
			unlink('../../images/users/'.$photoid);
		}
	}

	setRedirect(ADMIN_URL.'edit_user.php?id='.$post['id']);
} else {
	setRedirect(ADMIN_URL.'users.php');
}
exit(); ?>