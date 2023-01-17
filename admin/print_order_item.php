<?php
require_once("_config/config.php");
require_once("include/functions.php");

$order_id = $post['order_id'];
$item_id = $post['item_id'];

//Get order batch data, path of this function (get_order_data) admin/include/functions.php
$order_data = get_order_data($order_id);

$order_item_data = get_order_item($item_id,'general');
?>

<!doctype html>
<html>
<head>
<title></title>
<style type="text/css" media="print">
@page {
	size: 36mm 89mm; 
	margin: 0mm;
}
body {
	background-color:#FFFFFF; 
	margin: 20px;
}
</style>
</head>
<body>
<?php
//Template file
require_once("views/print_order_item.php"); ?>

<script language="javascript" type="text/javascript">
function printDiv(divID) {
	var divElements = document.getElementById(divID).innerHTML;
	var oldPage = document.body.innerHTML;

	document.body.innerHTML = divElements;

	//Print Page
	window.print();

	//Restore orignal HTML
	document.body.innerHTML = oldPage;
	return true;
}

window.addEventListener("afterprint", myFunction);
function myFunction() {
	window.close();
}

printDiv('print_order_data');
</script>
</body>
</html>