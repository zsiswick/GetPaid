<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	require_once(APPPATH.'libraries/stripe-php/lib/Stripe.php');
	
	$stripe = array(
	  "secret_key"      => "sk_test_7X4jGTKA2sfVOPSH7rZKaHtq",
	  "publishable_key" => "pk_test_Bj38OttZCFdKmufc5CrsZmei"
	);
	
	Stripe::setApiKey($stripe['secret_key']);

/* End of file stripe.php */
/* Location: ./application/config/stripe.php */