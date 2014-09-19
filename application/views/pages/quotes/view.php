<?php 
	$sumTotal = 0; 
	$payment_amount = 0;
	$hidden = array('iid' => $quote[0]['iid']); 
	$address_1 = $quote[0]['address_1'];
	$address_2 = $quote[0]['address_2'];
	$city = $quote[0]['city'];
	$state = $quote[0]['state'];
	$zip = $quote[0]['zip'];
	$inv_num = $quote[0]['prefix'].'-'.$quote[0]['inv_num'];
	//////////////////////////////////
	$logo = $quote[0]['logo'];
	$company_name = $quote[0]['company_name'];
	$p_address_1 = $quote[0]['my_address_1'];
	$p_address_2 = $quote[0]['my_address_2'];
	$p_city = $quote[0]['my_city'];
	$p_state = $quote[0]['my_state'];
	$p_zip = $quote[0]['my_zip'];
	
	if (!empty($quote[0]['item_id'])) {
		$is = explode(",", $quote[0]['item_id']);
		$item_ids = array_merge($is);
	}
	
	$desc = explode(",", $quote[0]['idescription']);
	$idescriptions = array_merge($desc);
	
	$qs = explode(",", $quote[0]['iqty']);
	$iqtys = array_merge($qs);
	
	$cos = explode(",", $quote[0]['icost']);
	$icosts = array_merge($cos);
	
	$this->load->helper('currency_helper');
	$currency = currency_method($quote[0]['currency']);
	
	//print("<pre>".print_r($quote, true )."</pre>");
?>

<!-- Load Header -->
<?php if ($this->uri->segment(2, 0) === "view"): echo('<h1 class="text-center">View Quote #'.$quote[0]['iid'].'</h1>'); endif ?>
<?php if ($edit === TRUE): echo('<h1 class="text-center">Edit Quote #'.$quote[0]['iid'].'</h1>'); endif ?>

<!-- Load Quote Actions -->
<?php if ($this->uri->segment(2, 0) === "view"): $this->load->view('widgets/quote-actions'); endif ?>
<?php if ($this->uri->segment(2, 0) === "review"): echo('<p></p><div class="row"><div class="small-12 columns text-center"><a id="declineQuoteBtn" class="button round light" data-reveal-id="emailModal2">Decline</a> <a id="approveQuoteBtn" class="button round light" data-reveal-id="emailModal">Accept</a></div></div>'); endif ?>

