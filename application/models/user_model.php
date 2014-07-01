<?php
class User_model extends CI_Model {

 function login($username, $password) {
   $this->db->select('uid, username, password, first_name, last_name, email');
   $this->db->from('users');
   $this->db->where('username', $username);
   $this->db->where('password', sha1($password));
   $this->db->limit(1);

   $query = $this->db->get();

   if($query->num_rows() == 1) {
     return $query->result();
   } else {
     return false;
   }
 }
 function register($username, $password, $random_hash) {
    $user = array(
    	'first_name' => $this->input->post('first_name'),
    	'last_name' => $this->input->post('last_name'),
    	'email' => $this->input->post('email'),
    	'username' => $username, 
    	'password' => sha1($password),
    	'verification_code' => $random_hash
    );
    return $this->db->insert('users', $user);
  }
 function verify_email($uid, $random_hash) {
    $this->db->select('uid, verification_code');
    $this->db->from('users');
    $this->db->where('uid', $uid);
    $this->db->where('verification_code', $random_hash);
    $this->db->limit(1);
 
    $query = $this->db->get();
 
    if($query->num_rows() == 1) {
      return $query->result_array();
    } else {
      return false;
    }
  }
	function activate_account($uid, $random_hash) {
		$u_data = array('user_group' => 'active');
		$this->db->where('uid', $uid);
		$this->db->where('verification_code', $random_hash);
		$this->db->update('users', $u_data);
		
		$this->db->select('uid, username, password, first_name, last_name, email');
		$this->db->from('users');
		$this->db->where('uid', $uid);
		$this->db->where('verification_code', $random_hash);
		$this->db->limit(1);
		
		$query = $this->db->get();
		
		if($query->num_rows() == 1) {
		  return $query->result();
		} else {
		  return false;
		}
	}
 function get_settings($uid) {
    $this->db->select('*', false);
    $this->db->where('settings.uid', $uid);
    $this->db->limit(1);
    $this->db->from('settings');
    $query = $this->db->get();
    return $query->result();
  } 
}