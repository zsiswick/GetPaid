<div class="row">
	<div class="large-6 columns large-centered">
		<h1 class="text-center">Settings</h1>
	</div>
</div>
<div class="row">
	<div class="large-6 columns large-centered">
		<div class="invoice-list-wrap clearfix">
			<div class="invoice-list-inner-wrap">
				<?php echo validation_errors(); ?>
				<?php echo form_open('settings/') ?>
					<label for="companyName">Company Name</label>
					<input type="text" name="companyName" value="<?php echo($settings[0]['company_name']) ?>" />
					<label for="fullname">Full Name</label>
					<input type="text" name="fullname" value="<?php echo($settings[0]['full_name']) ?>" />
					<input type="hidden" name="sid" value="" />
					<label for="due">Invoice Due</label>
					<select name="due">
						<option value="15">15 Days</option>
						<option value="30">30 Days</option>
						<option value="45">45 Days</option>
					</select><br />
					   
					<label for="notes">Payment Terms</label>
					<textarea placeholder="Please remit full payment 15 days from receipt of invoice. Make check payable to John Smith" name="notes" cols="30" rows="10"><?php echo($settings[0]['notes']) ?></textarea><br />
					
					<div class="row">
						<div class="large-6 columns small-only-text-center">
							<input type="submit" name="submit" value="Save Changes" class="button round" />
						</div>
					</div>		
				
				</form>
			</div>
		</div>		
	</div>
</div>
