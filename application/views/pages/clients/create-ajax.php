<div class=" clearfix">
	<div class="">
		<?php echo validation_errors(); ?>
		
		
		<?php 
			$attributes = array('id' => 'addClient');			
			echo form_open('clients/create', $attributes) 
		?>
		
			<input type="text" name="company" placeholder="Company" />
			<input type="text" name="contact" placeholder="Contact Name" />
			<input type="text" name="email" placeholder="Email Address" />
			
			<div id="moreFields">
				<input type="text" name="phone" placeholder="Phone Number" />
				<input type="text" name="address_1" placeholder="Address 1" />
				<input type="text" name="address_2" placeholder="Address 2" />
				<input type="text" name="city" placeholder="City"/>
				<input type="text" name="state" placeholder="State"/>
				<input type="text" name="zip" placeholder="zip"/>
				<input type="text" name="country" placeholder="Country"/>
				<input type="text" name="tax_id" placeholder="Tax ID" />
				<input type="text" name="default_inv_prefix" placeholder="Invoice Prefix"/>
			</div>
			<a id="showMoreFields" href="#" class="button round secondary">Add more info</a>
			<input type="submit" name="submit" value="Add Client" class="button round" />
		</form>
	</div>
</div>		
<a class="close-reveal-modal">&#215;</a>
<script type="text/javascript">
	$(document).ready(function() {
			
		$('#showMoreFields').on("click", function() {
			$("#moreFields").show();
		});
	});
</script>