<?php
	$uid = $this->tank_auth_my->get_user_id();
	//print("<pre>".print_r($settings,true)."</pre>");
?>
<div class="row">
	<div class="large-6 columns large-centered">
		<h1 class="text-center">Settings</h1>
	</div>
</div>
<div class="row">
	<div class="large-8 columns large-centered">
		<div class="form-wrap invoice-form light-bg">
			<?php echo validation_errors(); ?>
			<?php 
				if (isset($upload_error)) 
				{
					echo($upload_error);
				}
			?>
			<?php 
				$hidden = array('uid' => $uid);
				$attributes = array('data-abide'=>'');
				echo form_open_multipart('settings', $attributes, $hidden); 
			?>
			<ul class="tabs" data-tab role="tablist">
			  <li class="tab-title active" role="presentational" ><a href="#panel2-1" role="tab" tabindex="0" aria-selected="true" controls="panel2-1">Basic Info</a></li>
			  <li class="tab-title" role="presentational" ><a href="#panel2-2" role="tab" tabindex="0"aria-selected="false" controls="panel2-2">Payment Settings</a></li>
			</ul>
			<div class="tabs-content">
			  <section role="tabpanel" aria-hidden="false" class="content active" id="panel2-1">
			    
			    <div class="row">
			    	<div class="small-12 columns">
			    		<label for="companyName">Company Name</label>
			    		<input type="text" name="company_name" value="<?php echo($settings[0]['company_name']) ?>" required />
			    		<small class="error">Company Name is required.</small>
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
			    		<input type="email" name="email" value="<?php echo $settings[0]['email'] ?>" required pattern="email" />
			    		<small class="error">Valid email is required.</small>
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
			    		<input type="text" name="state" value="<?php echo $settings[0]['state'] ?>" maxlength="2" />
			    	</div>
			    	<div class="small-3 columns">
			    		<label for="zip">Zip</label>
			    		<input type="text" name="zip" value="<?php echo $settings[0]['zip'] ?>"/>
			    	</div>
			    </div>
			    
			    <label for="country">Country</label>
			    <input type="text" name="country" value="<?php echo $settings[0]['country'] ?>" />
			    
			  </section>
			  <section role="tabpanel" aria-hidden="true" class="content" id="panel2-2">
			    
			    <div class="row">
			    	<div class="small-12 columns">
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
			    	<div class="columns medium-6 end">
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
			    	</div>
			    </div>
			    
			    
			    <div class="row">
			    	<div class="columns small-12">
			    		<label for="notes">Payment Terms</label>
			    		<textarea placeholder="Please remit full payment 15 days from receipt of invoice. Make check payable to John Smith" name="notes" cols="30" rows="10"><?php echo($settings[0]['notes']) ?></textarea>
			    	</div>
			    </div>   
			    
			    <div class="row">
			    	<div class="columns small-12 end">
			    		<label data-tooltip title="Get paid quicker! Once you've linked Stripe with your Ruby Invoice account, your clients will be able to pay invoices directly.">Enable Stripe Payments</label>
			    		<div class="switch round">
			    		  <input id="enable_payments" name="enable_payments" type="checkbox" <?php if( $settings[0]['enable_payments'] == 1) {?> checked="checked" <?php } ?> value="1"/>
			    		  <label for="enable_payments"></label>
			    		</div>
			    	</div>
			    </div>
			    
			    
			    
			    <div id="paypal_settings" class="row">
			    	<div class="columns medium-6 end">
			    		<label for="stripe_connect">Connect to Stripe</label>
			    		
			    		<?php 
			    			if ( $settings[0]['stripe_cust_token'] == false ) {
			    				
			    				echo anchor('https://connect.stripe.com/oauth/authorize?response_type=code&client_id=ca_4eR11ZVjVsJOIKtOVnqhMRK4HSSX6ONl&scope=read_write&stripe_user[email]='.$settings[0]['email'].'&stripe_user[business_name]='.$settings[0]['company_name'].'&stripe_user[street_address]='.$settings[0]['address_1'].'&stripe_user[city]='.$settings[0]['city'].'&stripe_user[state]='.$settings[0]['state'].'&stripe_user[zip]='.$settings[0]['zip'], 'Connect Account', 'title="Connect Account" class="button small round"');
			    				
			    			} else {
			    				
			    				echo anchor('settings/disconnect_stripe', 'Disconnect Account', 'title="Disconnect Account" class="button small round"');
			    				
			    			}
			    		?>
			    	</div>
			    	<div class="columns small-12">
			    		<input type="checkbox" id="payment_notification" name="payment_notification" <?php if( $settings[0]['payment_notification'] == 1) {?> checked="checked" <?php } ?> value="1" /><label for="payment_notification">Send notification email upon payment</label>
			    	</div>
			    </div>
			    
			  </section>
			</div>
			
					<div class="row">
						<div class="large-12 columns text-right small-only-text-center">
							<input type="submit" name="submit" value="Save Changes" class="button round" />
						</div>
					</div>		
				
				</form>
				
		</div>		
	</div>
</div>
