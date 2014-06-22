<div class="row">
	<div class="large-12 columns">
		<h2>Edit Invoice #<?php echo($item[0]['iid']);?></h2>
		
		<div id="form-errors" class="alert-box alert round"></div>
		
		<?php $this->load->helper('dob'); ?>
		<?php $hidden = array('iid' => $item[0]['iid']);
		echo form_open('invoices/edit/'.$item[0]['iid'], '', $hidden) ?>
		<?php $sumTotal = 0 ?>
		
			
			<div class="panel">
				<label for="client">Client</label>
				<p><?php echo $item[0]['client']; ?></p>
				
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
					<?php foreach ($item['items'] as $invoice_item): ?>
						<?php 
							$number = $invoice_item['quantity'] * $invoice_item['unit_cost']; 
							$sumTotal = $sumTotal + $number;
						?>
						<tr>
							<td><input type="hidden" name="item_id[]" value="<?php echo $invoice_item['id'] ?>" /><input type="text" class="qty sum" name="qty[]" value="<?php echo $invoice_item['quantity'] ?>" /></td>
							<td><textarea name="description[]" cols="30" rows="3"><?php echo $invoice_item['description'] ?></textarea></td>
							<td><input type="text" class="unitCost sum" name="unit_cost[]" value="<?php echo $invoice_item['unit_cost'] ?>" /></td>
							<td data-totalsum="<?php echo number_format((float)$number, 2, '.', ''); ?>" class="totalSum">
								$<?php 
									echo number_format((float)$number, 2, '.', ','); 
								?>
							</td>
							<td><?php echo anchor('invoices/delete_row?id='.$invoice_item["id"].'&common_id='.$invoice_item["common_id"], 'Remove', 'id="'.$invoice_item["id"].'"'); ?></td>
						</tr>
					<?php endforeach ?>	
				</tbody>
				</table>
				<div class="row">
					<div class="large-12 columns text-left">
						<a id="addItems" class="button small secondary">Add more items</a>
					</div>
				</div>
				<div class="row">
					<div class="large-12 columns text-right">
						<h3>Total Due: <span id="invoiceTotal">$<?php echo number_format((float)$sumTotal, 2, '.', ',');?></span></h3>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="large-12 columns text-right">
					<?php echo anchor('invoices/delete_invoice/'.$item[0]['iid'], 'Delete Invoice', 'class="button secondary"', 'id="'.$item[0]['iid'].'"'); ?>
					<input type="submit" name="submit" value="Save invoice" class="button"/>
				</div>
			</div>
		</form>
	</div>
</div>