<div class="row">
	<div class="large-12 columns">
		<h1 class="text-center">New Invoice</h1>
		<?php 
			$attributes = array('class' => 'invoice-form light-bg', 'id' => 'createForm', 'data-abide'=>'');
			echo form_open('invoices/create', $attributes); 
		?>
		<div id="invoiceCreate" class="invoice-list-wrap">
			<div class="">
				<?php echo validation_errors(); ?>
					<div class="row invoice-info">
						<div class="medium-5 columns">
							<div class="row">
								<div class="large-12 columns">
									<div class="customer-logo">
										<?php if(!empty($settings[0]['logo'])): echo'<img class="company-logo" src="'.base_url().'uploads/logo/'.$this->tank_auth_my->get_user_id()."/".$settings[0]['logo'].'" />'; endif ?>
									</div>
									<h3><?php if(!empty($settings[0]['company_name'])): echo '<h3>'.$settings[0]['company_name'].'<h3/>'; endif ?></h3>	
								</div>
							</div>
						</div>
						<div class="medium-7 columns">
							<div class="row">
								<div class="large-12 columns text-right small-only-text-left">
									<h4 class="caps">Draft Invoice</h4>
								</div>
								<div class="medium-6 columns">
									<div class="">
										<h5 class="caps ruled">
												Billing Information
											</h5>
											<div class="info-block">	
										
												<?php 
													if ($settings) {
														// Map select option values to the list of clients available
														$clientList = array_map(function ($ar) {
															return $ar['company'];
														}, $settings);
														$clientID = array_map(function ($ar) {
															return $ar['id'];
														}, $settings);
														$clientList = array_combine($clientID, $clientList);
														$clientList['add_new_client'] = 'Add New Client';
														echo form_dropdown('client', $clientList, 1);
													} else {
														//echo anchor('clients/create', 'Add a Client', 'class="button round"', 'id="addClient"');
														$clientList = array('choose' => 'Choose...', 'add_new_client' => 'Add New Client');
														$attributes = 'required="" type="number"';
														echo form_dropdown('client', $clientList, 1, $attributes);
													}
												?>
												<small class="error">Client is required.</small>
													<ul id="client_data">
														<li id="contactName"></li>
														<li id="addressOne"></li>
														<li id="addressTwo"></li>
														<li id="cityStateZip"></li>
													</ul>
												
												<script type="text/javascript">
											    $(document).ready(function() {
											    
											    	var client_data = <?php echo json_encode($settings); ?>;
											    	var client_val = $('[name="client"]').val();
											    	var count = 0;
												    
												    function update_address(count, client_val) 
												    {
												    	if($.isNumeric(client_val)) {
												    		$('#contactName').html( client_data[count]['contact'] );
												    		$('#addressOne').html( client_data[count]['address_1'] );
												    		$('#addressTwo').html( client_data[count]['address_2'] );
												    		$('#cityStateZip').html( client_data[count]['city']+' '+client_data[count]['state']+' '+client_data[count]['zip'] );
												    		$('input[name="prefix"]').attr('value', client_data[count]['default_inv_prefix']);
												    	} else {
												    		$('#contactName').html('');
												    		$('#addressOne').html('');
												    		$('#addressTwo').html('');
												    		$('#cityStateZip').html('');
												    	}
												    }
													    
														$('[name="client"]').on( "change", function() {
															var count = $(this)[0].selectedIndex;
															
														  client_val =  $( this ).val();
														  update_address(count, client_val);
														});
														
														update_address(count, client_val);
														
														if (client_data.length) {
															$('input[name="prefix"]').attr('value', client_data[count]['default_inv_prefix']);
														}
														
														
														$('#send-date, #due-date').pickadate({
														    formatSubmit: 'yyyy-mm-dd',
														    hiddenName: true
														});
													});
											  </script>
										</div> 
									</div>
								</div>
								<div class="medium-6 columns">
									<div class="">
										<h5 class="caps ruled">
											Invoice ID
										</h5>
										<div class="info-block">
											<div class="row">
												<div class="small-4 columns"><input type="text" name="prefix" placeholder="Prefix" maxlength="6"/></div>
												<div class="small-8 columns"><input type="text" readonly="readonly" name="invoice_num" placeholder="Invoice Number" /></div>
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
												<input type="text" id="send-date" name="send-date" data-value="<?php echo( date('Y-m-d')); ?>" required />
												<small class="error">Creation date is required.</small>
											</div>	
											</div>	
										</div>
									</div>
									<div class="">
										<h5 class="caps ruled">
											Due Date
										</h5>
										<div class="info-block last">
											<div class="row">
												<div class="small-12 columns">
													<input type="text" id="due-date" name="due-date" value="<?php if(!empty($settings[0]['due']))
													{
														echo( date('d F, Y', strtotime(date('Y-m-d'). ' + '.$settings[0]['due'].' days')));  
													} else {
														echo( date('d F, Y', strtotime(date('Y-m-d'). ' + 15 days')));
													}?>
													 " required />
													<small class="error">Due date is required.</small>
												</div>
											</div>
										</div>	
									</div>
								</div>
							</div>
						</div>
					</div>
					<h3 class="small-only-text-center top-rule">Invoice Items</h3>
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
			</div>
			
			<div class="row actions">
				<div class="large-12 columns text-right small-only-text-center">
					<input type="submit" name="submit" value="Create Invoice" class="button round" />
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