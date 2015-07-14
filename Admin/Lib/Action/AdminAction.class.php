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


    /**
     * 新增管理员
     * @method save
     */
    public function save()
    {
        $model = D('Admin');

        $data = I('post.');

        if (!$model->create()) {
            $this->error($model->getError());
        }

        $salt = uniqid();
        $password = I('post.password');

        $model->salt = $salt;
        $model->password = md5(md5($password).$salt);

        $ins = $model->add();

        $this->_after_save($ins);
    }

    public function update()
    {
        $model = D(MODULE_NAME);

        if (!$model->create(I('post.'), 2)) {
            $this->error($model->getError());
        }
        $password = I('post.password');

        if (empty($password)) {     //密码为空则不修改密码
            unset($model->password);
        } else {
            $salt = uniqid();
            $model->salt = $salt;
            $model->password = md5(md5($password).$salt);
        }

        $pk = $model->getPk();
        $map[$pk] = I('post.'.$pk);

        $update_result = $model->where($map)->save();

        $this->_after_update($update_result);
    }
}
