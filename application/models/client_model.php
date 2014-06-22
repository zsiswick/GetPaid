<?php
class Client_model extends CI_Model {
	public $session_data;
	public function __construct()
	{
		$this->load->database();
		$this->session_data = $this->session->userdata('logged_in');;
	}
	
	public function get_clients($client = FALSE)
	{
		if ($client === FALSE)
		{
			$query = $this->db->get_where('client', array('uid' => $this->session_data['uid']));
			return $query->result_array();
		}
	
		$query = $this->db->get_where('common', array('client' => $client));
		
		return $query->result_array();
			
	}
	
	public function set_client()
	{	
		$data = array(
			'uid' => $this->session_data['uid'],
			'company' => $this->input->post('company'),
			'contact' => $this->input->post('contact'),
			'email' => $this->input->post('email'),
			'address_1' => $this->input->post('address_1'),
			'address_2' => $this->input->post('address_2'),
			'zip' => $this->input->post('zip'),
			'city' => $this->input->post('city'),
			'state' => $this->input->post('state'),
			'country' => $this->input->post('country'),
			'tax_id' => $this->input->post('tax_id'),
			'notes' => $this->input->post('notes')
		);
		
		return $this->db->insert('client', $data);
	}
	
}