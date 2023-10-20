<?php 
session_start();
unset($_SESSION['is_admin']);
unset($_SESSION['admin_username']);
header('location: index.php');
exit();
?>