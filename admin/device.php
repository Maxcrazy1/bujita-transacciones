<?php 
$file_name="device";

//Header section
require_once("include/header.php");

$filter_by = "";
if($post['filter_by']) {
	$filter_by .= " AND (d.title LIKE '%".real_escape_string($post['filter_by'])."%')";
}

/*if($post['brand_id']) {
	$filter_by .= " AND (d.brand_id LIKE '".$post['brand_id']."')";
}

//Get num of devices for pagination
$devices_p_query=mysqli_query($db,"SELECT COUNT(*) AS num_of_devices, d.*, b.title AS brand_title FROM devices AS d LEFT JOIN brand AS b ON b.id=d.brand_id WHERE 1 ".$filter_by."");
$devices_p_data = mysqli_fetch_assoc($devices_p_query);
$pages->set_total($devices_p_data['num_of_devices']);

//Fetch devices data
$query=mysqli_query($db,"SELECT d.*, b.title AS brand_title FROM devices AS d LEFT JOIN brand AS b ON b.id=d.brand_id WHERE 1 ".$filter_by." ".$pages->get_limit()."");*/

//Get num of devices for pagination
$devices_p_query=mysqli_query($db,"SELECT COUNT(*) AS num_of_devices, d.* FROM devices AS d WHERE 1 ".$filter_by."");
$devices_p_data = mysqli_fetch_assoc($devices_p_query);
$pages->set_total($devices_p_data['num_of_devices']);

//Fetch devices data
$query=mysqli_query($db,"SELECT d.* FROM devices AS d WHERE 1 ".$filter_by." ".$pages->get_limit()."");

//Fetch list of published brand
//$brands_data=mysqli_query($db,'SELECT * FROM brand WHERE published=1');

//Template file
require_once("views/device/device.php");

//Footer section
include("include/footer.php"); ?>
