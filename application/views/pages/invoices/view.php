<div class="row">
	<div class="large-12 columns">
	<?php 
		$this->load->helper('dob');
		$sumTotal = 0; 
		$payment_amount = 0;
		$amtLeft;
		$hidden = array('iid' => $item[0]['iid']); 
	?>
	
		<?php echo validation_errors(); ?>
		
		<h2>Invoice #<?php echo($item[0]['iid']); ?></h2>
			<div class="panel">
				<p>To: <?php echo $item[0]['client']; ?></p>
				<p>Date: <?php echo($theDate['month'].' '.$theDate['day'].', '.$theDate['year']);?></p>
				<p>Payment Due: <?php 
				
					$date = new DateTime($item[0]['date']);
					$date->add(new DateInterval('P'.$item['settings'][0]['due'].'D'));
					echo $date->format('F j, Y') . "\n" . '(' . $item['settings'][0]['due'] . ' Days)';
				
				?></p>
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
							//$total = number_format((float)$sumTotal, 2, '.', ',');
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
								<td class="text-right"><h3>$<span id="invoiceTotal"></span><?php echo number_format((float)($sumTotal), 2, '.', ',');?></h3></td>
							</tr>
							<tr>
								<td class="text-right"><h5>Paid:</h5></td>
								<td class="text-right">
									<h5>$<span id="amtPaid"><?php 
											foreach ($item['payments'] as $payment){
												$number = $payment['payment_amount'] ; 
												$payment_amount = $payment_amount + $number;
											}
											echo number_format((float)$payment_amount, 2, '.', ',');?>
										</span>
									</h5>
								</td>
							</tr>
							<tr>
								<td class="text-right"><h5>Left:</h5></td>
								<td class="text-right">
									<h5>$<span id="amtLeft"><?php
										$amtLeft = max($sumTotal - $payment_amount,0);
										echo(number_format((float)($amtLeft), 2, '.', ','));
									?></span></h5>
									<?php
										if ($amtLeft <= 0) {
											echo('INVOICE PAID');
										} else if ( $amtLeft == $sumTotal ) {
											echo('INVOICE OPEN');
										} else {
											echo('PARTIAL PAYMENT');
										}
									?>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="large-12 columns">
					<h4>Notes</h4>
					<p><?php echo($item['settings'][0]['notes']) ?></p>
				</div>
			</div>
			<div class="row">
				<div class="large-12 columns text-right">
					
					
					
					<?php echo anchor('invoices/edit/'.$item[0]['iid'], 'Edit Invoice', 'class="button"', 'id="'.$item[0]['iid'].'"'); ?>
					
					<ul class="button-group">
						<li><?php echo anchor('invoices/send_invoice?iid='.$item[0]['iid'].'&client='.$item[0]['client'], 'Send Invoice', 'class="small button secondary"'); ?></li>
						<li><?php echo anchor('invoices/pdf/'.$item[0]['iid'], 'Download PDF', 'class="small button secondary"'); ?></li>
						<li><a href="#" id="addPaymentBtn" data-reveal-id="paymentModal" class="small button secondary">Add Payment</a></li>
					</ul>
				</div>
			</div>
	</div>
</div>
<div class="row">
	<div class="large-4 columns large-centered">
		<div id="paymentModal" class="reveal-modal small" data-reveal></div>
	</div>
</div>