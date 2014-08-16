<?php 
	setlocale(LC_MONETARY, 'en_US'); 
	//print("<pre>".print_r($invoices,true)."</pre>");
?>

<?php
	if ($invoices) { ?>
	
	
	 <div class="row">
	 	<div class="large-12 columns text-center">
	 		<div class="row">
	 		  <div class="large-12 columns text-center"><h1>Invoices</h1></div>
	 		</div>
	 		<div class="row">
	 			<div class="medium-3 medium-centered columns">
 					<div id="plus-button" class="svg-container">
 						<a href="<?php echo base_url(); ?>index.php/invoices/create" class="plus-button">
	 						<svg version="1.1" viewBox="0 0 100 100" class="svg-content">
	 						<path fill-rule="evenodd" clip-rule="evenodd" fill="#fff" d="M50,0C22.4,0,0,22.4,0,50s22.4,50,50,50s50-22.4,50-50S77.6,0,50,0
	 							z M68.6,51.8H51.5v17.4c0,0.8-0.7,1.5-1.5,1.5s-1.5-0.7-1.5-1.5V51.8H30.6c-0.8,0-1.5-0.7-1.5-1.5s0.7-1.5,1.5-1.5h17.9V31.2
	 							c0-0.8,0.7-1.5,1.5-1.5s1.5,0.7,1.5,1.5v17.6h17.1c0.8,0,1.5,0.7,1.5,1.5S69.4,51.8,68.6,51.8z"/>
	 						</svg>
 						</a>
 					</div>
	 			</div>
	 		</div>
	 		
	 		<?php $this->load->view('widgets/invoice-dashboard');?>
	 	</div>
	 </div>
	 <div id="invoiceList" class="row">
	 	<div class="large-12 columns">
	 		<div class="row">
	 			<div class="large-12 columns text-center large-text-left">
	 				<h3 class="top-rule">
	 					Recent Invoices
	 				</h3>
	 			</div>
	 		</div>
	 		
	 		<div class="invoice-create list_header clearfix">
	 			
	 				<div class="small-12 medium-2 columns invoice-id">
	 					ID
	 				</div>
	 				<div class="small-12 medium-2 columns date">
	 					Created
	 				</div>
	 				<div class="small-12 medium-4 large-4 columns client">
	 					Client
	 				</div>
	 				<div class="small-12 medium-2 large-2 columns text-right amount">
	 					Amount
	 				</div>
	 				<div class="small-12 medium-2 large-2 columns text-center status">
	 					Status
	 				</div>
	 		</div>
	 		
	 				
	 				
	 				
	 				<?php foreach ($invoices as $invoice_item): ?>
		 			
		 			<?php 
		 				// Get comma delimited payments and put them into an array so we can find the sum of their amount
		 				$path = explode(",", $invoice_item['ipayments']);
		 				$exp = array_merge($path);
		 				$sum = array_sum( $exp );
		 				$percent = ($sum / $invoice_item['amount']) * 100;
		 			?>
		 			<div class="tabbed list clearfix">
		 				<div class="small-12 small-only-text-center medium-2 large-2 columns invoice-id">
		 					<a href="<?php echo base_url(); ?>index.php/invoices/view/<?php echo $invoice_item['iid']; ?>" class="button round small light">#<?php echo $invoice_item['iid'];?></a>
		 				</div>
		 				<div class="small-12 small-only-text-center medium-2 large-2 columns date">
		 					<?php echo $invoice_item['pdate']; ?>
		 				</div>
		 				<div class="small-12 small-only-text-center medium-4 large-4 columns client">
		 					<?php echo $invoice_item['company']; ?>
		 				</div>
		 				<div class="small-12 small-only-text-center medium-2 large-2 columns text-right amount">
		 					<?php echo money_format('%.2n', $invoice_item['amount']); ?>
		 				</div>
		 				<div class="small-12 small-only-text-center medium-2 large-2 columns text-right status">
		 				
		 					<?php 
		 					// Display additional information for partial payment status
		 					if ($invoice_item['status'] == 2) { ?>
		 						<div class="progress round">
		 							<span class="progress-label has-tip" data-tooltip title="<?php echo(money_format('%.2n', $sum));?> Paid"><?php echo(round($percent).'%');?></span>
		 						  <span class="meter" style="width:<?php echo(round($percent).'%');?>"></span>
		 						</div>
		 					<?php } else { ?>
		 						
		 						<?php 
			 						if ($invoice_item['status'] == 4) { // Invoice Due
			 						
			 							echo('<span class="round alert label">'.$status_flags[$invoice_item['status']].'</span>');
			 						
			 						}	else if ($invoice_item['status'] == 3) {?> 
			 						
				 						<div class="progress round">
				 							<span class="progress-label"><?php echo($status_flags[$invoice_item['status']]);?></span>
				 						  <span class="meter complete" style="width:<?php echo(round($percent).'%');?>"></span>
				 						</div>
			 						<?php
			 						} else if	($invoice_item['status'] == 0){ // Invoice Draft
			 							echo('<span class="round secondary label">'.$status_flags[$invoice_item['status']].'</span>');
			 						} else if ($invoice_item['status'] == 1) { ?>
			 								<div class="progress round">
			 									<span class="progress-label"><?php echo($status_flags[$invoice_item['status']]);?></span>
			 								  <span class="meter complete" style="width: 0%;"></span>
			 								</div>
			 						<?php }  
		 						
		 					 	} ?>
		 				</div>
		 			</div>
		 			
		 		<?php endforeach ?>
	 		
	 		
	 		
	 	</div>
	 </div>
<?php	} else { ?>
	<div class="row">
		<div class="large-12 columns text-center">
			<h4>Looks like you're new around town...</h4>
			<div id="plus-button" class="svg-container">
				<a href="<?php echo base_url(); ?>index.php/invoices/create" class="plus-button">
					<svg version="1.1" viewBox="0 0 100 100" class="svg-content">
					<path fill-rule="evenodd" clip-rule="evenodd" fill="#fff" d="M50,0C22.4,0,0,22.4,0,50s22.4,50,50,50s50-22.4,50-50S77.6,0,50,0
						z M68.6,51.8H51.5v17.4c0,0.8-0.7,1.5-1.5,1.5s-1.5-0.7-1.5-1.5V51.8H30.6c-0.8,0-1.5-0.7-1.5-1.5s0.7-1.5,1.5-1.5h17.9V31.2
						c0-0.8,0.7-1.5,1.5-1.5s1.5,0.7,1.5,1.5v17.6h17.1c0.8,0,1.5,0.7,1.5,1.5S69.4,51.8,68.6,51.8z"/>
					</svg>
				</a>
			</div>
		</div>
	</div>	
<?php	}
?>