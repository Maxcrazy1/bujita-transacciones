<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");

$list_of_model = '';
$query = $_REQUEST['query'];
if($query) {
	$top_search_query=mysqli_query($db,"SELECT m.*, d.title AS device_title, d.device_img, d.sef_url, b.title AS brand_title, b.ordering AS brand_ordering, b.id AS brand_id FROM mobile AS m LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE m.published=1 AND (m.searchable_words LIKE '%".$query."%' OR m.title LIKE '%".$query."%' OR b.title LIKE '%".$query."%' OR concat(b.title,' ', m.title) LIKE '%".$query."%') ORDER BY m.ordering ASC");
	while($top_search_data=mysqli_fetch_assoc($top_search_query)) {
		$name = $top_search_data['brand_title'].' '.$top_search_data['title'];
		$url = SITE_URL.$top_search_data['sef_url'].'/'.createSlug($top_search_data['title']).'/'.$top_search_data['id'];
		$list_of_model .= '{"value":"'.$name.'", "url":"'.$url.'"},';

	  /*$ts_storage_list = get_models_storage_data($top_search_data['id']);
	  if(empty($ts_storage_list)) {
		$ts_storage_list[0] = array("storage_size"=>"");
	  }
	  if(!empty($ts_storage_list)) {
		  foreach($ts_storage_list as $ts_storage) {
			 $name = $top_search_data['brand_title'].' '.$top_search_data['title'].($ts_storage['storage_size']?' '.$ts_storage['storage_size'].$ts_storage['storage_size_postfix']:'');
			 $url = SITE_URL.$top_search_data['sef_url'].'/'.createSlug($top_search_data['title']).'/'.$top_search_data['id'].($ts_storage['storage_size']?'/'.$ts_storage['storage_size']:'');
			 $list_of_model .= '{"value":"'.$name.'", "url":"'.$url.'"},';
		  }
	  }*/
	}
}

echo '{
		"query": "Unit",
		"suggestions": ['.rtrim($list_of_model,',').']
	}';
?>