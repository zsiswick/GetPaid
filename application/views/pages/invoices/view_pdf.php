<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Ruby Invoice</title>
	
	<style type="text/css">
		
		@font-face {
		    font-family: 'robotoregular';
		    src: url('fonts/roboto/roboto-regular-webfont.eot');
		    src: url('fonts/roboto/roboto-regular-webfont.eot?#iefix') format('embedded-opentype'),
		         url('fonts/roboto/roboto-regular-webfont.woff') format('woff'),
		         url('fonts/roboto/roboto-regular-webfont.ttf') format('truetype'),
		         url('fonts/roboto/roboto-regular-webfont.svg#robotoregular') format('svg');
		    font-weight: normal;
		    font-style: normal;
		
		}
	
		body, p, h1, h2, h3, h4, h5, h3.top-rule {
			color: #000 !important;
			background: #fff;
			font-family: "robotoregular", Helvetica, Arial, sans-serif;
		}
		.light-bg .ruled, .info-block.last, h3.top-rule, .list_header, hr {
			border-color: #ccc;
		}
		table thead th{
			background: #fff;
			color: #000;
		}
		table tr, table td {
			background: #fff;
		}
		
		.rule {
			padding: 0px;
			margin: 0px;
			line-height: 0;
		}
		h5 {
			text-transform: uppercase;
			font-size: 10px;
			padding: 0;
			margin: 0;
			line-height: 0;
		}
		div.info-block {
			margin-top: 20px;
			margin-bottom: 40px;
		}
		th {
			text-transform: uppercase;
			font-size: 10px;
		}
		hr {
			border-bottom: 1px solid #fff;
		}
		
	</style>
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
	$inv_num = $item[0]['prefix'].'-'.$item[0]['inv_num'];
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
				<div id="" class="light-bg">
					<table style="width: 100%;">
						<tr>
							<td style="width: 35%;" valign="top">
								<?php if(!empty($logo)): echo'<img class="company-logo" src="'.base_url().'uploads/logo/'.$item['client'][0]['uid']."/".$logo.'" /><br/><br/>'; endif ?>
								<p><?php if(!empty($company_name)): echo '<h3>'.$company_name.'<h3/>'; endif ?></p>
							</td>
							<td style="width: 5%;" valign="top">
							</td>
							<td style="width: 30%;" valign="top">
									
									<hr class="rule" />
									<h5>Billing Information</h5>
									<hr class="rule" />
								
									<div class="info-block">
									<?php echo $item['client'][0]['company'].'<br/>'; ?>
									<?php echo $item['client'][0]['contact'].'<br/>'; ?>
									<?php if(!empty($address_1)): echo $address_1.'<br/>'; endif ?>
									<?php if(!empty($address_2)): echo $address_2.'<br/>'; endif ?>
									<?php if(!empty($city)): echo $city.' '; endif ?> <?php if(!empty($state)): echo $state.' '; endif ?> <?php if(!empty($zip)): echo $zip; endif ?> <br /><br />
								</div>
							</td>
							<td style="width: 30%;" valign="top">
								<hr class="rule" />
								<h5>
										Invoice Num
								</h5>
								<hr class="rule" />
								<div class="info-block">	
									<?php if(!empty($item[0]['prefix'])): echo $item[0]['prefix'].'-'; endif ?><?php echo($item[0]['inv_num'])?>
									<br /><br />
								</div>
								
								<hr class="rule" />
								<h5>
										Creation Date
								</h5>
								<hr class="rule" />
								
								<div class="info-block">	
									<?php echo($theDate['month'].' '.$theDate['day'].', '.$theDate['year']);?>
									<br /><br />
								</div>
								
									<hr class="rule" />
									<h5>
											Due Date
									</h5>
									<hr class="rule" />
									
									<div class="info-block last">
										<?php
											
											$today = new DateTime(date('Ymd'));
											$due = new DateTime($item[0]['due_date']);
											// Calculate the difference between today's date, and the invoice due date
											$diff = $today->diff($due);
											
											if ($item[0]['status'] == 3){ ?>
												INVOICE PAID
											<?php }
											
											else if ($item[0]['status'] == 4) { ?>
												<?php echo $diff->format('%a DAYS'); ?> PAST DUE
											
										<?php	} else { ?>
											
												<?php 
													
													$date = new DateTime($item[0]['due_date']);
													echo ($date->format('F j, Y')); ?>
												
											
										<?php	} ?>
										<br /><br />
								</div>
							</td>
						</tr>
					</table>
					
					
					
							
					<table style="width: 100%;" cellpadding="0" cellspacing="0" border-collapse="collapse">
						<thead class="invoice-create list_header">
							<tr><th colspan="4"><hr /></th></tr>
							<tr>
								<th style="text-align: left;">Qty</th>
								<th style="text-align: left;">Description</th>
								<th style="text-align: right;">Price</th>
								<th style="text-align: right;">Total</th>
							</tr>
							<tr><th colspan="4"><hr /></th></tr>
						</thead>
						<?php 
							foreach ($item['items'] as $invoice_item): 
							 
							$number = $invoice_item['quantity'] * $invoice_item['unit_cost']; 
							$sumTotal = $sumTotal + $number;
						?>
						<tr>
							<td style="text-align: left;">
								<?php echo $invoice_item['quantity'] ?>
							</td>
							<td style="text-align: left;">
								<?php echo $invoice_item['description'] ?>
							</td>
							<td style="text-align: right;">
								<?php echo '$'.$invoice_item['unit_cost'] ?>
							</td>
							<td style="text-align: right;" data-totalsum="<?php echo number_format((float)$number, 2, '.', ','); ?>">
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
									<td style="width: 40%; text-align: left;">
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
									<td style="width: 40%; text-align: left;">
										<h4>Paid:</h4>
									</td>
									<td style="width: 60%; text-align: right;">
										<h4>$<span id="amtPaid"><?php 
													foreach ($item['payments'] as $payment){
														$number = $payment['payment_amount'] ; 
														$payment_amount = $payment_amount + $number;
													}
													echo number_format((float)$payment_amount, 2, '.', ',');?></span></h4>
									</td>
								</tr>
								<tr>
									<td colspan="2"><hr /></td>
								</tr>
								<tr>
									<td style="width: 40%; text-align: left;">
										<h4>Left:</h4>
									</td>
									<td style="width: 60%; text-align: right;">
										<h4>$<span id="amtLeft"><?php
											$amtLeft = max($sumTotal - $payment_amount,0);
											echo(number_format((float)($amtLeft), 2, '.', ','));
										?></span></h4>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>				
</div>
	
					
</body>

</html>