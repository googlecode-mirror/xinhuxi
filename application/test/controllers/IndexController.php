<?php

class Test_IndexController extends Agan_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
    	$this->view->title = '测试的哈哈';
        $this->aganRender('cms/test');
        //$this->getResponse()->setBody('');
    }
    
    public function formAction(){
        $form = new Zend_Form;
    	$form->setAction('/resource/process')
             ->setMethod('post');
        $form->setAttrib('id', 'login');
        $form->addElement('text', 'username');
        echo $form;
        exit();        
    }
    
    public function testAction()
    {
        function xxx(){
        	echo 'xxx';
        }
        xxx();
        exit();
    }
}