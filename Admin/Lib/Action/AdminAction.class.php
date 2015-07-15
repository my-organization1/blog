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
    public function _before_add()
    {
        $group_list = D('Group')->_list();
        $this->assign('group_list', $group_list);
    }

    public function _before_edit()
    {
        $this->_before_add();
    }

    public function _before_isEnable()
    {
        $id = intval(I('get.id'));

        if ($id === 1) {
            $this->error('不可禁用默认用户');
        }
    }

    public function _before_del()
    {
        $id = intval(I('get.id'));

        if ($id === 1) {
            $this->error('不可删除默认用户');
        }
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

    /**
     * 更新管理员信息
     */
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
