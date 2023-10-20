<?php 
$file_name="brand";

//Header section
require_once("include/header.php");

//Get num of brands for pagination
$brand_p_query=mysqli_query($db,"SELECT COUNT(*) AS num_of_brands FROM brand");
$brand_p_data = mysqli_fetch_assoc($brand_p_query);
$pages->set_total($brand_p_data['num_of_brands']);

//Fetch brands data
$query=mysqli_query($db,"SELECT * FROM brand ".$pages->get_limit()."");

//Template file
require_once("views/brand/brand.php");

//Footer section
require_once("include/footer.php"); ?>
