<?php

class Agan_Com_Fields_Template extends Agan_Com_Field
{
	protected $showTplList = array();
	
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