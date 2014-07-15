<?php
class User_model extends CI_Model {

 
 function get_settings($uid) 
 {
    $this->db->select('*', false);
    $this->db->where('settings.uid', $uid);
    $this->db->limit(1);
    $this->db->from('settings');
    $query = $this->db->get();
    return $query->result_array();
  } 
  public function set_settings($udata)
  {	
  	$uid = $this->tank_auth_my->get_user_id();
  	$file_name = $udata['upload_data']['file_name'];
  	$data = array(
  		'uid' => $uid,
  		'full_name' => $this->input->post('full_name'),
  		'company_name' => $this->input->post('company_name'),
  		'logo' => $file_name,
  		'email' => $this->input->post('email'),
  		'address_1' => $this->input->post('address_1'),
  		'address_2' => $this->input->post('address_2'),
  		'zip' => $this->input->post('zip'),
  		'city' => $this->input->post('city'),
  		'state' => $this->input->post('state'),
  		'country' => $this->input->post('country'),
  		'due' => $this->input->post('due'),
  		'notes' => $this->input->post('notes')
  	);
  	$this->db->where('uid', $uid);
  	$this->db->update('settings', $data);
  	return; 
  }
  
}