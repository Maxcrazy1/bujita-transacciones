<?php 
$file_name="view_emailsms_history";

//Header section
require_once("include/header.php");
 
$id = $post['id'];

//Fetch signle editable brand data
$get_behand_data=mysqli_query($db,'SELECT * FROM inbox_mail_sms WHERE id="'.$id.'"');
$brand_data=mysqli_fetch_assoc($get_behand_data);

//Template file
require_once("views/view_emailsms_history.php");

//Footer section
require_once("include/footer.php"); ?>
