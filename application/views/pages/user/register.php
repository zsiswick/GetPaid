<div class="row">
	<div class="large-6 columns large-centered">
		<h1>Register</h1>
		 <?php echo validation_errors(); ?>
		 <?php echo form_open('verifyregistration'); ?>
		   <label for="first_name">First Name:</label>
		   <input type="text" size="20" id="first_name" name="first_name"/>
		   <label for="first_name">Last Name:</label>
		   <input type="text" size="20" id="last_name" name="last_name"/>
		   <label for="email">Email Address:</label>
		   <input type="text" size="20" id="email" name="email"/>
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
