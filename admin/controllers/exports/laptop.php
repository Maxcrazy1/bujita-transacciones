<?php
$header = array('Model_ID',
	'Category_ID',
	'Category_Title',
	'Brand',
	'Device',
	'Model_Title',
	'Model_Price',
	'Type_ID',
	'Type_Title',
	'Type_Price',
	'Network_ID',
	'Network_Title',
	'Network_Price',
	'Network_UnlockPrice',
	'Screen_Size_ID',
	'Screen_Size_Title',
	'Screen_Size_Price',
	'Screen_Resolution_ID',
	'Screen_Resolution_Title',
	'Screen_Resolution_Price',
	'Year_ID',
	'Year_Title',
	'Year_Price',
	'Processor_ID',
	'Processor_Title',
	'Processor_Price',
	'Storage_ID',
	'Storage_Title',
	'Storage_Title_Postfix',
	'Storage_Price',
	'Ram_ID',
	'Ram_Title',
	'Ram_Title_Postfix',
	'Ram_Price',
	'Color_ID',
	'Color_Title',
	'Color_Code',
	'Color_Price',
	'Condition_ID',
	'Condition_Title',
	'Condition_Price',
	'Accessories_ID',
	'Accessories_Title',
	'Accessories_Price');
fputcsv($fp, $header);

