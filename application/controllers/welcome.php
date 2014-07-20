<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->helper('url');
	}

	function index()
	{
			$this->load->view('templates/client/header');
			$this->load->view('welcome');
			$this->load->view('templates/client/footer');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */