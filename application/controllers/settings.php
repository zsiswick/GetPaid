<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	var $userdata;
	 
	public function __construct() {
		parent::__construct();
		$this->load->library('tank_auth_my');	
		//CHECK IF USER IS LOGGED IN
		if (!$this->tank_auth_my->is_logged_in()) {
			redirect('/auth/login/');
		}
		$this->session_data = $this->session->userdata('logged_in');
		$this->userdata = array(
		'user_first_name' => $this->session_data['first_name'],
		'user_last_name' => $this->session_data['last_name'],
		'uid' => $this->session_data['uid'],
		'email' =>$this->session_data['email']
		);
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('user_model');
	} 
	
	public function index() {
		$uid = $this->tank_auth_my->get_user_id();
		$data['settings'] = $this->user_model->get_settings($uid);
		$data['first_name'] = $this->tank_auth_my->get_username();
		
		$this->form_validation->set_rules('notes',  'Description', 'max_length[400]|alpha_numeric');
		$this->form_validation->set_rules('due',  'Due', 'numeric');
		if($this->form_validation->run()==false){
			$this->load->view('templates/header');
			$this->load->view('pages/settings/index', $data);
			$this->load->view('templates/footer');
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */