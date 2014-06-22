<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Verifyregistration extends CI_Controller {

 function __construct()
 {
   parent::__construct();
   $this->load->model('user_model','',TRUE);
 }

 function index()
 {
   //This method will have the credentials validation
   $this->load->library('form_validation');

   $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
   $this->form_validation->set_rules('password2', 'Confirm Password', 'trim|required|xss_clean|callback_check_pwdmatch');
   $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');

   if($this->form_validation->run() === FALSE)
   {
     //Field validation failed.  User redirected to login page     
     $this->load->view('templates/header');
     $this->load->view('pages/user/register');
     $this->load->view('templates/footer');
   }
   else
   {
   	 $username = $this->input->post('username');
   	 $password = $this->input->post('password');
     //Go to private area
     $this->user_model->register($username, $password);
     redirect('/', 'refresh');
     
   }
 }

 function check_database($password)
 {
   //Field validation succeeded.  Validate against database
   $username = $this->input->post('username');
   $password = $this->input->post('password');

   //query the database
   $result = $this->user_model->login($username, $password);
   

   if($result === FALSE)
   {
   	$sess_array = array(
   	  'username' => $username
   	);
   	$this->session->set_userdata('logged_in', $sess_array);
    return TRUE;
   }
   else
   {
     $this->form_validation->set_message('check_database', 'username or password already exists');
     return FALSE;
   }
 }
 function check_pwdmatch()
  {
    //Field validation succeeded.  Validate against database
    $password = $this->input->post('password');
    $password2 = $this->input->post('password2');
 
    if($password != $password2){
      $this->form_validation->set_message('check_pwdmatch', 'Passwords do not match');
      return FALSE;
    }
    else{
      return TRUE;
    }
  }
}