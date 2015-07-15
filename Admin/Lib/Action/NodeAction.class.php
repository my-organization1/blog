<?php

/**
 * 节点Action
 * @package Action
 * @author guolei <2387813033@qq.com>
 * @copyright 2015 blog
 */
class NodeAction extends BaseAction
{
    /**
     * 删除节点
     *
     * 如果有子节点，则不允许删除
     * 删除时会同时删除group_node_map表中的权限对应记录
     */
    public function del()
    {
        $id = I('id');

        $model = D('Node');

        $child_list = $model->_list($map,'id');

        if (!empty($child_list)) {
            $this->error('此节点还有子节点存在,请先删除所有子节点后再删除');
        }

        $map['id'] = $id;

        $this->startTrans();

        //删除对应的节点关系表
        $del_node_map_result = $this->delNodeMap($info['id']);
        //删除此节点
        $del_result = D('Node')->where($map)->delete();

        if ($del_result !== false && $del_node_map_result !== false) {
            $this->commit();
            $this->success('删除成功',U('Node/index'));
        } else {
            $this->rollback();
            $this->error('删除失败');
        }
    }

    /**
     * 根据节点id删除group_node_map表的所有数据
     * @param  int $node_id 节点id
     * @return bool         返回操作结果
     */
    private function delNodeMap($node_id)
    {
        $model = D('GroupNodeMap');

        $map['node_id'] = $node_id;

        $del_result = $model->where($map)->delete();

        return $del_result;
    }
}