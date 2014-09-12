

<div class="row">
	<div class="columns small-12 large-6 small-centered">
		<?php 
			$attributes = array('class' => 'invoice-form light-bg', 'data-abide'=>'');
			echo form_open('invoices/create_timer/', $attributes);
		?>
		
		<div class="tabbed list no-rules">
			<div class="row">
				<div class="small-12 columns">
					<?php 
						if ($settings) {
							// Map select option values to the list of clients available
							$clientList = array_map(function ($ar) {
								return $ar['company'];
							}, $settings);
							$clientID = array_map(function ($ar) {
								return $ar['id'];
							}, $settings);
							$clientList = array_combine($clientID, $clientList);
							$clientList['add_new_client'] = 'Add New Client';
							echo form_dropdown('client', $clientList, 1);
						} else {
							//echo anchor('clients/create', 'Add a Client', 'class="button round"', 'id="addClient"');
							$clientList = array('choose' => 'Choose...', 'add_new_client' => 'Add New Client');
							$attributes = 'required="" type="number"';
							echo form_dropdown('client', $clientList, 1, $attributes);
						}
					?>
				</div>
				<div class="small-12 columns">
					<label for="">Date</label>
					<input type="text" id="date" name="date" data-value="<?php echo( date('Y-m-d')); ?>" required />
				</div>
				<div class="small-12 columns">
					<label for="">Description</label>
					<textarea type="text" id="description" name="description"></textarea>
				</div>
			</div>
			<input type="text" class="timer" placeholder="0 sec"/>
		<a id="toggleCron" class="button small round">Start Timer</a>
		</form>
	</div>
</div>

<script type="text/javascript">
	
	// place this before all of your code, outside of document ready.
	$.fn.clicktoggle = function(a, b) {
	    return this.each(function() {
	        var clicked = false;
	        $(this).bind("click", function() {
	            if (clicked) {
	                clicked = false;
	                return b.apply(this, arguments);
	            }
	            clicked = true;
	            return a.apply(this, arguments);
	        });
	    });
	};
	
	function odd() {
	    $('.timer').timer("pause");
	    $(this).text("Start Timer");
	}
	
	function even() {
	    $('.timer').timer("resume");
	    $(this).text("Pause Timer");
	}
	
	$(document).ready(function() {
		$('#date').pickadate({
		    formatSubmit: 'yyyy-mm-dd',
		    hiddenName: true,
		    today: 'today',
		    clear: 'Clear selection'
		});
		
		$("#toggleCron").clicktoggle(even, odd);
	});
</script>