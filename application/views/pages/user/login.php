<div class="row">
	<div class="large-6 columns large-centered">
		<h1>Login</h1>
		 <?php echo validation_errors(); ?>
		 <?php echo form_open('verifylogin'); ?>
		   <label for="username">Username:</label>
		   <input type="text" size="20" id="username" name="username"/>
		   <br/>
		   <label for="password">Password:</label>
		   <input type="password" size="20" id="passowrd" name="password"/>
		   <br/>
		   <input type="submit" value="Login" class="button"/> <a href="register" >Register</a>
		 </form>
	</div>
</div>
