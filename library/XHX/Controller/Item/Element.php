<?php

class XHX_Controller_Item_Element extends XHX_Controller_Item  {
    
    public function getFormElement()
    {
    	$r = get_object_vars($this);
    	unset($r['_ctr']);
    	return $r;
    }
    
    public function getField()
    {
    	return $this->key;
    }
    
    public function setValue($value)
    {
    	$this->value = $value;
    }
}
?>