<div class="row">
  <div class="large-12 columns text-center">
  <h1>Clients</h1></div>
</div>

<?php
	if ($clients) { ?>
		<div class="row">
			<div class="large-12 columns text-center">
				<a href="<?php echo base_url(); ?>index.php/clients/create" class="button round">Add New Client</a>
			</div>
		</div>
		<div class="row">
			<div class="large-12 columns">
				<div class="invoice-list-wrap clearfix">
					<div class="invoice-list-inner-wrap">
						
						<div class="row invoice-create list_header">
							<div class="small-12 medium-4 large-4 columns">
								Company
							</div>
							<div class="small-12 medium-4 large-4 columns">
								Contact
							</div>
							<div class="small-12 medium-4 large-4 columns">
								Email
							</div>
						</div>
						
						
							<?php foreach ($clients as $client): ?>
								<div class="row invoice list">
									<div class="small-12 small-only-text-center medium-4 large-4 columns">
										<input type="hidden" value="<?php echo $client['id']?>" /><a href="<?php echo base_url(); ?>index.php/clients/edit/<?php echo $client['id']; ?>"><?php echo $client['company'] ?></a>
									</div>
									<div class="small-12 small-only-text-center medium-4 large-4 columns">
										<?php echo $client['contact'] ?>
									</div>
									<div class="small-12 small-only-text-center medium-4 large-4 columns">
										<a href="mailto:<?php echo $client['email'] ?>"><?php echo $client['email'] ?></a>
									</div>
								</div>
							<?php endforeach ?>
						
					</div>
				</div>		
			</div>
		</div>
<?php	} else { ?>
	<div class="row">
		<div class="large-12 columns text-center">
			<h5>No clients yet? No worries mate, just add a few and you'll be good to go!</h5>
			<a href="<?php echo base_url(); ?>index.php/clients/create" class="button round">Add New Client</a>
		</div>
	</div>	
<?php	}
?>		