<?php

class XHX_Com_Item_Element extends XHX_Com_Item  {
    protected $_formElement = null;
    
    public function formElement()
    {
    	return $this->_config['attrs'];
    }
    
    public function getField()
    {
    	
    }
    
    public function form(){
        if( $this->_formElement != null ) return $this->_formElement;
        $class = 'Zend_Form_Element_'.$this->type;
        $attrs = $this->attrs;
        if( $this->_value !== null ) $attrs['value'] = $this->_value;
        $e = new $class($this->key,$attrs);
        $validators = $this->validators;
        if( !empty($validators) ) $e->setValidators($validators);
        $filters = $this->filters;
        if( !empty($filters) ) $e->setFilters($filters);
        $decorators = $this->decorators;
        if( !empty($decorators) ) $e->setDecorators($decorators);
        return $this->_formElement = $e;
    }
    /*
    public function setValue( $value ){
        if( $this->_formElement == null ) $this->form();
        $this->_formElement->setValue( $value );
        return $this->_value = $value;
    }
    */
    public function simpleForm()
    {
    	if( $this->_formElement == null ) $this->form();
    	$e = $this->_formElement;
    	$e->clearDecorators()->addDecorator('ViewHelper');
    	$str = $e->__toString();
    	$e->clearDecorators()->loadDefaultDecorators();
    	return $str;
    }
}
?>