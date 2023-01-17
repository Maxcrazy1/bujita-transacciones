<?php
$header = array('Model_ID',
	'Category_ID',
	'Category_Title',
	'Brand',
	'Device',
	'Model_Title',
	'Model_Price',
	'Network_ID',
	'Network_Title',
	'Network_Price',
	'Network_UnlockPrice',
	'Storage_ID',
	'Storage_Title',
	'Storage_Title_Postfix',
	'Storage_Price',
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
	$network_items_array = get_models_networks_data($model_id);
	$storage_items_array = get_models_storage_data($model_id);
	$colors_items_array = get_models_color_data($model_id);
	$condition_items_array = get_models_condition_data($model_id);
	$accessories_items_array = get_models_accessories_data($model_id);
	
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
			
			$data_to_csv['Network_ID'] = $model_fields_data['Network_ID'];
			$data_to_csv['Network_Title'] = $model_fields_data['Network_Title'];
			$data_to_csv['Network_Price'] = $model_fields_data['Network_Price'];
			$data_to_csv['Network_UnlockPrice'] = $model_fields_data['Network_UnlockPrice'];
			$data_to_csv['Storage_ID'] = $model_fields_data['Storage_ID'];
			$data_to_csv['Storage_Title'] = $model_fields_data['Storage_Title'];
			$data_to_csv['Storage_Title_Postfix'] = $model_fields_data['Storage_Title_Postfix'];
			$data_to_csv['Storage_Price'] = $model_fields_data['Storage_Price'];
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
		$data_to_csv['Network_ID'] = "";
		$data_to_csv['Network_Title'] = "";
		$data_to_csv['Network_Price'] = "";
		$data_to_csv['Network_UnlockPrice'] = "";
		$data_to_csv['Storage_ID'] = "";
		$data_to_csv['Storage_Title'] = "";
		$data_to_csv['Storage_Title_Postfix'] = "";
		$data_to_csv['Storage_Price'] = "";
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
		$f_data_to_csv[] = $data_to_csv_data['Network_ID'];
		$f_data_to_csv[] = $data_to_csv_data['Network_Title'];
		$f_data_to_csv[] = $data_to_csv_data['Network_Price'];
		$f_data_to_csv[] = $data_to_csv_data['Network_UnlockPrice'];
		$f_data_to_csv[] = $data_to_csv_data['Storage_ID'];
		$f_data_to_csv[] = $data_to_csv_data['Storage_Title'];
		$f_data_to_csv[] = $data_to_csv_data['Storage_Title_Postfix'];
		$f_data_to_csv[] = $data_to_csv_data['Storage_Price'];
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