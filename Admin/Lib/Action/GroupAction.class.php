<?php
/**
 * 管理组Action
 *
 * @package Action
 * @author guolei <2387813033@qq.com>
 * @copyright 2015 blog
 */
class GroupAction extends BaseAction
{
    /**
     * 组权限管理
     */
    function permision()
    {
        $this->display();
    }

    /**
     * 删除会员组
     *
     * 删除之前会判断是否有会员属于这个组
     */
    public function del()
    {
        $id = I('id');

        $AdminModel = D('Admin');

        $admin_map['group_id'] = $id;

        $admin_list = $AdminModel->_list($admin_map,'username');

        if (!empty($admin_list)) {
            $admin_list = implode(',', $admin_list);
            $this->error('还有会员属于这个组，请更改这些管理员的组以后再进行删除:'.$admin_list);
        }
        $model = D('Group');

        $map['id'] = $id;

        $del_result = $model->where($map)->delete();

        if ($del_result) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }

    /**
     * 添加节点到GroupNodeMap表
     */
    public function addPermision()
    {
        $group_id = I('post.group_id');
        $node_id = I('post.node_id');

        if (empty($group_id)) {
            $this->error('请选择有效的组');
        }
        if (empty($node_id)) {
            $this->error('节点ID错误');
        }

        $model = D('GroupNodeMap');
        $data['group_id'] = $group_id;
        $data['node_id'] = $node_id;

        $ins = $model->add($data);

        if ($ins) {
            $this->success('success');
        } else {
            $this->error('error');
        }
    }

    /**
     * 从GroupNodeMap表删除节点对应关系
     *
     */
    public function delPermision()
    {
        $group_id = I('post.group_id');
        $node_id = I('post.node_id');

        if (empty($group_id)) {
            $this->error('请选择有效的组');
        }
        if (empty($node_id)) {
            $this->error('节点ID错误');
        }

        $model = D('GroupNodeMap');
        $map['group_id'] = $group_id;
        $map['node_id'] = $node_id;

        $del_result = $model->where($map)->delete();

        if ($del_result) {
            $this->success('success');
        } else {
            $this->error('error');
        }
    }
}
