<div class="row">
	<div class="large-8 columns large-centered">
		<h2 class="text-center">Edit Invoice #<?php echo($item[0]['iid']);?></h2>
		
		<div id="form-errors" class="alert-box alert round"></div>
		
		<?php $this->load->helper('dob'); ?>
		<?php $hidden = array('iid' => $item[0]['iid']);
		echo form_open('invoices/edit/'.$item[0]['iid'], '', $hidden) ?>
		<?php $sumTotal = 0 ?>
	</div>
</div>
<div class="row">
	<div class="large-12 columns">
		<div class="table-container">
			<div class="panel clearfix">
				<div class="large-4 columns">
					<label for="client">Client:</label>
					<p><?php echo $item[0]['client']; ?></p>
				</div>
				<div class="large-8 columns">
					<div class="large-12 columns">
						<label>Date:</label>
					</div>
					<div class="large-3 columns">
						<?= $dob_dropdown_day ?>
					</div>
					<div class="large-5 columns">
						<?= $dob_dropdown_month ?>
					</div>
					<div class="large-4 columns">
						<?= $dob_dropdown_year ?>
					</div>
				</div>
			</div>
				<ul id="invoiceCreate" class="invoice-create list_header clearfix">
					<li class="qty">Qty</li>
					<li class="description">Description</li>
					<li class="price">Price</li>
					<li class="totalSum">Total</li>
					<li class="delete">Remove</li>
				</ul>
				
				<div class="edit-list-container">
					<?php foreach ($item['items'] as $invoice_item): ?>
						<?php 
							$number = $invoice_item['quantity'] * $invoice_item['unit_cost']; 
							$sumTotal = $sumTotal + $number;
						?>
						<ul class="invoice-list clearfix">
							<li class="qty"><input type="hidden" name="item_id[]" value="<?php echo $invoice_item['id'] ?>" /><input type="text" class="qty sum" name="qty[]" value="<?php echo $invoice_item['quantity'] ?>" /></li>
							<li class="description"><input type="text" name="description[]" value="<?php echo $invoice_item['description'] ?>" /></li>
							<li class="price"><input type="text" class="unitCost sum" name="unit_cost[]" value="<?php echo $invoice_item['unit_cost'] ?>" /></li>
							<li class="totalSum" data-totalsum="<?php echo number_format((float)$number, 2, '.', ''); ?>">$<?php 
								echo number_format((float)$number, 2, '.', ','); 
							?></li>
							<li class="delete"><?php echo anchor('invoices/delete_row?id='.$invoice_item["id"].'&common_id='.$invoice_item["common_id"], 'Remove', 'id="'.$invoice_item["id"].'"'); ?></li>
						</ul>
					<?php endforeach ?>	
				</div>
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
					<input type="submit" name="submit" value="Save Changes" class="button round"/>
				</div>
			</div>
		</form>
	</div>
</div>