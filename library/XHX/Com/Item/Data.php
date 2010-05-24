<?php

class XHX_Com_Item_Data extends XHX_Com_Item
{
	protected $_table;
	protected $_fieldInfos = array();
	protected $_allFields = array();
	protected $_formElement = null;
	protected $_data = array();
	protected $_pages = array();
	
    protected function _init(){
        $table = new XHX_Db_Table;
        $table->setOptions(array('name'=>$this->_ctr->getKey()));
        $this->_table = $table;
    }
    
    /**
     * @return multitype:|multitype:
     * 返回 获取 业务字段 与 表字段的对应
     */
    public function getFields( $keys = null )
    {
    	$this->_initFields();
    	if( $keys == null ) return $this->_allFields;
    	$fields = array();
    	foreach( (array) $keys as $key ){
    		$fields = array_merge( $fields, $this->_fieldInfos[$key] );
    	}
    	return $fields;
    }
    
    public function getFieldInfos()
    {
    	$this->_initFields();
    	return $this->_fieldInfos;
    }
    
    protected function _initFields()
    {
        if( empty($this->_fieldInfos) ){
            $allFields = array();
            foreach( $this->_ctr->getItem() as $item ) 
            {
                $fields = (array) $item->getField();
                $allFields = array_merge( $allFields, $fields );
                $this->_fieldInfos[$item->key] = $fields;
            }
            $this->_allFields = array_unique( $allFields );
        }
    }
    
    public function getPages()
    {
    	return $this->_pages;
    }
    
    public function getData()
    {
    	return $this->_data;
    }
	    
    public function form()
    {
    	if( $this->_formElement != null ) return $this->_formElement;
    	$e = new Zend_Form_Element_Hidden( $this->key );
    	$e->clearDecorators()->addDecorator('ViewHelper');
    	return $this->_formElement = $e;
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
    }
    
    public function setValue( $value ){
    /*
        if( $this->_formElement == null ) $this->form();
        $this->_formElement->setValue( $value );
    */
        return $this->_value = $value;
    }
    
    public function setValues( $data )
    {
        foreach( $this->getFieldInfos() as $key => $val ){
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
    	$this->_setValues( $data );
    }
    
    public function search( $params )
    {
    	$where = null;
        $order = 'id desc';
        $pageSize = 20;
        $page = 1;
        
        extract ( $params, EXTR_IF_EXISTS );
        
        $pageSize = intval($pageSize);
        if( $pageSize < 1 ) $pageSize = 20;
        $page = intval($page);
        if( $page < 1 ) $page = 1;
        $count = $this->_table->getCount($where);
        $pageCount = ceil( $count / $pageSize );
        $pageCount = max(1,$pageCount);
        $page = min( $page, $pageCount );
        $pages = array(
                        'count' => $count,
                        'pageSize' => $pageSize,
                        'pageCount' => $pageCount,
                        'page' => $page,
                        );
        $this->_pages = $pages;
        $offset = $pageSize * ($page - 1);
        return $this->_data = $this->_table->fetchAll($where, $order, $pageSize, $offset);
    }
}
?>