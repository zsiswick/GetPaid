<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller {

	 
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
		$upload_path = './uploads/logo/';
		
		
		if ( ! file_exists($upload_path.$uid) )
    {
        mkdir($upload_path . $uid, 0777);
    }
		
		// File Upload Config
		$config['upload_path'] = $upload_path.$uid.'/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '100';
		$config['overwrite'] = true;
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
	
	public function remove_logo($uid) {
		$this->load->helper('file');
		
		delete_files('./uploads/logo/'.$uid);
		$this->user_model->delete_logo($uid);
		redirect('/settings', 'refresh');
	}
	
	public function disconnect_stripe() 
	{
		$uid = $this->tank_auth_my->get_user_id();
		$this->user_model->unset_stripe_token($uid);	
	}
}

/* End of file settings.php */
/* Location: ./application/controllers/settings.php */