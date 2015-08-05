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

    protected $_validate = array(
        array('node', 'require', '请输入节点地址'),
        array('name', 'require', '请输入节点名称'),
    );

    protected $_auto = array(
        array('create_time', 'now', 1, 'function'),
        array('modification_time', 'now', 3, 'function'),
    );

    protected $_select_field = 'id,pid,node,name,is_show';

    /**
     * 获取组拥有的权限节点
     * @method getListByGroupId
     * @param  int         $group_id 组id
     * @return array                 查询到的数据
     */
    public function getListByGroupId($group_id)
    {
        //超级管理员组获取所有节点
        if (intval($group_id) === 1) {
            $node_map = array();
        } else {
            //获取拥有的节点id
            $map['group_id'] = $group_id;
            $field = 'group_id,node_id';
            $node_id_list = D('GroupNodeMap')->_list($map, $field);

            if (empty($node_id_list)) {
                return array();
            }
            //获取节点列表
            $node_map['id'] = array_column($node_id_list, 'node_id');
        }

        $list = $this->_list($node_map, $this->_select_field, 'id asc');

        return $list;
    }

    /**
     * 查询节点记录并且格式化为树形接口
     * @return array 查询出的数据
     */
    public function lists()
    {
        $list = $this->_list(array(), $this->_select_field, 'id asc');
        $list = ArrayHelper::tree($list);
        $list = array_column($list, null, 'id');

        return $list;
    }
}
