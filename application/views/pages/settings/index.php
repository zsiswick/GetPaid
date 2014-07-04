<div class="row">
	<div class="large-6 columns large-centered">
		<h1><?php echo($first_name);?>'s Settings</h1>
		<?php echo validation_errors(); ?>
		<?php var_dump($settings)?>
		<?php echo form_open('settings/') ?>
			<input type="hidden" name="sid" value="" />
			<label for="due">Due</label>
			<select name="due">
				<option value="15">15 Days</option>
				<option value="30">30 Days</option>
				<option value="45">45 Days</option>
			</select><br />
			   
			<label for="notes">Notes</label>
			<textarea name="notes" cols="30" rows="10"></textarea><br />
			
			<input type="submit" name="submit" value="Save Changes" class="button round" />
		
		</form>
	</div>
</div>
