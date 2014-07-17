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
		
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->model('user_model');
	} 
	
	public function index() {
		$uid = $this->tank_auth_my->get_user_id();
		$data['settings'] = $this->user_model->get_settings($uid);
		$data['first_name'] = $this->tank_auth_my->get_username();
		// File Upload Config
		$config['upload_path'] = './uploads/logo/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '100';
		$config['max_width']  = '150';
		$config['max_height']  = '150';
		$filename = $data['settings'][0]['logo'];
		$data['filename'] = $filename;
		
		$this->form_validation->set_rules('notes',  'Payment Terms', 'trim|xss_clean');
		$this->form_validation->set_rules('due',  'Due', 'numeric');
		if($this->form_validation->run()==false){
			$this->load->view('templates/header');
			$this->load->view('pages/settings/index', $data);
			$this->load->view('templates/footer');
		} else {
			
			$this->load->library('upload', $config);  
			if (!$this->upload->do_upload()) {
				
			// Our upload failed, but before we throw an error, learn why  
		    if ("You did not select a file to upload." != $this->upload->display_errors('','')) {
		    // in here we know they DID provide a file  
	        // but it failed upload, display error  
	        $data['upload_error'] = $this->upload->display_errors();  
    	    $this->load->view('templates/header');
    	    $this->load->view("pages/settings/index", $data);
    	    $this->load->view('templates/footer');
		    } else {  
	        // here we failed b/c they did not provide a file to upload  
	        // fail silently, or message user, up to you  
	        //$data['upload_error'] = 'No file was provided';
        }
			} else {  
			    // in here is where things went according to plan.   
			    //file is uploaded, people are happy  
			    $udata = array('upload_data' => $this->upload->data());
			}
			if(!isset($udata)) {
				$udata['upload_data']['file_name'] = $filename;
			}
			$this->user_model->set_settings($udata);
			redirect('/settings', 'refresh');
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */