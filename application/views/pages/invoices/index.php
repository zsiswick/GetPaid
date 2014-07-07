<?php setlocale(LC_MONETARY, 'en_US'); ?>
<div class="row">
  <div class="large-12 columns text-center"><h1><?php echo $username; ?>'s Invoices</h1></div>
</div>

<?php
	if ($invoices) { ?>
	 <div class="row">
	 	<div class="large-12 columns text-center">
	 		<a href="<?php echo base_url(); ?>index.php/invoices/create" class="button round">Create New Invoice</a>
	 	</div>
	 </div>
	 <div class="row">
	 	<div class="large-12 columns">
	 		<div class="invoice-list-wrap clearfix">
	 			<div class="invoice-list-inner-wrap">
	 				
	 				<div id="invoiceCreate" class="row invoice-create list_header">
	 					<div class="small-12 medium-1 large-1 columns invoice-id">
	 						ID
	 					</div>
	 					<div class="small-12 medium-3 large-3 columns date">
	 						Date
	 					</div>
	 					<div class="small-12 medium-4 large-4 columns client">
	 						Client
	 					</div>
	 					<div class="small-12 medium-2 large-2 columns text-right amount">
	 						Amount
	 					</div>
	 					<div class="small-12 medium-2 large-2 columns text-right status">
	 						Status
	 					</div>
	 				</div>
	 				
	 				<?php foreach ($invoices as $invoice_item): ?>
		 			
		 			<div class="row invoice list">
		 				<div class="small-12 small-only-text-center medium-1 large-1 columns invoice-id">
		 					<a href="<?php echo base_url(); ?>index.php/invoices/view/<?php echo $invoice_item['iid']; ?>">#<?php echo $invoice_item['iid'];?></a>
		 				</div>
		 				<div class="small-12 small-only-text-center medium-3 large-3 columns date">
		 					<?php echo $invoice_item['pdate']; ?>
		 				</div>
		 				<div class="small-12 small-only-text-center medium-4 large-4 columns client">
		 					<?php echo $invoice_item['client']; ?>
		 				</div>
		 				<div class="small-12 small-only-text-center medium-2 large-2 columns text-right amount">
		 					<?php echo money_format('%.2n', $invoice_item['amount']); ?>
		 				</div>
		 				<div class="small-12 small-only-text-center medium-2 large-2 columns text-right status">
		 					<span class="round alert label">STATUS</span>
		 				</div>
		 			</div>
		 			
		 		<?php endforeach ?></div>
	 		</div>
	 		
	 		
	 	</div>
	 </div>
<?php	} else { ?>
	<div class="row">
		<div class="large-12 columns text-center">
			<h5>Hey! Looks like you're new here...</h5>
			<a href="<?php echo base_url(); ?>index.php/invoices/create" class="button">Create New Invoice</a>
		</div>
	</div>	
<?php	}
?>
