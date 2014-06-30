<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Verifyregistration extends CI_Controller {

 function __construct() {
   parent::__construct();
   $this->load->model('user_model','',TRUE);
 }

 function index() {
   //This method will have the credentials validation
   $this->load->library('form_validation');

   $this->form_validation->set_rules('first_name', 'First name', 'trim|required|min_length[2]|max_length[24]|xss_clean');
   $this->form_validation->set_rules('last_name', 'Last name', 'trim|required|min_length[2]|max_length[24]|xss_clean');
   $this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
   $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[12]|xss_clean');
   $this->form_validation->set_rules('password', 'Password', 'trim|required|matches[password2]|xss_clean|callback_check_database');
   $this->form_validation->set_rules('password2', 'Confirm Password', 'trim|required|callback_check_pwdmatch');

   if($this->form_validation->run() === FALSE) {
     //Field validation failed.  User redirected to login page     
     $this->load->view('templates/header');
     $this->load->view('pages/user/register');
     $this->load->view('templates/footer');
   } else {
   	 $username = $this->input->post('username');
   	 $password = $this->input->post('password');
     //Go to private area
     $this->user_model->register($username, $password);
     $result = $this->user_model->login($username, $password);
     
       $sess_array = array();
       foreach($result as $row) {
         $sess_array = array(
           'uid' => $row->uid,
           'username' => $row->username,
           'first_name' => $row->first_name,
           'last_name' = $row->last_name,
           'email' => $row->email
         );
         $this->session->set_userdata('logged_in', $sess_array);
       }
     
     redirect('/', 'refresh');
   }
 }

 function check_database($password) {
   //Field validation succeeded.  Validate against database
   $username = $this->input->post('username');
   $password = $this->input->post('password');

   //query the database
   $result = $this->user_model->login($username, $password);
   

   if($result === FALSE) {
   	$sess_array = array(
   	  'username' => $username
   	);
   	$this->session->set_userdata('logged_in', $sess_array);
    return TRUE;
   } else {
     $this->form_validation->set_message('check_database', 'username or password already exists');
     return FALSE;
   }
 }
 function check_pwdmatch() {
    //Field validation succeeded.  Validate against database
    $password = $this->input->post('password');
    $password2 = $this->input->post('password2');
 
    if($password != $password2){
      $this->form_validation->set_message('check_pwdmatch', 'Passwords do not match');
      return FALSE;
    } else {
      return TRUE;
    }
  }
}