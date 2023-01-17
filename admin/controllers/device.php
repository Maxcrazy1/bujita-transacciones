<?php 
require_once("../_config/config.php");
require_once("../include/functions.php");

if(isset($post['d_id'])) {
	$device_q=mysqli_query($db,'SELECT device_img FROM devices WHERE id="'.$post['d_id'].'"');
	$device_data=mysqli_fetch_assoc($device_q);
	
	$query=mysqli_query($db,'DELETE FROM devices WHERE id="'.$post['d_id'].'" ');
	if($query=="1"){
		if($device_data['device_img']!="")
			unlink('../../images/device/'.$device_data['device_img']);

		$msg="Record successfully removed.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'device.php');
} elseif(isset($post['bulk_remove'])) {
	$ids_array = $post['ids'];
	if(!empty($ids_array)) {
		$removed_idd = array();
		foreach(explode(",",$ids_array) as $id_k=>$id_v) {
			$removed_idd[] = $id_v;

			$device_q=mysqli_query($db,'SELECT device_img FROM devices WHERE id="'.$id_v.'"');
			$device_data=mysqli_fetch_assoc($device_q);
			if($device_data['device_img']!="")
				unlink('../../images/device/'.$device_data['device_img']);

			$query=mysqli_query($db,'DELETE FROM devices WHERE id="'.$id_v.'"');
		}
	}

	if($query=='1') {
		$msg = count($removed_idd)." Record(s) successfully removed.";
		if(count($removed_idd)=='1')
			$msg = "Record successfully removed.";
	
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong updation failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'device.php');
} elseif(isset($post['p_id'])) {
	$query=mysqli_query($db,'UPDATE devices SET published="'.$post['published'].'" WHERE id="'.$post['p_id'].'"');
	if($query=="1"){
		if($post['published']==1)
			$msg="Successfully Published.";
		elseif($post['published']==0)
			$msg="Successfully Unpublished.";
			
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'device.php');
} elseif(isset($post['update'])) {
	$title=real_escape_string($post['title']);
	$sub_title=real_escape_string($post['sub_title']);
	$sef_url=createSlug(real_escape_string($post['sef_url']));
	$meta_title=real_escape_string($post['meta_title']);
	$meta_desc=real_escape_string($post['meta_desc']);
	$meta_keywords=real_escape_string($post['meta_keywords']);
	$price=real_escape_string($post['price']);
	$description=real_escape_string($post['description']);
	//$brand_id = $post['brand_id'];
	$published = $post['published'];
	$tooltip_network=real_escape_string($post['tooltip_network']);
	$tooltip_condition=real_escape_string($post['tooltip_condition']);
	$id = $post['id'];
	
	//Check Valid SEF URL
	/*$is_valid_sef_url_arr = check_sef_url_validation($sef_url, $id, "device");
	if($is_valid_sef_url_arr['valid']!=true) {
		$msg='This sef url already exist so please use other.';
		$_SESSION['error_msg']=$msg;
		if($id) {
			setRedirect(ADMIN_URL.'edit_device.php?id='.$id);
		} else {
			setRedirect(ADMIN_URL.'edit_device.php');
		}
		exit();
	}*/
	
	if($_FILES['device_img']['name']) {
		if(!file_exists('../../images/device/'))
			mkdir('../../images/device/',0777);
			
		$image_ext = pathinfo($_FILES['device_img']['name'],PATHINFO_EXTENSION);
		if($image_ext=="png" || $image_ext=="jpg" || $image_ext=="jpeg" || $image_ext=="gif") {
			if($post['old_image']!="")
				unlink('../../images/device/'.$post['old_image']);
		
			$image_tmp_name=$_FILES['device_img']['tmp_name'];
			$image_name=date('YmdHis').'.'.$image_ext;
			$imageupdate=', device_img="'.$image_name.'"';
			move_uploaded_file($image_tmp_name,'../../images/device/'.$image_name);
		} else {
			$msg="Image type must be png, jpg, jpeg, gif";
			$_SESSION['success_msg']=$msg;
			if($id) {
				setRedirect(ADMIN_URL.'edit_device.php?id='.$id);
			} else {
				setRedirect(ADMIN_URL.'edit_device.php');
			}
			exit();
		}
	}

	if($id) {
		//brand_id="'.$brand_id.'", 
		$query=mysqli_query($db,'UPDATE devices SET title="'.$title.'", sub_title="'.$sub_title.'", sef_url="'.$sef_url.'", meta_title="'.$meta_title.'", meta_desc="'.$meta_desc.'", meta_keywords="'.$meta_keywords.'", price="'.$price.'" '.$imageupdate.', description="'.$description.'", popular_device="'.$post['popular_device'].'", published="'.$published.'", tooltip_network="'.$tooltip_network.'", tooltip_condition="'.$tooltip_condition.'" WHERE id="'.$id.'"');
		if($query=="1") {
			$msg="Device has been successfully updated.";
			$_SESSION['success_msg']=$msg;
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
		}
		setRedirect(ADMIN_URL.'edit_device.php?id='.$id);
	} else {
		$query=mysqli_query($db,'INSERT INTO devices(title, sub_title, sef_url, meta_title, meta_desc, meta_keywords, price, device_img, description, popular_device, published, tooltip_network, tooltip_condition) values("'.$title.'","'.$sub_title.'","'.$sef_url.'","'.$meta_title.'","'.$meta_desc.'","'.$meta_keywords.'","'.$price.'","'.$image_name.'","'.$description.'","'.$post['popular_device'].'","'.$published.'","'.$tooltip_network.'","'.$tooltip_condition.'")');
		if($query=="1") {
			$msg="Device has been successfully added.";
			$_SESSION['success_msg']=$msg;
			setRedirect(ADMIN_URL.'device.php');
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_device.php');
		}
	}
} elseif($post['r_img_id']) {
	$get_behand_data=mysqli_query($db,'SELECT device_img FROM devices WHERE id="'.$post['r_img_id'].'"');
	$device_data=mysqli_fetch_assoc($get_behand_data);

	$del_logo=mysqli_query($db,'UPDATE devices SET device_img="" WHERE id='.$post['r_img_id']);
	if($device_data['device_img']!="")
		unlink('../../images/device/'.$device_data['device_img']);

	setRedirect(ADMIN_URL.'edit_device.php?id='.$post['id']);
} elseif($post['sbt_order']) {
	foreach($post['ordering'] as $ordering_key => $ordering_val) {
		if($ordering_val>0) {
			$query = mysqli_query($db,"UPDATE devices SET ordering='".$ordering_val."' WHERE id='".$ordering_key."'");
		}
	}
	if($query=="1") {
		$msg="Order(s) successfully saved.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong updation failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'device.php');
} else {
	setRedirect(ADMIN_URL.'device.php');
}
exit();
?>