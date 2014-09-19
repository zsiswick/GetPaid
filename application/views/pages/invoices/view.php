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
	$this->load->helper('currency_helper');
	$currency = currency_method($item['settings'][0]['currency']);
?>
<h1 class="text-center">View Invoice #<?php echo($item[0]['iid']);?></h1>
<div class="row">
	<div class="small-12 columns">
		<h3 class="small-only-text-center top-rule">Invoice Actions</h3>
		<div class="row">
			<div class="medium-4 columns">
				<h5 class="ruled caps">
					Edit
				</h5>
				<div class="info-block">
					<a href="<?php echo base_url()?>index.php/invoices/edit/<?php echo $item[0]['iid']?>" class="button small round light">Edit Invoice</a>
				</div>
				<h5 class="ruled caps">
					Auto-reminder
				</h5>
				<div class="switch round info-block">
				  <input id="auto_reminder" name="auto_reminder" type="checkbox" <?php if( $item[0]['auto_reminder'] == 1) {?> checked="checked" <?php } ?>/>
				  <label for="auto_reminder"></label>
				</div>
			</div>
			<div class="medium-4 columns">
				<h5 class="ruled caps">
					Payments
				</h5>
				<div class="info-block"><a href="#" id="addPaymentBtn" data-reveal-id="paymentModal" class="button round small light">Add Payment</a></div>
				<h5 class="ruled caps">
					Send
				</h5>
				<div class="info-block">
					<?php
						if ($invoice_sent == true && $item[0]['status'] != 3) { ?>
						
					  	<a href="#" id="sendInvoiceRemindBtn" data-reveal-id="paymentModal" class="button round small light">Send Reminder</a>
							
					<?php	} else if ( $item[0]['status'] == 3) { ?>
						
					  <a href="#" id="sendInvoiceThanks" data-reveal-id="paymentModal" class="button round small light">Send Thank You</a>	
					
					<?php } else {?>
					
						<a href="#" id="sendInvoiceBtn" data-reveal-id="paymentModal" class="button round small light">Send Invoice</a>
					
					<?php } ?>
				</div>
				
			</div>
			<div class="medium-4 columns">
				<h5 class="ruled caps">
					PDF
				</h5>
				<div class="info-block">
					<a href="<?php echo base_url(); ?>index.php/invoices/pdf/<?php echo $item[0]['iid']?>" class="button round small light">Download</a>
				</div>
				<h5 class="ruled caps">
					Permalink
				</h5>
				<div class="info-block">
					<a href="<?php echo base_url(); ?>index.php/invoice/view/<?php echo $item[0]['iid']?>/<?php echo $item['client'][0]['key']?>" class="button round small light">View</a>
				</div>
				
			</div>
		</div>
	</div>	
