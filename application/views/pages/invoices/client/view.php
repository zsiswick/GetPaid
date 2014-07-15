<div id="invoiceContainer">
	<div id="container">
		<div class="row">
			<div class="large-12 columns">
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
				
			?>
			
				<?php echo validation_errors();?>
				<div class="invoice-wrap">
						<div class="invoice-inner-wrap">
							<div class="row">
								<div class="small-12 small-centered large-uncentered large-8 columns invoice-info">
										<?php if(!empty($company_name)): echo'<img src="'.base_url().'uploads/logo/'.$logo.'" />'; endif ?>
									<p>
										<?php if(!empty($company_name)): echo $company_name.'<br/>'; endif ?>
										<?php if(!empty($p_address_1)): echo $p_address_1.'<br/>'; endif ?>
										<?php if(!empty($p_address_2)): echo $p_address_2.'<br/>'; endif ?>
										<?php if(!empty($p_city)): echo $p_city.' '; endif ?>
										<?php if(!empty($p_state)): echo $p_state.' '; endif ?>
										<?php if(!empty($p_zip)): echo '<br/>'.$p_zip; endif ?>
									</p>
								</div>
								<div class="small-12 small-centered large-uncentered large-4 columns invoice-info panel">
									<div class="row">
										<div class="small-12 small-only-text-center large-3 columns">
											<p>To:</p>
										</div>
										<div class="small-12 small-only-text-center large-9 columns">
											<p>
												<?php echo $item[0]['client']; ?><br/>
												<?php echo $item['client'][0]['contact']; ?><br/>
												<?php if(!empty($address_1)): echo $address_1.'<br/>'; endif ?>
												<?php if(!empty($address_2)): echo $address_2.'<br/>'; endif ?>
												<?php if(!empty($city)): echo $city.' '; endif ?>
												<?php if(!empty($state)): echo $state.' '; endif ?>
												<?php if(!empty($zip)): echo '<br/>'.$zip; endif ?>
											</p>
										</div>
									</div>
									<hr />
									<div class="row">
										<div class="small-3 hide-for-small-only small-only-text-left large-3 columns">
											<p>Invoice:</p>
										</div>
										<div class="small-12 small-only-text-center large-9 columns">
											<p><span><span class="show-for-small-only">Invoice: </span></span><?php echo($item[0]['iid']); ?></p>
										</div>
									</div>
									<hr />
									<div class="row">
										<div class="small-6 hide-for-small-only small-only-text-center large-3 columns">
											<p>Date:</p>
										</div>
										<div class="small-12 small-only-text-center large-9 columns">
											<p><span><span class="show-for-small-only">Date: </span></span><?php echo($theDate['month'].' '.$theDate['day'].', '.$theDate['year']);?></p>
										</div>
									</div>
									<hr />
									<div class="row">
										<div class="small-6 hide-for-small-only small-only-text-center large-3 columns">
											<p>Due:</p>
										</div>
										<div class="small-12 small-only-text-center large-9 columns">
											<p><span><span class="show-for-small-only">Due: </span></span>$<?php echo number_format((float)($item[0]['amount']), 2, '.', ',');?></p>
										</div>
									</div>
								</div>
							</div>
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
							
							<div id="invoiceCreate" class="row invoice-create list_header">
								<div class="small-12 medium-2 large-2 columns">
									Qty
								</div>
								<div class="small-12 medium-4 large-6 columns">
									Description
								</div>
								<div class="small-12 medium-3 large-2 columns text-right">
									Price
								</div>
								<div class="small-12 medium-3 large-2 columns text-right">
									Total
								</div>
							</div>
							
							
							
							
						
							<?php 
									foreach ($item['items'] as $invoice_item): 
									 
									$number = $invoice_item['quantity'] * $invoice_item['unit_cost']; 
									$sumTotal = $sumTotal + $number;
								?>
								
								<div class="row invoice list">
									<div class="small-12 small-only-text-center medium-2 large-2 columns qty">
										<?php echo $invoice_item['quantity'] ?>
									</div>
									<div class="small-12 small-only-text-center medium-4 large-6 columns description">
										<?php echo $invoice_item['description'] ?>
									</div>
									<div class="small-12 small-only-text-center medium-3 large-2 columns text-right price">
										<?php echo '$'.$invoice_item['unit_cost'] ?>
									</div>
									<div class="small-12 small-only-text-center medium-3 large-2 columns text-right totalSum" data-totalsum="<?php echo number_format((float)$number, 2, '.', ','); ?>">
										$<?php 
											echo number_format((float)$number, 2, '.', ','); 
										?>
									</div>
								</div>
								
								
							<?php endforeach ?>	
						
						<section id="payment-info" class="row">
							<div class="large-7 columns">
								<h3>Notes</h3>
								<p><?php echo($item['settings'][0]['notes']) ?></p>
							</div>
							<div id="payments" class="large-5 columns">
								
								<div class="row">
									<div class="small-7 columns large-only-text-right">
										<h3>Due:</h3>
									</div>
									<div class="small-5 columns text-right">
										<h3>$<span id="invoiceTotal"></span><?php echo number_format((float)($item[0]['amount']), 2, '.', ',');?></h3>
									</div>
								</div>
								<hr />
								<div class="row">
									<div class="small-7 columns large-only-text-right">
										<h5>Paid:</h5>
									</div>
									<div class="small-5 columns text-right">
										<h5>
											$<span id="amtPaid"><?php 
													foreach ($item['payments'] as $payment){
														$number = $payment['payment_amount'] ; 
														$payment_amount = $payment_amount + $number;
													}
													echo number_format((float)$payment_amount, 2, '.', ',');?>
												</span>
										</h5>
									</div>
								</div>
								<hr />
								
								<div class="row">
									<div class="small-7 columns large-only-text-right">
										<h5>Left:</h5>
									</div>
									<div class="small-5 columns text-right">
										<h5>$<span id="amtLeft"><?php
											$amtLeft = max($sumTotal - $payment_amount,0);
											echo(number_format((float)($amtLeft), 2, '.', ','));
										?></span></h5>
										
									</div>
								</div>
							</div>
						</section>
					</div>
				</div>
			</div>
		</div>
	</div>
	
</div>

<div class="row">
	<div class="small-12 medium-12 large-4 columns large-centered">
		<div id="paymentModal" class="reveal-modal small" data-reveal>
			<div id="form-errors" class="alert-box round"></div>
			<div id="form-wrap"></div>
		</div>
	</div>
</div>