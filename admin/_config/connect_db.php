<?php 
ini_set('memory_limit', '512M');
ob_start();
session_start();

$host = 'sdb-m.hosting.stackcp.net';
$db_user = 'demo10-3139356d07';
$db_password = '1o5jdsfeqi';
$db_name = 'demo10-3139356d07';

$db = mysqli_connect($host,$db_user,$db_password,$db_name) or die('Unable to connect to the database');

//mysqli_query($db,"SET sql_mode='STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION'");
mysqli_query($db,"SET sql_mode='NO_ENGINE_SUBSTITUTION'");

?>