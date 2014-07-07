<div class="row">
	<div class="large-12 columns">
		<h1 class="text-center">New Invoice</h1>
		<?php echo validation_errors(); ?>
		
		<?php 
			$attributes = array('class' => 'invoice-form', 'id' => 'createForm');
			echo form_open('invoices/create', $attributes); 
		?>
		
			<div class="panel">
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
				
				<label>Date:</label>
				<?= $dob_dropdown_day ?>
				<?= $dob_dropdown_month ?>
				<?= $dob_dropdown_year ?>	
			</div>
			
			<div class="table-container">
				
				<ul class="list_header clearfix">
					<li class="qty">Qty</li>
					<li class="description">Description</li>
					<li class="price">Price</li>
					<li class="totalSum">Total</li>
					<li class="delete">Remove</li>
				</ul>
				<div class="edit-list-container">
					<ul id="invoiceCreate" class="invoice-create invoice-list clearfix">
						<li class="qty"><input class="qty sum" type="text" name="qty[]" /></li>
						<li class="description"><input type="text" name="description[]" /></li>
						<li class="price"><input class="unitCost sum" type="text" name="unit_cost[]" /></li>
						<li class="totalSum">$0.00</li>
						<li class="delete"><a class="delete-row">Remove</a></li>
					</ul>
				</div>
				<div class="row">
					<div class="large-12 columns text-left">
						<a id="addItems" class="button small secondary">Add more items</a>
					</div>
				</div>
				<div class="row">
					<div class="large-12 columns text-right">
						<h3>Total Due: <span id="invoiceTotal">$0.00</span></h3>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="large-12 columns text-right">
					<input type="submit" name="submit" value="Create invoice" class="button" />
				</div>
			</div>
		</form>
	</div>
</div>