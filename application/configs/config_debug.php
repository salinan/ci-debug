<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Config_debug CONFIG
 * 
 * Description...
 * 
 * 
 * 
 * @package config_debug
 * @author leon 
 * @version 0.0.0
 */

/*
 * the ip adresses that output the debugcode with function p()
 * only on these servers debugging output is shown
 */

$config['debug_ips'] = array();

/*
 * the ip adresses that can act out with actions
 * other ip's cannot access 
 * used by : visitors_get_404()
 * fill in here the servers 
 */

$config['trusted_ips'] = array(
     $_SERVER['SERVER_ADDR']);

/*
 * used by : mailmessage()
 */                                                
$config['debug_mailto']    = ''; 


/* End of file config_debug.php */
/* Location: ./application/config/config_debug.php */