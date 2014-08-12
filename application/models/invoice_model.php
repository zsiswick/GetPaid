<?php
class Invoice_model extends CI_Model {
	
	var $statusFlags;
	public function __construct()
	{
		$this->load->database();
	}
	
	public function get_invoices($id)
	{		
		$this->db->select("c.id as iid, c.uid, c.cid, c.amount, c.status, client.company, GROUP_CONCAT(payments.payment_amount) AS ipayments", false);
		$this->db->select("DATE_FORMAT(c.date, '%b %d, %Y') AS pdate", false);
		$this->db->from('common c');
		$this->db->join('payments', 'payments.common_id = c.id', 'left');
		$this->db->join('client', 'client.id = c.cid', 'left');
		$this->db->where('c.uid', $id);
		$this->db->group_by('c.id');
		$this->db->order_by("date", "desc");
		$query = $this->db->get();
				
		return $query->result_array();
	}
	
		
	public function get_invoice($id, $uid)
	{
		
		$this->db->select('c.id as iid, c.date, c.uid, c.cid, c.amount, c.status, c.prefix, c.inv_num, c.auto_reminder, c.inv_sent, c.due_date', false);
		$this->db->where('c.id', $id);
		$this->db->from('common c');
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) 
		{
		    // the query returned results
		    $common = $query->result_array();
		    
		    $this->db->select('*', false);
		    $this->db->where('i.common_id', $id);
		    $this->db->from('item i');
		    $this->db->order_by("id", "asc");
		    $query2 = $this->db->get();
		    
		    $this->db->select('*', false);
		    $this->db->where('p.common_id', $id);
		    $this->db->from('payments p');
		    $this->db->order_by("pid", "asc");
		    $query3 = $this->db->get();
		    
		    $this->db->select('*', false);
		    $this->db->where('s.uid', $uid);
		    $this->db->from('settings s');
		    $query4 = $this->db->get();
		    
		    	if ($query4->num_rows() > 0) 
		    	{
		    		// the query returned results
		    		$this->db->select('cl.id, cl.company, cl.contact, cl.key, cl.email, cl.address_1, cl.address_2, cl.zip, cl.city, cl.state, cl.country, cl.tax_id, cl.notes', false);
		    		$this->db->where('cl.id', $common[0]['cid']);
		    		$this->db->from('client cl');
		    		$query5 = $this->db->get();
		    		
		    		$invoice = $query->result_array();
		    		$invoice['items'] = $query2->result_array();
		    		$invoice['payments'] = $query3->result_array();
		    		$invoice['settings'] = $query4->result_array();
		    		$invoice['client'] = $query5->result_array();
		    		return $invoice;
		    		
		    	} else {
		    		// query returned no results
		    		return;
		    	}
		} else {
		    // query returned no results
		    return;
		}
	}
	
	public function get_client_invoice($id, $key)
	{
		
		$this->db->select('c.id as iid, c.date, c.uid, c.cid, c.amount, c.status, c.inv_sent, c.prefix, c.inv_num, c.due_date', false);
		$this->db->where('c.id', $id);
		$this->db->from('common c');
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) 
		{
		    // the query returned results
		    $common = $query->result_array();
		    
		    $this->db->select('*', false);
		    $this->db->where('i.common_id', $id);
		    $this->db->from('item i');
		    $this->db->order_by("id", "asc");
		    $query2 = $this->db->get();
		    
		    $this->db->select('*', false);
		    $this->db->where('p.common_id', $id);
		    $this->db->from('payments p');
		    $this->db->order_by("pid", "asc");
		    $query3 = $this->db->get();
		    
		    $this->db->select('*', false);
		    $this->db->where('s.uid', $common[0]['uid']);
		    $this->db->from('settings s');
		    $query4 = $this->db->get();
		    
		    	if ($query4->num_rows() > 0) 
		    	{
		    		// the query returned results
		    		$this->db->select('cl.id, cl.company, cl.contact, cl.key, cl.email, cl.address_1, cl.address_2, cl.zip, cl.city, cl.state, cl.country, cl.tax_id, cl.notes', false);
		    		$this->db->where('cl.id', $common[0]['cid']);
		    		$this->db->where('cl.key', $key);
		    		$this->db->from('client cl');
		    		$query5 = $this->db->get();
		    		
		    		if ($query5->num_rows() > 0) 
		    		{
		    		
			    		$invoice = $query->result_array();
			    		$invoice['items'] = $query2->result_array();
			    		$invoice['payments'] = $query3->result_array();
			    		$invoice['settings'] = $query4->result_array();
			    		$invoice['client'] = $query5->result_array();
			    		return $invoice;
			    	} else {
			    		return;
			    	}
		    		
		    	} else {
		    		// query returned no results
		    		return;
		    	}
		} else {
		    // query returned no results
		    return;
		}
	}
	
	public function set_invoice($uid)
	{	
		$cid = $this->input->post('client');
		$inv_num = $this->invoice_model->get_set_invoice_num($cid);
		//FORMAT THE DATE BEFORE PUTTING IN THE DATABASE
		//$dateString = $this->input->post('year').'-'.$this->input->post('month').'-'.$this->input->post('day'); 
		$send_date = $this->input->post('send-date');
		$due_date = $this->input->post('due-date');
		$quantity = $this->input->post('qty');
		$description = $this->input->post('description');
		$unit_cost = $this->input->post('unit_cost');
		//
		$item_count = count($quantity);
		$sumTotal = 0;
		//
		//
		
		if (!($due_date)) {
			$due_date = $this->_calc_due_date($uid, $send_date);
		}
		//
		$common_data = array('uid' => $uid, 'cid' => $cid, 'prefix' => $this->input->post('prefix'), 'date' => $send_date, 'due_date'=>$due_date, 'remind_date'=>$due_date, 'inv_num' => $inv_num[0]['inv_num']);
		$client_data = array(); // Populate this with input fields from form...
		$this->db->insert('common', $common_data);
		// Get the table id of the last row updated using insert_id() function
		$common_id = $this->db->insert_id();
		
		for ( $i = 0; $i < $item_count; $i++ ) 
		{
			$number = $quantity[$i] * $unit_cost[$i]; 
			$sumTotal = $sumTotal + $number;
			$items[] = array(
				'quantity' => $quantity[$i],
				'description' => $description[$i],
				'unit_cost' => $unit_cost[$i],
				'common_id' => $common_id
				);
		}
		
		$this->db->insert_batch('item', $items);
		$this->db->where('id', $common_id);
		$this->db->limit(1);
		$amount = array('amount' => $sumTotal);
		$this->db->update('common', $amount);
		
		$this->invoice_model->get_set_invoice_status($common_id);
		
		return;
	}
	
	public function edit_invoice($uid)
	{	
		$cid = $this->input->post('client');
		$new_client = $this->input->post('new_client');
		if ($new_client == 1) {
			$inv_num = $this->invoice_model->get_set_invoice_num($cid);
		}
		$id = $this->input->post('item_id');
		$quantity = $this->input->post('qty');
		$description = $this->input->post('description');
		$unit_cost = $this->input->post('unit_cost');
		$common_id = $this->input->post('iid');
		//$dateString = $this->input->post('year').'-'.$this->input->post('month').'-'.$this->input->post('day'); 
		$send_date = $this->input->post('send-date');
		$due_date = $this->input->post('due-date');
		
		$item_count = count($quantity);
		$sumTotal = 0;
		
		for ( $i = 0; $i < $item_count; $i++ ) 
		{
		
			$number = $quantity[$i] * $unit_cost[$i]; 
			$sumTotal = $sumTotal + $number;
			
			$items[] = array(
				'id' => $id[$i],
				'quantity' => $quantity[$i],
				'description' => $description[$i],
				'unit_cost' => $unit_cost[$i],
				'common_id' => $common_id
				);
		}
		//
		//$date = $this->_calc_due_date($uid, $dateString);
		if (!($due_date)) {
			$due_date = $this->_calc_due_date($uid, $send_date);
		}
		//
		$common_data = array('date' => $send_date, 'cid' => $this->input->post('client'), 'prefix' => $this->input->post('prefix'), 'inv_num' => $this->input->post('invoice_num'), 'amount' => $sumTotal, 'due_date'=>$due_date, 'remind_date'=>$due_date);
		
		$this->db->where('id', $common_id);
		$this->db->update('common', $common_data);
		
		// FILTER OUT ALL THE NEW ITEMS FROM EXISTING SO THEY CAN BE INSERTED INTO
		// THE DATABASE PROPERLY
		$new_items = array_filter($items, function($el) { return empty($el['id']); });
		
		$this->db->update_batch('item', $items, 'id');
		
		if (!empty($new_items)) 
		{
			$this->db->insert_batch('item', $new_items);
		}
		$this->invoice_model->get_set_invoice_status($common_id);
		return;
	}
	
	function item_delete($delete_id, $id)
	{
	   $this->db->where('id', $delete_id);
	   $this->db->where('common_id', $id);
	   $this->db->limit(1);
	   $this->db->delete('item'); 
	}
	
	function invoice_delete($id)
	{  
		$uid = $this->tank_auth_my->get_user_id();
		
		$this->db->start_cache();
		$this->db->select('*', false);
		$this->db->where('id', $id);
		$this->db->where('uid', $uid);
		$this->db->from('common');
		$this->db->limit(1);
		$this->db->stop_cache();
		
		$query = $this->db->get();
		$this->db->delete('common');
		$this->db->flush_cache();
		
		if ($query->num_rows() > 0) 
		{
			// Delete all associated invoice items
			$this->db->where('common_id', $id);
			$this->db->delete('item'); 
			
			// Delete all associated invoice payments
			$this->db->where('common_id', $id);
			$this->db->delete('payments');
		}
	}
	
	function add_payment($pdata, $id)
	{
	  // Insert only the new payment, old payments can not be edited - deleted only
	  $this->db->insert('payments', $pdata);
	  // Update the invoice status
	  $this->invoice_model->get_set_invoice_status($id); 
	}
	
	function payment_delete($delete_id, $id)
	{
		$this->db->where('pid', $delete_id);
		$this->db->where('common_id', $id);
		$this->db->limit(1);
		$this->db->delete('payments');
		// Update the invoice status
		$this->invoice_model->get_set_invoice_status($id);
	}
	
	public function set_invoice_flag($id, $flagtype, $status) 
	{
		$data = array($flagtype => $status);
		$this->db->where('id', $id);
		$this->db->limit(1);
		$this->db->update('common', $data);
	}
	
	public function get_user_settings($uid) {
		$this->db->select('*', false);
		$this->db->where('s.uid', $uid);
		$this->db->limit(1);
		$this->db->from('settings s');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	public function get_invoice_num($cid) { // Retrieves an invoice number stored for each client and increments it for the next invoice
		$this->db->select('inv_num', false);
		$this->db->where('i.cid', $cid);
		$this->db->limit(1);
		$this->db->from('invoice_nums i');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	public function get_set_invoice_num($cid) { // Retrieves an invoice number stored for each client and increments it for the next invoice
		$this->db->select('inv_num', false);
		$this->db->where('i.cid', $cid);
		$this->db->limit(1);
		$this->db->from('invoice_nums i');
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) 
		{
			$data['num'] = $query->result_array();
			$data['num'][0]['inv_num'] += 1;
			
			$this->db->where('cid', $cid);
			$this->db->limit(1);
			$this->db->update('invoice_nums', $data['num'][0]);
		}
		
		return $query->result_array();
	}
	
	public function get_set_invoice_status($id) 
	{
		// Compare amount in invoice with the total payments made
		$this->db->select('c.amount, c.status, c.due_date, c.inv_sent', false);
		$this->db->where('c.id', $id);
		$this->db->from('common c');
		$query = $this->db->get();
		
		$this->db->select('p.payment_amount', false);
		$this->db->where('p.common_id', $id);
		$this->db->from('payments p');
		$query2 = $this->db->get();
		
		$invoice['data'] = $query->result_array();
		$invoice['payments'] = $query2->result_array();
		
		$payment_amount = 0;
		$invoice_total = $invoice['data'][0]['amount'];
		
		foreach ($invoice['payments'] as $payment) {
			$number = $payment['payment_amount']; 
			$payment_amount = $payment_amount + $number;
		}
		// Get invoice status stored in database
		$inv_status;
		
		// Calculate whether invoice is due
		$today = new DateTime(date('Y-m-d'));
		$due = new DateTime($invoice['data'][0]['due_date']);
		$diff = $today->diff($due);
		
		// If the invoice isn't already paid, set status as Open or Partial Payment
		// Finally, check if the invoice is due and not paid in full
		if ( $invoice['data'][0]['inv_sent'] == 0) {
			$inv_status = 0;
		} else {
		
			if ($payment_amount >= $invoice_total) {
				$inv_status = 3; // INVOICE IS PAID IN FULL
			} else if ( $payment_amount == 0 ) {
					$inv_status = 1; // INVOICE IS OPEN
			} else {
				$inv_status = 2; // PARTIAL PAYMENT
			}
			if ($inv_status !== 3 && $today > $due) {
				$inv_status = 4; // INVOICE IS DUE
			}
		} 
		
		$this->set_invoice_flag($id, 'status', $inv_status);
		return $inv_status;
	}
	
	/*
	public function get_auto_reminder_invoices() 
	{
		$this->db->select('*', false);
		$this->db->select('client.email AS client_email', FALSE);
		$this->db->select('settings.email AS user_email', FALSE);
		$this->db->where('c.auto_reminder', 1); // filter out invoices that aren't set to auto-remind
		$this->db->where('c.status !=', 3); // filter out paid invoices
		$this->db->where('c.due_date <=', date('Y-m-d'));
		$this->db->from('common c');
		$this->db->join('client', 'client.id = c.cid', 'left');
		$this->db->join('settings', 'settings.uid = c.uid', 'left');
		
		$query = $this->db->get();
		return $query->result_array();
	}
	*/
	public function get_auto_reminder_invoices() 
	{
		$reminders[] = array();
		$a = 0;
		$this->db->select('c.id as iid, c.date, c.uid, c.cid, c.amount, c.status, c.prefix, c.inv_num, c.auto_reminder, c.inv_sent, c.due_date, c.remind_date', false);
		$this->db->select('client.email AS client_email, client.key', FALSE);
		$this->db->select('settings.email AS user_email, settings.due, settings.full_name, settings.company_name', FALSE);
		$this->db->where('c.auto_reminder', 1); // filter out invoices that aren't set to auto-remind
		$this->db->where('c.status !=', 3); // filter out paid invoices
		$this->db->where('c.status !=', 0); // filter out draft invoices
		$this->db->where('c.remind_date <=', date('Y-m-d'));
		
		$this->db->from('common c');
		$this->db->join('client', 'client.id = c.cid', 'left');
		$this->db->join('settings', 'settings.uid = c.uid', 'left');
		
		$query = $this->db->get();
		$invoices = $query->result_array();
		
		if ($query->num_rows() > 0) 
		{
			  
			foreach ($invoices as &$invoice) {
				
				$reminders[$a]['remind_date'] = date('Y-m-d', strtotime($invoice['remind_date']. ' + '.$invoice['due'].' days'));
				$invoice['remind_date'] = date('Y-m-d', strtotime($invoice['remind_date']. ' + '.$invoice['due'].' days'));
				$reminders[$a]['id'] = $invoice['iid'];
				$a+=1;
			}
			
			$this->db->update_batch('common', $reminders, 'id'); // update the next remind date 
		}
		
		return $invoices;
	}
	
	public function set_auto_reminder($id, $checked) 
	{
		$data = array('id' => $id, 'auto_reminder' => $checked);
		$this->db->where('id', $data['id']);
		$this->db->limit(1);
		$this->db->update('common', $data);
	}
	
	public function get_set_due_invoices() 
	{
		$data = array('status' => 4);
		$this->db->where('due_date <=', date('Y-m-d'));
		$this->db->where('status !=', 3); // don't select paid invoices
		$this->db->update('common', $data);	
	}
	
	private function _calc_due_date($uid, $dateString) 
	{
		// Calculate the due date based on the invoice creation date, and the user's "due in" settings
		$userSettings = $this->get_user_settings($uid);
		$date = new DateTime($dateString);
		$date->add(new DateInterval('P'.$userSettings[0]['due'].'D'));
		//
		return $date;
	}
	
	private function _arrayUnique($array) {
	    $input = array_map("unserialize", array_unique(array_map("serialize", $array)));
	    foreach ( $input as $key => $value ) {
	        is_array($value) and $input[$key] = arrayUnique($value);
	    }
	    return $input;
	}
}