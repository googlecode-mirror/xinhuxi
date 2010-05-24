<?php

class Agan_Com_Model {

	protected $_config = array();
	protected $_fields = array();
	protected $_action = null;
    protected $_tasks = array();
    protected $_method = '';
	protected $_params = array();
	
    public $params = array();
	public $autoValid = true;
    public $result = array();
    public $validTasks = array();
    public $execTasks = array();
    public $postTasks = array();
    public $isValid = true;
    
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
            $this->_tasks[$key] = $this->_fields[$key] = $field;
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
    
    public function getMethod()
    {
    	return $this->_method;
    }
    
    public function getParams()
    {
    	return $this->_params;
    }
    
	public function __call($method, $params)
	{
		if( substr($method,0,6) != 'action' ) return false;
		$this->_method = $method = substr($method,6);
		$r = true;
		
		$this->_params = $this->params = empty( $params ) ? array():$params[0];
		
		$this->result = array();
		//把任务流放到 Public tasks 里面，可以由字段来控制遍历任务流
		$this->execTasks = $this->validTasks = $this->_tasks;

	    $methodPre = 'pre';
	    $_method = $methodPre.$method;
        foreach( $this->execTasks as $key => $field ){
          	$next = true;
           	if( method_exists($field, $methodPre) ) $next = $field->$methodPre( $this->params );
            if( $next !== false && method_exists($field, $_method) ) $field->$_method( $this->params );             
        }
        
		if( $this->autoValid == true ){
			//遍历验证
			$methodPre = 'valid';
            $_method = $methodPre.$method;
			//$_method = 'valid'.$method;
	        foreach( $this->validTasks as $key => $field ){
	        	$next = true;
	        	if( method_exists($field, $methodPre) ) $next = $field->$methodPre( $this->params );
	        	if( $next !== false && method_exists($field, $_method) ) $field->$_method( $this->params );
	        }
		}
		if( $this->isValid == true ){
	        //遍历执行
	        $methodPre = 'action';
            $_method = $methodPre.$method;
	        //$_method = 'action'.$method;
		    foreach( $this->execTasks as $key => $field ){
		    	$next = true;
                if( method_exists($field, $methodPre) ) $next = $field->$methodPre( $this->params );
                if( $next !== false && method_exists($field, $_method) ) $field->$_method( $this->params );
            }
		}else{
			$r = false;
		}
        
        //遍历追加方法
        foreach( $this->postTasks as $task ){
        	list($object, $_method) = $task;
        	if( !method_exists($object, $_method) ) continue;
        	$object->$_method();
        }
        return $r;
	}
}
?>