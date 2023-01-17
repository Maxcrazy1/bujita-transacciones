<script type="text/javascript">
function check_form(a) {
	if(a.username.value.trim()==""){
		alert('Please enter username');
		a.username.focus();
		a.username.value='';
		return false;
	}
	if(a.email.value.trim()==""){
		alert('Please enter email');
		a.email.focus();
		a.email.value='';
		return false;
	}
	
	<?php
	if($admin_data['id']=='') { ?>
		if(a.password.value.trim()==""){
			alert('Please enter password.');
			a.password.focus();
			a.password.value='';
			return false;
		}
	<?php
	} ?>
	
	if(a.password.value.trim()!=""){
		if(a.rpassword.value.trim()==""){
			alert('Please enter confirm password.');
			a.rpassword.focus();
			a.rpassword.value='';
			return false;
		}
		if(a.password.value.trim()!=a.rpassword.value.trim()){
			alert('Password and confirm password not matched.');
			a.rpassword.focus();
			a.rpassword.value='';
			return false;
		}
	}
	if(a.group_id.value.trim()==""){
		alert('Please select group');
		a.group_id.focus();
		a.group_id.value='';
		return false;
	}
}
</script>

<div id="wrapper">
    <header id="header" class="container">
    	<?php include("include/admin_menu.php"); ?>
    </header>

	<section class="container" role="main">
		<div class="row">
            <article class="span12 data-block">
				<header><h2><?=($id?'Edit Staff':'Add Staff')?></h2></header>
                <section>
					<?php include('confirm_message.php');?>
                    <div class="row-fluid">
                        <div class="span9">
                            <form role="form" action="controllers/staff.php" class="form-horizontal form-groups-bordered" method="post" onSubmit="return check_form(this);" enctype="multipart/form-data">
                                <fieldset>
                                    <div class="control-group">
                                        <label class="control-label" for="input">Username</label>
                                        <div class="controls">
											<input type="text" class="input-large" id="username" value="<?=$admin_data['username']?>" name="username">
                                        </div>
                                    </div>
									
									<div class="control-group">
                                        <label class="control-label" for="input">Email</label>
                                        <div class="controls">
											<input type="text" class="input-large" id="email" value="<?=$admin_data['email']?>" name="email">
                                        </div>
                                    </div>
									
									<div class="control-group">
                                        <label class="control-label" for="input">Password</label>
                                        <div class="controls">
											<input type="password" class="input-large" id="password" name="password">
                                        </div>
                                    </div>
									
									<div class="control-group">
                                        <label class="control-label" for="input">Confirm Password</label>
                                        <div class="controls">
											<input type="password" class="input-large" id="rpassword" name="rpassword">
                                        </div>
                                    </div>
									
									<div class="control-group">
										<label class="control-label" for="input">Group</label>
										<div class="controls">
											<select name="group_id" id="group_id" class="form-control">
												<option value=""> -Select- </option>
												<?php
												while($staff_group_list = mysqli_fetch_assoc($staff_groups_query)) {?>
													<option value="<?=$staff_group_list['id']?>" <?php if($admin_data['group_id'] == $staff_group_list['id']){echo 'selected="selected"';}?>> <?=$staff_group_list['name']?> </option>
												<?php
												} ?>
											</select>
										</div>
									</div>
									
									<div class="control-group radio-inline">
										<label class="control-label" for="published">Status</label>
										<div class="controls">
											<label class="radio-custom-inline custom-radio">
												<input type="radio" id="status" name="status" value="1" <?=($admin_data['status']==1?'checked="checked"':'')?>>
												Active
											</label>
											<label class="radio-custom-inline ml-10 custom-radio">
												<input type="radio" id="status" name="status" value="0" <?=($admin_data['status']=='0'||$admin_data['status']==''?'checked="checked"':'')?>>
												Inactive
											</label>
										</div>
									</div>
									
									<input type="hidden" name="id" value="<?=$admin_data['id']?>" />
								 
									<div class="form-actions">
										<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button>
										<a href="staff.php" class="btn btn-alt btn-large btn-black">Back</a>
									</div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </section>
            </article>
        </div>
    </section>
	<div id="push"></div>
</div>