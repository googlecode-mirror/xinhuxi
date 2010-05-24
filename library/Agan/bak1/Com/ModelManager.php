<?php

class Agan_Com_ModelManager {

	public static function getModel( $modelId, Zend_Controller_Action $action )
	{
		return new Agan_Com_Model( self::getModelConfig($modelId), $action );
	}
	
	public static function getModelConfig( $modelId )
	{
	   return array(
	               'key' => 'test',
	               'list' => array('id','listorder','title','url','manager'),
	               'fieldList' => array(
	                   'listorder' => array(
                               'class' => 'Agan_Com_Fields_ListOrder',
                               'enable' => true,
                               'config' => array(
                                               'label' => '排序',
                                               'description' => '介绍说明',
                                               'title' => '错误信息',
	                                           'size' => 5,
	                                           'value' => 0,
	                                           'validate' => array(
                                                                   'required' => 'true',
	                                                               'number' => array( 'decimaldigits' => 0) //小数位数 
                                                             ),
                                           ),
	                   ),
	                   'title' => array(
	                           'enable' => true,
	                           'class' => 'Agan_Com_Fields_Text',
	                           'config' => array(
	                                           'label' => '标题',
	                                           'description' => '字段介绍说明',
	                                           'size' => '30',
                                               'value' => '',
	                                           'title' => '稀里哗啦',
	                                           'isPassword' => false,
	                                           'validate' => array(
	                                                               'required' => 'true',
	                                                         ),
	                                       )
	                   ),
	                   'url' => array(
                               'enable' => true,
                               'class' => 'Agan_Com_Fields_Text',
                               'config' => array(
                                               'label' => 'url',
                                               'description' => '字段介绍说明',
                                               'size' => '30',
                                               'value' => '',
                                               'title' => '稀里哗啦',
                                               'isPassword' => false,
                                               'validate' => array(
                                                                   'required' => 'true',
                                                             ),
                                           )
                       ),
	                   'template' => array(
	                           'enable' => true,
                               'class' => 'Agan_Com_Fields_Template',
                               'config' => array()
                       ),
                       'manager' => array(
                               'enable' => true,
                               'class' => 'Agan_Com_Fields_Manager',
                               'config' => array(
                                               'label' => '管理操作'
                                           )
                       ),
                       'multiManager' => array(
                               'enable' => true,
                               'class' => 'Agan_Com_Fields_MultiManager',
                               'config' => array(
                                               'label' => '选择'
                                           )
                       ),
                       'id' => array(
                               'enable' => true,
                               'class' => 'Agan_Com_Fields_Data',
                               'config' => array(
                                               'label' => 'ID',
                                               'tree' => true,
                                               //'list' => array('listorder','id','title','url')
                                           )
                       ),
	               )
	          );	
	}
}

?>