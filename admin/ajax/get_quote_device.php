<?php
require_once("../_config/config.php");
require_once("../include/functions.php");

//$query=mysqli_query($db,"SELECT * FROM devices WHERE published=1 AND brand_id='".$post['brand_id']."'");
$query=mysqli_query($db,"SELECT d.id, d.title FROM mobile AS m LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE m.brand_id='".$post['brand_id']."' GROUP BY m.device_id ORDER BY d.id DESC");
echo '<option value="">Please Choose</option>';
while($device_list=mysqli_fetch_assoc($query)) {
	echo '<option value="'.$device_list['id'].'">'.$device_list['title'].'</option>';
}	
?>