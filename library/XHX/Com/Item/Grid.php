<?php

class XHX_Com_Item_Grid extends XHX_Com_Item
{
	protected $_formAttrs = array();
    protected $_data = null;
    protected $_pages = array();
    protected $_value = array();
    
    protected function _init()
    {
        $this->_data = $data = $this->_ctr->getItem('id');
    }
    
    public function gridAction()
    {
    	$info = $this->_ctr->getRequest()->getParams();
    	$params = array(
    	       'order' => array('listorder desc','id desc'),
    	       'pageSize' => 10,
    	       'page' => 1
    	);
    	foreach (array('order','pageSize','page') as $item){
    		if( isset($info[$item]) ) {
    			$params[$item] = $info[$item];
    			unset($info[$item]);
    		}
    	}
    	
    	$result = array();
    	$title = array();
    	//$fieldInfos = 
    	foreach( $this->config['fieldInfos'] as $fieldInfo ){
    	   	$key = $fieldInfo['field'];
    	   	$title[] = isset( $fieldInfo['title'] ) ? $fieldInfo['title'] : $this->_ctr->getItem($key)->label;
    	}
    	
    	$data = $this->_data->search($params);
    	foreach($data as $d){
    		$r = array();
    		$d = $d->toArray();
    		$this->_data->setValues($d);
	    	foreach( $this->config['fieldInfos'] as $fieldInfo ){
	            $item = $this->_ctr->getItem($fieldInfo['field']);
	            $valueField = isset($fieldInfo['valueField'])?$fieldInfo['valueField']:'value';
	            $r[] = $item->$valueField;
	        }
	        $result[] = $r;
    	}
    	$this->_value = $result;
    	$this->_pages = $this->_data->getPages();
    	$this->_ctr->view->grid = array('title'=>$title, 'data'=>$result, 'pages'=>$this->_pages);
        return $result;
    }
}

?>