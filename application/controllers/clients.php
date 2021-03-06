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
		//CHECK IF USER IS LOGGED IN
		if ( ! $this->session->userdata('logged_in')){ 
			redirect('login', 'refresh');
		}
		$this->session_data = $this->session->userdata('logged_in');
		$this->userdata = array(
		'user_first_name' => $this->session_data['first_name'],
		'user_last_name' => $this->session_data['last_name'],
		'uid' => $this->session_data['uid'],
		'email' =>$this->session_data['email']
		);
		$this->load->model('client_model');
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
		$this->form_validation->set_rules('company', 'Company', 'required|xss_clean');
		$this->form_validation->set_rules('contact', 'Contact Name', 'required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
		$this->form_validation->set_rules('address_1', 'Address 1', 'xss_clean');
		$this->form_validation->set_rules('address_2', 'Address 2', 'xss_clean');
		$this->form_validation->set_rules('zip', 'Zip Code', 'alpha_dash|xss_clean');
		$this->form_validation->set_rules('city', 'City', 'xss_clean');
		$this->form_validation->set_rules('state', 'State', 'xss_clean');
		$this->form_validation->set_rules('country', 'Country', 'xss_clean');
		$this->form_validation->set_rules('tax_id', 'Tax ID', 'xss_clean');
		$this->form_validation->set_rules('notes', 'Notes', 'xss_clean');
	
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
		$this->form_validation->set_rules('company', 'Company', 'required|xss_clean');
		$this->form_validation->set_rules('contact', 'Contact Name', 'required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
		$this->form_validation->set_rules('address_1', 'Address 1', 'xss_clean');
		$this->form_validation->set_rules('address_2', 'Address 2', 'xss_clean');
		$this->form_validation->set_rules('zip', 'Zip Code', 'alpha_dash|xss_clean');
		$this->form_validation->set_rules('city', 'City', 'xss_clean');
		$this->form_validation->set_rules('state', 'State', 'xss_clean');
		$this->form_validation->set_rules('country', 'Country', 'xss_clean');
		$this->form_validation->set_rules('tax_id', 'Tax ID', 'xss_clean');
		$this->form_validation->set_rules('notes', 'Notes', 'xss_clean');
	
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