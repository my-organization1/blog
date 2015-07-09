<?php
/**
 * Model基类
 * @package Model
 * @author guolei <2387813033@qq.com>
 * @copyright 2015 blog
 */

class BaseModel extends Model
{
    public function _initialize()
    {

    }

    /**
     * 查询多条数据
     * @method _list
     * @param  array   $map       查询条件
     * @param  string  $field     查询字段
     * @param  string  $order     排序规则,默认主键倒序
     * @param  integer $page      分页数,默认1
     * @param  integer $page_size 分页条数,默认10
     * @return array              查询出的数据
     */
    public function _list($map = array(), $field = '', $order = '', $page = 0, $page_size = 10)
    {
        $pk = $this->pk;    //主键
        $order = empty($order)?$pk.' desc':$order;

        if ($page === 0) {
            $list = $this->where($map)->field($field)->order($order)->select();
        } else {
            $page_index = ($page - 1) * $page_size;
            $list = $this->where($map)->field($field)->order($order)->limit($page_index.','.$page_size)->select();
        }

        $list = empty($list)?array():$list;

        return $list;
    }

    /**
     * 获取单条数据
     * @method _get
     * @param  array  $map   查询条件
     * @param  string $field 查询字段
     * @param  string $order 排序规则,默认主键倒序
     * @return array         查询出的条件
     */
    public function _get($map = array(), $field = '', $order = '')
    {
        $pk = $this->pk;    //主键
        $order = empty($order)?$pk.' desc':$order;

        $find = $this->where($map)->field($field)->order($order)->find();
        $find = empty($find)?array():$find;

        return $find;
    }
}
