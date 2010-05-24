<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	/*
    public function run()
    {
       Zend_Controller_Action_HelperBroker::getPluginLoader()
          ->removePrefixPath('Zend_Controller_Action_Helper','Zend/Controller/Action/Helper/')
          ->addPrefixPath('Agan_Controller_Action_Helper', 'Agan/Controller/Action/Helper/');
       //'Zend_Controller_Action_Helper' => 'Zend/Controller/Action/Helper/',
       parent::run();
    }
    */
	
	public function __construct($application)
    {
        parent::__construct($application);
		Zend_Loader_Autoloader::getInstance()->setFallbackAutoloader(true);
	}
	
}