<?php 
$file_name="starbuck_locations";

//Header section
require_once("include/header.php");

//Get num of starbuck_locations for pagination
$starbuck_location_p_query=mysqli_query($db,"SELECT COUNT(*) AS num_of_starbuck_location FROM starbuck_location");
$starbuck_location_p_data = mysqli_fetch_assoc($starbuck_location_p_query);
$pages->set_total($starbuck_location_p_data['num_of_starbuck_location']);

//Fetch starbuck_locations data
$query=mysqli_query($db,"SELECT * FROM starbuck_location ".$pages->get_limit()."");

//Template file
require_once("views/starbuck_location/list.php");

//Footer section
require_once("include/footer.php"); ?>
