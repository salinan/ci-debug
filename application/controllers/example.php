<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Example CONTROLLER
 * 
 * Description...
 * 
 * @package example
 * @author leon 
 * @version 0.0.0
 */

class Example extends CI_Controller {

	public function __construct() {
		parent::__construct();
                
                // load Debug library
                $this->load->library('debug');
	}
	
	public function index()
	{
            // enable debugging
            debug();
            
            // p() will save any returned value on one list
            // this list will be written with executiontime of each p()
            // this way easily script can me optimized
            
            
            p('test message 1');
            p('test message 2');
            p();// or use it empty
            
             
             
            
            
            
	}
        
        
        

}

/* End of file example.php */
/* Location: ./application/controllers/example.php */