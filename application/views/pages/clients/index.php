<?php
	if ($clients) { ?>
		<section class="">
			<div class="row">
			  <div class="large-12 columns text-center">
			  <h1>Clients</h1></div>
			</div>
		</section>
		
		<div class="row">
			<div class="large-12 columns text-center">
				<p><a href="<?php echo base_url(); ?>index.php/clients/create" class="plus-button">
					<svg width="100" height="100" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
						 viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
					<path fill-rule="evenodd" clip-rule="evenodd" fill="#D3E6E9" d="M50,0C22.4,0,0,22.4,0,50s22.4,50,50,50s50-22.4,50-50S77.6,0,50,0
						z M68.6,51.8H51.5v17.4c0,0.8-0.7,1.5-1.5,1.5s-1.5-0.7-1.5-1.5V51.8H30.6c-0.8,0-1.5-0.7-1.5-1.5s0.7-1.5,1.5-1.5h17.9V31.2
						c0-0.8,0.7-1.5,1.5-1.5s1.5,0.7,1.5,1.5v17.6h17.1c0.8,0,1.5,0.7,1.5,1.5S69.4,51.8,68.6,51.8z"/>
					</svg>
				</a></p>
			</div>
		</div>
		<div class="row">
			<div class="large-12 columns">
				<div class="clearfix">
					<div class="">
						
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
								<div class="row tabbed list">
									<div class="small-12 small-only-text-center medium-4 large-4 columns">
										<input type="hidden" value="<?php echo $client['id']?>" /><a href="<?php echo base_url(); ?>index.php/clients/edit/<?php echo $client['id']; ?>" class="button round small light"><?php echo $client['company'] ?></a>
									</div>
									<div class="small-12 small-only-text-center medium-4 large-4 columns">
										<?php echo $client['contact'] ?>
									</div>
									<div class="small-12 small-only-text-center medium-4 large-4 columns">
										<a href="mailto:<?php echo $client['email'] ?>" class=""><?php echo $client['email'] ?></a>
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
	  <h1>Clients</h1></div>
	</div>
	<div class="row">
		<div class="large-12 columns text-center">
			<h5>No clients yet? No worries mate, just add a few and you'll be good to go!</h5>
			<a href="<?php echo base_url(); ?>index.php/clients/create" class="button round">Add New Client</a>
		</div>
	</div>	
<?php	}
?>		