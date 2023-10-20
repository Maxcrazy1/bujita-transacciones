<?php
$Type_ID = $excel_file_data[7];
$Type_Title = real_escape_string($excel_file_data[8]);
$Type_Price = $excel_file_data[9];
$Network_ID = $excel_file_data[10];
$Network_Title = real_escape_string($excel_file_data[11]);
$Network_Price = $excel_file_data[12];
$Network_UnlockPrice = $excel_file_data[13];
$Screen_Size_ID = $excel_file_data[14];
$Screen_Size_Title = real_escape_string($excel_file_data[15]);
$Screen_Size_Price = $excel_file_data[16];
$Screen_Resolution_ID = $excel_file_data[17];
$Screen_Resolution_Title = real_escape_string($excel_file_data[18]);
$Screen_Resolution_Price = $excel_file_data[19];
$Year_ID = $excel_file_data[20];
$Year_Title = real_escape_string($excel_file_data[21]);
$Year_Price = $excel_file_data[22];
$Processor_ID = $excel_file_data[23];
$Processor_Title = real_escape_string($excel_file_data[24]);
$Processor_Price = $excel_file_data[25];
$Storage_ID = $excel_file_data[26];
$Storage_Title = real_escape_string($excel_file_data[27]);
$Storage_Title_Postfix = $excel_file_data[28];
$Storage_Price = $excel_file_data[29];
$Ram_ID = $excel_file_data[30];
$Ram_Title = real_escape_string($excel_file_data[31]);
$Ram_Title_Postfix = $excel_file_data[32];
$Ram_Price = $excel_file_data[33];
$Color_ID = $excel_file_data[34];
$Color_Title = real_escape_string($excel_file_data[35]);
$Color_Code = $excel_file_data[36];
$Color_Price = $excel_file_data[37];
$Condition_ID = $excel_file_data[38];
$Condition_Title = real_escape_string($excel_file_data[39]);
$Condition_Price = $excel_file_data[40];
$Accessories_ID = $excel_file_data[41];
$Accessories_Title = real_escape_string($excel_file_data[42]);
$Accessories_Price = $excel_file_data[43];

