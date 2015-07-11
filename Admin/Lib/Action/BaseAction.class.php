<?php
/**
 * Controller基类
 *
 * @copyright 2015 blog
 * @package Controller
 * @author guolei <2387813033@qq.com>
 */

class BaseAction extends Action
{
    public function _initialize()
    {
        $uid = session('uid');

        if (empty($uid)) {    //判断登陆
            redirect(U('Login/login'));
        }
        //判断权限,uid == 1 || gid == 1为超级管理员
        if (session('uid') != 1 && session('gid') != 1) {
            $current_node = MODULE_NAME.'/'.ACTION_NAME;
            if (!in_array($current_node, session('node_list'))) {
                redirect(U('Login/login'));
            }
        }
    }

    /**
     * 默认首页，查询列表展示
     * @method index
     */
    public function index()
    {
        $this->display();
    }
}
