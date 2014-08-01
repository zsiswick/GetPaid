<h1 class="text-center">View Invoice</h1>
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
			
				<?php echo validation_errors();?>
				
				<div id="invoiceCreate" class="invoice-wrap">
					
						<div class="invoice-inner-wrap">
							<div class="row invoice-info">
								<div class="medium-5 small-centered large-uncentered columns invoice-info">
										<?php if(!empty($logo)): echo'<img class="company-logo" src="'.base_url().'uploads/logo/'.$this->tank_auth_my->get_user_id()."/".$logo.'" />'; endif ?>
									<p>
										<?php if(!empty($company_name)): echo '<h3>'.$company_name.'<h3/>'; endif ?>
										<!--
										<?php if(!empty($p_address_1)): echo $p_address_1.'<br/>'; endif ?>
										<?php if(!empty($p_address_2)): echo $p_address_2.'<br/>'; endif ?>
										<?php if(!empty($p_city)): echo $p_city.' '; endif ?>
										<?php if(!empty($p_state)): echo $p_state.' '; endif ?>
										<?php if(!empty($p_zip)): echo '<br/>'.$p_zip; endif ?>-->
									</p>
								</div>
								<div class="large-7 small-centered large-uncentered columns">
									<div class="row">
									
										<div class="large-12 columns text-right">
											<h4 class="caps">Invoice <?php echo($status_flags[$item[0]['status']]);?></h4>
										</div>
										
										<div class="medium-6 columns">
											<div class="ruled on-paper">
												<h5 class="caps">
														Billing Information
												</h5>
													<ul id="clientAddress">
														<li><?php echo $item['client'][0]['company']; ?></li>
														<li><?php echo $item['client'][0]['contact']; ?></li>
														<li><?php if(!empty($address_1)): echo $address_1.'<br/>'; endif ?></li>
														<li><?php if(!empty($address_2)): echo $address_2.'<br/>'; endif ?></li>
														<li><?php if(!empty($city)): echo $city.' '; endif ?> <?php if(!empty($state)): echo $state.' '; endif ?> <?php if(!empty($zip)): echo $zip; endif ?></li>
													</ul>
											</div>
										</div>		
										
										<div class="medium-6 columns">
											<div class="ruled on-paper">
												<h5 class="caps">
														Invoice Num
												</h5>
												<p><?php echo($inv_num); ?></p>
											</div>
											
											<div class="ruled on-paper sans-top">
												<h5 class="caps">
														Send Date
												</h5>
												<p><span><span class="show-for-small-only">Date: </span></span><?php echo($theDate['month'].' '.$theDate['day'].', '.$theDate['year']);?></p>
											</div>
											
											<div class="ruled on-paper sans-top">
												<h5 class="caps">
														Due Date
												</h5>
												<?php
													
													$today = new DateTime(date('Ymj'));
													$due = new DateTime($item[0]['due_date']);
													// Calculate the difference between today's date, and the invoice due date
													$diff = $today->diff($due);
													
													if ($item[0]['status'] == 3){ ?>
														<p>INVOICE PAID</p>
													<?php }
													
													else if ($item[0]['status'] == 4) { ?>
														<p><?php echo $diff->format('%a DAYS'); ?> PAST DUE</p>
													
												<?php	} else { ?>
													
														<p><?php 
															
															$date = new DateTime($item[0]['due_date']);
															echo ($date->format('F j, Y')); ?>
														</p>
													
												<?php	} ?>
											</div>
										</div>
										
										
									</div>
									
									
								</div>
							</div>
							
							<div id="" class="row invoice-create list_header">
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
								
								<div class="row tabbed list">
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
						<div class="row">
							<div class="small-12 small-only-text-center columns">
								
								
								<div class="icon-bar five-up">
								  
								  <?php
								  	
								  	if ($invoice_sent == true) { ?>
								  	
									  	<a href="#" id="sendInvoiceRemind2Btn" data-reveal-id="paymentModal" class="item">
									  	  <i class="fi-alert size-21"></i>
									  	  <label class="hide-for-small-only">Remind</label>
									  	</a>
								  		
								  <?php	} else { ?>
								  	
									  	<a href="#" id="sendInvoice2Btn" data-reveal-id="paymentModal" class="item">
									  	  <i class="fi-mail size-21"></i>
									  	  <label class="hide-for-small-only">Send</label>
									  	</a>
								  
								  <?php } ?>
								  
								  
								  <a href="<?php echo base_url(); ?>index.php/invoices/pdf/<?php echo $item[0]['iid']?>" class="item">
								    <i class="fi-download size-21"></i>
								    <label class="hide-for-small-only">Download</label>
								  </a>
								  <a href="<?php echo base_url(); ?>index.php/invoice/view/<?php echo $item[0]['iid']?>/<?php echo $item['client'][0]['key']?>" class="item">
								    <i class="fi-link size-21"></i>
								    <label class="hide-for-small-only">Permalink</label>
								  </a>
								  <a href="#" id="addPayment2Btn" data-reveal-id="paymentModal" class="item">
								    <i class="fi-dollar-bill size-21"></i>
								    <label class="hide-for-small-only">Payments</label>
								  </a>
								  <a href="<?php echo base_url()?>index.php/invoices/edit/<?php echo $item[0]['iid']?>" class="item">
								    <i class="fi-pencil size-21"></i>
								    <label class="hide-for-small-only">Edit</label>
								  </a>
								</div>
							</div>
						</div>
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