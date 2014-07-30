<div class="invoice-list-wrap clearfix">
	<div class="invoice-list-inner-wrap">
		<?php echo validation_errors(); ?>
		
		
		<?php 
			$attributes = array('id' => 'addClient');			
			echo form_open('clients/create', $attributes) 
		?>
		
			<label for="company">Company</label>
			<input type="text" name="company" /><br />
			   
			<label for="contact">Contact Name</label>
			<input type="text" name="contact" /><br />
			
			<label for="email">Email</label>
			<input type="text" name="email" /><br />
			
					<input type="submit" name="submit" value="Add Client" class="button round" />
		</form>
	</div>
</div>		
<a class="close-reveal-modal">&#215;</a>
