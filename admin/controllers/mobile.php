<?php 
require_once("../_config/config.php");
require_once("../include/functions.php");

if($post['r_img_id']) {
	$mobile_data_q=mysqli_query($db,'SELECT model_img FROM mobile WHERE id="'.$post['r_img_id'].'"');
	$mobile_data=mysqli_fetch_assoc($mobile_data_q);

	mysqli_query($db,'UPDATE mobile SET model_img="" WHERE id='.$post['r_img_id']);
	if($mobile_data['model_img']!="")
		unlink('../../images/mobile/'.$mobile_data['model_img']);

	setRedirect(ADMIN_URL.'edit_mobile.php?id='.$post['id']);
} elseif(isset($post['pricing'])) {
	if($post['id']) {
		$category_data = get_category_data($post['cat_id']);
		$fields_type = $category_data['fields_type'];

		$d_mc_query=mysqli_query($db,'DELETE FROM model_catalog WHERE model_id="'.$post['id'].'"');
		if($d_mc_query=="1") {
			if(!empty($post['p_cond_price'])) {
				if($fields_type == "mobile" || $fields_type == "tablet") {
					foreach($post['p_cond_price'] as $p_n=>$p_cond_price_data) {
						foreach($p_cond_price_data as $p_s=>$p_cond_price_subdata) {
							$p_condition_data=real_escape_string(json_encode($p_cond_price_subdata));
							if($fields_type == "mobile") {
								mysqli_query($db,'INSERT INTO model_catalog(model_id, network, storage, conditions) values("'.$post['id'].'","'.$p_n.'","'.$p_s.'","'.$p_condition_data.'")');
							} elseif($fields_type == "tablet") {
								mysqli_query($db,'INSERT INTO model_catalog(model_id, watchtype, storage, conditions) values("'.$post['id'].'","'.$p_n.'","'.$p_s.'","'.$p_condition_data.'")');
							}
						}
					}
				} elseif($fields_type == "watch") {
					foreach($post['p_cond_price'] as $p_n=>$p_cond_price_data) {
						foreach($p_cond_price_data as $p_s=>$p_cond_price_subdata) {
							foreach($p_cond_price_subdata as $p_ss=>$p_cond_price_subdata_subdata) {
								$p_condition_data=real_escape_string(json_encode($p_cond_price_subdata_subdata));
								if($fields_type == "watch") {
									mysqli_query($db,'INSERT INTO model_catalog(model_id, watchtype, case_size, case_material, conditions) values("'.$post['id'].'","'.$p_n.'","'.$p_s.'","'.$p_ss.'","'.$p_condition_data.'")');
								}
							}
						}
					}
				} elseif($fields_type == "other") {
					foreach($post['p_cond_price'] as $p_n=>$p_cond_price_data) {
						$p_condition_data=real_escape_string(json_encode($p_cond_price_data));
						if($fields_type == "other") {
							mysqli_query($db,'INSERT INTO model_catalog(model_id, model, conditions) values("'.$post['id'].'","'.$p_n.'","'.$p_condition_data.'")');
						}
					}
				} elseif($fields_type == "laptop") {
					foreach($post['p_cond_price'] as $p_n=>$p_cond_price_data) {
						foreach($p_cond_price_data as $p_s=>$p_cond_price_subdata) {
							foreach($p_cond_price_subdata as $p_ss=>$p_cond_price_subdata_subdata) {
								foreach($p_cond_price_subdata_subdata as $p_sss=>$p_cond_price_sub_sub_sub) {
									foreach($p_cond_price_sub_sub_sub as $p_ssss=>$p_cond_price_sub_sub_sub_sub) {
										$p_condition_data=real_escape_string(json_encode($p_cond_price_sub_sub_sub_sub));
										if($fields_type == "laptop") {
											mysqli_query($db,'INSERT INTO model_catalog(model_id, watchtype, screen_size, processor, storage, ram, conditions) values("'.$post['id'].'","'.$p_n.'","'.$p_s.'","'.$p_ss.'","'.$p_sss.'","'.$p_ssss.'","'.$p_condition_data.'")');
										}
									}
								}
							}
						}
					}
				}
			}
		}

		$msg="Model pricing has been successfully updated.";
		$_SESSION['success_msg']=$msg;
		//setRedirect(ADMIN_URL.'edit_mobile.php?id='.$post['id'].'&pricing=1');
		setRedirect(ADMIN_URL.'edit_mobile.php?id='.$post['id']);
	}
} elseif(isset($post['d_id'])) {
	$mobile_q=mysqli_query($db,'SELECT model_img FROM mobile WHERE id="'.$post['d_id'].'"');
	$mobile_data=mysqli_fetch_assoc($mobile_q);

	$query=mysqli_query($db,'DELETE FROM mobile WHERE id="'.$post['d_id'].'" ');
	if($query=="1"){
		if($mobile_data['model_img']!="")
			unlink('../../images/mobile/'.$mobile_data['model_img']);

		$msg="Record successfully removed.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'mobile.php');
} elseif(isset($post['bulk_remove'])) {
	$ids_array = $post['ids'];
	if(!empty($ids_array)) {
		$removed_idd = array();
		foreach(explode(",",$ids_array) as $id_k=>$id_v) {
			$removed_idd[] = $id_v;

			$mobile_q=mysqli_query($db,'SELECT model_img FROM mobile WHERE id="'.$id_v.'"');
			$mobile_data=mysqli_fetch_assoc($mobile_q);
			if($mobile_data['model_img']!="")
				unlink('../../images/mobile/'.$mobile_data['model_img']);

			$query=mysqli_query($db,'DELETE FROM mobile WHERE id="'.$id_v.'"');
		}
	}

	if($query=='1') {
		$msg = count($removed_idd)." Record(s) successfully removed.";
		if(count($removed_idd)=='1')
			$msg = "Record successfully removed.";
	
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong updation failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'mobile.php');
} elseif(isset($post['p_id'])) {
	$query=mysqli_query($db,'UPDATE mobile SET published="'.$post['published'].'" WHERE id="'.$post['p_id'].'"');
	if($query=="1"){
		if($post['published']==1)
			$msg="Successfully Published.";
		elseif($post['published']==0)
			$msg="Successfully Unpublished.";
			
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong Delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'mobile.php');
} if(isset($post['update'])) {
	$device_id = $post['device_id'];
	$brand_id = $post['brand_id'];
	$cat_id = $post['cat_id'];
	$title=real_escape_string($post['title']);
	$description=real_escape_string($post['description']);
	$meta_title=real_escape_string($post['meta_title']);
	$meta_desc=real_escape_string($post['meta_desc']);
	$meta_keywords=real_escape_string($post['meta_keywords']);
	$price=real_escape_string($post['price']);
	$top_seller=real_escape_string(intval($post['top_seller']));
	$unlock_price=real_escape_string($post['unlock_price']);
	$tooltip_device=real_escape_string($post['tooltip_device']);
	$tooltip_storage=real_escape_string($post['tooltip_storage']);
	$tooltip_condition=real_escape_string($post['tooltip_condition']);
	$tooltip_network=real_escape_string($post['tooltip_network']);
	$tooltip_colors=real_escape_string($post['tooltip_colors']);
	$tooltip_miscellaneous=real_escape_string($post['tooltip_miscellaneous']);
	$tooltip_accessories=real_escape_string($post['tooltip_accessories']);
	$published = $post['published'];
	$ordering = $post['ordering'];
	$description = real_escape_string($post['description']);
	$searchable_words = real_escape_string($post['searchable_words']);

	$category_data = get_category_data($cat_id);
	$fields_type = $category_data['fields_type'];

	if($_FILES['model_img']['name']) {
		if(!file_exists('../../images/mobile/'))
			mkdir('../../images/mobile/',0777);
			
		$image_ext = pathinfo($_FILES['model_img']['name'],PATHINFO_EXTENSION);
		if($image_ext=="png" || $image_ext=="jpg" || $image_ext=="jpeg" || $image_ext=="gif") {
			if($post['old_image']!="")
				unlink('../../images/mobile/'.$post['old_image']);

			$image_tmp_name=$_FILES['model_img']['tmp_name'];
			$image_name=date('YmdHis').'.'.$image_ext;
			$imageupdate=', model_img="'.$image_name.'"';
			move_uploaded_file($image_tmp_name,'../../images/mobile/'.$image_name);
		} else {
			$msg="Image type must be png, jpg, jpeg, gif";
			$_SESSION['success_msg']=$msg;
			if($post['id']) {
				setRedirect(ADMIN_URL.'edit_mobile.php?id='.$post['id']);
			} else {
				setRedirect(ADMIN_URL.'edit_mobile.php');
			}
			exit();
		}
	}
	
	function save_model_fields($model_id,$post) {
		global $db;
		
		//START save/update for storage section
		$saved_storage_ids = array();
		if(empty($post['storage_size'])) {
			mysqli_query($db,"DELETE FROM models_storage WHERE model_id='".$model_id."'");
		} elseif(!empty($post['storage_size'])) {
			$storage_i_q=mysqli_query($db,'SELECT * FROM models_storage WHERE model_id="'.$model_id.'"');
			$initial_storage_data_rows=mysqli_num_rows($storage_i_q);
			
			foreach($post['storage_size'] as $key=>$value) {
				if(trim($value)) {
					if($initial_storage_data_rows<=0) {
						$query=mysqli_query($db,'INSERT INTO models_storage(model_id, storage_size, storage_size_postfix, top_seller, storage_price) values("'.$model_id.'","'.$post['storage_size'][$key].'","'.$post['storage_size_postfix'][$key].'","'.$post['top_seller'][$key].'","'.$post['storage_price'][$key].'")');
						$saved_storage_ids[] = mysqli_insert_id($db);
					} else {
						$storage_q=mysqli_query($db,'SELECT * FROM models_storage WHERE model_id="'.$model_id.'" AND id="'.$key.'"');
						$models_storage_data=mysqli_fetch_assoc($storage_q);
						if(empty($models_storage_data)) {
							$query=mysqli_query($db,'INSERT INTO models_storage(model_id, storage_size, storage_size_postfix, plus_minus, fixed_percentage, storage_price, top_seller) values("'.$model_id.'","'.$post['storage_size'][$key].'","'.$post['storage_size_postfix'][$key].'","'.$post['storage_plus_minus'][$key].'","'.$post['storage_fixed_percentage'][$key].'","'.$post['storage_price'][$key].'","'.$post['top_seller'][$key].'")');
							$saved_storage_ids[] = mysqli_insert_id($db);
						} else {
							$query=mysqli_query($db,'UPDATE models_storage SET storage_size="'.$post['storage_size'][$key].'",storage_size_postfix="'.$post['storage_size_postfix'][$key].'",plus_minus="'.$post['storage_plus_minus'][$key].'",fixed_percentage="'.$post['storage_fixed_percentage'][$key].'",storage_price="'.$post['storage_price'][$key].'",top_seller="'.$post['top_seller'][$key].'" WHERE model_id="'.$model_id.'" AND id="'.$key.'"');
							$saved_storage_ids[] = $key;
						}
					}
				}
			}
		}
		if(!empty($saved_storage_ids)) {
			mysqli_query($db,"DELETE FROM models_storage WHERE model_id='".$model_id."' AND id NOT IN(".implode(",",$saved_storage_ids).")");
		} //END save/update for storage section

		//START save/update for condition section
		$saved_condition_ids = array();
		if(empty($post['condition_name'])) {
			mysqli_query($db,"DELETE FROM models_condition WHERE model_id='".$model_id."'");
		} elseif(!empty($post['condition_name'])) {
			$condition_i_q=mysqli_query($db,'SELECT * FROM models_condition WHERE model_id="'.$model_id.'"');
			$initial_condition_data_rows=mysqli_num_rows($condition_i_q);
			
			foreach($post['condition_name'] as $cd_key=>$cd_value) {
				if(trim($cd_value)) {
					if($initial_condition_data_rows<=0) {
						$query=mysqli_query($db,'INSERT INTO models_condition(model_id, condition_name, plus_minus, fixed_percentage, condition_price, condition_terms, disabled_network) values("'.$model_id.'","'.real_escape_string($post['condition_name'][$cd_key]).'","'.$post['condition_plus_minus'][$cd_key].'","'.$post['condition_fixed_percentage'][$cd_key].'","'.$post['condition_price'][$cd_key].'","'.real_escape_string($post['condition_terms'][$cd_key]).'","'.$post['disabled_network'][$cd_key].'")');
						$saved_condition_ids[] = mysqli_insert_id($db);
					} else {
						$condition_q=mysqli_query($db,'SELECT * FROM models_condition WHERE model_id="'.$model_id.'" AND id="'.$cd_key.'"');
						$models_condition_data=mysqli_fetch_assoc($condition_q);
						if(empty($models_condition_data)) {
							$query=mysqli_query($db,'INSERT INTO models_condition(model_id, condition_name, plus_minus, fixed_percentage, condition_price, condition_terms, disabled_network) values("'.$model_id.'","'.real_escape_string($post['condition_name'][$cd_key]).'","'.$post['condition_plus_minus'][$cd_key].'","'.$post['condition_fixed_percentage'][$cd_key].'","'.$post['condition_price'][$cd_key].'","'.real_escape_string($post['condition_terms'][$cd_key]).'","'.$post['disabled_network'][$cd_key].'")');
							$saved_condition_ids[] = mysqli_insert_id($db);
						} else {
							$query=mysqli_query($db,'UPDATE models_condition SET condition_name="'.real_escape_string($post['condition_name'][$cd_key]).'",plus_minus="'.$post['condition_plus_minus'][$cd_key].'",fixed_percentage="'.$post['condition_fixed_percentage'][$cd_key].'",condition_price="'.$post['condition_price'][$cd_key].'",condition_terms="'.real_escape_string($post['condition_terms'][$cd_key]).'",disabled_network="'.$post['disabled_network'][$cd_key].'" WHERE model_id="'.$model_id.'" AND id="'.$cd_key.'"');
							$saved_condition_ids[] = $cd_key;
						}
					}
				}
			}
		}
		if(!empty($saved_condition_ids)) {
			mysqli_query($db,"DELETE FROM models_condition WHERE model_id='".$model_id."' AND id NOT IN(".implode(",",$saved_condition_ids).")");
		} //END save/update for condition section
		
		//START save/update for network section
		$saved_network_ids = array();
		if(empty($post['network_name'])) {
			mysqli_query($db,"DELETE FROM models_networks WHERE model_id='".$model_id."'");
		} elseif(!empty($post['network_name'])) {
			$networks_i_q=mysqli_query($db,'SELECT * FROM models_networks WHERE model_id="'.$model_id.'"');
			$initial_networks_data_rows=mysqli_num_rows($networks_i_q);
			
			foreach($post['network_name'] as $n_key=>$n_value) {
				if(trim($n_value)) {

					if(trim($_FILES['network_icon']['name'][$n_key])) {
						if(!file_exists('../../images/network/'))
							mkdir('../../images/network/',0777);

						$network_image_ext = pathinfo($_FILES['network_icon']['name'][$n_key],PATHINFO_EXTENSION);
						if($network_image_ext=="png" || $network_image_ext=="jpg" || $network_image_ext=="jpeg" || $network_image_ext=="gif") {
							$net_image_tmp_name=$_FILES['network_icon']['tmp_name'][$n_key];
							$network_icon=$n_key.date('YmdHis').'.'.$network_image_ext;
							move_uploaded_file($net_image_tmp_name,'../../images/network/'.$network_icon);
						} else {
							$msg="Image type must be png, jpg, jpeg, gif";
							$_SESSION['success_msg']=$msg;
							if($post['id']) {
								setRedirect(ADMIN_URL.'edit_mobile.php?id='.$model_id);
							} else {
								setRedirect(ADMIN_URL.'edit_mobile.php');
							}
							exit();
						}
					} else {
						$network_icon=$post['old_network_icon'][$n_key];
					}

					$network_price = 0;
					$network_unlock_price = 0;
					$network_price = $post['network_price'][$n_key];
					$network_unlock_price = $post['network_unlock_price'][$n_key];
					/*$network_price = ($post['network_price'][$n_key]>0?$post['network_price'][$n_key]:0);*/
					/*$network_unlock_price = ($post['network_unlock_price'][$n_key]>0?$post['network_unlock_price'][$n_key]:0);*/
					
					if($initial_networks_data_rows<=0) {
						$query=mysqli_query($db,'INSERT INTO models_networks(model_id, network_name, plus_minus, fixed_percentage, network_price, network_unlock_price, most_popular, change_unlock, network_icon) values("'.$model_id.'","'.$post['network_name'][$n_key].'","'.$post['network_plus_minus'][$n_key].'","'.$post['network_fixed_percentage'][$n_key].'","'.$network_price.'","'.$network_unlock_price.'","'.$post['most_popular'][$n_key].'","'.$post['change_unlock'][$n_key].'","'.$network_icon.'")');
						$saved_network_ids[] = mysqli_insert_id($db);
					} else {
						$network_q=mysqli_query($db,'SELECT * FROM models_networks WHERE model_id="'.$model_id.'" AND id="'.$n_key.'"');
						$models_network_data=mysqli_fetch_assoc($network_q);
						if(empty($models_network_data)) {
							$query=mysqli_query($db,'INSERT INTO models_networks(model_id, network_name, plus_minus, fixed_percentage, network_price, network_unlock_price, most_popular, change_unlock, network_icon) values("'.$model_id.'","'.$post['network_name'][$n_key].'","'.$post['network_plus_minus'][$n_key].'","'.$post['network_fixed_percentage'][$n_key].'","'.$network_price.'","'.$network_unlock_price.'","'.$post['most_popular'][$n_key].'","'.$post['change_unlock'][$n_key].'","'.$network_icon.'")');
							$saved_network_ids[] = mysqli_insert_id($db);
						} else {
							$query=mysqli_query($db,'UPDATE models_networks SET network_name="'.$post['network_name'][$n_key].'",plus_minus="'.$post['network_plus_minus'][$n_key].'",fixed_percentage="'.$post['network_fixed_percentage'][$n_key].'",network_price="'.$network_price.'",network_unlock_price="'.$network_unlock_price.'",most_popular="'.$post['most_popular'][$n_key].'",change_unlock="'.$post['change_unlock'][$n_key].'",network_icon="'.$network_icon.'" WHERE model_id="'.$model_id.'" AND id="'.$n_key.'"');
							$saved_network_ids[] = $n_key;
						}
					}
				}
			}
		}
		if(!empty($saved_network_ids)) {
			mysqli_query($db,"DELETE FROM models_networks WHERE model_id='".$model_id."' AND id NOT IN(".implode(",",$saved_network_ids).")");
		} //END save/update for network section

		//START save/update for connectivity section
		$saved_connectivity_ids = array();
		if(!empty($post['connectivity_name'])) {
			$connectivity_i_q=mysqli_query($db,'SELECT * FROM models_connectivity WHERE model_id="'.$model_id.'"');
			$initial_connectivity_data_rows=mysqli_num_rows($connectivity_i_q);
			
			foreach($post['connectivity_name'] as $c_key=>$c_value) {
				if(trim($c_value)) {
					if($initial_connectivity_data_rows<=0) {
						$query=mysqli_query($db,'INSERT INTO models_connectivity(model_id, connectivity_name, connectivity_price) values("'.$model_id.'","'.real_escape_string($post['connectivity_name'][$c_key]).'","'.$post['connectivity_price'][$c_key].'")');
						$saved_connectivity_ids[] = mysqli_insert_id($db);
					} else {
						$connectivity_q=mysqli_query($db,'SELECT * FROM models_connectivity WHERE model_id="'.$model_id.'" AND id="'.$c_key.'"');
						$models_connectivity_data=mysqli_fetch_assoc($connectivity_q);
						if(empty($models_connectivity_data)) {
							$query=mysqli_query($db,'INSERT INTO models_connectivity(model_id, connectivity_name, connectivity_price) values("'.$model_id.'","'.real_escape_string($post['connectivity_name'][$c_key]).'","'.$post['connectivity_price'][$c_key].'")');
							$saved_connectivity_ids[] = mysqli_insert_id($db);
						} else {
							$query=mysqli_query($db,'UPDATE models_connectivity SET connectivity_name="'.real_escape_string($post['connectivity_name'][$c_key]).'", connectivity_price="'.$post['connectivity_price'][$c_key].'" WHERE model_id="'.$model_id.'" AND id="'.$c_key.'"');
							$saved_connectivity_ids[] = $c_key;
						}
					}
				}
			}
		}
		if(!empty($saved_connectivity_ids)) {
			mysqli_query($db,"DELETE FROM models_connectivity WHERE model_id='".$model_id."' AND id NOT IN(".implode(",",$saved_connectivity_ids).")");
		} //END save/update for connectivity section

		//START save/update for watchtype section
		$saved_watchtype_ids = array();
		if(empty($post['watchtype_name'])) {
			mysqli_query($db,"DELETE FROM models_watchtype WHERE model_id='".$model_id."'");
		} elseif(!empty($post['watchtype_name'])) {
			$watchtype_i_q=mysqli_query($db,'SELECT * FROM models_watchtype WHERE model_id="'.$model_id.'"');
			$initial_watchtype_data_rows=mysqli_num_rows($watchtype_i_q);

			foreach($post['watchtype_name'] as $gnrtn_key=>$gnrtn_value) {
				if(trim($gnrtn_value)) {
					if($initial_watchtype_data_rows<=0) {
						$query=mysqli_query($db,'INSERT INTO models_watchtype(model_id, watchtype_name, watchtype_price, disabled_network) values("'.$model_id.'","'.real_escape_string($post['watchtype_name'][$gnrtn_key]).'","'.$post['watchtype_price'][$gnrtn_key].'","'.$post['disabled_network'][$gnrtn_key].'")');
						$saved_watchtype_ids[] = mysqli_insert_id($db);
					} else {
						$watchtype_q=mysqli_query($db,'SELECT * FROM models_watchtype WHERE model_id="'.$model_id.'" AND id="'.$gnrtn_key.'"');
						$models_watchtype_data=mysqli_fetch_assoc($watchtype_q);
						if(empty($models_watchtype_data)) {
							$query=mysqli_query($db,'INSERT INTO models_watchtype(model_id, watchtype_name, watchtype_price, disabled_network) values("'.$model_id.'","'.real_escape_string($post['watchtype_name'][$gnrtn_key]).'","'.$post['watchtype_price'][$gnrtn_key].'","'.$post['disabled_network'][$gnrtn_key].'")');
							$saved_watchtype_ids[] = mysqli_insert_id($db);
						} else {
							$query=mysqli_query($db,'UPDATE models_watchtype SET watchtype_name="'.real_escape_string($post['watchtype_name'][$gnrtn_key]).'", watchtype_price="'.$post['watchtype_price'][$gnrtn_key].'", disabled_network="'.$post['disabled_network'][$gnrtn_key].'" WHERE model_id="'.$model_id.'" AND id="'.$gnrtn_key.'"');
							$saved_watchtype_ids[] = $gnrtn_key;
						}
					}
				}
			}
		}
		if(!empty($saved_watchtype_ids)) {
			mysqli_query($db,"DELETE FROM models_watchtype WHERE model_id='".$model_id."' AND id NOT IN(".implode(",",$saved_watchtype_ids).")");
		} //END save/update for watchtype section

		//START save/update for case_material section
		$saved_case_material_ids = array();
		if(empty($post['case_material_name'])) {
			mysqli_query($db,"DELETE FROM models_case_material WHERE model_id='".$model_id."'");
		} elseif(!empty($post['case_material_name'])) {
			$case_material_i_q=mysqli_query($db,'SELECT * FROM models_case_material WHERE model_id="'.$model_id.'"');
			$initial_case_material_data_rows=mysqli_num_rows($case_material_i_q);
			
			foreach($post['case_material_name'] as $csmt_key=>$csmt_value) {
				if(trim($csmt_value)) {
					if($initial_case_material_data_rows<=0) {
						$query=mysqli_query($db,'INSERT INTO models_case_material(model_id, case_material_name, case_material_price) values("'.$model_id.'","'.real_escape_string($post['case_material_name'][$csmt_key]).'","'.$post['case_material_price'][$csmt_key].'")');
						$saved_case_material_ids[] = mysqli_insert_id($db);
					} else {
						$case_material_q=mysqli_query($db,'SELECT * FROM models_case_material WHERE model_id="'.$model_id.'" AND id="'.$csmt_key.'"');
						$models_case_material_data=mysqli_fetch_assoc($case_material_q);
						if(empty($models_case_material_data)) {
							$query=mysqli_query($db,'INSERT INTO models_case_material(model_id, case_material_name, case_material_price) values("'.$model_id.'","'.real_escape_string($post['case_material_name'][$csmt_key]).'","'.$post['case_material_price'][$csmt_key].'")');
							$saved_case_material_ids[] = mysqli_insert_id($db);
						} else {
							$query=mysqli_query($db,'UPDATE models_case_material SET case_material_name="'.real_escape_string($post['case_material_name'][$csmt_key]).'", case_material_price="'.$post['case_material_price'][$csmt_key].'" WHERE model_id="'.$model_id.'" AND id="'.$csmt_key.'"');
							$saved_case_material_ids[] = $csmt_key;
						}
					}
				}
			}
		}
		if(!empty($saved_case_material_ids)) {
			mysqli_query($db,"DELETE FROM models_case_material WHERE model_id='".$model_id."' AND id NOT IN(".implode(",",$saved_case_material_ids).")");
		} //END save/update for case_material section

		//START save/update for case_size section
		$saved_case_size_ids = array();
		if(empty($post['case_size'])) {
			mysqli_query($db,"DELETE FROM models_case_size WHERE model_id='".$model_id."'");
		} elseif(!empty($post['case_size'])) {
			$case_size_i_q=mysqli_query($db,'SELECT * FROM models_case_size WHERE model_id="'.$model_id.'"');
			$initial_case_size_data_rows=mysqli_num_rows($case_size_i_q);
			
			foreach($post['case_size'] as $case_size_key=>$case_size_value) {
				if(trim($case_size_value)) {
					if($initial_case_size_data_rows<=0) {
						$query=mysqli_query($db,'INSERT INTO models_case_size(model_id, case_size, case_size_price) values("'.$model_id.'","'.real_escape_string($post['case_size'][$case_size_key]).'","'.$post['case_size_price'][$case_size_key].'")');
						$saved_case_size_ids[] = mysqli_insert_id($db);
					} else {
						$case_size_q=mysqli_query($db,'SELECT * FROM models_case_size WHERE model_id="'.$model_id.'" AND id="'.$case_size_key.'"');
						$models_case_size_data=mysqli_fetch_assoc($case_size_q);
						if(empty($models_case_size_data)) {
							$query=mysqli_query($db,'INSERT INTO models_case_size(model_id, case_size, case_size_price) values("'.$model_id.'","'.real_escape_string($post['case_size'][$case_size_key]).'","'.$post['case_size_price'][$case_size_key].'")');
							$saved_case_size_ids[] = mysqli_insert_id($db);
						} else {
							$query=mysqli_query($db,'UPDATE models_case_size SET case_size="'.real_escape_string($post['case_size'][$case_size_key]).'", case_size_price="'.$post['case_size_price'][$case_size_key].'" WHERE model_id="'.$model_id.'" AND id="'.$case_size_key.'"');
							$saved_case_size_ids[] = $case_size_key;
						}
					}
				}
			}
		}
		if(!empty($saved_case_size_ids)) {
			mysqli_query($db,"DELETE FROM models_case_size WHERE model_id='".$model_id."' AND id NOT IN(".implode(",",$saved_case_size_ids).")");
		} //END save/update for case_size section
		
		//START save/update for color section
		$saved_color_ids = array();
		if(empty($post['color_name'])) {
			mysqli_query($db,"DELETE FROM models_color WHERE model_id='".$model_id."'");
		} elseif(!empty($post['color_name'])) {
			$color_i_q=mysqli_query($db,'SELECT * FROM models_color WHERE model_id="'.$model_id.'"');
			$initial_color_data_rows=mysqli_num_rows($color_i_q);

			foreach($post['color_name'] as $clr_key=>$clr_value) {
				$storage_ids = @implode(",",$post['color_storage_ids'][$clr_key]);
				if(trim($clr_value)) {
					if($initial_color_data_rows<=0) {
						$query=mysqli_query($db,'INSERT INTO models_color(model_id, color_name, color_code, color_price, storage_ids) values("'.$model_id.'","'.real_escape_string($post['color_name'][$clr_key]).'","'.real_escape_string($post['color_code'][$clr_key]).'","'.$post['color_price'][$clr_key].'","'.$storage_ids.'")');
						$saved_color_ids[] = mysqli_insert_id($db);
					} else {
						$color_q=mysqli_query($db,'SELECT * FROM models_color WHERE model_id="'.$model_id.'" AND id="'.$clr_key.'"');
						$models_color_data=mysqli_fetch_assoc($color_q);
						if(empty($models_color_data)) {
							$query=mysqli_query($db,'INSERT INTO models_color(model_id, color_name, color_code, color_price, storage_ids) values("'.$model_id.'","'.real_escape_string($post['color_name'][$clr_key]).'","'.real_escape_string($post['color_code'][$clr_key]).'","'.$post['color_price'][$clr_key].'","'.$storage_ids.'")');
							$saved_color_ids[] = mysqli_insert_id($db);
						} else {
							$query=mysqli_query($db,'UPDATE models_color SET color_name="'.real_escape_string($post['color_name'][$clr_key]).'", color_code="'.real_escape_string($post['color_code'][$clr_key]).'", color_price="'.$post['color_price'][$clr_key].'", storage_ids="'.$storage_ids.'" WHERE model_id="'.$model_id.'" AND id="'.$clr_key.'"');
							$saved_color_ids[] = $clr_key;
						}
					}
				}
			}
		}
		if(!empty($saved_color_ids)) {
			mysqli_query($db,"DELETE FROM models_color WHERE model_id='".$model_id."' AND id NOT IN(".implode(",",$saved_color_ids).")");
		} //END save/update for color section

		//START save/update for accessories section
		$saved_accessories_ids = array();
		if(empty($post['accessories_name'])) {
			mysqli_query($db,"DELETE FROM models_accessories WHERE model_id='".$model_id."'");
		} elseif(!empty($post['accessories_name'])) {
			$accessories_i_q=mysqli_query($db,'SELECT * FROM models_accessories WHERE model_id="'.$model_id.'"');
			$initial_accessories_data_rows=mysqli_num_rows($accessories_i_q);
			
			foreach($post['accessories_name'] as $accesr_key=>$accesr_value) {
				if(trim($accesr_value)) {
					if($initial_accessories_data_rows<=0) {
						$query=mysqli_query($db,'INSERT INTO models_accessories(model_id, accessories_name, accessories_price) values("'.$model_id.'","'.real_escape_string($post['accessories_name'][$accesr_key]).'","'.$post['accessories_price'][$accesr_key].'")');
						$saved_accessories_ids[] = mysqli_insert_id($db);
					} else {
						$accessories_q=mysqli_query($db,'SELECT * FROM models_accessories WHERE model_id="'.$model_id.'" AND id="'.$accesr_key.'"');
						$models_accessories_data=mysqli_fetch_assoc($accessories_q);
						if(empty($models_accessories_data)) {
							$query=mysqli_query($db,'INSERT INTO models_accessories(model_id, accessories_name, accessories_price) values("'.$model_id.'","'.real_escape_string($post['accessories_name'][$accesr_key]).'","'.$post['accessories_price'][$accesr_key].'")');
							$saved_accessories_ids[] = mysqli_insert_id($db);
						} else {
							$query=mysqli_query($db,'UPDATE models_accessories SET accessories_name="'.real_escape_string($post['accessories_name'][$accesr_key]).'", accessories_price="'.$post['accessories_price'][$accesr_key].'" WHERE model_id="'.$model_id.'" AND id="'.$accesr_key.'"');
							$saved_accessories_ids[] = $accesr_key;
						}
					}
				}
			}
		}
		if(!empty($saved_accessories_ids)) {
			mysqli_query($db,"DELETE FROM models_accessories WHERE model_id='".$model_id."' AND id NOT IN(".implode(",",$saved_accessories_ids).")");
		} //END save/update for accessories section

		//START save/update for screen_size section
		$saved_screen_size_ids = array();
		if(empty($post['screen_size_name'])) {
			mysqli_query($db,"DELETE FROM models_screen_size WHERE model_id='".$model_id."'");
		} elseif(!empty($post['screen_size_name'])) {
			$screen_size_i_q=mysqli_query($db,'SELECT * FROM models_screen_size WHERE model_id="'.$model_id.'"');
			$initial_screen_size_data_rows=mysqli_num_rows($screen_size_i_q);
			
			foreach($post['screen_size_name'] as $scrsz_key=>$scrsz_value) {
				if(trim($scrsz_value)) {
					if($initial_screen_size_data_rows<=0) {
						$query=mysqli_query($db,'INSERT INTO models_screen_size(model_id, screen_size_name, screen_size_price) values("'.$model_id.'","'.real_escape_string($post['screen_size_name'][$scrsz_key]).'","'.$post['screen_size_price'][$scrsz_key].'")');
						$saved_screen_size_ids[] = mysqli_insert_id($db);
					} else {
						$screen_size_q=mysqli_query($db,'SELECT * FROM models_screen_size WHERE model_id="'.$model_id.'" AND id="'.$scrsz_key.'"');
						$models_screen_size_data=mysqli_fetch_assoc($screen_size_q);
						if(empty($models_screen_size_data)) {
							$query=mysqli_query($db,'INSERT INTO models_screen_size(model_id, screen_size_name, screen_size_price) values("'.$model_id.'","'.real_escape_string($post['screen_size_name'][$scrsz_key]).'","'.$post['screen_size_price'][$scrsz_key].'")');
							$saved_screen_size_ids[] = mysqli_insert_id($db);
						} else {
							$query=mysqli_query($db,'UPDATE models_screen_size SET screen_size_name="'.real_escape_string($post['screen_size_name'][$scrsz_key]).'", screen_size_price="'.$post['screen_size_price'][$scrsz_key].'" WHERE model_id="'.$model_id.'" AND id="'.$scrsz_key.'"');
							$saved_screen_size_ids[] = $scrsz_key;
						}
					}
				}
			}
		}
		if(!empty($saved_screen_size_ids)) {
			mysqli_query($db,"DELETE FROM models_screen_size WHERE model_id='".$model_id."' AND id NOT IN(".implode(",",$saved_screen_size_ids).")");
		} //END save/update for screen_size section
		
		//START save/update for screen_resolution section
		$saved_screen_resolution_ids = array();
		if(empty($post['screen_resolution_name'])) {
			mysqli_query($db,"DELETE FROM models_screen_resolution WHERE model_id='".$model_id."'");
		} elseif(!empty($post['screen_resolution_name'])) {
			$screen_resolution_i_q=mysqli_query($db,'SELECT * FROM models_screen_resolution WHERE model_id="'.$model_id.'"');
			$initial_screen_resolution_data_rows=mysqli_num_rows($screen_resolution_i_q);
			
			foreach($post['screen_resolution_name'] as $scrrsl_key=>$scrrsl_value) {
				if(trim($scrrsl_value)) {
					if($initial_screen_resolution_data_rows<=0) {
						$query=mysqli_query($db,'INSERT INTO models_screen_resolution(model_id, screen_resolution_name, screen_resolution_price) values("'.$model_id.'","'.real_escape_string($post['screen_resolution_name'][$scrrsl_key]).'","'.$post['screen_resolution_price'][$scrrsl_key].'")');
						$saved_screen_resolution_ids[] = mysqli_insert_id($db);
					} else {
						$screen_resolution_q=mysqli_query($db,'SELECT * FROM models_screen_resolution WHERE model_id="'.$model_id.'" AND id="'.$scrrsl_key.'"');
						$models_screen_resolution_data=mysqli_fetch_assoc($screen_resolution_q);
						if(empty($models_screen_resolution_data)) {
							$query=mysqli_query($db,'INSERT INTO models_screen_resolution(model_id, screen_resolution_name, screen_resolution_price) values("'.$model_id.'","'.real_escape_string($post['screen_resolution_name'][$scrrsl_key]).'","'.$post['screen_resolution_price'][$scrrsl_key].'")');
							$saved_screen_resolution_ids[] = mysqli_insert_id($db);
						} else {
							$query=mysqli_query($db,'UPDATE models_screen_resolution SET screen_resolution_name="'.real_escape_string($post['screen_resolution_name'][$scrrsl_key]).'", screen_resolution_price="'.$post['screen_resolution_price'][$scrrsl_key].'" WHERE model_id="'.$model_id.'" AND id="'.$scrrsl_key.'"');
							$saved_screen_resolution_ids[] = $scrrsl_key;
						}
					}
				}
			}
		}
		if(!empty($saved_screen_resolution_ids)) {
			mysqli_query($db,"DELETE FROM models_screen_resolution WHERE model_id='".$model_id."' AND id NOT IN(".implode(",",$saved_screen_resolution_ids).")");
		} //END save/update for screen_resolution section
		
		//START save/update for lyear section
		$saved_lyear_ids = array();
		if(empty($post['lyear_name'])) {
			mysqli_query($db,"DELETE FROM models_lyear WHERE model_id='".$model_id."'");
		} elseif(!empty($post['lyear_name'])) {
			$lyear_i_q=mysqli_query($db,'SELECT * FROM models_lyear WHERE model_id="'.$model_id.'"');
			$initial_lyear_data_rows=mysqli_num_rows($lyear_i_q);
			
			foreach($post['lyear_name'] as $lyr_key=>$lyr_value) {
				if(trim($lyr_value)) {
					if($initial_lyear_data_rows<=0) {
						$query=mysqli_query($db,'INSERT INTO models_lyear(model_id, lyear_name, lyear_price) values("'.$model_id.'","'.real_escape_string($post['lyear_name'][$lyr_key]).'","'.$post['lyear_price'][$lyr_key].'")');
						$saved_lyear_ids[] = mysqli_insert_id($db);
					} else {
						$lyear_q=mysqli_query($db,'SELECT * FROM models_lyear WHERE model_id="'.$model_id.'" AND id="'.$lyr_key.'"');
						$models_lyear_data=mysqli_fetch_assoc($lyear_q);
						if(empty($models_lyear_data)) {
							$query=mysqli_query($db,'INSERT INTO models_lyear(model_id, lyear_name, lyear_price) values("'.$model_id.'","'.real_escape_string($post['lyear_name'][$lyr_key]).'","'.$post['lyear_price'][$lyr_key].'")');
							$saved_lyear_ids[] = mysqli_insert_id($db);
						} else {
							$query=mysqli_query($db,'UPDATE models_lyear SET lyear_name="'.real_escape_string($post['lyear_name'][$lyr_key]).'", lyear_price="'.$post['lyear_price'][$lyr_key].'" WHERE model_id="'.$model_id.'" AND id="'.$lyr_key.'"');
							$saved_lyear_ids[] = $lyr_key;
						}
					}
				}
			}
		}
		if(!empty($saved_lyear_ids)) {
			mysqli_query($db,"DELETE FROM models_lyear WHERE model_id='".$model_id."' AND id NOT IN(".implode(",",$saved_lyear_ids).")");
		} //END save/update for lyear section
		
		//START save/update for processor section
		$saved_processor_ids = array();
		if(empty($post['processor_name'])) {
			mysqli_query($db,"DELETE FROM models_processor WHERE model_id='".$model_id."'");
		} elseif(!empty($post['processor_name'])) {
			$processor_i_q=mysqli_query($db,'SELECT * FROM models_processor WHERE model_id="'.$model_id.'"');
			$initial_processor_data_rows=mysqli_num_rows($processor_i_q);
			
			foreach($post['processor_name'] as $prcr_key=>$prcr_value) {
				if(trim($prcr_value)) {
					if($initial_processor_data_rows<=0) {
						$query=mysqli_query($db,'INSERT INTO models_processor(model_id, processor_name, processor_price) values("'.$model_id.'","'.real_escape_string($post['processor_name'][$prcr_key]).'","'.$post['processor_price'][$prcr_key].'")');
						$saved_processor_ids[] = mysqli_insert_id($db);
					} else {
						$processor_q=mysqli_query($db,'SELECT * FROM models_processor WHERE model_id="'.$model_id.'" AND id="'.$prcr_key.'"');
						$models_processor_data=mysqli_fetch_assoc($processor_q);
						if(empty($models_processor_data)) {
							$query=mysqli_query($db,'INSERT INTO models_processor(model_id, processor_name, processor_price) values("'.$model_id.'","'.real_escape_string($post['processor_name'][$prcr_key]).'","'.$post['processor_price'][$prcr_key].'")');
							$saved_processor_ids[] = mysqli_insert_id($db);
						} else {
							$query=mysqli_query($db,'UPDATE models_processor SET processor_name="'.real_escape_string($post['processor_name'][$prcr_key]).'", processor_price="'.$post['processor_price'][$prcr_key].'" WHERE model_id="'.$model_id.'" AND id="'.$prcr_key.'"');
							$saved_processor_ids[] = $prcr_key;
						}
					}
				}
			}
		}
		if(!empty($saved_processor_ids)) {
			mysqli_query($db,"DELETE FROM models_processor WHERE model_id='".$model_id."' AND id NOT IN(".implode(",",$saved_processor_ids).")");
		} //END save/update for processor section
		
		//START save/update for ram section
		$saved_ram_ids = array();
		if(empty($post['ram_size'])) {
			mysqli_query($db,"DELETE FROM models_ram WHERE model_id='".$model_id."'");
		} elseif(!empty($post['ram_size'])) {
			$ram_i_q=mysqli_query($db,'SELECT * FROM models_ram WHERE model_id="'.$model_id.'"');
			$initial_ram_data_rows=mysqli_num_rows($ram_i_q);
			
			foreach($post['ram_size'] as $ram_key=>$ram_value) {
				if(trim($ram_value)) {
					if($initial_ram_data_rows<=0) {
						$query=mysqli_query($db,'INSERT INTO models_ram(model_id, ram_size, ram_size_postfix, ram_price) values("'.$model_id.'","'.real_escape_string($post['ram_size'][$ram_key]).'","'.real_escape_string($post['ram_size_postfix'][$ram_key]).'","'.$post['ram_price'][$ram_key].'")');
						$saved_ram_ids[] = mysqli_insert_id($db);
					} else {
						$ram_q=mysqli_query($db,'SELECT * FROM models_ram WHERE model_id="'.$model_id.'" AND id="'.$ram_key.'"');
						$models_ram_data=mysqli_fetch_assoc($ram_q);
						if(empty($models_ram_data)) {
							$query=mysqli_query($db,'INSERT INTO models_ram(model_id, ram_size, ram_size_postfix, ram_price) values("'.$model_id.'","'.real_escape_string($post['ram_size'][$ram_key]).'","'.real_escape_string($post['ram_size_postfix'][$ram_key]).'","'.$post['ram_price'][$ram_key].'")');
							$saved_ram_ids[] = mysqli_insert_id($db);
						} else {
							$query=mysqli_query($db,'UPDATE models_ram SET ram_size="'.real_escape_string($post['ram_size'][$ram_key]).'", ram_size_postfix="'.real_escape_string($post['ram_size_postfix'][$ram_key]).'", ram_price="'.$post['ram_price'][$ram_key].'" WHERE model_id="'.$model_id.'" AND id="'.$ram_key.'"');
							$saved_ram_ids[] = $ram_key;
						}
					}
				}
			}
		}
		if(!empty($saved_ram_ids)) {
			mysqli_query($db,"DELETE FROM models_ram WHERE model_id='".$model_id."' AND id NOT IN(".implode(",",$saved_ram_ids).")");
		} //END save/update for ram section

		//START save/update for dependency section
		$saved_depen_ids = array();

		/*if(empty($post['depen_form'])) {
			//mysqli_query($db,"DELETE FROM models_ram WHERE model_id='".$model_id."'");
			die("Opps! Dependency Error.");
		} elseif(!empty($post['depen_form'])) {
			switch ($post['depen_form']) {
				case 'mobile':
						
						if(count($post['depenkey']) < 1)
						{
							mysqli_query($db,"DELETE FROM mobiles_dependencies WHERE model_id='".$model_id."'");
							break;
						}	
						
						// var_dump($post['depenkey']);
						// die();
						foreach($post['depenkey'] as $depen_key) {

								$accessories_ids = @implode(",",$post['accessories_ids'][$depen_key]);
								$networks_ids = @implode(",",$post['networks_ids'][$depen_key]);
								$storage_ids = @implode(",",$post['storage_ids'][$depen_key]);
								$color_ids = @implode(",",$post['color_ids'][$depen_key]);
								$conditions_ids = @implode(",",$post['conditions_ids'][$depen_key]);
								// var_dump($depen_key);
								// var_dump($post['color_ids'][$depen_key]);
								// var_dump($color_ids);
								// die();

								$depen_q=mysqli_query($db,'SELECT * FROM mobiles_dependencies WHERE model_id="'.$model_id.'" AND id="'.$depen_key.'"');
								
								if($depen_q->num_rows == 0) {
									
									$query=mysqli_query($db,'INSERT INTO mobiles_dependencies(model_id, accessories, networks, storage, color, conditions) values("'.$model_id.'","'.$accessories_ids.'","'.$networks_ids.'","'.$storage_ids.'","'.$color_ids.'","'.$conditions_ids.'")');
									
									$saved_depen_ids[] = mysqli_insert_id($db);
								

								} else {
									$query=mysqli_query($db,'UPDATE mobiles_dependencies SET accessories="'.$accessories_ids.'", networks="'.$networks_ids.'", storage="'.$storage_ids.'", color="'.$color_ids.'", conditions="'.$conditions_ids.'" WHERE model_id="'.$model_id.'" AND id="'.$depen_key.'"');
									$saved_depen_ids[] = $depen_key;
								}
			
						}

				

						
					break;
				case 'tablet':

						if(count($post['depenkey']) < 1)
						{
							mysqli_query($db,"DELETE FROM mobiles_dependencies WHERE model_id='".$model_id."'");
							break;
						}	
						 
						foreach($post['depenkey'] as $depen_key) {



								$accessories_ids = @implode(",",$post['accessories_ids'][$depen_key]);
								$networks_ids = @implode(",",$post['networks_ids'][$depen_key]);
								$storage_ids = @implode(",",$post['storage_ids'][$depen_key]);
								$color_ids = @implode(",",$post['color_ids'][$depen_key]);
								$conditions_ids = @implode(",",$post['conditions_ids'][$depen_key]);
								$watchtype_ids = @implode(",",$post['watchtype_ids'][$depen_key]);

								// var_dump($depen_key);
								// var_dump($post['color_ids'][$depen_key]);
								// var_dump($color_ids);
								// die();

								$depen_q=mysqli_query($db,'SELECT * FROM mobiles_dependencies WHERE model_id="'.$model_id.'" AND id="'.$depen_key.'"');
								
								if($depen_q->num_rows == 0) {
									
									$query=mysqli_query($db,'INSERT INTO mobiles_dependencies(model_id, accessories, networks, storage, color, conditions, watchtype) values("'.$model_id.'","'.$accessories_ids.'","'.$networks_ids.'","'.$storage_ids.'","'.$color_ids.'","'.$conditions_ids.'", "'.$watchtype_ids.'")');
									
									$saved_depen_ids[] = mysqli_insert_id($db);
								

								} else {
							
									$query=mysqli_query($db,'UPDATE mobiles_dependencies SET accessories="'.$accessories_ids.'", networks="'.$networks_ids.'", storage="'.$storage_ids.'", color="'.$color_ids.'", conditions="'.$conditions_ids.'", watchtype="'.$watchtype_ids.'" WHERE model_id="'.$model_id.'" AND id="'.$depen_key.'"');
									$saved_depen_ids[] = $depen_key;
								}
			
						}


					
			
					break;
				case 'watch':

		
						if(count($post['depenkey']) < 1)
						{
							mysqli_query($db,"DELETE FROM mobiles_dependencies WHERE model_id='".$model_id."'");
							break;
						}	
						
						// var_dump($post['depenkey']);
						// die();
						foreach($post['depenkey'] as $depen_key) {



								$accessories_ids = @implode(",",$post['accessories_ids'][$depen_key]);
								$networks_ids = @implode(",",$post['networks_ids'][$depen_key]);
								$storage_ids = @implode(",",$post['storage_ids'][$depen_key]);
								$color_ids = @implode(",",$post['color_ids'][$depen_key]);
								$conditions_ids = @implode(",",$post['conditions_ids'][$depen_key]);
								$watchtype_ids = @implode(",",$post['watchtype_ids'][$depen_key]);
								$case_material_ids = @implode(",",$post['case_material_ids'][$depen_key]);
								$case_size_ids = @implode(",",$post['case_size_ids'][$depen_key]);

								// var_dump($depen_key);
								// var_dump($post['color_ids'][$depen_key]);
								// var_dump($color_ids);
								// die();

								$depen_q=mysqli_query($db,'SELECT * FROM mobiles_dependencies WHERE model_id="'.$model_id.'" AND id="'.$depen_key.'"');
								
								if($depen_q->num_rows == 0) {
									
									$query=mysqli_query($db,'INSERT INTO mobiles_dependencies(model_id, accessories, networks, storage, color, conditions, watchtype, case_material, case_size) values("'.$model_id.'","'.$accessories_ids.'","'.$networks_ids.'","'.$storage_ids.'","'.$color_ids.'","'.$conditions_ids.'", "'.$watchtype_ids.'", "'.$case_material_ids.'", "'.$case_size_ids.'")');
									
									$saved_depen_ids[] = mysqli_insert_id($db);
								

								} else {
									$query=mysqli_query($db,'UPDATE mobiles_dependencies SET accessories="'.$accessories_ids.'", networks="'.$networks_ids.'", storage="'.$storage_ids.'", color="'.$color_ids.'", conditions="'.$conditions_ids.'", watchtype="'.$watchtype_ids.'", case_material="'.$case_material_ids.'", case_size="'.$case_size_ids.'" WHERE model_id="'.$model_id.'" AND id="'.$depen_key.'"');
									$saved_depen_ids[] = $depen_key;
								}
			
						}


				
					break;
				
				case 'laptop':

						if(count($post['depenkey']) < 1)
						{
							mysqli_query($db,"DELETE FROM mobiles_dependencies WHERE model_id='".$model_id."'");
							break;
						}	
						
						// var_dump($post['depenkey']);
						// die();
						foreach($post['depenkey'] as $depen_key) {



								$accessories_ids = @implode(",",$post['accessories_ids'][$depen_key]);
									$networks_ids = @implode(",",$post['networks_ids'][$depen_key]);
									$storage_ids = @implode(",",$post['storage_ids'][$depen_key]);
									$color_ids = @implode(",",$post['color_ids'][$depen_key]);
									$conditions_ids = @implode(",",$post['conditions_ids'][$depen_key]);
									$watchtype_ids = @implode(",",$post['watchtype_ids'][$depen_key]);
									$screen_resolution_ids = @implode(",",$post['screen_resolution_ids'][$depen_key]);
									$screen_size_ids = @implode(",",$post['screen_size_ids'][$depen_key]);
									$lyear_ids = @implode(",",$post['lyear_ids'][$depen_key]);
									$processor_ids = @implode(",",$post['processor_ids'][$depen_key]);
									$ram_ids = @implode(",",$post['ram_ids'][$depen_key]);

								// var_dump($depen_key);
								// var_dump($post['color_ids'][$depen_key]);
								// var_dump($color_ids);
								// die();

								$depen_q=mysqli_query($db,'SELECT * FROM mobiles_dependencies WHERE model_id="'.$model_id.'" AND id="'.$depen_key.'"');
								
								if($depen_q->num_rows == 0) {
									
									$query=mysqli_query($db,'INSERT INTO mobiles_dependencies(model_id, accessories, networks, storage, color, conditions, watchtype, screen_resolution, screen_size, lyear, processor, ram) values("'.$model_id.'","'.$accessories_ids.'","'.$networks_ids.'","'.$storage_ids.'","'.$color_ids.'","'.$conditions_ids.'", "'.$watchtype_ids.'", "'.$screen_resolution_ids.'", "'.$screen_size_ids.'", "'.$lyear_ids.'", "'.$processor_ids.'", "'.$ram_ids.'")');
									
									$saved_depen_ids[] = mysqli_insert_id($db);
								

								} else {
									$query=mysqli_query($db,'UPDATE mobiles_dependencies SET accessories="'.$accessories_ids.'", networks="'.$networks_ids.'", storage="'.$storage_ids.'", color="'.$color_ids.'", conditions="'.$conditions_ids.'", watchtype="'.$watchtype_ids.'", screen_resolution="'.$screen_resolution_ids.'", screen_size="'.$screen_size_ids.'", lyear="'.$lyear_ids.'", processor="'.$processor_ids.'", ram="'.$ram_ids.'" WHERE model_id="'.$model_id.'" AND id="'.$depen_key.'"');
									$saved_depen_ids[] = $depen_key;
								}
			
						}
 

				
					break;				
				default:
					die("Opps! Dependency Error 2");
					break;
			}
			
		}*/

		if(!empty($saved_depen_ids)) {
			mysqli_query($db,"DELETE FROM mobiles_dependencies WHERE model_id='".$model_id."' AND id NOT IN(".implode(",",$saved_depen_ids).")");
		} //END save/update for dependency section
		
	}

	if($post['id']) {
		$query=mysqli_query($db,'UPDATE mobile SET title="'.$title.'", meta_title="'.$meta_title.'", meta_desc="'.$meta_desc.'", meta_keywords="'.$meta_keywords.'", device_id="'.$device_id.'", brand_id="'.$brand_id.'", cat_id="'.$cat_id.'", price="'.$price.'" '.$imageupdate.', unlock_price="'.$unlock_price.'", tooltip_device="'.$tooltip_device.'", tooltip_storage="'.$tooltip_storage.'", tooltip_condition="'.$tooltip_condition.'", tooltip_network="'.$tooltip_network.'", tooltip_colors="'.$tooltip_colors.'", tooltip_miscellaneous="'.$tooltip_miscellaneous.'", tooltip_accessories="'.$tooltip_accessories.'", top_seller='.$top_seller.', published="'.$published.'", ordering="'.$ordering.'", searchable_words="'.$searchable_words.'", description="'.$description.'" WHERE id="'.$post['id'].'"');
		if($query=="1") {
			$model_id = $post['id'];
			save_model_fields($model_id,$post);

			$msg="Model has been successfully updated.";
			$_SESSION['success_msg']=$msg;
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
		}
		setRedirect(ADMIN_URL.'edit_mobile.php?id='.$post['id']);
	} else {
		$_q='INSERT INTO mobile(title, meta_title, meta_desc, meta_keywords, device_id, brand_id, cat_id, price, model_img, unlock_price, tooltip_device, tooltip_storage, tooltip_condition, tooltip_network, tooltip_colors, tooltip_miscellaneous, tooltip_accessories, top_seller, published, ordering, searchable_words, description) values("'.$title.'","'.$meta_title.'","'.$meta_desc.'","'.$meta_keywords.'","'.$device_id.'","'.$brand_id.'","'.$cat_id.'","'.$price.'","'.$image_name.'","'.$unlock_price.'","'.$tooltip_device.'","'.$tooltip_storage.'","'.$tooltip_condition.'","'.$tooltip_network.'","'.$tooltip_colors.'","'.$tooltip_miscellaneous.'","'.$tooltip_accessories.'","'.$top_seller.'","'.$published.'","'.$ordering.'","'.$searchable_words.'","'.$description.'")';
		$query=mysqli_query($db,$_q);
		if($query=="1") {
			$model_id = mysqli_insert_id($db);
			save_model_fields($model_id,$post);
			
			$msg="Model has been successfully added.";
			$_SESSION['success_msg']=$msg;
			//setRedirect(ADMIN_URL.'mobile.php');
			setRedirect(ADMIN_URL.'edit_mobile.php?id='.$model_id);
		} else {
			$msg='Sorry! something wrong add failed.';
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_mobile.php');
		}
	}
} elseif($post['r_img_id']) {
	$mobile_data_q=mysqli_query($db,'SELECT model_img FROM mobile WHERE id="'.$post['r_img_id'].'"');
	$mobile_data=mysqli_fetch_assoc($mobile_data_q);

	$del_logo=mysqli_query($db,'UPDATE mobile SET model_img="" WHERE id='.$post['r_img_id']);
	if($mobile_data['model_img']!="")
		unlink('../../images/mobile/'.$mobile_data['model_img']);

	setRedirect(ADMIN_URL.'edit_mobile.php?id='.$post['id']);
} elseif($post['sbt_order']) {
	foreach($post['ordering'] as $ordering_key => $ordering_val) {
		if($ordering_val>0) {
			$query = mysqli_query($db,"UPDATE mobile SET ordering='".$ordering_val."' WHERE id='".$ordering_key."'");
		}
	}
	if($query=="1") {
		$msg="Order(s) successfully saved.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong updation failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'mobile.php');
} elseif(isset($post['export'])) {
	$ids = $post['ids'];

	$filter_by = "";
	if($post['filter_by']) {
		$filter_by .= " AND (m.title LIKE '%".real_escape_string($post['filter_by'])."%')";
	}

	if($post['cat_id']) {
		$filter_by .= " AND m.cat_id = '".$post['cat_id']."'";
	}

	if($post['brand_id']) {
		$filter_by .= " AND m.brand_id = '".$post['brand_id']."'";
	}

	if($post['device_id']) {
		$filter_by .= " AND m.device_id = '".$post['device_id']."'";
	}

	if($ids) {
		$filter_by .= " AND m.id IN(".$ids.")";
	}

	$c_query = mysqli_query($db,"SELECT c.title AS cat_title, c.fields_type AS cat_field_type FROM categories AS c WHERE c.id = '".$post['cat_id']."'");
	$category_data = mysqli_fetch_assoc($c_query);

	$query = mysqli_query($db,"SELECT m.*, c.title AS cat_title, c.fields_type AS cat_field_type, d.title AS device_title, d.sef_url, b.title AS brand_title FROM mobile AS m LEFT JOIN categories AS c ON c.id=m.cat_id LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE 1 ".$filter_by." ORDER BY m.id ASC");
	$num_rows = mysqli_num_rows($query);
	if($num_rows>0) {
		$filename = 'models-'.date("YmdHis").".csv";
		$fp = fopen('php://output', 'w');	
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename='.$filename);

		if($category_data['cat_field_type'] == "mobile") {
			include("exports/mobile.php");
		} elseif($category_data['cat_field_type'] == "tablet") {
			include("exports/tablet.php");
		} elseif($category_data['cat_field_type'] == "watch") {
			include("exports/watch.php");
		} elseif($category_data['cat_field_type'] == "laptop") {
			include("exports/laptop.php");
		}
	}
	exit();
} elseif(isset($post['import'])) {
	if($_FILES['file_name']['name'] == "") {
		$msg="Please choose .csv, .xls or .xlsx file.";
		$_SESSION['success_msg']=$msg;
		setRedirect(ADMIN_URL.'mobile.php');
		exit();
	} else {
		$path = str_replace(' ','_',$_FILES['file_name']['name']);
		$ext = pathinfo($path,PATHINFO_EXTENSION);
		if($ext=="csv" || $ext=="xls" || $ext=="xlsx") {

			$filename=$_FILES['file_name']['tmp_name'];
			move_uploaded_file($filename,'../uploaded_file/'.$path);

			$excel_file_path = '../uploaded_file/'.$path;
			require('../libraries/spreadsheet-reader-master/php-excel-reader/excel_reader2.php');
			require('../libraries/spreadsheet-reader-master/SpreadsheetReader.php');
			$excel_file_data_list = new SpreadsheetReader($excel_file_path);
			foreach($excel_file_data_list as $ek=>$excel_file_data)
			{
				/*echo '<pre>';
				echo 'Working on progress...';
				print_r($excel_file_data);
				exit;*/

				if(($ext=="xls" && $ek>1) || ($ext!="xls" && $ek>0)) {
					$Model_ID = $excel_file_data[0];
					$CategoryID = $excel_file_data[1];
					$Category_Title = real_escape_string($excel_file_data[2]);
					if($CategoryID) {
						$Category_ID = $CategoryID;
					}
					$Brand = real_escape_string($excel_file_data[3]);
					$Device = real_escape_string($excel_file_data[4]);
					$Model_Title = real_escape_string($excel_file_data[5]);
					$Model_Price = $excel_file_data[6];

					$c_query=mysqli_query($db,"SELECT * FROM categories WHERE id='".$Category_ID."'");
					$category_data = mysqli_fetch_assoc($c_query);
					$cat_field_type = $category_data['fields_type'];
					if($Category_Title) {
						mysqli_query($db,"UPDATE categories SET title='".$Category_Title."' WHERE id='".$Category_ID."'");
					}
					
					if($Model_ID>0) {
						$f_model_id = $Model_ID;
					}
					
					if($Model_Title!="") {
						$q_brnd = mysqli_query($db,"SELECT * FROM brand WHERE title='".$Brand."' AND title!=''");
						$brand_data = mysqli_fetch_assoc($q_brnd);
						$brand_id = $brand_data['id'];
						if(empty($brand_data)) {
							mysqli_query($db,"INSERT INTO brand(title) VALUES('".$Brand."')");
							$brand_id = mysqli_insert_id($db);
						}

						$q_dvc = mysqli_query($db,"SELECT * FROM devices WHERE title='".$Device."' AND title!=''");
						$device_data = mysqli_fetch_assoc($q_dvc);
						$device_id = $device_data['id'];
						if(empty($device_data)) {
							mysqli_query($db,"INSERT INTO devices(title, brand_id) VALUES('".$Device."','".$brand_id."')");
							$device_id = mysqli_insert_id($db);
						} else {
							mysqli_query($db,"UPDATE devices SET brand_id='".$brand_id."' WHERE id='".$device_id."'");
						}
					
						$qr=mysqli_query($db,"SELECT * FROM mobile WHERE id='".$Model_ID."'");
						$exist_mobile_data=mysqli_fetch_assoc($qr);
						if(empty($exist_mobile_data)) {
							mysqli_query($db,"INSERT INTO mobile(title, price, cat_id, device_id) VALUES('".$Model_Title."','".$Model_Price."','".$Category_ID."','".$device_id."')");
							$f_model_id = mysqli_insert_id($db);
						} else {
							$query = mysqli_query($db,"UPDATE mobile SET title='".$Model_Title."', price='".$Model_Price."', device_id='".$device_id."', cat_id='".$Category_ID."' WHERE id='".$Model_ID."'");
						}
					}

					if($cat_field_type == "mobile") {
						include("imports/mobile.php");
					} elseif($cat_field_type == "tablet") {
						include("imports/tablet.php");
					} elseif($cat_field_type == "watch") {
						include("imports/watch.php");
					} elseif($cat_field_type == "laptop") {
						include("imports/laptop.php");
					}
				}
			}
			if($query == '1') {
				unlink($excel_file_path);
				$msg="Data(s) successfully imported.";
				$_SESSION['success_msg']=$msg;
			} else {
				$msg='Sorry! something wrong imported failed.';
				$_SESSION['error_msg']=$msg;
			}
		} else {
			$msg="Allow only .csv, .xls or .xlsx file.";
			$_SESSION['success_msg']=$msg;
		}
	}
	setRedirect(ADMIN_URL.'mobile.php');
} elseif(isset($post['action']) && isset($post['id'])) {
	$model_id = $post['id'];
	
	$m_q=mysqli_query($db,'SELECT * FROM mobile WHERE id="'.$model_id.'"');
	$models_data=mysqli_fetch_assoc($m_q);
	$device_id=$models_data['device_id'];
	
	$storage_items_array = get_devices_storage_data($device_id);
	$condition_items_array = get_devices_condition_data($device_id);
	$colors_items_array = get_devices_color_data($device_id);
	$accessories_items_array = get_devices_accessories_data($device_id);
	$miscellaneous_items_array = get_devices_miscellaneous_data($device_id);
	$network_items_array = get_devices_networks_data($device_id);

	mysqli_query($db,"DELETE FROM models_storage WHERE model_id='".$model_id."'");
	if(!empty($storage_items_array)) {
		foreach($storage_items_array as $storage_item) {
			mysqli_query($db,'INSERT INTO models_storage(model_id, storage_size, storage_size_postfix, plus_minus, fixed_percentage, storage_price, top_seller) values("'.$model_id.'","'.$storage_item['storage_size'].'","'.$storage_item['storage_size_postfix'].'","'.$storage_item['plus_minus'].'","'.$storage_item['fixed_percentage'].'","'.$storage_item['storage_price'].'","'.$storage_item['top_seller'].'")');
		}
	}
	
	mysqli_query($db,"DELETE FROM models_condition WHERE model_id='".$model_id."'");
	if(!empty($condition_items_array)) {
		foreach($condition_items_array as $condition_item) {
			$query=mysqli_query($db,'INSERT INTO models_condition(model_id, condition_name, plus_minus, fixed_percentage, condition_price, condition_terms, disabled_network) values("'.$model_id.'","'.real_escape_string($condition_item['condition_name']).'","'.$condition_item['plus_minus'].'","'.$condition_item['fixed_percentage'].'","'.$condition_item['condition_price'].'","'.real_escape_string($condition_item['condition_terms']).'","'.$condition_item['disabled_network'].'")');
		}
	}
	
	mysqli_query($db,"DELETE FROM models_color WHERE model_id='".$model_id."'");
	if(!empty($colors_items_array)) {
		foreach($colors_items_array as $colors_item) {
			$query=mysqli_query($db,'INSERT INTO models_color(model_id, color_name, plus_minus, fixed_percentage, color_price) values("'.$model_id.'","'.real_escape_string($colors_item['color_name']).'","'.$colors_item['plus_minus'].'","'.$colors_item['fixed_percentage'].'","'.$colors_item['color_price'].'")');
		}
	}
	
	mysqli_query($db,"DELETE FROM models_accessories WHERE model_id='".$model_id."'");
	if(!empty($accessories_items_array)) {
		foreach($accessories_items_array as $accessories_item) {
			$query=mysqli_query($db,'INSERT INTO models_accessories(model_id, accessories_name, plus_minus, fixed_percentage, accessories_price) values("'.$model_id.'","'.real_escape_string($accessories_item['accessories_name']).'","'.$accessories_item['plus_minus'].'","'.$accessories_item['fixed_percentage'].'","'.$accessories_item['accessories_price'].'")');
		}
	}
	
	mysqli_query($db,"DELETE FROM models_miscellaneous WHERE model_id='".$model_id."'");
	if(!empty($miscellaneous_items_array)) {
		foreach($miscellaneous_items_array as $miscellaneous_item) {
			$query=mysqli_query($db,'INSERT INTO models_miscellaneous(model_id, miscellaneous_name, plus_minus, fixed_percentage, miscellaneous_price) values("'.$model_id.'","'.real_escape_string($miscellaneous_item['miscellaneous_name']).'","'.$miscellaneous_item['plus_minus'].'","'.$miscellaneous_item['fixed_percentage'].'","'.$miscellaneous_item['miscellaneous_price'].'")');
		}
	}
	
	mysqli_query($db,"DELETE FROM models_networks WHERE model_id='".$model_id."'");
	if(!empty($network_items_array)) {
		foreach($network_items_array as $network_item) {

			$network_price = 0;
			$network_price = ($network_item['network_price']>0?$network_item['network_price']:0);
		
			$query=mysqli_query($db,'INSERT INTO models_networks(model_id, network_name, plus_minus, fixed_percentage, network_price, most_popular, change_unlock, network_icon) values("'.$model_id.'","'.$network_item['network_name'].'","'.$network_item['plus_minus'].'","'.$network_item['fixed_percentage'].'","'.$network_price.'","'.$network_item['most_popular'].'","'.$network_item['change_unlock'].'","'.$network_item['network_icon'].'")');
		}
	}

	setRedirect(ADMIN_URL.'edit_mobile.php?id='.$model_id);
} else {
	setRedirect(ADMIN_URL.'mobile.php');
}
exit();
?>