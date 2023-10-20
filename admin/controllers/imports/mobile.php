<?php
$Network_ID = $excel_file_data[7];
$Network_Title = real_escape_string($excel_file_data[8]);
$Network_Price = $excel_file_data[9];
$Network_UnlockPrice = $excel_file_data[10];
$Storage_ID = $excel_file_data[11];
$Storage_Title = real_escape_string($excel_file_data[12]);
$Storage_Title_Postfix = $excel_file_data[13];
$Storage_Price = $excel_file_data[14];
$Color_ID = $excel_file_data[15];
$Color_Title = real_escape_string($excel_file_data[16]);
$Color_Code = $excel_file_data[17];
$Color_Price = $excel_file_data[18];
$Condition_ID = $excel_file_data[19];
$Condition_Title = real_escape_string($excel_file_data[20]);
$Condition_Price = $excel_file_data[21];
$Accessories_ID = $excel_file_data[22];
$Accessories_Title = real_escape_string($excel_file_data[23]);
$Accessories_Price = $excel_file_data[24];

if($f_model_id>0) {
	if($Network_Title!="") {
		$q_mn=mysqli_query($db,"SELECT * FROM models_networks WHERE id='".$Network_ID."' AND model_id='".$f_model_id."'");
		$exist_models_network_data=mysqli_fetch_assoc($q_mn);
		if(empty($exist_models_network_data)) {
			mysqli_query($db,"INSERT INTO models_networks(model_id, network_name, network_price, network_unlock_price) VALUES('".$f_model_id."','".$Network_Title."','".$Network_Price."','".$Network_UnlockPrice."')");
		} else {
			mysqli_query($db,"UPDATE models_networks SET network_name='".$Network_Title."', network_price='".$Network_Price."', network_unlock_price='".$Network_UnlockPrice."' WHERE id='".$Network_ID."' AND model_id='".$f_model_id."'");
		}
	}
	
	if($Storage_Title!="") {
		$q_ms=mysqli_query($db,"SELECT * FROM models_storage WHERE id='".$Storage_ID."' AND model_id='".$f_model_id."'");
		$exist_models_storage_data=mysqli_fetch_assoc($q_ms);
		if(empty($exist_models_storage_data)) {
			mysqli_query($db,"INSERT INTO models_storage(model_id, storage_size, storage_size_postfix, storage_price) VALUES('".$f_model_id."','".$Storage_Title."','".$Storage_Title_Postfix."','".$Storage_Price."')");
		} else {
			mysqli_query($db,"UPDATE models_storage SET storage_size='".$Storage_Title."', storage_size_postfix='".$Storage_Title_Postfix."', storage_price='".$Storage_Price."' WHERE id='".$Storage_ID."' AND model_id='".$f_model_id."'");
		}
	}
	
	if($Color_Title!="") {
		$q_clr=mysqli_query($db,"SELECT * FROM models_color WHERE id='".$Color_ID."' AND model_id='".$f_model_id."'");
		$exist_models_color_data=mysqli_fetch_assoc($q_clr);
		if(empty($exist_models_color_data)) {
			mysqli_query($db,"INSERT INTO models_color(model_id, color_name, color_code, color_price) VALUES('".$f_model_id."','".$Color_Title."','".$Color_Code."','".$Color_Price."')");
		} else {
			mysqli_query($db,"UPDATE models_color SET color_name='".$Color_Title."', color_code='".$Color_Code."', color_price='".$Color_Price."' WHERE id='".$Color_ID."' AND model_id='".$f_model_id."'");
		}
	}
	
	if($Condition_Title!="") {
		$q_mc=mysqli_query($db,"SELECT * FROM models_condition WHERE id='".$Condition_ID."' AND model_id='".$f_model_id."'");
		$exist_models_condition_data=mysqli_fetch_assoc($q_mc);
		if(empty($exist_models_condition_data)) {
			mysqli_query($db,"INSERT INTO models_condition(model_id, condition_name, condition_price) VALUES('".$f_model_id."','".$Condition_Title."','".$Condition_Price."')");
		} else {
			mysqli_query($db,"UPDATE models_condition SET condition_name='".$Condition_Title."', condition_price='".$Condition_Price."' WHERE id='".$Condition_ID."' AND model_id='".$f_model_id."'");
		}
	}
	
	if($Accessories_Title!="") {
		$q_macc=mysqli_query($db,"SELECT * FROM models_accessories WHERE id='".$Accessories_ID."' AND model_id='".$f_model_id."'");
		$exist_models_accessories_data=mysqli_fetch_assoc($q_macc);
		if(empty($exist_models_accessories_data)) {
			mysqli_query($db,"INSERT INTO models_accessories(model_id, accessories_name, accessories_price) VALUES('".$f_model_id."','".$Accessories_Title."','".$Accessories_Price."')");
		} else {
			mysqli_query($db,"UPDATE models_accessories SET accessories_name='".$Accessories_Title."', accessories_price='".$Accessories_Price."' WHERE id='".$Accessories_ID."' AND model_id='".$f_model_id."'");
		}
	}
} ?>