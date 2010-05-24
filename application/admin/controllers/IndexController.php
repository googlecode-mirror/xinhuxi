<?php

class Admin_IndexController extends Agan_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function formAction()
    {
    	$model = Agan_Com_ModelManager::getModel(0, $this);
    	$model->actionInputForm();
    	echo $model->result['form'];
    	exit;
    }
    
    public function addAction()
    {
    	$model = Agan_Com_ModelManager::getModel(0, $this);
        
    	if( $this->getRequest()->isPost() ){
    		$model->actionInput($_POST);
    	}else{
    		//$info = array('username'=>'fffffff');
    		$info = array();
    		$info = $this->_request->getParams();
    		if( $model->actionInputForm($info) == false ){
    		    print_r($model->result);
    		}
    	}
    }

    public function deleteAction()
    {
        $model = Agan_Com_ModelManager::getModel(0, $this);
        $info = $this->_request->getParams();
        $model->actionDelete($info);
    }
    
    public function listAction()
    {
    	$model = Agan_Com_ModelManager::getModel(0, $this);
        if( $this->getRequest()->isPost() ){
        	if( isset($_POST['type_order']) && $_POST['type_order'] == true )
                $model->actionOrder($_POST);
            if( isset($_POST['type_delete']) && $_POST['type_delete'] == true )
                $model->actionDelete($_POST);
        }
        $params = array('order'=>array('listorder desc','id desc'));
        $model->actionList($params);
    }
    
    public function inputAction()
    {
        $model = $this->_request->model;
        $method = $this->_request->method;
        $model = Agan_Com_ModelManager::getModel(0);
        $model->input();
        exit(0);
    }
    
    public function editAction()
    {
        $model = $this->_request->model;
        $method = $this->_request->method;
        $model = Agan_Com_ModelManager::getModel(0);
        $model->inputForm();
        exit(0);
    }
    
    public function updateAction()
    {
        $model = $this->_request->model;
        $method = $this->_request->method;
        $model = Agan_Com_ModelManager::getModel(0);
        $model->input();
        exit(0);
    }
    
    public function searchAction()
    {
    }
    
    public function manageAction()
    {
    	//$this->view->title = '测试的哈哈';
        $this->aganRender('admin/index');
        //$this->getResponse()->setBody('');
    }
    
    public function indexAction()
    {
        $this->aganRender('admin/index');
    }
    
    public function leftAction()
    {
        $this->aganRender('admin/left');
    }
    
    public function mainAction()
    {
        $this->aganRender('admin/main');
    }
}