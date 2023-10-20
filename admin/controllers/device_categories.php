<?php 
require_once("../_config/config.php");
require_once("../include/functions.php");

if(isset($post['d_id'])) {
	$category_q=mysqli_query($db,'SELECT image FROM categories WHERE id="'.$post['d_id'].'"');
	$category_data=mysqli_fetch_assoc($category_q);
	
	$query=mysqli_query($db,'DELETE FROM categories WHERE id="'.$post['d_id'].'" ');
	if($query=="1"){
		if($category_data['image']!="")
			unlink('../../images/categories/'.$category_data['image']);

		$msg="Record successfully removed.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'device_categories.php');
} elseif(isset($post['bulk_remove'])) {
	$ids_array = $post['ids'];
	if(!empty($ids_array)) {
		$removed_idd = array();
		foreach(explode(",",$ids_array) as $id_k=>$id_v) {
			$removed_idd[] = $id_v;

			$category_q=mysqli_query($db,'SELECT image FROM categories WHERE id="'.$id_v.'"');
			$category_data=mysqli_fetch_assoc($category_q);
			if($category_data['image']!="")
				unlink('../../images/categories/'.$category_data['image']);

			$query=mysqli_query($db,'DELETE FROM categories WHERE id="'.$id_v.'"');
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
	setRedirect(ADMIN_URL.'device_categories.php');
} elseif(isset($post['p_id'])) {
	$query=mysqli_query($db,'UPDATE categories SET published="'.$post['published'].'" WHERE id="'.$post['p_id'].'"');
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
	setRedirect(ADMIN_URL.'device_categories.php');
} elseif(isset($post['update'])) {
	$title=real_escape_string($post['title']);
	$fields_type=real_escape_string($post['fields_type']);
	$description=real_escape_string($post['description']);
	$published = $post['published'];
	
	if($_FILES['image']['name']) {
		if(!file_exists('../../images/categories/'))
			mkdir('../../images/categories/',0777);

		$image_ext = pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
		if($image_ext=="png" || $image_ext=="jpg" || $image_ext=="jpeg" || $image_ext=="gif") {
			if($post['old_image']!="")
				unlink('../../images/categories/'.$post['old_image']);

			$image_tmp_name=$_FILES['image']['tmp_name'];
			$image_name=date('YmdHis').'.'.$image_ext;
			$imageupdate=', image="'.$image_name.'"';
			move_uploaded_file($image_tmp_name,'../../images/categories/'.$image_name);
		} else {
			$msg="Image type must be png, jpg, jpeg, gif";
			$_SESSION['success_msg']=$msg;
			if($post['id']) {
				setRedirect(ADMIN_URL.'edit_category.php?id='.$post['id']);
			} else {
				setRedirect(ADMIN_URL.'edit_category.php');
			}
			exit();
		}
	}
	
	function save_category_fields($cat_id,$post) {
		global $db;
		
		//START save/update for storage section
		$saved_storage_ids = array();
		if(empty($post['storage_size'])) {
			mysqli_query($db,"DELETE FROM category_storage WHERE cat_id='".$cat_id."'");
		} elseif(!empty($post['storage_size'])) {
			$storage_i_q=mysqli_query($db,'SELECT * FROM category_storage WHERE cat_id="'.$cat_id.'"');
			$initial_storage_data_rows=mysqli_num_rows($storage_i_q);

			foreach($post['storage_size'] as $key=>$value) {
				if(trim($value)) {
					if($initial_storage_data_rows<=0) {
						$query=mysqli_query($db,'INSERT INTO category_storage(cat_id, storage_size, storage_size_postfix, top_seller, storage_price) values("'.$cat_id.'","'.$post['storage_size'][$key].'","'.$post['storage_size_postfix'][$key].'","'.$post['top_seller'][$key].'","'.$post['storage_price'][$key].'")');
						$saved_storage_ids[] = mysqli_insert_id($db);
					} else {
						$storage_q=mysqli_query($db,'SELECT * FROM category_storage WHERE cat_id="'.$cat_id.'" AND id="'.$key.'"');
						$category_storage_data=mysqli_fetch_assoc($storage_q);
						if(empty($category_storage_data)) {
							$query=mysqli_query($db,'INSERT INTO category_storage(cat_id, storage_size, storage_size_postfix, top_seller, storage_price) values("'.$cat_id.'","'.$post['storage_size'][$key].'","'.$post['storage_size_postfix'][$key].'","'.$post['top_seller'][$key].'","'.$post['storage_price'][$key].'")');
							$saved_storage_ids[] = mysqli_insert_id($db);
						} else {
							$query=mysqli_query($db,'UPDATE category_storage SET storage_size="'.$post['storage_size'][$key].'", storage_size_postfix="'.$post['storage_size_postfix'][$key].'", top_seller="'.$post['top_seller'][$key].'", storage_price="'.$post['storage_price'][$key].'" WHERE cat_id="'.$cat_id.'" AND id="'.$key.'"');
							$saved_storage_ids[] = $key;
						}
					}
				}
			}
		}
		if(!empty($saved_storage_ids)) {
			mysqli_query($db,"DELETE FROM category_storage WHERE cat_id='".$cat_id."' AND id NOT IN(".implode(",",$saved_storage_ids).")");
		} //END save/update for storage section

		//START save/update for condition section
		$saved_condition_ids = array();
		if(empty($post['condition_name'])) {
			mysqli_query($db,"DELETE FROM category_condition WHERE cat_id='".$cat_id."'");
		} elseif(!empty($post['condition_name'])) {
			$condition_i_q=mysqli_query($db,'SELECT * FROM category_condition WHERE cat_id="'.$cat_id.'"');
			$initial_condition_data_rows=mysqli_num_rows($condition_i_q);
			
			foreach($post['condition_name'] as $cd_key=>$cd_value) {
				if(trim($cd_value)) {
					if($initial_condition_data_rows<=0) {
						$query=mysqli_query($db,'INSERT INTO category_condition(cat_id, condition_name, condition_terms, condition_price) values("'.$cat_id.'","'.real_escape_string($post['condition_name'][$cd_key]).'","'.real_escape_string($post['condition_terms'][$cd_key]).'","'.$post['condition_price'][$cd_key].'")');
						$saved_condition_ids[] = mysqli_insert_id($db);
					} else {
						$condition_q=mysqli_query($db,'SELECT * FROM category_condition WHERE cat_id="'.$cat_id.'" AND id="'.$cd_key.'"');
						$category_condition_data=mysqli_fetch_assoc($condition_q);
						if(empty($category_condition_data)) {
							$query=mysqli_query($db,'INSERT INTO category_condition(cat_id, condition_name, condition_terms, condition_price) values("'.$cat_id.'","'.real_escape_string($post['condition_name'][$cd_key]).'","'.real_escape_string($post['condition_terms'][$cd_key]).'","'.$post['condition_price'][$cd_key].'")');
							$saved_condition_ids[] = mysqli_insert_id($db);
						} else {
							$query=mysqli_query($db,'UPDATE category_condition SET condition_name="'.real_escape_string($post['condition_name'][$cd_key]).'", condition_terms="'.real_escape_string($post['condition_terms'][$cd_key]).'", condition_price="'.$post['condition_price'][$cd_key].'" WHERE cat_id="'.$cat_id.'" AND id="'.$cd_key.'"');
							$saved_condition_ids[] = $cd_key;
						}
					}
				}
			}
		}
		if(!empty($saved_condition_ids)) {
			mysqli_query($db,"DELETE FROM category_condition WHERE cat_id='".$cat_id."' AND id NOT IN(".implode(",",$saved_condition_ids).")");
		} //END save/update for condition section
		
		//START save/update for network section
		$saved_network_ids = array();
		if(empty($post['network_name'])) {
			mysqli_query($db,"DELETE FROM category_networks WHERE cat_id='".$cat_id."'");
		} elseif(!empty($post['network_name'])) {
			$network_i_q=mysqli_query($db,'SELECT * FROM category_networks WHERE cat_id="'.$cat_id.'"');
			$initial_network_data_rows=mysqli_num_rows($network_i_q);
			
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
								setRedirect(ADMIN_URL.'edit_mobile.php?id='.$cat_id);
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
					/*$network_price = ($post['network_price'][$n_key]>0?$post['network_price'][$n_key]:0);
					$network_unlock_price = ($post['network_unlock_price'][$n_key]>0?$post['network_unlock_price'][$n_key]:0);*/

					if($initial_network_data_rows<=0) {
						$query=mysqli_query($db,'INSERT INTO category_networks(cat_id, network_name, network_icon, network_price, network_unlock_price) values("'.$cat_id.'","'.$post['network_name'][$n_key].'","'.$network_icon.'","'.$network_price.'","'.$network_unlock_price.'")');
						$saved_network_ids[] = mysqli_insert_id($db);
					} else {
						$network_q=mysqli_query($db,'SELECT * FROM category_networks WHERE cat_id="'.$cat_id.'" AND id="'.$n_key.'"');
						$category_network_data=mysqli_fetch_assoc($network_q);
						if(empty($category_network_data)) {
							$query=mysqli_query($db,'INSERT INTO category_networks(cat_id, network_name, network_icon, network_price, network_unlock_price) values("'.$cat_id.'","'.$post['network_name'][$n_key].'","'.$network_icon.'","'.$network_price.'","'.$network_unlock_price.'")');
							$saved_network_ids[] = mysqli_insert_id($db);
						} else {
							$query=mysqli_query($db,'UPDATE category_networks SET network_name="'.$post['network_name'][$n_key].'", network_icon="'.$network_icon.'", network_price="'.$network_price.'", network_unlock_price="'.$network_unlock_price.'" WHERE cat_id="'.$cat_id.'" AND id="'.$n_key.'"');
							$saved_network_ids[] = $n_key;
						}
					}
				}
			}
		}
		if(!empty($saved_network_ids)) {
			mysqli_query($db,"DELETE FROM category_networks WHERE cat_id='".$cat_id."' AND id NOT IN(".implode(",",$saved_network_ids).")");
		} //END save/update for network section

		//START save/update for connectivity section
		$saved_connectivity_ids = array();
		if(empty($post['connectivity_name'])) {
			mysqli_query($db,"DELETE FROM category_connectivity WHERE cat_id='".$cat_id."'");
		} elseif(!empty($post['connectivity_name'])) {
			$connectivity_i_q=mysqli_query($db,'SELECT * FROM category_connectivity WHERE cat_id="'.$cat_id.'"');
			$initial_connectivity_data_rows=mysqli_num_rows($connectivity_i_q);

			foreach($post['connectivity_name'] as $c_key=>$c_value) {
				if(trim($c_value)) {
					if($initial_connectivity_data_rows<=0) {
						$query=mysqli_query($db,'INSERT INTO category_connectivity(cat_id, connectivity_name, connectivity_price) values("'.$cat_id.'","'.real_escape_string($post['connectivity_name'][$c_key]).'","'.$post['connectivity_price'][$c_key].'")');
						$saved_connectivity_ids[] = mysqli_insert_id($db);
					} else {
						$connectivity_q=mysqli_query($db,'SELECT * FROM category_connectivity WHERE cat_id="'.$cat_id.'" AND id="'.$c_key.'"');
						$category_connectivity_data=mysqli_fetch_assoc($connectivity_q);
						if(empty($category_connectivity_data)) {
							$query=mysqli_query($db,'INSERT INTO category_connectivity(cat_id, connectivity_name, connectivity_price) values("'.$cat_id.'","'.real_escape_string($post['connectivity_name'][$c_key]).'","'.$post['connectivity_price'][$c_key].'")');
							$saved_connectivity_ids[] = mysqli_insert_id($db);
						} else {
							$query=mysqli_query($db,'UPDATE category_connectivity SET connectivity_name="'.real_escape_string($post['connectivity_name'][$c_key]).'", connectivity_price="'.$post['connectivity_price'][$c_key].'" WHERE cat_id="'.$cat_id.'" AND id="'.$c_key.'"');
							$saved_connectivity_ids[] = $c_key;
						}
					}
				}
			}
		}
		if(!empty($saved_connectivity_ids)) {
			mysqli_query($db,"DELETE FROM category_connectivity WHERE cat_id='".$cat_id."' AND id NOT IN(".implode(",",$saved_connectivity_ids).")");
		} //END save/update for connectivity section

		//START save/update for watchtype section
		$saved_watchtype_ids = array();
		if(empty($post['watchtype_name'])) {
			mysqli_query($db,"DELETE FROM category_watchtype WHERE cat_id='".$cat_id."'");
		} elseif(!empty($post['watchtype_name'])) {
			$watchtype_i_q=mysqli_query($db,'SELECT * FROM category_watchtype WHERE cat_id="'.$cat_id.'"');
			$initial_watchtype_data_rows=mysqli_num_rows($watchtype_i_q);

			foreach($post['watchtype_name'] as $gnrtn_key=>$gnrtn_value) {
				if(trim($gnrtn_value)) {
					if($initial_watchtype_data_rows<=0) {
						$query=mysqli_query($db,'INSERT INTO category_watchtype(cat_id, watchtype_name, watchtype_price, disabled_network) values("'.$cat_id.'","'.real_escape_string($post['watchtype_name'][$gnrtn_key]).'","'.$post['watchtype_price'][$gnrtn_key].'","'.$post['disabled_network'][$gnrtn_key].'")');
						$saved_watchtype_ids[] = mysqli_insert_id($db);
					} else {
						$watchtype_q=mysqli_query($db,'SELECT * FROM category_watchtype WHERE cat_id="'.$cat_id.'" AND id="'.$gnrtn_key.'"');
						$category_watchtype_data=mysqli_fetch_assoc($watchtype_q);
						if(empty($category_watchtype_data)) {
							$query=mysqli_query($db,'INSERT INTO category_watchtype(cat_id, watchtype_name, watchtype_price, disabled_network) values("'.$cat_id.'","'.real_escape_string($post['watchtype_name'][$gnrtn_key]).'","'.$post['watchtype_price'][$gnrtn_key].'","'.$post['disabled_network'][$gnrtn_key].'")');
							$saved_watchtype_ids[] = mysqli_insert_id($db);
						} else {
							$query=mysqli_query($db,'UPDATE category_watchtype SET watchtype_name="'.real_escape_string($post['watchtype_name'][$gnrtn_key]).'", watchtype_price="'.$post['watchtype_price'][$gnrtn_key].'", disabled_network="'.$post['disabled_network'][$gnrtn_key].'" WHERE cat_id="'.$cat_id.'" AND id="'.$gnrtn_key.'"');
							$saved_watchtype_ids[] = $gnrtn_key;
						}
					}
				}
			}
		}
		if(!empty($saved_watchtype_ids)) {
			mysqli_query($db,"DELETE FROM category_watchtype WHERE cat_id='".$cat_id."' AND id NOT IN(".implode(",",$saved_watchtype_ids).")");
		} //END save/update for watchtype section
		
		//START save/update for case_material section
		$saved_case_material_ids = array();
		if(empty($post['case_material_name'])) {
			mysqli_query($db,"DELETE FROM category_case_material WHERE cat_id='".$cat_id."'");
		} elseif(!empty($post['case_material_name'])) {
			$case_material_i_q=mysqli_query($db,'SELECT * FROM category_case_material WHERE cat_id="'.$cat_id.'"');
			$initial_case_material_data_rows=mysqli_num_rows($case_material_i_q);
			
			foreach($post['case_material_name'] as $csmt_key=>$csmt_value) {
				if(trim($csmt_value)) {
					if($initial_case_material_data_rows<=0) {
						$query=mysqli_query($db,'INSERT INTO category_case_material(cat_id, case_material_name, case_material_price) values("'.$cat_id.'","'.real_escape_string($post['case_material_name'][$csmt_key]).'","'.$post['case_material_price'][$csmt_key].'")');
						$saved_case_material_ids[] = mysqli_insert_id($db);
					} else {
						$case_material_q=mysqli_query($db,'SELECT * FROM category_case_material WHERE cat_id="'.$cat_id.'" AND id="'.$csmt_key.'"');
						$category_case_material_data=mysqli_fetch_assoc($case_material_q);
						if(empty($category_case_material_data)) {
							$query=mysqli_query($db,'INSERT INTO category_case_material(cat_id, case_material_name, case_material_price) values("'.$cat_id.'","'.real_escape_string($post['case_material_name'][$csmt_key]).'","'.$post['case_material_price'][$csmt_key].'")');
							$saved_case_material_ids[] = mysqli_insert_id($db);
						} else {
							$query=mysqli_query($db,'UPDATE category_case_material SET case_material_name="'.real_escape_string($post['case_material_name'][$csmt_key]).'", case_material_price="'.$post['case_material_price'][$csmt_key].'" WHERE cat_id="'.$cat_id.'" AND id="'.$csmt_key.'"');
							$saved_case_material_ids[] = $csmt_key;
						}
					}
				}
			}
		}
		if(!empty($saved_case_material_ids)) {
			mysqli_query($db,"DELETE FROM category_case_material WHERE cat_id='".$cat_id."' AND id NOT IN(".implode(",",$saved_case_material_ids).")");
		} //END save/update for case_material section
		
		//START save/update for case_size section
		$saved_case_size_ids = array();
		if(empty($post['case_size'])) {
			mysqli_query($db,"DELETE FROM category_case_size WHERE cat_id='".$cat_id."'");
		} elseif(!empty($post['case_size'])) {
			$case_size_i_q=mysqli_query($db,'SELECT * FROM category_case_size WHERE cat_id="'.$cat_id.'"');
			$initial_case_size_data_rows=mysqli_num_rows($case_size_i_q);
			
			foreach($post['case_size'] as $case_size_key=>$case_size_value) {
				if(trim($case_size_value)) {
					if($initial_case_size_data_rows<=0) {
						$query=mysqli_query($db,'INSERT INTO category_case_size(cat_id, case_size, case_size_price) values("'.$cat_id.'","'.real_escape_string($post['case_size'][$case_size_key]).'","'.$post['case_size_price'][$case_size_key].'")');
						$saved_case_size_ids[] = mysqli_insert_id($db);
					} else {
						$case_size_q=mysqli_query($db,'SELECT * FROM category_case_size WHERE cat_id="'.$cat_id.'" AND id="'.$case_size_key.'"');
						$category_case_size_data=mysqli_fetch_assoc($case_size_q);
						if(empty($category_case_size_data)) {
							$query=mysqli_query($db,'INSERT INTO category_case_size(cat_id, case_size, case_size_price) values("'.$cat_id.'","'.real_escape_string($post['case_size'][$case_size_key]).'","'.$post['case_size_price'][$case_size_key].'")');
							$saved_case_size_ids[] = mysqli_insert_id($db);
						} else {
							$query=mysqli_query($db,'UPDATE category_case_size SET case_size="'.real_escape_string($post['case_size'][$case_size_key]).'", case_size_price="'.$post['case_size_price'][$case_size_key].'" WHERE cat_id="'.$cat_id.'" AND id="'.$case_size_key.'"');
							$saved_case_size_ids[] = $case_size_key;
						}
					}
				}
			}
		}
		if(!empty($saved_case_size_ids)) {
			mysqli_query($db,"DELETE FROM category_case_size WHERE cat_id='".$cat_id."' AND id NOT IN(".implode(",",$saved_case_size_ids).")");
		} //END save/update for case_size section
		
		//START save/update for color section
		$saved_color_ids = array();
		if(empty($post['color_name'])) {
			mysqli_query($db,"DELETE FROM category_color WHERE cat_id='".$cat_id."'");
		} elseif(!empty($post['color_name'])) {
			$color_i_q=mysqli_query($db,'SELECT * FROM category_color WHERE cat_id="'.$cat_id.'"');
			$initial_color_data_rows=mysqli_num_rows($color_i_q);
			
			foreach($post['color_name'] as $clr_key=>$clr_value) {
				if(trim($clr_value)) {
					if($initial_color_data_rows<=0) {
						$query=mysqli_query($db,'INSERT INTO category_color(cat_id, color_name, color_code, color_price) values("'.$cat_id.'","'.real_escape_string($post['color_name'][$clr_key]).'","'.real_escape_string($post['color_code'][$clr_key]).'","'.$post['color_price'][$clr_key].'")');
						$saved_color_ids[] = mysqli_insert_id($db);
					} else {
						$color_q=mysqli_query($db,'SELECT * FROM category_color WHERE cat_id="'.$cat_id.'" AND id="'.$clr_key.'"');
						$category_color_data=mysqli_fetch_assoc($color_q);
						if(empty($category_color_data)) {
							$query=mysqli_query($db,'INSERT INTO category_color(cat_id, color_name, color_code, color_price) values("'.$cat_id.'","'.real_escape_string($post['color_name'][$clr_key]).'","'.real_escape_string($post['color_code'][$clr_key]).'","'.$post['color_price'][$clr_key].'")');
							$saved_color_ids[] = mysqli_insert_id($db);
						} else {
							$query=mysqli_query($db,'UPDATE category_color SET color_name="'.real_escape_string($post['color_name'][$clr_key]).'", color_code="'.real_escape_string($post['color_code'][$clr_key]).'", color_price="'.$post['color_price'][$clr_key].'" WHERE cat_id="'.$cat_id.'" AND id="'.$clr_key.'"');
							$saved_color_ids[] = $clr_key;
						}
					}
				}
			}
		}
		if(!empty($saved_color_ids)) {
			mysqli_query($db,"DELETE FROM category_color WHERE cat_id='".$cat_id."' AND id NOT IN(".implode(",",$saved_color_ids).")");
		} //END save/update for color section
		
		//START save/update for accessories section
		$saved_accessories_ids = array();
		if(empty($post['accessories_name'])) {
			mysqli_query($db,"DELETE FROM category_accessories WHERE cat_id='".$cat_id."'");
		} elseif(!empty($post['accessories_name'])) {
			$accessories_i_q=mysqli_query($db,'SELECT * FROM category_accessories WHERE cat_id="'.$cat_id.'"');
			$initial_accessories_data_rows=mysqli_num_rows($accessories_i_q);
			
			foreach($post['accessories_name'] as $accesr_key=>$accesr_value) {
				if(trim($accesr_value)) {
					if($initial_accessories_data_rows<=0) {
						$query=mysqli_query($db,'INSERT INTO category_accessories(cat_id, accessories_name, accessories_price) values("'.$cat_id.'","'.real_escape_string($post['accessories_name'][$accesr_key]).'","'.$post['accessories_price'][$accesr_key].'")');
						$saved_accessories_ids[] = mysqli_insert_id($db);
					} else {
						$accessories_q=mysqli_query($db,'SELECT * FROM category_accessories WHERE cat_id="'.$cat_id.'" AND id="'.$accesr_key.'"');
						$category_accessories_data=mysqli_fetch_assoc($accessories_q);
						if(empty($category_accessories_data)) {
							$query=mysqli_query($db,'INSERT INTO category_accessories(cat_id, accessories_name, accessories_price) values("'.$cat_id.'","'.real_escape_string($post['accessories_name'][$accesr_key]).'","'.$post['accessories_price'][$accesr_key].'")');
							$saved_accessories_ids[] = mysqli_insert_id($db);
						} else {
							$query=mysqli_query($db,'UPDATE category_accessories SET accessories_name="'.real_escape_string($post['accessories_name'][$accesr_key]).'", accessories_price="'.$post['accessories_price'][$accesr_key].'" WHERE cat_id="'.$cat_id.'" AND id="'.$accesr_key.'"');
							$saved_accessories_ids[] = $accesr_key;
						}
					}
				}
			}
		}
		if(!empty($saved_accessories_ids)) {
			mysqli_query($db,"DELETE FROM category_accessories WHERE cat_id='".$cat_id."' AND id NOT IN(".implode(",",$saved_accessories_ids).")");
		} //END save/update for accessories section

		//START save/update for screen_size section
		$saved_screen_size_ids = array();
		if(empty($post['screen_size_name'])) {
			mysqli_query($db,"DELETE FROM category_screen_size WHERE cat_id='".$cat_id."'");
		} elseif(!empty($post['screen_size_name'])) {
			$screen_size_i_q=mysqli_query($db,'SELECT * FROM category_screen_size WHERE cat_id="'.$cat_id.'"');
			$initial_screen_size_data_rows=mysqli_num_rows($screen_size_i_q);
			
			foreach($post['screen_size_name'] as $scrsz_key=>$scrsz_value) {
				if(trim($scrsz_value)) {
					if($initial_screen_size_data_rows<=0) {
						$query=mysqli_query($db,'INSERT INTO category_screen_size(cat_id, screen_size_name, screen_size_price) values("'.$cat_id.'","'.real_escape_string($post['screen_size_name'][$scrsz_key]).'","'.$post['screen_size_price'][$scrsz_key].'")');
						$saved_screen_size_ids[] = mysqli_insert_id($db);
					} else {
						$screen_size_q=mysqli_query($db,'SELECT * FROM category_screen_size WHERE cat_id="'.$cat_id.'" AND id="'.$scrsz_key.'"');
						$category_screen_size_data=mysqli_fetch_assoc($screen_size_q);
						if(empty($category_screen_size_data)) {
							$query=mysqli_query($db,'INSERT INTO category_screen_size(cat_id, screen_size_name, screen_size_price) values("'.$cat_id.'","'.real_escape_string($post['screen_size_name'][$scrsz_key]).'","'.$post['screen_size_price'][$scrsz_key].'")');
							$saved_screen_size_ids[] = mysqli_insert_id($db);
						} else {
							$query=mysqli_query($db,'UPDATE category_screen_size SET screen_size_name="'.real_escape_string($post['screen_size_name'][$scrsz_key]).'", screen_size_price="'.$post['screen_size_price'][$scrsz_key].'" WHERE cat_id="'.$cat_id.'" AND id="'.$scrsz_key.'"');
							$saved_screen_size_ids[] = $scrsz_key;
						}
					}
				}
			}
		}
		if(!empty($saved_screen_size_ids)) {
			mysqli_query($db,"DELETE FROM category_screen_size WHERE cat_id='".$cat_id."' AND id NOT IN(".implode(",",$saved_screen_size_ids).")");
		} //END save/update for screen_size section
		
		//START save/update for screen_resolution section
		$saved_screen_resolution_ids = array();
		if(empty($post['screen_resolution_name'])) {
			mysqli_query($db,"DELETE FROM category_screen_resolution WHERE cat_id='".$cat_id."'");
		} elseif(!empty($post['screen_resolution_name'])) {
			$screen_resolution_i_q=mysqli_query($db,'SELECT * FROM category_screen_resolution WHERE cat_id="'.$cat_id.'"');
			$initial_screen_resolution_data_rows=mysqli_num_rows($screen_resolution_i_q);
			
			foreach($post['screen_resolution_name'] as $scrrsl_key=>$scrrsl_value) {
				if(trim($scrrsl_value)) {
					if($initial_screen_resolution_data_rows<=0) {
						$query=mysqli_query($db,'INSERT INTO category_screen_resolution(cat_id, screen_resolution_name, screen_resolution_price) values("'.$cat_id.'","'.real_escape_string($post['screen_resolution_name'][$scrrsl_key]).'","'.$post['screen_resolution_price'][$scrrsl_key].'")');
						$saved_screen_resolution_ids[] = mysqli_insert_id($db);
					} else {
						$screen_resolution_q=mysqli_query($db,'SELECT * FROM category_screen_resolution WHERE cat_id="'.$cat_id.'" AND id="'.$scrrsl_key.'"');
						$category_screen_resolution_data=mysqli_fetch_assoc($screen_resolution_q);
						if(empty($category_screen_resolution_data)) {
							$query=mysqli_query($db,'INSERT INTO category_screen_resolution(cat_id, screen_resolution_name, screen_resolution_price) values("'.$cat_id.'","'.real_escape_string($post['screen_resolution_name'][$scrrsl_key]).'","'.$post['screen_resolution_price'][$scrrsl_key].'")');
							$saved_screen_resolution_ids[] = mysqli_insert_id($db);
						} else {
							$query=mysqli_query($db,'UPDATE category_screen_resolution SET screen_resolution_name="'.real_escape_string($post['screen_resolution_name'][$scrrsl_key]).'", screen_resolution_price="'.$post['screen_resolution_price'][$scrrsl_key].'" WHERE cat_id="'.$cat_id.'" AND id="'.$scrrsl_key.'"');
							$saved_screen_resolution_ids[] = $scrrsl_key;
						}
					}
				}
			}
		}
		if(!empty($saved_screen_resolution_ids)) {
			mysqli_query($db,"DELETE FROM category_screen_resolution WHERE cat_id='".$cat_id."' AND id NOT IN(".implode(",",$saved_screen_resolution_ids).")");
		} //END save/update for screen_resolution section
		
		//START save/update for lyear section
		$saved_lyear_ids = array();
		if(empty($post['lyear_name'])) {
			mysqli_query($db,"DELETE FROM category_lyear WHERE cat_id='".$cat_id."'");
		} elseif(!empty($post['lyear_name'])) {
			$lyear_i_q=mysqli_query($db,'SELECT * FROM category_lyear WHERE cat_id="'.$cat_id.'"');
			$initial_lyear_data_rows=mysqli_num_rows($lyear_i_q);
			
			foreach($post['lyear_name'] as $lyr_key=>$lyr_value) {
				if(trim($lyr_value)) {
					if($initial_lyear_data_rows<=0) {
						$query=mysqli_query($db,'INSERT INTO category_lyear(cat_id, lyear_name, lyear_price) values("'.$cat_id.'","'.real_escape_string($post['lyear_name'][$lyr_key]).'","'.$post['lyear_price'][$lyr_key].'")');
						$saved_lyear_ids[] = mysqli_insert_id($db);
					} else {
						$lyear_q=mysqli_query($db,'SELECT * FROM category_lyear WHERE cat_id="'.$cat_id.'" AND id="'.$lyr_key.'"');
						$category_lyear_data=mysqli_fetch_assoc($lyear_q);
						if(empty($category_lyear_data)) {
							$query=mysqli_query($db,'INSERT INTO category_lyear(cat_id, lyear_name, lyear_price) values("'.$cat_id.'","'.real_escape_string($post['lyear_name'][$lyr_key]).'","'.$post['lyear_price'][$lyr_key].'")');
							$saved_lyear_ids[] = mysqli_insert_id($db);
						} else {
							$query=mysqli_query($db,'UPDATE category_lyear SET lyear_name="'.real_escape_string($post['lyear_name'][$lyr_key]).'", lyear_price="'.$post['lyear_price'][$lyr_key].'" WHERE cat_id="'.$cat_id.'" AND id="'.$lyr_key.'"');
							$saved_lyear_ids[] = $lyr_key;
						}
					}
				}
			}
		}
		if(!empty($saved_lyear_ids)) {
			mysqli_query($db,"DELETE FROM category_lyear WHERE cat_id='".$cat_id."' AND id NOT IN(".implode(",",$saved_lyear_ids).")");
		} //END save/update for lyear section
		
		//START save/update for processor section
		$saved_processor_ids = array();
		if(empty($post['processor_name'])) {
			mysqli_query($db,"DELETE FROM category_processor WHERE cat_id='".$cat_id."'");
		} elseif(!empty($post['processor_name'])) {
			$processor_i_q=mysqli_query($db,'SELECT * FROM category_processor WHERE cat_id="'.$cat_id.'"');
			$initial_processor_data_rows=mysqli_num_rows($processor_i_q);
			
			foreach($post['processor_name'] as $prcr_key=>$prcr_value) {
				if(trim($prcr_value)) {
					if($initial_processor_data_rows<=0) {
						$query=mysqli_query($db,'INSERT INTO category_processor(cat_id, processor_name, processor_price) values("'.$cat_id.'","'.real_escape_string($post['processor_name'][$prcr_key]).'","'.$post['processor_price'][$prcr_key].'")');
						$saved_processor_ids[] = mysqli_insert_id($db);
					} else {
						$processor_q=mysqli_query($db,'SELECT * FROM category_processor WHERE cat_id="'.$cat_id.'" AND id="'.$prcr_key.'"');
						$category_processor_data=mysqli_fetch_assoc($processor_q);
						if(empty($category_processor_data)) {
							$query=mysqli_query($db,'INSERT INTO category_processor(cat_id, processor_name, processor_price) values("'.$cat_id.'","'.real_escape_string($post['processor_name'][$prcr_key]).'","'.$post['processor_price'][$prcr_key].'")');
							$saved_processor_ids[] = mysqli_insert_id($db);
						} else {
							$query=mysqli_query($db,'UPDATE category_processor SET processor_name="'.real_escape_string($post['processor_name'][$prcr_key]).'", processor_price="'.$post['processor_price'][$prcr_key].'" WHERE cat_id="'.$cat_id.'" AND id="'.$prcr_key.'"');
							$saved_processor_ids[] = $prcr_key;
						}
					}
				}
			}
		}
		if(!empty($saved_processor_ids)) {
			mysqli_query($db,"DELETE FROM category_processor WHERE cat_id='".$cat_id."' AND id NOT IN(".implode(",",$saved_processor_ids).")");
		} //END save/update for processor section
		
		//START save/update for ram section
		$saved_ram_ids = array();
		if(empty($post['ram_size'])) {
			mysqli_query($db,"DELETE FROM category_ram WHERE cat_id='".$cat_id."'");
		} elseif(!empty($post['ram_size'])) {
			$ram_i_q=mysqli_query($db,'SELECT * FROM category_ram WHERE cat_id="'.$cat_id.'"');
			$initial_ram_data_rows=mysqli_num_rows($ram_i_q);
			
			foreach($post['ram_size'] as $ram_key=>$ram_value) {
				if(trim($ram_value)) {
					if($initial_ram_data_rows<=0) {
						$query=mysqli_query($db,'INSERT INTO category_ram(cat_id, ram_size, ram_size_postfix, ram_price) values("'.$cat_id.'","'.real_escape_string($post['ram_size'][$ram_key]).'","'.real_escape_string($post['ram_size_postfix'][$ram_key]).'","'.$post['ram_price'][$ram_key].'")');
						$saved_ram_ids[] = mysqli_insert_id($db);
					} else {
						$ram_q=mysqli_query($db,'SELECT * FROM category_ram WHERE cat_id="'.$cat_id.'" AND id="'.$ram_key.'"');
						$category_ram_data=mysqli_fetch_assoc($ram_q);
						if(empty($category_ram_data)) {
							$query=mysqli_query($db,'INSERT INTO category_ram(cat_id, ram_size, ram_size_postfix, ram_price) values("'.$cat_id.'","'.real_escape_string($post['ram_size'][$ram_key]).'","'.real_escape_string($post['ram_size_postfix'][$ram_key]).'","'.$post['ram_price'][$ram_key].'")');
							$saved_ram_ids[] = mysqli_insert_id($db);
						} else {
							$query=mysqli_query($db,'UPDATE category_ram SET ram_size="'.real_escape_string($post['ram_size'][$ram_key]).'", ram_size_postfix="'.real_escape_string($post['ram_size_postfix'][$ram_key]).'", ram_price="'.$post['ram_price'][$ram_key].'" WHERE cat_id="'.$cat_id.'" AND id="'.$ram_key.'"');
							$saved_ram_ids[] = $ram_key;
						}
					}
				}
			}
		}
		if(!empty($saved_ram_ids)) {
			mysqli_query($db,"DELETE FROM category_ram WHERE cat_id='".$cat_id."' AND id NOT IN(".implode(",",$saved_ram_ids).")");
		} //END save/update for ram section
	}
	
	$tooltip_model=real_escape_string($post['tooltip_model']);
	$tooltip_device=real_escape_string($post['tooltip_device']);
	$tooltip_storage=real_escape_string($post['tooltip_storage']);
	$tooltip_condition=real_escape_string($post['tooltip_condition']);
	$tooltip_network=real_escape_string($post['tooltip_network']);
	$tooltip_connectivity=real_escape_string($post['tooltip_connectivity']);
	$tooltip_watchtype=real_escape_string($post['tooltip_watchtype']);
	$tooltip_case_material=real_escape_string($post['tooltip_case_material']);
	$tooltip_case_size=real_escape_string($post['tooltip_case_size']);
	$tooltip_color=real_escape_string($post['tooltip_color']);
	$tooltip_accessories=real_escape_string($post['tooltip_accessories']);
	$tooltip_screen_size=real_escape_string($post['tooltip_screen_size']);
	$tooltip_screen_resolution=real_escape_string($post['tooltip_screen_resolution']);
	$tooltip_lyear=real_escape_string($post['tooltip_lyear']);
	$tooltip_processor=real_escape_string($post['tooltip_processor']);
	$tooltip_ram=real_escape_string($post['tooltip_ram']);
	
	$storage_title=real_escape_string($post['storage_title']);
	$condition_title=real_escape_string($post['condition_title']);
	$network_title=real_escape_string($post['network_title']);
	$connectivity_title=real_escape_string($post['connectivity_title']);
	$case_size_title=real_escape_string($post['case_size_title']);
	$type_title=real_escape_string($post['type_title']);
	$case_material_title=real_escape_string($post['case_material_title']);
	$color_title=real_escape_string($post['color_title']);
	$accessories_title=real_escape_string($post['accessories_title']);
	$screen_size_title=real_escape_string($post['screen_size_title']);
	$screen_resolution_title=real_escape_string($post['screen_resolution_title']);
	$lyear_title=real_escape_string($post['lyear_title']);
	$processor_title=real_escape_string($post['processor_title']);
	$ram_title=real_escape_string($post['ram_title']);

	if($post['id']) {
		$query=mysqli_query($db,'UPDATE categories SET title="'.$title.'", fields_type="'.$fields_type.'" '.$imageupdate.', description="'.$description.'", published="'.$published.'", tooltip_device="'.$tooltip_device.'", tooltip_storage="'.$tooltip_storage.'", tooltip_condition="'.$tooltip_condition.'", tooltip_network="'.$tooltip_network.'", tooltip_connectivity="'.$tooltip_connectivity.'", tooltip_watchtype="'.$tooltip_watchtype.'", tooltip_case_material="'.$tooltip_case_material.'", tooltip_case_size="'.$tooltip_case_size.'", tooltip_color="'.$tooltip_color.'", tooltip_accessories="'.$tooltip_accessories.'", tooltip_screen_size="'.$tooltip_screen_size.'", tooltip_screen_resolution="'.$tooltip_screen_resolution.'", tooltip_lyear="'.$tooltip_lyear.'", tooltip_processor="'.$tooltip_processor.'", tooltip_ram="'.$tooltip_ram.'", storage_title="'.$storage_title.'", condition_title="'.$condition_title.'", network_title="'.$network_title.'", connectivity_title="'.$connectivity_title.'", case_size_title="'.$case_size_title.'", type_title="'.$type_title.'", case_material_title="'.$case_material_title.'", color_title="'.$color_title.'", accessories_title="'.$accessories_title.'", screen_size_title="'.$screen_size_title.'", screen_resolution_title="'.$screen_resolution_title.'", lyear_title="'.$lyear_title.'", processor_title="'.$processor_title.'", ram_title="'.$ram_title.'" WHERE id="'.$post['id'].'"');
		if($query=="1") {
			$cat_id = $post['id'];
			save_category_fields($cat_id,$post);

			$msg="Category has been successfully updated.";
			$_SESSION['success_msg']=$msg;
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
		}
		setRedirect(ADMIN_URL.'edit_category.php?id='.$post['id']);
	} else {
		$query=mysqli_query($db,'INSERT INTO categories(title, fields_type, image, description, published, tooltip_device, tooltip_storage, tooltip_condition, tooltip_network, tooltip_connectivity, tooltip_watchtype, tooltip_case_material, tooltip_case_size, tooltip_color, tooltip_accessories, tooltip_screen_size, tooltip_screen_resolution, tooltip_lyear, tooltip_processor, tooltip_ram, storage_title, condition_title, network_title, connectivity_title, case_size_title, type_title, case_material_title, color_title, accessories_title, screen_size_title, screen_resolution_title, lyear_title, processor_title, ram_title) values("'.$title.'","'.$fields_type.'","'.$image_name.'","'.$description.'","'.$published.'", "'.$tooltip_device.'", "'.$tooltip_storage.'", "'.$tooltip_condition.'", "'.$tooltip_network.'", "'.$tooltip_connectivity.'", "'.$tooltip_watchtype.'", "'.$tooltip_case_material.'", "'.$tooltip_case_size.'", "'.$tooltip_color.'", "'.$tooltip_accessories.'", "'.$tooltip_screen_size.'", "'.$tooltip_screen_resolution.'", "'.$tooltip_lyear.'", "'.$tooltip_processor.'", "'.$tooltip_ram.'", "'.$storage_title.'", "'.$condition_title.'", "'.$network_title.'", "'.$connectivity_title.'", "'.$case_size_title.'", "'.$type_title.'", "'.$case_material_title.'", "'.$color_title.'", "'.$accessories_title.'", "'.$screen_size_title.'", "'.$screen_resolution_title.'", "'.$lyear_title.'", "'.$processor_title.'", "'.$ram_title.'")');
		if($query=="1") {
			$cat_id = mysqli_insert_id($db);
			save_category_fields($cat_id,$post);
			
			$msg="Category has been successfully added.";
			$_SESSION['success_msg']=$msg;
			setRedirect(ADMIN_URL.'device_categories.php');
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_category.php');
		}
	}
} elseif($post['sbt_order']) {
	foreach($post['ordering'] as $ordering_key => $ordering_val) {
		if($ordering_val>0) {
			$query = mysqli_query($db,"UPDATE categories SET ordering='".$ordering_val."' WHERE id='".$ordering_key."'");
		}
	}
	if($query=="1") {
		$msg="Order(s) successfully saved.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong updation failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'device_categories.php');
} elseif($post['r_img_id']) {
	$get_behand_data=mysqli_query($db,'SELECT image FROM categories WHERE id="'.$post['r_img_id'].'"');
	$brand_data=mysqli_fetch_assoc($get_behand_data);

	$del_logo=mysqli_query($db,'UPDATE categories SET image="" WHERE id='.$post['r_img_id']);
	if($brand_data['image']!="")
		unlink('../../images/categories/'.$brand_data['image']);

	setRedirect(ADMIN_URL.'edit_category.php?id='.$post['id']);
} else {
	setRedirect(ADMIN_URL.'device_categories.php');
}
exit();
?>