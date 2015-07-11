<?php
/**
 * 用户组Model
 *
 * @package Model
 * @author guolei <2387813033@qq.com>
 * @copyright 2015 blog
 *
 */

class GroupModel extends BaseModel
{
    protected $tableName = 'group';

    /**
     * 根据id获取一个组的信息
     *
     * @method get
     * @param  int $group_id 组id
     * @return array         组信息
     */
    public function get($group_id)
    {
        $map['id'] = $group_id;

        $field = 'id,name,remark,create_time';

        $info = $this->_get($map, $field);

        return $info;
    }

}
