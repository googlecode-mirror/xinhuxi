<?php

class XHX_Com_ModelManager {

	public static function getModel( $modelId, Zend_Controller_Action $action )
	{
		return new XHX_Com_Model( self::getModelConfig($modelId), $action );
	}
	
	public static function getModelConfig( $modelId )
	{
	   return array(
	               'key' => 'test',
	               'list' => array('id','listorder','title','url','manager'),
	               'fieldList' => array(
	                   'id' => array(
                               'enable' => true,
                               'class' => 'XHX_Com_Fields_Data',
                               'config' => array(
                                               //'list' => array('listorder','id','title','url')
                                           )
                       ),
	                   'title' => array(
                               'enable' => true,
                               'class' => 'XHX_Com_Fields_Element',
                               'config' => array(
                                               'type' => 'Text',
                                               'attrs' => array(
                                                   'label' => 'Title',
	                                               'size' => 40,
                                                   'description' => '字段介绍说明',
                                                   'value' => '',
	                                               'required' => true,
                                               ),
                                               'validators' => array(
                                                                   array(
                                                                       'validator' => 'stringLength',
                                                                       'options' => array(1, 20)
                                                                   ),
                                                             ),
                                               'filters' => array(),
                                               'decorators' => array(),
                                           )
                       ),
                       'url' => array(
                               'enable' => true,
                               'class' => 'XHX_Com_Fields_Element',
                               'config' => array(
                                               'type' => 'Text',
                                               'attrs' => array(
                                                   'label' => 'Url',
                                                   'size' => 40,
                                                   'description' => '字段介绍说明',
                                                   'value' => '',
                                                   'required' => true,
                                               ),
                                               'validators' => array(
                                                                   array(
                                                                       'validator' => 'stringLength',
                                                                       'options' => array(1, 100)
                                                                   )
                                                             ),
                                               'filters' => array(),
                                               'decorators' => array(),
                                           )
                       ),
                       'listorder' => array(
                               'enable' => true,
                               'class' => 'XHX_Com_Fields_Element',
                               'config' => array(
                                               'type' => 'Text',
                                               'attrs' => array(
                                                   'label' => '排序',
                                                   'size' => 2,
                                                   'description' => '字段介绍说明',
                                                   'value' => 0,
                                                   'required' => true,
                                               ),
                                               'validators' => array(
                                                                   array('validator' => 'Int'),
                                                             ),
                                               'filters' => array(),
                                               'decorators' => array(),
                                           )
                       ),
                       'template' => array(
                               'enable' => false,
                               'class' => 'Agan_Com_Fields_Template',
                               'config' => array()
                       ),
                       'form' => array(
                               'enable' => true,
                               'class' => 'XHX_Com_Fields_Form',
                               'config' => array(),
                       ),
                       'grid' => array(
                               'enable' => true,
                               'class' => 'XHX_Com_Fields_Grid',
                               'config' => array(
                                                'fieldInfos' => array(
			                                            array('field'=>'id','title'=>'ID'),
			                                            array('field'=>'title'),
			                                            array('field'=>'url'),
			                                            array('field'=>'listorder'),
			                                     )
                                            ),
                       ),
	               )
	          );	
	}
}

?>