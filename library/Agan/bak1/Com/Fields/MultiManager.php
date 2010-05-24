<?php
class Agan_Com_Fields_MultiManager extends Agan_Com_Field
{
    public function outputAction( $params )
    {
    	/*
        $info = array(
              'label' => $this->key,
              'title' => $this->title,
              'value' => $params['id'],
        );
        $e = new Zend_Form_Element_Checkbox($this->key,$info);
        $e->removeDecorator('Errors')->removeDecorator('Description')->removeDecorator('HtmlTag')->removeDecorator('Label');
        $e = $e->__toString();
        //$e = str_replace('name="'.$this->key.'"','name="'.$this->key.'[]"',$e);
        return $e;
        */
    	
        return '<input type="checkbox" size="2" name="'.$this->key.'[]" value="'.$params['id'].'" />';
    }
    
    public function getFields(){
        return array();
    }
}
?>