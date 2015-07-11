<?php
/**
 * 后台节点表
 *
 * @package Model
 * @author guolei <2387813033@qq.com>
 * @copyright 2015 blog
 *
 */

class NodeModel extends BaseModel
{
    protected $tableName = 'node';

    /**
     * 获取组拥有的权限节点
     * @method getListByGroupId
     * @param  int         $group_id 组id
     * @return array                 查询到的数据
     */
    public function getListByGroupId($group_id)
    {
        //获取拥有的节点id
        $map['group_id'] = $group_id;
        $field = 'group_id,node_id';
        $node_id_list = D('GroupNodeMap')->_list($map, $field);

        if (empty($node_id_list)) {
            return array();
        }
        //获取节点列表
        $node_map['id'] = array_column($node_id_list, 'node_id');
        $field = 'id,pid,node,name';

        $list = $this->_list($map, $field);

        return $list;
    }
}
