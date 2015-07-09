<?php
/**
 * 后台登录类 不继承Base基类,单独存在
 *
 * @package Controller
 * @author guolei <238713033@qq.com>
 * @copyright 2015 blog
 */
class LoginAction extends Action
{
    //不用检测登录状态的方法
    private $not_check_login_func = array('logout');
    /**
     * 初始化,判断登录状态
     */
    public function _initialize()
    {
        if (!in_array(ACTION_NAME, $this->not_check_login_func)) {
            $uid = session('uid');
            if (empty($uid)) {
                redirect(U('login'));
                exit();
            }

            //登录状态跳转到指定地址
            $redirect_url = I('redirect_url', '');
            $redirect_url = empty($redirect_url)?U('Index/index'):urldecode($redirect_url);
            redirect($redirect_url);
        }
    }

    /**
     * 登录页面
     * @method login
     */
    public function login()
    {
        $this->display();
    }

    /**
     * 检测登录状态
     * @method checkLogin
     */
    public function checkLogin()
    {
        if (!IS_POST) {
            exit();
        }

        $username = I('post.username');
        $password = I('post.password');
    }

    /**
     * 退出
     * @method logout
     */
    public function logout()
    {
        session(null);
    }
}
