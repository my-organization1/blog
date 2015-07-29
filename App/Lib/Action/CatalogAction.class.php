<?php
/**
 * 分类Action
 * @package Action
 * @author guolei <2387813033@qq.com>
 * @copyright 2015 blog
 */
class CatalogAction extends BaseAction
{
    public function index()
    {
        $id = I('get.id');
        $info = D('Catalog')->info($id);

        $this->assign('catalog_info', $info);
        $this->display(C('APP_DEFAULT_THEME').'/'.$info['list_tpl']);
    }
}