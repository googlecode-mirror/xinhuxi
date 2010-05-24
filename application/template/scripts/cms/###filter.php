<?php
$body = $this->getResponse()->getBody();

$patterns = array();
$replacements = array();

$patterns[] = '(</head>)';
$replacements[] = '<base href="http://agan/template/cms/" />
<title>'.$this->view->title.'</title>
</head>';

$body = preg_replace($patterns, $replacements, $body, 1);
$this->getResponse()->setBody($body);