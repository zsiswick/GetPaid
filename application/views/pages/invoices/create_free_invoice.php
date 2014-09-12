<h1 class="text-center">Create an Invoice</h1>
<p class="large-p text-center light">Want to send quotes by email, mark them as accepted or declined, and turn them into invoices?<br/> Check out our online <a href="<?php echo(base_url()); ?>index.php/features">quoting features</a> or <a href="<?php echo(base_url()); ?>index.php/auth/register">register for a free account</a>.</p>
<?php 
	$attributes = array('id' => 'createForm', 'data-abide'=>'');
	echo form_open('welcome/pdf', $attributes); 
?>
<div class="row">
	<div class="large-10 columns">
		<div id="invoiceCreate" class="invoice-list-wrap invoice-form light-bg">
				<?php echo validation_errors(); ?>
					
					<div class="row invoice-info">
						<div class="medium-9 columns">
							<div class="row">
								<div class="medium-6 columns">
									<h5 class="caps ruled">Your Information</h5>
									<div class="info-block">
										<input type="text" name="name" placeholder="Company Name" required />
										<small class="error">Company name is required</small>
										<textarea name="address" id="" cols="30" rows="2" placeholder="Address"></textarea>
									</div>
										
								</div>
								<div class="medium-6 columns">
										<h5 class="caps ruled">
												Billing Information
											</h5>
											<div class="info-block">	
												<input type="text" name="client_name" placeholder="Company or Contact Name" required />
												<small class="error">Company or contact name is required</small>
												<textarea name="client_address" id="" cols="30" rows="2" placeholder="Address"></textarea>
											</div> 
								</div>
									<div class="columns small-8 end">
										<h5 class="ruled caps">Description</h5>
										<div class="info-block">
											<textarea name="inv_description" id="" cols="30" rows="2"></textarea>
										</div>
									</div>
							</div>
							
						</div>
						<div class="medium-3 columns">
							<div class="row">
								
								
								<div class="medium-12 columns">
									<div class="">
										<h5 class="caps ruled">
											Invoice ID
										</h5>
										<div class="info-block">
											<div class="row">
												<div class="small-12 columns">
													<input type="text" name="invoice_num" placeholder="INV-1234" />
													<small class="error">Invoice ID is required</small>
												</div>
											</div>
										</div>	
									</div>
									
									<div class="">
										<h5 class="caps ruled">
											Creation Date
										</h5>
										<div class="info-block">
											<div class="row">
											<div class="small-12 columns">
												<input type="text" id="send_date" name="send_date" data-value="<?php echo( date('Y-m-d')); ?>" required />
												<small class="error">Creation date is required.</small>
											</div>	
											</div>	
										</div>
									</div>
									<div class="">
										<h5 class="caps ruled">
											Due Date
										</h5>
										<div class="info-block">
											<div class="row">
												<div class="small-12 columns">
													<input type="text" id="due_date" name="due_date" value="<?php echo( date('d F, Y', strtotime(date('Y-m-d'). ' + 15 days'))) ?>" required />
													<small class="error">Due date is required.</small>
												</div>
											</div>
										</div>	
									</div>
								</div>
							</div>
							
						</div>
					</div>
					<div class="list_header">
						<div class="row">
							<div class="small-12 medium-2 columns qty">
								Qty
							</div>
							<div class="small-12 medium-5 columns description">
								Description
							</div>
							<div class="small-12 medium-2 columns price">
								Price
							</div>
							<div class="small-12 medium-2 large-only-text-right columns totalSum">
								Total
							</div>
							<div class="small-12 medium-1 large-only-text-right columns delete">
							</div>
						</div>
					</div>
					
					<div class="edit-list-container">
						<div class="tabbed list no-rules">
							<div class="row">
								<div class="qty small-12 medium-2 columns">
									<input class="qty sum" type="text" name="qty[]" value="<?php echo set_value('qty[]'); ?>" placeholder="1.5" required />
									<small class="error">Quantity is required.</small>
								</div>
								<div class="description small-12 medium-5 columns">
									<input type="text" name="description[]" value="<?php echo set_value('description[]'); ?>" placeholder="Client Meeting" />
								</div>
								<div class="price small-12 medium-2 columns">
									<input class="unitCost sum" type="text" name="unit_cost[]" value="<?php echo set_value('unit_cost[]'); ?>" placeholder="65" required />
									<small class="error">Price is required.</small>
								</div>
								<div class="totalSum small-12 medium-2 large-only-text-right columns" >
									$0.00
								</div>
								<div class="delete small-12 medium-1 columns large-only-text-right small-text-center">
									<a class="delete-row button small round">x</a>
								</div>
								<div class="small-12 columns"><hr /></div>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="large-12 columns text-left small-only-text-center">
							<a id="addItems" class="button small round">Add Another Item</a>
						</div>
					</div>
					<hr />
					<div class="row">
						<div class="large-12 columns text-right small-only-text-center">
							<h3>Total Due: <span id="invoiceTotal">$0.00</span></h3>
						</div>
					</div>
					<div class="row">
						<div class="columns small-12">
							<div class="info-block">
								<textarea name="terms_conditions" id="" cols="30" rows="2" placeholder="Terms and Conditions"></textarea>
							</div>
						</div>
					</div>
		</div>
	</div>
	<div class="large-2 columns">
		<div class="sidebar">
			<input type="submit" name="submit" value="Download" class="button round light"/>
			<a href="" class="button round light" data-reveal-id="sendModal">Print</a>
		</div>	
	</div>
</div>
</form>
<div class="row">
	<div class="small-12 medium-12 large-4 columns large-centered">
		<div id="sendModal" class="reveal-modal small light-bg" data-reveal>
			<div id="form-errors"></div>
			<div id="loadingImg"><img src="<?php echo base_url();?>assets/images/ajax-loader.gif" alt="loading" /></div>
			<div id="form-wrap">
				<?php echo($register_form); ?>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
  $(document).ready(function() {
  	$('#send_date, #due_date').pickadate({
		    formatSubmit: 'yyyy-mm-dd',
		    hiddenName: true
		});
	});
</script>