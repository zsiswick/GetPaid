<?php 
	 
	$address_1 = $item['client'][0]['address_1'];
	$address_2 = $item['client'][0]['address_2'];
	$city = $item['client'][0]['city'];
	$state = $item['client'][0]['state'];
	$zip = $item['client'][0]['zip'];
	$prefix = $item[0]['prefix'];
	$inv_num = $item[0]['inv_num'];
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
<div class="row">
	<div class="large-8 columns large-centered">
		<h1 class="text-center">Edit Invoice #<?php echo($item[0]['iid']);?></h1>
		<div id="form-errors" class="alert-box alert round"></div>
	</div>
</div>

<div class="row">
	<div class="large-12 columns">
		
		<?php 
			$attributes = array('class' => 'invoice-form');
			$hidden = array('iid' => $item[0]['iid']);
			echo form_open('invoices/edit/'.$item[0]['iid'], $attributes, $hidden);
			
		?>
		<?php $sumTotal = 0 ?>
		
		<div class="invoice-list-wrap">
			<div class="invoice-list-inner-wrap clearfix">
				
				<div class="row invoice-info">
					<div class="medium-5 small-centered large-uncentered columns invoice-info">
							<?php if(!empty($logo)): echo'<img class="company-logo" src="'.base_url().'uploads/logo/'.$this->tank_auth_my->get_user_id()."/".$logo.'" />'; endif ?>
						<p>
							<?php if(!empty($company_name)): echo '<h3>'.$company_name.'<h3/>'; endif ?>
							
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
									
									<?php 
										if ($clients) {
											// Map select option values to the list of clients available
											$clientList = array_map(function ($ar) {
												return $ar['company'];
											}, $clients);
											$clientID = array_map(function ($ar) {
												return $ar['id'];
											}, $clients);
											$clientList = array_combine($clientID, $clientList);
											$clientList['add_new_client'] = 'Add New Client';
											echo form_dropdown('client', $clientList, 1);
										} else {
											echo anchor('clients/create', 'Add a Client', 'class="button round"', 'id="addClient"');
										}
									?>
									
									<ul id="clientAddress">
										<li id="contactName"><?php echo $item['client'][0]['contact']; ?></li>
										<li id="addressOne"><?php if(!empty($address_1)): echo $address_1.'<br/>'; endif ?></li>
										<li id="addressTwo"><?php if(!empty($address_2)): echo $address_2.'<br/>'; endif ?></li>
										<li id="cityStateZip"><?php if(!empty($city)): echo $city.' '; endif ?> <?php if(!empty($state)): echo $state.' '; endif ?> <?php if(!empty($zip)): echo $zip; endif ?></li>
									</ul>
									<script type="text/javascript">
									  $(document).ready(function() {
									  
									  	var clientAddress = <?php echo json_encode($clients); ?>;
									  	var client_val = $('[name="client"]').val();
									  	var count = 0;
									    
									    function update_address(count, client_val) 
									    {
									    	if($.isNumeric(client_val)) {
									    		$('#contactName').html( clientAddress[count]['contact'] );
									    		$('#addressOne').html( clientAddress[count]['address_1'] );
									    		$('#addressTwo').html( clientAddress[count]['address_2'] );
									    		$('#cityStateZip').html( clientAddress[count]['city']+' '+clientAddress[count]['state']+' '+clientAddress[count]['zip'] );
									    		$('input[name="prefix"]').val(clientAddress[count]['default_inv_prefix']);
									    	} else {
									    		$('#contactName').html('');
									    		$('#addressOne').html('');
									    		$('#addressTwo').html('');
									    		$('#cityStateZip').html('');
									    	}
									    }
										    
											$('[name="client"]').on( "change", function() {
												var count = $(this)[0].selectedIndex;
												
											  client_val =  $( this ).val();
											  update_address(count, client_val);
											});
											
											update_address(count, client_val);
											
											$('input[name="prefix"]').val(clientAddress[count]['default_inv_prefix']);
										
										});
									</script>
									
								</div>
							</div>		
							
							<div class="medium-6 columns">
								<div class="ruled on-paper">
									<h5 class="caps">
											Invoice Num
									</h5>
									<div class="row">
										<div class="small-4 columns"><input type="text" name="prefix" placeholder="Prefix" maxlength="6" value="<?php echo($prefix); ?>"/></div>
										<div class="small-8 columns"><input type="text" name="invoice_num" placeholder="Invoice Number" value="<?php echo($inv_num); ?>"/></div>
									</div>
								</div>
								
								<div class="ruled on-paper sans-top">
									<h5 class="caps">
											Send Date
									</h5>
									<div class="row">
										<div class="small-3 columns">
											<?= $dob_dropdown_day ?>
										</div>
										<div class="small-5 columns">
											<?= $dob_dropdown_month ?>
										</div>
										<div class="small-4 columns">
											<?= $dob_dropdown_year ?>
										</div>
									</div>
									
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
				
				<section id="invoiceCreate">
					
					<div class="list_header row">
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
						<div class="small-12 medium-1 large-only-text-right columns remove">
							
						</div>
					</div>
					
					<div class="edit-list-container">
						<?php foreach ($item['items'] as $invoice_item): ?>
							<?php 
								$number = $invoice_item['quantity'] * $invoice_item['unit_cost']; 
								$sumTotal = $sumTotal + $number;
							?>
							<div class="row tabbed list no-rules">
								<div class="qty small-12 medium-2 columns">
									<input type="hidden" name="item_id[]" value="<?php echo $invoice_item['id'] ?>" /><input type="text" class="qty sum" name="qty[]" value="<?php echo $invoice_item['quantity'] ?>" />
								</div>
								<div class="description small-12 medium-5 columns">
									<input type="text" name="description[]" value="<?php echo $invoice_item['description'] ?>" />
								</div>
								<div class="price small-12 medium-2 columns">
									<input type="text" class="unitCost sum" name="unit_cost[]" value="<?php echo $invoice_item['unit_cost'] ?>" />
								</div>
								<div class="totalSum small-12 medium-2 large-only-text-right columns" data-totalsum="<?php echo number_format((float)$number, 2, '.', ''); ?>">
									$<?php echo number_format((float)$number, 2, '.', ','); ?>
								</div>
								<div class="delete small-12 medium-1 columns small-text-center large-only-text-right">
									<a href="<?php echo base_url(); ?>index.php/invoices/item_delete?id=<?php echo $invoice_item["id"].'&common_id='.$invoice_item["common_id"].'&iuid='.$item[0]['uid'];?>" id="remove-<?php echo $invoice_item["id"]; ?>" class="button small round">x</a>
								</div>
							</div>
						<?php endforeach ?>	
					</div>
				</section>
				
				<div class="row">
					<div class="large-12 columns text-left small-only-text-center">
						<a id="addItems" class="button small round">Add Another Item</a>
					</div>
				</div>
				
				<hr />
				<div class="row">
					<div class="large-12 columns small-only-text-center text-right">
						<h3>Total Due: <span id="invoiceTotal">$<?php echo number_format((float)$sumTotal, 2, '.', ',');?></span></h3>
					</div>
				</div>
				
			</div>
			
			<div class="row actions">
				<div class="large-12 columns text-right small-only-text-center">
					<input type="submit" name="submit" value="Save Changes" class="button round"/>
				</div>
				<div class="large-12 columns text-right small-only-text-center">
					<a href="#" id="deleteInvoiceBtn" data-reveal-id="editModal">Delete Invoice</a>
				</div>
			</div>
			
		</form>
	</div>
	</div>
</div>
<div class="row">
	<div class="small-12 medium-12 large-4 columns large-centered">
		<div id="editModal" class="reveal-modal small" data-reveal>
			<div class="row">
				<div class="small-10 columns text-center small-centered">
					<h3>Blimey!</h3>
					<h5>Are you sure you want to delete this invoice?</h5>
					<hr />
					<a id="cancelDeleteBtn" href="#" class="button round secondary">No Thanks</a>
					<?php echo anchor('invoices/delete_invoice/'.$item[0]['iid'], 'Delete It', 'class="button round"', 'id="delete-'.$item[0]['iid'].'"'); ?>
				</div>
			</div>
			<a class="close-reveal-modal">&#215;</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="small-12 medium-12 large-4 columns large-centered">
		<div id="clientModal" class="reveal-modal small" data-reveal>
			<div id="form-errors" class="alert-box round"></div>
			<div id="form-wrap"></div>
		</div>
	</div>
</div>