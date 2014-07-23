<div class="row">
	<div class="large-8 columns large-centered">
		<h1 class="text-center">Edit Invoice #<?php echo($item[0]['iid']);?></h1>
		<div id="form-errors" class="alert-box alert round"></div>
	</div>
</div>

<div class="row">
	<div class="large-12 columns">
		
		<?php $hidden = array('iid' => $item[0]['iid']);
		echo form_open('invoices/edit/'.$item[0]['iid'], '', $hidden) ?>
		<?php $sumTotal = 0 ?>
		
		<div class="invoice-list-wrap">
			<div class="invoice-list-inner-wrap clearfix">
				
				<div class="row">
					<div class="medium-4 large-4 columns">
						<label for="client">Client:</label>
						<p><?php echo $item['client'][0]['company']; ?></p>
					</div>
					<div class="medium-8 large-8 columns">
						<div class="row">
							<div class="large-12 columns">
								<label>Date:</label>
							</div>
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
				
				<section id="invoiceCreate">
					
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
						<div class="small-12 medium-1 large-only-text-right columns remove">
							
						</div>
					</div>
					
					<div class="edit-list-container">
						<?php foreach ($item['items'] as $invoice_item): ?>
							<?php 
								$number = $invoice_item['quantity'] * $invoice_item['unit_cost']; 
								$sumTotal = $sumTotal + $number;
							?>
							<div class="row invoice list no-rules">
								<div class="qty small-12 medium-2 columns">
									<input type="hidden" name="item_id[]" value="<?php echo $invoice_item['id'] ?>" /><input type="text" class="qty sum" name="qty[]" value="<?php echo $invoice_item['quantity'] ?>" />
								</div>
								<div class="description small-12 medium-5 columns">
									<input type="text" name="description[]" value="<?php echo $invoice_item['description'] ?>" />
								</div>
								<div class="price small-12 medium-2 columns">
									<input type="text" class="unitCost sum" name="unit_cost[]" value="<?php echo $invoice_item['unit_cost'] ?>" />
								</div>
								<div class="totalSum small-12 medium-2 large-only-text-right columns" data-totalsum="<?php echo number_format((float)$number, 2, '.', ''); ?>">
									$<?php echo number_format((float)$number, 2, '.', ','); ?>
								</div>
								<div class="delete small-12 medium-1 columns small-text-center large-only-text-right">
									<a href="<?php echo base_url(); ?>index.php/invoices/delete_row?id=<?php echo $invoice_item["id"].'&common_id='.$invoice_item["common_id"]?>" id="remove-<?php echo $invoice_item["id"]; ?>"><i class="step fi-x size-21"></i></a>
								</div>
							</div>
						<?php endforeach ?>	
					</div>
				</section>
				
				<div class="row">
					<div class="large-12 columns text-left">
						<a id="addItems" class="button small secondary round">Add Another Item</a>
					</div>
				</div>
				
				<hr />
				<div class="row">
					<div class="large-12 columns small-only-text-center text-right">
						<h3>Total Due: <span id="invoiceTotal">$<?php echo number_format((float)$sumTotal, 2, '.', ',');?></span></h3>
					</div>
				</div>
				
			</div>
			
			<div class="row actions">
				<div class="large-12 columns text-right small-only-text-center">
					<input type="submit" name="submit" value="Save Changes" class="button round"/>
				</div>
				<div class="large-12 columns text-right small-only-text-center">
					<a href="#" id="deleteInvoiceBtn" data-reveal-id="editModal">Delete Invoice</a>
				</div>
			</div>
			
		</form>
	</div>
	</div>
</div>
<div class="row">
	<div class="small-12 medium-12 large-4 columns large-centered">
		<div id="editModal" class="reveal-modal small" data-reveal>
			<div class="row">
				<div class="small-10 columns text-center small-centered">
					<h3>Blimey!</h3>
					<h5>Are you sure you want to delete this invoice?</h5>
					<hr />
					<a id="cancelDeleteBtn" href="#" class="button round secondary">Cancel</a>
					<?php echo anchor('invoices/delete_invoice/'.$item[0]['iid'], 'Delete Invoice', 'class="button round"', 'id="delete-'.$item[0]['iid'].'"'); ?>
				</div>
			</div>
			<a class="close-reveal-modal">&#215;</a>
		</div>
	</div>
</div>