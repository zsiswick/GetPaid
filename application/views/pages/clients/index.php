<?php
	if ($clients) { ?>
		<section>
			<div class="row">
			  <div class="large-12 columns text-center">
			  <h1>Clients</h1></div>
			</div>
		</section>
		
		
		
		<div class="row">
			<div class="medium-3 medium-centered text-center columns">
				<div id="plus-button" class="svg-container">
					<a href="<?php echo base_url(); ?>index.php/clients/create" class="plus-button">
						<svg version="1.1" viewBox="0 0 100 100" class="svg-content">
						<path fill-rule="evenodd" clip-rule="evenodd" fill="#fff" d="M50,0C22.4,0,0,22.4,0,50s22.4,50,50,50s50-22.4,50-50S77.6,0,50,0
							z M68.6,51.8H51.5v17.4c0,0.8-0.7,1.5-1.5,1.5s-1.5-0.7-1.5-1.5V51.8H30.6c-0.8,0-1.5-0.7-1.5-1.5s0.7-1.5,1.5-1.5h17.9V31.2
							c0-0.8,0.7-1.5,1.5-1.5s1.5,0.7,1.5,1.5v17.6h17.1c0.8,0,1.5,0.7,1.5,1.5S69.4,51.8,68.6,51.8z"/>
						</svg>
					</a>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="large-12 columns">
				<div class="form-wrap invoice-form light-bg">
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
										<input type="hidden" value="<?php echo $client['id']?>" /><a href="<?php echo base_url(); ?>index.php/clients/edit/<?php echo $client['id']; ?>" class="button round small"><?php echo $client['company'] ?></a>
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
			<h4>No clients yet? No worries, just add a few and you'll be good to go!</h4>
			<a href="<?php echo base_url(); ?>index.php/clients/create" class="button round light">Add New Client</a>
		</div>
	</div>	
<?php	}
?>		