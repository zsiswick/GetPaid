<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invoices extends CI_Controller {

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
	public $thisDay = 0 ;
	public $thisMonth = 0 ;
	public $thisYear = 0 ;
	var $userdata;
	 
	public function __construct()
	{
		parent::__construct();
		
		//CHECK IF USER IS LOGGED IN
		if ( ! $this->session->userdata('logged_in')){ 
			redirect('login', 'refresh');
		}
		
		$this->session_data = $this->session->userdata('logged_in');
		
		$this->userdata = array(
	    'user_first_name' => $this->session_data['first_name'],
	    'uid' => $this->session_data['uid']
	  );
		
		$this->thisDay = date("j");
		$this->thisMonth = date("n");
		$this->thisYear = date("Y");
		
		
		
		$this->load->helper('form');
		$this->load->helper('dateInput_helper');
		$this->load->library('form_validation');
		
		$this->load->model('invoice_model');
		$this->load->model('client_model');
	} 
	
	public function index() {
		
		$session_data = $this->session->userdata('logged_in');
		$data['first_name'] = $this->userdata['user_first_name'];
		$uid = $this->userdata['uid'];
		$data['invoices'] = $this->invoice_model->get_invoices($uid);
		$this->load->view('templates/header', $data);
		$this->load->view('pages/invoices/index', $data);
		$this->load->view('templates/footer');
	}
	
	public function client_invoices($client = FALSE){
		
		$data['invoices'] = $this->invoice_model->get_invoices($client);
		
		if (empty($data['invoices'])){
			show_404();
		}
		$data['title'] = $data['invoices'][0]['client'];
		$this->load->view('templates/header', $data);
		$this->load->view('pages/invoices/client_invoices', $data);
		$this->load->view('templates/footer');
		
	}
	
	public function view($id = FALSE) {
	
		$session_data = $this->session->userdata('logged_in');
		$uid = $session_data['uid'];
		$data['item'] = $this->invoice_model->get_invoice($id);
		$data['dob_dropdown_day'] = buildDayDropdown('day', $this->thisDay);
		$data['dob_dropdown_month'] = buildMonthDropdown('month', $this->thisMonth);
		$data['dob_dropdown_year'] = buildYearDropdown('year', $this->thisYear);
		$common_id = $data['item'][0]['iid'];
		$pamount = $this->input->post('pamount');
		$paymentDate = $this->_format_date_string($this->input->post('year'), $this->input->post('month'), $this->input->post('day'));
		$pdata = array(
			'payment_amount'=>$this->input->post('pamount'),
			'pdate'=> $paymentDate,
			'common_id'=>$common_id
		);
				
		if (empty($data['item'])) {
				show_404();
			
		} else {
		$month=array('01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December');
			$datePieces = explode("-", $data['item'][0]['date']);		
			$data['dateDay'] = $datePieces[2];
			$data['dateMonth'] = $month[$datePieces[1]];
			$data['dateYear'] = $datePieces[0];
			$data['title'] = $data['item'][0]['client'];
			
			$this->form_validation->set_rules('pamount', 'Payment Amount', 'required|numeric');
			$this->form_validation->set_rules('day', 'Day', 'required');
			$this->form_validation->set_rules('month', 'Month', 'required');
			$this->form_validation->set_rules('year', 'Year', 'required');
			
			if ( $data['item'][0]['uid'] === $uid ) {
			
				if ($this->form_validation->run() === FALSE) {
					$this->load->view('templates/header', $data);
					$this->load->view('pages/invoices/view', $data);
					$this->load->view('templates/footer');
				} else {
					//submit payment to db
					$this->invoice_model->add_payment($pdata);
					redirect('/invoices/view/'.$common_id, 'refresh');
				}
			} else {
				show_404();
			}
		}
	}
	
	public function create(){
		
		$data['dob_dropdown_day'] = buildDayDropdown('day', $this->thisDay);
		$data['dob_dropdown_month'] = buildMonthDropdown('month', $this->thisMonth);
		$data['dob_dropdown_year'] = buildYearDropdown('year', $this->thisYear);
		$data['clients'] = $this->client_model->get_clients();
		$data['title'] = 'Create an invoice';
		
		$this->form_validation->set_rules('description[]',  'Description', 'required');
		$this->form_validation->set_rules('qty[]',  'Quantity', 'required|numeric');
	
		// CHECK THE FORM TO SEE IF SUBMITTED VIA AJAX
		if($this->input->is_ajax_request()){
		   $respond=array();
		   
		   if($this->form_validation->run()==false){
		      $respond['result'] = 'false';
		      $respond['errors'] = validation_errors();
		   }
		   else {
		      $respond['result'] = 'true';
		      $respond['errors'] = 'The invoice was added!';
		      $this->invoice_model->set_invoice();
		      $respond['redirect'] = base_url().'/index.php/invoices';
		   }			
		   return $this->output->set_output(json_encode($respond));
		}
		
		if ($this->form_validation->run() === FALSE){
	    $data['js_to_load']='jquery.calculation.min.js';
			$this->load->view('templates/header', $data);
			$this->load->view('pages/invoices/create', $data);
			$this->load->view('templates/footer', $data);
		}
		else {
			$this->invoice_model->set_invoice();
			redirect('/invoices', 'refresh');
		}
	}
	
	public function edit($id = FALSE) {
		
		$invoice_id = $this->uri->segment(3, 0);
		$data['title'] = 'Edit this invoice';
		
		$session_data = $this->session->userdata('logged_in');
		$uid = $session_data['uid'];
		
		$data['item'] = $this->invoice_model->get_invoice($id);
		
		if (empty($data['item'])) {
				show_404();
			
		} else {
			
			$data['iid'] = $data['item'][0]['iid'];
			// BREAK APART THE DATE STORED IN THE DATABASE AND PUT IT BACK INTO THE INPUT FIELDS
			$datePieces = explode("-", $data['item'][0]['date']);		
			$data['dob_dropdown_day'] = buildDayDropdown('day', $datePieces[2]);
			$data['dob_dropdown_month'] = buildMonthDropdown('month', $datePieces[1]);
			$data['dob_dropdown_year'] = buildYearDropdown('year', $datePieces[0]);
			
			$this->form_validation->set_rules('qty[]', 'Quantity', 'numeric');	
			if ( $data['item'][0]['uid'] === $uid ) {
			
				if ($this->form_validation->run() === FALSE) {
						$data['js_to_load']='jquery.calculation.min.js';
						$this->load->view('templates/header', $data);
						$this->load->view('pages/invoices/edit', $data);
						$this->load->view('templates/footer', $data);
					} else {
						$this->invoice_model->edit_invoice();
						redirect('/invoices/view/'.$invoice_id, 'refresh');
					}
			} else {
				show_404();
			}
		}
	}
	
	public function delete_row() {
	
		$delete_id = $this->input->get('id');
		$id = $this->input->get('common_id');
		// invoice id
		$data['item'] = $this->invoice_model->get_invoice($id);
		// for security, check whether the id in URL matches the invoice ID
		$checkInvoice = $this->_searchArray($data['item'], 'id', $delete_id);
		// make sure the id's given are whole numbers
		if (is_numeric($id) && strpos( $id, '.' ) === false) {
			
			if ($this->_check_user($id) === true && $checkInvoice) {
				$this->invoice_model->row_delete($delete_id);
				redirect($_SERVER['HTTP_REFERER']);
				
			} else {
				return show_404();
			}
		} else {
			return show_404();
		}
	}
	
	public function delete_payment() {
	
		$delete_id = $this->input->get('pid');
		$id = $this->input->get('common_id');
		// invoice id
		$data['item'] = $this->invoice_model->get_invoice($id);
		// for security, check whether the id in URL matches the invoice ID
		$checkInvoice = $this->_searchArray($data['item']['payments'], 'pid', $delete_id);
		// make sure the id's given are whole numbers
		
		if (is_numeric($id) && strpos( $id, '.' ) === false) {
			
			if ($this->_check_user($id) === true && $checkInvoice) {
				$this->invoice_model->payment_delete($delete_id);
				redirect($_SERVER['HTTP_REFERER']);
				
			} else {
				return show_404();
			}
		} else {
			return show_404();
		}
	}
	
	public function delete_invoice($id) {
	  if ($this->_check_user($id) === true) {
	  	$this->invoice_model->invoice_delete($id);
	  	redirect('/invoices', 'refresh');
	  } else {
	  	show_404();
	  }
	}
			
	private function _check_user($id) {
		$data['item'] = $this->invoice_model->get_invoice($id);
		$session_data = $this->session->userdata('logged_in');
		$uid = $session_data['uid'];
		if ( $data['item'][0]['uid'] === $uid ) {
			return true;
		} else {
			return false;
		}
	}
	
	private function _searchArray($items, $searchKey, $val) {
	   foreach($items as $key => $product)
	   {
	      if ( $product[$searchKey] === $val )
	         return true;
	   }
	   return false;
	}
	private function _format_date_string($year, $month, $day) {
		return $year.'-'.$month.'-'.$day;
	}
}

/* End of file invoices.php */
/* Location: ./application/controllers/invoices.php */