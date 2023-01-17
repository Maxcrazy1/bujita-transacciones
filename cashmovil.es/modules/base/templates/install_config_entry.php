<h2>Configuration Settings</h2>
<p>All of the form fields below should be automatically filled in for you by the installer, and you can normally just click Continue...</p>
<div id="configSettings">
	<form method="POST">
		
		<h3>Web URL of OWA</h3>
		<p class="form-row">
			<span class="form-label">URL of OWA:</span>
			<span class="form-field">
				<input type="text"size="50" name="<?php echo $this->getNs();?>public_url" value="<?php echo $public_url;?>">
			</span>
			<span class="form-instructions">This is the web URL of OWA's base directory.</span>
		</p>
		
		<h3>Database</h3>
		<p class="form-row">
			<span class="form-label">Database Type:</span>
			<span class="form-field">
				<select name="<?php echo $this->getNs();?>db_type">
					<option value="mysql">Mysql</option>
				</select>
			</span>
			<span class="form-instructions">This is the type of database you are going to use.</span>
		</p>
		
		<p class="form-row">
			<span class="form-label">Database Host:</span>
			<span class="form-field">
				<input type="text"size="30" name="<?php echo $this->getNs();?>db_host" value="sdb-x.hosting.stackcp.net">
			</span>
			<span class="form-instructions">This is the host that your database resides on.</span>
		</p>
		
		<p class="form-row">
			<span class="form-label">Database Name:</span>
			<span class="form-field">
				<input type="text"size="30" name="<?php echo $this->getNs();?>db_name" value="openwebanalytics-3231342d7f">
			</span>
			<span class="form-instructions">This is the name of the database to install tables into.</span>
		</p>
		
		<p class="form-row">
			<span class="form-label">Database User:</span>
			<span class="form-field">
				<input type="text"size="30" name="<?php echo $this->getNs();?>db_user" value="openwebanalytics-3231342d7f">
			</span>
			<span class="form-instructions">This is the user name to connect to the database.</span>
		</p>
		
		<p class="form-row">
			<span class="form-label">Database Password:</span>
			<span class="form-field">
				<input type="text"size="30" name="<?php echo $this->getNs();?>db_password" value="b85d4d99de44">
			</span>
			<span class="form-instructions">This is the password to connect to the database.</span>
		</p>
		<p>
			<?php echo $this->createNonceFormField('base.installConfig');?>
			<input type="hidden" value="base.installConfig" name="<?php echo $this->getNs();?>action">
			<input class="owa-button"type="submit" value="Continue..." name="<?php echo $this->getNs();?>save_button">
		<p>
		
	</form>
	
</div>