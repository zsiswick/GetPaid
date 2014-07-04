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
	 				<ul class="list_header clearfix">
	 					<li class="invoice-id">ID</li>
	 					<li class="date">Date</li>
	 					<li class="client">Client</li>
	 					<li class="amount">Amount</li>
	 					<li class="status">Status</li>
	 				</ul>
	 				<?php foreach ($invoices as $invoice_item): ?>
	 			<ul class="invoice-list clearfix">
	 				<li class="invoice-id"><a href="<?php echo base_url(); ?>index.php/invoices/view/<?php echo $invoice_item['iid']; ?>">#<?php echo $invoice_item['iid'];?></a></li>
	 				<li class="date"><?php echo $invoice_item['pdate']; ?></li>
	 				<li class="client"><?php echo $invoice_item['client']; ?></li>
	 				<li class="amount"><?php echo money_format('%.2n', $invoice_item['amount']); ?></li>
	 				<li class="status"><span class="round alert label">STATUS</span></li>
	 			</ul>
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
