<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// non trusted ip's will get 404 page 
// if they are coming from other ip's than the ones in the config-file
function visitors_get_404($mail=FALSE){
    if(!in_array(ip(), config_item('trusted_ips'))){
           if($mail){mailmessage('no access : '.__METHOD__);}
           show_404();
    }      
}
// get a debug action
function p($value='',$key=NULL,$line='...'){
    $ci =& get_instance();
    $ci->debug->p($value,$key,$line); 
}
// write out the last used query
function q($value='LAST QUERY'){
    $ci =& get_instance();
    $ci->debug->p($ci->db->last_query(),$value);
}
// write out the used memory
function mem($value='memory_get_usage'){
    $ci =& get_instance();
    $ci->debug->p(round(memory_get_usage()/1024/1024, 2),$value);
}

// test if it is one of the debuggers ip's
function is_debug(){
   return in_array($_SERVER['REMOTE_ADDR'],config_item('debug_ips'))?TRUE:FALSE;
}

// this will enable the debugger
function debug($value=NULL,$key=NULL){
    $ci =& get_instance();
    $ci->debug->on();
    $ci->debug->force=FALSE;
    $ci->benchmark->mark('debug_start');
    if($value){
        p($value,$key);
    }
}
// put the debuggerclass on for everyone
function debug_force($value=NULL,$key=NULL){
    $ci =& get_instance();
    $ci->debug->on();
    $ci->debug->force=TRUE;
    $ci->benchmark->mark('debug_start');
    if($value){
        p($value,$key);
    }
}
// put the debuggerclass off
function debug_off(){
    $ci =& get_instance();
    $ci->debug->off();
}

// some functions to quickly list and output 
// tables and fields from your connected database

function tables(){
    $ci =& get_instance();    
    debug($ci->db->list_tables());
}
function fields($table){
    $ci =& get_instance(); 
    debug($ci->db->list_fields($table));
}
function table($table=NULL,$rows='25',$filter=NULL){
    $ci =& get_instance(); 
    $ar = array('tables'=>$ci->db->list_tables());
    if($table) {
        if($filter){$this->db->where($filter);}
        $ar = array_merge($ar,array(
        'table'       => $table,
        'rows'   => $ci->db->from($table)->count_all_results(),
        'fields' => $ci->db->list_fields($table),
        'data'   => $ci->db->from($table)
        ->limit($rows)->get()->result_array()));
        $ar['rows']=count($ar['data']).'/'.$ar['rows'];
    } 
    debug($ar);
    return $ar;
}

// mail a message for debugging

function mailmessage($msg = ''){
    logline('message sent on : ' .date('Y-m-d H:i:s'));
    logline('server : '.$_SERVER['SERVER_NAME'].' @ '.$_SERVER['SERVER_ADDR']);
    logline('by remote server : '.ip().'<hr>');
    logline($msg);
    $message = implode('<br>',$GLOBALS['loglines']);
    $headers= "From: The Test Messenger <testmessage@messageland.com>\r\n";
    $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
    mail(config_item('debug_mailto'),"Testmessage @ ".$_SERVER['HTTP_HOST'],$message,$headers);
}
// what is my ip ??
function ip(){
    return $_SERVER['REMOTE_ADDR'];
}





/* End of file debug_helper.php */
/* Location: ./application/helpers/debug_helper.php */
