<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

/*
|--------------------------------------------------------------------------
| USER DEFINED
|--------------------------------------------------------------------------
|
|
*/

define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

define('STATUS_FLAGS', serialize (array('0' => 'DRAFT', '1' => 'OPEN', '2' => 'PARTIAL', '3' => 'PAID', '4' => 'DUE')));
define('QUOTE_FLAGS', serialize (array('0' => 'DRAFT', '1' => 'ACCEPTED', '2' => 'DECLINED')));
define('RUBY_TRANSACTION_FEE', 0);
define('RUBY_EMAIL', 'hello@rubyinvoice.com');
define('STRIPE_CLIENT_ID', 'ca_4eR1KfPCsb7yLu7V8tyCaGjJayNpEtqu');
define('STRIPE_REDIRECT_URI', 'https://www.rubyinvoice.com/index.php/settings/stripe_return');
define('SECRET_KEY', 'sk_live_lA9zuBURdxoln5Qt43fl7lVi');
define('PUBLISHABLE_KEY', 'pk_live_O759uhrCqTG6TDA1tRXdd0qM');

/* End of file constants.php */
/* Location: ./application/config/constants.php */