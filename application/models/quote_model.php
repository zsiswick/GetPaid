<?php
class Quote_model extends CI_Model {
	
	public $session_data;
	
	public function __construct()
	{
		$this->load->database();
	}
	
	public function get_quotes($uid)
	{		
		$this->db->select("q.id as iid, q.uid, q.cid, q.amount, q.status, q.date_issued, client.company", false);
		$this->db->select("DATE_FORMAT(q.date_issued, '%b %d, %Y') AS pdate", false);
		$this->db->from('quotes q');
		$this->db->join('client', 'client.id = q.cid', 'left');
		$this->db->where('q.uid', $uid);
		//$this->db->group_by('c.uid');
		//$this->db->order_by("date_issued", "desc");
		$query = $this->db->get();
				
		return $query->result_array();
	}
	
	public function set_quote($uid)
	{	
		$cid = $this->input->post('client');
		$inv_num = $this->invoice_model->get_set_invoice_num($cid);
		//FORMAT THE DATE BEFORE PUTTING IN THE DATABASE
		$issue_date = $this->input->post('issue-date');
		$quantity = $this->input->post('qty');
		$description = $this->input->post('description');
		$unit_cost = $this->input->post('unit_cost');
		$prefix = $this->input->post('prefix');
		$item_count = count($quantity);
		$sumTotal = 0;
		
		//
		$common_data = array('uid' => $uid, 'cid' => $cid, 'prefix' => $prefix, 'date_issued' => $issue_date, 'inv_num' => $inv_num);
		$client_data = array(); // Populate this with input fields from form...
		$this->db->insert('quotes', $common_data);
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
		$this->db->update('quotes', $amount);
		
		//$this->invoice_model->get_set_invoice_status($common_id);
		
		return;
	}
	
}