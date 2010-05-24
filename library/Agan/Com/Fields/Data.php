<?php

class Agan_Com_Fields_Data extends Agan_Com_Field
{
	protected $_table;
	protected $_fields = array();
	
    protected function _init(){
        $table = new Zend_Db_Table;
        $table->setOptions(array('name'=>$this->_model->key));
        $this->_table = $table;
    }
	
    public function __get( $key = null ){
    	if( $this->_model->getMethod() == 'List' && $key == 'label' ) return  '选择/'.$this->_config[$key];
        return isset( $this->_config[$key] )?$this->_config[$key]:null;
    }
    
    public function preInputForm( $params ){
    	if( isset($params[$this->key]) && !empty($params[$this->key]) && intval($params[$this->key]) > 0 )
    	{
    	   $result = $this->_table->find( $params[$this->key] );
    	   $this->_model->params = $result[0]->toArray();
    	   $info = array('value' => $params[$this->key]);
    	   $e = new Zend_Form_Element_Hidden($this->key,$info);
    	   $e->removeDecorator('Errors')->removeDecorator('Description')->removeDecorator('HtmlTag')->removeDecorator('Label');
    	   if( isset($this->_model->result['_hidden']) )
    	       $this->_model->result['_hidden'] .= $e;
    	   else
    	       $this->_model->result['_hidden'] = $e;
    	}
    }
    
    public function actionInput( $params ){
    	$data = $this->getData($params);
    	if( isset($data[$this->key]) ){
    		$where = $this->key.' = '.$data[ $this->key ];
    		unset( $data[$this->key] );
            $this->_table->update($data,$where);
    	}else{
    		$this->_table->insert($data);
    	}
    }
    
    public function actionDelete( $params )
    {
    	$id = $params[$this->key];
    	if( is_string($id) ) $where = $this->key.' = '.$id;
    	if( is_array($id) ) $where = $this->key.' in ('.implode(',',$id).')';
    	$this->_table->delete($where);
    }
    
    public function outputAction( $params ){
    	if( $this->_model->getMethod() == 'List' )
            return '<input type="checkbox" name="'.$this->key.'[]" value="'.$params[$this->key].'" size="2" />/'.$params[$this->key];
        else
            return $params[$this->key];
    }
        
    public function actionList( $params ){
    	$fields = array();
    	$title = array();
    	foreach( $this->_model->list as $key ){
    		$field = $this->_model->getField($key);
    		if( $field == false ) continue;
    		$title[] = $field->label;
            $fields = array_merge($fields, (array) $field->getFields() );
    	}
    	$fields = array_unique($fields);
    	
        if( !empty($fields) ) {
            $db = Zend_Db_Table::getDefaultAdapter();
            $select = $db->select();
            $select->from($this->_model->key, $fields );
            if( isset($params['order']) && !empty($params['order']) ) $select->order($params['order']);
            $data = $db->fetchAll($select);
        }else{
            $data = array();
        }

        foreach( $data as $data_key => $data_val ){
            $result = array();
	        foreach( $this->_model->list as $key ){
	            $field = $this->_model->getField($key);
	            if( $field == false ) continue;
	            if( method_exists($field, 'outputAction') ) 
	               $result[$key] = $field->outputAction($data_val);
	            else
	               $result[$key] = $data_val[$key];
	        }
            $data[$data_key] = $result;
        }

        array_unshift($data,$title);
        $this->_model->result[$this->key] = $data;
        return $data;
    }
    
    public function actionOrder(Array $params){
    	if( !is_array($params['listorder']) || empty($params['listorder']) ) return false;
    	foreach( $params['listorder'] as $key => $val ){
    		$data = array('listorder'=>$val);
    		$where = "$this->key = $key";
    		$this->_table->update($data,$where);
    	}
    	return true;
    }
    
    public function dataList( $data ){
    	$data = $this->_table->fetchAll();
        return $data;
    }
    
    protected function getData($params)
    {
    	$data = array();
    	if( empty($this->_fields) ) $this->getDataFields();
    	foreach( $this->_fields as $f )
    	{
    	   if( isset($params[$f]) ) $data[$f] = $params[$f];
    	}
    	return $data;
    }
    
    protected function getDataFields()
    {
        foreach( $this->_model->getField() as $f )
        {
            $_f = $f->getFields();
            if( is_string($_f) ) $this->_fields[] = $_f;
            if( is_array($_f) ) $this->_fields = array_merge($this->_fields, $_f );
        }
        $this->_fields = array_unique($this->_fields);
    }
}
?>