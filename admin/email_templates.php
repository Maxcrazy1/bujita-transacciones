<?php 
$file_name="email_template";

//Header section
require_once("include/header.php");

//Get fixed template type with respective template constants
require_once("include/template_type_with_constants.php");

$filter_by = "";
if($post['filter_by'] == "order_problem_status") {
	$filter_by .= " AND type = 'order_problem_status'";
}

//Fetch data list of saved mail templates
$query="SELECT * FROM mail_templates WHERE 1 ".$filter_by."";
$result = mysqli_query($db,$query);

//Gather mail template data from fixed type (template_type_with_constants.php)
$already_added_template_type = array();
$get_already_added_template_type_query = mysqli_query($db,'SELECT type FROM mail_templates');
while($get_already_added_template_type_row=mysqli_fetch_assoc($get_already_added_template_type_query)) {
	$already_added_template_type[$get_already_added_template_type_row['type']] = $get_already_added_template_type_row['type'];
}
$template_type_final_array = array_diff_key($template_type_array, $already_added_template_type);
$num_of_rows = mysqli_num_rows($result);

//Template file
require_once("views/email_template/email_templates.php");

//Footer section
require_once("include/footer.php"); ?>
