<?php

class XHX_Com_Item_Template extends XHX_Com_Item
{
	protected $showTplList = array();
		
    public function formActionPost()
    {
    	print_r($this->_ctr->view->form);
        exit('template');
    }
    
    public function gridActionPost()
    {
    	$request = $this->_ctr->getRequest();
    	$params = $request->getParams();
    	if( !$request->isXmlHttpRequest() )
    	{
    		Zend_Debug::dump( $this->_ctr->view->getVars() );
    		exit();
    		$this->_ctr->render('grid');
    	}else{
    		print_r( $params );
    		exit();
    		$this->_ctr->getHelper('json')->sendJson();
    	}
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    public function actionInputForm( $params ) {
    	$action = $this->_model->getAction();
    	$action->view->model = $this->_model;
        $this->showTplList[] = 'admin/add';
        $this->_model->postTasks[] = array($this,'render');
    }

    public function pre( $params ) {
        if( in_array( $this->_model->getMethod(), array('Input','Delete') ) )
            $this->_model->postTasks[] = array($this,'msg');
    }
    /*
    public function preInput( $params ) {
    	$this->_model->postTasks[] = array($this,'msg');
    }
    */
    
    public function actionList( $params ) {
        $action = $this->_model->getAction();
        $action->view->model = $this->_model;
        $this->showTplList[] = 'admin/list';
        $this->_model->postTasks[] = array($this,'render');
    }
    /*
    public function validInput( $params ){
        if( $this->_model->isValid == false ){
        	$this->_model->action->view->msg = $this->_model->result;
        	$this->showTplList[] = 'admin/test';
            $this->_model->postTasks[100] = array($this,'_render');
        }
    }
    */
    public function msg(){
        $action = $this->_model->getAction();
        if( $this->_model->isValid == true )
        {
        	$action->view->msg = '操作成功！';
        	$action->view->go = '<script type="text/javascript">window.location.href="/admin/index/list";</script>';
        }
            else
        {
        	$action->view->msg = '操作失败！';
            $action->view->go = '<script type="text/javascript">window.history.go(-1);</script>';
        }
        $this->showTplList[] = 'admin/msg';
        $this->render();
    }
    
    public function render( $tpl ){
    	$action = $this->_model->getAction();
    	$action->aganRender($tpl);
    }
}
?>