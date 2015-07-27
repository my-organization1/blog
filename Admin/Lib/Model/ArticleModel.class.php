<?php
/**
 * 文章管理Model
 *
 * @package Model
 * @author guolei <2387813033@qq.com>
 * @copyright 2015 blog
 */
class ArticleModel extends BaseModel
{
    protected $tableName = 'article';

    protected $_validate = array(
        array('title', 'require', '请输入文章标题'),
        array('write', 'require', '请输入作者'),
        array('catalog_id', 'require', '请选择分类'),
        array('source', 'require', '请输入来源'),
        array('content', 'require', '请输入文章内容'),
    );

    protected $_auto = array(
        array('status', 1, 1, 'string'),
        array('admin_id', 'auto_admin_id', 3, 'callback'),
        array('create_time', 'now', 1, 'function'),
        array('modification_time', 'now', 3, 'function')
    );

    protected function auto_admin_id()
    {
        return session('uid');
    }

    public function checkLink($link)
    {
        if (empty($link)) {
            return true;
        }

        $RootDirList = scandir('.');
        $RootDirList = array_map(function($v){
            return strtolower($v);
        }, $RootDirList);       //将数组里的值全部转换为小写

        if (in_array(strtolower($link), $RootDirList)) {
            return false;
        }
        return true;
    }
}