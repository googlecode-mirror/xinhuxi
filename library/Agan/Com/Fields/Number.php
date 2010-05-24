<?php
class Agan_Com_Fields_Number extends Agan_Com_Field
{
   protected function init()
   {
       //if( !isset($this->_config['datatype']) ) $this->_config['datatype'] = '';
       //$this->_config['datatype'] .= '|number';
   }
   
   public function actionInputForm( $params ) {
   	    $info = array(
              'label' => $this->key,
              'title' => $this->title,
              'size' => $this->size,
              'value' => $this->value,
              'data' => $this->getAttrData(array('validate'=>$this->validate)),
        );
        if( isset($params[$this->key]) ) $info['value'] = $params[$this->key];
        $e = new Zend_Form_Element_Text($this->key,$info);
        $e->removeDecorator('Errors')->removeDecorator('Description')->removeDecorator('HtmlTag')->removeDecorator('Label');
        $this->_model->result[$this->key] = $e;
        return true;
    }
}
?>