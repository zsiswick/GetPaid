<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Get Paid!</title>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/foundation.css" />
	<!--<link rel="stylesheet" href="<?php $autoload['helper'] = array('url','utility'); ?>assets/css/company.css" />-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css" />
	<script src="<?php echo base_url(); ?>assets/js/vendor/modernizr.js"></script>
</head>
<body>

<div class="row">
	<div class="large-12 columns">
	<?php 
		$sumTotal = 0; 
		$payment_amount = 0;
		$amtLeft;
		$hidden = array('iid' => $item[0]['iid']); 
	?>
	
		
		<h2>Invoice #<?php echo($item[0]['iid']); ?></h2>
			<div class="panel">
				<p>To: <?php echo $item[0]['client']; ?></p>
				<p>Date: <?php echo($theDate['month'].' '.$theDate['day'].', '.$theDate['year']);?></p>
				<p>Payment Due: <?php 
				
					$date = new DateTime($item[0]['date']);
					$date->add(new DateInterval('P'.$item['settings'][0]['due'].'D'));
					echo $date->format('F j, Y') . "\n";
				
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
								<td class="text-right"><h3>$<span id="invoiceTotal"></span><?php echo number_format((float)$sumTotal, 2, '.', ',');?></h3></td>
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
										$amtLeft = number_format((float)($sumTotal - $payment_amount), 2, '.', ',');
										echo($amtLeft);
									?></span></h5>
									<?php
										if ($amtLeft == 0) {
											echo('INVOICE PAID');
										} else if ( $amtLeft > 0) {
											echo('PARTIAL PAYMENT');
										}
									?>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
	</div>
</div>
</body>
<script src="<?php echo base_url();?>assets/js/vendor/jquery.js"></script>
<script src="<?php echo base_url();?>assets/js/foundation.min.js"></script>
<script src="<?php echo base_url();?>assets/js/scripts.js"></script>
</html>