<script type="text/javascript">
function check_form(a){
	if(a.username.value.trim()==""){
		alert('Please enter your username');
		a.username.focus();
		a.username.value='';
		return false;
	}

	if(a.email.value.trim()==""){
		alert('Please enter your email');
		a.email.focus();
		a.email.value='';
		return false;
	}

	if(a.password.value.trim()!=""){
		if(a.rpassword.value.trim()==""){
			alert('Please retype password.');
			a.rpassword.focus();
			a.rpassword.value='';
			return false;
		}

		if(a.password.value.trim()!=a.rpassword.value.trim()){
			alert('Password and Retype password not matched.');
			a.rpassword.focus();
			a.rpassword.value='';
			return false;
		}
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
				<header><h2><span class="icon-user"></span> My Account</h2></header>
                <section>
					<?php include('confirm_message.php'); ?>
                    <div class="row-fluid">
                        <div class="span6">
                            <h4>Edit Profile</h4>
                            <form action="controllers/admin_user/profile.php" role="form" class="form-horizontal form-groups-bordered" method="post" onSubmit="return check_form(this);">
                                <fieldset>
                                    <div class="control-group">
                                        <label class="control-label" for="input">Username *</label>
                                        <div class="controls">
											<input type="text" class="input-xlarge" id="field-1" value="<?=@$get_userdata_row['username']?>" name="username">
                                        </div>
                                    </div>
									
									<div class="control-group">
                                        <label class="control-label" for="input">Email *</label>
                                        <div class="controls">
											<input type="text" class="input-xlarge" id="field-1" value="<?=@$get_userdata_row['email']?>" name="email">
                                        </div>
                                    </div>
									
									<div class="control-group">
                                        <label class="control-label" for="input">Change Password</label>
                                        <div class="controls">
											<input type="password" class="input-xlarge" id="field-3" name="password">
                                        </div>
                                    </div>
									
									<div class="control-group">
                                        <label class="control-label" for="input">Retype Password</label>
                                        <div class="controls">
											<input type="password" class="input-xlarge" id="field-3" name="rpassword">
                                        </div>
                                    </div>
                                    <input type="hidden" name="id" value="<?=@$get_userdata_row['id']?>" />
         							<input type="hidden" name="old_password" value="<?=@$get_userdata_row['password']?>" />
									 
                                    <div class="form-actions">
                                        <button class="btn btn-alt btn-large btn-primary" type="submit" name="update">Update</button>
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