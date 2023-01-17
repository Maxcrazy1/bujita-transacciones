<?php 
$file_name="device_categories";

//Header section
require_once("include/header.php");
 
$id = $post['id'];

//Fetch signle editable brand data
$get_behand_data=mysqli_query($db,'SELECT * FROM categories WHERE id="'.$id.'"');
$brand_data=mysqli_fetch_assoc($get_behand_data);

$storage_items_array = get_category_storage_data($id);
$condition_items_array = get_category_condition_data($id);
$network_items_array = get_category_networks_data($id);
$connectivity_items_array = get_category_connectivity_data($id);
$watchtype_items_array = get_category_watchtype_data($id);
$case_material_items_array = get_category_case_material_data($id);
$case_size_items_array = get_category_case_size_data($id);
$color_items_array = get_category_color_data($id);
$accessories_items_array = get_category_accessories_data($id);
$screen_size_items_array = get_category_screen_size_data($id);
$screen_resolution_items_array = get_category_screen_resolution_data($id);
$lyear_items_array = get_category_lyear_data($id);
$processor_items_array = get_category_processor_data($id);
$ram_items_array = get_category_ram_data($id);

//Template file
require_once("views/categories/edit_category.php");

//Footer section
require_once("include/footer.php"); ?>
