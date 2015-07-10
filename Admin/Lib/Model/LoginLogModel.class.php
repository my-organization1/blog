<?php
/**
 * 后台登陆日志Model
 *
 * @package Model
 * @author guolei <2387813033@qq.com>
 * @copyright 2015 blog
 *
 */
class LoginLogModel extends BaseModel
{
    protected $tableName = 'login_log';

    /**
     * 写入登陆记录
     * @param  string $username 登陆用户名
     * @param  string $password 登陆密码
     * @return bool             是否成功
     */
    public function writeLog($username, $password = ''){
        $data['username'] = $username;
        $data['password'] = $password;
        $data['ip'] = get_client_ip();
        $data['is_success'] = empty($password)?1:0;

        $ins = $this->add($data);

        if ($ins) {
            return true;
        }
        return false;
    }
}
