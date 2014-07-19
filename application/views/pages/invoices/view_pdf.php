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

			<?php 
				$sumTotal = 0; 
				$payment_amount = 0;
				$hidden = array('iid' => $item[0]['iid']); 
				$address_1 = $item['client'][0]['address_1'];
				$address_2 = $item['client'][0]['address_2'];
				$city = $item['client'][0]['city'];
				$state = $item['client'][0]['state'];
				$zip = $item['client'][0]['zip'];
				//////////////////////////////////
				$logo = $item['settings'][0]['logo'];
				$company_name = $item['settings'][0]['company_name'];
				$p_address_1 = $item['settings'][0]['address_1'];
				$p_address_2 = $item['settings'][0]['address_2'];
				$p_city = $item['settings'][0]['city'];
				$p_state = $item['settings'][0]['state'];
				$p_zip = $item['settings'][0]['zip'];
				$invoice_sent = $item[0]['inv_sent'];
				
			?>
			
					<table class="pdf_general_info" style="width: 100%;">
						<tr>
							<td style="width: 70%;" valign="top">
										<?php if(!empty($logo)): echo'<img class="company-logo" src="'.base_url().'uploads/logo/'.$logo.'" />'; endif ?>
									<p>
										<?php if(!empty($company_name)): echo $company_name.'<br/>'; endif ?>
										<?php if(!empty($p_address_1)): echo $p_address_1.'<br/>'; endif ?>
										<?php if(!empty($p_address_2)): echo $p_address_2.'<br/>'; endif ?>
										<?php if(!empty($p_city)): echo $p_city.' '; endif ?>
										<?php if(!empty($p_state)): echo $p_state.' '; endif ?>
										<?php if(!empty($p_zip)): echo '<br/>'.$p_zip; endif ?>
									</p>
							</td>
							<td style="width: 30%;">
								
									<table style="width: 250px;">
										<tr>
											<td valign="top" style="width: 40%;">
													<p>To:</p>
											</td>
											<td style="width: 60%;">
													<p>
														<?php echo $item[0]['client']; ?><br/>
														<?php echo $item['client'][0]['contact']; ?><br/>
														<?php if(!empty($address_1)): echo $address_1.'<br/>'; endif ?>
														<?php if(!empty($address_2)): echo $address_2.'<br/>'; endif ?>
														<?php if(!empty($city)): echo $city.' '; endif ?>
														<?php if(!empty($state)): echo $state.' '; endif ?>
														<?php if(!empty($zip)): echo '<br/>'.$zip; endif ?>
													</p>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<hr />
											</td>
										</tr>
										<tr>
											<td style="width: 40%;">
													<p>Invoice:</p>
											</td>
											<td style="width: 60%;">
													<p><?php echo($item[0]['iid']); ?></p>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<hr />
											</td>
										</tr>
										<tr>
											<td style="width: 40%;">
													<p>Date:</p>
											</td>
											<td style="width: 60%;">
													<p><span><span class="show-for-small-only">Date: </span></span><?php echo($theDate['month'].' '.$theDate['day'].', '.$theDate['year']);?></p>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<hr />
											</td>
										</tr>
										<tr>
											<td style="width: 40%;">
													<p>Due:</p>
											</td>
											<td style="width: 60%;">
													<p><span><span class="show-for-small-only">Due: </span></span>$<?php echo number_format((float)($item[0]['amount']), 2, '.', ',');?></p>
											</td>
										</tr>
									</table>
								
									
									
									<div class="row">
										
										
									</div>
								
							</td>
						</tr>
					</table>

					<div class="row">
						<div class="small-12 small-only-text-center columns">
							<?php
								
								$today = new DateTime(date('Ymj'));
								$due = new DateTime($item[0]['due_date']);
								// Calculate the difference between today's date, and the invoice due date
								$diff = $today->diff($due);
								
								if ($item[0]['status'] == 3){ ?>
									<p><span id="status" class="label success round">INVOICE PAID</span></p>
								<?php }
								
								else if ($item[0]['status'] == 4) { ?>
									<p><span id="status" class="label alert round"><?php echo $diff->format('%a DAYS'); ?> PAST DUE</span></p>
								
							<?php	} else { ?>
								
									<p><span id="status" class="label round">
										Payment Due By: <?php 
										
										$date = new DateTime($item[0]['due_date']);
										echo ($date->format('F j, Y')); ?>
									</span></p>
								
							<?php	} ?>
							
						</div>
					</div>
					
					
					<table style="width: 100%; border-collapse: collapse;" cellpadding="0" cellspacing="0">
						<tr style="background: #333; color: #fff;">
							<td style="width: 20%; color: #fff; border-collapse: collapse;">Qty</td>
							<td style="width: 40%; color: #fff; border-collapse: collapse;">Description</td>
							<td style="width: 20%; color: #fff; text-align: right; border-collapse: collapse;">Price</td>
							<td style="width: 20%; color: #fff; text-align: right; border-collapse: collapse;">Total</td>
						</tr>
					</table>
					
					
					
					
					<table style="width: 100%;">
					<?php 
							foreach ($item['items'] as $invoice_item): 
							 
							$number = $invoice_item['quantity'] * $invoice_item['unit_cost']; 
							$sumTotal = $sumTotal + $number;
						?>
						
						<tr>
							<td style="width: 20%;">
								<?php echo $invoice_item['quantity'] ?>
							</td>
							<td style="width: 40%;">
								<?php echo $invoice_item['description'] ?>
							</td>
							<td style="width: 20%; text-align: right;">
								<?php echo '$'.$invoice_item['unit_cost'] ?>
							</td>
							<td data-totalsum="<?php echo number_format((float)$number, 2, '.', ',');?>" style="width: 20%; text-align: right;">
								$<?php 
									echo number_format((float)$number, 2, '.', ','); 
								?>
							</td>
						</tr>
						<tr>
							<td colspan="4"><hr /></td>
						</tr>
						
					<?php endforeach ?>	
					</table>
				
					
					<table style="width: 100%;">
						<tr>
							<td valign="top" style="width: 70%;">
								<h3>Notes</h3>
								<p><?php echo($item['settings'][0]['notes']) ?></p>
							</td>
							<td style="width: 30%;">
								<table style="width: 250px;">
									<tr>
										<td style="width: 40%; text-align: right;">
											<h3>Due:</h3>
										</td>
										<td style="width: 60%; text-align: right;">
											<h3>$<span id="invoiceTotal"></span><?php echo number_format((float)($item[0]['amount']), 2, '.', ',');?></h3>
										</td>
									</tr>
									<tr>
										<td colspan="2"><hr /></td>
									</tr>
									<tr>
										<td style="width: 40%; text-align: right;">
											<h5>Paid:</h5>
										</td>
										<td style="width: 60%; text-align: right;">
											<h5>$<span id="amtPaid"><?php 
														foreach ($item['payments'] as $payment){
															$number = $payment['payment_amount'] ; 
															$payment_amount = $payment_amount + $number;
														}
														echo number_format((float)$payment_amount, 2, '.', ',');?></span></h5>
										</td>
									</tr>
									<tr>
										<td colspan="2"><hr /></td>
									</tr>
									<tr>
										<td style="width: 40%; text-align: right;">
											<h5>Left:</h5>
										</td>
										<td style="width: 60%; text-align: right;">
											<h5>$<span id="amtLeft"><?php
												$amtLeft = max($sumTotal - $payment_amount,0);
												echo(number_format((float)($amtLeft), 2, '.', ','));
											?></span></h5>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					




</body>
<script src="<?php echo base_url();?>assets/js/vendor/jquery.js"></script>
<script src="<?php echo base_url();?>assets/js/foundation.min.js"></script>
<script src="<?php echo base_url();?>assets/js/scripts.js"></script>
</html>