<?php

class XHX_Com_Model {

	protected $_config = array();
	protected $_fields = array();
	protected $_action = null;
    
    public static function getFieldFloder()
    {
        return dirname(__FILE__).'/Fields';
    }
        
	public function __construct( $config, Zend_Controller_Action $action )
	{
		$this->_action = $action;
		if( is_array($config) ) {
            $this->_config = $config;
        }
        if( !isset( $config['fieldList'] ) || empty($config['fieldList']) ) throw new Zend_Exception('model config is wrong');
        foreach( $config['fieldList'] as $key => $fieldConfig ){
	    	$class = $fieldConfig['class'];
            $config = $fieldConfig['config'];
            $config['key'] = $key;
            if( !isset( $fieldConfig['enable'] ) || $fieldConfig['enable'] != true ) continue;
            $field = new $class( $this, $config );
            $this->_fields[$key] = $field;
        }
	}
	
	public function __get($key){
		return isset( $this->_config[$key] )?$this->_config[$key]:null;
	}
	
	public function getAction()
	{
		return $this->_action;
	}
	
    public function getField($key = null)
    {
    	if( $key == null ) return $this->_fields;
    	if( isset($this->_fields[$key]) ) return $this->_fields[$key];
    	return false;
    }
}
?>