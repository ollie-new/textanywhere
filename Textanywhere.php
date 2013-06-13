<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Textanywhere Class
 *
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Ollie New
 */
class CI_Textanywhere {

	//set config vars
	var $email_from = "";
	var $sms_from_name = "";
	var $textanywhere_domain = "@sms160id.textapp.net";
	var $smtp_host = "";
	var $smtp_user = "";
	var $smtp_pass = "";
	
	//other vars
	var $CI;
	
	/**
	 * Constructor - Sets super object and loads libs/models if necessary
	 *
	 * @access	public
	 */
	function CI_Textanywhere($config = array())
	{
		// Set the super object to a local variable for use later
		$this->CI =& get_instance();
	}

	// --------------------------------------------------------------------
	
	/**
	 * Initialize config vars
	 *
	 * Accepts an associative array as input
	 *
	 * @access	public
	 * @param	array	config preferences
	 * @return	void
	 */	
	function initialize($config)
	{
		foreach ($config as $key => $val)
		{
			if (isset($this->$key))
			{
				$this->$key = $val;
			}
		}
		
		//make sure the required vars have been provided
		$this->_check_var('email_from');
		$this->_check_var('sms_from_name');
		$this->_check_var('textanywhere_domain');
		$this->_check_var('smtp_host');
		$this->_check_var('smtp_user');
		$this->_check_var('smtp_pass');

		//initalize the email settings
		$email_config['protocol'] = 'smtp';
		$email_config['mailtype'] = 'html';
		$email_config['smtp_host'] = $this->smtp_host;
		$email_config['smtp_user'] = $this->smtp_user;
		$email_config['smtp_pass'] = $this->smtp_pass;
		$this->CI->email->initialize($email_config);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Make sure a var is provided and has a value
	 *
	 *
	 * @access	private
	 * @param	string, string
	 */	
	function _check_var($var_name)
	{
		if(!isset($this->$var_name) || !$this->$var_name) {
			exit('Please provide a value for: '.$var_name."\n");
		}
	}
		
	// --------------------------------------------------------------------
	
	/**
	 * Output the current settings
	 *
	 *
	 * @access	public
	 */	
	function current_vars()
	{
		print "--\n";
		print "email_from: ".$this->email_from."\n";
		print "sms_from_name: ".$this->sms_from_name."\n";
		print "textanywhere_domain: ".$this->textanywhere_domain."\n";
		print "smtp_host: ".$this->smtp_host."\n";
		print "smtp_user: ".$this->smtp_user."\n";
		print "smtp_pass: ".$this->smtp_pass."\n";
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Clear all vars
	 *
	 *
	 * @access	public
	 */
	function clear()
	{
		$this->email_from = "";
		$this->sms_from_name = "";
		$this->textanywhere_domain = "";
		$this->smtp_host = "";
		$this->smtp_user = "";
		$this->smtp_pass = "";
	}
	
	// --------------------------------------------------------------------	
	
	/**
	 * Send the driver_sms
	 * 
	 * @access	public
	 * @param	string
	 * @param	string
	 * @return	string
	 */
	function send_sms($mobile_number, $sms_message) {

		$mobile_number = str_replace(' ', '', $mobile_number);
			
		//go ahead and send the email to TextAnywhere: this will trigger the SMS
		$this->CI->email->from($this->email_from);
		$this->CI->email->to($mobile_number.$this->textanywhere_domain);
		$this->CI->email->subject($this->sms_from_name);
		$this->CI->email->message($sms_message);
		$this->CI->email->set_alt_message($sms_message);

		if(!$this->CI->email->send()) {
		    log_message('error', "SMS could not be sent to mobile number ".$mobile_number);
		    print "Oh dear - SMS could not be sent to mobile number ".$mobile_number."\n";
		    return false;
		} else {
			print "Cool, SMS has been sent to mobile number ".$mobile_number."\n";
			return true;
		}
	}

	// --------------------------------------------------------------------

// END CI_Textanywhere class

/* End of file Textanywhere.php */
}
?>