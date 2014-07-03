<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		$this->load->helper(array('form'));
		$this->load->view('templates/header');
		$this->load->view('pages/user/login');
		$this->load->view('templates/footer');
	}
}