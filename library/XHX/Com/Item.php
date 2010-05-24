<?php
class XHX_Com_Item
{
	protected $_ctr;   //controller
	protected $_itemInfo;
	
    public function __construct( $itemInfo, XHX_Controller_Action $controller )
    {
        $this->_ctr = $controller;
        foreach( $itemInfo as $key => $val)
        {
        	eval('$this->'.$key.' = $val ');
        }
        $itemInfo['value'] = isset( $itemInfo['value'] ) ? $itemInfo['value'] : '';
        $this->_itemInfo = $itemInfo;        
        $this->_init();
    }

    protected function _get($key, $arr, $default = null )
    {
    	return isset($arr[$key]) ? $arr[$key] : $default;
    }
    
    public function __get( $key = null ){
    	if( !isset($this->_itemInfo[$key]) ) return null;
    	return $this->_itemInfo[$key];
    }
    
    protected function _init(){
    	
    }
    
    public function setValue( $value )
    {
    	$this->_itemInfo['value'] = $value;
    }
}
?>