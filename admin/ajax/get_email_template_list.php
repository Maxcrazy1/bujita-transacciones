<?php
require_once("../_config/config.php");
require_once("../include/functions.php");

$status = $post['status'];
if($status != "") {
	$template_type_val = "order_".$status."_status";
	$query=mysqli_query($db,"SELECT * FROM mail_templates WHERE status='1' AND type='".$template_type_val."' AND is_fixed='0'");
	$mail_tmpl_num=mysqli_num_rows($query);
	if($mail_tmpl_num>0) { ?>
	<div class="control-group">
		<label class="control-label" for="input">Email Template: </label>
		<div class="controls">
			<select name="email_template" id="email_template" onchange="ChangeEmailTemplate(this.value)">
			<?php
			echo '<option value="">Choose Email Template</option>';
			while($mail_tmpl_list=mysqli_fetch_assoc($query)) {
				echo '<option value="'.$mail_tmpl_list['id'].'">'.$mail_tmpl_list['subject'].'</option>';
			} ?>
			</select>
		</div>
	</div>
	<?php
	}
} ?>