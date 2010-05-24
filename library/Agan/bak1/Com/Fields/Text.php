<?php
class Agan_Com_Fields_Text extends Agan_Com_Field
{
	public function actionInputForm( $params ) {
		$info = array(
		      'label' => $this->key,
		      'title' => $this->title,
		      'size' => $this->size,
		      'value' => $this->value,
		      'data' => $this->getAttrData(array('validate'=>$this->validate)),
		);
		if( isset($params[$this->key]) ) $info['value'] = $params[$this->key];
		if( isset( $this->_config['isPassword'] ) && $this->_config['isPassword'] == true ){
			$info['RenderPassword'] = true;
		    $e = new Zend_Form_Element_Password($this->key,$info);
		}else{
		    $e = new Zend_Form_Element_Text($this->key,$info);
		}
		$e->removeDecorator('Errors')->removeDecorator('Description')->removeDecorator('HtmlTag')->removeDecorator('Label');
		$this->_model->result[$this->key] = $e;
		return $e;
	}
	
	public function outputAction( $params ){
		return $params[$this->key];
	}
	
	public function input($data)
	{
		return $data;
	}
	
	public function validInput( $data ){
		$validator = new Zend_Validate();
		//$validator->addValidator(new Zend_Validate_Int());
		if ($validator->isValid($data)) {
		    return $data;
		} else {
			//$this->_model->isValid = false;
		    return $this->_info['errMsg'];
		}
	}
}
?>