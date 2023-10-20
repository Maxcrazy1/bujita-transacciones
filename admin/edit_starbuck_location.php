<?php 
$file_name="starbuck_locations";

//Header section
require_once("include/header.php");
 
$id = $post['id'];

//Fetch signle editable faqs data
$query = mysqli_query($db,'SELECT * FROM starbuck_location WHERE id="'.$id.'"');
$starbuck_location_data=mysqli_fetch_assoc($query);

//Template file
require_once("views/starbuck_location/edit.php");

//Footer section
require_once("include/footer.php"); ?>