if($f_model_id>0) {
	if($Type_Title!="") {
		$q_mn=mysqli_query($db,"SELECT * FROM models_watchtype WHERE id='".$Type_ID."' AND model_id='".$f_model_id."'");
		$exist_models_network_data=mysqli_fetch_assoc($q_mn);
		if(empty($exist_models_network_data)) {
			mysqli_query($db,"INSERT INTO models_watchtype(model_id, watchtype_name, watchtype_price) VALUES('".$f_model_id."','".$Type_Title."','".$Type_Price."')");
		} else {
			mysqli_query($db,"UPDATE models_watchtype SET watchtype_name='".$Type_Title."', watchtype_price='".$Type_Price."' WHERE id='".$Type_ID."' AND model_id='".$f_model_id."'");
		}
	}
	
	if($Network_Title!="") {
		$q_mn=mysqli_query($db,"SELECT * FROM models_networks WHERE id='".$Network_ID."' AND model_id='".$f_model_id."'");
		$exist_models_network_data=mysqli_fetch_assoc($q_mn);
		if(empty($exist_models_network_data)) {
			mysqli_query($db,"INSERT INTO models_networks(model_id, network_name, network_price, network_unlock_price) VALUES('".$f_model_id."','".$Network_Title."','".$Network_Price."','".$Network_UnlockPrice."')");
		} else {
			mysqli_query($db,"UPDATE models_networks SET network_name='".$Network_Title."', network_price='".$Network_Price."', network_unlock_price='".$Network_UnlockPrice."' WHERE id='".$Network_ID."' AND model_id='".$f_model_id."'");
		}
	}
	
	if($Screen_Size_Title!="") {
		$q_ss=mysqli_query($db,"SELECT * FROM models_screen_size WHERE id='".$Screen_Size_ID."' AND model_id='".$f_model_id."'");
		$exist_models_screen_size_data=mysqli_fetch_assoc($q_ss);
		if(empty($exist_models_screen_size_data)) {
			mysqli_query($db,"INSERT INTO models_screen_size(model_id, screen_size_name, screen_size_price) VALUES('".$f_model_id."','".$Screen_Size_Title."','".$Screen_Size_Price."')");
		} else {
			mysqli_query($db,"UPDATE models_screen_size SET screen_size_name='".$Screen_Size_Title."', screen_size_price='".$Screen_Size_Price."' WHERE id='".$Screen_Size_ID."' AND model_id='".$f_model_id."'");
		}
	}
	
	if($Screen_Resolution_Title!="") {
		$q_sr=mysqli_query($db,"SELECT * FROM models_screen_resolution WHERE id='".$Screen_Resolution_ID."' AND model_id='".$f_model_id."'");
		$exist_models_screen_resolution_data=mysqli_fetch_assoc($q_sr);
		if(empty($exist_models_screen_resolution_data)) {
			mysqli_query($db,"INSERT INTO models_screen_resolution(model_id, screen_resolution_name, screen_resolution_price) VALUES('".$f_model_id."','".$Screen_Resolution_Title."','".$Screen_Resolution_Price."')");
		} else {
			mysqli_query($db,"UPDATE models_screen_resolution SET screen_resolution_name='".$Screen_Resolution_Title."', screen_resolution_price='".$Screen_Resolution_Price."' WHERE id='".$Screen_Resolution_ID."' AND model_id='".$f_model_id."'");
		}
	}
	
	if($Year_Title!="") {
		$q_ly=mysqli_query($db,"SELECT * FROM models_lyear WHERE id='".$Year_ID."' AND model_id='".$f_model_id."'");
		$exist_models_year_data=mysqli_fetch_assoc($q_ly);
		if(empty($exist_models_year_data)) {
			mysqli_query($db,"INSERT INTO models_lyear(model_id, lyear_name, lyear_price) VALUES('".$f_model_id."','".$Year_Title."','".$Year_Price."')");
		} else {
			mysqli_query($db,"UPDATE models_lyear SET lyear_name='".$Year_Title."', lyear_price='".$Year_Price."' WHERE id='".$Year_ID."' AND model_id='".$f_model_id."'");
		}
	}
	
	if($Processor_Title!="") {
		$q_prcr=mysqli_query($db,"SELECT * FROM models_processor WHERE id='".$Processor_ID."' AND model_id='".$f_model_id."'");
		$exist_models_processor_data=mysqli_fetch_assoc($q_prcr);
		if(empty($exist_models_processor_data)) {
			mysqli_query($db,"INSERT INTO models_processor(model_id, processor_name, processor_price) VALUES('".$f_model_id."','".$Processor_Title."','".$Processor_Price."')");
		} else {
			mysqli_query($db,"UPDATE models_processor SET processor_name='".$Processor_Title."', processor_price='".$Processor_Price."' WHERE id='".$Processor_ID."' AND model_id='".$f_model_id."'");
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
	
	if($Ram_Title!="") {
		$q_rm=mysqli_query($db,"SELECT * FROM models_ram WHERE id='".$Ram_ID."' AND model_id='".$f_model_id."'");
		$exist_models_ram_data=mysqli_fetch_assoc($q_rm);
		if(empty($exist_models_ram_data)) {
			mysqli_query($db,"INSERT INTO models_ram(model_id, ram_size, ram_size_postfix, ram_price) VALUES('".$f_model_id."','".$Ram_Title."','".$Ram_Title_Postfix."','".$Ram_Price."')");
		} else {
			mysqli_query($db,"UPDATE models_ram SET ram_size='".$Ram_Title."', ram_size_postfix='".$Ram_Title_Postfix."', ram_price='".$Ram_Price."' WHERE id='".$Ram_ID."' AND model_id='".$f_model_id."'");
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