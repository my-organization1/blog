<?php
/**
 * 分类Model
 *
 * @package Model
 * @author guolei <2387813033@qq.com>
 * @copyright 2015 blog
 *
 */
class CatalogModel extends BaseModel
{
    protected $tableName = 'catalog';
    protected $_validate = array(
        array('name', 'require', '请输入分类名称',),
        array('list_tpl', 'require', '请选择列表页模板'),
        array('content_tpl', 'require', '请选择内容页模板'),
        array('link', 'require', '请输入访问链接'),
    );
    protected $_auto = array(
        array('is_show', 1, 1, 'string'),
        array('create_time', 'now', 1, 'function'),
        array('modification_time', 'now', 3, 'function')
    );
}
