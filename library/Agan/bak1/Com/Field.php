<?php
class Agan_Com_Field
{
	protected $_model;
	protected $_config;
	
    public function __construct( Agan_Com_Model $model, $config )
    {
        $this->_model = $model;
        if( !isset( $config['key'] ) || empty($config['key']) ) throw new Zend_Exception('field key config is wrong');
        $this->_config = $config;
        $this->_init();
    }

    public function __get( $key = null ){
        return isset( $this->_config[$key] )?$this->_config[$key]:null;
    }
    
    protected function _init(){
    	
    }
    
    public function getFields(){
        return $this->key;
    }
    
    public function getAttrs($arr,$ext = array(),$base = array('label','value'))
    {
    	$attrs = array();
    	$base = array_merge($ext,$base);
    	foreach( $base as $attr ){
    		if( isset($arr[$attr]) ) $attrs[$attr] = $arr[$attr];
    	}
    	return $attrs;
    }
    
    public function getAttrData( $data )
    {
    	if( isset($data['validate']) ) $data['validate'] = $this->getValidateForm( $data['validate'] );
    	return str_replace('"','',json_encode($data));
    }
    
    public function getValidateForm( $validate )
    {
        if( isset($validate['number']) ){
            $v = $validate['number'];
            if( isset($v['decimaldigits']) && $v['decimaldigits'] == 0 )
            {
                $validate['digits'] = true;
            }
            unset($validate['number']);
        }
        return $validate;	
    }
    
    public function getValidator( $validate ){
        $arr = array();
        if( isset( $validate['require'] ) && $validate['require'] == true ){
            $arr[] = new Zend_Validate_NotEmpty();
        }
        if( isset($validate['number']) ){
        	$v = $validate['number'];
        	if( isset($v['decimaldigits']) && $v['decimaldigits'] == 0 )
        	{
        		$arr[] = new Zend_Validate_Int();
        	}
        }
        /*
        if( !empty($validate['datatype']) ){
            foreach( explode('|',$validate['datatype']) as $type ){
                switch($type){
                    case 'limit':
                        $options = array();
                        if( isset($validate['min']) ) $options['min'] = $validate['min'];
                        if( isset($validate['max']) ) $options['max'] = $validate['max'];
                        $arr[] = new Zend_Validate_StringLength( $options );
                        break;
                    case 'number':
                        $arr[] = new Zend_Validate_Digits();
                        if( isset($validate['minnumber']) && is_numeric($validate['minnumber']) )
                        {
                            if( isset($validate['maxnumber']) && is_numeric($validate['minnumber']) )
                            {
                                $arr[] = new Zend_Validate_Between( $validate['minnumber'], $validate['maxnumber'] );
                            }else{
                                $arr[] = new Zend_Validate_GreaterThan( $validate['minnumber'] );
                            }
                        }else{
                            if( isset($validate['maxnumber']) && is_numeric($validate['minnumber']) )
                            {
                                $arr[] = new Zend_Validate_LessThan( $validate['maxnumber'] );
                            }
                        }
                        break;
                }
            }
        }
        */
        return $arr;
    }
}
?>