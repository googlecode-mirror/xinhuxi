<?php
class XHX_Controller_Item
{
	protected $_ctr;   //controller
	
    public function __construct( $itemInfo, XHX_Controller_Action $controller )
    {
        $this->_ctr = $controller;
        foreach( $itemInfo as $key => $val)
        {
        	$this->$key = $val;
        }
        $this->_init();
    }
    
    protected function _init(){
        
    }
    
    protected function _get($key, $arr, $default = null )
    {
    	return isset($arr[$key]) ? $arr[$key] : $default;
    }
}
?>