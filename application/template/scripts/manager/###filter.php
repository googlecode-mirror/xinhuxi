<?php
$body = $this->getResponse()->getBody();

$patterns = array();
$replacements = array();

$patterns[] = '(<head>)';
$replacements[] = '<head>
<base href="http://agan/template/manager/" />
<title>'.$this->view->title.'</title>';

$body = preg_replace($patterns, $replacements, $body, 1);
$this->getResponse()->setBody($body);