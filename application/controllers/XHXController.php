<?php

class XHXController extends XHX_Controller_Action
{

	protected $_key = 'XHX';
    protected $_itemsInfo = array(
                       'id' => array(
                               'enable' => true,
                               'class' => 'XHX_Controller_Item_Data',
                               'config' => array(
                                               //'list' => array('listorder','id','title','url')
                                           )
                       ),
                       'title' => array(
                               'enable' => true,
                               'class' => 'XHX_Controller_Item_Element',
                               'label' => 'Title',
                               'config' => array(
                                               'type' => 'Text',
                                               'attrs' => array(
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
                               'label' => 'Url',
                               'class' => 'XHX_Controller_Item_Element',
                               'config' => array(
                                               'type' => 'Text',
                                               'attrs' => array(
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
                               'class' => 'XHX_Controller_Item_Element',
                               'label' => '排序',
                               'value' => 0,
                               'config' => array(
                                               'type' => 'Text',
                                               'attrs' => array(
                                                   'size' => 2,
                                                   'description' => '字段介绍说明',
                                                   'required' => true,
                                               ),
                                               'validators' => array(
                                                                   array('validator' => 'Int'),
                                                             ),
                                               'filters' => array(),
                                               'decorators' => array(),
                                           )
                       ),
                       
                       'form' => array(
                               'enable' => true,
                               'class' => 'XHX_Controller_Item_Form',
                               'config' => array(),
                       ),
                       'template' => array(
                               'enable' => true,
                               'class' => 'XHX_Controller_Item_Template',
                               'config' => array()
                       ),
                       'grid' => array(
                               'enable' => true,
                               'class' => 'XHX_Controller_Item_Grid',
                               'config' => array(
                                                'fieldInfos' => array(
                                                        array('field'=>'id','title'=>'ID'),
                                                        array('field'=>'title'),
                                                        array('field'=>'url'),
                                                        array('field'=>'listorder'),
                                                 ),
                                            )
                       ),
              );
}
?>