<?php
class User_model extends CI_Model {

 function login($username, $password) {
   $this->db->select('uid, username, password, first_name');
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
 function register($username, $password) {
    $user = array(
    	'username' => $this->input->post('username'), 
    	'password' => sha1($this->input->post('password'))
    );
    return $this->db->insert('users', $user);
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