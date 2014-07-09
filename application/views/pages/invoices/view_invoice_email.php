<div class="row">
	<div class="small-12 columns">
		<h4 class="text-center">The invoice will be sent to:</h4>
		<h5 class="text-center"><?php echo($item['client'][0]['contact']);?> (<?php echo($item['client'][0]['email'])?>)</h5>
		<?php
			$hidden = array('client_email' => $item['client'][0]['email']);
			$attributes = array('class' => 'invoice-form', 'id' => 'sendInvoiceEmail');
			echo form_open('invoices/send_invoice_email/'.$item[0]['iid'], $attributes, $hidden); 
		?>
		<input type="text" name="emailSubject" value="New Invoice #<?php echo($item[0]['iid']);?> from <?php echo($first_name);?>" />
		 <textarea name="emailMessage" id="" cols="30" rows="15">Hello <?php echo($item['client'][0]['contact']);?>,&#013;
		 
There is a new invoice ready for you for $<?php echo($item[0]['amount']);?>.&#013;
You can view the invoice online at:&#013;

<?php echo base_url(); ?>index.php/invoices/view/<?php echo $item[0]['iid']?>&#013;

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