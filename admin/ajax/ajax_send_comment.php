<?php
require_once("../_config/config.php");
require_once("../include/functions.php");

$response = array();

$post = $_REQUEST;
$staff_id = $post['staff_id'];
$order_id = $post['order_id'];
$c_status = $post['c_status'];
$comment=real_escape_string($post['comment']);
$date = date("Y-m-d H:i:s");

if($staff_id == "" && $order_id == "") {
	exit;
} elseif($comment=="") {
	$response['message'] = "Please fill up mandatory fields.";
	$response['status'] = false;
} else {
	$c_query = mysqli_query($db,"INSERT INTO comments(`staff_id`, `order_id`, `comment`, `status`, `date`) VALUES('".$staff_id."','".$order_id."','".$comment."','".$c_status."','".$date."')");
	$last_insert_id = mysqli_insert_id($db);
	if($c_query == '1') {
		$response['message'] = "You have successfully submitted";
		$response['status'] = true;
		$response['is_comment'] = "yes";
		$response['comments'] = $comment;
		$response['c_status'] = ucwords(str_replace("_"," ",$c_status));
		$response['date'] = format_date($date).' '.format_time($date);
		
		$comment_query=mysqli_query($db,"SELECT c.*, s.name AS staff_name, s.username AS staff_username FROM comments AS c LEFT JOIN admin AS s ON s.id=c.staff_id WHERE c.id='".$last_insert_id."'");
		$comment_data = mysqli_fetch_assoc($comment_query);
		$response['staff_username'] = $comment_data['staff_username'];
	} else {
		$response['message'] = "Something went wrong!!!";
		$response['status'] = false;
	}
}

echo json_encode($response);
exit;
?>