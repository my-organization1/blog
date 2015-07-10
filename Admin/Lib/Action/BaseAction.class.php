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

        if(empty($uid)){    //判断登陆
            redirect(U('Login/login'));
        }
        //判断权限
    }

    /**
     * 默认首页，查询列表展示
     * @method index
     */
    public function index()
    {

    }
}
