<div class="row">
  <div class="large-12 columns text-center"><h1><?php echo $first_name; ?>'s Clients</h1></div>
</div>
<div class="row">
	<div class="large-12 columns text-right">
		<a href="<?php echo base_url(); ?>index.php/clients/create" class="button">Add New Client</a>
	</div>
</div>
<div class="row">
	<div class="large-12 columns">
		<table class="invoice-list">
		<thead>
			<tr>
				<th>Company</th>
				<th>Contact</th>
				<th>Email</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($clients as $invoice_item): ?>
				<tr>
					<td><?php echo $invoice_item['company'] ?></td>
					<td><?php echo $invoice_item['contact'] ?></td>
					<td><a href="mailto:<?php echo $invoice_item['email'] ?>"><?php echo $invoice_item['email'] ?></a></td>
				</tr>
			<?php endforeach ?>
		</tbody>
		</table>
	</div>
</div>