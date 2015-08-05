<?php
/**
 * 分类Model
 *
 * @package Model
 * @author guolei <2387813033@qq.com>
 * @copyright 2015 blog
 *
 */
class CatalogModel extends BaseModel
{
    protected $tableName = 'catalog';
    protected $_validate = array(
        array('name', 'require', '请输入分类名称'),
        array('list_tpl', 'require', '请选择列表页模板'),
        array('content_tpl', 'require', '请选择内容页模板'),
    );
    protected $_auto = array(
        array('is_show', 1, 1, 'string'),
        array('create_time', 'now', 1, 'function'),
        array('modification_time', 'now', 3, 'function'),
    );

    protected $_select_field = 'id,pid,name,is_show,list_tpl,content_tpl,router_id';

    /**
     * 查询分类列表
     * @param  array   $map       查询条件
     * @param  string  $order     排序
     * @param  integer $page      页数，默认1
     * @param  integer $page_size 每页条数，默认10
     * @return array              查询出的数据
     */
    public function lists($map = array(), $order = '', $page = 1, $page_size = 10)
    {
        $list = $model->_list($map, $this->_select_field, $order);

        if (empty($list)) {
            return false;
        }

        //查询路由表记录
        $router_id = array_column($list, 'router_id');

        $router_map['id'] = array('in', $router_id);
        $router_list = D('Router')->lists($router_map);
        $router_list = array_column($router_list, null, 'router_id');

        //合并数据
        foreach ($list as $_k => $_v) {
            $list[$_k] = array_merge($_v, $router_list[$_v['router_id']]);
        }
    }

    /**
     * 根据id获取单条分类信息
     * @param  int $id     分类id
     * @return array
     */
    public function get($id)
    {
        $map['id'] = $id;

        $info = $model->_get($map, $this->_select_field);
        $router_info = D('Router')->get($info['router_id']);

        if (empty($router_info)) {
            return array();
        }

        $info = array_merge($info, $router_info);

        return $info;
    }
}
