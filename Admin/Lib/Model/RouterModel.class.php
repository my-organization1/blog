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
    protected $_select_field = 'id as router_id,rule,link';

    /**
     * 新增分类
     * @param int    $id      router_id
     * @param string $rule    访问链接
     * @param string $link    指向链接
     * @return  bool          成功返回true
     */
    public function add($id, $rule, $link)
    {
        $rule = addcslashes($rule, '/');
        $rule = '/^' . $rule . '$/';

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

    /**
     * 更改路由信息
     * @param  int $id   router_id
     * @param  string $rule 访问链接
     * @param  string $link 指向链接
     * @return bool         成功返回true
     */
    public function update($id, $rule, $link)
    {
        $map['id'] = $id;

        $rule = addcslashes($rule, '/');
        $rule = '/^' . $rule . '$/';

        if ($this->checkRule($rule, $id)) {
            return false;
        }

        $data['rule'] = $rule;
        $data['link'] = $link;
        $data['modification_time'] = now();

        $save_result = $this->where($map)->save($data);
        return $save_result;
    }

    /**
     * 查询路由列表
     * @param  array $map   查询条件
     * @return array        查询出的数据
     */
    public function lists($map)
    {
        $router_list = $this->_list($map, $this->_select_field);

        if (empty($router_list)) {
            return array();
        }

        foreach ($router_list as $_k => $_v) {
            $router_list[$_k]['rule'] = RestoreRule($_v['rule']);
        }

        return $router_list;
    }

    /**
     * 根据router_id查询单条记录
     * @param  int $id    主键id
     * @return array        查询出的数据
     */
    public function get($id, $field = '')
    {
        $map['id'] = $id;

        $info = $this->_get($map, $this->_select_field);

        if (empty($info)) {
            return array();
        }

        $info['rule'] = RestoreRule($info['rule']);

        return $info;
    }

    /**
     * 获取即将插入的主键id
     * @return int
     */
    public function getInsId()
    {
        $sql = 'SHOW TABLE STATUS LIKE \'' . C('DB_PREFIX') . 'router\'';
        $info = $this->query($sql);
        return $info[0]['Auto_increment'] ? $info[0]['Auto_increment'] : 1;
    }

    /**
     * 监测路由是否已存在
     * @param  string $rule 路由
     * @param  int    $id   查询除此id以外的数据
     * @return bool       存在返回true，不存在返回false
     */
    private function checkRule($rule, $id = '')
    {
        $RootDirList = scandir('.');
        $RootDirList = array_map(function ($v) {
            return strtolower($v);
        }, $RootDirList); //将数组里的值全部转换为小写

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
