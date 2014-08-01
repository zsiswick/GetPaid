<?php
class Client_model extends CI_Model {
	public $session_data;
	public function __construct()
	{
		$this->load->database();
	}
	
	public function get_clients($client = FALSE, $uid)
	{
		if ($client === FALSE)
		{
			$query = $this->db->get_where('client', array('uid' => $uid));
			return $query->result_array();
		}
	
		$query = $this->db->get_where('common', array('client' => $client));
		
		return $query->result_array();
			
	}
	
	public function get_client($client_id = FALSE)
	{
		
		if (is_numeric($client_id)) {
			$this->db->select('*');
			$this->db->from('client');	
			$this->db->where('id', $client_id);
		} else {
			$company = str_replace("%20", " ", $client_id);
			$this->db->select('*');
			$this->db->from('client');	
			$this->db->where('company', $company);
		}
			$query = $this->db->get();
			return $query->result_array();
	}
	
	public function set_sample_client($uid)
	{	
		$data = array(
			'uid' => $uid,
			'key' => substr(str_shuffle(MD5(microtime())), 0, 5), // 6c468
			'company' => 'Sample Company',
			'contact' => 'Sample Contact',
			'email' => 'sample@rubyinvoice.com',
			'address_1' => '123 Ruby Street',
			'address_2' => '',
			'zip' => '01234',
			'city' => 'Rubyville',
			'state' => 'MA',
			'country' => 'USA',
			'tax_id' => '',
			'notes' => 'VIP Client'
		);
		
		return $this->db->insert('client', $data);
	}
	
	public function set_client($uid)
	{	
		$data = array(
			'uid' => $uid,
			'key' => substr(str_shuffle(MD5(microtime())), 0, 5), // 6c468
			'company' => $this->input->post('company'),
			'contact' => $this->input->post('contact'),
			'email' => $this->input->post('email'),
			'phone' => $this->input->post('phone'),
			'address_1' => $this->input->post('address_1'),
			'address_2' => $this->input->post('address_2'),
			'zip' => $this->input->post('zip'),
			'city' => $this->input->post('city'),
			'state' => $this->input->post('state'),
			'country' => $this->input->post('country'),
			'tax_id' => $this->input->post('tax_id'),
			'default_inv_prefix' => $this->input->post('default_inv_prefix'),
			'notes' => $this->input->post('notes')
		);
		
		return $this->db->insert('client', $data);
	}
	
	public function update_client()
	{	
		$cdata = array(
			'id' => $this->input->post('cid'),
			'company' => $this->input->post('company'),
			'contact' => $this->input->post('contact'),
			'email' => $this->input->post('email'),
			'phone' => $this->input->post('phone'),
			'address_1' => $this->input->post('address_1'),
			'address_2' => $this->input->post('address_2'),
			'zip' => $this->input->post('zip'),
			'city' => $this->input->post('city'),
			'state' => $this->input->post('state'),
			'country' => $this->input->post('country'),
			'tax_id' => $this->input->post('tax_id'),
			'default_inv_prefix' => $this->input->post('default_inv_prefix'),
			'notes' => $this->input->post('notes')
		);
		$this->db->where('id', $cdata['id']);
		$this->db->update('client', $cdata);
		
		return;
	}
	
	public function delete_client($id)
	{	
		$uid = $this->tank_auth_my->get_user_id();
		
		$this->db->start_cache();
		$this->db->select('*', false);
		$this->db->where('cid', $id);
		$this->db->where('uid', $uid);
		$this->db->from('common');
		$this->db->stop_cache();
		
		$query = $this->db->get();
		$common = $query->result_array();
		$this->db->delete('common'); 
		$this->db->flush_cache();
		
		foreach ($common as $invoice_id) {
			// Delete all associated items
			$this->db->where_in('common_id', $invoice_id['id']);
			$this->db->delete('item');
			
			// Delete all associated invoice payments
			$this->db->where_in('common_id', $invoice_id['id']);
			$this->db->delete('payments');
		}
		
		$this->db->where('id', $id);
		$this->db->where('uid', $uid);
		$this->db->limit(1);
		$this->db->delete('client');
		
		return;
	}
	
}