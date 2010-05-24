<?php
class Agan_Com_Fields_Manager extends Agan_Com_Field
{
	public function outputAction( $params )
	{
		return '<a href="/admin/index/add/id/'.$params['id'].'">修改</a> | <a href="/admin/index/delete/id/'.$params['id'].'" onClick="return window.confirm(\'确定删除吗？\')">删除</a>';
	}
	
    public function getFields(){
        return array();
    }
}
?>