$data_to_csv_array = array();
while($model_data=mysqli_fetch_assoc($query)) {
	$data_to_csv = array();
	$model_fields_data_array = array();

	$model_id = $model_data['id'];
	$watchtype_items_array = get_models_watchtype_data($model_id);
	$network_items_array = get_models_networks_data($model_id);
	
	$screen_size_items_array = get_models_screen_size_data($model_id);
	$screen_resolution_items_array = get_models_screen_resolution_data($model_id);
	$lyear_items_array = get_models_lyear_data($model_id);
	$processor_items_array = get_models_processor_data($model_id);
	
	$storage_items_array = get_models_storage_data($model_id);
	$ram_items_array = get_models_ram_data($model_id);
	$colors_items_array = get_models_color_data($model_id);
	$condition_items_array = get_models_condition_data($model_id);
	$accessories_items_array = get_models_accessories_data($model_id);
	
	if(!empty($screen_size_items_array)) {
		foreach($screen_size_items_array as $ss_key => $screen_size_items_data) {
			$model_fields_data_array[$ss_key]['Screen_Size_ID'] = $screen_size_items_data['id'];
			$model_fields_data_array[$ss_key]['Screen_Size_Title'] = $screen_size_items_data['screen_size_name'];
			$model_fields_data_array[$ss_key]['Screen_Size_Price'] = $screen_size_items_data['screen_size_price'];
		}
	}
	if(!empty($screen_resolution_items_array)) {
		foreach($screen_resolution_items_array as $sr_key => $screen_resolution_items_data) {
			$model_fields_data_array[$sr_key]['Screen_Resolution_ID'] = $screen_resolution_items_data['id'];
			$model_fields_data_array[$sr_key]['Screen_Resolution_Title'] = $screen_resolution_items_data['screen_resolution_name'];
			$model_fields_data_array[$sr_key]['Screen_Resolution_Price'] = $screen_resolution_items_data['screen_resolution_price'];
		}
	}
	if(!empty($lyear_items_array)) {
		foreach($lyear_items_array as $ly_key => $lyear_items_data) {
			$model_fields_data_array[$ly_key]['Year_ID'] = $lyear_items_data['id'];
			$model_fields_data_array[$ly_key]['Year_Title'] = $lyear_items_data['lyear_name'];
			$model_fields_data_array[$ly_key]['Year_Price'] = $lyear_items_data['lyear_price'];
		}
	}
	if(!empty($processor_items_array)) {
		foreach($processor_items_array as $prs_key => $processor_items_data) {
			$model_fields_data_array[$prs_key]['Processor_ID'] = $processor_items_data['id'];
			$model_fields_data_array[$prs_key]['Processor_Title'] = $processor_items_data['processor_name'];
			$model_fields_data_array[$prs_key]['Processor_Price'] = $processor_items_data['processor_price'];
		}
	}
	
	if(!empty($ram_items_array)) {
		foreach($ram_items_array as $r_key => $ram_items_data) {
			$model_fields_data_array[$r_key]['Ram_ID'] = $ram_items_data['id'];
			$model_fields_data_array[$r_key]['Ram_Title'] = $ram_items_data['ram_size'];
			$model_fields_data_array[$r_key]['Ram_Title_Postfix'] = $ram_items_data['ram_size_postfix'];
			$model_fields_data_array[$r_key]['Ram_Price'] = $ram_items_data['ram_price'];
		}
	}
	
	if(!empty($watchtype_items_array)) {
		foreach($watchtype_items_array as $t_key => $watchtype_items_data) {
			$model_fields_data_array[$t_key]['Type_ID'] = $watchtype_items_data['id'];
			$model_fields_data_array[$t_key]['Type_Title'] = $watchtype_items_data['watchtype_name'];
			$model_fields_data_array[$t_key]['Type_Price'] = $watchtype_items_data['watchtype_price'];
		}
	}
	
	if(!empty($storage_items_array)) {
		foreach($storage_items_array as $s_key => $storage_items_data) {
			$model_fields_data_array[$s_key]['Storage_ID'] = $storage_items_data['id'];
			$model_fields_data_array[$s_key]['Storage_Title'] = $storage_items_data['storage_size'];
			$model_fields_data_array[$s_key]['Storage_Title_Postfix'] = $storage_items_data['storage_size_postfix'];
			$model_fields_data_array[$s_key]['Storage_Price'] = $storage_items_data['storage_price'];
		}
	}
	
	if(!empty($condition_items_array)) {
		foreach($condition_items_array as $c_key => $condition_items_data) {
			$model_fields_data_array[$c_key]['Condition_ID'] = $condition_items_data['id'];
			$model_fields_data_array[$c_key]['Condition_Title'] = $condition_items_data['condition_name'];
			$model_fields_data_array[$c_key]['Condition_Price'] = $condition_items_data['condition_price'];
		}
	}
	
	if(!empty($network_items_array)) {
		foreach($network_items_array as $n_key => $network_items_data) {
			$model_fields_data_array[$n_key]['Network_ID'] = $network_items_data['id'];
			$model_fields_data_array[$n_key]['Network_Title'] = $network_items_data['network_name'];
			$model_fields_data_array[$n_key]['Network_Price'] = $network_items_data['network_price'];
			$model_fields_data_array[$n_key]['Network_UnlockPrice'] = $network_items_data['network_unlock_price'];
		}
	}

	if(!empty($accessories_items_array)) {
		foreach($accessories_items_array as $acce_key => $accessories_items_data) {
			$model_fields_data_array[$acce_key]['Accessories_ID'] = $accessories_items_data['id'];
			$model_fields_data_array[$acce_key]['Accessories_Title'] = $accessories_items_data['accessories_name'];
			$model_fields_data_array[$acce_key]['Accessories_Price'] = $accessories_items_data['accessories_price'];
		}
	}
	
	if(!empty($colors_items_array)) {
		foreach($colors_items_array as $clr_key => $colors_items_data) {
			$model_fields_data_array[$clr_key]['Color_ID'] = $colors_items_data['id'];
			$model_fields_data_array[$clr_key]['Color_Title'] = $colors_items_data['color_name'];
			$model_fields_data_array[$clr_key]['Color_Code'] = $colors_items_data['color_code'];
			$model_fields_data_array[$clr_key]['Color_Price'] = $colors_items_data['color_price'];
		}
	}

	if(!empty($model_fields_data_array)) {
		foreach($model_fields_data_array as $model_fields_data) {
			if($model_data['id']!=$model_tmp_id) {
				$data_to_csv['Model_ID'] = $model_data['id'];
				$data_to_csv['Category_ID'] = $model_data['cat_id'];
				$data_to_csv['Category_Title'] = $model_data['cat_title'];
				$data_to_csv['Brand'] = $model_data['brand_title'];
				$data_to_csv['Device'] = $model_data['device_title'];
				$data_to_csv['Model_Title'] = $model_data['title'];
				$data_to_csv['Model_Price'] = $model_data['price'];
			} else {
				$data_to_csv['Model_ID'] = '';
				$data_to_csv['Category_ID'] = '';
				$data_to_csv['Category_Title'] = '';
				$data_to_csv['Brand'] = '';
				$data_to_csv['Device'] = '';
				$data_to_csv['Model_Title'] = '';
				$data_to_csv['Model_Price'] = '';
			}
			
			$data_to_csv['Type_ID'] = $model_fields_data['Type_ID'];
			$data_to_csv['Type_Title'] = $model_fields_data['Type_Title'];
			$data_to_csv['Type_Price'] = $model_fields_data['Type_Price'];
			$data_to_csv['Network_ID'] = $model_fields_data['Network_ID'];
			$data_to_csv['Network_Title'] = $model_fields_data['Network_Title'];
			$data_to_csv['Network_Price'] = $model_fields_data['Network_Price'];
			$data_to_csv['Network_UnlockPrice'] = $model_fields_data['Network_UnlockPrice'];
			$data_to_csv['Screen_Size_ID'] = $model_fields_data['Screen_Size_ID'];
			$data_to_csv['Screen_Size_Title'] = $model_fields_data['Screen_Size_Title'];
			$data_to_csv['Screen_Size_Price'] = $model_fields_data['Screen_Size_Price'];
			$data_to_csv['Screen_Resolution_ID'] = $model_fields_data['Screen_Resolution_ID'];
			$data_to_csv['Screen_Resolution_Title'] = $model_fields_data['Screen_Resolution_Title'];
			$data_to_csv['Screen_Resolution_Price'] = $model_fields_data['Screen_Resolution_Price'];
			$data_to_csv['Year_ID'] = $model_fields_data['Year_ID'];
			$data_to_csv['Year_Title'] = $model_fields_data['Year_Title'];
			$data_to_csv['Year_Price'] = $model_fields_data['Year_Price'];
			$data_to_csv['Processor_ID'] = $model_fields_data['Processor_ID'];
			$data_to_csv['Processor_Title'] = $model_fields_data['Processor_Title'];
			$data_to_csv['Processor_Price'] = $model_fields_data['Processor_Price'];
			$data_to_csv['Storage_ID'] = $model_fields_data['Storage_ID'];
			$data_to_csv['Storage_Title'] = $model_fields_data['Storage_Title'];
			$data_to_csv['Storage_Title_Postfix'] = $model_fields_data['Storage_Title_Postfix'];
			$data_to_csv['Storage_Price'] = $model_fields_data['Storage_Price'];
			$data_to_csv['Ram_ID'] = $model_fields_data['Ram_ID'];
			$data_to_csv['Ram_Title'] = $model_fields_data['Ram_Title'];
			$data_to_csv['Ram_Title_Postfix'] = $model_fields_data['Ram_Title_Postfix'];
			$data_to_csv['Ram_Price'] = $model_fields_data['Ram_Price'];
			$data_to_csv['Color_ID'] = $model_fields_data['Color_ID'];
			$data_to_csv['Color_Title'] = $model_fields_data['Color_Title'];
			$data_to_csv['Color_Code'] = $model_fields_data['Color_Code'];
			$data_to_csv['Color_Price'] = $model_fields_data['Color_Price'];
			$data_to_csv['Condition_ID'] = $model_fields_data['Condition_ID'];
			$data_to_csv['Condition_Title'] = $model_fields_data['Condition_Title'];
			$data_to_csv['Condition_Price'] = $model_fields_data['Condition_Price'];
			$data_to_csv['Accessories_ID'] = $model_fields_data['Accessories_ID'];
			$data_to_csv['Accessories_Title'] = $model_fields_data['Accessories_Title'];
			$data_to_csv['Accessories_Price'] = $model_fields_data['Accessories_Price'];
			$data_to_csv_array[] = $data_to_csv;

			$model_tmp_id = $model_data['id'];											
		}
	} else {
		$data_to_csv['Model_ID'] = $model_data['id'];
		$data_to_csv['Category_ID'] = $model_data['cat_id'];
		$data_to_csv['Category_Title'] = $model_data['cat_title'];
		$data_to_csv['Brand'] = $model_data['brand_title'];
		$data_to_csv['Device'] = $model_data['device_title'];
		$data_to_csv['Model_Title'] = $model_data['title'];
		$data_to_csv['Model_Price'] = $model_data['price'];
		$data_to_csv['Type_ID'] = "";
		$data_to_csv['Type_Title'] = "";
		$data_to_csv['Type_Price'] = "";
		$data_to_csv['Network_ID'] = "";
		$data_to_csv['Network_Title'] = "";
		$data_to_csv['Network_Price'] = "";
		$data_to_csv['Network_UnlockPrice'] = "";
		$data_to_csv['Screen_Size_ID'] = "";
		$data_to_csv['Screen_Size_Title'] = "";
		$data_to_csv['Screen_Size_Price'] = "";
		$data_to_csv['Screen_Resolution_ID'] = "";
		$data_to_csv['Screen_Resolution_Title'] = "";
		$data_to_csv['Screen_Resolution_Price'] = "";
		$data_to_csv['Year_ID'] = "";
		$data_to_csv['Year_Title'] = "";
		$data_to_csv['Year_Price'] = "";
		$data_to_csv['Processor_ID'] = "";
		$data_to_csv['Processor_Title'] = "";
		$data_to_csv['Processor_Price'] = "";
		$data_to_csv['Storage_ID'] = "";
		$data_to_csv['Storage_Title'] = "";
		$data_to_csv['Storage_Title_Postfix'] = "";
		$data_to_csv['Storage_Price'] = "";
		$data_to_csv['Ram_ID'] = "";
		$data_to_csv['Ram_Title'] = "";
		$data_to_csv['Ram_Title_Postfix'] = "";
		$data_to_csv['Ram_Price'] = "";
		$data_to_csv['Color_ID'] = "";
		$data_to_csv['Color_Title'] = "";
		$data_to_csv['Color_Code'] = "";
		$data_to_csv['Color_Price'] = "";
		$data_to_csv['Condition_ID'] = "";
		$data_to_csv['Condition_Title'] = "";
		$data_to_csv['Condition_Price'] = "";
		$data_to_csv['Accessories_ID'] = "";
		$data_to_csv['Accessories_Title'] = "";
		$data_to_csv['Accessories_Price'] = "";
		$data_to_csv_array[] = $data_to_csv;
	}
}

