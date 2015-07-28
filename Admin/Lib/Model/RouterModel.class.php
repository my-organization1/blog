<?php
/**
 * 路由Model
 *
 * @package Model
 * @author guolei <2387813033@qq.com>
 * @copyright 2015 blog
 */
class RouterModel extends BaseModel
{
    protected $tableName = 'router';

    public function save($id, $rule, $link)
    {
        $rule = addcslashes($rule, '/');
        $rule = '/^'.$rule.'$/';

        if ($this->checkRule($rule)) {
            return false;
        }

        $data['id'] = $id;
        $data['rule'] = $rule;
        $data['link'] = $link;
        $data['create_time'] = now();
        $data['modification_time'] = now();

        $ins = $this->add($data);

        return $ins;
    }

    public function update($id, $rule, $link)
    {
        $map['id'] = $id;

        $rule = addcslashes($rule, '/');
        $rule = '/^'.$rule.'$/';

        if ($this->checkRule($rule, $id)) {
            return false;
        }

        $data['rule'] = $rule;
        $data['link'] = $link;
        $data['modification_time'] = now();

        $save = $this->where($map)->save($data);

        return $ins;
    }

    public function lists($map, $field)
    {
        $router_list = $this->_list($map, $field);

        if (empty($router_list)) {
            return array();
        }
        foreach ($router_list as $_k => $_v) {
            $router_list[$_k]['rule'] = RestoreRule($_v['rule']);
        }

        return $router_list;
    }


    /**
     * 获取即将插入的主键id
     * @return int id
     */
    public function getInsId()
    {
        $sql = 'SHOW TABLE STATUS LIKE \''.C('DB_PREFIX').'router\'';
        $info = $this->query($sql);
        return $info[0]['Auto_increment'] ? $info[0]['Auto_increment'] : 1;
    }

    /**
     * 监测路由是否已存在
     * @param  string $rule 路由
     * @param  int    $id   查询除此id以外的数据
     * @return bool       存在返回true，不存在返回false
     */
    private function checkRule($rule, $id='')
    {
        $RootDirList = scandir('.');
        $RootDirList = array_map(function($v){
            return strtolower($v);
        }, $RootDirList);       //将数组里的值全部转换为小写

        if (in_array(strtolower($link), $RootDirList)) {
            return false;
        }

        $map['rule'] = $rule;
        if (!empty($id)) {
            $map['id'] = array('neq', $id);
        }

        $info = $this->where($map)->getField('id');

        if ($info) {
            return true;
        } else {
            return false;
        }
    }
}
