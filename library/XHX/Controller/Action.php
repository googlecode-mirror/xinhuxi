<?php
require_once 'Zend/Controller/Action.php';

abstract class XHX_Controller_Action extends Zend_Controller_Action
{
	protected $_key = null;
	protected $_itemsInfo = array();
	protected $_items = array();
	
    public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
    {
        parent::__construct($request, $response, $invokeArgs );
        $this->_initItem();
    }
    
    protected function _initItem()
    {
        if( empty($this->_key) || empty($this->_itemsInfo) ) throw new Zend_Exception('please set the var $this->_key and $this->_itemsInfo');     
        foreach( $this->_itemsInfo as $key => $itemInfo ){
            $itemInfo['key'] = $key;
            if( !isset( $itemInfo['enable'] ) || $itemInfo['enable'] != 'true' ) continue;
            $class = $itemInfo['class'];
            $item = new $class($itemInfo, $this );
            $this->_items[$key] = $item;
        }
    }
    
    public function getKey()
    {
    	return $this->_key;
    }
    

    public function __call($methodName, $args)
    {
        $methods = array('ActionPre',$methodName.'Pre',$methodName,$methodName.'Post','ActionPost');
        foreach($methods as $methodName){
            foreach( $this->_items as $key => $item ){
	            if( method_exists($item, $methodName) ) $item->$methodName();            
	        }
        }
    }
    
    public function getItem($key = null)
    {
        if( $key == null ) return $this->_items;
        if( isset($this->_items[$key]) ) return $this->_items[$key];
        return false;
    }
}