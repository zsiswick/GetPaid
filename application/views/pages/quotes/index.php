<?php
	$this->load->helper('currency_helper');
	$currency = currency_method($quotes[0]['currency']);
	//print("<pre>".print_r($quotes,true)."</pre>");
?>

<?php
	if ($quotes) { ?>


	 <div class="row">

	 	<div class="large-12 columns text-center">
	 		<h1>Quotes</h1>
	 		<div class="row">
	 			<div class="medium-3 medium-centered columns">
 					<div id="plus-button" class="svg-container">
 						<a href="<?php echo base_url(); ?>index.php/quotes/create" class="plus-button">
	 						<svg version="1.1" viewBox="0 0 100 100" class="svg-content">
	 						<path fill-rule="evenodd" clip-rule="evenodd" fill="#fff" d="M50,0C22.4,0,0,22.4,0,50s22.4,50,50,50s50-22.4,50-50S77.6,0,50,0
	 							z M68.6,51.8H51.5v17.4c0,0.8-0.7,1.5-1.5,1.5s-1.5-0.7-1.5-1.5V51.8H30.6c-0.8,0-1.5-0.7-1.5-1.5s0.7-1.5,1.5-1.5h17.9V31.2
	 							c0-0.8,0.7-1.5,1.5-1.5s1.5,0.7,1.5,1.5v17.6h17.1c0.8,0,1.5,0.7,1.5,1.5S69.4,51.8,68.6,51.8z"/>
	 						</svg>
 						</a>
 					</div>
	 			</div>
	 		</div>

	 	</div>
	 </div>
	 <div id="invoiceList" class="row light-bg invoice-form">
	 	<div class="large-12 columns">
	 		<div class="row">
	 			<div class="large-12 columns text-center large-text-left">
	 				<h3>
	 					Recent Quotes
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

	 		<?php foreach ($quotes as $quote_item): ?>


			<div class="tabbed list clearfix">
				<div class="small-12 small-only-text-center medium-2 large-2 columns invoice-id">
					<a href="<?php echo base_url(); ?>index.php/quotes/view/<?php echo $quote_item['iid']; ?>" class="button round small">#<?php echo $quote_item['iid'];?></a>
				</div>
				<div class="small-12 small-only-text-center medium-2 large-2 columns date">
					<?php echo $quote_item['pdate']; ?>
				</div>
				<div class="small-12 small-only-text-center medium-4 large-4 columns client">
					<?php echo $quote_item['company']; ?>
				</div>
				<div class="small-12 small-only-text-center medium-2 large-2 columns text-right amount">
					<?= $currency ?><?php echo number_format((float)$quote_item['amount'], 2, '.', ',');?>
				</div>
				<div class="small-12 small-only-text-center medium-2 large-2 columns text-right status">
					<span class="label secondary round"><?php echo($quote_flags[$quote_item['status']]);?></span>
				</div>
			</div>

		<?php endforeach ?>

	 	</div>
	 </div>
<?php	} else { ?>
	<div class="row">
		<div class="large-12 columns text-center">
			<h1>Quotes</h1>
			<h4>Looks like you haven't created any quotes yet...</h4>
			<div id="plus-button" class="svg-container">
				<a href="<?php echo base_url(); ?>index.php/quotes/create" class="plus-button">
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
