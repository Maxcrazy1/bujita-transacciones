<?php 
$file_name="faqs_groups";

//Header section
require_once("include/header.php");

//Get num of faqs for pagination
$faq_p_query=mysqli_query($db,"SELECT COUNT(*) AS num_of_faq FROM faqs_groups");
$faq_p_data = mysqli_fetch_assoc($faq_p_query);
$pages->set_total($faq_p_data['num_of_faq']);

//Fetch faqs data
$query=mysqli_query($db,"SELECT fg.*, c.title AS cat_title FROM faqs_groups AS fg LEFT JOIN categories AS c ON c.id=fg.cat_id ".$pages->get_limit()."");

//Template file
require_once("views/faq/faqs_groups.php");

//Footer section
require_once("include/footer.php"); ?>
