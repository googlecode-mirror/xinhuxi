<?php
class XHX_Com_Item_Form extends XHX_Com_Item
{
	protected $_inputForm = null;
	protected $_data = null;
	
	protected function _init()
	{
		//$this->_data = $data = $this->_model->getField('id');
	}
	
	public function formAction()
	{
		$params = $this->_controller->getRequest()->getParams();
		$formType = $params['type'];
		$formDataType = $params['formDataType'];
		$formArray = array();
		foreach( $this->_controller->getField() as $key => $field ){
			if( method_exists($field, 'formElement') ) $formArray[$key] = $field->formElement($formType);
	    }
	    $form = $this->getForm( $formArray, $formDataType );
	    $this->_controller->view->{$this->key} = $this->_value = $form;
	    $this->_controller->getHelper('Json')->sendJson($form);
	}
	
	public function gridAction()
	{
		
	}
	
	public function getForm( $formArray, $formDataType )
	{
		$form = array();
		return $form;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
    public function inputForm( $id = NULL ) {
    	if( $id != NULL && intval($id) > 0 ) $this->_data->setValuesID( $id );
    	if( $this->_inputForm != null ) return $this->_inputForm;
    	$form = new Zend_Form();
    	$form->setMethod('post');
        foreach( $this->_model->getField() as $field ){
            if( method_exists($field, 'form') ){
        		$e = $field->form(null,'input');
        		if( $e instanceof Zend_Form_Element ) $form->addElement($e);
        	}
        }
        
        $form->addElement('submit', 'submit', array('label' => '确定'))
             ->addElement('reset', 'reset', array('label' => '重置'));
             
        return $form;
    }
    
    public function inputFormExtjs( $id = NULL )
    {
    	$form = $this->inputForm($id);
    	return $form;
    }
    
    public function input( $info )
    {
    	$form = $this->inputForm();
    	$form->isValid( $info );
    	if( $form->isValid( $info ) ){
    		$this->_data->input( $info );
    	}
    	return $form;
    }
}
?>