<div class="row">
  <div class="large-12 columns text-center"><h1><?php echo $first_name; ?>'s Clients</h1></div>
</div>
<div class="row">
	<div class="large-12 columns text-center">
		<a href="<?php echo base_url(); ?>index.php/clients/create" class="button round">Add New Client</a>
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
			<?php foreach ($clients as $client): ?>
				<tr>
					<td><input type="hidden" value="<?php echo $client['id']?>" /><a href="<?php echo base_url(); ?>index.php/clients/edit/<?php echo $client['id']; ?>"><?php echo $client['company'] ?></a></td>
					<td><?php echo $client['contact'] ?></td>
					<td><a href="mailto:<?php echo $client['email'] ?>"><?php echo $client['email'] ?></a></td>
				</tr>
			<?php endforeach ?>
		</tbody>
		</table>
	</div>
</div>