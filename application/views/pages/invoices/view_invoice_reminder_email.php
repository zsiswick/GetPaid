<?php 
	$date = new DateTime($item[0]['due_date']);
?>
<div class="row">
	<div class="small-12 columns">
		<h4 class="text-center">The invoice Reminder will be sent to:</h4>
		<h5 class="text-center"><?php echo($item['client'][0]['contact']);?> (<?php echo($item['client'][0]['email'])?>)</h5>
		<?php
			$hidden = array('client_email' => $item['client'][0]['email']);
			$attributes = array('class' => 'invoice-form', 'id' => 'sendInvoiceEmail');
			echo form_open('invoices/send_invoice_email/'.$item[0]['iid'], $attributes, $hidden); 
		?>
		<label for="emailSubject">Subject</label>
		<input type="text" name="emailSubject" value="Reminder: Invoice #<?php echo($item[0]['iid']);?> from <?php echo($first_name);?>" />
		<label for="emailMessage">Message</label>
		<textarea name="emailMessage" id="" cols="30" rows="15">Hello <?php echo($item['client'][0]['contact']);?>,&#013;
		 
Just a reminder that invoice #<?php echo($item[0]['iid']);?> was due on <?php echo ($date->format('F j, Y'));?>.&#013;Please make a payment of $<?php echo($item[0]['amount']);?> as soon as possible.&#013;&#013;
You can view the invoice online at:&#013;
<?php echo base_url(); ?>index.php/invoice/view/<?php echo $item[0]['iid']."/".$item['client'][0]['key']?>&#013;

Best regards,&#013; 

<?php echo($first_name);?> 


<?php echo($item['settings'][0]['company_name']);?>
	 </textarea>
	 <div class="row">
	 	<div class="small-12 columns text-center">
	 		<input type="submit" name="submit" value="Send Invoice" class="button small round"/>	
	 	</div>
	 </div>
	 
	 </form>
	</div>
</div>
<a class="close-reveal-modal">&#215;</a>