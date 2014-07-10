<?php
class Invoice_model extends CI_Model {
	
	var $statusFlags;
	public function __construct()
	{
		$this->load->database();
	}
	
	public function get_invoices($id)
	{		
		$this->db->select("c.id as iid, c.uid, c.client, c.amount, c.status", false);
		$this->db->select("DATE_FORMAT(c.date, '%M %d, %Y') AS pdate", false);
		$this->db->from('common c');
		$this->db->where('uid', $id);
		$this->db->order_by("date", "asc");
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_invoice($id, $uid)
	{
		
		$this->db->select('c.id as iid, c.date, c.uid, c.client, c.amount, c.status, c.inv_sent, c.due_date', false);
		$this->db->where('c.id', $id);
		$this->db->from('common c');
		$query = $this->db->get();
		
		$client = $query->result_array();
		
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
		
		$this->db->select('cl.contact, cl.email, cl.address_1, cl.address_2, cl.zip, cl.city, cl.state, cl.country, cl.tax_id, cl.notes', false);
		$this->db->where('cl.company', $client[0]['client']);
		$this->db->from('client cl');
		$query5 = $this->db->get();
		
		$invoice = $query->result_array();
		$invoice['items'] = $query2->result_array();
		$invoice['payments'] = $query3->result_array();
		$invoice['settings'] = $query4->result_array();
		$invoice['client'] = $query5->result_array();
		return $invoice;
	}
	
	public function set_invoice($uid)
	{	
		
		//FORMAT THE DATE BEFORE PUTTING IN THE DATABASE
		$dateString = $this->input->post('year').'-'.$this->input->post('month').'-'.$this->input->post('day'); 
		$quantity = $this->input->post('qty');
		$description = $this->input->post('description');
		$unit_cost = $this->input->post('unit_cost');
		//
		$item_count = count($quantity);
		$sumTotal = 0;
		//
		// Calculate the due date based on the invoice creation date, and the user's "due in" settings
		$userSettings = $this->get_user_settings($uid);
		$date = new DateTime($dateString);
		$date->add(new DateInterval('P'.$userSettings[0]['due'].'D'));
		//
		$common_data = array('uid' => $uid, 'client' => $this->input->post('client'), 'date' => $dateString, 'due_date'=>$date->format('Y-n-d'));
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
		
		return;
	}
	
	public function edit_invoice($uid)
	{	
		
		$id = $this->input->post('item_id');
		$quantity = $this->input->post('qty');
		$description = $this->input->post('description');
		$unit_cost = $this->input->post('unit_cost');
		$common_id = $this->input->post('iid');
		$dateString = $this->input->post('year').'-'.$this->input->post('month').'-'.$this->input->post('day'); 
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
		// Calculate the due date based on the invoice creation date, and the user's "due in" settings
		$userSettings = $this->get_user_settings($uid);
		$date = new DateTime($dateString);
		$date->add(new DateInterval('P'.$userSettings[0]['due'].'D'));
		//
		$common_data = array('date' => $dateString, 'amount' => $sumTotal, 'due_date'=>$date->format('Y-n-d'));
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
		return;
	}
	
	function row_delete($delete_id)
	{
	   $this->db->where('id', $delete_id);
	   $this->db->limit(1);
	   $this->db->delete('item'); 
	}
	
	function invoice_delete($id)
	{  
	   $this->db->where_in('common_id', $id);
	   $this->db->delete('item'); 
	   $this->db->where('id', $id);
	   $this->db->limit(1);
	   $this->db->delete('common');
	}
	
	function add_payment($pdata, $id)
	{
	  // Insert only the new payment, old payments can not be edited - deleted only
	  $this->db->insert('payments', $pdata);
	  // Update the invoice status
	  $this->invoice_model->_get_set_invoice_status($id); 
	}
	
	function payment_delete($delete_id, $id)
	{
		$this->db->where('pid', $delete_id);
		$this->db->limit(1);
		$this->db->delete('payments');
		// Update the invoice status
		$this->invoice_model->_get_set_invoice_status($id);
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
	
	private function _get_set_invoice_status($id) 
	{
		// Compare amount in invoice with the total payments made
		$this->db->select('c.amount', false);
		$this->db->where('c.id', $id);
		$this->db->from('common c');
		$query = $this->db->get();
		
		$this->db->select('p.payment_amount', false);
		$this->db->where('p.common_id', $id);
		$this->db->from('payments p');
		$query2 = $this->db->get();
		
		$invoice['invoice_total'] = $query->result_array();
		$invoice['payments'] = $query2->result_array();
		
		$payment_amount = 0;
		$invoice_total = $invoice['invoice_total'][0]['amount'];
		foreach ($invoice['payments'] as $payment) {
			$number = $payment['payment_amount']; 
			$payment_amount = $payment_amount + $number;
		}
		
		if ($payment_amount >= $invoice_total) {
			$inv_status = 3; // Paid in Full
		} else if ( $payment_amount == 0 ) {
			$inv_status = 1; // Invoice Open
		} else {
			$inv_status = 2; // Partial Payment
		}
		
		$this->set_invoice_flag($id, 'status', $inv_status);
		return $inv_status;
	}
	
	private function _arrayUnique($array) {
	    $input = array_map("unserialize", array_unique(array_map("serialize", $array)));
	    foreach ( $input as $key => $value ) {
	        is_array($value) and $input[$key] = arrayUnique($value);
	    }
	    return $input;
	}
}