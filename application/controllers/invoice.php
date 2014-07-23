<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invoice extends CI_Controller {

	public $thisDay = 0 ;
	public $thisMonth = 0 ;
	public $thisYear = 0 ;
	 
	public function __construct()
	{
		parent::__construct();
		
		$this->thisDay = date("j");
		$this->thisMonth = date("n");
		$this->thisYear = date("Y");
		
		$this->load->helper('form');
		$this->load->helper('date_input_helper');
		$this->load->library('form_validation');
		
		$this->load->model('invoice_model');
		$this->load->model('client_model');
	} 
	
	public function index() 
	{
		// Do Something
	}
	
	public function view($id = FALSE, $key = FALSE) 
	{
		$data['item'] = $this->invoice_model->get_client_invoice($id, $key);
		$data['status_flags'] = unserialize(STATUS_FLAGS);

		if (empty($data['item']['client'])) 
		{
			show_404();
		} 
			else 
		{
			$data['dob_dropdown_day'] = buildDayDropdown('day', $this->thisDay);
			$data['dob_dropdown_month'] = buildMonthDropdown('month', $this->thisMonth);
			$data['dob_dropdown_year'] = buildYearDropdown('year', $this->thisYear);
			$data['theDate'] = $this->_month_string($data['item'][0]['date']);
			$data['title'] = $data['item']['client'][0]['company'];
			
			$this->load->view('templates/client/header', $data);
			$this->load->view('pages/invoices/client/view', $data);
			$this->load->view('templates/client/footer');
		}
	}
	
	private function _month_string($date) {
	$month=array('01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December');
		$datePieces = explode("-", $date);		
		
		$day = $datePieces[2];
		$month = $month[$datePieces[1]];
		$year = $datePieces[0];
		
		return $humanDate = array('day'=>$day, 'month'=>$month, 'year'=>$year);
	}
	
}

/* End of file invoices.php */
/* Location: ./application/controllers/invoices.php */