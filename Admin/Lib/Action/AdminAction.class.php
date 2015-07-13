<?php
/**
 * 后台管理员Action
 *
 * @package Action
 * @author guolei <2387813033@qq.com>
 * @copyright 2015 blog
 *
 */
class AdminAction extends BaseAction
{
    protected function _before_add()
    {
        $group_list = D('Group')->_list();
    }

    protected function _before_edit()
    {
        $this->_before_add();
    }
}
