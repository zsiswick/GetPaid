	<?php 
		$this->load->helper('dob');
		$invoicAmount = $item[0]['amount']; 
		$amount = 0;
		$hidden = array('iid' => $item[0]['iid']); 
	?>
	
	<?php 
		foreach ($item['payments'] as $payments){
			$number = $payments['payment_amount'];	
			$amount = $amount + $number;
		}
	?>

	<?php
		$attributes = array('class' => 'invoice-form', 'id' => 'addPayment');
		echo form_open('invoices/view/'.$item[0]['iid'], $attributes, $hidden); 
	?>
		<div class="row">
		<div class="columns large-12">
			<div id="form-errors" class="alert-box alert round"></div>
			<label for="payment_amount[]">Amount</label>
			<input class="" type="text" id="pamount" name="pamount" value="<?php echo(number_format((float)($invoicAmount - $amount), 2, '.', '')); ?>"/>
		</div>
			<div class="columns large-12">
				<label>Date:</label>
			</div>
			<div class="columns large-3 small-3">
				<?php echo $dob_dropdown_day; ?>
			</div>
			<div class="columns large-5 small-5">
				<?php echo $dob_dropdown_month; ?>
			</div>
			<div class="columns large-4 small-4">
				<?php echo$dob_dropdown_year; ?>
			</div>
		<div class="columns large-12">
			<input type="submit" name="submit" value="Add Payment" class="button"/>
		
			<table id="invoicePayments" class="invoice-create">
				<?php	
						if (!empty($item['payments'])) {
					?>
						<thead>
							<tr>
								<th></th>
								<th>Amount</th>
								<th>Date</th>
							</tr>
						</thead>
						<tbody>
						<?php
							foreach ($item['payments'] as $payment){
						?>
							<tr>
								<td><?php echo anchor('invoices/delete_payment?pid='.$payment["pid"].'&common_id='.$payment["common_id"], 'Remove', 'pid="'.$payment["pid"].'"'); ?></td>
								<td><input type="hidden" name="payment_amount[]" class="amt" value="<?php echo $payment['payment_amount'] ?>" />$<?php echo $payment['payment_amount'] ?></td>
								<td><?php echo $payment['pdate'] ?></td>
							</tr>
						<?php			
							}
						} 
					 ?>	
				</tbody>
			</table>
		
		</div>	
		</div> 
	</form>	
	<a class="close-reveal-modal">&#215;</a>

