<?php
class XHX_Controller_Item_Form extends XHX_Controller_Item
{
	protected $_dataField = null;
	
	protected function _init()
	{
       $this->_dataField = $this->_ctr->getItem('id');
	}
	
	protected function _getForm( $formType )
	{
	   $formArray = array();
	   foreach( $this->_ctr->getItem() as $key => $field ){
            if( !method_exists($field, 'getFormElement') ) continue;
	   		$arr = $field->getFormElement($formType);
	   		if( empty($arr) ) continue;
            $formArray[$key] = $this->_getExtForm($arr, $key);
       }
       return $formArray;
	}
	
	protected function _getExtForm( $arr, $key )
	{
		$elm = array();
        $elm['name'] = $key;
        $elm['fieldLabel'] = $arr['label'];
        $config = $arr['config'];
        $attrs = $config['attrs'];
        if( isset($attrs['size']) ) $elm['size'] = $attrs['size'];
        switch ( $config['type'] ){
        	case 'Text':
        		$elm['xtype'] = 'textfield';
        		break;
        }
        if( isset($e['value']) ) $elm['value'] = $e['value'];
        return $elm;
	}
	
	public function getInputForm()
	{
	   return $this->_getForm('input');
	}
	
    public function getSearchForm()
    {
       return $this->_getForm('search');
    }
	
	public function gridAction()
	{
		$r = array(
		      'addForm' => $this->getInputForm(),
		      'searchForm' => $this->getSearchForm()
		);
		$this->_ctr->view->{$this->key} = $r;
	}
	
	public function inputFormAction()
	{
		if ( !empty($_POST) ) {
			$r = $this->_dataField->input($_POST);
			if( $r ){
				$r = array(
					'success'=>true,
					'msg'=>'操作成功'
				);
			}else{
				$r = array(
					'success'=>false,
					'msg'=>'操作失败'
				);
			}
			$this->_ctr->getHelper('json')->sendJson($r);
		}
	}
	
	
	
	
	
	
	
	public function formAction()
	{
		$formType = 'input';
		$formDataType = 'ExtJs';
		$params = $this->_ctr->getRequest()->getParams();
		$formType = $this->_get('type',$params,$formType);//$params['type'];
		$formDataType = $this->_get('formDataType',$params,$formDataType);//$params['formDataType'];
		$formArray = array();
		foreach( $this->_ctr->getItem() as $key => $field ){
			if( method_exists($field, 'getFormElement') ) $formArray[$key] = $field->getFormElement($formType);
	    }
	    print_r($formArray);exit();
	    /*
	    $form = $this->getForm( $formArray, $formDataType );
	    $this->_controller->view->{$this->key} = $this->_value = $form;
	    $this->_controller->getHelper('Json')->sendJson($form);
	    */
	}
}
?>