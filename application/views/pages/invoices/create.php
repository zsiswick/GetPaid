<div class="row">
	<div class="large-12 columns">
		<h1 class="text-center">New Invoice</h1>
		<?php 
			$attributes = array('class' => 'invoice-form', 'id' => 'createForm');
			echo form_open('invoices/create', $attributes); 
		?>
		<div id="invoiceCreate" class="invoice-list-wrap">
			<div class="invoice-list-inner-wrap">
				<?php echo validation_errors(); ?>
					<div class="row">
						<div class="medium-5 columns">
							<div class="row">
								<div class="large-12 columns">
									<div class="customer-logo">
										<svg height="125" width="125" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
											 viewBox="0 0 125 125" enable-background="new 0 0 125 125" xml:space="preserve">
										<path fill-rule="evenodd" clip-rule="evenodd" fill="#4B011F" d="M57.4,59.5c0.4,0.6,0.6,1.5,0.6,2.7v0.5c0,1.2-0.2,2.1-0.6,2.7
											s-1,0.9-1.8,0.9c-0.4,0-0.7-0.1-1.1-0.2c-0.3-0.2-0.6-0.4-0.8-0.7s-0.4-0.7-0.5-1.1c-0.1-0.5-0.2-1-0.2-1.6v-0.5
											c0-1.2,0.2-2.1,0.6-2.7c0.4-0.6,1-0.9,1.8-0.9C56.4,58.6,57,58.9,57.4,59.5z M77.5,58.6c-0.8,0-1.4,0.3-1.8,0.9
											c-0.4,0.6-0.6,1.5-0.6,2.7v0.5c0,0.6,0.1,1.1,0.2,1.6c0.1,0.5,0.3,0.8,0.5,1.1s0.5,0.5,0.8,0.7c0.3,0.2,0.7,0.2,1.1,0.2
											c0.8,0,1.4-0.3,1.8-0.9S80,64,80,62.8v-0.5c0-1.2-0.2-2.1-0.6-2.7C78.9,58.9,78.3,58.6,77.5,58.6z M125,62.5C125,97,97,125,62.5,125
											C28,125,0,97,0,62.5C0,28,28,0,62.5,0C97,0,125,28,125,62.5z M50.3,66.3h-5v-9.5h-2.3v11.4h7.3V66.3z M60.4,62.3
											c0-0.9-0.1-1.6-0.4-2.3c-0.2-0.7-0.6-1.3-1-1.8c-0.4-0.5-0.9-0.9-1.5-1.1s-1.2-0.4-2-0.4c-0.7,0-1.4,0.1-2,0.4s-1.1,0.6-1.5,1.1
											c-0.4,0.5-0.8,1.1-1,1.8c-0.2,0.7-0.4,1.5-0.4,2.3v0.5c0,0.9,0.1,1.6,0.4,2.3c0.2,0.7,0.6,1.3,1,1.8s0.9,0.8,1.5,1.1s1.2,0.4,2,0.4
											c0.7,0,1.4-0.1,2-0.4s1.1-0.6,1.5-1.1c0.4-0.5,0.8-1.1,1-1.8s0.4-1.5,0.4-2.3V62.3z M64.2,62.8v-0.7c0-1.2,0.2-2.1,0.6-2.7
											c0.4-0.6,1-0.9,1.8-0.9c0.3,0,0.6,0,0.9,0.1c0.3,0.1,0.5,0.2,0.6,0.4s0.3,0.4,0.4,0.6c0.1,0.2,0.2,0.5,0.2,0.8h2.3
											c-0.1-0.6-0.2-1.1-0.4-1.5s-0.5-0.9-0.8-1.2c-0.4-0.3-0.8-0.6-1.4-0.8s-1.2-0.3-1.9-0.3c-0.7,0-1.4,0.1-2,0.4
											c-0.6,0.2-1.1,0.6-1.5,1.1s-0.7,1-1,1.7s-0.3,1.5-0.3,2.3v0.7c0,0.9,0.1,1.7,0.4,2.3c0.2,0.7,0.6,1.3,1,1.7c0.4,0.5,1,0.8,1.6,1.1
											c0.6,0.2,1.3,0.4,2,0.4c0.6,0,1.2-0.1,1.7-0.2c0.5-0.1,0.9-0.2,1.3-0.4c0.4-0.2,0.6-0.3,0.9-0.5s0.4-0.4,0.6-0.5v-4.5h-4.5v1.7h2.1
											v2c-0.1,0.1-0.1,0.1-0.2,0.2c-0.1,0.1-0.2,0.1-0.4,0.2s-0.3,0.1-0.5,0.1c-0.2,0-0.5,0.1-0.7,0.1c-0.9,0-1.5-0.3-2-0.9
											S64.2,64,64.2,62.8z M82.4,62.3c0-0.9-0.1-1.6-0.4-2.3c-0.2-0.7-0.6-1.3-1-1.8c-0.4-0.5-0.9-0.9-1.5-1.1s-1.2-0.4-2-0.4
											c-0.7,0-1.4,0.1-2,0.4s-1.1,0.6-1.5,1.1c-0.4,0.5-0.8,1.1-1,1.8c-0.2,0.7-0.4,1.5-0.4,2.3v0.5c0,0.9,0.1,1.6,0.4,2.3
											c0.2,0.7,0.6,1.3,1,1.8s0.9,0.8,1.5,1.1s1.2,0.4,2,0.4c0.7,0,1.4-0.1,2-0.4s1.1-0.6,1.5-1.1c0.4-0.5,0.8-1.1,1-1.8s0.4-1.5,0.4-2.3
											V62.3z"/>
										</svg>
									</div>
									<h3>Zachary Siswick (DBA - Chromaloop)</h3>	
								</div>
							</div>
						</div>
						<div class="medium-7 columns">
							<div class="row">
								<div class="large-12 columns text-right">
									<h4 class="caps">Draft Invoice</h4>
								</div>
								<div class="medium-6 columns">
									<div class="ruled">
										<h5 class="caps">
												Billing Information
											</h5>	
										
											<?php 
												if ($clients) {
													// Map select option values to the list of clients available
													$clientList = array_map(function ($ar) {
														return $ar['company'];
													}, $clients);
													$clientID = array_map(function ($ar) {
														return $ar['id'];
													}, $clients);
													$clientList = array_combine($clientID, $clientList);
													$clientList['add_new_client'] = 'Add New Client';
													echo form_dropdown('client', $clientList, 1);
												} else {
													echo anchor('clients/create', 'Add a Client', 'class="button round"', 'id="addClient"');
												}
											?>
												<ul id="clientAddress">
													<li id="contactName"></li>
													<li id="addressOne"></li>
													<li id="addressTwo"></li>
													<li id="cityStateZip"></li>
												</ul>
											
											<script type="text/javascript">
										    $(document).ready(function() {
										    
										    	var clientAddress = <?php echo json_encode($clients); ?>;
										    	var client_val = $('[name="client"]').val();
										    	var count = 0;
											    
											    function update_address(count, client_val) 
											    {
											    	if($.isNumeric(client_val)) {
											    		$('#contactName').html( clientAddress[count]['contact'] );
											    		$('#addressOne').html( clientAddress[count]['address_1'] );
											    		$('#addressTwo').html( clientAddress[count]['address_2'] );
											    		$('#cityStateZip').html( clientAddress[count]['city']+' '+clientAddress[count]['state']+' '+clientAddress[count]['zip'] );
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
												
													
										    			
										    });
										    
											    
											</script>
									</div>
								</div>
								<div class="medium-6 columns">
									<div class="ruled">
										<h5 class="caps">
											Invoice ID
										</h5>
										<div class="row">
											<div class="small-4 columns"><input type="text" name="prefix" placeholder="Prefix"/></div>
											<div class="small-8 columns"><input type="text" readonly="readonly" name="invoice_num" placeholder="123"/></div>
										</div>
									</div>
									
									<div class="ruled sans-top">
										<h5 class="caps">
											Send Date
										</h5>
										<div class="row">
											<div class="small-3 columns">
												<?= $dob_dropdown_day ?>
											</div>
											<div class="small-5 columns">
												<?= $dob_dropdown_month ?>
											</div>
											<div class="small-4 columns">
												<?= $dob_dropdown_year ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="list_header row">
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
					
					<div class="edit-list-container">
						<div class="row tabbed list no-rules">
							<div class="qty small-12 medium-2 columns">
								<input class="qty sum" type="text" name="qty[]" />
							</div>
							<div class="description small-12 medium-5 columns">
								<input type="text" name="description[]" />
							</div>
							<div class="price small-12 medium-2 columns">
								<input class="unitCost sum" type="text" name="unit_cost[]" />
							</div>
							<div class="totalSum small-12 medium-2 large-only-text-right columns" >
								$0.00
							</div>
							<div class="delete small-12 medium-1 columns large-only-text-right small-text-center">
								<a class="delete-row button small round">x</a>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="large-12 columns text-left small-only-text-center">
							<a id="addItems" class="button small round">Add Another Item</a>
						</div>
					</div>
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
			<div id="form-errors" class="alert-box round"></div>
			<div id="form-wrap"></div>
		</div>
	</div>
</div>