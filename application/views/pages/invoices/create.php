<div class="row">
	<div class="large-12 columns">
		<h1 class="text-center">New Invoice</h1>
		<?php 
			$attributes = array('class' => 'invoice-form', 'id' => 'createForm');
			echo form_open('invoices/create', $attributes); 
		?>
		<div class="invoice-list-wrap">
			<div class="invoice-list-inner-wrap">
				<?php echo validation_errors(); ?>
					<div class="row">
						<div class="medium-4 large-4 columns">
							<div class="row">
								<div class="large-12 columns">
									<label for="client">Client</label>
									<?php 
										if ($clients) {
											// Map select option values to the list of clients available
											$clientList = array_map(function ($ar) {
												return $ar['company'];
											}, $clients);
											$clientList = array_combine($clientList, $clientList);
											echo form_dropdown('client', $clientList, 0);
										} else {
											echo anchor('clients/create', 'Add a Client', 'class="button round"', 'id="addClient"');
										}
									?>
								</div>
							</div>
						</div>
						<div class="medium-8 large-8 columns">
							<div class="row">
								<div class="large-12 columns">
									<label>Date:</label>
								</div>	
								<div class="small-3 large-3 columns">
									<?= $dob_dropdown_day ?>
								</div>
								<div class="small-5 large-5 columns">
									<?= $dob_dropdown_month ?>
								</div>
								<div class="small-4 large-4 columns">
									<?= $dob_dropdown_year ?>
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
					
					<div id="invoiceCreate" class="edit-list-container">
						<div class="row invoice list no-rules">
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
								<a class="delete-row"><i class="step fi-x size-21"></i></a>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="large-12 columns text-left">
							<a id="addItems" class="button small secondary round">Add Another Item</a>
						</div>
					</div>
					<hr />
					<div class="row">
						<div class="large-12 columns text-right small-only-text-center">
							<h3>Total Due: <span id="invoiceTotal">$0.00</span></h3>
						</div>
					</div>
			</div>
			
			<div class="row">
				<div class="large-12 columns text-right small-only-text-center">
					<input type="submit" name="submit" value="Create Invoice" class="button round" />
				</div>
			</div>
				
		</div>
		
		</form>
	</div>
</div>