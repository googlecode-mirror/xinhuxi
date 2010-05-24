<?php

class IndexController extends Agan_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }
    
    public function indexAction()
    {
        $this->aganRender('manager/index');
    }
    
    public function gridAction()
    {
    	$this->aganRender('manager/grid');
    }
    
    public function gridAction1()
    {
    	$model = XHX_Com_ModelManager::getModel(0, $this);
            $info = array(
                        'page' => 4,
                        'pageSize' => 2,
                        //'url = \'aasdf\'', 
                        'listorder = 0',
                    );
            $grid = $model->getField('grid');
            $data = $grid->grid($info);
            print_r($data);
            $thead = '<thead><tr><th>'.implode('</th><th>',$data[0]).'</th></tr></thead>';
            unset($data[0]);
            $tbody = '<tbody>';
            foreach( $data as $d){
            	$tbody .= '<tr><td>'.implode('</td><td>',$d).'</td></tr>';
            }
            $tbody .= '</tbody>';
            $table = '<table cellspacing="0" id="the-table">'.$thead.$tbody.'</table>';
            $this->view->table = $table;
            $this->aganRender('manager/grid');
    }
    
    public function gridextjsAction()
    {
    }
    
    public function inputformAction()
    {
        $id = null;
        $params = $this->getRequest()->getParams();
        if( isset($params['id']) && intval($params['id']) > 0 ) $id = intval($params['id']);
        $model = XHX_Com_ModelManager::getModel(0, $this);
        $form = $model->getField('form');
        if( $this->getRequest()->isPost() )
        {
        	$this->view->form = $form->input( $_POST );
        }else{
        	$this->view->form = $form->inputForm($id);
        }
        
        $this->aganRender('admin/form');
    }
    
    public function inputAction()
    {
    	/*
        $id = null;
        if( isset($_GET['id']) && intval($_GET['id']) > 0 ) $id = intval($_GET['id']);
        */
        $model = XHX_Com_ModelManager::getModel(0, $this);
        
        $this->view->form = $model->getField('form')->inputForm($id);
        $this->aganRender('test');
    }
    
    public function index1Action()
    {
    	// http://agan/index/index/field/form/
    	
        $model = XHX_Com_ModelManager::getModel(0, $this);
        //$info = $this->_request->getParams();
        $info = array(
                'field' => 'form',
                'method' => 'inputForm',
        );
        
        $field = $model->getField( $info['field'] );
        $method = $info['method'];
        unset($info['field']);unset($info['method']);
        
        $this->view->form = $field->$method($info);
        $this->aganRender('test');
    }
    
    public function formAction()
    {
        $table = new Zend_Db_Table;
        $table->setOptions(array('name'=>'test'));
        $table->setMetadataCacheInClass( true );
        $data = array('listorder'=>'11');
        $table->insert($data);
        Zend_Debug::dump( $table );
        die();
    }
}