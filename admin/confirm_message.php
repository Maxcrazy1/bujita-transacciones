<?php
//START for show confirmation message for success
if($_SESSION['success_msg']!=""){ ?>
	<div class="alert alert-success fade in">
	   <a data-dismiss="alert" class="close">x</a>
	   <strong><?=$_SESSION['success_msg']?></strong>
	</div>		
<?php
} unset($_SESSION['success_msg']);
//END for show confirmation message for success

//START for show confirmation message for error
if(@$_SESSION['error_msg']){ ?>
	<div class="alert alert-error fade in">
	   <a data-dismiss="alert" class="close">x</a>
	   <strong><?=$_SESSION['error_msg']?></strong>
	</div>
<?php
} unset($_SESSION['error_msg']);
//END for show confirmation message for error ?>