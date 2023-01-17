<?php
require_once("../_config/config.php");
require_once("../include/functions.php");

$id = $post['id'];
$order_id = $post['order_id'];

$query=mysqli_query($db,"SELECT * FROM mail_templates WHERE status='1' AND id='".$id."'");
$mail_tmpl_data=mysqli_fetch_assoc($query);

$template_data = get_template_data('admin_reply_from_order');
$general_setting_data = get_general_setting_data();
$admin_user_data = get_admin_user_data();
$order_data = get_order_data($order_id);

$patterns = array(
	'{$logo}',
	'{$admin_logo}',
	'{$admin_email}',
	'{$admin_username}',
	'{$admin_site_url}',
	'{$admin_panel_name}',
	'{$from_name}',
	'{$from_email}',
	'{$site_url}',
	'{$customer_fname}',
	'{$customer_lname}',
	'{$customer_fullname}',
	'{$customer_phone}',
	'{$customer_email}',
	'{$customer_address_line1}',
	'{$customer_address_line2}',
	'{$customer_city}',
	'{$customer_state}',
	'{$customer_country}',
	'{$customer_postcode}',
	'{$customer_company_name}',
	'{$order_id}',
	'{$order_payment_method}',
	'{$order_date}',
	'{$order_approved_date}',
	'{$order_expire_date}',
	'{$order_sales_pack}',
	'{$current_date_time}');

$replacements = array(
	$logo,
	$admin_logo,
	$admin_user_data['email'],
	$admin_user_data['username'],
	ADMIN_URL,
	$general_setting_data['admin_panel_name'],
	$general_setting_data['from_name'],
	$general_setting_data['from_email'],
	SITE_URL,
	$order_data['first_name'],
	$order_data['last_name'],
	$order_data['name'],
	$order_data['phone'],
	$order_data['email'],
	$order_data['address'],
	$order_data['address2'],
	$order_data['city'],
	$order_data['state'],
	$order_data['country'],
	$order_data['postcode'],
	$order_data['company_name'],
	$order_data['order_id'],
	$order_data['payment_method'],
	$order_data['order_date'],
	$order_data['approved_date'],
	$order_data['expire_date'],
	$order_data['sales_pack'],
	date('Y-m-d H:i'));

$email_subject = str_replace($patterns,$replacements,$mail_tmpl_data['subject']);
$email_body_text = str_replace($patterns,$replacements,$mail_tmpl_data['content']);
?>

<textarea class="input-xlarge wysihtml5" name="note" id="note" placeholder="note" rows="25"><?=$email_body_text?></textarea>

<!-- Wysihtml5 -->
<script src="js/plugins/wysihtml5/wysihtml5-0.3.0.js"></script>
<script src="js/plugins/wysihtml5/bootstrap-wysihtml5.js"></script>
<script>
$(document).ready(function() {
	// Note, we are adding .btn-alt to toolbar template directly in bootstrap-wysihtml5.js for better readability
	$('.wysihtml5').wysihtml5({
		"font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
	"emphasis": true, //Italics, bold, etc. Default true
	"lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
	"html": true, //Button which allows you to edit the generated HTML. Default false
	"link": true, //Button to insert a link. Default true
	"image": true, //Button to insert an image. Default true,
	"color": false, //Button to change color of font  
	parser: function(html) {
        return html;
    }
	});
});
</script>