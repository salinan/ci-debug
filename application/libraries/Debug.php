<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Debug LIBRARY
 * 
 * Description...
 * 
 * @package Debug
 * @author leon <your@email.com>
 * @version 0.0.0
 */
class Debug {
	/**
	 * Constructor function
	 *
	 * @return Debug 
	 */
	public function __construct()
	{
                $this->ci =& get_instance();
		$this->ci->load->helper('debug','url');
		$this->ci->load->config('config_debug');
		//$this->ci->load->model('mdebug');
                $this->infos  = array();
                $this->output = FALSE;
                $this->block  = TRUE;
                $this->force  = FALSE;
                $this->ips    = $this->ci->config->item('debug_ips');
                
	}
   
        // switch it on
        public function on()
	{
              $this->block  = FALSE;
	}
        public function off()
	{
              $this->block  = TRUE;
	}
        
        // add a debug line : is used by global funcion p
        public function p($value='',$key='',$line=NULL)
	{ 
          if($this->block == TRUE){return;}
           $n = count($this->infos);
           $this->ci->benchmark->mark('mark'.$n);
           $total = $this->ci->benchmark->elapsed_time('debug_start','mark'.$n);
           $delta=$n?$this->ci->benchmark->elapsed_time('mark'.($n-1),'mark'.$n):$total; 
           $title ="$key from start: $total , after last p(): $delta";
           $this->infos[] = array(
                'title' => $title,
                'value' => $value,
                'delta' => $delta,
                'line'  => $line
           );    
            $this->output = TRUE;
	}
        public function testdiv(){
            //echo '<div style="position:absolute;" id="debug"></div>';
            
        }
        
        // show the message 
        public function prn()
	{
              echo '<xmp style="display:block;font-size:10px;line-height:9px;letter-spacing:0.01em;">';
              
              echo print_r("                         SERVER : ".$_SERVER['SERVER_SOFTWARE']."    \n",TRUE);
              echo print_r("                    PHP VERSION : ".phpversion()."    \n",TRUE);
              echo print_r("                     SERVERTIME : ".date("Y-m-d H:i:s")."    \n",TRUE);
              echo print_r("                       LOCATION : ".current_url()."    \n",TRUE);
              
              echo print_r("...............................................................................\n\n",TRUE);
              
              echo print_r("                         MEMORY : ". round(memory_get_usage()/1024/1024, 2)."MB\n",TRUE);
              echo print_r("                    PEAK MEMORY : ". round(memory_get_peak_usage()/1024/1024, 2)."MB\n",TRUE);
              echo print_r("                  SERVER MEMORY : ". ini_get('memory_limit'). "B\n",TRUE);
              echo print_r("...............................................................................\n",TRUE);
              
              echo print_r("\n                     TOTAL TIME : ".$this->ci->benchmark->elapsed_time('debug_start')."    ",TRUE); 
              echo print_r("\n                    TOTAL ITEMS : ".count($this->infos)."    ",TRUE); 
              $str = array();
              echo print_r("\n...............................................................................\n",TRUE);
             foreach ($this->infos as $info) {
               $key=strtoupper($info['title']);
               $line=strtoupper($info['line']);
               echo print_r("\n                $key ON LINE $line    \n",TRUE);
               echo print_r("...............................................................................\n\n",TRUE);
               print_r($info['value']);
                echo print_r("\n...............................................................................\n\n",TRUE);
            }   
            echo '</xmp>'; 
	}
         // show the message
        public function header()
	{
              echo '<xmp style="color:#423f3f;font-weight:bold;width:475px;background-color:#c7c4e6;display:block;font-size:10px;line-height:9px;letter-spacing:0.01em;">';
              echo print_r("\n                 DEBUGGER ON ".strtoupper($_SERVER['SERVER_NAME'])."\n\n",TRUE);
              
            echo '</xmp>'; 
	}


        public function __destruct()
	{
                if($this->block == TRUE){return;}
                // only testers get the output or by using debug_force()
                if(!in_array(ip(),config_item('debug_ips'))&&$this->force==FALSE){return;}
                $this->header();
		if($this->output){
                    $this->prn();
                }
                
	}

}

/* End of file Debug.php */
/* Location: ./application/libraries/Debug.php */