</div><!---->
<div id="invoiceContainer" class="">
		<div class="row">
			<div class="large-12 columns">
			
			
				<?php echo validation_errors();?>
				
				<div id="invoiceCreate" class="invoice-form light-bg">
					
						<div class="">
							<div class="row">
								<div class="large-12 columns text-right small-only-text-left">
									<h4 class="caps">Invoice <?php echo($status_flags[$item[0]['status']]);?></h4>
								</div>
							</div>
							<div class="row invoice-info">
								<div class="medium-5 small-centered large-uncentered columns invoice-info">
										<?php if(!empty($logo)): echo'<img class="company-logo" src="'.base_url().'uploads/logo/'.$this->tank_auth_my->get_user_id()."/".$logo.'" />'; endif ?>
									<?php if(!empty($company_name)): echo '<h3>'.$company_name.'<h3/>'; endif ?>
									<div class="info-block">
										<ul>
											<?php if( !empty($item['settings'][0]['address_1']) ): echo('<li>'.$item['settings'][0]['address_1'].'</li>'); endif ?>
											<?php if( !empty($item['settings'][0]['address_2']) ): echo('<li>'.$item['settings'][0]['address_2'].'</li>'); endif ?>
											<?php if( !empty($item['settings'][0]['city']) || !empty($item['settings'][0]['state']) || !empty($item['settings'][0]['zip']) ): echo('<li>'); endif ?><?php echo($item['settings'][0]['city'].' '.$item['settings'][0]['state'].' '.$item['settings'][0]['zip']); ?><?php if( !empty($item['settings'][0]['city']) || !empty($item['settings'][0]['state']) || !empty($item['settings'][0]['zip']) ): echo('</li>'); endif ?>
											<?php if( !empty($item['settings'][0]['country']) ): echo('<li>'.$item['settings'][0]['country'].'</li>'); endif ?>
										</ul>
									</div>
								</div>
								
								<div class="large-7 small-centered large-uncentered columns">
									<div class="row">
										<div class="medium-6 columns">
											<h5 class="caps ruled">Billing Information</h5>
												<div class="info-block ">
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
											<h5 class="caps ruled">
													Invoice Num
											</h5>
											<div class="info-block ">	
												<?php if(!empty($item[0]['prefix'])): echo $item[0]['prefix'].'-'; endif ?><?php echo($item[0]['inv_num']) ?>
											</div>
											
											<h5 class="caps ruled">
													Creation Date
											</h5>
											<div class="info-block">	
												<?php echo($theDate['month'].' '.$theDate['day'].', '.$theDate['year']);?>
											</div>
											
												<h5 class="caps ruled">
														Due Date
												</h5>
												<div class="info-block last">
													<input id="inv_due" type="hidden" value="<?php echo($item['settings'][0]['due'])?>" />
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
											</div>
										</div>
										
										
									</div>
									
								<?php
									if (!empty($item[0]['description'])) { ?>
										<div class="row">
									<div class="columns small-12">
										<h5 class="ruled caps">Description</h5>
										<div class="info-block">
											<?php echo($item[0]['description']);?>
										</div>
									</div>
								</div>
									<?php } ?>
								</div>
							</div>
								
							<div class="invoice-create list_header clearfix">
								<div class="row">
									<div class="small-12 medium-2 columns qty">
										Qty
									</div>
									<div class="small-12 medium-6 columns description">
										Description
									</div>
									<div class="small-12 medium-2 columns price text-right">
										Price
									</div>
									<div class="small-12 medium-2 text-right columns totalSum">
										Total
									</div>
								</div>
							</div>
							
							<div class="tabbed list no-rules">
								<?php 
										foreach ($item['items'] as $invoice_item): 
										 
										$number = $invoice_item['quantity'] * $invoice_item['unit_cost']; 
										$sumTotal = $sumTotal + $number;
									?>
									
									<div class="row">
										<div class="small-12 medium-2 large-2 columns hide-for-small-only">
											<?php echo $invoice_item['quantity'] ?>
										</div>
										<div class="small-12 medium-6 columns small-only-text-center">
											<?php echo $invoice_item['description'] ?>
										</div>
										<div class="small-12 small-only-text-center medium-2 columns text-right hide-for-small-only">
											<?php echo $invoice_item['unit_cost'] ?>
										</div>
										<div class="small-12 columns small-only-text-center show-for-small-only">
											<?php echo $invoice_item['quantity'] ?> x <?php echo $invoice_item['unit_cost'] ?>
										</div>
										<div class="small-12 small-only-text-center medium-2 columns text-right totalSum" data-totalsum="<?php echo number_format((float)$number, 2, '.', ','); ?>">
											<?php 
												echo number_format((float)$number, 2, '.', ','); 
											?>
										</div>
										<div class="small-12 columns"><hr /></div>
									</div>
									
									
								<?php endforeach ?>
							</div>
								
						
						
						<section id="payment-info">
							<div class="row">
								<div id="payments" class="large-push-7 large-5 columns ">
									
									<div class="row">
										<div class="small-5 columns">
											<h3>Due:</h3>
										</div>
										<div class="small-7 columns text-right">
											<h3><?php echo($currency)?><span id="invoiceTotal"></span><?php echo number_format((float)($item[0]['amount']), 2, '.', ',');?></h3>
										</div>
										<div class="small-12 columns"><hr /></div>
									</div>
									<div class="row">
										<div class="small-5 columns">
											<h4>Paid:</h4>
										</div>
										<div class="small-7 columns text-right">
											<h4>
												<?php echo($currency)?><span id="amtPaid"><?php 
														foreach ($item['payments'] as $payment){
															$number = $payment['payment_amount'] ; 
															$payment_amount = $payment_amount + $number;
														}
														echo number_format((float)$payment_amount, 2, '.', ',');?>
													</span>
											</h4>
										</div>
										<div class="small-12 columns"><hr /></div>
									</div>
									
									<div class="row">
										<div class="small-5 columns">
											<h4>Left:</h4>
										</div>
										<div class="small-7 columns text-right">
											<h4><?php echo($currency)?><span id="amtLeft"><?php
												$amtLeft = max($sumTotal - $payment_amount,0);
												echo(number_format((float)($amtLeft), 2, '.', ','));
											?></span></h4>
										</div>
										<div class="small-12 columns"><hr /></div>
									</div>
								</div>
								<div class="large-pull-5 large-7 columns ">
									<h3>Payment Terms</h3>
									<p><?php echo($item['settings'][0]['notes']) ?></p>
								</div>
							</div>
							
						</section>
					</div>
				</div>
			</div>
		</div>
	
</div>

<div class="row">
	<div class="small-12 medium-12 large-4 columns large-centered">
		<div id="paymentModal" class="reveal-modal small light-bg" data-reveal>
			<div id="form-errors"></div>
			<div id="loadingImg"><img src="<?php echo base_url();?>assets/images/ajax-loader.gif" alt="loading" /></div>
			<div id="form-wrap"></div>
		</div>
	</div>
</div>