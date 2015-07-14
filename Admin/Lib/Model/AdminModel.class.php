<?php
/**
 * 管理员Model
 *
 * @package Model
 * @author guolei <2387813033@qq.com>
 * @copyright 2015 blog
 *
 */

class AdminModel extends BaseModel
{
    protected $tableName = 'admin';

    protected $_validate = array(
        array('username', 'require', '请输入用户名'),
        array('password', 'require', '请输入密码')
    );

    protected $_auto = array(
        array('is_enable', 'auto_post', 1, 'function','1'),
        array('create_time', 'now', 1, 'function'),
        array('modification_time', 'now', 3, 'function')
    );

    protected function auto_post($arg)
    {
        $val = I('post.'.$arg[0]);
        return isset($val) ? $val : $arg[1];
    }

    /**
     * 登陆方法
     * @param  string $username 用户名
     * @param  string $password 密码
     * @return array|bool           成功返回用户信息,失败返回false
     */
    public function login($username, $password)
    {
        //查询用户信息
        $map['username'] = $username;
        $map['is_enable'] = 1;

        $field = 'id,group_id,username,nickname,password,salt,name,sex,age,mobile,email,is_enable,create_time';

        $info = $this->_get($map, $field);

        if (empty($info)) {   //会员不存在或被禁用
            $this->error = 9001;
            return false;
        }

        //对比密码
        if ($info['password'] != md5(md5($password).$info['salt'])) {
            $this->error = 9002;        //密码错误
            return false;
        }

        return $info;
    }
}
