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
		$this->load->model('quote_model');
		$this->load->model('invoice_model');
	} 
	
	public function index() 
	{
		$uid = $this->tank_auth_my->get_user_id();
		//$data['quotes'] = $this->quote_model->get_quotes($uid);
		$data['quotes'] = $this->quote_model->get_quotes($uid);
		//$data['settings'] = $this->user_model->get_settings($uid);
		//$data['first_name'] = $this->tank_auth_my->get_username();
		
		$this->load->view('templates/header', $data);
		$this->load->view('pages/quotes/index', $data);
		$this->load->view('templates/footer', $data);
	}
	
	public function create(){
			
		$uid = $this->tank_auth_my->get_user_id();
		
		$data['settings'] = $this->invoice_model->get_invoice_settings($uid);
		
		
		$this->form_validation->set_rules('client', 'Client', 'required|numeric|xss_clean|client');
		$this->form_validation->set_rules('description[]',  'Description', 'trim|xss_clean');
		$this->form_validation->set_rules('qty[]',  'Quantity', 'required|numeric');
		$this->form_validation->set_rules('unit_cost[]',  'Unit Cost', 'callback_numeric_money');
		$this->form_validation->set_message('numeric_money', 'Please enter an amount greater than $0.99');
		
		//print("<pre>".print_r($data['settings'],true)."</pre>");
		
		if ($this->form_validation->run() === FALSE){
	    
	    $jsfiles = array('picker.js', 'picker.date.js');
	    $cssfiles = array('default.css', 'default.date.css');
	    $data['css_to_load'] = $cssfiles;
	    $data['js_to_load'] = $jsfiles;
			$this->load->view('templates/header', $data);
			$this->load->view('pages/quotes/create', $data);
			$this->load->view('templates/footer', $data);
		}
		else {
			$this->quote_model->set_quote($uid);
			redirect('/quotes', 'refresh');
		}
	}
	
	
}

/* End of file estimates.php */
/* Location: ./application/controllers/estimates.php */