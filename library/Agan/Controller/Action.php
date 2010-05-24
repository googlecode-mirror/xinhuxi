<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Controller
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: Action.php 20096 2010-01-06 02:05:09Z bkarwin $
 */

require_once 'Zend/Controller/Action.php';

abstract class Agan_Controller_Action extends Zend_Controller_Action
{
    protected $_templatePath;
    protected $_viewScriptPath;
	protected $_viewPhpPath;
    
    public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
    {
        parent::__construct($request, $response, $invokeArgs );
        $this->viewSuffix = 'html';
        $this->getHelper('ViewRenderer')->setViewSuffix('html');
        $bootstrap = $this->getFrontController()->getParam('bootstrap');
        $aganConfig = $bootstrap->getOption('agan');
        $this->_templatePath = $aganConfig['template']['path'];
        $this->_viewScriptPath = $bootstrap->getOption('resources');
        $this->_viewScriptPath = $this->_viewScriptPath['view']['basePath'].'/scripts';
    }
	
    public function aganRender($action = '',$name = '',$noController = true)
    {
        $tpl = $this->_templatePath .'/'. $action . '.html';
        $tplCache = $this->_viewScriptPath .'/'. $action . '.html';
        Agan_Util::createDir($tplCache);
        
	        if( file_exists($tpl) ){
	        	try{
            	   //if( file_exists($tplCache) ) unlink($tplCache);
            	   if( copy($tpl,$tplCache) ) $this->_compileTpl($tplCache);
	               //if( rename($tpl,$tplCache) ) $this->_compileTpl($tplCache);
	               $this->_compileTpl($tplCache);
	        	}catch(Exception $e) {
		            throw new Zend_Exception("complie tpl $tpl failed!",0,$e);
		        }
	        }

        $this->render($action,$name,$noController);
        $this->_filter($action);
    }
    
    protected function _filter($action)
    {
    	$floders = explode('/',$action);
    	$floder = '/';
    	$i = 1;
    	while($i){
    		$filter = $this->_viewScriptPath .$floder.'###filter.php';
    		if( file_exists( $filter ) )  require_once($filter);
            if( $i >= count($floders) ) break;
            $floder .= $floders[$i - 1].'/';
            $i++;
    	}
    }
    
    protected function _compileTplBlock(&$dom, $blockFiles)
    {
        if( !empty($blockFiles) ){
            foreach($blockFiles as $blockFile)
            {
                $blockFileName = basename($blockFile);
                $xpath = explode('___',$blockFileName);
                $xpath = substr( $xpath[1], 0, -4 );
                $results = $dom->find($xpath);
                if( empty($results) ) continue;
                $php = file_get_contents($blockFile);
                foreach ($results as $result) {
                    $result->innertext = $php;
                }
            }
        }
    }
    
    protected function _compileTpl($tpl)
    {
        require_once('simple_html_dom.php');
        $dom = file_get_dom($tpl);
        
        //全局级别block
        $blockFiles = glob($this->_viewScriptPath.'/___*.php');
        $this->_compileTplBlock($dom, $blockFiles);
        
        //目录级别 blok
        $blockFiles = glob(dirname($tpl).'/___*.php');
        $this->_compileTplBlock($dom, $blockFiles);
        
        //单模板 blok
        $fileName = basename($tpl);
        $action = str_replace('.phtml','',$fileName);
        $blockFiles = glob(dirname($tpl).'/'.$action.'___*.php');
        $this->_compileTplBlock($dom, $blockFiles);
        
        $dom->save($tpl);
        $dom->clear();
        unset($dom);
/*
        
        //单模板 blok
        $blockFiles = glob(dirname($tpl).'/'.$action.'___*.php');
        if( !empty($blockFiles) ){
        	require_once('simple_html_dom.php');
        	$dom = file_get_dom($tpl);
	    	foreach($blockFiles as $blockFile)
	    	{
	    		$blockFileName = basename($blockFile);
	    		$xpath = substr($blockFileName, strlen($fileName) - 3, strlen($blockFileName) - 4 - (strlen($fileName) - 3) );
	    		$results = $dom->find($xpath);
	    		if( empty($results) ) continue;
	    		$php = file_get_contents($blockFile);
	      		foreach ($results as $result) {
	    			$result->innertext = $php;
				}
	    	}
	    	$dom->save($tpl);
	    	$dom->clear();
	    	unset($dom);
    	}
 */   	
        return true;
    }
}