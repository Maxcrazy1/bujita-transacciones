<?php 
require_once("../_config/config.php");
require_once("../include/functions.php");

if(isset($post['d_id'])) {
	$query=mysqli_query($db,'DELETE FROM starbuck_location WHERE id="'.$post['d_id'].'"');
	if($query=="1"){
		$msg="Record successfully removed.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'starbuck_locations.php');
} elseif(isset($post['bulk_remove'])) {
	$ids_array = $post['ids'];
	if(!empty($ids_array)) {
		$removed_idd = array();
		foreach(explode(",",$ids_array) as $id_k=>$id_v) {
			$query=mysqli_query($db,'DELETE FROM starbuck_location WHERE id="'.$id_v.'"');
			
			$starbuck_location_q=mysqli_query($db,'SELECT * FROM starbuck_location WHERE id="'.$id_v.'"');
			$starbuck_location_data=mysqli_fetch_assoc($starbuck_location_q);
			if(empty($starbuck_location_data)) {
				$removed_idd[] = $id_v;
			}
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
	setRedirect(ADMIN_URL.'starbuck_locations.php');
} elseif(isset($post['p_id'])) {
	$query=mysqli_query($db,'UPDATE starbuck_location SET status="'.$post['status'].'" WHERE id="'.$post['p_id'].'"');
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
	setRedirect(ADMIN_URL.'starbuck_locations.php');
} elseif(isset($post['update'])) {
	$name = real_escape_string($post['name']);
	$address = real_escape_string($post['address']);
	$map_link = $post['map_link'];
	$status = $post['status'];
	$date = date("Y-m-d H:i:s");
	
	if($post['id']) {
		$query=mysqli_query($db,'UPDATE starbuck_location SET name="'.$name.'", address="'.$address.'", map_link="'.$map_link.'", added_date="'.$date.'", status="'.$status.'" WHERE id="'.$post['id'].'"');
		if($query=="1") {
			$msg="Starbuck Location has been successfully updated.";
			$_SESSION['success_msg']=$msg;
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
		}
		setRedirect(ADMIN_URL.'edit_starbuck_location.php?id='.$post['id']);
	} else {
		$query=mysqli_query($db,'INSERT INTO starbuck_location(name, address, map_link, updated_date, status) values("'.$name.'","'.$address.'","'.$map_link.'","'.$date.'","'.$status.'")');
		if($query=="1") {
			$msg="Starbuck Location has been successfully added.";
			$_SESSION['success_msg']=$msg;
			setRedirect(ADMIN_URL.'starbuck_locations.php');
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_starbuck_location.php');
		}
	}
} elseif($post['sbt_order']) {
	foreach($post['ordering'] as $ordering_key => $ordering_val) {
		if($ordering_val>0) {
			$query = mysqli_query($db,"UPDATE starbuck_location SET ordering='".$ordering_val."' WHERE id='".$ordering_key."'");
		}
	}
	if($query=="1") {
		$msg="Order(s) successfully saved.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong updation failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'starbuck_locations.php');
} else {
	setRedirect(ADMIN_URL.'starbuck_locations.php');
}
exit();
?>