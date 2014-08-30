<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Quotes extends CI_Controller {

	 	 
	public function __construct() 
	{
		parent::__construct();
		$this->load->library('tank_auth_my');	
		//CHECK IF USER IS LOGGED IN
		if (!$this->tank_auth_my->is_logged_in()) {
			redirect('/auth/login/');
		}
		$this->session_data = $this->session->userdata('logged_in');
		
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->model('user_model');
	} 
	
	public function index() 
	{
		$uid = $this->tank_auth_my->get_user_id();
		//$data['settings'] = $this->user_model->get_settings($uid);
		//$data['first_name'] = $this->tank_auth_my->get_username();
		
		$this->load->view('templates/header');
		$this->load->view('pages/quotes/index');
		$this->load->view('templates/footer');
	}
	
	
}

/* End of file estimates.php */
/* Location: ./application/controllers/estimates.php */