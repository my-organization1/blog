<?php
/**
 * 分类管理类
 * @package Action
 * @author guolei <2387813033@qq.com>
 * @copyright 2015 blog
 */
class CatalogAction extends BaseAction
{
    public function index()
    {
        $model = D('Catalog');

        $field = 'id,pid,name,link,is_show';
        $order = 'sort desc';
        $list = $model->_list(array(), $field, $order);
        $list = ArrayHelper::tree($list);

        $this->assign('list', $list);
        $this->display();
    }
}