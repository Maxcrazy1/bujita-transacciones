<?php 
$file_name="newsletter";

//Header section
require_once("include/header.php");

//Get num of newsletters submitted form for pagination
$user_p_query=mysqli_query($db,"SELECT COUNT(*) AS num_of_records FROM newsletters");
$user_p_data = mysqli_fetch_assoc($user_p_query);
$pages->set_total($user_p_data['num_of_records']);

//Fetch list of newsletters submitted form 
$query=mysqli_query($db,"SELECT * FROM newsletters ORDER BY id DESC ".$pages->get_limit()."");

//Template file
require_once("views/newsletter.php");

//Footer section
require_once("include/footer.php"); ?>