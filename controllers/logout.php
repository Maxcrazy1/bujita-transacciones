<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");

unset($_SESSION['login_user']);
unset($_SESSION['user_id']);
unset($_SESSION['tmp_order_id']);

setRedirect(SITE_URL);
exit();
?>