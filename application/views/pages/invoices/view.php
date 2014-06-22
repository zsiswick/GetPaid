<div class="row">
	<div class="large-12 columns">
	<?php 
		$this->load->helper('dob');
		$sumTotal = 0; 
		$payment_amount = 0;
		$hidden = array('iid' => $item[0]['iid']); 
	?>
	
		<?php echo validation_errors(); ?>
		
		<h2>Invoice #<?php echo($item[0]['iid']); ?></h2>
			<div class="panel">
				<p>Client: <?php echo $item[0]['client']; ?></p>
				<p>Date: <?php echo($dateMonth.' '.$dateDay.', '.$dateYear);?></p>
			</div>
			<div class="table-container">
				<table id="invoiceCreate" class="invoice-create">
				<thead>
					<tr>
						<th>Qty</th>
						<th>Description</th>
						<th class="text-right">Price</th>
						<th class="text-right">Total</th>
					</tr>
				</thead>
				<tbody>
					<?php 
													
							foreach ($item['items'] as $invoice_item): 
							 
							$number = $invoice_item['quantity'] * $invoice_item['unit_cost']; 
							$sumTotal = $sumTotal + $number;
						?>
						<tr>
							<td><?php echo $invoice_item['quantity'] ?></td>
							<td><?php echo $invoice_item['description'] ?></td>
							<td class="text-right"><?php echo '$'.$invoice_item['unit_cost'] ?></td>
							<td data-totalsum="<?php echo number_format((float)$number, 2, '.', ','); ?>" class="totalSum text-right">
								$<?php 
									echo number_format((float)$number, 2, '.', ','); 
								?>
							</td>
						</tr>
					<?php endforeach ?>	
				</tbody>
				</table>
				<div class="row">
					<div class="large-12 columns text-right">
						
						<table id="payments" class="right">
							<tr>
								<td class="text-right"><h3>Total:</h3></td>
								<td class="text-right"><h3 id="invoiceTotal">$<?php echo number_format((float)$sumTotal, 2, '.', ',');?></h3></td>
							</tr>
							<tr>
								<td class="text-right"><h5>Paid:</h5></td>
								<td class="text-right">
									<h5><?php 
																	
											foreach ($item['payments'] as $payment){
												$number = $payment['payment_amount'] ; 
												$payment_amount = $payment_amount + $number;
											}
											
											echo '$'.number_format((float)$payment_amount, 2, '.', ',');
										?></h5>
								</td>
							</tr>
							<tr>
								<td class="text-right"><h5>Left:</h5></td>
								<td class="text-right">
									<h5><?php
										echo('$'.number_format((float)($sumTotal - $payment_amount), 2, '.', ','));
									?></h5>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="large-12 columns text-right">
					<a href="#" data-reveal-id="paymentModal" class="button">Add Payment</a>
					<?php echo anchor('invoices/edit/'.$item[0]['iid'], 'Edit Invoice', 'class="button secondary"', 'id="'.$item[0]['iid'].'"'); ?>
				</div>
			</div>
	</div>
</div>
<div class="row">
	<div class="large-4 columns large-centered">
		<div id="paymentModal" class="reveal-modal small" data-reveal>
		<?php 
			$attributes = array('class' => 'invoice-form', 'id' => 'addPayment');
			echo form_open('invoices/view/'.$item[0]['iid'], $attributes, $hidden) 
		?>
			<div class="row">
			<div class="columns large-12">
				<label for="payment_amount[]">Amount</label>
				<input class="" type="text" name="pamount" value="<?php echo(number_format((float)($sumTotal - $payment_amount), 2, '.', '')); ?>"/>
			</div>
				<div class="columns large-12">
					<label>Date:</label>
				</div>
				<div class="columns large-3 small-3">
					<?php echo $dob_dropdown_day; ?>
				</div>
				<div class="columns large-5 small-5">
					<?php echo $dob_dropdown_month; ?>
				</div>
				<div class="columns large-4 small-4">
					<?php echo$dob_dropdown_year; ?>
				</div>
			
			<div class="columns large-12">
				<input type="submit" name="submit" value="Add Payment" class="button"/>
				
				<?php	
					if (!empty($item['payments'])) {
				?>
					<table id="invoicePayments" class="invoice-create">
					<thead>
						<tr>
							<th></th>
							<th>Amount</th>
							<th>Date</th>
						</tr>
					</thead>
					<tbody>		
					<?php
						foreach ($item['payments'] as $payment){
					?>
						<tr>
							<td><?php echo anchor('invoices/delete_payment?pid='.$payment["pid"].'&common_id='.$payment["common_id"], 'Remove', 'pid="'.$payment["pid"].'"'); ?></td>
							<td><input type="hidden" name="payment_amount[]" value="<?php echo $payment['payment_amount'] ?>" />$<?php echo $payment['payment_amount'] ?></td>
							<td><?php echo $payment['pdate'] ?></td>
						</tr>
					<?php			
					}
					} 
				 ?>
				 </tbody>
				 </table>
				
			</div>	
			
			
			</div> 
		</form>
		<a class="close-reveal-modal">&#215;</a>
		</div>
	</div>
</div>