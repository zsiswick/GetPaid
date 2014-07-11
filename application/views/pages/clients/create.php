<div class="row">
	<div class="large-6 columns large-centered">
		<h1 class="text-center">Add a Client</h1>
	</div>
</div>
<div class="row">
	<div class="large-6 columns large-centered">
		<div class="invoice-list-wrap clearfix">
			<div class="invoice-list-inner-wrap">
				<?php echo validation_errors(); ?>
				
				<?php echo form_open('clients/create') ?>
				
					<label for="company">Company</label>
					<input type="text" name="company" /><br />
					   
					<label for="contact">Contact Name</label>
					<input type="text" name="contact" /><br />
					
					<label for="email">Email</label>
					<input type="text" name="email" /><br />
					
					<label for="address_1">Address 1</label>
					<input type="text" name="address_1" /><br />
					
					<label for="address_2">Address 2</label>
					<input type="text" name="address_2" /><br />
					
					<label for="city">City</label>
					<input type="text" name="city" /><br />
					
					<label for="state">State</label>
					<input type="text" name="state" /><br />
					
					<label for="zip">Zip</label>
					<input type="text" name="zip" /><br />
					
					<label for="country">Country</label>
					<input type="text" name="country" /><br />
					
					<label for="tax_id">Tax Id</label>
					<input type="text" name="tax_id" /><br />
					
					<label for="notes">Notes</label>
					<textarea name="notes" id="" cols="30" rows="10"></textarea><br />
				
					<input type="submit" name="submit" value="Add Client" class="button round" />
				
				</form>
			</div>
		</div>		
	</div>
</div>
