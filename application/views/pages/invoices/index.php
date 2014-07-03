<?php setlocale(LC_MONETARY, 'en_US'); ?>
<div class="row">
  <div class="large-12 columns text-center"><h1><?php echo $username; ?>'s Invoices</h1></div>
</div>

<?php
	if ($invoices) { ?>
	 <div class="row">
	 	<div class="large-12 columns text-center">
	 		<a href="<?php echo base_url(); ?>index.php/invoices/create" class="button">Create New Invoice</a>
	 	</div>
	 </div>
	 <div class="row">
	 	<div class="large-12 columns">
	 		<table class="invoice-list">
	 		<thead>
	 			<tr>
	 				<th width="200"></th>
	 				<th>Date</th>
	 				<th width="150">Client</th>
	 				<th width="150" class="text-right">Amount</th>
	 				<th class="text-right">Status</th>
	 			</tr>
	 		</thead>
	 		<tbody>
	 			<?php foreach ($invoices as $invoice_item): ?>
	 				<tr>
	 					<td><a href="<?php echo base_url(); ?>index.php/invoices/view/<?php echo $invoice_item['iid']; ?>">#<?php echo $invoice_item['iid'];?></a></td>
	 					<td><?php echo $invoice_item['pdate']; ?></td>
	 					<td><?php echo $invoice_item['client']; ?></td>
	 					<td class="text-right"><?php echo money_format('%.2n', $invoice_item['amount']); ?></td>
	 					<td class="text-right"><?php echo $invoice_item['status']; ?></td>
	 				</tr>
	 			<?php endforeach ?>
	 		</tbody>
	 		</table>
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
