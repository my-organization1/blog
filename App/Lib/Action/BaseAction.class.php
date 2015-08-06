<?php
/**
 * 前台基类
 * @package Action
 * @author guolei <2387813033@qq.com>
 * @copyright 2015 blog
 */
class BaseAction extends Action
{
    public function _initialize()
    {
        //获取导航
        $menu_list = D('Catalog')->menu();

        $this->assign('menu_list', $menu_list);
    }
}
