<?php 
$file_name="categories";

//Header section
require_once("include/header.php");

//Fetch category list
$query = mysqli_query($db,"SELECT catID, catTitle, catSlug FROM blog_cats ORDER BY catTitle DESC");

//Template file
require_once("views/blog/categories.php");

//Footer section
require_once("include/footer.php"); ?>
