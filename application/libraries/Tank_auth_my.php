<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require 'Tank_auth.php';


/**
 * Extends the Tank Auth library with support to add user email to session
 *
 * @author Zac.Siswick
 */
class Tank_auth_my extends Tank_auth {
    
    function __construct()
    {
			//Run parent constructor to setup everything normally
			parent::__construct();
		
		}
    /**
     * Login user on the site. Return TRUE if login is successful
     * (user exists and activated, password is correct), otherwise FALSE.
     *
     * @param	string	(username or email or both depending on settings in config file)
     * @param	string
     * @param	bool
     * @return	bool
     */
    function login($login, $password, $remember, $login_by_username, $login_by_email)
    {
    		// Which function to use to login (based on config)
    		if ($login_by_username AND $login_by_email) {
    			$get_user_func = 'get_user_by_login';
    		} else if ($login_by_username) {
    			$get_user_func = 'get_user_by_username';
    		} else {
    			$get_user_func = 'get_user_by_email';
    		}
    		$loggedIn = parent::login($login, $password, $remember, $login_by_username, $login_by_email);
    	
    			if($loggedIn) 
    			{
    				$user = $this->ci->users->$get_user_func($login);
    				$this->ci->session->set_userdata(array(
    						'email'	=> $user->email
    				));
    			}
    			return $loggedIn;
    }
    
    function get_email()
    {
    	return $this->ci->session->userdata('email');
    }
}
