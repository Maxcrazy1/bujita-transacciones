<?php 
$file_name="device_categories";

//Header section
require_once("include/header.php");

//Get num of categories for pagination
$category_p_query=mysqli_query($db,"SELECT COUNT(*) AS num_of_categories FROM categories");
$category_p_data = mysqli_fetch_assoc($category_p_query);
$pages->set_total($category_p_data['num_of_categories']);

//Fetch categories data
$query=mysqli_query($db,"SELECT * FROM categories ".$pages->get_limit()."");

//Template file
require_once("views/categories/categories.php");

//Footer section
require_once("include/footer.php"); ?>
