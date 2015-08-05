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
    /**
     * 新增管理员获取所有组列表供选择
     */
    public function _before_add()
    {
        $field = 'id,name';
        $group_list = D('Group')->_list();
        $this->assign('group_list', $group_list);
    }

    /**
     * 编辑管理员获取组列表
     */
    public function _before_edit()
    {
        $this->_before_add();
    }

    /**
     * 不能禁用超级管理员
     */
    public function _before_isEnable()
    {
        $id = intval(I('get.id'));

        if ($id === 1) {
            $this->error('不可禁用默认用户');
        }
    }

    /**
     * 防止删除超级管理员
     */
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

        if (!$model->create(I('post.'), 1)) {
            $this->error($model->getError());
        }

        $salt = uniqid();
        $password = I('post.password');

        $model->salt = $salt;
        $model->password = md5(md5($password) . $salt);

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
        $id = I('post.id');

        if (empty($password)) {
            //密码为空则不修改密码
            unset($model->password);
        } else {
            $salt = uniqid();
            $model->salt = $salt;
            $model->password = md5(md5($password) . $salt);
        }

        $map['id'] = $id;

        $update_result = $model->where($map)->save();

        $this->_after_update($update_result);
    }
}
