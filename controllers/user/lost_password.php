<?php 
require_once("../../admin/_config/config.php");
require_once("../../admin/include/functions.php");

if(isset($post['reset'])) {
    $email=real_escape_string($post['email']);
    $query=mysqli_query($db,"SELECT * FROM users WHERE email='".$email."'");
    $user_data=mysqli_fetch_assoc($query);
    if($user_data['id']!="" && $email!="") {
		$uid=$user_data['id'];
		$token=md5($email.time());
		
		$upt_query = mysqli_query($db,"UPDATE users SET token='".$token."' WHERE id='".$uid."'");
		if($upt_query=='1') {
			$template_data = get_template_data('reset_password');
		    
			$patterns = array(
				'{$logo}', '{$header_logo}', '{$footer_logo}',
				'{$admin_logo}',
				'{$admin_email}',
				'{$admin_username}',
				'{$admin_site_url}',
				'{$admin_panel_name}',
				'{$from_name}',
				'{$from_email}',
				'{$site_url}',
				'{$customer_fname}',
				'{$customer_lname}',
				'{$customer_fullname}',
				'{$customer_phone}',
				'{$customer_email}',
				'{$customer_address_line1}',
				'{$customer_address_line2}',
				'{$customer_city}',
				'{$customer_state}',
				'{$customer_country}',
				'{$customer_postcode}',
				'{$current_date_time}',
				'{$password_reset_link}');
				
    		$temp_arr = strtolower($user_data['name']).";";
    	    $temp_arr = preg_split("/[\s*]/", $temp_arr);
    	    $hold ="";
    	    foreach($temp_arr as $str){
    	        $hold.= ucfirst($str)." ";
            }
    	    $temp_arr = trim(preg_replace("/\;/", "", $hold));
    	    
		  //  $header_logo = str_replace('my_preheader', substr(preg_replace('/\{\$\w+\_\w+\}/i',"", preg_replace('/\{\$(customer_fullname)\}(\W)/i', $temp_arr."$2".' ' ,$template_data['content'])),0,300), $header_logo);
			$password_reset_link = '<a href="'.SITE_URL.'reset_password?t='.$token.'">Reset password</a>';
			$header_logo = SITE_URL.'images/logo.png';
			$footer_logo = SITE_URL.'images/logo.png';
			$admin_logo = SITE_URL.'images/logo.png';
			
			$replacements = array(
				$logo, 
				'', 
				'',
				$admin_logo,
				$general_setting_data['email'],
				$general_setting_data['from_name'],
				ADMIN_URL,
				$general_setting_data['admin_panel_name'],
				$general_setting_data['from_name'],
				$general_setting_data['from_email'],
				SITE_URL,
				$user_data['first_name'],
				$user_data['last_name'],
				$user_data['name'],
				$user_data['phone'],
				$user_data['email'],
				$user_data['address'],
				$user_data['address2'],
				$user_data['city'],
				$user_data['state'],
				$user_data['country'],
				$user_data['postcode'],
				format_date(date('Y-m-d H:i')).' '.format_time(date('Y-m-d H:i')),
				$password_reset_link);
				
			if(!empty($template_data)) {
				$email_subject = str_replace($patterns,$replacements,$template_data['subject']);
				$email_body_text = str_replace($patterns,$replacements,$template_data['content']);
				
					$cabeceras = "From: ".FROM_NAME." <".FROM_EMAIL.">" . "\r\n";
					$cabeceras .= "Reply-To:" .FROM_EMAIL."\r\n";
					$cabeceras .= "MIME-Version: 1.0" . "\r\n";
					$cabeceras .= "Content-Type: text/html; charset=UTF-8" . "\r\n";

					mail($user_data['email'],$email_subject,$email_body_text,$cabeceras);
				// send_email($user_data['email'], $email_subject, $email_body_text, FROM_NAME, FROM_EMAIL);
			}

			$msg='Confirmed! Reset your password link has been sent. Check your email.';
			setRedirectWithMsg(SITE_URL.'lost_password',$msg,'success');
		} else {
			$msg='Occured error so please contact with support staff.';
			setRedirectWithMsg(SITE_URL.'lost_password',$msg,'error');
		}
    } else {
		$msg='Sorry, this email address is not recognized. To create a new account use the sign-up form.';
		setRedirectWithMsg(SITE_URL.'lost_password?error',$msg,'warning');
    }
	exit();
} else {
	$msg='Direct access denied';
	setRedirectWithMsg(SITE_URL,$msg,'danger');
	exit();
} ?>