<div id="invoiceContainer">
		<div class="row">
			<div class="large-12 columns">
						<?php 
							$attributes = array('class' => 'invoice-form light-bg', 'id' => 'editForm', 'data-abide'=>'');
							echo form_open('quotes/edit/'.$quote[0]['iid'], $attributes, $hidden); 
						?>
							<div class="row">
								<div class="large-12 columns text-right small-only-text-left">
									<!-- Show email form messages if any -->
									<?php
										if ($this->session->flashdata('error')) { ?>
												<div class="alert-box radius text-center">
													<?php echo($this->session->flashdata('error')); ?>
												</div>
									<?php }?>
									<?php echo validation_errors();?>
									<h4 class="caps">Quote <?php echo($quote_flags[$quote[0]['status']]);?></h4>
								</div>
							</div>
							<div class="row invoice-info">
								<div class="medium-5 small-centered large-uncentered columns invoice-info">
										<?php if(!empty($logo)): echo'<img class="company-logo" src="'.base_url().'uploads/logo/'.$quote[0]['uid']."/".$logo.'" />'; endif ?>
									<?php if(!empty($company_name)): echo '<h3>'.$company_name.'<h3/>'; endif ?>
									<div class="info-block">
										<ul>
											<?php if( !empty($quote[0]['my_address_1']) ): echo('<li>'.$quote[0]['my_address_1'].'</li>'); endif ?>
											<?php if( !empty($quote[0]['my_address_2']) ): echo('<li>'.$quote[0]['my_address_2'].'</li>'); endif ?>
											<?php if( !empty($quote[0]['my_city']) || !empty($quote[0]['my_state']) || !empty($quote[0]['my_zip']) ): echo('<li>'); endif ?><?php echo($quote[0]['my_city'].' '.$quote[0]['my_state'].' '.$quote[0]['my_zip']); ?><?php if( !empty($quote[0]['my_city']) || !empty($quote[0]['my_state']) || !empty($quote[0]['my_zip']) ): echo('</li>'); endif ?>
											<?php if( !empty($quote[0]['my_country']) ): echo('<li>'.$quote[0]['my_country'].'</li>'); endif ?>
										</ul>
									</div>
								</div>
								
								<div class="large-7 small-centered large-uncentered columns">
									
									
									<?php if( $edit === FALSE ) { ?>
										<div class="row">
										<div class="medium-6 columns">
											<h5 class="caps ruled">Billing Information</h5>
												<div class="info-block ">
													<ul id="clientAddress">
														<li><?php echo $quote[0]['company']; ?></li>
														<li><?php echo $quote[0]['contact']; ?></li>
														<li><?php if(!empty($address_1)): echo $address_1.'<br/>'; endif ?></li>
														<li><?php if(!empty($address_2)): echo $address_2.'<br/>'; endif ?></li>
														<li><?php if(!empty($city)): echo $city.' '; endif ?> <?php if(!empty($state)): echo $state.' '; endif ?> <?php if(!empty($zip)): echo $zip; endif ?></li>
													</ul>
											</div>
										</div>		
										
										<div class="medium-6 columns">
											<h5 class="caps ruled">
													Quote Num
											</h5>
											<div class="info-block ">	
												<?php if(!empty($quote[0]['prefix'])): echo $quote[0]['prefix'].'-'; endif ?><?php echo($quote[0]['inv_num']) ?>
											</div>
											
											<h5 class="caps ruled">
													Issue Date
											</h5>
											<div class="info-block">	
												<?php echo($theDate['month'].' '.$theDate['day'].', '.$theDate['year']);?>
											</div>
											
												
										</div>
										
										
									</div>
									<?php } else { ?>
										<?php $this->load->view('templates/billing-info'); ?>
									<?php } ?>
									
								<?php
									if (!empty($quote[0]['description'])) { ?>
										<div class="row">
									<div class="columns small-12">
										<h5 class="ruled caps">Description</h5>
										<div class="info-block">
											<?php echo($quote[0]['description']);?>
										</div>
									</div>
								</div>
									<?php } ?>
								</div>
							</div>
							
							
									<?php if ($edit === TRUE ) {?>
										<div class="list_header">
											<div class="row">
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
												<div class="small-12 medium-1 large-only-text-right columns delete">
												</div>
											</div>
										</div>
									<?php } else { ?>
										<div class="invoice-create list_header clearfix">
											<div class="row">
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
										</div>
									<?php } ?>
								
									<div class="edit-list-container">
									<div class="tabbed list no-rules">
							
									<?php 
										$i = 0;
										foreach ($iqtys as $item_qts): 
										 
										$number = $item_qts * $icosts[$i]; 
										$sumTotal = $sumTotal + $number;
										
									?>
									
									<?php if( $edit === TRUE ) { // SHOW THE EDIT FORM ?>
										
											<div class="row">
												<div class="qty small-12 medium-2 columns">
													<input type="hidden" name="item_id[]" value="<?php echo $item_ids[$i] ?>" /><input type="text" class="qty sum" name="qty[]" value="<?php echo $item_qts ?>" required />
													<small class="error">Quantity is required.</small>
												</div>
												<div class="description small-12 medium-5 columns">
													<input type="text" name="description[]" value="<?php echo $idescriptions[$i] ?>" />
												</div>
												<div class="price small-12 medium-2 columns">
													<input type="text" class="unitCost sum" name="unit_cost[]" value="<?php echo $icosts[$i] ?>" required />
													<small class="error">Price is required.</small>
												</div>
												<div class="totalSum small-12 medium-2 large-only-text-right columns" data-totalsum="<?php echo number_format((float)$number, 2, '.', ''); ?>">
													<?php echo number_format((float)$number, 2, '.', ','); ?>
												</div>
												<div class="delete small-12 medium-1 columns large-only-text-right small-text-center">
													<a class="delete-row button small round">x</a>
												</div>
												<div class="small-12 columns"><hr /></div>
											</div>
												
									<?php } else { // SHOW THE STANDARD VIEW ?>
										
										<div class="row">
											<div class="small-12 medium-2 large-2 columns hide-for-small-only">
												<?php echo $item_qts; ?>
											</div>
											<div class="small-12 medium-4 large-6 columns small-only-text-center">
												<?php echo $idescriptions[$i]; ?>
											</div>
											<div class="small-12 small-only-text-center medium-3 large-2 columns text-right hide-for-small-only">
												<?php echo $icosts[$i]; ?>
											</div>
											<div class="small-12 columns small-only-text-center show-for-small-only">
												<?php echo $item_qts; ?> x <?php echo '$'.$icosts[$i]; ?>
											</div>
											<div class="small-12 small-only-text-center medium-3 large-2 columns text-right totalSum" data-totalsum="<?php echo number_format((float)$number, 2, '.', ','); ?>">
												<?php echo number_format((float)$number, 2, '.', ','); ?>
											</div>
											<div class="small-12 columns"><hr /></div>
										</div>
									<?php } ?>
								
								<?php 
									$i++;
									endforeach 
								?>
								
								
								
							</div>
						</div> <!-- tabbed list -->
						<?php if($edit === TRUE ) { ?>
							<div class="row">
								<div class="large-12 columns text-left small-only-text-center">
									<a id="addItems" class="button small round">Add Another Item</a>
								</div>
							</div>	
						<?php } ?>
						
						<section id="payment-info">
							<div class="row">
								<div id="payments" class="large-push-7 large-5 columns ">
									
									<div class="row">
										<div class="small-5 columns">
											<h3>Total:</h3>
										</div>
										<div class="small-7 columns text-right">
											<?php if ( $edit === FALSE ) { ?>
												<h3><?= $currency ?><span id="invoiceTotal"></span><?php echo number_format((float)($quote[0]['amount']), 2, '.', ',');?></h3>
											<?php } else { ?>
												<h3><?= $currency ?><span id="invoiceTotal"><?php echo number_format((float)$sumTotal, 2, '.', ',');?></span></h3>
											<?php } ?>
										</div>
										<div class="small-12 columns"><hr /></div>
									</div>
									
								</div>
								<div class="large-pull-5 large-7 columns ">
									<h3>Terms</h3>
									<p><?php echo($quote[0]['terms']) ?></p>
								</div>
							</div>
						</section>
						<?php if( $edit === TRUE ) { ?>
							<div class="row actions">
								<div class="large-12 columns text-right small-only-text-center">
									<input type="submit" name="submit" value="Save Changes" class="button round"/>
								</div>
								<div class="large-12 columns text-right small-only-text-center">
									<a href="#" id="deleteQuoteBtn" data-reveal-id="editModal">Delete Quote</a>
								</div>
							</div>
						<?php } ?>
					</form>	
			</div>
		</div>
