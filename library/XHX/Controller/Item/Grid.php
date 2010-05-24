<?php

class XHX_Controller_Item_Grid extends XHX_Controller_Item
{
	protected $_dataField = null;
    protected $_data = array();
    protected $_count = null;
    
    protected function _init()
    {
        $this->_dataField = $this->_ctr->getItem('id');
    }
    
    public function getCount()
    {
        return $this->_count;
    }
    
    public function gridDataAction()
    {
        $info = $this->_ctr->getRequest()->getParams();
        $params = array(
               'order' => array('listorder desc','id desc'),
               'limit' => 20,
               'start' => 0
        );
        foreach (array('limit','start') as $item){
            if( isset($info[$item]) ) {
                $params[$item] = $info[$item];
                unset($info[$item]);
            }
        }
        
        if( isset($info['sort']) ) $params['order'] = "$info[sort] $info[dir]";
        
        $data = $this->_dataField->search($params);
        foreach($data as $d){
            $r = array();
            $d = $d->toArray();
            $this->_dataField->setValues($d);
            foreach( $this->config['fieldInfos'] as $fieldInfo ){
                $key = $fieldInfo['field'];
                $item = $this->_ctr->getItem($key);
                $valueField = isset($fieldInfo['valueField'])?$fieldInfo['valueField']:'value';
                $r[$key] = $item->$valueField;
            }
            $result[] = $r;
        }
        $this->_data = $result;
        $this->_count = (int) $this->_dataField->getCount();
        
        $r = array(
            'results' => $this->_count,
            'rows' => $this->_data
        );

        $this->_ctr->getHelper('json')->sendJson( $r );
    }
    
    public function gridAction()
    {    	
    	$title = array();
    	foreach( $this->config['fieldInfos'] as $fieldInfo ){
    	   	$key = $fieldInfo['field'];
    	   	$title[$key] = isset( $fieldInfo['title'] ) ? $fieldInfo['title'] : $this->_ctr->getItem($key)->label;
    	}
    	$result = array('title'=>$title);
    	$this->_ctr->view->grid = $result;
    }
}

?>