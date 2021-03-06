<div class="row">
	<div class="large-6 columns large-centered">
		<h2>Edit Client</h2>
		<?php echo validation_errors(); ?>
		
		<?php echo form_open('clients/edit') ?>
			<input type="hidden" name="cid" value="<?php echo $client[0]['id'] ?>" />
			<label for="company">Company</label>
			<input type="text" name="company" value="<?php echo $client[0]['company'] ?>"/><br />
			   
			<label for="contact">Contact Name</label>
			<input type="text" name="contact" value="<?php echo $client[0]['contact'] ?>"/><br />
			
			<label for="email">Email</label>
			<input type="text" name="email" value="<?php echo $client[0]['email'] ?>" /><br />
			
			<label for="address_1">Address 1</label>
			<input type="text" name="address_1" value="<?php echo $client[0]['address_1'] ?>"/><br />
			
			<label for="address_2">Address 2</label>
			<input type="text" name="address_2" value="<?php echo $client[0]['address_2'] ?>"/><br />
			
			<label for="zip">Zip</label>
			<input type="text" name="zip" value="<?php echo $client[0]['zip'] ?>"/><br />
			
			<label for="city">City</label>
			<input type="text" name="city" value="<?php echo $client[0]['city'] ?>"/><br />
			
			<label for="state">State</label>
			<input type="text" name="state" value="<?php echo $client[0]['state'] ?>" /><br />
			
			<label for="country">Country</label>
			<input type="text" name="country" value="<?php echo $client[0]['country'] ?>" /><br />
			
			<label for="tax_id">Tax Id</label>
			<input type="text" name="tax_id" value="<?php echo $client[0]['company'] ?>"/><br />
			
			<label for="notes">Notes</label>
			<textarea name="notes" id="" cols="30" rows="10"><?php echo $client[0]['notes'] ?></textarea><br />
		
			<input type="submit" name="submit" value="Save Changes" class="button" />
		
		</form>
	</div>
</div>
