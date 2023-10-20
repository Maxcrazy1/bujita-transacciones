<script type="text/javascript">
function checklogin(a){
	if(a.username.value.trim()==""){
		alert('Please enter your username');
		a.username.focus();
		a.username.value='';
		return false;
	}
	if(a.password.value.trim()==""){
		alert('Please enter your password');
		a.password.focus();
		a.password.value='';
		return false;
	}
}
</script>

<body class="login">
	<section class="container" role="main">
		<?php 
		require_once('confirm_message.php'); ?>
		<div class="login-logo">
			<a href="login.html"><?=ADMIN_PANEL_NAME?></a>
			<h4>Welcome to <?=ADMIN_PANEL_NAME?></h4>
		</div>

		<form action="controllers/admin_user/login.php" method="post" role="form" onSubmit="return checklogin(this);">
			<div class="control-group">
			  <div class="form-controls">
				<div class="input-prepend"> <span class="add-on"><span class="icon-user"></span></span>
				  <input type="text" class="form-control" name="username" id="username" placeholder="Username" autocomplete="off" />
				</div>
			  </div>
			</div>
			<div class="control-group">
			  <div class="form-controls">
				<div class="input-prepend"> <span class="add-on"><span class="icon-key"></span></span>
				  <input type="password" class="form-control" name="password" id="password" placeholder="Password" autocomplete="off" />
				</div>
			  </div>
			</div>
			<button class="btn btn-alt btn-primary btn-large btn-block" type="submit" name="login">Login</button>
			<div class="login-credits text-center"> <a class="login-link" href="lostlogin.php">Lost your password?</a></div>
		</form>
	</section>
</body>