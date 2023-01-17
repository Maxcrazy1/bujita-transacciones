<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");

$query=mysqli_query($db,"SELECT m.*, d.title AS device_title, d.device_img, d.sef_url, b.title AS brand_title, b.id AS brand_id FROM mobile AS m LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE m.device_id='".$post['device_id']."' ORDER BY m.ordering DESC");
echo '<option value="">Please Choose</option>';
while($top_search_data=mysqli_fetch_assoc($query)) {
  $ts_storage_list = json_decode($top_search_data['storage']);
  if(!empty($ts_storage_list)) {
	  foreach($ts_storage_list as $ts_storage) {
		 echo '<option value="'.SITE_URL.$top_search_data['sef_url'].'/'.createSlug($top_search_data['title']).'/'.$top_search_data['id'].'/'.$ts_storage->storage_size.'">'.$top_search_data['title'].' '.$ts_storage->storage_size.'</option>';
	  }
  } else {
  	 echo '<option value="'.SITE_URL.$top_search_data['sef_url'].'/'.createSlug($top_search_data['title']).'/'.$top_search_data['id'].'">'.$top_search_data['title'].'</option>';
  }
}
?>