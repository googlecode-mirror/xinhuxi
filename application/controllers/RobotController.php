<?php
class RobotController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $client = new Zend_Http_Client();
        $client->setUri('http://www.renren.com/PLogin.do');
        $client->setParameterGet(array(
            'email'  => 'ganmu1986@hotmail.com',
            'password' => '13311221',
            'domain'     => 'renren.com',
        ));
        $response = $client->request('POST');
        echo $response->getBody();
        //Zend_Debug::dump($client->getCookieJar());
        exit();        
    }
}
?>