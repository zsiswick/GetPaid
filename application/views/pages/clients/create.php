<div class="row">
	<div class="large-6 columns large-centered">
		<h1 class="text-center">Add a Client</h1>
	</div>
</div>
<div class="row">
	<div class="large-8 columns large-centered">
		<div class="invoice-list-wrap invoice-form clearfix">
			<div class="invoice-list-inner-wrap">
				<?php echo validation_errors(); ?>
				
				<?php echo form_open('clients/create') ?>
				
					<div class="row">
						<div class="small-6 columns">
							<label for="company">Company</label>
							<input type="text" name="company" />	
						</div>
						<div class="small-6 columns">
							<label for="contact">Contact Name</label>
							<input type="text" name="contact" />	
						</div>
					</div>
					
					<div class="row">
						<div class="small-6 columns">
							<label for="email">Email</label>
							<input type="text" name="email" />	
						</div>
						<div class="small-6 columns">
							<label for="phone">Phone</label>
							<input type="text" name="phone" />	
						</div>
					</div>   
					
					<div class="row">
						<div class="small-6 columns">
							<label for="address_1">Address 1</label>
							<input type="text" name="address_1" />	
						</div>
						<div class="small-6 columns">
							<label for="address_2">Address 2</label>
							<input type="text" name="address_2" />
						</div>
					</div>
					
					<div class="row">
						<div class="small-6 columns">
							<label for="city">City</label>
							<input type="text" name="city" />	
						</div>
						<div class="small-3 columns">
							<label for="state">State</label>
							<input type="text" name="state" />
						</div>
						<div class="small-3 columns">
							<label for="zip">Zip</label>
							<input type="text" name="zip" />
						</div>
					</div>
					
					<label for="country">Country</label>
					<input type="text" name="country" />
					
					<div class="row">
						<div  class="small-7 columns">
							<label for="tax_id">Tax Id</label>
							<input type="text" name="tax_id"/>
						</div>
						<div  class="small-5 columns">
							<label for="default_inv_prefix">Invoice Prefix</label>
							<input type="text" name="default_inv_prefix" maxlength="6"/>
						</div>
					</div>
					
					
					
					
					<label for="notes">Notes</label>
					<textarea name="notes" id="" cols="30" rows="10"></textarea><br />
					
					<div class="row">
						<div class="large-12 columns text-right small-only-text-center">
							<input type="submit" name="submit" value="Add Client" class="button round" />
						</div>
					</div>	
				</form>
			</div>
		</div>		
	</div>
</div>
