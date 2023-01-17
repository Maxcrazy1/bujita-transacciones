<?php 
$file_name="promocode";

//Header section
require_once("include/header.php");

//Fetch promocode list
$query='SELECT * FROM promocode ORDER BY to_date ASC';
$result=mysqli_query($db,$query);
				
//Template file
require_once("views/promocode/promocode.php");

//Footer section
include("include/footer.php"); ?>