//print_r($data_to_csv_array);
//exit;
if(!empty($data_to_csv_array)) {
	foreach($data_to_csv_array as $data_to_csv_data) {
		$f_data_to_csv = array();
		$f_data_to_csv[] = $data_to_csv_data['Model_ID'];
		$f_data_to_csv[] = $data_to_csv_data['Category_ID'];
		$f_data_to_csv[] = $data_to_csv_data['Category_Title'];
		$f_data_to_csv[] = $data_to_csv_data['Brand'];
		$f_data_to_csv[] = $data_to_csv_data['Device'];
		$f_data_to_csv[] = $data_to_csv_data['Model_Title'];
		$f_data_to_csv[] = $data_to_csv_data['Model_Price'];
		$f_data_to_csv[] = $data_to_csv_data['Type_ID'];
		$f_data_to_csv[] = $data_to_csv_data['Type_Title'];
		$f_data_to_csv[] = $data_to_csv_data['Type_Price'];
		$f_data_to_csv[] = $data_to_csv_data['Network_ID'];
		$f_data_to_csv[] = $data_to_csv_data['Network_Title'];
		$f_data_to_csv[] = $data_to_csv_data['Network_Price'];
		$f_data_to_csv[] = $data_to_csv_data['Network_UnlockPrice'];
		$f_data_to_csv[] = $data_to_csv_data['Screen_Size_ID'];
		$f_data_to_csv[] = $data_to_csv_data['Screen_Size_Title'];
		$f_data_to_csv[] = $data_to_csv_data['Screen_Size_Price'];
		$f_data_to_csv[] = $data_to_csv_data['Screen_Resolution_ID'];
		$f_data_to_csv[] = $data_to_csv_data['Screen_Resolution_Title'];
		$f_data_to_csv[] = $data_to_csv_data['Screen_Resolution_Price'];
		$f_data_to_csv[] = $data_to_csv_data['Year_ID'];
		$f_data_to_csv[] = $data_to_csv_data['Year_Title'];
		$f_data_to_csv[] = $data_to_csv_data['Year_Price'];
		$f_data_to_csv[] = $data_to_csv_data['Processor_ID'];
		$f_data_to_csv[] = $data_to_csv_data['Processor_Title'];
		$f_data_to_csv[] = $data_to_csv_data['Processor_Price'];
		$f_data_to_csv[] = $data_to_csv_data['Storage_ID'];
		$f_data_to_csv[] = $data_to_csv_data['Storage_Title'];
		$f_data_to_csv[] = $data_to_csv_data['Storage_Title_Postfix'];
		$f_data_to_csv[] = $data_to_csv_data['Storage_Price'];
		$f_data_to_csv[] = $data_to_csv_data['Ram_ID'];
		$f_data_to_csv[] = $data_to_csv_data['Ram_Title'];
		$f_data_to_csv[] = $data_to_csv_data['Ram_Title_Postfix'];
		$f_data_to_csv[] = $data_to_csv_data['Ram_Price'];
		$f_data_to_csv[] = $data_to_csv_data['Color_ID'];
		$f_data_to_csv[] = $data_to_csv_data['Color_Title'];
		$f_data_to_csv[] = $data_to_csv_data['Color_Code'];
		$f_data_to_csv[] = $data_to_csv_data['Color_Price'];
		$f_data_to_csv[] = $data_to_csv_data['Condition_ID'];
		$f_data_to_csv[] = $data_to_csv_data['Condition_Title'];
		$f_data_to_csv[] = $data_to_csv_data['Condition_Price'];
		$f_data_to_csv[] = $data_to_csv_data['Accessories_ID'];
		$f_data_to_csv[] = $data_to_csv_data['Accessories_Title'];
		$f_data_to_csv[] = $data_to_csv_data['Accessories_Price'];
		fputcsv($fp, $f_data_to_csv);
	}
}
?>