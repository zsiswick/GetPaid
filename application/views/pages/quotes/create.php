<div class="row">
	<div class="large-12 columns">
		<h1 class="text-center">New Quote</h1>
		<?php 
			$attributes = array('class' => 'invoice-form light-bg', 'id' => 'createForm', 'data-abide'=>'');
			echo form_open('quotes/create', $attributes); 
		?>
		<div id="quoteCreate" class="invoice-list-wrap">
			<div class="">
				<?php echo validation_errors(); ?>
					<div class="row">
						<div class="large-12 columns text-right small-only-text-left">
							<h4 class="caps">Draft Quote</h4>
						</div>
					</div>
					<div class="row invoice-info">
						<div class="medium-5 columns">
							<div class="row">
								<div class="large-12 columns">
									<div class="customer-logo">
										<?php if(!empty($settings[0]['logo'])): echo'<img class="company-logo" src="'.base_url().'uploads/logo/'.$this->tank_auth_my->get_user_id()."/".$settings[0]['logo'].'" />'; endif ?>
									</div>
									<?php if(!empty($settings[0]['company_name'])): echo '<h3>'.$settings[0]['company_name'].'<h3/>'; endif ?>
								</div>
							</div>
						</div>
						<div class="medium-7 columns">
							<?php $this->load->view('templates/billing-info'); ?>
							<div class="row">
								<div class="columns small-12">
									<h5 class="ruled caps">Description</h5>
									<div class="info-block">
										<textarea name="quote_description" id="" cols="30" rows="2"></textarea>
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
							<h3>Total: <span id="invoiceTotal">$0.00</span></h3>
						</div>
					</div>
			</div>
			
			<div class="row actions">
				<div class="large-12 columns text-right small-only-text-center">
					<input type="submit" name="submit" value="Create Quote" class="button round" />
				</div>
			</div>
		</div>
		
		</form>
	</div>
</div>

<div class="row">
	<div class="small-12 medium-12 large-4 columns large-centered">
		<div id="clientModal" class="reveal-modal small" data-reveal>
			<div id="form-errors" class="light-bg"></div>
			<div id="loadingImg"><img src="<?php echo base_url();?>assets/images/ajax-loader.gif" alt="loading" /></div>
			<div id="form-wrap"></div>
		</div>
	</div>
</div>