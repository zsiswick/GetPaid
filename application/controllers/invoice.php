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
			$data['top_nav'] = false;
			
			$this->load->view('templates/client/header', $data);
			$this->load->view('pages/invoices/client/view', $data);
			$this->load->view('templates/client/footer');
		}
	}
	
	public function stripe_return() 
	{
		define('CLIENT_ID', 'ca_4eR11ZVjVsJOIKtOVnqhMRK4HSSX6ONl');
	  define('API_KEY', 'sk_test_7X4jGTKA2sfVOPSH7rZKaHtq');
	 
	  define('TOKEN_URI', 'https://connect.stripe.com/oauth/token');
	  define('AUTHORIZE_URI', 'https://connect.stripe.com/oauth/authorize');
	 
	  if (isset($_GET['code'])) { // Redirect w/ code
	    $code = $_GET['code'];
	 
	    $token_request_body = array(
	      'client_secret' => API_KEY,
	      'grant_type' => 'authorization_code',
	      'client_id' => CLIENT_ID,
	      'code' => $code,
	    );
	 
	    $req = curl_init(TOKEN_URI);
	    curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($req, CURLOPT_POST, true );
	    curl_setopt($req, CURLOPT_POSTFIELDS, http_build_query($token_request_body));
	 
	    // TODO: Additional error handling
	    $respCode = curl_getinfo($req, CURLINFO_HTTP_CODE);
	    $resp = json_decode(curl_exec($req), true);
	    curl_close($req);
	 
	    $this->load->library('tank_auth_my');
	    $uid = $this->tank_auth_my->get_user_id();
	    $this->load->model('user_model');
	    $this->user_model->set_stripe_token($uid, $resp['access_token']);
	    
	    redirect('/settings', 'refresh');
	    
	  } else if (isset($_GET['error'])) { // Error
	    echo $_GET['error_description'];
	  } else { // Show OAuth link
	    $authorize_request_body = array(
	      'response_type' => 'code',
	      'scope' => 'read_write',
	      'client_id' => CLIENT_ID
	    );
	 
	    $url = AUTHORIZE_URI . '?' . http_build_query($authorize_request_body);
	    echo "<a href='$url'>Connect with Stripe</a>";
	  }
	}
	
	public function stripe_payment() 
	{
		require_once(APPPATH.'libraries/stripe-php/lib/Stripe.php');
		
		$invoice_num = $this->input->post('invoice_num');
		$invoice_amount = $this->input->post('invoice_amount');
		$uid = $this->input->post('uid');
		$id = $this->input->post('iid');
		$cust_email = $this->input->post('cust_email');
		$today = date('Y-m-d');
		define('ADMIN_EMAIL', 'zsiswick@gmail.com');
		define('CUSTOMER_EMAIL', $cust_email);
		
		$client_key = $this->input->post('client_key');
		// See your keys here https://dashboard.stripe.com/account
		Stripe::setApiKey("sk_test_7X4jGTKA2sfVOPSH7rZKaHtq"); // Set your secret key: remember to change this to your live secret key in production
		
		// Get the customer token from DB
		$this->load->model('user_model');
		$settings = $this->user_model->get_stripe_token($uid);
		$cust_token = $settings[0]['stripe_cust_token'];
		//$cust_token = "sk_test_X6SWABikcNrj6DfOfElv0yfe"; // pass from db
		
		// Stores errors:
		$errors = array();
		
		// Need a payment token:
		if (isset($_POST['stripeToken'])) {
			// Get the credit card details submitted by the form
			$card_token = $_POST['stripeToken'];
			
			// Check for a duplicate submission, just in case:
			// Uses sessions, you could use a cookie instead.
			if (isset($_SESSION['token']) && ($_SESSION['token'] == $card_token)) {
				$errors['token'] = 'You have apparently resubmitted the form. Please do not do that.';
			} else { // New submission.
				$_SESSION['token'] = $card_token;
			}
			
		} else {
			$errors['token'] = 'The order cannot be processed. Please make sure you have JavaScript enabled and try again.';
		}
		
			// If no errors, process the order:
			if (empty($errors)) {
				
				// create the charge on Stripe's servers - this will charge the user's card
				try {
					
					// Create a Customer and save to Stripe App
					$customer = Stripe_Customer::create(array(
					  "card" => $card_token,
					  "description" => "Paying invoice: #".$invoice_num) // pass invoice number
					);
					$customer->save();
							
					// Create a Customer Token from the saved customer object above
					$customer_token = Stripe_Token::create(
					  array("customer" => $customer->id),
					  $cust_token // user's access token from the Stripe Connect flow
					);
							
					// Charge the card
					$charge = Stripe_Charge::create(array(
					  "amount" => $invoice_amount * 100, // pass amount from invoice
					  "currency" => "usd",
					  "card" => $customer_token->id, // this is where you define who get's paid
					  "description" => "Paying invoice: #".$invoice_num // pass invoice number
						), $cust_token // user's access token from the Stripe Connect flow
					);
					
					// Check that it was paid:
					if ($charge->paid == true) {
						
						// TODO Store the order in the database.
						// TODO Send the email. 
						// Celebrate!
						$pdata = array(
							'payment_amount'=>$invoice_amount,
							'pdate'=> $today,
							'common_id'=>$id
						);
						
						// Send email to customer to let them know a payment was made
						$message = "Huzzah! You have received a payment of $".number_format((float)$invoice_amount, 2, '.', ',')." for Invoice #".$invoice_num.'. The payment has been sent to your Stripe account.';
						$this->_send_invoice_payment_email($message, CUSTOMER_EMAIL);
						
						// Add the payment to the db
						$this->invoice_model->add_payment($pdata, $id);
						
						// Confirm payment to client
						$this->session->set_flashdata('error', "Your payment has been processed. Thank you!");
						redirect('/invoice/view/'.$id.'/'.$client_key , 'refresh');
						
					} else { // Charge was not paid!	
						$this->session->set_flashdata('error', "Payment System Error! Your payment could NOT be processed because the payment system rejected the transaction. You can try again or use another card.");
						redirect('/invoice/view/'.$id.'/'.$client_key , 'refresh');
					}
					
				} catch (Stripe_CardError $e) {
				    // Card was declined.
					$e_json = $e->getJsonBody();
					$err = $e_json['error'];
					$errors['stripe'] = $err['message'];
					$this->session->set_flashdata('error', $errors['stripe']);
					redirect('/invoice/view/'.$id.'/'.$client_key , 'refresh');
					
				} catch (Stripe_ApiConnectionError $e) {
				    // Network problem, perhaps try again.
				    $this->session->set_flashdata('error', "There was a network problem. Please try again shortly.");
				    redirect('/invoice/view/'.$id.'/'.$client_key , 'refresh');
				} catch (Stripe_InvalidRequestError $e) {
				    // You screwed up in your programming. Shouldn't happen!
				    $message = "Error #1 — Something went wrong. Your card wasn't charged. Please contact customer support for help with your payment";
				    $this->session->set_flashdata('error', $message);
				    send_invoice_payment_email($message, ADMIN_EMAIL);
				    redirect('/invoice/view/'.$id.'/'.$client_key , 'refresh');
				} catch (Stripe_ApiError $e) {
				    // Stripe's servers are down!
				    $this->session->set_flashdata('error', "Stripe's servers are down. Please try again shortly.");
				    redirect('/invoice/view/'.$id.'/'.$client_key , 'refresh');
				} catch (Stripe_CardError $e) {
				    // Something else that's not the customer's fault.
				    $message = "Error #2 — Something went wrong. Your card wasn't charged. Please contact customer support for help with your payment";
				    $this->session->set_flashdata('error', $message);
				    send_invoice_payment_email($message, ADMIN_EMAIL);
				    redirect('/invoice/view/'.$id.'/'.$client_key , 'refresh');
				}
			}		
	}
	
	private function _send_invoice_payment_email($message, $email) 
	{
		$this->load->library('email');
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';
		$this->email->initialize($config);
		$this->email->from("hello@rubyinvoice.com", "Ruby Invoice");
		$this->email->to($email); 
		$this->email->subject("Invoice Payment");
		$this->email->message($message);	
		
		$this->email->send();
		//echo $this->email->print_debugger();
	}
	
	private function _month_string($date) 
	{
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