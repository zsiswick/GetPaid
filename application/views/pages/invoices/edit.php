<?php 
	 
	$id = $item['client'][0]['id'];
	$company = $item['client'][0]['company'];
	$address_1 = $item['client'][0]['address_1'];
	$address_2 = $item['client'][0]['address_2'];
	$city = $item['client'][0]['city'];
	$state = $item['client'][0]['state'];
	$zip = $item['client'][0]['zip'];
	$prefix = $item[0]['prefix'];
	$inv_num = $item[0]['inv_num'];
	$date = $item[0]['date'];
	$due_date = $item[0]['due_date'];
	
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
			$attributes = array('class' => 'invoice-form light-bg', 'data-abide'=>'');
			$hidden = array('iid' => $item[0]['iid'], 'new_client' => 0);
			echo form_open('invoices/edit/'.$item[0]['iid'], $attributes, $hidden);
			
		?>
		<?php $sumTotal = 0 ?>
		
		<div class="invoice-list-wrap">
			<div class="clearfix">
				
				<div class="row invoice-info">
					<div class="medium-5 small-centered large-uncentered columns invoice-info">
							<?php if(!empty($logo)): echo'<img class="company-logo" src="'.base_url().'uploads/logo/'.$this->tank_auth_my->get_user_id()."/".$logo.'" />'; endif ?>
						<p>
							<?php if(!empty($company_name)): echo '<h3>'.$company_name.'<h3/>'; endif ?>
							
						</p>
					</div>
					<div class="large-7 small-centered large-uncentered columns">
						<div class="row">
						
							<div class="large-12 columns text-right small-only-text-left">
								<h4 class="caps">Invoice <?php echo($status_flags[$item[0]['status']]);?></h4>
							</div>
							
							<div class="medium-6 columns">
								
									<h5 class="caps ruled on-paper">
											Billing Information
									</h5>
									<div class="info-block last">
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
											echo form_dropdown('client', $clientList, $id);
										} else {
											echo anchor('clients/create', 'Add a Client', 'class="button round"', 'id="addClient"');
										}
									?>
									
									<ul id="client_data">
										<li id="contactName"><?php echo $item['client'][0]['contact']; ?></li>
										<li id="addressOne"><?php if(!empty($address_1)): echo $address_1.'<br/>'; endif ?></li>
										<li id="addressTwo"><?php if(!empty($address_2)): echo $address_2.'<br/>'; endif ?></li>
										<li id="cityStateZip"><?php if(!empty($city)): echo $city.' '; endif ?> <?php if(!empty($state)): echo $state.' '; endif ?> <?php if(!empty($zip)): echo $zip; endif ?></li>
									</ul>
									<script type="text/javascript">
									  $(document).ready(function() {
									  
									  	var baseurl = window.location.protocol + "//" + window.location.host + "/" + "rubyinvoice/";
									  	var client_data = <?php echo json_encode($clients); ?>;
									  	var client_val = $('[name="client"]').val();
									  	var count = 0;
									  	var invoice_num = "<?php echo($inv_num); ?>";
									  	
									  	function update_address(count, client_val) 
									    {
									    	//alert(client_data[client_val]['contact']);
									    	
									    	if($.isNumeric(client_val)) {
									    		$('#contactName').html( client_data[count]['contact'] );
									    		$('#addressOne').html( client_data[count]['address_1'] );
									    		$('#addressTwo').html( client_data[count]['address_2'] );
									    		$('#cityStateZip').html( client_data[count]['city']+' '+client_data[count]['state']+' '+client_data[count]['zip'] );
									    		$('input[name="prefix"]').attr('value', client_data[count]['default_inv_prefix']);
									    		
									    		
									    		$.get( baseurl+"index.php/invoices/get_invoice_number/"+client_data[count]['id'], function( data ) {
										    		obj = JSON.parse(data);
										    		
										    		if (<?php echo($id)?> == client_data[count]['id']) { // first check if the client selected is the original one assigned to the invoice so a new invoice number isn't used. That would be confusing.
								    		    	$('input[name="invoice_num"]').attr('value', invoice_num);
								    		    	$('input[name="new_client"]').attr('value', 0);
								    		    } else {
								    		    	$('input[name="invoice_num"]').attr('value', obj.inv_num);
								    		    	$('input[name="new_client"]').attr('value', 1);
								    		    }
									    		});
									    		
									    		 
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
											
											$('#send-date, #due-date').pickadate({
											    formatSubmit: 'yyyy-mm-dd',
											    hiddenName: true,
											    today: 'today',
											    clear: 'Clear selection'
											});
											
											
											
										});
									</script>
									
								</div>
							</div>		
							
							<div class="medium-6 columns">
									<h5 class="caps ruled on-paper">
											Invoice Num
									</h5>
									<div class="info-block">
									<div class="row">
										<div class="small-4 columns"><input type="text" name="prefix" placeholder="Prefix" maxlength="6" value="<?php echo($prefix); ?>"/></div>
										<div class="small-8 columns"><input type="text" name="invoice_num" placeholder="Invoice Number" value="<?php echo($inv_num); ?>"/></div>
									</div>
								</div>
									<h5 class="caps ruled on-paper">
											Creation Date
									</h5>
									<div class="info-block">
									<div class="row">
										<div class="small-12 columns">
											<input type="text" id="send-date" name="send-date" data-value="<?php echo($date) ?>" required />
											<small class="error">Creation date is required.</small>
										</div>
									</div>
								</div>
									<h5 class="caps ruled on-paper">
										Due Date
									</h5>
									<div class="info-block last">
										<div class="row">
											<div class="small-12 columns">
												<input type="text" id="due-date" name="due-date" data-value="<?php echo($due_date) ?>" required />
												<small class="error">Due date is required.</small>
											</div>
										</div>
									</div>
							</div>
						</div>
					</div>
				</div>
				<h3 class="small-only-text-center top-rule">Invoice Items</h3>
				<section id="invoiceCreate">
					
					<div class="list_header clearfix">
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
							<div class="small-12 medium-1 large-only-text-right columns remove">
								
							</div>
						</div>
						
					</div>
					
					<div class="edit-list-container">
						<div class="tabbed list no-rules">
							<?php foreach ($item['items'] as $invoice_item): ?>
								<?php 
									$number = $invoice_item['quantity'] * $invoice_item['unit_cost']; 
									$sumTotal = $sumTotal + $number;
								?>
								<div class="row">
									<div class="qty small-12 medium-2 columns">
										<input type="hidden" name="item_id[]" value="<?php echo $invoice_item['id'] ?>" /><input type="text" class="qty sum" name="qty[]" value="<?php echo $invoice_item['quantity'] ?>" />
										<small class="error">Quantity is required.</small>
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
									<div class="small-12 columns"><hr /></div>
								</div>
							<?php endforeach ?>	
						</div>
						
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