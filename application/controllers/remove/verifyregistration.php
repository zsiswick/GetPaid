<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Verifyregistration extends CI_Controller {

 function __construct() {
   parent::__construct();
   $this->load->model('user_model','',TRUE);
 }

 function index() {
   //This method will have the credentials validation
   $this->load->library('form_validation');

   $this->form_validation->set_rules('first_name', 'First name', 'trim|required|xss_clean');
   $this->form_validation->set_rules('last_name', 'Last name', 'trim|required|xss_clean');
   $this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email|xss_clean');
   $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
   $this->form_validation->set_rules('password', 'Password', 'trim|required|matches[password2]|xss_clean|callback_check_database');
   $this->form_validation->set_rules('password2', 'Confirm Password', 'trim|required|callback_check_pwdmatch');

   if($this->form_validation->run() === FALSE) {
     $this->load->helper(array('form'));
     $this->load->view('templates/header');
     $this->load->view('pages/user/register');
     $this->load->view('templates/footer');
   } else {
   	 $username = $this->input->post('username');
   	 $password = $this->input->post('password');
   	 $random_hash = substr(md5(uniqid(rand(), true)), 16, 16);
     $email = $this->input->post('email');
     //ADD NEW USER
     $this->user_model->register($username, $password, $random_hash);
     $result = $this->user_model->login($username, $password);
     
     $reslt_array = array();
     foreach($result as $row) {
     	$reslt_array = array('uid'=>$row->uid);
     }
     $uid = $reslt_array['uid'];
     $this->send_verification_email($random_hash, $uid, $email, $username);
     
     redirect('/login', 'refresh');
   }
 }
 
 function activate_account($uid, $random_hash) {
 	$confirmation = $this->user_model->verify_email($uid, $random_hash);
 	if ($confirmation) {
 		$result = $this->user_model->activate_account($uid, $random_hash);
 		$sess_array = array();
 		foreach($result as $row) {
 			$sess_array = array('uid'=>$row->uid, 'username'=>$row->username, 'first_name'=>$row->first_name, 'last_name'=>$row->last_name, 'email'=>$row->email);
 			$this->session->set_userdata('logged_in', $sess_array);
 		}
 		redirect('/', 'refresh');
 	} else {
 		//Activation failed. User redirected to register page     
 		$this->load->helper(array('form'));
 		$this->load->view('templates/header');
 		$this->load->view('pages/user/register');
 		$this->load->view('templates/footer');
 	}
 }

 function check_database($password) {
   //Field validation succeeded.  Validate against database
   $username = $this->input->post('username');
   $password = $this->input->post('password');
   $result = $this->user_model->login($username, $password);
   
   if($result === FALSE) {
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
  function send_verification_email($random_hash, $uid, $email, $username) {
  
  	$this->load->library('email');
  	$siteURL = base_url();
  	$config['wordwrap'] = TRUE;
  	$config['mailtype'] = 'html';
  	$this->email->initialize($config);
  	$this->email->from('zsiswick@gmail.com', 'The Crew at Get Paid');
  	$this->email->to($email); 
  	$this->email->subject('Your new account at GetPaid needs verification');
  	$this->email->message('<p>Hello ' . $username . ',</p><p>Before you can begin invoicing, we need to verify your email address. You can quickly do so by clicking, or copying and pasting the link provided in your browser window: </p><p><a href="'.$siteURL.'index.php/verifyregistration/activate_account/'.$uid.'/'.$random_hash.'">'.$siteURL.'index.php/verifyregistration/activate_account/'.$uid.'/'.$random_hash.'</a></p><p>Thanks for using GetPaid!</p>');	
  	
  	$this->email->send();
  }
}