<?php
class Agan_Com_Fields_Form extends Agan_Com_Field
{
	protected $formfield = 'formtype';
    public function input( $params = array() ) {
    	$form = new Zend_Form();
    	$form->setAction('/index/index/form/input')->setMethod('get')->setAttrib('id','input')
    	     ->addElement('hidden', $this->formfield, array('value'=>$form->getId()));
        foreach( $this->_model->getField() as $field ){
        	if( method_exists($field, 'form') ){
        		$e = $field->form(null,'input');
        		if( $e instanceof Zend_Form_Element ) $form->addElement($e);
        	}
        }
        
        $form->addElement('submit', 'submit', array('label' => '确定'))
             ->addElement('reset', 'reset', array('label' => '重置'));
        
        $params = $this->isSubmit($form,$params);
        if( $params !== false ){
        	$form->isValid($params);
        }
        
        $action = $this->_model->getAction();
        $action->view->form = $form;
        $temploate = $this->_model->getField('template');
        $temploate->render('test');
        return $form;
    }
    
    protected function isSubmit( $form,$params = array() )
    {
    	if( empty($params) ){
	        if( $form->getMethod() == 'get' ){
	            $params = $_GET;
	        }elseif( $form->getMethod() == 'post' ){
	        	$params = $_POST;
	        }
    	}
        if( isset($params[$this->formfield]) && $params[$this->formfield] == $form->getId() && isset($params['submit']) && !empty($params['submit']) )
            return $params;
        return false;
    }
}
?>