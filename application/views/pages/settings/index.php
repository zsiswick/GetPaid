<?php
	$uid = $this->tank_auth_my->get_user_id();
?>
<div class="row">
	<div class="large-6 columns large-centered">
		<h1 class="text-center">Settings</h1>
	</div>
</div>
<div class="row">
	<div class="large-8 columns large-centered">
		<div class="form-wrap invoice-form light-bg">
			<div class="">
				<?php 
					if (isset($upload_error)) 
					{
						echo($upload_error);
					}
				?>
				<?php echo validation_errors(); ?>
				<?php 
					$attributes = array('data-abide'=>'');
					echo form_open_multipart('settings', $attributes); 
				?>
					
					
					<div class="row">
						<div class="small-6 columns">
							<label for="companyName">Company Name</label>
							<input type="text" name="company_name" value="<?php echo($settings[0]['company_name']) ?>" required />
							<small class="error">Company Name is required.</small>
						</div>
						<div class="small-6 columns">
							<?php 
								if (!empty($filename)) 
								{
									echo('<img src="'.base_url().'uploads/logo/'.$uid."/".$filename.'" class="logo thumb" />');
									echo('<a href="'.base_url().'index.php/settings/remove_logo/'.$uid.'">Remove</a>');
								}
							?>
							
							<label for="userfile">Upload a Logo</label>
							<input type="file" name="userfile" size="20" />
						</div>
					</div>
					
					
					
					
					<div class="row">
						<div class="small-6 columns">
							<label for="fullname">Full Name</label>
							<input type="text" name="full_name" value="<?php echo($settings[0]['full_name']) ?>" required />
							<small class="error">Full Name is required.</small>
						</div>
						<div class="small-6 columns">
							<label for="email">Email</label>
							<input type="email" name="email" value="<?php echo $settings[0]['email'] ?>" required />
							<small class="error">Email is required.</small>
						</div>
					</div>
					
					<div class="row">
						<div class="small-6 columns">
							<label for="address_1">Address 1</label>
							<input type="text" name="address_1" value="<?php echo $settings[0]['address_1'] ?>"/>
						</div>
						<div class="small-6 columns">
							<label for="address_2">Address 2</label>
							<input type="text" name="address_2" value="<?php echo $settings[0]['address_2'] ?>"/>
						</div>
					</div>
					
					<div class="row">
						<div class="small-6 columns">
							<label for="city">City</label>
							<input type="text" name="city" value="<?php echo $settings[0]['city'] ?>"/>
						</div>
						<div class="small-3 columns">
							<label for="state">State</label>
							<input type="text" name="state" value="<?php echo $settings[0]['state'] ?>" />
						</div>
						<div class="small-3 columns">
							<label for="zip">Zip</label>
							<input type="text" name="zip" value="<?php echo $settings[0]['zip'] ?>"/>
						</div>
					</div>
					
					<label for="country">Country</label>
					<input type="text" name="country" value="<?php echo $settings[0]['country'] ?>" />
					
					<input type="hidden" name="sid" value="" />
					<label for="due">Invoice Due In</label>
					
					
					<?php
						$options = array(
				                  '15'  => '15 Days',
				                  '30'    => '30 Days',
				                  '45'   => '45 Days',
				                );
						
						
						echo form_dropdown('due', $options, $settings[0]['due']);
					?>
					
					<br />
					   
					<label for="notes">Payment Terms</label>
					<textarea placeholder="Please remit full payment 15 days from receipt of invoice. Make check payable to John Smith" name="notes" cols="30" rows="10"><?php echo($settings[0]['notes']) ?></textarea><br />
					
					<div class="row">
						<div class="large-12 columns text-right small-only-text-center">
							<input type="submit" name="submit" value="Save Changes" class="button round" />
						</div>
					</div>		
				
				</form>
			</div>
		</div>		
	</div>
</div>
