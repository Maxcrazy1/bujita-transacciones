<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");
require_once('../models/mobile.php');
require_once('../admin/_config/connect_db.php');

$final_model_amt = 0;
$device_name = '';
if($_SESSION['user_id']){
    $user_state = true;
}else{
    $user_state = false;
}
$req_data = $_REQUEST;
$req_model_id = $req_data['model_id'];
$fields_cat_type = $req_data['fields_cat_type'];
$network_price_mode = $req_data['network_price_mode'];
$step_type = $req_data['step_type'];

$email_state = $req_data['email_state'];

$model_data = get_single_model_data($req_model_id);
$model_price = $model_data['price'];
$f_model_price = $model_price;
$f_other_item_price = $model_price;

if($req_model_id) {
	$storage_list = array();
	$condition_list = array();
	$network_list = array();
	$color_list = array();
	$accessories_list = array();
	$watchtype_list = array();
	$case_material_list = array();
	$case_size_list = array();
	$screen_size_list = array();
	$screen_resolution_list = array();
	$lyear_list = array();
	$processor_list = array();
	$ram_list = array();
	
	$storage_id = $req_data['storage_id'];
	$condition_id = $req_data['condition_id'];
	$network_id = $req_data['network_id'];
	$color_id = $req_data['color_id'];
	$accessories_ids = $req_data['accessories_ids'];
	$case_size_id = $req_data['case_size_id'];
	$watchtype_id = $req_data['watchtype_id'];
	$case_material_id = $req_data['case_material_id'];
	$screen_size_id = $req_data['screen_size_id'];
	$screen_resolution_id = $req_data['screen_resolution_id'];
	$lyear_id = $req_data['lyear_id'];
	$processor_id = $req_data['processor_id'];
	$ram_id = $req_data['ram_id'];

	if($storage_id>0) {
		$storage_list = get_models_storage_data($req_model_id,array($storage_id));
	}
	if($condition_id>0) {
		$condition_list = get_models_condition_data($req_model_id,array($condition_id));
	}
	if($network_id>0) {
		$network_list = get_models_networks_data($req_model_id,array($network_id));
	}
	if(!empty($color_id)) {
		$color_list = get_models_color_data($req_model_id,array($color_id));
	}
	if(!empty($accessories_ids)) {
		$accessories_list = get_models_accessories_data($req_model_id,$accessories_ids);
	}
	if($watchtype_id>0) {
		$watchtype_list = get_models_watchtype_data($req_model_id,array($watchtype_id));
		$network_mode = $watchtype_list[0]['disabled_network'];
	}

	// Storage
	//$storage_price = ($storage_list[0]['storage_price']>0?$storage_list[0]['storage_price']:'0');
	$storage_price = $storage_list[0]['storage_price'];
	$req_storage = $storage_list[0]['storage_size'].$storage_list[0]['storage_size_postfix'];
	
	$f_model_price = ($f_model_price+$storage_price);
	$f_other_item_price = ($f_other_item_price+$storage_price);
	// Storage
	
	// Condition
	$condition_name = $condition_list[0]['condition_name'];
	$cond_amt = $condition_list[0]['condition_price'];
	//$cond_amt = ($condition_list[0]['condition_price']>0?$condition_list[0]['condition_price']:'0');
	
	$f_model_price = ($f_model_price+$cond_amt);
	$f_other_item_price = ($f_other_item_price+$cond_amt);
	// Condition

	// Network
	$network_name = "";
	$network_amt = 0;
	if($fields_cat_type == "mobile" || ($fields_cat_type != "mobile" && $network_mode == '1')) {
		$network_name = $network_list[0]['network_name'];
		if($network_price_mode == "unlock" || preg_match("/unlock/",strtolower($network_name))) {
		    $network_amt = $network_list[0]['network_unlock_price'];
			//$network_amt = ($network_list[0]['network_unlock_price']>0?$network_list[0]['network_unlock_price']:'0');
		} else {
		    $network_amt = $network_list[0]['network_price'];
			//$network_amt = ($network_list[0]['network_price']>0?$network_list[0]['network_price']:'0');
		}

		$f_model_price = ($f_model_price+$network_amt);
		$f_other_item_price = ($f_other_item_price+$network_amt);
	}
	// Network
	
	// Colors
	$color_name = $color_list[0]['color_name'];
	$color_price = $color_list[0]['color_price'];
	//$color_price = ($color_list[0]['color_price']>0?$color_list[0]['color_price']:'0');

	$f_model_price = ($f_model_price+$color_price);
	$f_other_item_price = ($f_other_item_price+$color_price);
	// Colors

	// Accessories
	if(count($accessories_list)>0) {
		foreach($accessories_list as $accessories_data) {
			$accessories_price = $accessories_data['accessories_price'];
			$accessories_name .= $accessories_data['accessories_name'].': Yes, ';

			$f_model_price = ($f_model_price+$accessories_price);
			$f_other_item_price = ($f_other_item_price+$accessories_price);
		}
	} // Accessories
	
	// Watchtype
	$watchtype_name = $watchtype_list[0]['watchtype_name'];
	$watchtype_amt = $watchtype_list[0]['watchtype_price'];
	//$watchtype_amt = ($watchtype_list[0]['watchtype_price']>0?$watchtype_list[0]['watchtype_price']:'0');
	
	$f_model_price = ($f_model_price+$watchtype_amt);
	$f_other_item_price = ($f_other_item_price+$watchtype_amt);
	// Watchtype

	if($fields_cat_type == "mobile") {
		$storage = ($req_storage?$req_storage:"N/A");
		$network = ($network_name?$network_name:"N/A");
		if($req_model_id && $condition_name && $storage && $network) {
			$mc_query=mysqli_query($db,"SELECT * FROM model_catalog WHERE model_id='".$req_model_id."' AND network='".$network."' AND storage='".$storage."'");
			$model_catalog_data=mysqli_fetch_assoc($mc_query);
		}
		
		if($network_name) {
			$device_name .= ', '.$network_name;
		}
		if($req_storage) {
			$device_name .= ', '.$req_storage;
		}
		if($color_name) {
			$device_name .= ', '.$color_name;
		}
		if($condition_name) {
			$device_name .= ', '.$condition_name;
		}
		if(rtrim($accessories_name,', ')) {
			$device_name .= ', '.rtrim($accessories_name,', ');
		}
	}
	if($fields_cat_type == "tablet") {
		$fwatchtype_name = ($watchtype_name?$watchtype_name:"N/A");
		$freq_storage = ($req_storage?$req_storage:"N/A");
		if($req_model_id && $condition_name && $fwatchtype_name && $freq_storage) {
			$mc_query=mysqli_query($db,"SELECT * FROM model_catalog WHERE model_id='".$req_model_id."' AND storage='".$freq_storage."' AND watchtype='".$fwatchtype_name."'");
			$model_catalog_data=mysqli_fetch_assoc($mc_query);
		}

		if($watchtype_name) {
			$device_name .= ', '.$watchtype_name;
		}
		if($network_name) {
			$device_name .= ', '.$network_name;
		}
		if($req_storage) {
			$device_name .= ', '.$req_storage;
		}
		if($color_name) {
			$device_name .= ', '.$color_name;
		}
		if($condition_name) {
			$device_name .= ', '.$condition_name;
		}
		if(rtrim($accessories_name,', ')) {
			$device_name .= ', '.rtrim($accessories_name,', ');
		}
	}
	if($fields_cat_type == "watch") {
		if($case_material_id>0) {
			$case_material_list = get_models_case_material_data($req_model_id,array($case_material_id));
		}
		if($case_size_id>0) {
			$case_size_list = get_models_case_size_data($req_model_id,array($case_size_id));
		}
		
		// Case Material
		$case_material_name = $case_material_list[0]['case_material_name'];
		$case_material_amt = $case_material_list[0]['case_material_price'];
		//$case_material_amt = ($case_material_list[0]['case_material_price']>0?$case_material_list[0]['case_material_price']:'0');
		
		$f_model_price = ($f_model_price+$case_material_amt);
		$f_other_item_price = ($f_other_item_price+$case_material_amt);
		// Case Material
		
		// Case Size
		$case_size = $case_size_list[0]['case_size'];
		$case_size_amt = $case_size_list[0]['case_size_price'];
		//$case_size_amt = ($case_size_list[0]['case_size_price']>0?$case_size_list[0]['case_size_price']:'0');
		
		$f_model_price = ($f_model_price+$case_size_amt);
		$f_other_item_price = ($f_other_item_price+$case_size_amt);
		// Case Size
	
		$fwatchtype_name = ($watchtype_name?$watchtype_name:"N/A");
		$fcase_size = ($case_size?$case_size:"N/A");
		$fcase_material = ($case_material_name?$case_material_name:"N/A");
		if($req_model_id && $condition_name && $fwatchtype_name && $fcase_size && $fcase_material) {
			$mc_query=mysqli_query($db,"SELECT * FROM model_catalog WHERE model_id='".$req_model_id."' AND case_size='".$fcase_size."' AND case_material='".$fcase_material."' AND watchtype='".$fwatchtype_name."'");
			$model_catalog_data=mysqli_fetch_assoc($mc_query);
		}
		
		if($watchtype_name) {
			$device_name .= ', '.$watchtype_name;
		}
		if($network_name) {
			$device_name .= ', '.$network_name;
		}
		if($req_storage) {
			$device_name .= ', '.$req_storage;
		}
		if($case_material_name) {
			$device_name .= ', '.$case_material_name;
		}
		if($case_size) {
			$device_name .= ', '.$case_size;
		}
		if($color_name) {
			$device_name .= ', '.$color_name;
		}
		if($condition_name) {
			$device_name .= ', '.$condition_name;
		}
		if(rtrim($accessories_name,', ')) {
			$device_name .= ', '.rtrim($accessories_name,', ');
		}
	}
	if($fields_cat_type == "laptop") {
		if($screen_size_id>0) {
			$screen_size_list = get_models_screen_size_data($req_model_id,array($screen_size_id));
		}
		if($screen_resolution_id>0) {
			$screen_resolution_list = get_models_screen_resolution_data($req_model_id,array($screen_resolution_id));
		}
		if($lyear_id>0) {
			$lyear_list = get_models_lyear_data($req_model_id,array($lyear_id));
		}
		if($processor_id>0) {
			$processor_list = get_models_processor_data($req_model_id,array($processor_id));
		}
		if($ram_id>0) {
			$ram_list = get_models_ram_data($req_model_id,array($ram_id));
		}
		
		// Screen Size
		$screen_size_name = $screen_size_list[0]['screen_size_name'];
		$screen_size_amt = $screen_size_list[0]['screen_size_price'];
		//$screen_size_amt = ($screen_size_list[0]['screen_size_price']>0?$screen_size_list[0]['screen_size_price']:'0');
		
		$f_model_price = ($f_model_price+$screen_size_amt);
		$f_other_item_price = ($f_other_item_price+$screen_size_amt);
		// Screen Size
		
		// Screen Resolution
		$screen_resolution_name = $screen_resolution_list[0]['screen_resolution_name'];
		$screen_resolution_amt = $screen_resolution_list[0]['screen_resolution_price'];
		//$screen_resolution_amt = ($screen_resolution_list[0]['screen_resolution_price']>0?$screen_resolution_list[0]['screen_resolution_price']:'0');
		
		$f_model_price = ($f_model_price+$screen_resolution_amt);
		$f_other_item_price = ($f_other_item_price+$screen_resolution_amt);
		// Screen Resolution
		
		// lyear
		$lyear_name = $lyear_list[0]['lyear_name'];
		$lyear_amt = $lyear_list[0]['lyear_price'];
		//$lyear_amt = ($lyear_list[0]['lyear_price']>0?$lyear_list[0]['lyear_price']:'0');
		
		$f_model_price = ($f_model_price+$lyear_amt);
		$f_other_item_price = ($f_other_item_price+$lyear_amt);
		// lyear
		
		// Processor
		$processor_name = $processor_list[0]['processor_name'];
		$processor_amt = $processor_list[0]['processor_price'];
		//$processor_amt = ($processor_list[0]['processor_price']>0?$processor_list[0]['processor_price']:'0');
		
		$f_model_price = ($f_model_price+$processor_amt);
		$f_other_item_price = ($f_other_item_price+$processor_amt);
		// Processor
		
		// Ram
		$ram_name = $ram_list[0]['ram_size'].$ram_list[0]['ram_size_postfix'];
		$ram_amt = $ram_list[0]['ram_price'];
		//$ram_amt = ($ram_list[0]['ram_price']>0?$ram_list[0]['ram_price']:'0');
		
		$f_model_price = ($f_model_price+$ram_amt);
		$f_other_item_price = ($f_other_item_price+$ram_amt);
		// Ram
		
		$fwatchtype_name = ($watchtype_name?$watchtype_name:"N/A");
		$fscreen_size_name = ($screen_size_name?$screen_size_name:"N/A");
		$fprocessor_name = ($processor_name?$processor_name:"N/A");
		$freq_storage = ($req_storage?$req_storage:"N/A");
		$fram_name = ($ram_name?$ram_name:"N/A");
		if($req_model_id && $condition_name && $fwatchtype_name && $fscreen_size_name && $processor_name && $freq_storage && $fram_name) {
			$mc_query=mysqli_query($db,"SELECT * FROM model_catalog WHERE model_id='".$req_model_id."' AND screen_size='".$fscreen_size_name."' AND processor='".$fprocessor_name."' AND watchtype='".$fwatchtype_name."' AND storage='".$freq_storage."' AND ram='".$fram_name."'");
			$model_catalog_data=mysqli_fetch_assoc($mc_query);
		}
		
		if($watchtype_name) {
			$device_name .= ', '.$watchtype_name;
		}
		if($network_name) {
			$device_name .= ', '.$network_name;
		}
		
		if($screen_size_name) {
			$device_name .= ', '.$screen_size_name;
		}
		if($screen_resolution_name) {
			$device_name .= ', '.$screen_resolution_name;
		}
		if($lyear_name) {
			$device_name .= ', '.$lyear_name;
		}
		if($processor_name) {
			$device_name .= ', '.$processor_name;
		}
		
		if($req_storage) {
			$device_name .= ', '.$req_storage;
		}
		if($ram_name) {
			$device_name .= ', '.$ram_name;
		}
		if($color_name) {
			$device_name .= ', '.$color_name;
		}
		if($condition_name) {
			$device_name .= ', '.$condition_name;
		}
		if(rtrim($accessories_name,', ')) {
			$device_name .= ', '.rtrim($accessories_name,', ');
		}
	}
	
	$device_name = ltrim($device_name,', ');
	$final_model_amt = $f_model_price;
}

