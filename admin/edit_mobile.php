<?php
$file_name="mobile";

//Header section
require_once("include/header.php");

$id = $post['id'];

//Fetch signle editable mobile(model) data
$mobile_data_q=mysqli_query($db,'SELECT m.*, c.fields_type, c.storage_title, c.condition_title, c.network_title, c.connectivity_title, c.case_size_title, c.type_title, c.case_material_title, c.color_title, c.accessories_title, c.screen_size_title, c.screen_resolution_title, c.lyear_title, c.processor_title, c.ram_title FROM mobile AS m LEFT JOIN categories AS c ON c.id=m.cat_id WHERE m.id="'.$id.'"');
$mobile_data=mysqli_fetch_assoc($mobile_data_q);

//Fetch device list
$devices_data=mysqli_query($db,'SELECT * FROM devices ORDER BY id ASC');

//Fetch list of published brand
$brands_data=mysqli_query($db,'SELECT * FROM brand ORDER BY id ASC');

//Fetch category list
$categories_data=mysqli_query($db,'SELECT * FROM categories ORDER BY id ASC');

$storage_items_array = get_models_storage_data($id);
$condition_items_array = get_models_condition_data($id);
$network_items_array = get_models_networks_data($id);
$connectivity_items_array = get_models_connectivity_data($id);
$watchtype_items_array = get_models_watchtype_data($id);
$case_material_items_array = get_models_case_material_data($id);
$case_size_items_array = get_models_case_size_data($id);
$color_items_array = get_models_color_data($id);
$accessories_items_array = get_models_accessories_data($id);
//$miscellaneous_items_array = get_models_miscellaneous_data($id);
$screen_size_items_array = get_models_screen_size_data($id);
$screen_resolution_items_array = get_models_screen_resolution_data($id);
$lyear_items_array = get_models_lyear_data($id);
$processor_items_array = get_models_processor_data($id);
$ram_items_array = get_models_ram_data($id);

// dependencies 
$dependencies_array = get_models_dependencies($id);


//Template file
require_once("views/mobile/edit_mobile.php");

//Footer section
include("include/footer.php"); ?>
