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
    /**
     * 登录页面
     * @method login
     */
    public function login()
    {
        $uid = session('uid');
        if (!empty($uid)) {
            //登录状态跳转到指定地址
            $redirect_url = I('redirect_url', '');
            $redirect_url = empty($redirect_url)?U('Index/index'):urldecode($redirect_url);
            redirect($redirect_url);
            exit();
        }

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
        $redirect_url = I('post.redirect_url', '');

        if (empty($username)) {
            $this->error('请输入用户名');
        }

        if (empty($password)) {
            $this->error('请输入密码');
        }

        $model = D('Admin');

        $admin_info = $model->login($username, $password);

        if ($admin_info === false) {      //登陆失败
            $error = $model->getError();
            switch ($error) {
                case 9001:
                    $error_msg = '会员不存在或已被禁用';
                    break;
                case 9002:
                    $error_msg = '请输入正确的密码';
                    break;
                default:
                    $error_msg = '登陆失败';
            }
            D('LoginLog')->writeLog($username, $password);
            $this->error($error_msg);
        }

        //写入session
        session('uid', $admin_info['id']);
        session('gid', $admin_info['group_id']);
        session('nickname', $admin_info['nickname']);

        //获取权限并且写入session
        $node_list = D('Node')->getListByGroupId($admin_info['group_id']);

        session('node_list', $node_list);

        //写入log表
        D('LoginLog')->writeLog($username);

        $redirect_url = empty($redirect_url)?U('Index/index'):urldecode($redirect_url);

        $this->success('登录成功', $redirect_url);
    }

    /**
     * 退出
     * @method logout
     */
    public function logout()
    {
        session(null);
        redirect(U('Login/login'));
    }
}
