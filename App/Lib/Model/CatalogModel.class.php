<?php

class CatalogModel extends BaseModel
{
    protected $tableName = 'catalog';

    /**
     * 根据id获取分类详情
     * @param  int $catalog_id 分类主键id
     * @return array           分类的信息
     */
    public function info($catalog_id)
    {
        $map['id'] = $catalog_id;
        $field = 'id,pid,router_id,name,sort,title,keywords,description,is_show,list_tpl,content_tpl';

        $info = $this->_get($map, $field);
        if (empty($info)) {
            return array();
        }

        return $info;
    }

    /**
     * 获取导航
     * @method menu
     * @return array 导航数据
     */
    public function menu()
    {
        $map['is_show'] = 1;
        $field = 'id,pid,router_id,name,sort,title,keywords,description,is_show,list_tpl,content_tpl';
        $list = $this->_list($map, $field, 'sort desc');

        $router_id = array_column($list, 'router_id');

        //查询路由表
        $router_map['id'] = array('in', $router_id);
        $router_field = 'id as router_id,rule,link';

        $router_list = D('Router')->_list($router_map, $router_field);
        foreach ($router_list as $_k => $_v) {
            $router_list[$_k]['url'] = RestoreRule($_v['rule']);
        }
        $router_list = array_column($router_list, null, 'router_id');
        //合并数据
        foreach ($list as $_k => $_v) {
            $list[$_k] = array_merge($_v, $router_list[$_v['router_id']]);
        }

        return $list;
    }
}
