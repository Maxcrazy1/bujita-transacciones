<?php 

require_once("admin/include/functions.php");
require_once("admin/_config/config.php");


$device_data_list = get_device_data_list();
$brand_data_list = get_brand_data();

$base_url = "https://cellsensei.macmetro.com";

header("Content-Type: application/xml; charset=utf-8");

echo '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL;

echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" 
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 
http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">'.PHP_EOL;

echo '<url>'.PHP_EOL;
echo '<loc>'.$base_url.'</loc>'.PHP_EOL;
echo '<lastmod>'.date(DATE_ATOM,time()).'</lastmod>'.PHP_EOL;
echo '<changefreq>daily</changefreq>'.PHP_EOL;
echo '<priority>1.0</priority>'.PHP_EOL;
echo '</url>'.PHP_EOL;

$my_query = "SELECT * FROM brand";
$result_brands = mysqli_query($db, $my_query);

while($row = mysqli_fetch_array($result_brands))
{
    if($row["published"] == 1){
		echo '<url>'.PHP_EOL;
		echo '<loc>'.$base_url.'/brand/'.$row["sef_url"].'</loc>'.PHP_EOL;
		echo '<lastmod>'.date(DATE_ATOM,time()).'</lastmod>'.PHP_EOL;
		echo '<changefreq>daily</changefreq>'.PHP_EOL;
		echo '<priority>1.0</priority>'.PHP_EOL;
		echo '</url>'.PHP_EOL;
	}
}

$my_query = "SELECT * FROM devices";
$result_devices = mysqli_query($db, $my_query);

while($row = mysqli_fetch_array($result_devices))
{
    if($row["published"] == 1){
		echo '<url>'.PHP_EOL;
		echo '<loc>'.$base_url.'/'.$row["sef_url"].'</loc>'.PHP_EOL;
		echo '<lastmod>'.date(DATE_ATOM,time()).'</lastmod>'.PHP_EOL;
		echo '<changefreq>daily</changefreq>'.PHP_EOL;
		echo '<priority>1.0</priority>'.PHP_EOL;
		echo '</url>'.PHP_EOL;
	}
}

//TO DO
// Devices_brands
//Brands_devices
//Models
// CATEGORY ID: 6 - Phones, 7 - Tablets, 13 - Watch, 17 - laptops,
// BRAND ID: 32 - Apple, 33 - Samsung, 34 - Dell, 35 - Google, 36 - Motorola
// 			 37 - Nokia, 38 - HTC, 39 - Sony, 40 - Xiaomi, 41 - Lenovo, 42 - LG
// 			 43 - Huawei, 44 - HP, 45 - Microsoft, 
// DEVICE ID: 6 - Phones, 7 - Tablets, 13 - Watch, 17 - laptops,

$my_query = "SELECT * FROM mobile";
$result_mobile = mysqli_query($db, $my_query);
$my_array = array();
$counter = 0;

while($row = mysqli_fetch_array($result_mobile))
{
    if($row["published"] == 1){
		$tmp_result = mysqli_fetch_array(mysqli_query($db,"SELECT * FROM devices WHERE id='".$row["device_id"]."'"));
		$brand_id = $row["brand_id"];
		$device_id = $row["device_id"];
		
		if( !in_array($brand_id.'_'.$device_id, $my_array) ){
			$tmp_result_1 = mysqli_fetch_array(mysqli_query($db,"SELECT * FROM brand WHERE id='".$brand_id."'"));
			echo '<url>'.PHP_EOL;
			echo '<loc>'.$base_url.'/brand/'.$tmp_result_1["sef_url"].'/'.$tmp_result["sef_url"].'</loc>'.PHP_EOL;
			echo '<lastmod>'.date(DATE_ATOM,time()).'</lastmod>'.PHP_EOL;
			echo '<changefreq>daily</changefreq>'.PHP_EOL;
			echo '<priority>1.0</priority>'.PHP_EOL;
			echo '</url>'.PHP_EOL;
			$my_array[$counter] = $brand_id.'_'.$device_id;
			$counter += 1;
		}
		
		echo '<url>'.PHP_EOL;
		echo '<loc>'.$base_url.'/'.$tmp_result["sef_url"].'/'.createSlug($row["title"]).'/'.$row["id"].'</loc>'.PHP_EOL;
		echo '<lastmod>'.date(DATE_ATOM,time()).'</lastmod>'.PHP_EOL;
		echo '<changefreq>daily</changefreq>'.PHP_EOL;
		echo '<priority>1.0</priority>'.PHP_EOL;
		echo '</url>'.PHP_EOL;
	}
}





$my_query = "SELECT * FROM menus";
$result_static = mysqli_query($db, $my_query);

while($row = mysqli_fetch_array($result_static))
{
    if(($row["is_custom_url"] == 1) && !(preg_match("/sell-/",strtolower($row["url"]))) ) {
			echo '<url>'.PHP_EOL;
			echo '<loc>'.$row["url"].'</loc>'.PHP_EOL;
			echo '<lastmod>'.date(DATE_ATOM,time()).'</lastmod>'.PHP_EOL;
			echo '<changefreq>daily</changefreq>'.PHP_EOL;
			echo '<priority>1.0</priority>'.PHP_EOL;
			echo '</url>'.PHP_EOL;
		
    }

}


echo '</urlset>'.PHP_EOL;


?>