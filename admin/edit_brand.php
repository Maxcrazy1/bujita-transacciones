<?php 
$file_name="brand";

//Header section
require_once("include/header.php");
 
$id = $post['id'];

if($id<=0 && $prms_brand_add!='1') {
	setRedirect(ADMIN_URL.'profile.php');
	exit();
} elseif($id>0 && $prms_brand_edit!='1') {
	setRedirect(ADMIN_URL.'profile.php');
	exit();
}

//Fetch signle editable brand data
$get_behand_data=mysqli_query($db,'SELECT * FROM brand WHERE id="'.$id.'"');
$brand_data=mysqli_fetch_assoc($get_behand_data);

//Template file
require_once("views/brand/edit_brand.php");

//Footer section
require_once("include/footer.php"); ?>