$final_model_amt = 0;
if($model_catalog_data['conditions']) {
	$ps_condition_items_array = json_decode($model_catalog_data['conditions'],true);
	if($ps_condition_items_array[$condition_name]) {
		$final_model_amt = $ps_condition_items_array[$condition_name];
	}
}

if($final_model_amt>0) {
	$response_array = array();
	$response_array['payment_amt'] = $final_model_amt;
	
	if($req_data['is_admin'] == '1' && $req_data['quantity']>1) {
		$final_model_amt = ($final_model_amt * $req_data['quantity']);
		$_final_model_amt=$currency_symbol.$final_model_amt;
		$response_array['show_final_amt'] = $_final_model_amt;
	} else {
		//$_final_model_amt=amount_fomat($final_model_amt);
		$_final_model_amt=$currency_symbol.$final_model_amt;
		$response_array['show_final_amt'] = $_final_model_amt;
	}
	$response_array['device_name'] = $device_name;
	$response_array['network_name'] = strtolower($network_name);
} else {
	$response_array['payment_amt'] = '0';
	$_final_model_amt=amount_fomat('0');
	$response_array['show_final_amt'] = $_final_model_amt;
	$response_array['device_name'] = $device_name;
	$response_array['network_name'] = strtolower($network_name);
	//$response_array['device_name'] = '';
	//$response_array['network_name'] = '';
}
    $response_array['email_state'] = false;
    $response_array['user_state'] = $user_state;
    if($user_state && $final_model_amt!=0 ){
        $user_details = get_user_data(intval($_SESSION['user_id']));
        $htmlContent = '
                        <p>Nombre del cliente:'.$user_details['name'].'</p>
                        <p>Correo electrónico del cliente:'.$user_details['email'].'</p>
                        <p>Número de teléfono móvil: 669692502</p>
                        <table style="width:100%;border:1px solid black;">
                          <tr>
                            <td>Marca</td>
                            <td>:'.$response_array['device_name'].'</td>
                          </tr>
                          
                          <tr>
                            <td>Almacenamiento</td>
                            <td>:'.$req_storage.'</td>
                          </tr>
                          
                          <tr>
                            <td>Nombre</td>
                            <td>:'.$user_details['name'].'</td>
                          </tr>
                          
                          <tr>
                            <td>Email</td>
                            <td>:'.$user_details['email'].'</td>
                          </tr>
                        </table>'; 
     
        
            $mail_res= send_email_text($user_details['email'],'cotización for '.$response_array['device_name'],$htmlContent,FROM_NAME,FROM_EMAIL);
            $response_array['email_state'] = true;
        
        
        
    }
    // echo $user_details;
echo json_encode(true);
exit;