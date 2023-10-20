<div id="wrapper">
    <header id="header" class="container">
    	<?php include("include/admin_menu.php"); ?>
    </header>

	<section class="container" role="main">
		<div class="row">
            <article class="span12 data-block">
				<header><h2>Email/SMS Details</h2></header>
                <section>
					<?php include('confirm_message.php');?>
                    <div class="row-fluid">
						<div class="span9">
						<fieldset>
							<div class="control-group">
								<label class="control-label" for="input"><h4>Email Content:</h4></label>
								<div class="controls">
									<?=$brand_data['body']?>
								</div>
							</div>
							
							<?php
							if($brand_data['sms_content']!="") { ?>
								<div class="control-group" style="margin-top:50px;">
									<label class="control-label" for="input"><h4>SMS Content:</h4></label>
									<div class="controls">
										<?=$brand_data['sms_content']?>
									</div>
								</div>
							<?php
							} ?>
							
							<div class="form-actions">
								<a href="emailsms_history.php" class="btn btn-alt btn-large btn-black">Back</a>
							</div>
						</fieldset>
						</div>
                    </div>
                </section>
            </article>
        </div>
    </section>
	<div id="push"></div>
</div>