<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clients extends CI_Controller {

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
		$this->load->model('client_model');
		$this->session_data = $this->session->userdata('logged_in');
		$this->userdata = array(
		  'user_first_name' => $this->session_data['first_name'],
		  'uid' => $this->session_data['uid']
		);
	} 
	
	public function index() {
		
		$data['clients'] = $this->client_model->get_clients();
		$data['first_name'] = $this->userdata['user_first_name'];
		
		$this->load->view('templates/header');
		$this->load->view('pages/clients/index', $data);
		$this->load->view('templates/footer');
	}
	
	public function create() {
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$data['title'] = 'Add a client';
		$this->form_validation->set_rules('company', 'Company', 'required');
		$this->form_validation->set_rules('contact', 'Contact Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
	
		if ($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header', $data);
			$this->load->view('pages/clients/create');
			$this->load->view('templates/footer');
		} else {
			$this->client_model->set_client();
			redirect('/clients', 'refresh');
			
		}
	}
	
	public function edit($id = FALSE) {
		$client_id = $this->uri->segment(3, 0);
		$data['client'] = $this->client_model->get_client($client_id);
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$data['title'] = 'Edit Client';
		$this->form_validation->set_rules('company', 'Company', 'required');
		$this->form_validation->set_rules('contact', 'Contact Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
	
		if ($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header', $data);
			$this->load->view('pages/clients/edit', $data);
			$this->load->view('templates/footer', $data);
		} else {
			$this->client_model->update_client($client_id);
			redirect('/clients', 'refresh');
			
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */