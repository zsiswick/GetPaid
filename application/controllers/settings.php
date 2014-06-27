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
		$this->load->model('user_model');
		$this->session_data = $this->session->userdata('logged_in');
		$this->userdata = array(
		  'user_first_name' => $this->session_data['first_name'],
		  'uid' => $this->session_data['uid']
		);
	} 
	
	public function index() {
		
		//$data['settings'] = $this->user_model->get_settings();
		$data['first_name'] = $this->userdata['user_first_name'];
		
		$this->load->view('templates/header');
		$this->load->view('pages/settings/index', $data);
		$this->load->view('templates/footer');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */