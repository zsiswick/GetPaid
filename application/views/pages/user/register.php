<div class="row">
	<div class="large-6 columns large-centered">
		<h1>Register</h1>
		 <?php echo validation_errors(); ?>
		 <?php echo form_open('verifyregistration'); ?>
		   <label for="username">Username:</label>
		   <input type="text" size="20" id="username" name="username"/>
		   <br/>
		   <label for="password">Password:</label>
		   <input type="password" size="20" id="passowrd" name="password"/>
		   <label for="password">Password Confirmation:</label>
		   <input type="password" size="20" id="passowrd2" name="password2"/>
		   <br/>
		   <input type="submit" value="Register" class="button"/> 
		 </form>
	</div>
</div>
