<div class="row">
	<div class="small-12 columns">
		<h3 class="small-only-text-center top-rule">Quote Actions</h3>
		<div class="row">
			<div class="medium-4 columns">
				<h5 class="ruled caps">
					Edit
				</h5>
				<div class="info-block">
					<a href="<?php echo base_url()?>index.php/quotes/edit/<?php echo $quote[0]['iid']?>" class="button small round light">Edit Quote</a>
				</div>
				
			</div>
			<div class="medium-4 columns">
				
				<h5 class="ruled caps">
					Send
				</h5>
				
				<div class="info-block">
					<a href="#" data-reveal-id="emailModal" class="button small round light">Send Quote</a>
				</div>
				
			</div>
			<div class="medium-4 columns">
				
				<h5 class="ruled caps">
					Permalink
				</h5>
				<div class="info-block">
					<a href="<?php echo base_url(); ?>index.php/quotes/review/<?php echo $quote[0]['iid']?>/<?php echo $quote[0]['key']?>" class="button round small light">View</a>
				</div>
				
			</div>
		</div>
	</div>	
</div>