</div>
<?php 
	if ($this->uri->segment(2, 0) === "review") { ?>
		
		<div class="row">
			<div class="small-12 medium-12 large-4 columns large-centered">
				<div id="emailModal" class="reveal-modal small light-bg" data-reveal>
					<div id="form-errors"></div>
					<div id="form-wrap"></div>
					<?php $this->load->view('pages/quotes/email/view_approve_quote'); ?>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="small-12 medium-12 large-4 columns large-centered">
				<div id="emailModal2" class="reveal-modal small light-bg" data-reveal>
					<div id="form-errors"></div>
					<div id="form-wrap"></div>
					<?php echo($view_decline_quote); ?>
				</div>
			</div>
		</div>
		
<?php	} ?>

<div class="row">
	<div class="small-12 medium-12 large-4 columns large-centered">
		<div id="emailModal" class="reveal-modal small light-bg" data-reveal>
			<div id="form-errors"></div>
			<div id="form-wrap"></div>
			<?php echo($view_send_quote); ?>
		</div>
	</div>
</div>

<div class="row">
	<div class="small-12 medium-12 large-4 columns large-centered">
		<div id="editModal" class="reveal-modal small light-bg" data-reveal>
			<div class="row">
				<div class="small-10 columns text-center small-centered">
					<h3>Blimey!</h3>
					<p>Are you sure you want to delete this quote?</p>
					<hr />
					<a id="cancelDeleteBtn" href="#" class="button round secondary">No Thanks</a>
					<?php echo anchor('quotes/delete_quote/'.$quote[0]['iid'], 'Delete It', 'class="button round"', 'id="delete-'.$quote[0]['iid'].'"'); ?>
				</div>
			</div>
			<a class="close-reveal-modal">&#215;</a>
		</div>
	</div>
</div>
<script type="text/javascript">
  $(document).ready(function() {
  
  	function init_autoNumeric() {
			$('.sum, .totalSum, #invoiceTotal').autoNumeric('init', {aDec:'.', aSep:'', aForm: false});
		}
		
		$(document).on('click', "#addItems", function() { 
			init_autoNumeric();
		});
		
		init_autoNumeric();
		
	});
</script>