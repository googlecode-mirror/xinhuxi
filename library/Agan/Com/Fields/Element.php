<?php

class Agan_Com_Fields_Element extends Agan_Com_Field {
	protected $_formElement = null;
	
    public function form( $value = null ){
    	if( $this->_formElement != null ) {
    		$this->_formElement->setValue( $value );
    		return $this->_formElement;
    	}
    	$class = 'Zend_Form_Element_'.$this->type;
    	$attrs = $this->attrs;
        if( $value !== null ) $attrs['value'] = $value;
        
        $e = new $class($this->key,$attrs);
        $validators = $this->validators;
        if( !empty($validators) ) $e->setValidators($validators);
        $filters = $this->filters;
        if( !empty($filters) ) $e->setFilters($filters);
        $decorators = $this->decorators;
        if( !empty($decorators) ) $e->setDecorators($decorators);
        return $this->_formElement = $e;
    }
}

?>