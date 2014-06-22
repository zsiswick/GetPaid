<?php
class Invoice_model extends CI_Model {
	
	var $statusFlags;
	public function __construct()
	{
		$this->load->database();
		
		$this->statusFlags = array(
			'0'=>'Draft',
			'1'=>'Sent',
			'2'=>'Due',
			'3'=>'Partial',
			'4'=>'Paid'
		);
	}
	
	public function get_invoices($uid)
	{		
		$this->db->select("c.id as iid, c.uid, c.client, c.amount, c.status", false);
		$this->db->select("DATE_FORMAT(c.date, '%M %d, %Y') AS pdate", false);
		$this->db->from('common c');
		$this->db->where('uid', $uid);
		$this->db->order_by("date", "asc");
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_common($id) {
		$query = $this->db->get_where('common', array('id' => $id));
		return $query->result_array();
	}
	
	public function get_invoice($id)
	{/*
		$this->db->select('c.id as iid, c.date, c.uid, c.client, c.amount, c.status, item.*, payments.*', false);
		$this->db->from('common c');
		$this->db->join('item', 'item.common_id = c.id', 'left');
		$this->db->join('payments', 'payments.common_id = c.id', 'left');
		$this->db->where('c.id', $id);
		$this->db->order_by("id", "asc");
		$query = $this->db->get();
		return $query->result_array();
		*/
		$this->db->select('c.id as iid, c.date, c.uid, c.client, c.amount, c.status', false);
		$this->db->where('c.id', $id);
		$this->db->from('common c');
		$query = $this->db->get();
		
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
		
		$invoice = $query->result_array();
		$invoice['items'] = $query2->result_array();
		$invoice['payments'] = $query3->result_array();
		return $invoice;
	}
	
	public function set_invoice()
	{	
		
		$session_data = $this->session->userdata('logged_in');
		//FORMAT THE DATE BEFORE PUTTING IN THE DATABASE
		$dateString = $this->input->post('year').'-'.$this->input->post('month').'-'.$this->input->post('day'); 
		$quantity = $this->input->post('qty');
		$description = $this->input->post('description');
		$unit_cost = $this->input->post('unit_cost');
		
		$item_count = count($quantity);
		$sumTotal = 0;
		
		$common_data = array('uid' => $session_data['uid'], 'client' => $this->input->post('client'), 'date' => $dateString);
		$this->db->insert('common', $common_data);
		// Get the table id of the last row updated using insert_id() function
		$common_id = $this->db->insert_id();
		
		for ( $i = 0; $i < $item_count; $i++ ) {
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
		$amount = array('amount' => $sumTotal);
		$this->db->update('common', $amount);
		
		return;
	}
	
	public function edit_invoice()
	{	
		
		/*
		** ALL THIS SHOULD BE DONE IN THE CONTROLLER!!!
		*/
		$id = $this->input->post('item_id');
		$quantity = $this->input->post('qty');
		$description = $this->input->post('description');
		$unit_cost = $this->input->post('unit_cost');
		$common_id = $this->input->post('iid');
		$dateString = $this->input->post('year').'-'.$this->input->post('month').'-'.$this->input->post('day'); 
		/*
		**
		*/
		
		$item_count = count($quantity);
		$sumTotal = 0;
		
		for ( $i = 0; $i < $item_count; $i++ ) {
		
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
		
		$common_data = array('date' => $dateString, 'amount' => $sumTotal);
		$this->db->where('id', $common_id);
		$this->db->update('common', $common_data);
		
		// FILTER OUT ALL THE NEW ITEMS FROM EXISTING SO THEY CAN BE INSERTED INTO
		// THE DATABASE PROPERLY
		$new_items = array_filter($items, function($el) { return empty($el['id']); });
		
		$this->db->update_batch('item', $items, 'id');
		
		if (!empty($new_items)) {
			$this->db->insert_batch('item', $new_items);
		}
		return;
	}
	
	function row_delete($delete_id)
	{
	   $this->db->where('id', $delete_id);
	   $this->db->delete('item'); 
	}
	
	function invoice_delete($id)
	{  
	   $this->db->where_in('common_id', $id);
	   $this->db->delete('item'); 
	   $this->db->where('id', $id);
	   $this->db->delete('common');
	}
	
	function add_payment($pdata){
	  // Insert only the new payment, old payments can not be edited - deleted only
	  $this->db->insert('payments', $pdata);
	  // TO DO: Set the invoice status 
	}
	
	function payment_delete($delete_id){
		$this->db->where('pid', $delete_id);
		$this->db->delete('payments');
	}
	
	private function _arrayUnique($array) {
	    $input = array_map("unserialize", array_unique(array_map("serialize", $array)));
	    foreach ( $input as $key => $value ) {
	        is_array($value) and $input[$key] = arrayUnique($value);
	    }
	    return $input;
	}
		
}