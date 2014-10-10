<?php

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
	$this->load->helper('status_flag_classes_helper');
?>
<div class="row">
	<div class="small-12 columns">
		<h3 class="small-only-text-center">Invoice Actions</h3>
		<div class="row">
			<div class="medium-4 columns">
				<h5 class="ruled caps">
					Edit
				</h5>
				<div class="info-block">
					<a href="<?php echo base_url()?>index.php/invoices/edit/<?php echo $item[0]['iid']?>" class="button small round secondary">Edit Invoice</a>
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
				<div class="info-block"><a href="#" id="addPaymentBtn" data-reveal-id="paymentModal" class="button round small secondary">Add Payment</a></div>
				<h5 class="ruled caps">
					Send
				</h5>
				<div class="info-block">
					<?php
						if ($invoice_sent == true && $item[0]['status'] != 3) { ?>

					  	<a href="#" id="sendInvoiceRemindBtn" data-reveal-id="paymentModal" class="button round small secondary">Send Reminder</a>

					<?php	} else if ( $item[0]['status'] == 3) { ?>

					  <a href="#" id="sendInvoiceThanks" data-reveal-id="paymentModal" class="button round small secondary">Send Thank You</a>

					<?php } else {?>

						<a href="#" id="sendInvoiceBtn" data-reveal-id="paymentModal" class="button round small secondary">Send Invoice</a>

					<?php } ?>
				</div>

			</div>
			<div class="medium-4 columns">
				<h5 class="ruled caps">
					PDF
				</h5>
				<div class="info-block">
					<a href="<?php echo base_url(); ?>index.php/invoices/pdf/<?php echo $item[0]['iid']?>" class="button round small secondary">Download</a>
				</div>
				<h5 class="ruled caps">
					Permalink
				</h5>
				<div class="info-block">
					<a href="<?php echo base_url(); ?>index.php/invoice/view/<?php echo $item[0]['iid']?>/<?php echo $item['client'][0]['key']?>" class="button round small secondary">View</a>
				</div>

			</div>
		</div>
	</div>
</div>
<div id="invoiceContainer">
		<div class="row">
			<div class="large-12 columns">


				<?php echo validation_errors();?>
				<div class="invoice-wrap">
					<div class="ribbon <?= status_flag_classes($item[0]); ?>"><div><?php echo($status_flags[$item[0]['status']]);?></div></div>
					<div class="invoice-form light-bg">

								<div class="row invoice-info">
									<div class="medium-5 small-centered large-uncentered columns">
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

								<!-- Template Here -->
								<?php $this->load->view('templates/view-invoice-rows');?>


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
