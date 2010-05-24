<?php

class XHX_Controller_Item_Data extends XHX_Controller_Item
{
	protected $_table;
	protected $_fieldInfo = array();
	protected $_fields = array();
	protected $_formElement = null;
	protected $_data = array();
	protected $_count = array();
	
    protected function _init(){
        $table = new XHX_Db_Table;
        $table->setOptions(array('name'=>$this->_ctr->getKey()));
        $this->_table = $table;
    }
    
    public function getFormElement()
    {
    	return array();
    	return array(
				   'enable' => true,
				   'class' => 'XHX_Controller_Item_Element',
				   'label' => 'ID',
				   'config' => array(
								   'type' => 'Text',
								   'attrs' => array(
									   'size' => 40,
									   'description' => '字段介绍说明',
									   'value' => '',
									   'required' => true,
								    ),
								    'validators' => array(
													   array(
														   'validator' => 'stringLength',
														   'options' => array(1, 20)
													   ),
												  ),
								   'filters' => array(),
								   'decorators' => array(),
    				)
				);
    }
    
    public function getField()
    {
    	return $this->key;
    }
    
    /**
     * @return multitype:|multitype:
     * 返回 获取 业务字段 与 表字段的对应
     */
    public function getFields( $keys = null )
    {
    	$this->_initFields();
    	if( $keys == null ) return $this->_fields;
    	$fields = array();
    	foreach( (array) $keys as $key ){
    		$fields = array_merge( $fields, $this->_fieldInfo[$key] );
    	}
    	return $fields;
    }
    
    public function getFieldInfo()
    {
    	$this->_initFields();
    	return $this->_fieldInfo;
    }
    
    protected function _initFields()
    {
        if( empty($this->_fieldInfo) ){
            $allFields = array();
            foreach( $this->_ctr->getItem() as $item ) 
            {
            	if( !method_exists($item,'getField') ) continue;
                $fields = (array) $item->getField();
                $allFields = array_merge( $allFields, $fields );
                $this->_fieldInfo[$item->key] = $fields;
            }
            $this->_fields = array_unique( $allFields );
        }
    }
    
    public function getCount()
    {
    	return $this->_count;
    }
    
    public function getData()
    {
    	return $this->_data;
    }
    
    public function getInfoData( $info )
    {
    	$fields = $this->getFields();
    	$data = array();
    	foreach( $info as $key => $val ){
    		if( in_array($key, $fields) ) $data[$key] = $val;
    	}
    	return $data;
    }
    
    public function input( $info )
    {
    	$data = $this->getInfoData($info);
    	if( empty($data) ) return false;
    	if( isset($data[$this->key]) )
    	{
    		$where = $this->key ." = ". $data[ $this->key ];
    		unset( $data[$this->key] );
    		$this->_table->update($data, $where);
    	}else{
    		$this->_table->insert($data);
    	}
    	return true;
    }
    
    public function setValue( $value ){
    /*
        if( $this->_formElement == null ) $this->form();
        $this->_formElement->setValue( $value );
    */
        return $this->value = $value;
    }
    
    public function setValues( $data )
    {
        foreach( $this->getFieldInfo() as $key => $val ){
            $item = $this->_ctr->getItem($key);
            if( !method_exists( $item, 'setValue') ) continue;
            if( count($val) == 1 ){
                $item->setValue( $data[$val[0]] );
            }else{
                $value = array();
                foreach( $val as $f ){
                    $value[] = $data[$f];
                }
                $item->setValue( $value );
            }
        }
    }
    
    public function setValuesID( $id )
    {
    	$id = intval($id);
    	if( $id < 1 ) return false;
    	$data = $this->_table->find($id)->toArray();
    	$this->_data = $data = $data[0];
    	$this->setValues( $data );
    }
    
    public function search( $params )
    {
    	$where = null;
        $order = 'id desc';
        $limit = 20;
        $start = 0;
        extract ( $params, EXTR_IF_EXISTS );
        $this->_count = $this->_table->getCount($where);
        return $this->_data = $this->_table->fetchAll($where, $order, $limit, $start);
    }
}
?>