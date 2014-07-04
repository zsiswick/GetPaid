<div class="row">
	<div class="large-12 columns">
		<h2>New Invoice</h2>
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
				<table id="invoiceCreate" class="invoice-create">
				<thead>
					<tr>
						<th>Qty</th>
						<th>Description</th>
						<th>Price</th>
						<th>Total</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><input class="qty sum" type="text" name="qty[]" /></td>
						<td><textarea name="description[]" cols="30" rows="3"></textarea></td>
						<td><input class="unitCost sum" type="text" name="unit_cost[]" /></td>
						<td class="totalSum">$0.00</td>
						<td><a class="delete-row">Remove</a></td>
					</tr>
				</tbody>
				</table>
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