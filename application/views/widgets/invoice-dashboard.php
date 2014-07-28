<?php
	
	setlocale(LC_MONETARY, 'en_US');
	$drafts_sum = 0;
	$due_sum = 0;
	$paid_sum = 0;
	//var_dump($invoices);
	
	function filter_drafts($var)
	{
	    return (is_array($var) && $var['status'] == 0);
	}
	
	function filter_due($var)
	{
	    return (is_array($var) && $var['status'] == 4);
	}
	function filter_pay($var)
	{
	    return (is_array($var) && $var['status'] == 3);
	}
	
	$filtered_drafts = array_filter($invoices, "filter_drafts");
	$filtered_due = array_filter($invoices, "filter_due");
	$filtered_paid = array_filter($invoices, "filter_pay");
	
	foreach ($filtered_drafts as $k) {
	  $drafts_sum+=$k['amount'];
	}
	
	foreach ($filtered_due as $k) {
	  $due_sum+=$k['amount'];
	}
	
	foreach ($filtered_paid as $k) {
	  $paid_sum+=$k['amount'];
	}
?>
<section class="dashboard purple">
	<div class="row">
		
		<div class="columns medium-3 medium-offset-3 small-only-text-center">
			<section class="">
				<span class="label">Uninvoiced</span>
				<h3><?php echo(money_format('%.2n', $drafts_sum)); ?></h3>
			</section>
		</div>
		
		<div class="columns medium-3 small-only-text-center">
			<section class="">
				<span class="label">Invoices Overdue</span>
				<h3><?php echo(money_format('%.2n', $due_sum)); ?></h3>
			</section>
		</div>
		
		<div class="columns medium-3 small-only-text-center">
			<section class="">
				<span class="label">Invoices Paid</span>
				<h3><?php echo(money_format('%.2n', $paid_sum)); ?></h3>
			</section>
		</div>
		
	</div>
</section>